<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class AdminController extends Controller
{

    public function register(){
        $data = array(
            'fname' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password')
        );
        // DB::table('admins')->insert($data);
        Admin::create($data);
    }
    
    public function change_password(){
        return view('admin/change-password');
    }

    public function changePasswordFunction(Request $request){

        $validator = Validator::make($request->all(), [
            'old_password'=>'required',
            'new_password'=>'required'
        ]);
        
        if(!$validator->passes()){
            return response()->json([
                'error' => true,
                'error_type' => 'form',
                'message' => 'Invalid request',
                'errors' => $validator->errors()->toArray(),
            ], 422);

        }else{

            try {
                
                $admin = Admin::find(session('userid'));

                if($admin){

                    if (Hash::check($request->old_password, $admin->password)) {

                        $newPassword = Hash::make($request->new_password);
                        // print_r($newPassword);
                        $data = array(
                            'password' => $newPassword,
                            'updated_by' => session('username'),
                            'updated_at' => now(),
                        );

                        $admin->update($data);

                        Session::flash('success','Password Changed Successfully');

                        $response = [
                            'success' => true,
                            'message' => 'Password Changed Successfully'
                        ];
                    }else{
                        $response = [
                            'error' => true,
                            'error_type' => 'form',
                            'message' => 'Old Password Does Not Match',
                            'errors' => ['old_password'=>'Old Password Does Not Match'],
                        ];
                    }      
                }else{
                    $response = [
                        'error' => true,
                        'error_type' => 'form',
                        'message' => 'User Id Not Found',
                        'errors' => ['old_password'=>'User Id Not Found'],
                    ];
                }

            } catch (\Exception $e) {
                $response = [
                    'error' => true,
                    'error_type' => 'database',
                    'message' => 'Database connection error: ' . $e->getMessage(),
                ];
            }

            return response()->json($response);

        }

    }
}
