<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\prosearchRequest;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\Maincategory;
use App\Models\Product;
use App\Traits\HttpResponses;
use GuzzleHttp\Psr7\Query;
use Illuminate\Http\Request;

class searchController extends Controller
{
    use HttpResponses;

    public function productsearch(prosearchRequest $request){
        // nameOfProduct - nameOfBrand - category - mainCatergory - color - size - price
        
        $request->validated();
        $filters = $request->only(['query','category','Mcategory','start_price','end_price']);
        $product = Product::Query();

        if(!empty($filters['query'])){
            $product->where(function ($query) use ($filters){
                $query->where('pro_name','like','%'. $filters['query'] .'%')
                      ->orWhere('pro_description','like','%'. $filters['query'] .'%');
            });
        }

        // if(!empty($filters['brand_name'])){
        //     $product->where()
        // }
        
        if(!empty($filters['Mcategory'])){
            $McategoryId = Maincategory::where('mcate_name',$filters['Mcategory'])->pluck('id')->toArray();
            !empty($McategoryId) ? $product->whereIn('pro_maincategory',$McategoryId) : null;
        }

        if(!empty($filters['category'])){
            $categoryId = Category::where('cate_name',$filters['category'])->pluck('id')->toArray();
            !empty($categoryId) ? $product->whereIn('pro_category',$categoryId) : null;
        }

        if(isset($filters['start_price'],$filters['end_price'])){
            $product->whereBetween('pro_price',[$filters['start_price'], $filters['end_price']]);
        }

        $result = $product->with(['Category','Maincategory'])->get();

        if($result->isEmpty()){
            return $this->success('No items fount here');
        }

        return $this->success(ProductResource::collection($result),'success');

    }

}
