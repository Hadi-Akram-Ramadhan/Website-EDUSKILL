<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\GamificationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class WebAuthController extends Controller
{
    protected GamificationService $gamificationService;

    public function __construct(GamificationService $gamificationService)
    {
        $this->gamificationService = $gamificationService;
    }

    /**
     * Show Web Login Page.
     */
    public function showLogin(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('learn.index');
        }

        $demoUsers = User::orderBy('id')->get();

        return view('auth.login', compact('demoUsers'));
    }

    /**
     * Handle Web Login submission.
     */
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            $this->gamificationService->syncHearts(Auth::user());

            return redirect()->intended(route('learn.index'));
        }

        return back()->withErrors([
            'email' => 'Email atau kata sandi tidak cocok.',
        ])->onlyInput('email');
    }

    /**
     * One-Click Quick Login for instant demo testing.
     */
    public function quickLogin(int $userId): RedirectResponse
    {
        $user = User::findOrFail($userId);
        Auth::login($user);
        request()->session()->regenerate();
        $this->gamificationService->syncHearts($user);

        return redirect()->route('learn.index')->with('success', "Halo {$user->name}! Selamat datang di Kodein.");
    }

    /**
     * Show Web Register Page.
     */
    public function showRegister(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('learn.index');
        }

        return view('auth.register');
    }

    /**
     * Handle Web Registration.
     */
    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'role' => ['required', 'string', 'in:siswa,guru'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'avatar' => 'https://api.dicebear.com/7.x/bottts/svg?seed='.urlencode($validated['name']),
            'xp' => 0,
            'level' => 1,
            'hearts' => 5,
            'gems' => 50,
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('learn.index')->with('success', 'Akun berhasil dibuat! Mulai petualangan coding-mu sekarang 🚀');
    }

    /**
     * Handle Web Logout.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('landing');
    }
}
