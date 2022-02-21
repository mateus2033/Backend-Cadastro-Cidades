<?php

namespace App\Entities\Cityes;

use App\Utils\ErrosEnum;

/**
 * @property string  $name
 * @property int     $iso_ddd
 * @property int     $population
 * @property int     $income_per_capital
 * @property int     $state_id
 * @property boolean $isValid
 * @property array   $mensage
 */
class CityesEntitie{


    private $id;
    private string $name;
    private int    $iso_ddd;
    private int    $population;
    private int    $income_per_capital;
    private bool   $isValid;
    public  array  $mesage;



    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getIso_ddd()
    {
        return $this->iso_ddd;
    }

    public function getPopulation()
    {
        return $this->population;
    }

    public function getIncomePerCapital()
    {
        return $this->income_per_capital;
    }


    public function setId($e)
    {
        $this->id = $e;
    }

    public function setName($e)
    {
        $this->name = $e;
    }

    public function setIso_ddd($e)
    {
        $this->iso_ddd = $e;
    }

    public function setPopulation($e)
    {
        $this->population = $e;
    }

    public function setState_id($e)
    {
        $this->state_id = $e;
    }

    public function setIncomePerCapital($e)
    {
        $this->income_per_capital = $e;
    }


    /**
     * Gerencia a criacao do modelo padrao de save do City.
     */
    public static function fromJsonCityes(array $cityes)
    {

        $self = new self();
        $self->validateCity($cityes);

        if($self->isValid)
        {
            $response = $self->_mountCity();
            return $response;

        } else {

            return $self;
        }

    }


    /**
     * Monta um array padrao contendo os dados da cidade.
     * @return array $array
     */
    private function _mountCity()
    {

        $array = array(

            'id'                 => $this->getId(),
            'name'               => $this->getName(),
            'iso_ddd'            => $this->getIso_ddd(),
            'population'         => $this->getPopulation(),
            'income_per_capital' => $this->getIncomePerCapital(),
        );


        return $array;

    }




    /**
     *Valida os dados referente as cidades.
     *@param array $cityes 
     */
    public function validateCity(array $cityes)
    {

        $array = [];

        $array['id']                 = $this->_id($cityes);
        $array['name']               = $this->_name($cityes);
        $array['iso_ddd']            = $this->_iso_ddd($cityes);
        $array['population']         = $this->_population($cityes);
        $array['income_per_capital'] = $this->_income_per_capital($cityes);


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
     * Recebe um array e retorna uma String ou null.
     * @param array $data
     * @return string|null
     */
    private function _id($data)
    { 
          
        if(!isset($data['id']))
        {
            return null;
        }
        
        if(!is_integer($data['id']))
        {
            return ErrosEnum::$olnystrings;
        }
        
        $this->setId($data['id']);
        return null;


    }


    /**
     * Recebe um array e retorna uma String ou null.
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
     * Recebe um array e retorna uma String ou null.
     * @param array $data
     * @return string|null
    */
    private function _iso_ddd($data)
    {
        if(!isset($data['iso_ddd']))
        {
            return ErrosEnum::$required;
        }

        if(!is_int($data['iso_ddd']) || $data['iso_ddd'] < 0)
        {
            return ErrosEnum::$positivenumbers;
        }

        if($data['iso_ddd'] > 100)
        {
            return ErrosEnum::$invalidDDD;
        }

        $this->setIso_ddd($data['iso_ddd']);
        return null;


    }

    /**
     * Recebe um array e retorna uma String ou null.
     * @param array $data
     * @return string|null
    */
    private function _population($data)
    {

        if(!isset($data['population']))
        {
            return ErrosEnum::$required;
        }     

        if(!is_numeric($data['population']) || $data['population'] < 0)
        {
            return ErrosEnum::$positivenumbers;
        }

        $this->setPopulation($data['population']);
        return null;

    }

    /**
     * Recebe um array e retorna uma String ou null.
     * @param array $data
     * @return string|null
     */
    private function _income_per_capital($data)
    {

        if(!isset($data['income_per_capital']))
        {
            return ErrosEnum::$required;
        }    

        if(!is_numeric($data['income_per_capital']) || $data['income_per_capital'] <0)
        {
            return ErrosEnum::$positivenumbers;
        }

        $this->setIncomePerCapital($data['income_per_capital']);
        return null;

    }





}