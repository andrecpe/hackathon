param (
    $valor = 900,
    $qt=5
)
$headers = New-Object "System.Collections.Generic.Dictionary[[String],[String]]"
$headers.Add("Content-Type", "application/json")
$headers.Add("Accept", "text/plain")

$body = @"
{
    `"valorDesejado`": $valor,
    `"prazo`": $qt
}
"@

$response = Invoke-RestMethod 'http://localhost:8000/api' -Method 'POST' -Headers $headers -Body $body | ConvertTo-Json -Depth:20 -Compress
Write-Output $response 