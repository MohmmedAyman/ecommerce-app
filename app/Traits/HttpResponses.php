<?php

namespace App\Traits;

use Illuminate\Http\Response;

trait HttpResponses{
    protected function success($data,$msg=null,$code=200){
        return Response()->json([
            'status' => 'Succesed Request',
            'message' => $msg,
            'data' => $data
        ],$code);
    }

    protected function erorr($data,$msg=null,$code=500){
        return Response()->json([
            'status' => 'The Request Has Erorr',
            'message' => $msg,
            'data' => $data
        ],$code);
    }

    protected function authorize(int $id){
        if(auth()->user()->id === $id){
            return false;
        }else{
            return $this->erorr("You Don't Have Access On This Page",code:401);
        };
    }
}