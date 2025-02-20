<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
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
                ->filter(fn($item) => Gate::allows('view', $item))
                ->map(fn($item) => [
                    'id' => $item->id,
                    'name' => $item->name,
                    'path' => $item->path,
                    'mime' => $item->mime,
                    '_lft' => $item->_lft,
                    '_rgt' => $item->_rgt,
                    'parent_id' => $item->parent_id,
                    'is_folder' => $item->is_folder,
                    'size' => $item->size,
                    'is_favorite' => $item->is_favorite,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                    'created_by' => $item->created_by,
                    'updated_by' => $item->updated_by,
                    'deleted_at' => $item->deleted_at,
                    'is_shared' => $item->is_shared,
                ])
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
