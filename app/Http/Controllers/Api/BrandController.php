<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Middleware\EnsureUserIsAdmin;
use App\Http\Requests\StoreBrandRequest;
use App\Http\Requests\UpdateBrandRequest;
use App\Http\Resources\BrandRresource;
use App\Traits\HttpResponses;
use App\Models\Brand;

class BrandController extends Controller
{
    use HttpResponses;

    public function __construct(){
        $this->middleware([EnsureUserIsAdmin::class],['except' => ['index','show']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->success('BrandController@index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBrandRequest $request)
    {
        try {
            $data = $request->validated();
            $logo_path = $request->file("logo_path")->store('logs','public');
            $data['logo_path'] = $logo_path;
            $user_id = auth()->user()->id;
            if(Brand::where('user_id',$user_id)->first()){
                throw new \Exception('You can not create more than one brand');
            };
            $data['user_id'] = $user_id;
            $res = Brand::create($data);
            return $this->success(new BrandRresource($res));
        } catch (\Exception $e) {
            return $this->erorr($e->getMessage(),code:404);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return $this->success(new BrandRresource(Brand::find($id)));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBrandRequest $request, Brand $brand)
    {
        if($this->authorize($brand->user_id)){
            return $this->authorize($brand->user_id);
        };
        
        $data = $request->validated();
        if(empty($data)){ 
            return $this->erorr('No data to update',code:404);
         }else{
            try{
                $logo_path = $request->file("logo_path")?file("logo_path")->store('logs','public'):null;
                $logo_path? $data['logo_path'] = $logo_path : null;
                $brand->update(array_filter($data));
                return $this->success(new BrandRresource($brand));
            }catch(\Exception $e){
                return $this->erorr($e->getMessage(),code:404);
         } 
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
