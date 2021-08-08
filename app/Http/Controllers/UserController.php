<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserData;
use App\Http\Requests\UserProfilePersonalData;
use App\Models\Company;
use App\Models\Documents;
use App\Models\DocumentSignature;
use App\Models\SmsCode;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * @param UserData $request
     * @return JsonResponse
     */
    public function save(UserData $request): JsonResponse
    {
        $data = $request->validated();
        $user = User::find(auth()->user()->id);
        if (isset($data['oldPassword'])) {
            if ($user->password !== $data['oldPassword']) {
                return response()->json([
                    'error' => true,
                    'errors' => [
                        'oldPassword' => ['Wrong current password']
                    ]
                ]);
            }

            $user->password = bcrypt($data['newPassword']);
        }
        switch ($data['login_type']) {
            case User::LOGIN_TYPE_PHYS:
                $user->snils = $data['snils'];
                $user->email = $data['email'];
                $user->phone = $data['phone'];
                break;
            case User::LOGIN_TYPE_YUR:
                $user->ogrn = $data['ogrn'];
                $user->email = $data['email'];
                $user->phone = $data['phone'];
                break;
            case User::LOGIN_TYPE_IP:
                $user->ogrnip = $data['ogrnip'];
                $user->email = $data['email'];
                $user->phone = $data['phone'];
                break;
            case User::LOGIN_TYPE_EMAIl:
            default:
                $user->email = $data['email'];
                $user->phone = $data['phone'];
                break;
        }

        try {
            $user->save();
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ]);
        }

        $user->fullLoad();

        return response()->json([
            'success' => true,
            'user' => $user
        ]);
    }

    /**
     * @param UserProfilePersonalData $request
     * @return JsonResponse
     */
    public function saveProfile(UserProfilePersonalData $request): JsonResponse
    {
        $data = $request->validated();
        $user = User::find(auth()->user()->id);
        if ($profile = $user->profile) {
            $profile->update($data);
        } else {
            $user->profile()->create($data);
        }

        $user->refresh();
        return response()->json([
            'success' => true,
            'user' => $user
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function saveCompany(Request $request): JsonResponse
    {
        if ($request->get('id')) {
            $company = Company::find($request->get('id'));
            $company->update($request->all());
        } else {
            $data = $request->all();
            $data['user_id'] = auth()->user()->id;
            $company = Company::create($data);
        }

        return response()->json([
            'success' => true,
            'company' => $company
        ]);
    }

    public function deleteCompany(Request $request)
    {
        $id = $request->get('id');
        if ($id) {
            $company = Company::find($id);
            if ($company) {
                $company->delete();

                return response()->json([
                    'success' => true,
                    'company' => null
                ]);
            }

            return response()->json([
                'error' => true,
                'message' => "Can't find model"
            ]);
        }

        return response()->json([
            'error' => true,
            'message' => "Missed id parameter"
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getList(Request $request): JsonResponse
    {
        $users = User::with(['profile']);
        $users = $users->paginate(10);
        return response()->json($users);
    }

    /**
     * @param Request $request
     */
    public function upload(Request $request)
    {
        $userId = auth()->user()->id;
        if ($request->file()) {
            foreach ($request->file() as $type => $file) {
                $path_parts = pathinfo($file->getClientOriginalName());
                $document = new Documents();
                $filename = Str::random(40) . '.' . $path_parts['extension'];
                $filePath = $file->storeAs('uploads', $filename, 'public');
                $document->type = $type;
                $document->path = $filePath;
                $document->filename = $file->getClientOriginalName();
                $document->user_id = $userId;
                $document->save();
            }
        }

        return response()->json(['success' => true]);
    }

    public function getDocuments(Request $request): JsonResponse
    {
        $out = [
            'phys' => [],
            'yur' => []
        ];
        $documents = Documents::with(['signature'])->where('user_id', auth()->user()->id)->get();
        foreach ($documents as $doc) {
            if ($doc->type === Documents::TYPE_PERSONAL_ID || $doc->type === Documents::TYPE_PROXY) {
                $out['phys'][] = $doc;
            } else {
                $out['yur'][] = $doc;
            }
        }

        return response()->json([
            'docs' => $out
        ]);
    }

    public function deleteDocument(Request $request): JsonResponse
    {
        $id = $request->get('id');
        $document = Documents::find($id);
        if ($document) {
            Storage::delete('public/' . $document->path);
            $document->delete();

            return response()->json([
                'success' => true
            ]);
        }
        return response()->json([
            'error' => true,
            'message' => 'Something went wrong'
        ]);
    }

    public function getDocumentForSign(Request $request)
    {
        $document = Documents::find($request->get('id'));
        if ($document) {
            $file = public_path() . DIRECTORY_SEPARATOR . 'storage' . DIRECTORY_SEPARATOR . $document->path;
            $contentType = mime_content_type($file);
            $headers = [
                'Content-Type' => $contentType,
            ];

            return response()->file($file, $headers);
        }

        return response('Not found', 404);
    }

    public function signDocument(Request $request): JsonResponse
    {
        $data = $request->all();
        $signature = DocumentSignature::where('document_id', $data['document_id'])->first();
        if (!$signature) {
            if ($data['type'] === DocumentSignature::TYPE_SMS) {
                $smsCode = SmsCode::where('user_id',auth()->user()->id)
                    ->where('document_id', $data['document_id'])
                    ->where('code', $data['code'])
                    ->first();
                if ($smsCode) {
                    $data['sms_code'] = $data['code'];
                    DocumentSignature::create($data);
                    SmsCode::flushUserCodesForDocument(auth()->user()->id, $data['document_id']);
                    return response()->json([
                        'success' => true
                    ]);
                } else {
                    return response()->json([
                        'error' => true,
                        'message' => 'Code not found'
                    ]);
                }
            } else {
                DocumentSignature::create($data);
                return response()->json([
                    'success' => true
                ]);
            }
        }

        return response()->json([
            'error' => true,
            'message' => 'Document already signed'
        ]);


    }

    public function unsignDocument(Request $request): JsonResponse
    {
        $signature = DocumentSignature::find($request->get('id'));
        if ($signature) {
            $signature->delete();
            return response()->json([
                'success' => true
            ]);
        }

        return response()->json([
            'error' => true,
            'message' => 'Signature not found'
        ]);
    }

    public function sendSms(Request $request): JsonResponse
    {
        $code = random_int(100000, 999999);
        $data = [
            'document_id' => $request->get('id'),
            'user_id' => auth()->user()->id,
            'code' => $code
        ];
        $smsCode = SmsCode::create($data);
        $result = $smsCode->sendSms();

        return response()->json($request);
    }
}
