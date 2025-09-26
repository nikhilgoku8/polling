<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Polling;
use App\Models\PollingVote;
use App\Models\User;

class PollingVoteController extends Controller
{
    public function index(Request $request)
    {
        $result = Polling::orderByDesc('updated_at')
            ->when($request->title, function($query) use ($request){
                $query->where('title','LIKE', "%{$request->title}%");
            })
            ->when($request->poll_type, function($query) use ($request){
                $query->where('poll_type', $request->poll_type);
            })
            ->when($request->winner_type, function($query) use ($request){
                $query->where('winner_type', $request->winner_type);
            })
            ->when($request->status, function($query) use ($request){
                $query->where('status', $request->status);
            })
            ->orderByDesc('created_at')
            ->paginate(100);
            
        return view('admin.pollings.index', compact('result'));
    }

    public function create()
    {        
        return view('admin.pollings.create');
    }

    public function show(Polling $polling)
    {
        $data['result'] = $polling;
        $data['users'] = User::all();
        return view('admin.pollings.show', $data);
    }

    public function edit(Polling $polling)
    {
        $data['result'] = $polling;
        $data['users'] = User::all();

        return view('admin.pollings.edit', $data);
    }

    public function store(Request $request)
    {
        return $this->handlePollingRequest($request, new Polling(), true);
    }

    public function update(Request $request, Polling $polling)
    {
        return $this->handlePollingRequest($request, $polling, false);
    }

    public function string_filter($string){
        $string = str_replace('--', '-', preg_replace('/[^A-Za-z0-9\-\']/', '', str_replace(' ', '-', str_replace("- ","-", str_replace(" -","-", str_replace("&","and", preg_replace("!\s+!"," ",strtolower($string))))))));
        return $string;
    }

    private function handlePollingRequest(Request $request, Polling $polling, bool $isNew)
    {
        $dataID = $request->input('dataID');
        try {

            $rules = [
                'title' => 'required|string|max:255|unique:pollings,title,'.$dataID,
                'poll_type' => 'required',
                'winner_type' => 'required',
                'status' => 'required',
            ];

            $messages = [];

            $attributes = [];

            $validator = Validator::make($request->all(), $rules , $messages, $attributes);

            // This validates and gives errors which are caught below and also stop further execution
            $validated = $validator->validated();

            if ($isNew) {
                $validated['created_by'] = session('username');
            }
            $validated['updated_by'] = session('username');

            // Directly handle the save/update logic here
            if ($isNew) {
                $polling = Polling::create($validated);
            } else {
                $polling->update($validated);
            }

            return response()->json([
                'status' => 'success',
                'message' => $isNew ? 'Polling created successfully!' : 'Polling updated successfully!',
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

    public function destroy(Polling $polling)
    {
        $polling->delete();
        return redirect()->route('admin.pollings.index')->with('success', 'Polling deleted!');
    }

    public function bulkDelete(Request $request)
    {

        Polling::destroy($request->input('dataID'));

        return response()->json(['success' => true, 'message' => 'Record Deleted']);
    }
}
