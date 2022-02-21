<?php

namespace App\Repository;

use App\Entities\People\PeopleEntities;
use App\ExceptionsErros\MyExceptionsErros;
use App\Interfaces\PeopleInterface;
use App\Models\People;
use App\Models\States;
use App\Utils\ErrosEnum;
use App\Utils\HandlerMessager;
use Exception;

use function PHPUnit\Framework\isEmpty;

class PeopleRepository implements PeopleInterface{ 

   
    /**
     * Retorna a listagem das cidades por estado.
     * @param object $data
     */
    public function index($data)
    {


        $paginate = $data->get('paginate');
        $paginate ? $paginate : $paginate = 10;
        $index = People::paginate($paginate);
        $index->load('state');
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
     * Verifica se a pessoa informada está cadastrada.
     */
    public function show($id)
    {

        if(!isset($id))
        {
           return HandlerMessager::errorMessage(404,["Pessoa não informado."],[ErrosEnum::$genericErroMessage]);
        }

        $response = People::Find($id);
        
        if($response == null)
        {
            return HandlerMessager::errorMessage(404,["Pessoa não encontrada."],[ErrosEnum::$genericErroMessage]);
        }


        $response->load('state');
        return HandlerMessager::sucessMessage(200,[$response],[ErrosEnum::$sucessoperation]);


    }



    /**
     * Valida os dados referentes ao estado
     * @param array $people
     * @return array|Exception
     */
    public function fromJsonPeople(array $people)
    {

        $stateresponse =  PeopleEntities::fromJsonPeople($people);

        if(isset($stateresponse->mensage))
        {
            $response = json_encode($stateresponse->mensage);
            throw new Exception($response, 400);
            
        } else {

            return $stateresponse;

        }
   
    }



    /**
     * Pesquisa os campos informados de city e state.
     * @param array $responsePeople
     */
    public function mountRelationPeople(array $responsePeople)
    {

        $state = $responsePeople['state'];
        $city  = $responsePeople['city'];

        $response = States::
        join('cityes','cityes.state_id', 'states.id')
       ->where('states.initials', $state)
       ->where('cityes.name',$city)->get();
        
        if($response->isEmpty()){
            
            throw new Exception("Cidade ou estado não encontrado.",404);

        } 

        $array = array(
            'response'       => $response->first()->state_id,
            'responsePeople' => $responsePeople
        );
        
        return $array;

    }



    /**
     * Salva e associa objeto pessoa com estado.
     */
    public function savePeople(array $array)
    {
       
        $state_id = $array['response'];
        $people   = $array['responsePeople']; 


        $response = People::create($people);
        $response->state()->associate($state_id);
        $response->save();
        $response->load('state');

        return $response;


    }



    /**
     * Gerencia o processo de save de People.
     * @param array $people
     */
    public function manageSave(array $people)
    {

        try {
            
            $responsePeople = $this->fromJsonPeople($people);
            $response       = $this->mountRelationPeople($responsePeople);
            $saved          = $this->savePeople($response);
            return HandlerMessager::sucessMessage(201,[$saved],[ErrosEnum::$sucessoperation]);

        } catch (\Exception $e) {
            
            return MyExceptionsErros::errosExceptions($e->getCode(), $e->getMessage());
        }

    }




    /**
     * Gerencia o processo de delete de People.
     */
    public function manegeDelete($id)
    {

        try {
           
            $people = $this->show($id);
            if(!isset($people['error']))
            {
                $delete =  $this->deletePeople($people['data']);
                return HandlerMessager::sucessMessage(200,['Pessoa deletada.'],[ErrosEnum::$sucessoperation]);
            }

            return $people;

        } catch (\Exception $e) {
            


        }


    }


    /** 
     * Desassocia e delete people.
    */
    public function deletePeople($people)
    {

        $people = $people[0];
        $people->state()->dissociate();
        $people->save();

        People::destroy($people->id);
        return true;


    }



}