<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function index()
    {
        return view('admin.users.index', ['users' => User::where('is_developer', false)->orderBy('name')->orderBy('id')->paginate(20)]);
    }

    public function create()
    {
        return view('admin.users.form', ['user' => new User]);
    }

    public function store(Request $request)
    {
        $this->save($request, new User);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        abort_if($user->is_developer, 404);

        return view('admin.users.form', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        abort_if($user->is_developer, 404);
        $this->save($request, $user);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(Request $request, User $user)
    {
        abort_if($user->is_developer, 404);
        if ($user->is($request->user())) {
            return back()->withErrors(['user' => 'Akun yang sedang digunakan tidak dapat dihapus.']);
        }
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus.');
    }

    private function save(Request $request, User $user): void
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'role' => ['required', Rule::in(['admin', 'user'])],
            'password' => [$user->exists ? 'nullable' : 'required', 'confirmed', Password::min(12)],
        ]);
        if ($user->is($request->user()) && $data['role'] !== 'admin') {
            throw ValidationException::withMessages(['role' => 'Akses admin akun yang sedang digunakan tidak dapat dicabut.']);
        }
        $user->fill(['name' => $data['name'], 'email' => $data['email']]);
        $user->is_admin = $data['role'] === 'admin';
        if (! empty($data['password'])) {
            $user->password = $data['password'];
            $user->remember_token = null;
        }
        $user->save();
    }
}
