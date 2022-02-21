<?php

namespace app\Entities\People;

use App\Support\CpfValidation;
use App\Support\InitialValidationState;
use App\Utils\ErrosEnum;

/**
 * @property string $name
 * @property string $cpf
 * @property string $state
 * @property string $city
 * @property array  $mensage
 * @property bool   $isValid
 */
class PeopleEntities {


    private string $name;
    private string $cpf;
    private string $state;
    private string $city;
    public $mensage;
    public $isValid;


    public function getName()
    {
        return $this->name;
    }

    public function getCpf()
    {
        return $this->cpf;
    }

    public function getState()
    {
        return $this->state;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function setName($e)
    {   
        $this->name = $e;
    }

    public function setCpf($e)
    {
        $this->cpf = $e;
    }

    public function setState($e)
    {
        $this->state = $e;
    }

    public function setCity($e)
    {
        $this->city = $e;
    }




    public static function fromJsonPeople(array $people)
    {

        $self = new self();
        $self->validatePeople($people);

        if($self->isValid)
        {
            $response = $self->_mountPeople();
            return $response;

        } else {

            return $self;
        }
        
    }



    /**
     * Monta um array padrao contendo os dados da cidade.
     * @return array $array
     */
    private function _mountPeople()
    {

        $array = array(

            'name'   => $this->getName(),
            'cpf'    => $this->getCpf(),
            'state'  => $this->getState(),
            'city'   => $this->getCity(),
        );

        return $array;

    }




    /**
     *Valida os dados referente as cidades.
     *@param array $cityes 
     */
    public function validatePeople(array $people)
    {

        $array = [];
        $array['name']  = $this->_name($people);
        $array['cpf']   = $this->_cpf($people);
        $array['state'] = $this->_state($people);
        $array['city']  = $this->_city($people);


        $array =  array_filter($array, function($data)
        {
            return $data != null;
        });

        $response = !empty($array);

        if($response)
        {
            $this->mensage = $array;
            $this->isValid = false;

        } else { 

            $this->mensage = [];
            $this->isValid = true;

        }
        

    }



    /**
    *Valida os dados referente as cidades.
    *@param array $people 
    */
    private function _name($people) 
    {

        if(!isset($people['name']))
        {
            return ErrosEnum::$required;
        }

        if(!is_string($people['name']))
        {
            return ErrosEnum::$olnystrings;
        }

        $this->setName($people['name']);

        return null;

    
    }


    /**
    *Valida os dados referente as cidades.
    *@param array $people 
    */
    private function _cpf($people)  
    {

        if(!isset($people['cpf']))
        {
            return ErrosEnum::$required;
        }

        if(!is_string($people['cpf']))
        {
            return ErrosEnum::$olnystrings;
        }

        $cpf = new CpfValidation();
        $cpf = $cpf->validarCPF($people['cpf']);
        
        if($cpf){

            $this->setCpf($cpf);
        }

        return null;

    }


    /**
    *Valida os dados referente as cidades.
    *@param array $people 
    */
    private function _state($people)
    {

        if(!isset($people['state']))
        {
            return ErrosEnum::$required;
        }

        if(!is_string($people['state']))
        {
            return ErrosEnum::$olnystrings;
        }

        $initial = InitialValidationState::validateInitials($people['state']);

        if(!$initial)
        {
           return ErrosEnum::$initialinvalid;
        }

        $this->setState($people['state']);
        return null;
    
    }


    /**
    *Valida os dados referente as cidades.
    *@param array $people 
    */
    private function _city($people) 
    {

        if(!isset($people['city']))
        {
            return ErrosEnum::$required;
        }

        if(!is_string($people['city']))
        {
            return ErrosEnum::$olnystrings;
        }

        $this->setCity($people['city']);

        return null;
    
    }








}