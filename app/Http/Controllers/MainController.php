<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class MainController extends Controller
{
    // panggil halaman login
    public function showLoginPage()
    {
        return view('login');
    }

    // proses login admin/dokter
    public function doLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Find the user by email
        $user = User::where('email', $request->email)->first();

        // Check if the user exists and the password matches directly
        if (
            !$user || $user->password !== $request->password
        ) {
            return back()->with('error', 'Email atau password salah.');
        }

        // Log the user in
        Auth::login($user);

        // Redirect based on the user's role
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } else if ($user->role === 'dokter') {
            $request->session()->put("idlogin",$user->id);
            return redirect()->route('dokter.dashboard');
        } else {
            return redirect()->route('pasien.pilih-poli');
        }

        // Redirect to login page if no valid role
        return redirect()->route('showLoginPage');
    }
}
