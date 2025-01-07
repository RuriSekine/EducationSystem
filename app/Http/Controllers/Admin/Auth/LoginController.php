<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth; 

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

    // use AuthenticatesUsers;
    use AuthenticatesUsers {
        logout as performLogout;
    }                              

    /**
     * Where to redirect users after login.ログイン後にリダイレクトする場所
     *
     * @var string
     */
    protected $redirectTo = '/admin/top';//管理者用トップ画面

    /**
     * View ログインフォームを表示する
     */
    public function showLoginForm() {
        return view('admin.auth.login');
    }

    public function login(Request $request) {
        
        $credentials = $request->only('email', 'password');

        $request->validate([
            'email' => 'required|max:255',
            'password' => 'required|min:8|max:255|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!$%^&*()_+={}\[\]:;"\'<>,.?/]).+$/',
        ], [
            'email.required' => 'メールアドレスを入力してください。',
            'password.required' => 'パスワードを入力してください。',
            'password.min' => 'パスワードは8文字以上である必要があります。',
        ]);

        //ログイン処理
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
        // 成功したらログインコメント表示
            $request->session()->flash('status','ログイン成功');
            return redirect()->route('admin.home');
        }
        //失敗したら元の画面にもどるようにする
        return back()->withErrors([
            'login_error' => 'メールアドレスまたはパスワードが正しくありません',
        ]);
    }

    /**
     * Create a new controller instance.
     * ログインしていないユーザーのみに制限されることを保証
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:admin')->except('performLogout');
        //ログアウトは除外
    }

    protected function guard()//管理者用ログイン（認証）適用。
    {
        return Auth::guard('admin');
    }

    //ログアウト処理
    public function logout(Request $request)
    {
        $this->performLogout($request);
        return redirect('admin/login');
    }                 

}
