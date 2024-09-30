<?php

namespace App\Http\Controllers;

use App\Http\Requests\CateRequest;
use App\Models\Category;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();

        return $this->success(['Category'=>$categories]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CateRequest $request)
    {
        $data = $request->validated();

        $category = Category::create($data);

        return $this->success(['Category'=>$category]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return $this->success(['Category'=>$category]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CateRequest $request, Category $category)
    {
        $data = $request->validated();
        $category->update($data);
        return $this->success(['Category'=>$category]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return $this->success(null,code:204);
    }

}
