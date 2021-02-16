<?php
namespace App\Classes;

use App\Events\AccountRegistered;
use App\Events\PasswordReset;
use App\Exceptions\CustomValidationFailed;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Models\UserActivity;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Traits\ActivityManager;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthClass
{
    use ActivityManager;
    /**
     * @var User
     */
    private $user;

    private  $auth;

    private $activityLog;

    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository) {
        $this->user = new User();
        $this->auth = Auth::guard('api');
        $this->activityLog = new UserActivity;
        $this->userRepository = $userRepository;
    }

    public function loginUser($data){
        $user = null;
        DB::transaction(function () use (&$user,$data){
            $token = $this->auth->attempt(['email' => $data['email'],'password' => $data['password'],'active' => 1]);
            if (!$token) {
                throw new AuthenticationException('invalid email or password');
            }
            $user = $this->user->find($this->auth->user()->id);
            $user->access_token = $token;
            $this->loginChecks($user);
            $this->logEntryActivityTime($user->id);
            $this->activityLog($user->id,"$user->name Logged in to the App",'login');
        });
        $resource = new UserResource($user);
        return response()->fetch('Login Successful',$resource,'user');
    }

    public function registerUser($data){
        $user = null;
        DB::transaction(function () use (&$user,$data){
             $data['password'] = Hash::make($data['password']);
             $data['user_type'] = 'consumer';
             $user = $this->userRepository->create($data);
             $token = auth()->login($user);
             $user->access_token = $token;
             $this->sendVerificationEmail($user);
             $this->activityLog(
                 $user->id,
                 "$user->name Registered in to the App",
                 'register'
             );
        });
        $resource = new UserResource($user);
        $message = "Registration  Successful.. Please Kindly Check Your Email For Verification OTP to continue your registration";
        return response()->fetch($message,
            $resource,'user');

    }

    protected function sendVerificationEmail(object $user):void {
        $length = 5;
        $otp =  substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil
        ($length/strlen($x)) )),1,$length);
        DB::table('email_otp')->updateOrInsert(['user_id' => $user->id],[
            'user_id' => $user->id,
            'otp' => $otp
        ]);
        event(new AccountRegistered($user));
        return;
    }

    protected function loginChecks($user): void
    {
        if (!$user->email_verified) {
            throw new AuthorizationException('kindly  verify your email before login');
        }
        if ($user->user_type === 'sub_admin' &&  !$this->activityLog->where('user_id',$user->id)->exists()) {
            throw new AuthorizationException('kindly reset your password before login');
        }
    }

    public function verifyUserEmail($user,$otp){
        $user_otp = DB::table('email_otp')->where('user_id',$user->id)->first()->otp;
        if($user_otp === $otp){
            $user->email_verified = 1;
            $user->save();
            $token = auth()->login($user);
            $user->access_token = $token;
            $resource = new UserResource($user);
            $this->activityLog($user->id,"$user->name Account Verified",'verification');
            return response()->updated('user verified successfully',$resource,'user');
        }
        throw new CustomValidationFailed('the otp is invalid');

    }

    public function resendVerificationEmail($user) {
        $this->sendVerificationEmail($user);
        $resource = new UserResource($user);
        $this->activityLog($user->id,"$user->name Password  Verification Email Resend",'verification');
        return \response()->fetch('verification mail resent successfully',$user,'user');
    }

    public function sendResetPasswordMail($email){
        $user = $this->user->where('email',$email)->first();
        event(new PasswordReset($user));
        $this->activityLog($user->id,"$user->name Password Reset Email Sent",'reset');
        return \response()->created('password reset sent successfully', true,'reset');
    }

    public function resetPassword($user,$data){
        $password = Hash::make($data['password']);
        $user->password = $password;
        $user->save();
        $token = auth()->login($user);
        $user->access_token = $token;
        $resource = new UserResource($user);
        $this->activityLog($user->id,"$user->name Password Reset",'reset');
        return response()->updated('Password Reset successfully',$resource,'user');
    }
}
