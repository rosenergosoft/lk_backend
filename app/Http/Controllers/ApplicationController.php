<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Scopes\ClientScope;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Psy\Util\Json;

class ApplicationController extends Controller
{
    public function changeStatus (Request $request): JsonResponse
    {
        if($applicationId = $request->get('application_id')) {
            $application = Application::find($applicationId);
            $application->status = $request->get('status');
            $application->save();
            return response()->json([
                'success' => 'true',
                'message' => 'Статус сохранен'
            ]);
        } else {
            return response()->json([
                'error' => 'true',
                'message' => 'Статус не сохранен'
            ]);
        }
    }
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function list(Request $request)
    {
        $user = auth()->user();
        $roles = $user->getRoleNames()->toArray();
        $list = new Application();

        if (in_array('customer',$roles)) {
            $list = $list->with(['user.profile','user.company','vendor', 'client'])->where('user_id',$user->id);
        }

        if (in_array('admin',$roles) || in_array('super',$roles)){
            $list = $list->with(['user.profile','user.company','vendor', 'client']);
        }

        $list = $this->filter($list,$request->all());
        $list = $list->paginate(10);

        return response()->json($list);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getCounts(Request $request): JsonResponse
    {
        $user = auth()->user();
        $roles = $user->getRoleNames()->toArray();

        $count = [];

        if (in_array('super',$roles) || in_array('admin',$roles)) {
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

        if (in_array('vendor', $roles)) {
            $vendorId = $user->vendor->id;
            $count = [
                Application::STATUS_ACCEPTED => Application::where('status',Application::STATUS_ACCEPTED)->where('vendor_id', $vendorId)->count(),
                Application::STATUS_COMPLETED => Application::where('status',Application::STATUS_COMPLETED)->where('vendor_id', $vendorId)->count(),
                Application::STATUS_IN_PROGRESS => Application::where('status',Application::STATUS_IN_PROGRESS)->where('vendor_id', $vendorId)->count(),
                Application::STATUS_DECLINED => Application::where('status',Application::STATUS_DECLINED)->where('vendor_id', $vendorId)->count(),
                Application::STATUS_WAITING_COMPANY_RESPONSE => Application::where('status',Application::STATUS_WAITING_COMPANY_RESPONSE)->where('vendor_id', $vendorId)->count(),
                Application::STATUS_PROGRESS_INVOICE => Application::where('status',Application::STATUS_PROGRESS_INVOICE)->where('vendor_id', $vendorId)->count(),
                Application::STATUS_PROGRESS_PREPARING => Application::where('status',Application::STATUS_PROGRESS_PREPARING)->where('vendor_id', $vendorId)->count(),
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

    /**
     * @param $model
     * @param $params
     * @return mixed
     */
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
