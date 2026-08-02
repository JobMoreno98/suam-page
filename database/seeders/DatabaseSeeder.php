<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

         $user = User::factory()->create([
            'name' => 'ADMIN',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password')
        ]);
        Role::create([
            'name' => 'super_admin',
            'guard_name' => 'web'
        ]);

        $user->assignRole('super_admin');
        $user->update();

        $this->call([
            AreaFormacionSeeder::class,
        ]);
    }
}
