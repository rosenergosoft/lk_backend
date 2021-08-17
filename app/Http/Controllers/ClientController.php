<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function list(Request $request): JsonResponse
    {

        if (auth()->user()->hasRole('super')) {
            $list = Client::all()->pluck('name','id');
            return response()->json([
                'success' => true,
                'list' => $list
            ]);
        }

        return response()->json(['error' => true, 'message' => "You don't have a permission for this"]);
    }

    public function switchClient(Request $request): JsonResponse
    {
        if (auth()->user()->hasRole('super')) {
            $user = User::find(auth()->user()->id);
            $user->client_id = $request->get('client_id');
            $user->save();

            return response()->json([
                'success' => true
            ]);
        }

        return response()->json(['error' => true, 'message' => "You don't have a permission for this"]);
    }
}
