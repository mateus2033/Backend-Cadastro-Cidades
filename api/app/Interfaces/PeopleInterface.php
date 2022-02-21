<?php

namespace app\Interfaces;

interface PeopleInterface {


    public function index($data);
    public function show($id);
    public function fromJsonPeople(array $people);
    public function mountRelationPeople(array $responsePeople);
    public function savePeople(array $array);
    public function manageSave(array $people);
    public function manegeDelete($id);
    public function deletePeople($people);

    
}