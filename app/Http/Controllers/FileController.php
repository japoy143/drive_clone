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
        $path = explode('/', $request->path);
        $current_path = array_slice($path, 2);
        $final_path = join("/", $current_path);

        $last_object = end($path);
        $path_length = count($path);


        $file = File::create([
            'name' => $request->file,
            'is_folder' => 1,
            'created_by' => Auth::id(),
            'updated_by' => Auth::id(),

        ]);


        if ($path[1] === 'file' || $path[1] === 'directory' && $path_length > 2) {
            $node = File::where('name', '=', $last_object)->first();

            //path
            $file->update(['path' => $final_path . '/' . $request->file]);
            $node->appendNode($file);

        } else {
            $file->makeRoot()->save();
        }




    }
}
