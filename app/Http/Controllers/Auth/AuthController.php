<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\SendMailGis;
use App\Models\Desa;
use App\Models\Pasien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
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
        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Ambil kredensial
        $credentials = $request->only('email', 'password');

        // Cek login
        if (Auth::attempt($credentials)) {
            // Redirect ke dashboard jika login berhasil
            return redirect()->intended('dashboard')->with('success', 'You have successfully logged in.');
        }

        // Redirect kembali ke login dengan pesan error
        return redirect("login")->withErrors(['loginError' => 'Email atau password salah.'])->withInput();
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
                ->whereMonth('tahun_terdata', '=', $month_now)->where('diagnosis_klinis', '=', 'DBD')
                ->count();
            $bulan_sekarang = Carbon::now()->month; // Mendapatkan bulan saat ini
            $tahun_sekarang = Carbon::now()->year; // Mendapatkan tahun saat ini

            $jumlah_kasus_perdesa = DB::table('pasiens')
                ->join('desas', 'pasiens.id_desa', '=', 'desas.id') // Gabungkan dengan tabel 'desas' berdasarkan 'id_desa'
                ->where('diagnosis_klinis', 'DBD') // Filter berdasarkan diagnosis
                ->whereYear('tahun_terdata', $tahun_sekarang) // Filter berdasarkan tahun saat ini
                ->whereMonth('tahun_terdata', $bulan_sekarang) // Filter berdasarkan bulan saat ini
                ->select('desas.id as desa_id', 'desas.nama as nama_desa', DB::raw('COUNT(*) as count_kasus'))
                ->groupBy('desas.id', 'desas.nama') // Pastikan GROUP BY mencakup semua kolom yang tidak dalam agregasi
                ->orderByDesc(DB::raw('COUNT(*)')) // Urutkan berdasarkan jumlah pasien terbanyak
                ->limit(1) // Batasi hanya satu hasil
                ->first();

            // dd($jumlah_kasus_perdesa);
            return view('auth.dashboard', compact('jumlah_pasien', 'last_updated_times', 'desa_list', 'pasiens', 'jumlah_kasus_terkini', 'jumlah_kasus_perdesa'));
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
            'NIK' => $data['NIK'],
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
    public function getDataPasienByDesaPie(Request $request)
    {
        try {
            $tahun = $request->input('tahun', Carbon::now()->year);

            // Get cases count by village
            $data = DB::table('pasiens')
                ->join('desas', 'pasiens.id_desa', '=', 'desas.id')
                ->whereYear('tahun_terdata', $tahun)
                ->where('diagnosis_klinis', '=', 'DBD')
                ->select('desas.nama', DB::raw('COUNT(*) as jumlah'))
                ->groupBy('desas.nama')
                ->orderBy('jumlah', 'DESC')
                ->get();

            // Format data for the pie chart
            $labels = $data->pluck('nama')->toArray();
            $values = $data->pluck('jumlah')->toArray();
            $intValues = [];
            foreach ($values as $v) {
                $intValues[] = (int)$v;
            }

            return response()->json([
                'success' => true,
                'data_chart' => [
                    'labels' => $labels,
                    'values' => $intValues,
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // public function forgotPasssword($email){
    //     $url = url('/').'/'.$email;
    // }

    public function send_email(Request $request)
    {
        $url = url('/') . '/forgot-pasword' . '/' . $request->email;
        $details = [
            'title' => 'Email From GIS DBD',
            'body' => 'Click For Forgot Password' . ' ' . $url
        ];
        Mail::to($request->email)->send(new SendMailGis($details));
        return redirect()->back();
    }

    public function view_email_forgot_password()
    {
        return view('auth.email_forgot_password');
    }
    public function page_forgot_password($email)
    {
        return view('auth.forgot', compact('email'));
    }

    public function update_forgot_password(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');
        $user = User::where('email', '=', $email)->update([
            'password' => Hash::make($password)
        ]);
        return redirect()->route('login')->with('success', 'password berhasil di ganti');
    }
    public function user_profile()
    {
        $user = '';
        if (Auth::user()->hasRole('Pasien')) {
            $pasien = Pasien::where('email', '=', Auth::user()->email)->first();
            $user = $pasien;
        } else if (Auth::user()->hasRole('Kepala Puskes') || Auth::user()->hasRole('Admin')) {
            $user = Auth::user();
        }
        return view('auth.user_profile', compact('user'));
    }

    public function update_user_profile(Request $request)
    {
        if (Auth::user()->hasRole('Pasien')) {
            $request->validate([
                'nama' => 'required',
                'email' => 'required|email|unique:users,email,' . Auth::user()->id,
                'password' => 'nullable|min:6',
                'alamat' => 'required',
                'usia' => 'required',
                'provinsi' => 'required',
                'kab_kota' => 'required',
                'tempat_lahir' => 'required',
                'tanggal_lahir' => 'required',
                'jenis_kelamin' => 'required',
            ]);

            $pasien = Pasien::where('email', Auth::user()->email)->first();

            if ($pasien) {
                $pasien->nik = $request->NIK;
                $pasien->nama = $request->nama;
                $pasien->email = $request->email;
                if ($request->password) {
                    $pasien->password = Hash::make($request->password);
                }
                $pasien->alamat = $request->alamat;
                $pasien->usia = $request->usia;
                $pasien->provinsi = $request->provinsi;
                $pasien->kab_kota = $request->kab_kota;
                $pasien->tempat_lahir = $request->tempat_lahir;
                $pasien->tanggal_lahir = $request->tanggal_lahir;
                $pasien->jenis_kelamin = $request->jenis_kelamin;
                $pasien->save();

                return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
            }
        } elseif (Auth::user()->hasRole('Kepala Puskes') || Auth::user()->hasRole('Admin')) {
            $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:users,email,' . Auth::user()->id,
            ]);

            $user = Auth::user();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->save();

            return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
        }

        return redirect()->back()->with('error', 'Gagal memperbarui profil.');
    }
}
