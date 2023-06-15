<?php

namespace Database\Seeders;

use DB;
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

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        DB::table('user_groups')->delete();
        $user_groups = [
            [
                'group'      => "Super Admin",
                'group_code' => "SU",
            ],
            [
                'group'      => "Admin",
                'group_code' => "ADMIN",
            ],
            [
                'group'      => "Moderator",
                'group_code' => "MODERATOR",
            ],
            [
                'group'      => "Staff",
                'group_code' => "STAFF",
            ],
            [
                'group'      => "Editor",
                'group_code' => "EDITOR",
            ],
            [
                'group'      => "Member",
                'group_code' => "MEMBER",
            ],
            [
                'group'      => "Banned",
                'group_code' => "BANNED",
            ],
        ];
        DB::table('user_groups')->insert($user_groups);
        $this->call(UsersSeeder::class);
    }
}
