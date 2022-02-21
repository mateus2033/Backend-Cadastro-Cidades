<?php

namespace app\Entities\States;

use App\Support\InitialValidationState;
use App\Utils\ErrosEnum;

/**
 *@property string  $name
 *@property string  $initials
 *@property integer $population
 *@property bool    $isValid
 *@property array   $mensage
 */
class StatesEntities{


    private string $name;
    private string $initials;
    private int    $population;
    public  array  $mensage; 
    private $isValid;   



    public function getName()
    {
        return $this->name;
    }

    public function getInitials()
    {
        return $this->initials;
    }

    public function getPopulation()
    {
        return $this->population;
    }

    public function setName($e)
    {
        $this->name = $e;
    }

    public function setInitials($e)
    {
        $this->initials = $e;
    }

    public function setPopulation($e)
    {
        $this->population = $e;
    }




    /**
     * Monta um objeto padronizado.
     */
    public static function fromJsonState(array $states)
    {
        $self = new self();
        $self->valiatedState($states);

        if($self->isValid)
        {
            $objeto = $self->rideState();
            return $objeto;

        } else {

            return $self;

        }

    }


    /**
     * Apos a validacao monta um array padrao para o state
     * @return array $array
     */
    public function rideState()
    {

        $array = array(

            'name'       =>$this->getName(),
            'initials'   =>$this->getInitials(),
            'population' =>$this->getPopulation()

        );


       return $array;


    }


    /**
     * Valida os dados referente ao estado informado no Front-End.
     */
    public function valiatedState(array $state)
    {
        
        $array = [];
       
        
        $array['name']          =$this->_name($state);       
        $array['initials']      =$this->_initials($state);
        $array['population']    =$this->_population($state);
        
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
     * Recebe um array e retorna uma string ou null
     * @param array $data
     * @return string|null
     */
    private function _name($data)
    {

        if(!isset($data['name']))
        {
            return ErrosEnum::$required;
        }

        if(!is_string($data['name']))
        {
            return ErrosEnum::$olnystrings;
        }

        $this->setName($data['name']);

        return null;

    }

    /**
     * Recebe um array e retorna uma string ou null
     * @param array $data
     * @return string|null
    */
    private function _initials($data)
    {
        
        if(!isset($data['initials']))
        {
            return ErrosEnum::$required;
        }

        if(!is_string($data['initials']))
        {
            return ErrosEnum::$olnystrings;
        }

        if(!InitialValidationState::validateInitials($data['initials']))
        {
            return ErrosEnum::$initialinvalid;
        }

        $this->setInitials($data['initials']);

        return null;

    }

    /**
     * Recebe um array e retorna uma string ou null
     * @param array $data
     * @return string|null
    */
    private function _population($data)
    {
        
        if(!isset($data['population']))
        {
            return ErrosEnum::$required;
        }

        if(!is_numeric($data['population']))
        {
            return ErrosEnum::$onlynumbers;
        }

        $this->setPopulation($data['population']);

        return null;


    }




}