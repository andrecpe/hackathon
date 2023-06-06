<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SolicitaProdutoController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'valorDesejado' => 'required|numeric|decimal:0,2|min:200',
            'prazo' => 'required|integer|min:1'
        ]);
        $dados = $request->all();
        $valor = $dados['valorDesejado'];
        $prazo = $dados['prazo'];
        $produtos = Produto::where('VR_MINIMO', '<=', $valor)
            ->where(function ($query) use ($valor) {
                $query->where('VR_MAXIMO', '>=', $valor)
                    ->orWhereNull('VR_MAXIMO');
            })
            ->where('NU_MINIMO_MESES', '<=', $prazo)
            ->where(function ($query) use ($prazo) {
                $query->where('NU_MAXIMO_MESES', '>=', $prazo)
                    ->orWhereNull('NU_MAXIMO_MESES');
            })
            ->get();
        if (count($produtos) == 0) {
            return response()->json([
                "Codigo" => 400,
                "Mensagem" => "Não há produtos disponíveis para os parâmetros informados"
            ], 400);
        }
        $resultadoSimulacao = array();
        $resultadoSimulacao[] = $this->sac($valor, $prazo, $produtos[0]->PC_TAXA_JUROS);
        $resultadoSimulacao[] = $this->price($valor, $prazo, $produtos[0]->PC_TAXA_JUROS);
        return response()->json([
            "codigoProduto" => $produtos[0]->CO_PRODUTO,
            "descricaoProduto" => $produtos[0]->NO_PRODUTO,
            "taxaJuros" => $produtos[0]->PC_TAXA_JUROS,
            "resultadoSimulacao" => $resultadoSimulacao
        ]);
    }

    private function price($valorDesejado, $prazo, $juros): array
    {
        $valorPrestacao = ($valorDesejado * $juros) / (1 - (1 + $juros) ** ($prazo * -1));
        $saldo = $valorDesejado;
        $parcelas = array();
        for ($i = 0; $i < $prazo; $i++) {
            $jurosMes = $saldo * $juros;
            $amortizacao = $valorPrestacao - $jurosMes;
            $saldo -= $amortizacao;
            $parcelas[] = [
                "numero" => $i + 1,
                "valorAmortizacao" => round($amortizacao, 2),
                "valorJuros" => round($jurosMes, 2),
                "valorPrestacao" => round($valorPrestacao, 2)
            ];
        }
        return [
            "tipo" => "PRICE",
            "parcelas" => $parcelas
        ];
    }

    private function sac($valorDesejado, $prazo, $juros): array
    {
        $amortizacao = $valorDesejado / $prazo;
        $saldo = $valorDesejado;
        $parcelas = array();
        for ($i = 0; $i < $prazo; $i++) {
            $jurosMes = $saldo * $juros;
            $valorPrestacao = $amortizacao + $jurosMes;
            $saldo -= $amortizacao;
            $parcelas[] = [
                "numero" => $i + 1,
                "valorAmortizacao" => round($amortizacao, 2),
                "valorJuros" => round($jurosMes, 2),
                "valorPrestacao" => round($valorPrestacao, 2)
            ];
        }
        return [
            "tipo" => "SAC",
            "parcelas" => $parcelas
        ];
    }

    public function index()
    {
        return Produto::all();
    }
}
