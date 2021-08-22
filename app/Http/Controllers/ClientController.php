<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function get(Request $request)
    {
        if (auth()->user()->hasRole('super')) {
            $id = auth()->user()->client_id;
            $client = Client::find($id);

            return response()->json([
                'success' => true,
                'client' => $client
            ]);
        }

        return response()->json(['error' => true, 'message' => "You don't have a permission for this"]);
    }

    public function save(Request $request)
    {
        if (auth()->user()->hasRole('super')) {
            $id = auth()->user()->client_id;
            $client = Client::find($id);
            $client->type = $request->get('type');
            $client->save();

            return response()->json([
                'success' => true,
                'client' => $client
            ]);
        }

        return response()->json(['error' => true, 'message' => "You don't have a permission for this"]);
    }

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
