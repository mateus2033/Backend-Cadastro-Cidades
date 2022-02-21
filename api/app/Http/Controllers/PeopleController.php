<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\People;
use App\Repository\PeopleRepository;
use Illuminate\Support\Facades\DB;

class PeopleController extends Controller
{


    protected $peopleDomain;
    protected $peopleModel;

    public function __construct(PeopleRepository $peopleDomain, People $peopleModel)
    {
        $this->peopleDomain = $peopleDomain;
        $this->peopleModel  = $peopleModel; 
    }



    public function index(Request $request)
    {       
        $response = $this->peopleDomain->index($request);
        return response($response, $response['code']);

    }



    public function storage(Request $request)
    {
    
        $people  = $request->only($this->peopleModel->getModel()->getFillable());
         
        DB::beginTransaction();
        $reponse = $this->peopleDomain->manageSave($people);

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
        $response = $this->peopleDomain->show($request->id);
        return response($response, $response['code']);
    }

 

    public function destroy(Request $request)
    {
        $people = $request->id;

        DB::beginTransaction();
        $reponse = $this->peopleDomain->manegeDelete($people);

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
