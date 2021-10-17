<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\CompanyInformation;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function getFields(): JsonResponse
    {
        $id = auth()->user()->client_id;
        $fields = CompanyInformation::where('client_id', $id)->get();
        if($fields->count() == 0) {
            $fields = CompanyInformation::$fields;
        }
        return response()->json([
            'success' => true,
            'fields' => $fields
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function saveFields(Request $request) {
        if (auth()->user()->hasRole('super') || auth()->user()->hasRole('admin')) {
            $clientId = auth()->user()->client_id;

            $fields = $request->get('fields');

            foreach ($fields as $key=>$field) {
                $fields[$key]['client_id'] = $clientId;
                unset($fields[$key]['created_at']);
                unset($fields[$key]['updated_at']);
                if(!isset($field['value'])) $fields[$key]['value'] = '';
            }

            CompanyInformation::upsert($fields, ['client_id', 'name']);

            return response()->json([
                'success' => true
            ]);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function get(Request $request): JsonResponse
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

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function save(Request $request): JsonResponse
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

    /**
     * @param Request $request
     * @return JsonResponse
     */
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

    /**
     * @param Request $request
     * @return JsonResponse
     */
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
