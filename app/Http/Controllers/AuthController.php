<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

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
            case User::LOGIN_TYPE_PHYS:
                $credentials = request(['snils', 'password']);
                break;
            case User::LOGIN_TYPE_YUR:
                $credentials = request(['ogrn', 'password']);
                break;
            case User::LOGIN_TYPE_IP:
                $credentials = request(['ogrnip', 'password']);
                break;
            case User::LOGIN_TYPE_EMAIl:
            default:
                $credentials = request(['email', 'password']);
                break;
        }

        $credentials['is_active'] = 1;

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $user = \auth()->user();
        if (!$user->hasRole('super')){
            $host = parse_url(\request()->headers->get('origin'));
            $client = Client::where('host',$host['host'])->first();
            if (!$client || $user->client_id !== $client->id){
                return response()->json(['error' => 'Unauthorized'], 401);
            }
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
        $user->fullLoad();
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
        $hostArr = parse_url(\request()->headers->get('origin'));
        $host = $hostArr['host'];
        if ($host) {
            $client = Client::where('host', $host)->first();
            if ($client){
                $user = new User();
                $user->type = 'customer';
                $user->client_id = $client->id;
                $user->login_type = $request->get('login_type');
                $user->email = $request->get('email');
                $user->phone = $request->get('phone');
                $user->name = $request->get('name');
                $user->snils = $request->get('snils');
                $user->ogrn = $request->get('ogrn');
                $user->ogrnip = $request->get('ogrnip');
                $user->password = bcrypt($request->get('password'));
                $user->is_active = 1;

                $user->save();
                $user->setPermissionsToUser('customer');
                $name = explode(' ',$request->get('name'));
                $user->profile()->create([
                    'first_name' => $name[1] ?? '',
                    'last_name' => $name[0] ?? '',
                    'middle_name' => $name[2] ?? '',
                    'account' => $request->get('account')
                ]);

                return response()->json(['success' => true]);
            } else {
                return response()->json([
                    'error' => true,
                    'message' => 'Client not found'
                ]);
            }
        }

        return response()->json([
            'error' => true,
            'message' => 'Host is required'
        ]);
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
