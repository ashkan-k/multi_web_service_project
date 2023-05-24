<?php

namespace App\Http\Traits;

use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

trait Uploader
{
    private function Upload($file , $base_folder , $folder)
    {
        $year = Carbon::now()->year;
        $mouth = Carbon::now()->month;
        $day = Carbon::now()->day;

        $imagePath = "/uploads/{$base_folder}/{$year}-{$mouth}-{$day}/{$folder}/";
        $filename = Str::random(20) . '-' . time() . '.' . $file->getClientOriginalName();

        $file->move(public_path($imagePath) ,$filename);
        return $imagePath . $filename;
    }

    public function UploadFile($request, $name, $base_folder , $folder, $default=null)
    {
        $file = $request->hasFile($name) ? $this->Upload($request->file($name) , $base_folder, $folder) : $default;
        return $file;
    }
}
