<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TabelaTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testSimulacao()
    {
//        $jsonInput = [
//            "valorDesejado" => 900.00,
//            "prazo" => 5
//        ];
        $expectedData = [
            [
                "CO_PRODUTO" => 1,
                "NO_PRODUTO" => "Produto 1",
                "PC_TAXA_JUROS" => ".017900000",
                "NU_MINIMO_MESES" => "0",
                "NU_MAXIMO_MESES" => "24",
                "VR_MINIMO" => "200.00",
                "VR_MAXIMO" => "10000.00"
            ], [
                "CO_PRODUTO" => 2,
                "NO_PRODUTO" => "Produto 2",
                "PC_TAXA_JUROS" => ".017500000",
                "NU_MINIMO_MESES" => "25",
                "NU_MAXIMO_MESES" => "48",
                "VR_MINIMO" => "10000.01",
                "VR_MAXIMO" => "100000.00"
            ], [
                "CO_PRODUTO" => 3,
                "NO_PRODUTO" => "Produto 3",
                "PC_TAXA_JUROS" => ".018200000",
                "NU_MINIMO_MESES" => "49",
                "NU_MAXIMO_MESES" => "96",
                "VR_MINIMO" => "100000.01",
                "VR_MAXIMO" => "1000000.00"
            ], [
                "CO_PRODUTO" => 4,
                "NO_PRODUTO" => "Produto 4",
                "PC_TAXA_JUROS" => ".015100000",
                "NU_MINIMO_MESES" => "97",
                "NU_MAXIMO_MESES" => null,
                "VR_MINIMO" => "1000000.01",
                "VR_MAXIMO" => null
            ]
        ];

        $response = $this->get('/api');
        $response->assertStatus(200);
        $response->assertJson($expectedData);
    }
}
