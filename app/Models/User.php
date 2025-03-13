<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    protected $fillable = ['name', 'name_kana', 'email', 'profile_image', 'password'];

    /**
     * プロフィールの保存・更新 (DBトランザクション対応)
     *
     * @param array $data
     * @param User $user
     * @return User
     * @throws \Exception
     */
    public static function updateProfile(array $data, User $user): User
    {
        return DB::transaction(function () use ($data, $user) {
            $user->fill([
                'name' => $data['name'],
                'name_kana' => $data['name_kana'],
                'email' => $data['email'],
            ]);

            // プロフィール画像の処理
            if (isset($data['profile_image'])) {
                if ($user->profile_image) {
                    Storage::disk('public')->delete('profile_images/' . $user->profile_image);
                }
                $file = $data['profile_image'];
                $fileName = time() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('public/profile_images', $fileName);
                $user->profile_image = $fileName;
            }

            $user->save();

            return $user;
        });
    }

    /**
     * パスワードの変更 (DBトランザクション対応)
     *
     * @param string $currentPassword
     * @param string $newPassword
     * @param User $user
     * @throws \Exception
     */
    public static function updatePassword(string $currentPassword, string $newPassword, User $user): void
    {
        DB::transaction(function () use ($currentPassword, $newPassword, $user) {
            if (!Hash::check($currentPassword, $user->password)) {
                throw new \Exception('現在のパスワードが正しくありません。');
            }

            $user->password = Hash::make($newPassword);
            $user->save();
        });
    }
}