param (
    $valor = 900,
    $qt = 5
)

$t1 = & .\testes1.ps1 -valor $valor -qt $qt
$t2 = & .\testes2.ps1 -valor $valor -qt $qt

$r1 = $t1 | ConvertFrom-Json
$taxaJuros1 = [float]$r1.taxaJuros
$r2 = $t2 | ConvertFrom-Json
$taxaJuros2 = [float]$r2.taxaJuros
$testes = New-Object System.Collections.ArrayList
$tira = $testes.Add($r1.codigoProduto -eq $r2.codigoProduto)
$tira = $testes.Add($r1.descricaoProduto -eq $r2.descricaoProduto)
$tira = $testes.Add($taxaJuros1 -eq $taxaJuros1)
$tira = $testes.Add($r1.resultadoSimulacao[0].tipo -eq $r2.resultadoSimulacao[0].tipo)
$tira = $testes.Add($r1.resultadoSimulacao[1].tipo -eq $r2.resultadoSimulacao[1].tipo)

for ($i = 0; $i -lt $qt; $i++) {
    $tira = $testes.Add($r1.resultadoSimulacao[0].parcelas[$i].numero -eq $r2.resultadoSimulacao[0].parcelas[$i].numero)
    $tira = $testes.Add($r1.resultadoSimulacao[1].parcelas[$i].numero -eq $r2.resultadoSimulacao[1].parcelas[$i].numero)
    $tira = $testes.Add($r1.resultadoSimulacao[0].parcelas[$i].valorAmortizacao -eq $r2.resultadoSimulacao[0].parcelas[$i].valorAmortizacao)
    $tira = $testes.Add($r1.resultadoSimulacao[1].parcelas[$i].valorAmortizacao -eq $r2.resultadoSimulacao[1].parcelas[$i].valorAmortizacao)
    $tira = $testes.Add($r1.resultadoSimulacao[0].parcelas[$i].valorJuros -eq $r2.resultadoSimulacao[0].parcelas[$i].valorJuros)
    $tira = $testes.Add($r1.resultadoSimulacao[1].parcelas[$i].valorJuros -eq $r2.resultadoSimulacao[1].parcelas[$i].valorJuros)
    $tira = $testes.Add($r1.resultadoSimulacao[0].parcelas[$i].valorPrestacao -eq $r2.resultadoSimulacao[0].parcelas[$i].valorPrestacao)
    $tira = $testes.Add($r1.resultadoSimulacao[1].parcelas[$i].valorPrestacao -eq $r2.resultadoSimulacao[1].parcelas[$i].valorPrestacao)
}

foreach ($teste in $testes) {
    if (-not $teste) {
        Write-Output "Falso"
        exit 0
    }
}
Write-Output "Igual"
exit 0