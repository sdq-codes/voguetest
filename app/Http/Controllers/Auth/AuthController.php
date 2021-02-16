<?php

namespace App\Http\Controllers\Auth;

use App\Classes\AuthClass;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    //
    /**
     * @var AuthClass
     */
    private $authClass;

    public function __construct(AuthClass $authClass) {
        $this->authClass = $authClass;
    }

    public function login(Request $request){
        $this->validate($request,[
            'email' => 'required|email',
            'password' => 'required'
        ]);
        return $this->authClass->loginUser($request->only(['email','password']));
    }


    public function register(Request $request){
        $this->validate($request,[
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
            'name' => 'required|string',
            'phone_number' => 'required|numeric',
        ]);

        return $this->authClass->registerUser($request->only(['email','password','name','phone_number']));
    }

    public function userVerification(Request $request){
        $this->validate($request,[
            'otp' => 'required'
        ]);
        $user =  $request->user();
        return $this->authClass->verifyUserEmail($user,$request->otp);
    }

    public function resendVerification(Request $request){
        $user = $request->user();
        return $this->authClass->resendVerificationEmail($user);
    }

    public function resetPasswordMail(Request $request){
        $this->validate($request,[
            'email' => 'required|email|exists:users,email'
        ]);

        return $this->authClass->sendResetPasswordMail($request->email);
    }

    public function passwordReset(Request $request){
        $this->validate($request,[
            'password'=> 'required|confirmed'
        ]);
        $user =  $request->user();
        return $this->authClass->resetPassword($user,$request->only(['password']));
    }
}
