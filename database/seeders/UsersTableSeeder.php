<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        // DB::table('users')->insert([
        //     'name' => 'John Doe23',
        //     'email' => 'johndoe23@example.com',
        //     'password' => Hash::make('password223'),
        //     'google_id' => '11743319275979465222223',
        //     'github_id' => '8156345123',
        //     'username' => 'johnprovip23',
        //     'avatar' => 'storage/Blog/image/avatars/DRE07857 (1)_168897622923.jpg',
        //     'gender' => 1,

        // ]);

        // Tạo dữ liệu mẫu sử dụng factory
        \App\Models\User::factory(3)->create();
    }
}
