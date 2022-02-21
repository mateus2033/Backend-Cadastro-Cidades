<?php

namespace App\Utils;

class HandlerMessager{


    /**
    * @param int    $code 
    * @param string $object
    * @param array  $message
    * @return array
    */
    static public function sucessMessage(int $code, array $object, $message)
    {   
        return ['data'=>$object, 'message'=>$message, 'code'=>$code];
    }


    /**
    * @param int    $code
    * @param array  $message
    * @param string $error
    * @return array
    */
    static public function errorMessage(int $code, array $message, $error)
    {   
        return ['message'=>$message,'error'=>$error,'code'=>$code];
    }


    /**
     * @param int $code
     * @param string $message
     * @return array
     */
    static public function genericError(int $code, string $message)
    {
        return ['message'=>$message, 'code'=>$code];
    }









}