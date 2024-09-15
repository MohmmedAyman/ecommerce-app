<?php

namespace App\Http\Controllers;

use App\Http\Requests\CateRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();

        return $this->json($categories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CateRequest $request)
    {
        $data = $request->validated();

        $category = Category::create($data);

        return $this->json($category);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return $this->json($category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CateRequest $request, Category $category)
    {
        $data = $request->validated();
        $category->update($data);
        return $this->json($category);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return $this->json();
    }

    private function json($data =null){
        if(!$data){
            return response()->json([
                'status' => true
            ]);
        }
        return response()->json([
            'status' => true,
            'data' =>[
                'Category' => $data
            ]
            ]);

    }
}
