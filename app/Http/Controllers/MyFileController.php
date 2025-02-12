<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MyFileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('MyFiles', [
            'files' => File::where('parent_id', '=', null)->get(),
        ]);
    }


    public function rootToDirectory(Request $request)
    {
        $path = $request->path;
        $current_file = File::where('name', '=', $path)->first();
        $children = File::where('parent_id', "=", $current_file->id)->get();
        return Inertia::render('FileDirectories/Directory', ['path' => $path, 'files' => $children]);
    }

    public function directory(Request $request)
    {

        $path = $request->path;
        $current_file = File::where('path', '=', $path)->first();
        $file_directory_name = $current_file->name;
        $children = File::where('parent_id', "=", $current_file->id)->get();
        return Inertia::render('FileDirectories/Directory', ['path' => $path, 'directoryName' => $file_directory_name, 'files' => $children]);
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
