<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\Tools;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Notifications\OpenProjectNotification;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\Sanctum;

class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     * @param Request $request
     * @return Response
     */

    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    public function store(Request $request)
    {

        try {
            $validator = Validator::make($request->all(), $this->rules());

            if ($validator->fails()) {
                return returnValidatorFails($validator);
            }

            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {

                $token = auth()->user()->createToken('auth-token')->plainTextToken;

                $userResource = new UserResource(auth()->user(),$token);
                $email = 'brahimhaddad.code@gmail.com'; // Specify the email address
                Notification::route('mail', $email)->notify(new OpenProjectNotification());
                return returnResponseJson(['user'=>$userResource,'token'=>$token],Response::HTTP_OK,'user' );
            }

            return returnResponseJson(["error" => "That credentials not compatible with data."], Response::HTTP_BAD_REQUEST);

        } catch (\Exception $e) {
            return returnCatchException($e);
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request)
    {
        $log = auth('sanctum')->user()->tokens()->delete();
        return returnResponseJson(['message'=>'logout success'],200);
    }
}
