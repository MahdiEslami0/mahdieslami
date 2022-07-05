<?php

namespace App\Http\Controllers;

use Defuse\Crypto\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UploaderController extends ApiController
{
    public function image(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:5000',
        ]);
        if ($validator->fails()) {
            return $this->errorResponse($validator->messages(), 422);
        }
        $imageName = time() . '.' . $request->image->extension();
        $request->image->move(public_path('uploads/images'), $imageName);
        return $this->successResponse([
            'image' =>   $imageName,
        ], 201);
    }
    public function get_images()
    {
        $imageDir = public_path('uploads/images');
        $images = preg_grep('~\.(jpeg|jpg|png)$~', scandir($imageDir));
        return $this->successResponse([
            'image' =>  $images,
        ], 201);
    }
    public function delete_images(Request $request)
    {
        unlink($request->path);
        return $this->successResponse('done', 201);
    }
}
