<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Http\Requests\Auth\RegisterFormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth; 

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */
    
    //use RegistersUsers;

    /**
     * Where to redirect users after registration.
     * 登録後どこに飛ばす
     * @var string
     */
    //protected $redirectTo = "/admin/login";管理者用ログイン画面

    /**
     * View 新規登録フォームを表示する
     */
    public function showRegisterForm() {
        return view('admin.auth.register');
    }

    /**
     * Create a new controller instance.
     * ログインしていないユーザーのみに制限されることを保証
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:admin');
    }

    
    protected function guard()//管理者用ログイン（認証）適用。
    {
        return Auth::guard('admin');
    }

    /**
     * Get a validator for an incoming registration request.
     * 入力されたデーターが特定の条件やルールに合致するかを確認する
     * @param  array  $data
     * @return
     */
    /**
     * 管理者の新規登録を行う
     *@param  \App\Http\Requests\Auth\RegisterFormRequest  $request
     *@return
     */
    public function register(RegisterFormRequest $request) {
        $admin = $this->create($request->validated());
        //// バリデーション済みデータを使用して管理者を登録
        $request->session()->flash('status', '登録が完了しました');
        return redirect()->route('admin.show.register.success');
    }

    /**
     * Show the registration success page.
     */
    public function showRegisterSuccess()
    {
        return view('admin.auth.register_success');// 新規登録成功ページを表示
    }

        /**
     * Create a new user instance after a valid registration.
     * バリデーションが成功した後に、新しいユーザーをデーターベースに作成
     * @param  array  $data
     * @return \App\Models\Admin
     */
        protected function create(array $data)
        {
            return Admin::create([
                'name' => $data['name'],
                'kana' => $data['kana'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);
        }

}
