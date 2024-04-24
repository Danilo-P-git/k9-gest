<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Requests\DataTableRequest;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index(DataTableRequest $request)
    {

        $categories = Category::orderBy($request->sort, $request->order)->paginate($request->page);
        return response()->json($categories);
    }
    public function getAll()
    {
        $categories = Category::all();
        return response()->json($categories);
    }
    public function store(CategoryRequest $request)
    {
        $category_id = $request->id;
        $category_name = $request->name;
        $category = Category::find($category_id);
        if ($category) {
            $category->name = $category_name;
            $category->save();
            return response()->json($category);
        } else {
            $category = new Category();
            $category->name = $category_name;
            $category->save();
            return response()->json($category);
        }
    }
}
