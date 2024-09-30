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

    protected function erorr($data,$msg=null,$code){
        return Response()->json([
            'status' => 'The Request Has Erorr',
            'message' => $msg,
            'data' => $data
        ],$code);
    }
}