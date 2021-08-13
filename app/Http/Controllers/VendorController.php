<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function list(Request $request): JsonResponse
    {
        $client_id = auth()->user()->client_id;
        $vendors = Vendor::where('client_id',$client_id)->get()->pluck('name','id');

        return response()->json([
            'success' => true,
            'vendors' => $vendors
        ]);
    }
}
