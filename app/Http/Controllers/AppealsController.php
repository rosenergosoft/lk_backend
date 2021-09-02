<?php

namespace App\Http\Controllers;

use App\Models\Appeal;
use App\Models\AppealDocs;
use App\Models\AppealMessages;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
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

    /**
     * @param Request $request
     * @return JsonResponse
     */
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

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function sendMessage(Request $request): JsonResponse
    {
        if($appeal_id = $request->get('appeal_id')) {
            $message = new AppealMessages();
            $message->appeal_id = $appeal_id;
            $message->user_id = auth()->user()->id;
            if($messageText = $request->get('message')) {
                $message->message = $messageText;
                $message->save();
                $appeal = Appeal::find($appeal_id);
                if(auth()->user()->type === 'customer') {
                    $appeal->status = Appeal::STATUS_ACCEPTED;
                } else {
                    $appeal->status = Appeal::STATUS_WAITING_USER_RESPONSE;
                }
                $appeal->save();

                return response()->json([
                    'success' => 'true',
                    'messages' => AppealMessages::with('userProfile')->where('appeal_id', $appeal_id)->get(),
                    'message' => 'Сообщение отправлено',
                    'appeal' => $appeal
                ]);
            }
        }
        return response()->json([
            'error' => 'false',
            'message' => 'Ошибка'
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function changeStatus (Request $request): JsonResponse
    {
        if($appealId = $request->get('appeal_id')) {
            $appeal = Appeal::find($appealId);
//            $user = auth()->user();
//            $roles = $user->getRoleNames()->toArray();
//            if(in_array('admin', $roles)) {
//                $appeal->status = $request->get('status')->save();
//            }
            $appeal->status = $request->get('status');
            $appeal->save();
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
     * @param $appealId
     * @return JsonResponse
     */
    public function getMessages($appealId): JsonResponse
    {
        $appeal = Appeal::find($appealId);
        if($appeal) {
            $messages = $appeal->messages()->with(['userProfile'])->get();
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
     * @param Request $request
     * @return JsonResponse
     */
    public function list(Request $request): JsonResponse
    {
        $user = auth()->user();
        $roles = $user->getRoleNames()->toArray();
        if(in_array('customer', $roles)) {
            $list = Appeal::where('user_id', $user->id)->paginate();
        } else if(
            in_array('admin', $roles) ||
            in_array('super', $roles) ||
            in_array('vendor', $roles)
        ) {
            $list = Appeal::where('status', '<>', Appeal::STATUS_DRAFT)->paginate();
        }
        if(isset($list)) {
            return response()->json($list);
        } else {
            return response()->json([
                'message' => 'No appeals found'
            ]);
        }
    }

    /**
     * @param $appealId
     * @return JsonResponse
     */
    public function getAppeal($appealId): JsonResponse
    {
        $appeal = Appeal::find($appealId);
        $user = auth()->user();
        $roles = $user->getRoleNames()->toArray();
        if(in_array('customer', $roles)) {
            if ($appeal->user_id !== $user->id){
                return response()->json([
                    'error' => true,
                    'message' => 'Forbidden'
                ]);
            }
        }
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

    /**
     * @param Request $Request
     * @return JsonResponse
     */
    public function fileUpload (Request $Request): JsonResponse
    {
        if ($Request->file()){
            foreach ($Request->file() as $type => $file) {
                $path_parts = pathinfo($file->getClientOriginalName());
                $document = new AppealDocs();
                $filename = Str::random(40).'.'.$path_parts['extension'];
                $filePath = $file->storeAs('uploads', $filename,'public');
                $document->file = $filePath;
                $document->original_name = $file->getClientOriginalName();
                $document->user_id = Auth()->user()->id;
                if($appealId = $Request->get('appeal_id')) {
                    $appeal = Appeal::find($appealId);
                    $document->appeal_id = $appealId;
                } else {
                    return response()->json(['success' => false, 'message' => 'Error']);
                }

                $document->save();
            }
            return response()->json([
                'success' => true,
                'docs' => $appeal->docs,
                'appeal' => $appeal
            ]);
        }
        return response()->json(['success' => true]);
    }

    /**
     * @param $appealId
     * @return JsonResponse
     */
    public function getDocs($appealId): JsonResponse
    {
        $docs = AppealDocs::where('appeal_id', $appealId)->get();
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
        $doc = AppealDocs::find($request->get('doc_id'));
        if($doc->appeal_id == $request->get('appeal_id') && $doc->user_id == Auth()->user()->id) {
            $doc->delete();
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false, 'message' => 'You don\'t have enough permissions for this action']);
        }
    }

    public function downloadFile ($fileId) {
        $doc = AppealDocs::find($fileId);
        if($doc->user_id == Auth()->user()->id) {
            $file = public_path('storage/' . $doc->file);
            return response()->make(file_get_contents($file), 200, [
                'Content-type: ' . mime_content_type($file),
                'Content-Disposition: attachment; filename=' . $doc->original_name
            ]);
        } else return '';
    }
}
