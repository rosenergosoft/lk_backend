<?php

namespace App\Http\Controllers;

use App\Models\Appeal;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Psy\Util\Json;

class AppealsController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function getDraft(): JsonResponse
    {
        $appeal = Appeal::where('status', Appeal::STATUS_DRAFT)
            ->where('user_id', auth()->user()->id)
            ->first();
        if ($appeal){
            return response()->json([
                'appeal_id' => $appeal->id
            ]);
        }

        return response()->json([
            'message' => 'No drafts for this user'
        ]);
    }

    /**
     * @return JsonResponse
     */
    public function draft(): JsonResponse
    {
        $data = [
            'user_id' => auth()->user()->id,
            'status' => Appeal::STATUS_DRAFT
        ];

        $appeal = Appeal::create($data);

        return response()->json([
            'success' => true,
            'appeal' => $appeal
        ]);
    }

    public function create(Request $request): JsonResponse
    {
        $data = $request->all();
        if ($data['id']) {
            $appeal = Appeal::find($data['id']);
            $data['status'] = Appeal::STATUS_ACCEPTED;
            $appeal->update($data);

            return response()->json([
                'success' => true,
                'appeal' => $appeal
            ]);
        }

        return response()->json([
            'error' => 'true',
            'message' => 'Missed id parameter'
        ]);
    }

    public function list() {

    }

    public function getAppeal($appealId): JsonResponse
    {
        $appeal = Appeal::find($appealId);
        if($appeal) {
            return response()->json([
                'appeal' => $appeal,
                'userProfile' => $appeal->user->profile,
                'company'     => $appeal->user->company ?? ''
            ]);
        } else {
            return response()->json([
                'message' => 'No appeal found with this id'
            ]);
        }
    }
}
