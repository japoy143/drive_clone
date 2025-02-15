<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

use function Pest\Laravel\json;

class MyFileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return Inertia::render('MyFiles', [
            'files' => File::when($request->search, function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->search . '%');
            })->where('parent_id', '=', null)->get(),

            'searchTerm' => $request->search
        ]);
    }



    public function rootToDirectory(Request $request)
    {
        $path = $request->path;
        $current_file = File::where('name', '=', $path)->first();
        return Inertia::render(
            'FileDirectories/Directory',
            [
                'path' => $path,
                'files' => File::when($request->search, function ($query) use ($request) {
                    $query->where('name', 'like', '%' . $request->search . '%');
                })->where('parent_id', '=', $current_file->id)->get()
            ]
        );
    }

    public function directory(Request $request)
    {

        $path = $request->path;
        $current_file = File::where('path', '=', $path)->first();
        $file_directory_name = $current_file->name;
        $children = File::where('parent_id', "=", $current_file->id)->get();
        return Inertia::render('FileDirectories/Directory', ['path' => $path, 'directoryName' => $file_directory_name, 'files' => $children]);
    }


    public function getUserApi()
    {
        $all_users = User::paginate(4);
        return response()->json($all_users);
    }

    public function searchUserApi(Request $request)
    {
        $query = $request->input('query'); // Get the search input

        $users = User::where('name', 'like', "%{$query}%") // Search in the 'name' column
            ->get(); // Fetch results

        return response()->json($users); // Return JSON response
    }

    public function rename(Request $request, File $file)
    {
        $file->update(['name' => $request->fileName]);
    }


    public function favorite(File $file)
    {
        $file->update(['is_favorite' => 1]);
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(File $file)
    {
        $file->delete();
    }
}
