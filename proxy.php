<?php
// proxy.php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");

$ticker = $_GET['ticker'] ?? '';

if ($ticker === 'BBCA') {
    $url = "https://query1.finance.yahoo.com/v8/finance/chart/BBCA.JK?interval=1d";
} elseif ($ticker === 'TSLA') {
    $url = "https://query1.finance.yahoo.com/v8/finance/chart/TSLA?interval=1d";
} else {
    echo json_encode(['error' => 'Ticker invalid']);
    exit;
}

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)');
$result = curl_exec($ch);
curl_close($ch);

echo $result;
?>