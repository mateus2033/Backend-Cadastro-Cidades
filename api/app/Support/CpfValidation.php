<?php

namespace app\Support;

use App\Models\People;
use Exception;

class CpfValidation {

    protected $modelPeople  = People::class;
  

    /**
     * Valida o CPF informado.
     * @param string $cpf
     * @return $cpf|Exception
     */
    public function validarCPF(string $cpf)
    {
    
        
        $cpf = preg_replace('/[^0-9]/is', '', $cpf);

        if (strlen($cpf) != 11) {
            throw new Exception("CPF inválido", 406);
        }


        if (preg_match('/(\d)\1{10}/', $cpf)) {
            throw new Exception("CPF inválido", 406);
        }

        for ($t = 9; $t < 11; $t++) {

            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                throw new Exception("CPF inválido", 406);
            }
        }

        $getCPF = $this->getCPF($cpf);

        if(!empty($getCPF))
        {
            throw new Exception("CPF já cadastrado.", 400);
        }

        return $cpf;


    }


    /**
     * Valida identidade do CPF no banco de dados.
     * @param int $cpf
     * @return $cpf|null
     */
    public function getCPF(int $cpf)
    {
        $cpf = $this->modelPeople::where('cpf','=', $cpf)->first();
        return $cpf;
        
    }



}