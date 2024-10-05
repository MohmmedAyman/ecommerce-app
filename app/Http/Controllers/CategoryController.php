<?php

namespace App\Http\Controllers;

use App\Http\Middleware\EnsureUserIsAdmin;
use App\Http\Requests\CateRequest;
use App\Models\Category;
use App\Traits\HttpResponses;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class CategoryController extends Controller implements HasMiddleware
{
    use HttpResponses;

    public static function middleware(): array
    {
        return [
            'auth:sanctum',
            new Middleware(EnsureUserIsAdmin::class, except: ['index','show']),
        ];
    }


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
