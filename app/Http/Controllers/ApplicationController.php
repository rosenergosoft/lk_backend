<?php

namespace App\Http\Controllers;

use App\Mail\NewApplication;
use App\Models\AppDocs;
use App\Models\Application;
use App\Models\CompanyInformation;
use App\Models\Documents;
use App\Models\User;
use App\Services\DocumentGenerationService;
use http\Client;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Messages;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\Client as ResClient;

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
            $list = $list->with(['user.profile','user.company','vendor', 'client'])->where('status', '<>', Application::STATUS_DRAFT);
        }

        if (in_array('vendor',$roles)) {
            $list = $list->with(['user.profile','user.company','vendor', 'client'])->where('status', '<>', Application::STATUS_DRAFT)->where('vendor_id',$user->vendor->id);
        }

        $list = $this->filter($list,$request->all());
        $list = $list->paginate($request->get('per_page',10));

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
     * @param Request $request
     * @return JsonResponse
     */
    public function fileUpload (Request $request): JsonResponse
    {
        if ($request->file()){
            foreach ($request->file() as $type => $file) {
                $path_parts = pathinfo($file->getClientOriginalName());
                $filename = Str::random(40).'.'.$path_parts['extension'];
                $filePath = $file->storeAs('uploads', $filename,'public');
                $document = new AppDocs();
                $document->file = $filePath;
                $document->type = $request->get('type','common');
                $document->original_name = $file->getClientOriginalName();
                $document->user_id = Auth()->user()->id;
                if($applicationId = $request->get('entity_id')) {
                    $application = Application::find($applicationId);
                    $document->entity_id = $applicationId;
                } else {
                    return response()->json(['success' => false, 'message' => 'Error']);
                }

                $document->save();
            }
            return response()->json([
                'success' => true,
                'docs' => $application->docs,
                'application' => $application
            ]);
        }
        return response()->json(['success' => true]);
    }

    /**
     * @param $appealId
     * @return JsonResponse
     */
    public function getDocs($applicationId): JsonResponse
    {
        $docs = AppDocs::with('user')->where('entity_id', $applicationId)
            ->get();
        if($docs) {
            return response()->json([
                'success' => true,
                'docs' => $docs
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'There\'s no docs for this appeal'
            ]);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function fileDelete(Request $request): JsonResponse
    {
        $doc = AppDocs::find($request->get('doc_id'));
        if($doc->entity_id == $request->get('application_id') && $doc->user_id == Auth()->user()->id) {
            $doc->delete();
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false, 'message' => 'You don\'t have enough permissions for this action']);
        }
    }

    public function downloadFile ($fileId) {
        $doc = AppDocs::find($fileId);
        if($doc->user_id == Auth()->user()->id) {
            $file = public_path('storage/' . $doc->file);
            return response()->make(file_get_contents($file), 200, [
                'Content-type: ' . mime_content_type($file),
                'Content-Disposition: attachment; filename=' . $doc->original_name
            ]);
        } else return '';
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function sendMessage(Request $request): JsonResponse
    {
        if($entity_id = $request->get('entity_id')) {
            $message = new Messages();
            $message->entity_id = $entity_id;
            $message->type = "common";
            $message->user_id = auth()->user()->id;
            if($messageText = $request->get('message')) {
                $message->message = $messageText;
                $message->save();
                $application = Application::find($entity_id);
                if(auth()->user()->type === 'customer') {
                    $application->status = Application::STATUS_ACCEPTED;
                } else {
                    $application->status = Application::STATUS_WAITING_COMPANY_RESPONSE;
                }
                $application->save();

                return response()->json([
                    'success' => 'true',
                    'messages' => Messages::with('userProfile')->where('entity_id', $entity_id)->get(),
                    'message' => 'Сообщение отправлено',
                    'application' => $application
                ]);
            }
        }
        return response()->json([
            'error' => 'false',
            'message' => 'Ошибка'
        ]);
    }

    /**
     * @param $appealId
     * @return JsonResponse
     */
    public function getMessages($applicationId): JsonResponse
    {
        $application = Application::find($applicationId);
        if($application) {
            $messages = $application->messages()->with(['userProfile'])->get();
            return response()->json([
                'success' => 'true',
                'messages' => $messages
            ]);
        } else {
            return response()->json([
                'error' => 'true',
                'message' => 'Ошибка'
            ]);
        }
    }

    /**
     * @return JsonResponse
     */
    public function draft(Request $request): JsonResponse
    {
        $data = [
            'user_id' => auth()->user()->id,
            'type' => $request->get('type'),
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
    public function getDraft($type): JsonResponse
    {
        $application = Application::where('status', Application::STATUS_DRAFT)
            ->where('user_id', auth()->user()->id)
            ->where('type', $type)
            ->first();
        if ($application){
            $docs = Documents::getAllPrepared();
            return response()->json([
                'id' => $application->id,
                'docs'  => $docs
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
        $user = auth()->user();
        $roles = $user->getRoleNames()->toArray();
        if(in_array('customer', $roles)) {
            if ($application->user_id !== $user->id){
                return response()->json([
                    'error' => true,
                    'message' => 'Forbidden'
                ]);
            }
        }
        if( $application) {
            return response()->json([
                'application' => $application,
                'userProfile' => $application->user->profile,
                'company'     => $application->user->company ?? '',
                'vendor'      => $application->vendor
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
            $data['status'] = Application::STATUS_WAITING_COMPANY_RESPONSE;
            $application->update($data);

            $clientId = auth()->user()->client_id;
            $user = User::find(auth()->user()->id);
            $companyInformation = CompanyInformation::where('client_id', $clientId)->get();

            if($application->type == 'electricity') {
                $documentService = new DocumentGenerationService();
                $generatedDocument = $documentService->generateElectricityDocs($companyInformation, $user, $application);
                if ($generatedDocument) {
                    $document = new AppDocs();
                    $document->file = $generatedDocument['path'];
                    $document->type = 'generated_doc';
                    $document->original_name = $generatedDocument['name'];
                    $document->user_id = $user->id;
                    $document->entity_id = $application->id;
                    $document->save();
                }
            }

            $client = ResClient::find($clientId);
            Mail::to(CompanyInformation::getValue($companyInformation, 'email'))->send(new NewApplication('https://' . $client->host, $user->profile->first_name . ' ' . $user->profile->middle_name . ' ' . $user->profile->last_name));

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
