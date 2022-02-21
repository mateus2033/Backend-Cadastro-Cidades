<?php

namespace App\Repository;

use App\Entities\Cityes\CityesEntitie;
use App\Interfaces\CityesInterface;
use App\Models\Cityes;
use App\Utils\ErrosEnum;
use App\Utils\HandlerMessager;
use Exception;

class CityesRepository implements CityesInterface{



    /**
     * Valida os dados referente a cidade informada e retorna um objeto padrao.
     * @param array $cityes
     */
    public function fromJsonCityes(array $cityes)
    {
        
        $response = CityesEntitie::fromJsonCityes($cityes);
        
        if(isset($response->mensage))
        {
            $response = json_encode($response->mensage);
            throw new Exception($response, 400);   

        } else {
            return $response;
        }

    }



    /**
     * Caso seja informado algun ID referente a cidades, este metodo o removera.
     * @param array $cityes
     */
    public function removeIdFromCityes(array $cityes)
    {

        $array = [];

        foreach($cityes as $city){

            unset($city['id']);
            $array[] = $city;
        
        }
  
        return $array;

    }



    /**
     * @param array $cityes
     * @param int $state_id
     */
    public function manageStorageCity(array $cityes, int $state_id)
    {
       
        $responseCityes = $this->generateFromJson($cityes);
        $cityes         = $this->removeIdFromCityes($responseCityes);
        $citysaved      = $this->saveCity($cityes, $state_id);
        return true;

    }


    /**
     * Manda para o fromJsonCityes atraves do foreach
     * @param array $cityes
     */
    public function generateFromJson(array $cityes)
    {
        
        $array = [];
        foreach($cityes as $city){

            $response = $this->fromJsonCityes($city);
            $array[]  = $response;

        }

        return $array;
            
    }


    /**
     * Salva e associa a cidade com o estado criado anteriormente.
     * @param array $responseCityes
     */
    public function saveCity(array $responseCityes, int  $state_id)
    {
        
        foreach($responseCityes as $city){
            
           $response = Cityes::create($city);
           $response->state()->associate($state_id);
           $response->save();

        }
        
        return true;

    }



    /**
     * Valida o nome da cidade.
     */
    public function validaCityName($cityName)
    {

        if(is_null($cityName))
        {
           return HandlerMessager::genericError(404,"Cidade não informada.");
        }


        if(!is_string($cityName))
        {
            return HandlerMessager::genericError(400,"Esta campo deve conter apernas caracteres.");
        }

        return $cityName;

    }



    /**
     * Busca a cidade informada juntamente com seu estado associado.
     */
    public function getCityWithState($cityName)
    {

        $city = $this->validaCityName($cityName);
        if(is_array($city))
        {   
            throw new Exception($city['message'], $city['code']);
        }

        
        $response = Cityes::where('name', $cityName)->get();
        if(!$response->isEmpty())
        {
            $response->load('state');
            return $response;
        }

        throw new Exception("Cidade não encontrada.",404);
       
    }



    /**
     * Busca a cidade no objeto state e atualiza.
     */
    public function updateCity(object $state, array $cityes)
    {


        foreach($cityes as $city){

            $update = $state->city()->where('id',[$city['id']])->first();
            
            if(!$update)
            {
                throw new Exception("Esta cidade não pertence ao ESTADO informado.",406);
            } 
                
            $update->update($city);
            $update->save();
            
        }

        return true;

    }



    /**
     * Gerencia o processo de update das cidades.
     * @param object $state
     * @param array  $cityes
     */
    public function manageUpdateCity($state, array $cityes)
    {
      
        $response = $this->generateFromJson($cityes);
        $update   = $this->updateCity($state, $response);
        return true;
        

    }


}