<?php
# Este script ajuda a encontrar problemas de fila no Zend-Server.
# Ele tenta se conectar pela API e, caso obtenha um xml com errorData ou fique
# muito tempo sem responder, reinicia o serviço. Não encontramos o motivo exato do
# problema. O serviço não fica parado, nem existe um momento certo em que o erro ocorre.
# o socket do serviço simplesmente para e ficamos com gargalo em todas nossas Jobs.

function generateRequestSignature($host, $path, $timestamp, $userAgent, $apiKey)
{
    $data = $host . ":" .$path. ":" .$userAgent. ":" .gmdate('D, d M Y H:i:s T', $timestamp);
    return hash_hmac('sha256', $data, $apiKey);
}

$action   = 'jobqueueStatistics';
$host      = '';
$path      = "/ZendServer/Api/$action";
$timestamp = time();
$userAgent = 'Zend_Http_Client/1.9';
$keyName   = '';
$apiKey    = '';

$signedKey = generateRequestSignature($host, $path, $timestamp, $userAgent, $apiKey);

$headers = array(
    "Host: $host",
    "X-Zend-Signature: $keyName; $signedKey",
    "User-agent: $userAgent",
    "Date: " . gmdate('D, d M Y H:i:s T', $timestamp),
    "Accept: application/vnd.zend.serverapi+xml;version=1.9",
    "Content-type: application/x-www-form-urlencoded"
);

$url = "{$host}{$path}";

try {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_TIMEOUT, 20);
    $output = curl_exec($curl);
    $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

    if ($output == false) {
        throw new Exception("Request Timeout");
    }

    $xml = new SimpleXMLElement($output);

    if (isset($xml->errorData)) {
        throw new Exception("Erro na API");
    }
    $log = date("[d/m/Y H:i:s]") . " - Serviço estável"; 
    system("echo '$log' >> /tmp/check_queue.log");

} catch (Exception $e) {
    system("/usr/local/zend/etc/rc.d/S06jobqueue restart");

    $log = date("[d/m/Y H:i:s]") . " - Serviço reiniciado";

    system("echo '$log' >> /tmp/check_queue.log");
    echo $e->getMessage() . " - Serviço reiniciado";
}
