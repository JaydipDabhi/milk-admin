<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\MilkDelivery;
use App\Models\RateMaster;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class AdminController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $year = Carbon::now()->year;

        // Total liters sold this year
        $cowMilkSales = MilkDelivery::where('type', 'cow')
            ->whereYear('created_at', $year)
            ->sum('weight');

        $buffaloMilkSales = MilkDelivery::where('type', 'buffalo')
            ->whereYear('created_at', $year)
            ->sum('weight');

        $gheeSales = MilkDelivery::where('type', 'ghee')
            ->whereYear('created_at', $year)
            ->sum('weight');

        $butterSales = MilkDelivery::where('type', 'butter')
            ->whereYear('created_at', $year)
            ->sum('weight');

        // Total revenue (cow + buffalo)
        $totalRate = MilkDelivery::whereYear('created_at', $year)
            ->select(DB::raw('SUM(weight * rate) as total'))
            ->value('total');

        $customerCount = Customer::count();
        // $userCount = User::count();
        $userCount = User::where('role', '!=', 'Super Admin')->count();

        return view('dashboard.dashboard', [
            'cowMilkSales' => $cowMilkSales,
            'buffaloMilkSales' => $buffaloMilkSales,
            'gheeSales' => $gheeSales,
            'butterSales' => $butterSales,
            'totalRate' => $totalRate,
            'customerCount' => $customerCount,
            'userCount' => $userCount,
        ]);
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

        return redirect()->route('login')->with('success', 'Registration successful! Please login.');
    }

    public function loginuser(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate(); // Prevent session fixation
            return redirect()->intended(route('admin.index'))->with('success', 'Logged in successfully!');
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
        return redirect()->route('login')->with('error', 'Logged out successfully!');
    }

    public function showLinkRequestForm()
    {
        return view('register.forgot-password');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        // ✅ Delete any existing reset tokens for the email
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        // ✅ Send new reset link
        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', __($status))
            : back()->withErrors(['email' => __($status)]);
    }

    public function showResetForm(Request $request, $token)
    {
        return view('register.reset-password', [
            'token' => $token,
            'email' => $request->email,
        ]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) use ($request) {
                $user->password = Hash::make($password);
                $user->save();

                // ✅ Manually delete the token from password_reset_tokens table
                DB::table('password_reset_tokens')->where('email', $request->email)->delete();

                Auth::login($user); // Optional: auto-login after reset
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('admin.index')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }

    public function user_list()
    {
        if (Auth::user()->role !== 'Super Admin') {
            return redirect()->route('admin.index')->with('error', 'Access denied.');
        }

        $users = User::where('role', '!=', 'Super Admin')->get();
        return view('dashboard.user-list', compact('users'));
    }

    public function user_create()
    {
        if (Auth::user()->role !== 'Super Admin') {
            return redirect()->route('admin.index')->with('error', 'Access denied.');
        }

        $roles = User::distinct()->pluck('role')->filter(function ($role) {
            return $role !== 'Super Admin';
        });
        return view('dashboard.user-add', compact('roles'));
    }

    public function user_store(Request $request)
    {
        if (Auth::user()->role !== 'Super Admin') {
            return redirect()->route('admin.index')->with('error', 'Access denied.');
        }

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
        if (Auth::user()->role !== 'Super Admin') {
            return redirect()->route('admin.index')->with('error', 'Access denied.');
        }

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
        if (Auth::user()->role !== 'Super Admin') {
            return redirect()->route('admin.index')->with('error', 'Access denied.');
        }
        $user = User::findOrFail($id);
        if ($user->role === 'Super Admin') {
            return back()->with('error', 'You cannot delete a Super Admin.');
        }
        $user->delete();
        return redirect()->route('admin.user_list')->with('success', 'User deleted successfully.');
    }
}
