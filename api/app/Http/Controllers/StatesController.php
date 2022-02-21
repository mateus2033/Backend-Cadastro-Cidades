<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repository\StateRepository;
use App\Models\States;
use App\Models\Cityes;
use Illuminate\Support\Facades\DB;

class StatesController extends Controller
{

    protected $statesRepository;
    protected $stateModel;
    protected $cityesModel;

    public function __construct(Cityes $cityesModel, States $stateModel, StateRepository $statesRepository)
    {
        $this->statesRepository = $statesRepository;
        $this->stateModel   = $stateModel;
        $this->cityesModel  = $cityesModel;
    }
    
   
    public function index(Request $request)
    {
        $reponse = $this->statesRepository->index($request);
        return response($reponse, $reponse['code']);

    }

 
    public function storage(Request $request)
    {

        $array[0] = [];
      
        $state  = $request->only($this->stateModel->getModel()->getFillable());
        empty($request->cityes) ? $cityes = $array : $cityes  = $request->cityes;
        
        DB::beginTransaction();
        $reponse = $this->statesRepository->manageSave($state, $cityes);

        if($reponse['code'] == 201)
        {
            DB::commit();
            return response($reponse, $reponse['code']);

        } else {

            DB::rollBack();
            return response($reponse, $reponse['code']);

        }

    }


    public function show(Request $request)
    {

        $cityName  = $request->name;
        $reponse   = $this->statesRepository->getCity($cityName);
        return response($reponse, $reponse['code']);

    }

 


    public function update(Request $request)
    {
        $array[0] = [];
      
        isset($request->state_id) ? $state   = $request->state_id : $state = 0;
        empty($request->cityes)   ? $cityes  = $array : $cityes  = $request->cityes;
        
        DB::beginTransaction();
        $reponse = $this->statesRepository->manageUpdate($state, $cityes);

        if($reponse['code'] == 200)
        {
            DB::commit();
            return response($reponse, $reponse['code']);

        } else {

            DB::rollBack();
            return response($reponse, $reponse['code']);

        }
    }

  
}
