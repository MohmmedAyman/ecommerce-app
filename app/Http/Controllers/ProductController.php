<?php

namespace App\Http\Controllers;

use App\Http\Middleware\EnsureUserIsAdmin;
use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Traits\HttpResponses;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class ProductController extends Controller implements HasMiddleware
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
        return $this->success(ProductResource::collection(Product::all()));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();

        $pro = Product::create($data);
        return $this->success(new ProductResource($pro));
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return $this->success(new ProductResource($product));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $data = $request->validated();

        $product->update($data);

        return $this->success(new ProductResource($product));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return $this->success(null,code:204);
    }

  
}
