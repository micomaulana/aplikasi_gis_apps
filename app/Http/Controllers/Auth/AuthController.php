<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Desa;
use App\Models\Pasien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Spatie\Permission\Models\Role;

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
        $data_desas = Desa::all();
        return view('auth.registration', compact('data_desas'));
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
        // dd($request->all());
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'alamat' => 'required',
            'id_desa' => 'required',
            'usia' => 'required',
            'provinsi' => 'required',
            'kab_kota' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            'jenis_kelamin' => 'required',
        ]);

        $data = $request->all();
        if ($this->create_pasien($data)) {
            $this->create_user($data);
        }

        return redirect("dashboard")->withSuccess('Great! You have successfully logged in.');
    }
    /** * Write code on Method * * @return response() */

    public function dashboard()
    {
        if (Auth::check()) {
            $tanggal = Carbon::now()->startOfMonth()->format('Y-m-d');
            $jumlah_pasien = Pasien::where('tahun_terdata', '>=', $tanggal)->count();
            $last_updated_times = Pasien::latest()->first();
            $desa_list = Desa::all();
            $pasiens = Pasien::all();
            $year_now = Carbon::now()->year; // Get current year
            $month_now = Carbon::now()->month; // Get current month

            $jumlah_kasus_terkini = Pasien::whereYear('tahun_terdata', '=', $year_now)
                ->whereMonth('tahun_terdata', '=', $month_now)
                ->count();
            $bulan_sekarang = Carbon::now()->month; // Mendapatkan bulan saat ini
            $tahun_sekarang = Carbon::now()->year; // Mendapatkan tahun saat ini

            $jumlah_kasus_perdesa = DB::table('pasiens')
                ->where('diagnosis_klinis', '=', 'DBD') // Filter berdasarkan diagnosis, jika diperlukan
                ->join('desas', 'pasiens.id_desa', '=', 'desas.id') // Gabungkan dengan tabel 'desas' berdasarkan 'id_desa'
                ->whereYear('tahun_terdata', $tahun_sekarang) // Filter berdasarkan tahun saat ini
                ->whereMonth('tahun_terdata', $bulan_sekarang) // Filter berdasarkan bulan saat ini
                ->select('desas.nama as nama_desa', DB::raw('COUNT(*) as count_kasus')) // Ambil nama desa dan jumlah pasien
                ->groupBy('desas.nama') // Kelompokkan berdasarkan nama desa
                ->orderByDesc(DB::raw('COUNT(*)')) // Urutkan berdasarkan jumlah pasien terbanyak
                ->first(); // Ambil desa dengan jumlah pasien terbesar
            // dd($jumlah_kasus_perdesa);
            return view('auth.dashboard', compact('jumlah_pasien', 'last_updated_times', 'desa_list', 'pasiens', 'jumlah_kasus_terkini','jumlah_kasus_perdesa'));
        }
        return redirect("login")->withSuccess('Opps! You do not have access');
    }
    /** * Write code on Method * * @return response() */
    public function create_user(array $data)
    {
        $user = User::create(['name' => $data['nama'], 'email' => $data['email'], 'password' => Hash::make($data['password'])]);
        $role = Role::where('name', '=', 'Pasien')->first();
        $user->assignRole($role->id);
        return $user;
    }

    public function create_pasien(array $data)
    {
        return Pasien::create([
            'nama' => $data['nama'],
            'alamat' => $data['alamat'],
            'usia' => $data['usia'],
            'id_desa' => $data['id_desa'],
            'provinsi' => $data['provinsi'],
            'kab_kota' => $data['kab_kota'],
            'tempat_lahir' => $data['tempat_lahir'],
            'tanggal_lahir' => $data['tanggal_lahir'],
            'jenis_kelamin' => $data['jenis_kelamin'],
            'no_hp' => $data['no_hp'],
            'email' => $data['email'],
            'tahun_terdata' => now()
        ]);
    }
    /** * Write code on Method * * @return response() */
    public function logout()
    {
        Session::flush();
        Auth::logout();
        return Redirect('login');
    }
}
