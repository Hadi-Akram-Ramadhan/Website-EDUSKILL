<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AdminUserController extends Controller
{
    /**
     * Display a listing of the users.
     */
    public function index(Request $request): View
    {
        $query = User::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->input('role'));
        }

        $users = $query->orderByDesc('id')->paginate(12)->withQueryString();

        $stats = [
            'total' => User::count(),
            'students' => User::where('role', 'siswa')->count(),
            'mentors' => User::where('role', 'guru')->count(),
            'admins' => User::where('role', 'super_admin')->count(),
        ];

        return view('admin.users.index', compact('users', 'stats'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create(): View
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'regex:/^[a-zA-Z\s]+$/', 'max:255'],
            'nis_nim' => ['nullable', 'string', 'regex:/^[0-9A-Za-z\/\-\.]+$/', 'max:30', 'unique:users,nis_nim'],
            'email' => 'required|email|unique:users,email|max:255',
            'password' => 'required|string|min:6',
            'role' => ['required', Rule::in(['siswa', 'guru', 'super_admin'])],
            'xp' => 'nullable|integer|min:0',
            'gems' => 'nullable|integer|min:0',
            'hearts' => 'nullable|integer|min:0|max:5',
        ], [
            'name.regex' => 'Nama pengguna hanya boleh berisi huruf dan spasi (tidak boleh mengandung angka atau simbol).',
            'nis_nim.regex' => 'Format NIS tidak valid.',
            'nis_nim.unique' => 'NIS ini sudah terdaftar. Silakan gunakan NIS lain.',
            'email.unique' => 'Email ini sudah terdaftar. Silakan gunakan email lain.',
        ]);

        $avatarSeed = preg_replace('/[^a-zA-Z0-9]/', '_', strtolower($validated['name']));

        User::create([
            'name' => $validated['name'],
            'nis_nim' => $validated['nis_nim'] ?? null,
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'avatar' => "https://api.dicebear.com/7.x/bottts/svg?seed={$avatarSeed}",
            'xp' => $validated['xp'] ?? 0,
            'gems' => $validated['gems'] ?? 100,
            'hearts' => $validated['hearts'] ?? 5,
            'level' => 1,
            'streak_count' => 0,
        ]);

        return redirect()->route('admin.users.index')->with('success', "Pengguna '{$validated['name']}' berhasil ditambahkan.");
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user): View
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'regex:/^[a-zA-Z\s]+$/', 'max:255'],
            'nis_nim' => ['nullable', 'string', 'regex:/^[0-9A-Za-z\/\-\.]+$/', 'max:30', Rule::unique('users', 'nis_nim')->ignore($user->id)],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:6',
            'role' => ['required', Rule::in(['siswa', 'guru', 'super_admin'])],
            'xp' => 'nullable|integer|min:0',
            'gems' => 'nullable|integer|min:0',
            'hearts' => 'nullable|integer|min:0|max:5',
        ], [
            'name.regex' => 'Nama pengguna hanya boleh berisi huruf dan spasi (tidak boleh mengandung angka atau simbol).',
            'nis_nim.regex' => 'Format NIS tidak valid.',
            'nis_nim.unique' => 'NIS ini sudah terdaftar oleh pengguna lain.',
            'email.unique' => 'Email ini sudah terdaftar oleh pengguna lain.',
        ]);

        $updateData = [
            'name' => $validated['name'],
            'nis_nim' => $validated['nis_nim'] ?? $user->nis_nim,
            'email' => $validated['email'],
            'role' => $validated['role'],
            'xp' => $validated['xp'] ?? $user->xp,
            'gems' => $validated['gems'] ?? $user->gems,
            'hearts' => $validated['hearts'] ?? $user->hearts,
        ];

        if (! empty($validated['password'])) {
            $updateData['password'] = Hash::make($validated['password']);
        }

        $user->update($updateData);

        return redirect()->route('admin.users.index')->with('success', "Data pengguna '{$user->name}' berhasil diperbarui.");
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user): RedirectResponse
    {
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $userName = $user->name;
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', "Pengguna '{$userName}' telah dihapus.");
    }
}
