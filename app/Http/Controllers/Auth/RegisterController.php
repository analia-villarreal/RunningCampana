<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

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
    protected $redirectTo = '/home';

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
            'last_name' => ['required', 'string', 'max:255'],
            'gender' => ['required', 'string',],
            'age' => ['required', 'integer',],
            'weight' => ['integer',],
            'height' => ['integer',],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'avatar' => 'file',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $path = $data['avatar'];


        if (!is_null($path)) {
            $filename = $path->store('public/avatars');
            $dbFilename = explode('/',$filename);
            $filename = 'storage/avatars/'.$dbFilename[2];
        }

        return User::create([
            'name' => $data['name'],
            'last_name' => $data['last_name'],
            'gender' => $data['gender'],
            'age' => $data['age'],
            'weight' => $data['weight'],
            'height' => $data['height'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'avatar' => $filename,
            'role' => $data['role'],
        ]);
    }
}