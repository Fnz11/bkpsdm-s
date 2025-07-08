<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        foreach (['asn', 'admin', 'superadmin'] as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        $csvPath = storage_path('app/seeds/ref_pegawais.csv');
        if (!file_exists($csvPath)) {
            $this->command->error("File CSV tidak ditemukan: {$csvPath}");
            return;
        }

        $file = fopen($csvPath, 'r');
        fgetcsv($file); // Skip header

        // Mapping admin untuk masing-masing unit kerja
        $adminUnitKerja = [
            19 => '199908282023081001', // ABDULLAH FATAH
            26 => '198007022003121004', // AGUNG WIJAYANTO
            27 => '197711112003121013'  // ANDY PURWANTO
        ];

        while (($row = fgetcsv($file)) !== false) {
            $nip = $row[1];
            $nama = $row[3];

            if (User::where('nip', $nip)->exists()) {
                continue;
            }

            $email = strtolower(Str::slug($nama, '')) . '.' . $nip . '@gmail.com';
            
            // Tentukan role (admin untuk atasan unit kerja)
            $role = 'asn';
            if (in_array($nip, $adminUnitKerja)) {
                $role = 'admin';
            }

            $user = User::create([
                'nip' => $nip,
                'email' => $email,
                'role' => $role,
                'password' => Hash::make('12345678'),
            ]);

            $user->assignRole($role);
        }

        fclose($file);

        // Buat user manual
        // Buat user manual
        $this->createManualUser(
            nip: '11112',
            nama: 'Admin Sistem',
            email: 'admin@gmail.com',
            role: 'admin'
        );

        $this->createManualUser(
            nip: '11113',
            nama: 'Superadmin Sistem',
            email: 'superadmin@gmail.com',
            role: 'superadmin'
        );

        $this->createManualUser(
            nip: '11111',
            nama: 'Asn',
            email: 'asn@gmail.com',
            role: 'asn'
        );
    }

    private function createManualUser(string $nip, string $nama, string $email, string $role): void
    {
        if (User::where('nip', $nip)->exists()) {
            return;
        }

        $user = User::create([
            'nip' => $nip,
            'email' => $email,
            'role' => $role,
            'password' => Hash::make('12345678'),
        ]);

        $user->assignRole($role);

        if (!DB::table('ref_pegawai')->where('nip', $nip)->exists()) {
            DB::table('ref_pegawai')->insert([
                'nip' => $nip,
                'name' => $nama,
                'foto' => null,
                'alamat' => 'Kantor Pusat',
                'no_hp' => 0,
                'nip_atasan' => '199908282023081001',
                'tempat_lahir' => 'Jakarta',
                'tanggal_lahir' => now()->format('Y-m-d'),
                'created_at' => now(),
            ]);
        }
    }
}