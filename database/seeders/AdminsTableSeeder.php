<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $adminRecords=[
        ['id'=>1,'name'=>'superadmin','type'=>'superadmin','vendor_id'=>0,'mobile'=>'78855758888','email'=>'admin@gmail.com','password'=>'$2y$10$T0ML.6XZRkPN53SGN9o7NuhOlY0/2K242ln1SCIi.uj7oIYv4r40K','image'=>'','status'=>1],
        ['id'=>2,'name'=>'john','type'=>'vendor','vendor_id'=>1,'mobile'=>'7885458888','email'=>'john@gmail.com','password'=>'$2y$10$T0ML.6XZRkPN53SGN9o7NuhOlY0/2K242ln1SCIi.uj7oIYv4r40K','image'=>'','status'=>0],

       ];
       Admin::insert($adminRecords);
    }
}