<?php

namespace app\Interfaces;

interface CityesInterface {

    public function fromJsonCityes(array $cityes);
    public function removeIdFromCityes(array $cityes);
    public function manageStorageCity(array $cityes, int $state_id);
    public function generateFromJson(array $cityes);
    public function saveCity(array $responseCityes, int  $state_id);
    public function validaCityName($cityName);
    public function getCityWithState($cityName);
    public function updateCity(object $state, array $cityes);
    public function manageUpdateCity($state, array $cityes);
}