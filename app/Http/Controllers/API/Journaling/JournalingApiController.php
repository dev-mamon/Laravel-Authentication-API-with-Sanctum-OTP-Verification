<?php

namespace App\Http\Controllers\API\Journaling;

use App\Http\Controllers\Controller;
use App\Models\Journaling;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;

class JournalingApiController extends Controller
{
    use ApiResponse;

    /**
     * Get current year journals for auth user
     */
    public function index()
    {
        $user = auth()->user();
        $currentYear = now()->year;
        $currentWeek = now()->weekOfYear;

        $journals = Cache::remember("journals_{$user->id}_{$currentYear}", now()->addMinutes(10), function () use ($user, $currentYear, $currentWeek) {
            return Journaling::with(['users' => fn ($q) => $q->where('user_id', $user->id)])
                ->where('year', $currentYear)
                ->get()
                ->map(fn ($journal) => [
                    'id' => $journal->id,
                    'year' => $journal->year,
                    'week' => $journal->week,
                    'is_submitted' => (bool) ($journal->users->first()?->pivot->is_submitted ?? false),
                    'content' => $journal->users->first()?->pivot->content ?? '',
                    'is_unlock' => $journal->week == $currentWeek,
                ]);
        });

        $totalWeeks = $journals->count();
        $completedWeeks = $journals->where('is_submitted', true)->count();

        return $this->sendResponse([
            'journals' => $journals,
            'progress' => [
                'completed' => $completedWeeks,
                'total' => $totalWeeks,
                'percentage' => $totalWeeks ? round($completedWeeks / $totalWeeks * 100) : 0,
            ],
        ], 'Journals retrieved successfully.');
    }

    /**
     * Submit current week journal for auth user
     */
    public function submit(Request $request)
    {
        $user = auth()->user();
        $year = now()->year;
        $currentWeek = now()->weekOfYear;

        // Validate content
        $validator = Validator::make($request->all(), [
            'content' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation error', $validator->errors(), 422);
        }

        // Get current week journal
        $journal = Journaling::where('year', $year)
            ->where('week', $currentWeek)
            ->first();

        if (! $journal) {
            return $this->sendError('This week\'s journal is not available.', [], 404);
        }

        // Attach or update pivot for user
        $journal->users()->syncWithoutDetaching([
            $user->id => [
                'is_submitted' => true,
                'content' => $request->input('content'),
            ],
        ]);

        // Reload pivot fresh
        $journal->load(['users' => function ($q) use ($user) {
            $q->where('user_id', $user->id);
        }]);

        $pivot = $journal->users->first()?->pivot;

        // Clear cache for this user/year
        $cacheKey = "journals_{$user->id}_{$year}";
        Cache::forget($cacheKey);

        return $this->sendResponse([
            'id' => $journal->id,
            'year' => $journal->year,
            'week' => $journal->week,
            'content' => $pivot?->content ?? '',
            'is_submitted' => $pivot ? (bool) $pivot->is_submitted : true, // boolean true
            'is_unlock' => true,
        ], 'Journal submitted successfully.');
    }

    // share links
    public function generate(Request $request)
    {
        $request->validate([
            'journal_id' => 'required|exists:journalings,id',
        ]);

        $user = auth()->user();

        $link = URL::temporarySignedRoute(
            'journal.share.view',
            now()->addDay(),
            [
                'user_id' => $user->id,
                'journal_id' => $request->journal_id,
            ]
        );

        return $this->sendResponse([
            'share_link' => $link,
        ], 'Share link generated successfully.');
    }

    /**
     * Public view of finance record via signed URL
     */
    public function view($user_id, $journal_id)
    {
        $user = User::findOrFail($user_id);

        $journal = Journaling::with(['users' => fn ($q) => $q->where('user_id', $user_id)])
            ->where('id', $journal_id)
            ->firstOrFail();

        $pivot = $journal->users->first()?->pivot;

        return response()->json([
            'user' => $user->only('id', 'name', 'email'),
            'journal' => [
                'year' => $journal->year,
                'week' => $journal->week,
                'content' => $pivot->content ?? '',
                'is_submitted' => (bool) ($pivot->is_submitted ?? false),
            ],
        ]);
    }
}
