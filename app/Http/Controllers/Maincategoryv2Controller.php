<?php

namespace App\Http\Controllers;

use App\Http\Middleware\EnsureUserIsAdmin;
use App\Models\Maincategory;
use App\Http\Requests\McateRequest;
use App\Traits\HttpResponses;
use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;

class Maincategoryv2Controller extends Controller implements HasMiddleware
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
    public function index(Request $request)
    {
        $maincategories = Maincategory::all();
        return $this->success([
            'Main Categories' => $maincategories,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(McateRequest $request)
    {
        $data = $request->validated();

        $mcate = Maincategory::create($data);

        return $this->success([
            'Main Category' => $mcate
        ],code:201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Maincategory $maincategory)
    {
        try{
            return $this->success([
                'Main Category' => $maincategory
            ]);
        }catch(Exception $e){
            $response = response()->json([
                'status' => false,
                'error' => 'No data',
            ]);
            throw new HttpResponseException($response);
        }
           
        
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(McateRequest $request, Maincategory $maincategory)
    {
        $data = $request->validated();
        $maincategory->update($data);
        return $this->success([
            'Main Category' => $maincategory
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Maincategory $maincategory)
    {
        $maincategory->delete();
        return $this->success(null,code:204);
    }
}
