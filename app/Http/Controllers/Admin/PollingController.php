<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Polling;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class PollingController extends Controller
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

    public function candidatesUpdate(Request $request)
    {
        try {

            $rules = [
                'polling_id' => 'required|exists:pollings,id',
                'poll_candidates' => 'required|array|min:1',
                'poll_candidates.*' => 'required|exists:users,id',
            ];

            $messages = [];

            $attributes = [];

            $validator = Validator::make($request->all(), $rules , $messages, $attributes);

            // This validates and gives errors which are caught below and also stop further execution
            $validated = $validator->validated();

            $polling = Polling::find($validated['polling_id']);

            //////////////////////////////////
            if($polling->winner_type == 'gender-based'){
                $newCandidateIds = $validated['poll_candidates'];

                // Fetch genders of the new candidates
                $genders = User::whereIn('id', $newCandidateIds)->pluck('gender')->unique();

                // Check condition
                if (! $genders->contains('male') || ! $genders->contains('female')) {
                    throw ValidationException::withMessages([
                        'poll_candidates' => 'You must include at least one male and one female candidate.',
                    ]);
                }
            }
            //////////////////////////////////

            // Delete children that are not in the new set
            $polling->candidates()->sync($validated['poll_candidates']);

            return response()->json([
                'status' => 'success',
                'message' => 'Polling updated successfully!',
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
