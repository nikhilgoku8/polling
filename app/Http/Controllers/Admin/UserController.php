<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $result = User::orderByDesc('updated_at')
            ->when($request->fname, function($query) use ($request){
                $query->where('fname','LIKE', "%{$request->fname}%");
            })
            ->when($request->lname, function($query) use ($request){
                $query->where('mname','LIKE', "%{$request->lname}%");
            })
            ->when($request->lname, function($query) use ($request){
                $query->where('lname','LIKE', "%{$request->lname}%");
            })
            ->when($request->email, function($query) use ($request){
                $query->where('email','LIKE', "%{$request->email}%");
            })
            ->when($request->gender, function($query) use ($request){
                $query->where('gender', $request->gender);
            })
            ->orderBy('fname')
            ->paginate(100);
            
        return view('admin.users.index', compact('result'));
    }

    public function create()
    {        
        return view('admin.users.create');
    }

    public function show(User $user)
    {
        $result = $user;
        return view('admin.users.show', compact('result'));
    }

    public function edit(User $user)
    {
        $result = $user;
        return view('admin.users.edit', compact('result'));
    }

    public function store(Request $request)
    {
        return $this->handleUserRequest($request, new User(), true);
    }

    public function update(Request $request, User $user)
    {
        return $this->handleUserRequest($request, $user, false);
    }

    public function string_filter($string){
        $string = str_replace('--', '-', preg_replace('/[^A-Za-z0-9\-\']/', '', str_replace(' ', '-', str_replace("- ","-", str_replace(" -","-", str_replace("&","and", preg_replace("!\s+!"," ",strtolower($string))))))));
        return $string;
    }

    private function handleUserRequest(Request $request, User $user, bool $isNew)
    {
        $dataID = $request->input('dataID');
        try {

            $rules = [
                'fname' => 'required|string|max:50',
                'mname' => 'nullable|string|max:50',
                'lname' => 'required|string|max:50',
                'email' => 'required|email|unique:users,email,'.$dataID,
                'gender' => 'required',
                'password' => $isNew ? 'required|bail|min:8|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/' : 'nullable|bail|min:8|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/',
                'confirm_password' => 'nullable|bail|required_with:password|same:password',
            ];

            $messages = [
                'password.regex' => 'Must be at least 8 characters with 1 uppercase, 1 lowercase, 1 digit, and 1 special character.'
            ];

            $attributes = [];

            $validator = Validator::make($request->all(), $rules , $messages, $attributes);

            // This validates and gives errors which are caught below and also stop further execution
            $validated = $validator->validated();

            // Not to set Password NULL if empty
            if (array_key_exists('password', $validated) && is_null($validated['password'])) {
                unset($validated['password']);
            }

            if ($isNew) {
                $validated['created_by'] = session('username');
            }
            $validated['updated_by'] = session('username');

            if ($request->password) {
                $validated['password'] = Hash::make($request->password);
                $validated['last_password_changed'] = now();
            }

            // Directly handle the save/update logic here
            if ($isNew) {
                $user = User::create($validated);
            } else {
                $user->update($validated);
            }

            return response()->json([
                'status' => 'success',
                'message' => $isNew ? 'User created successfully!' : 'User updated successfully!',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'error_type' => 'form',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'error_type' => 'server',
                'message' => 'Something went wrong. Please try again later.',
                'console_message' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted!');
    }

    public function bulkDelete(Request $request)
    {

        User::destroy($request->input('dataID'));

        return response()->json(['success' => true, 'message' => 'Record Deleted']);
    }
}
