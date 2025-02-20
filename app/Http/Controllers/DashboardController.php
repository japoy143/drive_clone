<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search'); // Get search term

        return Inertia::render('Dashboard', [
            'files' => File::when(!empty($search), function ($query) use ($search) {
                return $query->where('name', 'like', '%' . $search . '%');
            })->latest()->take(3)->get()
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
                ]),

            'favorites' => File::where('is_favorite', 1)->get()
        ]);
    }
}
