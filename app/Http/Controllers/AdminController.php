<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        return view('dashboard.dashboard');
    }

    public function register()
    {
        return view('register.register');
    }

    public function login()
    {
        return view('register.login');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'mobile' => 'required|digits:10|unique:users,mobile',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'mobile' => $validatedData['mobile'],
            'password' => Hash::make($validatedData['password']),
        ]);

        return redirect()->route('admin.login')->with('success', 'Registration successful! Please login.');
    }

    public function loginuser(Request $request)
    {
        if (Auth::attempt([
            'email' => $request->email,
            'password' => $request->password,
        ])) {
            return redirect()->route('admin.index')->with('success', 'Logged in successfully!');
        }
        return back()->withErrors([
            'email' => 'The provided email is incorrect.',
            'password' => 'The provided password is incorrect.',
        ])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login')->with('success', 'Logged out successfully!');
    }

    public function user_list()
    {
        $users = User::where('role', '!=', 'Super Admin')->get();
        return view('dashboard.user-list', compact('users'));
    }

    public function user_create()
    {
        $roles = User::distinct()->pluck('role')->filter(function ($role) {
            return $role !== 'Super Admin';
        });
        return view('dashboard.user-add', compact('roles'));
    }

    public function user_store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'mobile' => 'required|digits:10|unique:users,mobile',
            'role' => 'required|not_in:Select Role',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = new User();
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->mobile = $validatedData['mobile'];
        $user->role = $validatedData['role'];
        $user->password = Hash::make($validatedData['password']);
        $user->save();
        return redirect()->route('admin.user_list')->with('success', 'User added successfully!');
    }

    public function user_edit($id)
    {
        $user = User::findOrFail($id);
        $roles = User::distinct()->pluck('role')->filter(function ($role) {
            return $role !== 'Super Admin';
        });
        return view('dashboard.user-edit', compact('user', 'roles'));
    }

    public function user_update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'mobile' => 'required|digits:10|unique:users,mobile,' . $id,
            'role' => 'required|string',
            'password' => 'nullable|min:6|confirmed',
        ]);
        $user = User::findOrFail($id);
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->mobile = $validatedData['mobile'];
        $user->role = $validatedData['role'];
        if ($request->filled('password')) {
            $user->password = Hash::make($validatedData['password']);
        }
        $user->save();
        return redirect()->route('admin.user_list')->with('success', 'User details updated successfully!');
    }

    public function user_delete($id)
    {
        $user = User::findOrFail($id);
        if ($user->role === 'Super Admin') {
            return back()->with('error', 'You cannot delete a Super Admin.');
        }
        $user->delete();
        return redirect()->route('admin.user_list')->with('success', 'User deleted successfully.');
    }
}
