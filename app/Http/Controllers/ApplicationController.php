<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Psy\Util\Json;

class ApplicationController extends Controller
{
    public function list(Request $request)
    {
        $user = auth()->user();
        $roles = $user->getRoleNames()->toArray();
        $list = '';
        if (in_array('admin',$roles)){
            $list = Application::with(['user.profile','user.company','vendor'])->where('client_id',$user->client_id);
            $list = $this->filter($list,$request->all());
            $list = $list->paginate(10);
        }

        if (in_array('super',$roles)) {
            $list = Application::with(['user.profile','user.company','vendor']);
            $list = $this->filter($list,$request->all());
            $list = $list->paginate(10);
        }

        return response()->json($list);
    }

    public function getCounts(Request $request): JsonResponse
    {
        $user = auth()->user();
        $roles = $user->getRoleNames()->toArray();

        if (in_array('super',$roles)) {
            $count = [
                Application::STATUS_ACCEPTED => Application::where('status',Application::STATUS_ACCEPTED)->count(),
                Application::STATUS_COMPLETED => Application::where('status',Application::STATUS_COMPLETED)->count(),
                Application::STATUS_IN_PROGRESS => Application::where('status',Application::STATUS_IN_PROGRESS)->count(),
                Application::STATUS_DECLINED => Application::where('status',Application::STATUS_DECLINED)->count(),
                Application::STATUS_WAITING_COMPANY_RESPONSE => Application::where('status',Application::STATUS_WAITING_COMPANY_RESPONSE)->count(),
                Application::STATUS_PROGRESS_INVOICE => Application::where('status',Application::STATUS_PROGRESS_INVOICE)->count(),
                Application::STATUS_PROGRESS_PREPARING => Application::where('status',Application::STATUS_PROGRESS_PREPARING)->count(),
            ];
        }

        if (in_array('admin',$roles)) {
            $count = [
                Application::STATUS_ACCEPTED => Application::where('client_id',$user->client_id)->where('status',Application::STATUS_ACCEPTED)->count(),
                Application::STATUS_COMPLETED => Application::where('client_id',$user->client_id)->where('status',Application::STATUS_COMPLETED)->count(),
                Application::STATUS_IN_PROGRESS => Application::where('client_id',$user->client_id)->where('status',Application::STATUS_IN_PROGRESS)->count(),
                Application::STATUS_DECLINED => Application::where('client_id',$user->client_id)->where('status',Application::STATUS_DECLINED)->count(),
                Application::STATUS_WAITING_COMPANY_RESPONSE => Application::where('client_id',$user->client_id)->where('status',Application::STATUS_WAITING_COMPANY_RESPONSE)->count(),
                Application::STATUS_PROGRESS_INVOICE => Application::where('client_id',$user->client_id)->where('status',Application::STATUS_PROGRESS_INVOICE)->count(),
                Application::STATUS_PROGRESS_PREPARING => Application::where('client_id',$user->client_id)->where('status',Application::STATUS_PROGRESS_PREPARING)->count(),
            ];
        }

        return response()->json([
            'success' => true,
            'counts' => $count
        ]);
    }
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

    protected function filter($model, $params)
    {
        if (isset($params['status']) && $params['status'] !== 'all') {
            $model->where('status', $params['status']);
        }

        if (isset($params['query'])) {
            $model->whereHas('user.profile', function ($query) use($params) {
                $query->where('first_name','like','%'.$params['query'].'%')
                    ->orWhere('last_name','like','%'.$params['query'].'%')
                    ->orWhere('middle_name','like','%'.$params['query'].'%');
            })
            ->orWhereHas('user.company', function ($query) use($params) {
                $query->where('name','like','%'.$params['query'].'%');
            })
            ->orWhereHas('vendor', function ($query) use($params) {
                $query->where('name','like','%'.$params['query'].'%');
            });
        }

        return $model;
    }
}
