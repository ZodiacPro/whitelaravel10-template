<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Hash;
use App\Models\AuthorityModel;

class UserImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if(strtolower($row[0]) == "name"){
            return;
        }
        if(!$row[0]){
            return;
        }
        if(!$row[1]){
            return;
        }
        if (filter_var($row[1], FILTER_VALIDATE_EMAIL) === false) {
            return;
        }
        $checkforDuplicate = User::where('email',$row[1])->first();
        if($checkforDuplicate) return;

        if(!$row[4]){
            return;
        }else{
            $company = 20;
            if(strtolower($row[4]) == "gmc") $company = 1;
            if(strtolower($row[4]) == "mmi") $company = 2;
            if(strtolower($row[4]) == "tms") $company = 3;
        }


        $data = User::create([
            'name'   => $row[0],
            'email'      => $row[1],
            'phone'   => $row[2],
            'location'  => $row[3],
            'password'  =>  ('gmc@2024'),
            'company'  =>  $company,
        ]);

        $access = [
            ['linkName_id' => 1, 'user_id' => $data->id],
            ['linkName_id' => 2, 'user_id' => $data->id],
            ['linkName_id' => 3, 'user_id' => $data->id],
            ['linkName_id' => 4, 'user_id' => $data->id],
            ['linkName_id' => 5, 'user_id' => $data->id],
            ['linkName_id' => 6, 'user_id' => $data->id],
            ['linkName_id' => 7, 'user_id' => $data->id],
        ];
        AuthorityModel::insert($access);
    }
}
