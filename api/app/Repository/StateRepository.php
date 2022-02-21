<?php

namespace App\Repository;

use App\Entities\States\StatesEntities;
use App\Repository\CityesRepository;
use App\ExceptionsErros\MyExceptionsErros;
use App\Interfaces\StatesInterface;
use App\Models\States;
use App\Utils\ErrosEnum;
use App\Utils\HandlerMessager;
use Exception;

class StateRepository implements StatesInterface{


    protected $cityDomain;


    public function __construct(CityesRepository $cityDomain)
    {
        $this->cityDomain = $cityDomain;
    }





    /**
     * Retorna a listagem das cidades por estado.
     * @param object $data
     */
    public function index($data)
    {


        $paginate = $data->get('paginate');
        $paginate ? $paginate : $paginate = 10;
        $index    = States::paginate($paginate);
        
        $index->load('city');
        try {  

            if (!$index) {
                return HandlerMessager::errorMessage(400, [$index], ["Erro ao carregar alunos."]);
            }

            return HandlerMessager::sucessMessage(200, [$index], ["Operação realizada com sucesso."]);
            
        } catch (Exception $e) {
            return MyExceptionsErros::errosExceptions($e->getCode(), $e->getMessage());
        }

    }


    /**
     * Valida os dados referentes ao estado
     * @param array $state
     * @return array|Exception
     */
    public function fromJsonState(array $state)
    {

        $stateresponse =  StatesEntities::fromJsonState($state);

        if(isset($stateresponse->mensage))
        {
            $response = json_encode($stateresponse->mensage);
            throw new Exception($response, 400);
            
        } else {

            return $stateresponse;

        }
   
    }


    /**
     * Busca o estado criado juntamente com suas cidades associadas.
     */
    public function getRelations(int $state_id)
    {
        
        if($state_id == 0)
        {
            throw new Exception("Estado não informado.", 400);

        }

           $response = States::Find($state_id);
           if($response)
           {
             $response->load('city');
             return $response;
           }
           
        throw new Exception("Estado não localizado.",404);

    }




    /**
     * Gerencia o save das cidades por estado
     * @param array $states
     * @param array $cityes
     */
    public function manageSave(array $state, array $cityes)
    {

        try{

            $responseState = $this->fromJsonState($state);
            $responseState = States::create($responseState);
            $responseCity  = $this->cityDomain->manageStorageCity($cityes, $responseState->id);
            $serach        = $this->getRelations($responseState->id);
            
            return HandlerMessager::sucessMessage(201,[$serach],[ErrosEnum::$sucessoperation]);

        }catch(Exception $e){

            return MyExceptionsErros::errosExceptions($e->getCode(), $e->getMessage());
        }

    }



    /**
     * Gerencia o update das cidades por estado
     * @param array $states
     * @param array $cityes
     */
    public function manageUpdate(int $state, array $cityes)
    {

        try {
            
            $state      = $this->getRelations($state);
            $cityUpdate = $this->cityDomain->manageUpdateCity($state, $cityes);
            $cityUpdate = States::Find($state->id)->load('city');
            return HandlerMessager::sucessMessage(200,[$cityUpdate],[ErrosEnum::$sucessoperation]);

        } catch (\Exception $e) {
            
            return MyExceptionsErros::errosExceptions($e->getCode(), $e->getMessage());
        }

    }



    /**
     * Gerencia o processo de busca da cidade.
     */
    public function getCity($cityName)
    {

        try {

            $response = $this->cityDomain->getCityWithState($cityName);
            return HandlerMessager::sucessMessage(200,[$response],[ErrosEnum::$sucessoperation]);
            

        } catch (\Exception $e) {
            
            return MyExceptionsErros::errosExceptions($e->getCode(), $e->getMessage());
        }



    }




}
