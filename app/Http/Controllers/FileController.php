<?php

namespace App\Http\Controllers;

use App\Http\Requests\FileRequest;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FileController extends Controller
{
    public function saveFile(FileRequest $request)
    {

        $file = File::create([
            'name' => $request->file,
            'is_folder' => 1,
            'created_by' => Auth::id(),
            'updated_by' => Auth::id(),

        ]);

        if ($request->parent) {
            $node = File::find($request->parent);

            $node->appendNode($file);

            dd('save');
        }


        dd('hello');
    }
}
