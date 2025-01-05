<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
        protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'name_kana' => ['required', 'string', 'max:255', 'regex:/^[ァ-ヶー]+$/u'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'regex:/^[a-zA-Z0-9!@#$%^&*()_+\-=\[\]{};:\'"|,.<>?]*$/', 'confirmed'],
        ], $this->messages());
    }

    protected function messages()
    {
        return [
            'name.required' => 'ユーザーネームは入力必須です。',
            'name_kana.required' => 'カナは入力必須です。',
            'name_kana.regex' => 'カナはカタカナで入力してください。',
            'email.required' => 'メールアドレスは入力必須です。',
            'email.email' => 'メールアドレス形式で入力してください。',
            'password.required' => 'パスワードは入力必須です。',
            'password.regex' => 'パスワードは半角で入力してください。',
            'password.min' => 'パスワードは8文字以上で入力してください。',
            'password.confirmed' => 'パスワードと合致していません。',
        ];
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'name_kana' => $data['name_kana'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'grade_id' => 1, //新規登録のユーザーは全て1年生として自動で1を割り当てる。
        ]);
    }

    public function register(Request $request)
    {
        $validator =  $this->validator($request->all());

        if ($validator->fails()) {
            return redirect()->back()
                            ->withErrors($validator)
                            ->withInput();
        }

        event(new Registered($user = $this->create($request->all())));

        return $this->registered($request, $user)
                        ?: redirect($this->redirectPath());
    }

    protected function registered(Request $request, $user)
    {
        return redirect('/user/login');
    }

    public function showRegistrationForm(){
        return view('user.auth.register');
    }
}
