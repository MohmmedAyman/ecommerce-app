<?php

namespace App\Http\Controllers;

use App\Models\Maincategory;
use Illuminate\Http\Request;
use App\Http\Requests\McateRequest;
use Exception;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Exceptions\HttpResponseException;

class Maincategoryv2Controller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $maincategories = Maincategory::all();
        return response()->json([
            'status' => true,
            'data' =>[
                'Main Categories' => $maincategories
            ],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(McateRequest $request)
    {
        $data = $request->validated();

        $mcate = Maincategory::create($data);

        return response()->json([
            'status' => true,
            'data' => [
                'Main Category' => $mcate
            ]
            ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Maincategory $maincategory)
    {
        try{
            return response()->json([
                'status' => true,
                'data' => [
                    'Main Category' => $maincategory
                ]
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
        return response()->json([
            'status' => true,
            'data' => [
                'Main Category' => $maincategory
            ]
            ]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Maincategory $maincategory)
    {
        $maincategory->delete();
        return response()->json([
            'status' => true,
        ]);
    }
}
