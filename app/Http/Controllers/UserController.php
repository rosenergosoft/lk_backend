<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserData;
use App\Http\Requests\UserProfilePersonalData;
use App\Http\Resources\UsersList;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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
                break;
            case User::LOGIN_TYPE_YUR:
                $user->ogrn = $data['ogrn'];
                $user->email = $data['email'];
                break;
            case User::LOGIN_TYPE_IP:
                $user->ogrnip = $data['ogrnip'];
                $user->email = $data['email'];
                break;
            case User::LOGIN_TYPE_EMAIl:
            default:
                $user->email = $data['email'];
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
    public function getList(Request $request): JsonResponse
    {
        $users = User::with(['profile']);
        $users->paginate($request->get('per_page',10));

        return response()->json(new UsersList($users));
    }
}
