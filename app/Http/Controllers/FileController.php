<?php

namespace App\Http\Controllers;

use App\Http\Requests\FileRequest;
use App\Jobs\UploadFileJob;
use App\Models\File;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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

    //upload file
    public function uploadFile(Request $request)
    {
        $path = explode('/', $request->path);


        $last_object = end($path);
        $path_length = count($path);

        foreach ($request->file('files') as $key => $item) {
            $file_name = $item->getClientOriginalName();
            $mime = $item->getClientOriginalExtension();

            $file = File::create([
                'name' => $file_name,
                'is_folder' => 0,
                'created_by' => Auth::id(),
                'updated_by' => Auth::id(),
                'mime' => $mime,

            ]);

            $file_path = $item->storeAs('uploads', $file_name);
            $storage_path = Storage::url($file_path);


            if ($path[1] === 'file' || $path[1] === 'directory' && $path_length > 2) {
                $node = File::where('name', '=', $last_object)->first();

                //path
                $file->update(['path' => $storage_path]);
                $node->appendNode($file);

            } else {
                //path
                $file->update(['path' => $storage_path]);
                $file->makeRoot()->save();
            }
        }
    }

}
