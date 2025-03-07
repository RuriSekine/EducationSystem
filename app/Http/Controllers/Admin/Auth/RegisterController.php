<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    /**
     * 新規登録画面を表示
     */
    public function showRegistrationForm()
    {
        return view('admin.auth.register');
    }

    /**
     * バリデーションルール
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name'  => ['required', 'string', 'max:255'],
            'kana'  => ['required', 'string', 'max:255', 'regex:/^[ァ-ヶー]+$/u'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:admins'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * 新しい管理者を作成
     */
    protected function create(array $data)
    {
        return Admin::create([
            'name'     => $data['name'],
            'kana'     => $data['kana'],  // 修正
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    /**
     * 新規登録処理
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        $admin = $this->create($request->all());

        return redirect()->route('admin.login')->with('success', '管理者登録が完了しました');
    }

    /**
     * リダイレクト先
     */
    protected function redirectTo()
    {
        return route('admin.login');
    }
}