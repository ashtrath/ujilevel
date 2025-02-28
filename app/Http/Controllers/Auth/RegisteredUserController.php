<?php

namespace App\Http\Controllers\Auth;

use App\Enums\JenisKelamin;
use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'jenis_kelamin' => ['required', 'string', 'in:' . implode(',', JenisKelamin::values())], 
            'usia' => ['required', 'integer', 'min:10', 'max:70'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'nama' => $request->nama,
            'jenis_kelamin' => JenisKelamin::from($request->jenis_kelamin), 
            'usia' => $request->usia,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => UserRole::User, 
        ]);

        Auth::login($user);

        return $this->redirectUser($user);
    }

    /**
     * Redirect user setelah login berdasarkan role.
     */
    protected function redirectUser(User $user)
    {
        return $user->role === UserRole::Admin
            ? redirect()->route('admin.dashboard')
            : redirect()->route('user.dashboard');
    }
}
