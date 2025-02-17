<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'user-list', 
            'user-create', 
            'user-edit', 
            'user-delete', 
            'role-list', 
            'role-create', 
            'role-edit', 
            'role-delete', 
            'desa-list', 
            'desa-create', 
            'desa-edit', 
            'desa-delete', 
            'pasien-list',
            'pasien-create', 
            'pasien-edit', 
            'pasien-delete',
            'dokter-list',
            'dokter-create', 
            'dokter-edit', 
            'dokter-delete',
            'informasi-list',
            'informasi-create', 
            'informasi-edit', 
            'informasi-delete',
            'maps',
            'validasi-admin',
            'validasi-kepala_puskesmas',
            'dashboard-admin',
            'laporandbd_admin',
            'laporankondisi_masyarakat',
            'landingpage',
            'dashboard_masyarakat',
            'faq_masyarakat',
            'pelaporan_lab'
        ];
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    
    }
}
