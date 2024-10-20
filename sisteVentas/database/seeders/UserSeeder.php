<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
             'name' => 'lion',
             'email' => 'lion@gmail.com',
             'password' => bcrypt('12345678')//NOTE: password
         ]);
        $rol = Role::create(['name' => 'admin']);
        $permisos = Permission::pluck('id', 'id')->all();
        $rol -> syncPermissions($permisos);
        //$user = User::find(1);
        $user -> assignRole('admin');
    }
}
