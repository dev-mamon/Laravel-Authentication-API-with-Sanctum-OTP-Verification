<?php

namespace App\Http\Controllers\API\CreativeDesign;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\CreativeDesign;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\URL;

class CreativeDesignApiController extends Controller
{
    use ApiResponse;

    public function index()
    {
        $cacheKey = 'creative_designs_all';

        $designs = Cache::remember($cacheKey, now()->addMinutes(10), function () {
            return CreativeDesign::with('user')->get()->map(function ($design) {
                return [
                    'id' => $design->id,
                    'user' => $design->user->name,
                    'title' => $design->image_title,
                    'size' => $design->image_size,
                    'image_url' => Helper::generateURL($design->image),
                    'created_at' => $design->created_at->toDateTimeString(),
                ];
            });
        });

        return $this->sendResponse($designs, 'Creative Designs Retrieved');
    }

    public function submit(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:50120', // max 50MB
        ]);

        $file = $request->file('image');

        // Upload the file
        $filePath = Helper::uploadFile('creative_designs', $file);

        // Auto-generate title from original filename (without extension)
        $imageTitle = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

        // Get image dimensions
        [$width, $height] = getimagesize(public_path($filePath));
        $imageSize = "{$width}x{$height}";

        // Get file size in KB
        $fileSize = round(filesize(public_path($filePath)) / 1024, 2).' KB';

        // Store in database
        $design = CreativeDesign::create([
            'user_id' => $request->user()->id,
            'image' => $filePath,
            'image_title' => $imageTitle,
            'image_size' => $fileSize,
        ]);

        // Clear the cache so the new design appears immediately
        Cache::forget('creative_designs_all');

        return $this->sendResponse([
            'id' => $design->id,
            'image_url' => Helper::generateURL($design->image),
            'image_title' => $design->image_title,
            'image_size' => $design->image_size,
        ], 'Creative Design Submitted Successfully');
    }

    // Generate shareable link
    public function generate(Request $request)
    {
        $request->validate([
            'creative_design_id' => 'required|exists:creative_designs,id',
        ]);

        $user = auth()->user();

        $link = URL::temporarySignedRoute(
            'creative.share.view',
            now()->addDay(),
            [
                'user_id' => $user->id,
                'design_id' => $request->creative_design_id,
            ]
        );

        return $this->sendResponse([
            'share_link' => $link,
        ], 'Share link generated successfully.');
    }

    // Public view of Creative Design via signed URL
    public function view($user_id, $design_id)
    {
        $user = User::findOrFail($user_id);

        $design = CreativeDesign::where('id', $design_id)
            ->where('user_id', $user_id)
            ->firstOrFail();

        // Get image URL using your existing helper
        $imageUrl = Helper::generateURL($design->image);

        // Get image size in KB
        $imageSizeKB = 0;
        $fullPath = public_path($design->image);
        if (file_exists($fullPath)) {
            $imageSizeKB = round(filesize($fullPath) / 1024, 2); // KB with 2 decimals
        }

        return response()->json([
            'user' => $user->only('id', 'name', 'email'),
            'creative_design' => [
                'image' => $imageUrl,
                'image_title' => $design->image_title,
                'image_size' => $imageSizeKB.' KB',
            ],
        ]);
    }
}
