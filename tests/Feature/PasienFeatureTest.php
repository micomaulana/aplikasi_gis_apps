<?php

namespace Tests\Feature;

use App\Models\Pasien;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PasienFeatureTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function check_create_data_pasien_success()
    {
        $data = [
            "nama" => "mico",
            "NIK" => "123233412",
            "alamat" => "karya maju",
            "email" => "mike@gmail.com",
            "usia" => "18",
            "id_desa" => "1",
            "provinsi" => "sumatera selatan",
            "kab_kota" => "musi banyuasin",
            "tempat_lahir" => "sekayu",
            "tanggal_lahir" => "2004-10-13",
            "jenis_kelamin" => "laki laki",
            "diagnosis_lab" => "suspect",
            "diagnosis_klinis" => "DBD",
            "status_akhir" => "sembuh",
            "no_hp" => "0921342322",
            "tahun_terdata" => "2024"
        ];

        // Kirim request
        $response = $this->post('/pasiens', $data); // Sesuaikan dengan route resource

        // Assert redirect back
        $response->assertSessionHas('success', 'insert data berhasil');
        $response->assertRedirect(); // Karena menggunakan redirect()->back()

        // Periksa database
        $this->assertDatabaseHas('pasiens', $data);
    }

    /** @test */
    public function check_show_data_pasien_success()
    {
        // Menambahkan data ke database
        $pasien = Pasien::create([
            "nama" => "joko",
            "NIK" => "123233412",
            "alamat" => "karya maju",
            "email" => "mike@gmail.com",
            "usia" => "18",
            "id_desa" => "1",
            "provinsi" => "sumatera selatan",
            "kab_kota" => "musi banyuasin",
            "tempat_lahir" => "sekayu",
            "tanggal_lahir" => "2004-10-13",
            "jenis_kelamin" => "laki laki",
            "diagnosis_lab" => "suspect",
            "diagnosis_klinis" => "DBD",
            "status_akhir" => "sembuh",
            "no_hp" => "0921342322",
            "tahun_terdata" => "2024"
        ]);

        // Use resource route convention
        $response = $this->get(route('pasien.show', $pasien));

        // Assertions
        $response->assertStatus(200);
        $response->assertViewIs('pasien.show');
        $response->assertViewHas('pasien', $pasien);
    }

    /** @test */
    public function check_update_data_pasien_success()
    {
        // Buat data awal
        $pasien = Pasien::create([
            "nama" => "mico",
            "NIK" => "123233412",
            "alamat" => "karya maju",
            "email" => "mike@gmail.com",
            "usia" => "18",
            "id_desa" => "1",
            "provinsi" => "sumatera selatan",
            "kab_kota" => "musi banyuasin",
            "tempat_lahir" => "sekayu",
            "tanggal_lahir" => "2004-10-13",
            "jenis_kelamin" => "laki laki",
            "diagnosis_lab" => "suspect",
            "diagnosis_klinis" => "DBD",
            "status_akhir" => "sembuh",
            "no_hp" => "0921342322",
            "tahun_terdata" => "2024"
        ]);

        // Data untuk update
        $updatedData = [
            "nama" => "brayen",
            "NIK" => "123233412",
            "alamat" => "karya maju",
            "email" => "mike@gmail.com",
            "usia" => "18",
            "id_desa" => "1",
            "provinsi" => "sumatera selatan",
            "kab_kota" => "musi banyuasin",
            "tempat_lahir" => "sekayu",
            "tanggal_lahir" => "2004-10-13",
            "jenis_kelamin" => "laki laki",
            "diagnosis_lab" => "suspect",
            "diagnosis_klinis" => "DBD",
            "status_akhir" => "sembuh",
            "no_hp" => "0921342322",
            "tahun_terdata" => "2024"
        ];

        // Kirim request update
        $response = $this->put('/pasiens/' . $pasien->id, $updatedData);

        // Assert redirect dan session
        $response->assertSessionHas('success', 'update data berhasil');
        $response->assertRedirect();

        // Periksa database
        $this->assertDatabaseHas('pasiens', $updatedData);
        $this->assertDatabaseMissing('pasiens', [
            'nama' => 'pasien awal'
        ]);
    }

    /** @test */
    public function check_delete_data_pasien_success()
    {
        // Create a pasien first
        $pasien = Pasien::create([
            "nama" => "pasien test delete",
            "NIK" => "123233412",
            "alamat" => "karya maju",
            "email" => "mike@gmail.com",
            "usia" => "18",
            "id_desa" => "1",
            "provinsi" => "sumatera selatan",
            "kab_kota" => "musi banyuasin",
            "tempat_lahir" => "sekayu",
            "tanggal_lahir" => "2004-10-13",
            "jenis_kelamin" => "laki laki",
            "diagnosis_lab" => "suspect",
            "diagnosis_klinis" => "DBD",
            "status_akhir" => "sembuh",
            "no_hp" => "0921342322",
            "tahun_terdata" => "2024"
        ]);

        // Delete using the actual ID
        $response = $this->delete("/pasiens/{$pasien->id}");

        // Assertions
        $response->assertSessionHas('success', 'delete data berhasil');
        $response->assertRedirect();

        // Verify deletion
        $this->assertDatabaseMissing('pasiens', [
            'id' => $pasien->id,
            'nama' => "pasien test delete"
        ]);
        $this->assertNull(Pasien::find($pasien->id));
    }
}
