<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','registration']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $type = \request('type');
        switch ($type) {
            case 'phys':
                $credentials = request(['snils', 'password']);
                break;
            case 'yur':
                $credentials = request(['ogrn', 'password']);
                break;
            case 'ip':
                $credentials = request(['ogrnip', 'password']);
                break;
            case 'email':
            default:
                $credentials = request(['email', 'password']);
                break;
        }


        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        /** @var User $user */
        $user = auth()->user();
        $user->load(['roles','permissions','profile']);
        return response()->json($user);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function registration(Request $request)
    {
        $data = $request->all();

        $user = new User();
        $user->email = $request->get('email');
        $user->name = $request->get('name');
        $user->snils = $request->get('snils');
        $user->ogrn = $request->get('ogrn');
        $user->ogrnip = $request->get('ogrnip');
        $user->password = bcrypt($request->get('password'));

        $user->save();
        $name = explode(' ',$request->get('name'));
        $user->profile()->create([
            'first_name' => $name[1],
            'last_name' => $name[0],
            'middle_name' => $name[2],
            'account' => $request->get('account')
        ]);

        return response()->json(['success']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
