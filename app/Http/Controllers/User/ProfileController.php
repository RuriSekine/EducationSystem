<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\PasswordRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Exception;

class ProfileController extends Controller
{
    public function index()
    {
        return view('user.profile_edit', ['user' => Auth::user()]);
    }

    public function edit()
    {
        $user = Auth::user(); // ログインユーザー情報を取得

        return view('user.profile_edit', compact('user')); // ビューにユーザー情報を渡す
    }

    /**
     * プロフィール更新処理
     */
    public function update(ProfileRequest $request)
    {
        $user = Auth::user();

        try {
            User::updateProfile($request->validated(), $user);
            return Redirect::route('user.edit.profile')->with('success', 'プロフィールが更新されました。');
        } catch (Exception $e) {
            return Redirect::back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * パスワード編集画面を表示
     */
    public function editPassword()
    {
        return view('user.password_edit');
    }

    /**
     * パスワード更新処理
     */
    public function updatePassword(PasswordRequest $request)
    {
        $user = Auth::user();

        try {
            User::updatePassword($request->current_password, $request->new_password, $user);
            return Redirect::route('user.edit.profile')->with('success', 'パスワードが変更されました。');
        } catch (Exception $e) {
            return Redirect::back()->withErrors(['current_password' => $e->getMessage()]);
        }
    }
}
?>