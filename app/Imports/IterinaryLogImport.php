<?php

namespace App\Imports;

use App\Models\IterinaryLog;
use Maatwebsite\Excel\Concerns\ToModel;
use DateTime;
use Exception;
use App\Models\User;
use Auth;

class IterinaryLogImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {

        if(strtolower($row[0]) == "identification"){
            return;
        }
        if(!$row[0]){
            return;
        }
        $access = Auth::user()->company;
       
        if(!$access == 0){
            
            $data = User::where('id',$row[0])->first();
            if($data->company != Auth::user()->company){
                return;
            }
        }

        $timeIn = IterinaryLogImport::convertTimeFormat($row[2]);
        $timeOut = IterinaryLogImport::convertTimeFormat($row[3]);
       
        if(!$timeIn)return;
        if(!$timeIn)return;

        $checkUser = User::where('id',$row[0])->first();
       
        if(!$checkUser)return;

        $date = IterinaryLogImport::convertDateFormat($row[1]);
       
       
        IterinaryLog::create([
            'user_id'   => $row[0],
            'date'      => $date,
            'time_in'   => $timeIn,
            'time_out'  => $timeOut,
            'location'  => $row[4],
        ]);
       
    }

    public function convertTimeFormat($time) {
        $date = strtotime($time);
        if ($date) {
            return date('H:i:s',$date);
        } else {
            return;
        }
    }
    public function convertDateFormat($date) {
        $c = strtotime($date);
        if ($c) {
            return date('Y-m-d',$c);
        } else {
            return;
        }
    }
}
