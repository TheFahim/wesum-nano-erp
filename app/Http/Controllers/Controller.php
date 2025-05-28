<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

abstract class Controller
{
    public function fileSave($file, $directoryPath, $fileName = null)
    {

        if (!File::exists($directoryPath)) {
            File::makeDirectory($directoryPath, 0755, true);
        }


        if ($file) {

            if ($fileName) {
                $final_name = time() . '-' . uniqid() . '-' . $fileName . '.' . $file->getClientOriginalExtension();
            } else {
                $final_name = time() . '-' . uniqid() . '-' . $file->getClientOriginalName();
            }

            $file->move(public_path($directoryPath), $final_name);

            return $directoryPath.'/'.$final_name;
        }

    }

    public function fileUpdate($file, $directoryPath, $oldFilePath, $fileName = null)
    {
        $hasFile = $file ?? false;

        if (!$hasFile && File::exists($oldFilePath)) {

            File::delete($oldFilePath);

            return null;

        }
        if ($hasFile && !File::exists($oldFilePath)) {

            return $this->fileSave($file, $directoryPath, $fileName);
        }


        if ($hasFile && File::exists($oldFilePath)) {


            $fileWithPath = 'uploads/team_members/'.$file->getClientOriginalName();

            if ($hasFile && $fileWithPath !== $oldFilePath) {

                File::delete($oldFilePath);

                return $this->fileSave($file, $directoryPath, $fileName);
            } else {
                return $oldFilePath;
            }

        }

    }

    public function checkUserPermission($permission)
    {

        if (!(Auth::user()->can($permission))) {
            abort(403);
        }

    }
}
