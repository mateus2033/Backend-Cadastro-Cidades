<?php

namespace App\Interfaces;

interface StatesInterface {


    public function index($data);
    public function fromJsonState(array $state);
    public function getRelations(int $state_id);
    public function manageSave(array $state, array $cityes);
    public function manageUpdate(int $state, array $cityes);
    public function getCity($cityName);

    
}