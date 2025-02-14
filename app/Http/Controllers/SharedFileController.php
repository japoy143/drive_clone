<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use PhpParser\Node\Stmt\TryCatch;

class SharedFileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $files = File::where('is_shared', '=', 1)->get();

        return Inertia::render('SharedFiles', ['files' => $files]);
    }


    public function sharedFile($email, $id)
    {
        $user = User::where('email', $email)->first();
        $file = File::findOrFail($id);


        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // Attach user ID to the file
        $file->users()->attach($user->id);
        $file->update(['is_shared' => 1]);

        return response()->json(['message' => 'File shared successfully'], 200);
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
    public function destroy(string $id)
    {
        //
    }
}
