<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        
          
         DB::table('users')->insert([
            'name' => 'Zaineb',
            'username'=>'Zianeb123',
            'email' => 'zineb.essaih02@gmail.com',
            'password' => Hash::make('password'),
        ]);
    }
}
