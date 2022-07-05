<?php

namespace App\Http\Controllers;

use App\Models\category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends ApiController
{
    public function create(Request $request)
    {
        $category = category::where('c_parent', $request->parent)->orderBy('created_at', 'desc')->first();
        if ($category == null or $category->c_parent == null) {
            $order = '1';
        } else {
            $order = $category->c_order + 1;
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
            'slug' => 'required|string|max:50',
            'status' => 'required|max:2',
            'decription' => 'max:200',
            'image' => 'max:100',
        ]);
        if ($validator->fails()) {
            return $this->errorResponse($validator->messages(), 422);
        }
        category::create([
            'c_name' => $request->name,
            'c_slug' => $request->slug,
            'c_status' => $request->status,
            'c_decription' => $request->decription,
            'c_image' => $request->image,
            'c_parent' => $request->parent,
            'c_order' => $order,
        ]);
        return $this->successResponse('category created', 201);
    }

    public function get_all()
    {
        $categories = Category::with('children')->wherenull('c_parent')->orderby('created_at', 'ASC')->paginate(5);
        $parents = category::where('c_parent', null)->get();
        return $this->successResponse([
            'categories' =>  $categories,
            'parents' =>  $parents,
        ], 201, 'success response');
    }
    public function update_category_status($id, $status)
    {
        category::where('c_id', $id)->orWhere('c_parent', $id)->update(
            [
                'c_status' => $status,
            ]
        );
        return $this->successResponse('category status updated', 201);
    }
}
