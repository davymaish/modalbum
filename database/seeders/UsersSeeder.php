<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersSeeder extends Seeder 
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Am Admin',
            'email' => 'admin@google.com',
            'group_id' => 1
        ]);

        User::factory(10)->create();
    }
}
