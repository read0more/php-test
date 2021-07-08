<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/**
 * 문제 1. https://www.php.net/releases/?json에서 php 최신 정보 가져와 출력
 */

$json = json_decode(file_get_contents("https://www.php.net/releases/?json"), true);
if ($json === false) {
    echo "데이터를 가져올 수 없음";
} else {
    echo array_shift($json)['version'] . '<br />';
}

/**
 * 문제 2. 문제 1을 cURL로 변경
 */
$c = curl_init("https://www.php.net/releases/?json");
curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
$json = json_decode(curl_exec($c), true);
if ($json === false) {
    echo "데이터를 가져올 수 없음";
} else {
    echo array_shift($json)['version'] . '<br />';
}
curl_close($c);

/**
 * 문제 3. 사용자가 마지막으로 웹 페이지 본 시각을 쿠키를 이용해 보여주기
 */
$c = curl_init("http://$_SERVER[HTTP_HOST]/chapter11-2.php");
curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
curl_setopt($c, CURLOPT_COOKIEJAR, __DIR__ . '/saved.cookies');
curl_setopt($c, CURLOPT_COOKIEFILE, __DIR__ . '/saved.cookies');
$response = curl_exec($c);
echo "$response<br />";
$response = curl_exec($c);
echo "$response<br />";
curl_close($c);

/**
 * 문제 4.
 */
$code = file_get_contents(__FILE__);
$files = [
    'files'=> [
        basename(__FILE__) => [
            'content' => $code
        ]
    ]
];

$env = json_decode(file_get_contents("env.json"), true);
$c = curl_init("https://api.github.com/gists");
curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
curl_setopt($c, CURLOPT_POST, true);
curl_setopt($c, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($c, CURLOPT_HTTPHEADER, [
    'Content-type: application/json',
    "Authorization: token $env[access_token]",
]);
curl_setopt($c, CURLOPT_POSTFIELDS, json_encode($files));
$response = curl_exec($c);
if ($response === false) {
    echo "요청을 생성할 수 없음";
    var_dump(curl_error($c));
} else {
    $info = curl_getinfo($c);

    if ($info['http_code'] !== 201) {
        echo "gist를 생성할 수 없음";
    }
    var_dump($response);
}
curl_close($c);
