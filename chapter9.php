<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/**
 * 문제 1. html 템플릿 파일읽고 출력값으로 교체하고 별도의 파일로 페이지 저장하기
 */
$page = file_get_contents('test-template.html');
if ($page === false) {
    die('test-template.html 파일을 읽을 수 없습니다.');
}

$vars = [
  'title' => '9연습문제',
  'color' => 'gold'
];
$templateVars = [];
foreach ($vars as $k => $v) {
    $templateVars['{' . $k. '}'] = $v;
}

$page = str_replace(array_keys($templateVars), array_values($templateVars), $page);

//$page = strtr($page, [
//    '{title}' => '9연습문제',
//    '{color}' => 'cyan',
//]);

$result = file_put_contents('result.html', $page);
if ($result === false) {
    die('result.html 파일을 생성할 수 없습니다.');
}

/**
 * 문제 2. addresses.txt 한줄 씩 읽어서
 * 이메일 출현 횟수, 이메일 주소를 쉼표로 연결한 문자열을 address-count.txt에 출력
 */
$countArr = [];
$result = "";
foreach (file('addresses.txt') as $address) {
    $address = trim($address);
    $countArr[$address] = isset($countArr[$address]) ? $countArr[$address] + 1 : 1;
}

arsort($countArr);
foreach ($countArr as $email => $count) {
    $result .= "$email,$count\n";
}
$result = file_put_contents('addresses-count.txt', $result);
if ($result === false) {
    die('result.html 파일을 생성할 수 없습니다.');
}

/**
 * 문제 3. CSV파일을 HTML 테이블로 출력
 */
$fh = fopen('dishes.csv', 'rb');
echo <<<table
<table>
    <tr>
        <th>메뉴명</th>
        <th>가격</th>
        <th>매운음식</th>
    </tr>
table;

while ((!feof($fh)) && ($info = fgetcsv($fh))) {
    $info[2] = $info[2] ? 'O' : "X";
    echo "<tr><td>" . implode("</td><td>", $info) . "</td></tr>";
}

echo "</table>";


/**
 * 문제 4. 파일명 폼으로 받아서 출력(문서 루트 하위의 파일만)
 */
if (isset($_POST['filename'])) {
    printFile($_POST['filename']);
}


function printFile($filename)
{
    $basePath = realpath($_SERVER['DOCUMENT_ROOT']);
    $filepath = realpath("$basePath/$filename");

    // 문제 5. HTML 파일만 가능하게 하기
    if (strcasecmp(pathinfo($filename, PATHINFO_EXTENSION),'HTML') !== 0) {
        echo 'HTML파일만 가능합니다.';
        return;
    }

    if ($basePath === substr($filepath, 0, strlen($basePath)) && is_readable($filepath)) {
        echo nl2br(htmlentities(file_get_contents($filepath)));
    } else {
        echo '올바른 경로를 입력해주세요.';
    }
}

?>

<b>문제 4,5번 form...출력할 파일</b>
<form method="post">
    <input type="text" name="filename" />
</form>
