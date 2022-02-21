<?php

namespace Tests\Feature;

use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class peopleTest extends TestCase
{
    
    /** @test */
    public function only_storage()
    {

        $faker = \Faker\Factory::create('pt_BR');

        for($i=0;$i<=800;$i++){
        $response = $this->post('api/people',[

            'name' =>  $faker->name(),
            'cpf'  =>  $faker->cpf(),
            'state'=>  "MG",
            'city' =>  "Belo Horizonte"
        ]);
        }
        $response->assertStatus(201);

    }



    /** @test */
    public function only_show()
    {

        $faker    = Factory::create();
        $response = $this->get('api/people',[

            "id"=> $faker->numberBetween($min = 10,  $max = 100)

        ]);

        $response->assertStatus(404);

    }



    /** @test */
    public function only_found_index()
    {

        $faker    = Factory::create();
        $response = $this->post('api/people/index',[

            "id"=> $faker->numberBetween($min = 10,  $max = 100)

        ]);

        $response->assertStatus(200);

    }



    /** @test */
    public function only_found_delete()
    {
    
        
        $faker    = Factory::create();
        $response = $this->delete('api/people',[
    
            "id"=> $faker->numberBetween($min = 1,  $max = 100)
    
        ]);
    
        $response->assertStatus(200);
    
    }







}
