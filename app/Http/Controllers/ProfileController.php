<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use DataTables;
use Response;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UserImport;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index(Request $request){
        if ($request->ajax()) {
            $data = User::get();
    
            return DataTables::of($data)
                ->addColumn('action', function ($row) {
                    if($row->active){
                        $html = '
                        <div class="d-grid">
                            <button class="btn btn-sm btn-danger" onclick="dis('.$row->id.')" type="button">Disable</button>
                            <button class="btn btn-sm btn-secondary" onclick="res('.$row->id.')" type="button">Reset</button>
                        </div>';
                    }else{
                        $html = '
                    <div class="d-grid">
                        <button class="btn btn-sm btn-success" onclick="en('.$row->id.')" type="button">Enable</button>
                        <button class="btn btn-sm btn-secondary" onclick="res('.$row->id.')" type="button">Reset</button>
                    </div>';
                    }
                    return $html;
                })
                ->addColumn('dateText', function ($row) {
                    return date("h:i A", strtotime($row->created_at));
                })
                ->addColumn('company', function ($row) {
                    if($row->company == 0) return "All";
                    if($row->company == 1) return "Gomeco";
                    if($row->company == 2) return "Multimach";
                    if($row->company == 3) return "TMS";
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('pages.user.user-management');
    }
    public function create(Request $request)
    {
        if($request->type === "reset"){
            User::where('id',$request->id)
            ->update([
                'password' => Hash::make('gmc@2024'),
            ]);
            $user = User::where('id',$request->id)->first();
            return $user->email;
        }
        return view('pages.profile');
    }

    public function downloadtemplate(){
        $filepath = public_path('/templates/user_template.xlsx');
        return Response::download($filepath);
    }

    public function user_upload(Request $request)
    {
        if($request->hasFile('file')){
            try {
                Excel::import(new UserImport, $request->file('file'));
            }
            catch (QueryException $e) {
                return redirect()->route('usermanagement.index')->with('failed', 'Error Uploading File, Please check file data!');
                
            }
        }
        return redirect()->route('usermanagement.index')->with('success', 'Registered!');
    }

    public function update()
    {
            
        $user = request()->user();
        $attributes = request()->validate([
            'email' => 'required|email|unique:users,email,'.$user->id,
            'name' => 'required',
            'phone' => 'required|max:10',
            'about' => 'required:max:150',
            'location' => 'required'
        ]);

        auth()->user()->update($attributes);
        return back()->withStatus('Profile successfully updated.');
    
    }
    public function update_user(Request $request)
    {
        if($request->type === "enable"){
            User::where('id',$request->id)
            ->update([
                'active' => 1
            ]);
            return 'success';
        }
        if($request->type === "disable"){
            User::where('id',$request->id)
            ->update([
                'active' => 0
            ]);
            return 'success';
        }
        if($request->type === "reset"){
            User::where('id',$request->id)
            ->update([
                'password' => Hash::make('gmc@2024'),
            ]);
            $user = User::where('id',$request->id)->first();
            return $user->email;
        }
        return;
    }
}
