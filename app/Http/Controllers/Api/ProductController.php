<?php

namespace App\Http\Controllers\Api;
use App\Http\Middleware\EnsureUserIsAdmin;
use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Traits\HttpResponses;
use Illuminate\Routing\Controller;
use App\Http\Resources\ProductCollection;


class ProductController extends Controller 
{
    use HttpResponses;

    // there is another way to do middleware on Controller look on CategoryController
    public function __construct(){
        $this->middleware([EnsureUserIsAdmin::class],['except' => ['index','show']]);
    }

    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->success(new ProductCollection(Product::all()->keyBy->id));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();
        $data['brand_id'] = auth()->user()->brand->id;
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
        if($result = $this->authorize($product->brand->user_id)){
            return $result;
        }
        $data = $request->validated();

        $product->update(array_filter($data));

        return $this->success(new ProductResource($product));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        if($result = $this->authorize($product->brand->user_id)){
            return $result;
        }
        $product->delete();
        return $this->success(null,code:204);
    }

  
}
