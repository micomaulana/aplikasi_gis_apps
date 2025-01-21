<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Desa;

class DesaFeatureTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function check_create_data_desa_success()
    {
        $data = [
            'nama' => "desa sukomulyo",
            'longitude' => "104.74580000",
            'latitude' => "-2.91673000"
        ];

        // Kirim request
        $response = $this->post('/desas', $data); // Sesuaikan dengan route resource

        // Assert redirect back
        $response->assertSessionHas('success', 'insert data berhasil');
        $response->assertRedirect(); // Karena menggunakan redirect()->back()

        // Periksa database
        $this->assertDatabaseHas('desas', $data);
    }

    /** @test */
    public function check_show_data_desa_success()
    {
        // Menambahkan data ke database
        $desa = \App\Models\Desa::create([
            'nama' => "desa sukomulyo",
            'longitude' => "104.74580000",
            'latitude' => "-2.91673000"
        ]);

        // Kirim request GET ke halaman show dengan ID desa
        $response = $this->get("/desas/{$desa->id}");

        // Memastikan halaman memuat data yang benar
        $response->assertStatus(200); // Pastikan status code 200 (OK)

        // Memastikan view yang dirender adalah 'desas.show'
        $response->assertViewIs('desa.show');

        // Memastikan data desa ada di dalam tampilan
        $response->assertViewHas('desa', $desa);

        // Memastikan data ada di database
        $this->assertDatabaseHas('desas', [
            'nama' => "desa sukomulyo",
            'longitude' => "104.74580000",
            'latitude' => "-2.91673000"
        ]);
    }

    /** @test */
    public function check_update_data_desa_success()
    {
        // Buat data awal
        $desa = Desa::create([
            'nama' => "desa sukomulyo",
            'longitude' => "104.74580000",
            'latitude' => "-2.91673000"
        ]);

        // Data untuk update
        $updatedData = [
            'nama' => "palembang",
            'longitude' => "105.74580000",
            'latitude' => "-2.31673000"
        ];

        // Kirim request update
        $response = $this->put('/desas/' . $desa->id, $updatedData);

        // Assert redirect dan session
        $response->assertSessionHas('success', 'update data berhasil');
        $response->assertRedirect();

        // Periksa database
        $this->assertDatabaseHas('desas', $updatedData);
        $this->assertDatabaseMissing('desas', [
            'nama' => 'desa awal'
        ]);
    }

    /** @test */
    public function check_delete_data_desa_success()
    {
        // Buat data untuk dihapus
        $desa = Desa::create([
            'nama' => "desa test delete",
            'longitude' => "104.74580000",
            'latitude' => "-2.91673000"
        ]);

        // Kirim request delete
        $response = $this->delete('/desas/' . $desa->id);

        // Assert redirect dan session
        $response->assertSessionHas('success', 'delete data berhasil');
        $response->assertRedirect();

        // Periksa data sudah terhapus dari database
        $this->assertDatabaseMissing('desas', [
            'id' => $desa->id,
            'nama' => "desa test delete"
        ]);

        // Verifikasi data benar-benar tidak ada
        $this->assertNull(Desa::find($desa->id));
    }
}
