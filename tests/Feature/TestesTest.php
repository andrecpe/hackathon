<?php
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TestesTest extends TestCase
{
    public function testSimulacao2()
    {
        $valor  = 900.00;
        $qt = 5;
        $jsonInput = [
            "valorDesejado" => $valor,
            "prazo" => $qt
        ];

        $expectedData = `powershell script/testes1.ps1 -valor $valor -qt $qt`;
        $response = `powershell script/testes2.ps1 -valor $valor -qt $qt`;
        $response->assertStatus(200);
        $response->assertText($expectedData);
    }
}
