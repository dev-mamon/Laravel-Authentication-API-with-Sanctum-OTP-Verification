<?php

namespace App\Http\Controllers\API\Fashion;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Fashion;
use App\Traits\ApiResponse;

class FashionApiController extends Controller
{
    use ApiResponse;

    public function index()
    {
        $fashions = Fashion::all();
        $apiResponse = [
            'id' => $fashions->id,
            'image' => Helper::generateURL($fashions->image) ?? null,
            'logo' => Helper::generateURL($fashions->logo) ?? null,
            'url' => $fashions->url,
        ];

        return $this->sendResponse($apiResponse, 'Fashions retrieved successfully.');
    }
}
