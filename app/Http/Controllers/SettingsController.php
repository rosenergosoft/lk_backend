<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function typeList(): JsonResponse
    {
        $id = auth()->user()->client_id;
        $client = Client::find($id);

        return response()->json([
            'success' => true,
            'type' => $client->type
        ]);
    }
}
