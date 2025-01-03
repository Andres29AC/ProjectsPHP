<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    { 
        //$this->call(DocumentoSeeder::class);
        //$this -> call(ComprobanteSeeder::class);
        $this -> call(UserSeeder::class);
        //$this -> call(PermissionSeeder::class);
        //NOTE: Para ejecutar los seeders, se debe ejecutar el siguiente comando: 
        //php artisan db:seed
    }
}
