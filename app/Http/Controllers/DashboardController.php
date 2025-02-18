<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search'); // Get search term

        return Inertia::render('Dashboard', [
            'files' => File::when(!empty($search), function ($query) use ($search) {
                return $query->where('name', 'like', '%' . $search . '%');
            })->latest()->take(3)->get(),

            'favorites' => File::where('is_favorite', 1)->get()
        ]);
    }
}
