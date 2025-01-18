<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/user/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    public function showLoginForm(){
        return view('user.auth.login');
    }

    protected function authenticated(Request $request, $user)
    {
        return redirect('/user/top');
        // authenticated メソッドは、ユーザーが正常にログインした直後に呼び出される。
    }

    protected function validateLogin(Request $request)
    {
        $messages = [
            'email.required' => '・入力したメールアドレスに誤りがあります。',
            'email.email' => '・メールアドレスは半角で入力してください。',
            'password.required' => '・入力したパスワードに誤りがあります。',
            'password.string' => '・パスワードは半角で入力してください。',
        ];

        $validator = Validator::make($request->all(),[
            $this->username() => 'required|email',
            'password' => 'required|string',
        ], $messages);

        if ($validator->fails()) {
            throw new ValidationException($validator); //登録されていない誤った情報の場合はValidationExceptionにthrowされてメッセージが表示される
        }
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            $this->username() => ['メールアドレスまたはパスワードが正しくありません。'],
        ]);
    }
}
