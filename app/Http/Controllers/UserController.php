<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserData;
use App\Http\Requests\UserProfilePersonalData;
use App\Models\Company;
use App\Models\Documents;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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
        if (isset($data['oldPassword'])){
            if ($user->password !== $data['oldPassword']){
                return response()->json([
                    'error' => true,
                    'errors' => [
                        'oldPassword' => ['Wrong current password']
                    ]
                ]);
            }

            $user->password = bcrypt($data['newPassword']);
        }
        switch ($data['login_type']){
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

        try{
            $user->save();
        } catch (\Exception $e){
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
        if ($profile = $user->profile){
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
        if ($request->get('id')){
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
        if ($id){
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
        if ($request->file()){
            foreach ($request->file() as $type => $file) {
                $path_parts = pathinfo($file->getClientOriginalName());
                $document = new Documents();
                $filename = Str::random(40).'.'.$path_parts['extension'];
                $filePath = $file->storeAs('uploads', $filename,'public');
                $document->type = $type;
                $document->path = $filePath;
                $document->filename = $file->getClientOriginalName();
                $document->user_id = $userId;
                $document->save();
            }
        }

        return response()->json(['success' => true]);
    }

    public function getDocuments(Request $request)
    {
        $out = [
            'phys' => [],
            'yur' => []
        ];
        $documents = Documents::where('user_id',auth()->user()->id)->get();
        foreach ($documents as $doc) {
            if ($doc->type === Documents::TYPE_PERSONAL_ID || $doc->type === Documents::TYPE_PROXY){
                $out['phys'][] = $doc;
            } else {
                $out['yur'][] = $doc;
            }
        }

        return response()->json([
            'docs' => $out
        ]);
    }
}
