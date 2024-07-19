<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\UrlModel;
use App\Models\AuthorityModel;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $data = User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'superadmin@gomecogroup.com',
            'password' => ('123123123')
        ]);

        $links = [
            ['linkName' => '/'],
            ['linkName' => 'home'],
            ['linkName' => 'dashboard'],
            ['linkName' => 'verify'],
            ['linkName' => 'sign-in'],
            ['linkName' => 'sign-out'],
            ['linkName' => 'profile'],
            ['linkName' => 'superadmin'],
                           
        ];
        UrlModel::insert($links);

        $access = [
            ['linkName_id' => 1, 'user_id' => $data->id],
            ['linkName_id' => 2, 'user_id' => $data->id],
            ['linkName_id' => 3, 'user_id' => $data->id],
            ['linkName_id' => 4, 'user_id' => $data->id],
            ['linkName_id' => 5, 'user_id' => $data->id],
            ['linkName_id' => 6, 'user_id' => $data->id],
            ['linkName_id' => 7, 'user_id' => $data->id],
            ['linkName_id' => 8, 'user_id' => $data->id],
        ];
        AuthorityModel::insert($access);
    }
}
