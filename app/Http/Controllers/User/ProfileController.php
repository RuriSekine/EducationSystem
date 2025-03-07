<?php
namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        return view('user.profile_edit',['user' => Auth::user()]); // プロフィール画面のビューを返す
    }
    /**
     * プロフィール編集画面を表示
     */
    public function edit()
    {
        return view('user.profile_edit', ['user' => Auth::user()]);
    }

    /**
     * プロフィール更新処理
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'name_kana' => ['required', 'string', 'max:255', 'regex:/^[ァ-ヴー\s]+$/u'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'profile_image' => ['nullable', 'image', 'mimes:png,jpg,jpeg', 'max:2048'], 
        ]);

        $user->name = $request->input('name');
        $user->name_kana = $request->input('name_kana');
        $user->email = $request->input('email');
        if ($request->hasFile('profile_image')) 
        {
            // 古い画像を削除
            if ($user->profile_image) 
            {
                Storage::disk('public')->delete('profile_images/' . $user->profile_image);
            }
    
            // 画像を保存
            $file = $request->file('profile_image');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/profile_images', $fileName);
            
            // DBに保存
            $user->profile_image = $fileName;
        }
        $user->save();
        
        return redirect()->route('user.edit.profile')->with('success', 'プロフィールが更新されました。');
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
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);
    
        $user = Auth::user();
    
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => '現在のパスワードが正しくありません。']);
        }
    
        $user->password = Hash::make($request->new_password);
        $user->save();
    
        return redirect()->route('user.edit.profile')->with('success', 'パスワードが変更されました。');
    }
}
?>