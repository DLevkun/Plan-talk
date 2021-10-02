<?php

namespace App\Http\Traits;

trait UploadsFiles
{
    protected function uploadFile($method, $request, $fileName, $folder)
    {
        if($request->isMethod($method)){
            if($request->hasFile($fileName)){
                $extension = $request->file($fileName)->extension();
                $file = $request->file($fileName);
                $img_name = rand().".".$extension;
                $path = "/img/{$folder}/";
                $file->move(public_path().$path, $img_name);
                $img_path = $path.$img_name;
            }else{
                $img_path = null;
            }
        }
        return $img_path;
    }
}
