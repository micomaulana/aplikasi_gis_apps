<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Desa;
use App\Models\Pasien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    /** * Write code on Method * * @return response() */ 
    
    public function index()
    {
        return view('auth.login');
    }
    /** * Write code on Method * * @return response() */
    
    public function registration()
    {
        return view('auth.registration');
    }
    /** * Write code on Method * * @return response() \*/ 
    public function postLogin(Request $request)
    {
        $request->validate(['email' => 'required', 'password' => 'required',]);
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect()->intended('dashboard')->withSuccess('You have Successfully loggedin');
        }
        return redirect("login")->withSuccess('salah coy');
    }
    /** * Write code on Method * * @return response() */ 
    
    public function postRegistration(Request $request)
    {
        $request->validate(['name' => 'required', 'email' => 'required|email|unique:users', 'password' => 'required|min:6',]);
        $data = $request->all();
        $check = $this->create($data);
        return redirect("dashboard")->withSuccess('Great! You have Successfully loggedin');
    }
    /** * Write code on Method * * @return response() */ 
    
    public function dashboard()
    {
        if (Auth::check()) {
            $tanggal = Carbon::now()->startOfMonth()->format('Y-m-d');
            $jumlah_pasien = Pasien::where('created_at','>=',$tanggal)->count();
            $last_updated_times = Pasien::latest()->first();
            $desa_list = Desa::all();
            $pasiens = Pasien::all();
            return view('auth.dashboard',compact('jumlah_pasien','last_updated_times','desa_list','pasiens'));
        }
        return redirect("login")->withSuccess('Opps! You do not have access');
    }
    /** * Write code on Method * * @return response() */
    public function create(array $data)
    {
        return User::create(['name' => $data['name'], 'email' => $data['email'], 'password' => Hash::make($data['password'])]);
    }
    /** * Write code on Method * * @return response() */ 
    public function logout()
    {
        Session::flush();
        Auth::logout();
        return Redirect('login');
    }
}
