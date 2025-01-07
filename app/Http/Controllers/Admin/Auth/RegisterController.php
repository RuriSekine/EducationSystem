<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
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
    
    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     * 登録後どこに飛ばす
     * @var string
     */
    protected $redirectTo = '/admin/top';//管理者用トップ画面

    /**
     * View 新規登録フォームを表示する
     */
    public function showRegisterForm() {
        return view('admin.auth.register');
    }

    public function register(Request $request) {
        //データのバリデーション
        $this->validator($request->all())->validate();
        //バリデーションが通ったらデータベースに作成
        $this->create($request->all());
        //コメント表示
        return view('admin.auth.register_success');
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
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'max:255', 'unique:admins'],
            'kana_name' => ['required', 'max:255', 'unique:admins', 'regex:/^[ｧ-ﾝﾞﾟァ-ヴー]+$/u'],
            'email' => ['required', 'email', 'max:255', 'unique:admins'],
            'password' => ['required', 'min:8', 'max:255', 'confirmed','regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!$%^&*()_+={}\[\]:;"\'<>,.?/]).+$/'],
            'password_confirmation' => ['confirmed'],
        ], [
            'name.required' => 'ユーザーネームが入力されていません。',
            'kana_name.required' => 'カナが入力されていません。',
            'email.required' => 'メールアドレスが入力されていません。',
            'password.required' => 'パスワードが入力されていません。',
            'password.confirmed' => 'パスワードが一致しません。',
            'password.min' => 'パスワードは8文字以上である必要があります。',
            'password_confirmation.required' => 'パスワード確認が入力されていません。'
        ]);
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
            'kana' => $data['kana_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
