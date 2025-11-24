<?php

namespace App\Http\Controllers\API\Finance;

use App\Http\Controllers\Controller;
use App\Models\Finance;
use App\Models\User;
use App\Traits\ApiResponse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\URL;

class FinanceApiController extends Controller
{
    use ApiResponse;

    public function index()
    {
        $user = auth()->user();
        $currentYear = now()->year;
        $currentMonth = now()->month;

        $cacheKey = "finances_{$user->id}_{$currentYear}";

        $finances = Cache::remember($cacheKey, now()->addMinutes(1), function () use ($user, $currentYear, $currentMonth) {
            return Finance::with(['users' => fn ($q) => $q->where('user_id', $user->id)])
                ->where('year', $currentYear)
                ->get()
                ->map(fn ($f) => [
                    'id' => $f->id,
                    'year' => $f->year,
                    'month' => Carbon::createFromDate(null, (int) $f->month, 1)->format('F'), // month name here
                    'is_submitted' => (bool) ($f->users->first()?->pivot->is_submitted ?? false),
                    'allowance' => $f->users->first()?->pivot->allowance ?? 0,
                    'expenses' => $f->users->first()?->pivot->expenses ?? 0,
                    'save_amount' => $f->users->first()?->pivot->save_amount ?? 0,
                    'content' => $f->users->first()?->pivot->content ?? '',
                    'is_current' => $f->month == $currentMonth,
                ]);
        });

        $total = $finances->count();
        $completed = $finances->where('is_submitted', true)->count();

        $apiResponse = [
            'finances' => $finances,
            'progress' => [
                'completed' => $completed,
                'total' => $total,
                'percentage' => $total ? round($completed / $total * 100) : 0,
            ],
        ];

        return $this->sendResponse($apiResponse, 'Finances retrieved successfully.');

    }

    // User submits or updates monthly finance data
    public function submit(Request $request)
    {
        $request->validate([
            'finance_id' => 'required|exists:finances,id',
            'allowance' => 'required|numeric|min:0',
            'expenses' => 'required|numeric|min:0',
            'content' => 'nullable|string',
        ]);

        $user = auth()->user();

        //  Calculate save_amount automatically
        $allowance = $request->allowance;
        $expenses = $request->expenses;
        $saveAmount = max($allowance - $expenses, 0); // Prevent negative savings

        // 🔄 Update or insert into pivot table
        $user->finances()->syncWithoutDetaching([
            $request->finance_id => [
                'is_submitted' => true,
                'allowance' => $allowance,
                'expenses' => $expenses,
                'save_amount' => $saveAmount,
                'content' => $request->content ?? '',
            ],
        ]);

        //  Clear cache so next index() refreshes
        Cache::forget("finances_{$user->id}_".now()->year);

        return $this->sendResponse([], 'Finance data submitted successfully.');
    }

    // share links
    public function generate(Request $request)
    {
        $request->validate([
            'finance_id' => 'required|exists:finances,id',
        ]);

        $user = auth()->user();

        $link = URL::temporarySignedRoute(
            'finance.share.view', // must match the named route
            now()->addDay(),      // link valid for 24 hours
            [
                'user_id' => $user->id,
                'finance_id' => $request->finance_id,
            ]
        );

        return $this->sendResponse([
            'share_link' => $link,
        ], 'Share link generated successfully.');
    }

    /**
     * Public view of finance record via signed URL
     */
    public function view($user_id, $finance_id)
    {
        $user = User::findOrFail($user_id);

        $finance = Finance::with(['users' => fn ($q) => $q->where('user_id', $user_id)])
            ->where('id', $finance_id)
            ->firstOrFail();

        $pivot = $finance->users->first()?->pivot;

        return response()->json([
            'user' => $user->only('id', 'name', 'email'),
            'finance' => [
                'year' => $finance->year,
                'month' => $finance->month,
                'allowance' => $pivot->allowance ?? 0,
                'expenses' => $pivot->expenses ?? 0,
                'save_amount' => $pivot->save_amount ?? 0,
                'content' => $pivot->content ?? '',
                'is_submitted' => (bool) ($pivot->is_submitted ?? false),
            ],
        ]);
    }
}
