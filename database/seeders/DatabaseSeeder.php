<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Bassem Hossam',
        //     'email' => 'bassem@gmail.com',
        // ]);

        $user = DB::table('users')->where('email', 'bassem@gmail.com')->first();
        
        if (!$user) {
            \App\Models\User::factory()->create([
                'name' => 'Bassem Hossam',
                'email' => 'bassem@gmail.com',
            ]);
        }
    }
}
