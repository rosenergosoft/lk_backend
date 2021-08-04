<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function draft(): JsonResponse
    {
        $data = [
            'user_id' => auth()->user()->id,
            'status' => Application::STATUS_DRAFT
        ];

        $application = Application::create($data);

        return response()->json([
            'success' => true,
            'application' => $application
        ]);
    }

    /**
     * @return JsonResponse
     */
    public function getDraft(): JsonResponse
    {
        $application = Application::where('status', Application::STATUS_DRAFT)
            ->where('user_id', auth()->user()->id)
            ->first();
        if ($application){
            return response()->json([
                'id' => $application->id
            ]);
        }

        return response()->json([
            'message' => 'No drafts fro this user'
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        $data = $request->all();
        if ($data['id']) {
            $application = Application::find($data['id']);
            $data['status'] = Application::STATUS_ACCEPTED;
            $application->update($data);

            return response()->json([
                'success' => true,
                'application' => $application
            ]);
        }

        return response()->json([
            'error' => 'true',
            'message' => 'Missed id parameter'
        ]);
    }
}
