<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class LoginController extends Controller
{

    public function dashboard(Request $request){
        return view('admin/dashboard');
    }

    public function login(){
        return view('admin/login');
    }

    public function authenticate(Request $request){

        $validator = Validator::make($request->all(), [
            'email'=>'required|email',
            'password'=>'required'
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

                $admin = Admin::where('email', $request->email)->first();

                if($admin){

                    if (Hash::check($request->password, $admin->password)) {

                        $admin->update(['last_login' => now()]);

                        $request->session()->put('username', $admin->fname);
                        $request->session()->put('userid', $admin->id);
                        $request->session()->put('isAdmin', 'yes');
                        $request->session()->put('last_login', $admin->last_login ?? now());
                        $response = [
                            'success' => true,
                            'message' => 'Login successful'
                        ];
                    }else{
                        $response = [
                            'error' => true,
                            'error_type' => 'login',
                            'message' => 'Incorrect Password'
                        ];
                    }      
                }else{
                    $response = [
                        'error' => true,
                        'error_type' => 'login',
                        'message' => 'User not found'
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

    public function logout(Request $request){
        $request->session()->flush();
        return redirect()->route('admin.login');
    }
}
