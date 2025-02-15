<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TrashController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return Inertia::render('Trash', [
            'trash_files' => File::when($request->search, function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->search . '%');
            })->onlyTrashed()->get()
        ]);
    }

    public function restore($id)
    {
        $all_trash = File::onlyTrashed()->findOrFail($id);
        $all_trash->restore();

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
