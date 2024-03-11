<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->insert([
            'name' => 'Nguyễn Văn Mạnh',
            'email' => 'nguyenvanmanh2001it1@gmail.com',
            'role' => '1',
            'password' => Hash::make('nguyenvanmanh2001it1'),
            'avatar' => 'storage/Blog/image/avatars/admin.png',
        ]);
    }
}
