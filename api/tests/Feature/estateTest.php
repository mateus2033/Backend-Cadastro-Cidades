<?php

namespace Tests\Feature;

use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class estateTest extends TestCase
{





    /** @test */
    public function only_faker_create()
    {
        
        $faker = Factory::create();
        for($i=0;$i<=800;$i++){

            $json = '{
            
            "name"      :"'.$faker->state().'",
            "initials"  :"ES",
            "population":"'.$faker->numberBetween($min = 1000, $max = 10000000).'",
            
                "cityes": [{
                    "name"               :"'.$faker->city().'",        
                    "iso_ddd"            :'.$faker->numberBetween($min = 10,  $max = 100).',
                    "population"         :'.$faker->numberBetween($min = 500, $max = 700000).', 
                    "income_per_capital" :'.$faker->numberBetween($min = 900, $max = 2000).'     
             }]
            }';

            $decodificado = json_decode($json, true);      
            $response = $this->post('/api/cityes', $decodificado);

        }
        $response->assertStatus(201);
    }





    /** @test */
    public function only_fixed_value_create()
    {
        
        $faker = Factory::create();
        for($i=0;$i<=500;$i++){

            $json = '{
            
            "name"      :"Mingas Gerais",
            "initials"  :"MG",
            "population":"'.$faker->numberBetween($min = 1000, $max = 10000000).'",
            
                "cityes": [{
                    "name"               :"Belo Horizonte",        
                    "iso_ddd"            :'.$faker->numberBetween($min = 10,  $max = 100).',
                    "population"         :'.$faker->numberBetween($min = 500, $max = 700000).', 
                    "income_per_capital" :'.$faker->numberBetween($min = 900, $max = 2000).'     
             }]
            }';

            $decodificado = json_decode($json, true);      
            $response = $this->post('/api/cityes', $decodificado);

        }
        $response->assertStatus(201);
    }





    /** @test */
    public function only_found_index()
    {
        $faker = Factory::create();
        for($i=0;$i<=50;$i++){

            $response = $this->post('/api/cityes/index',[

               "paginate" => $faker->numberBetween($min = 1, $max = 10)
            ]);
        }
          
        $response->assertStatus(200);
    }




    /** @test */
    public function only_found_show()
    {

        $faker = Factory::create();
        for($i=0;$i<=10;$i++){

            $response = $this->get('/api/cityes',["name" => $faker->name()]);

        }   
        $response->assertStatus(404);
    }



}
