<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Psy\Util\Json;

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
            'message' => 'No drafts for this user'
        ]);
    }

    /**
     * @param $applicationId
     * @return JsonResponse
     */
    public function getApplication($applicationId): JsonResponse
    {
        $application = Application::find($applicationId);
        if( $application) {
            return response()->json([
                'application' => $application,
                'userProfile' => $application->user->profile,
                'company'     => $application->user->company ?? ''
            ]);
        } else {
            return response()->json([
                'message' => 'No application found with this id'
            ]);
        }
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
