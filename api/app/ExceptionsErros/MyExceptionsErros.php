<?php

namespace App\ExceptionsErros;

use App\Utils\ErrosEnum;
use App\Utils\HandlerMessager;

class MyExceptionsErros{


    /**
     * Retorna uma MenssagemException com base no codigo informado originado da classe Exception no try catch.
     * @param int $code
     * @param strinf $message
     * @return string
     */
    public static function errosExceptions(int $code, string $message)
    {
        
        switch ($code) {

            case '400':
                return HandlerMessager::errorMessage($code,[$message],ErrosEnum::$genericErroMessage);
                break;

            case '404':
                return HandlerMessager::errorMessage($code,[$message],ErrosEnum::$genericErroMessage);
                break;

            case '406':
                return HandlerMessager::errorMessage($code,[$message],ErrosEnum::$genericErroMessage);
                break;
                
            default:
                return HandlerMessager::errorMessage(400,["Erro"], ErrosEnum::$genericErroMessage);
                break;
        }

    }

}