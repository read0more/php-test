<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
/*
* 문제1. 다음 PHP 프로그램의 오류를 찾아내시오.
* print '점심 메뉴는 소고기 입니다.';
* 바깥쪽'를 "로 바꿔야 함
* print '그는 '해물 요리면 좋을텐데'라고 생각했다.';
*/
echo '==== 문제1 ====<br/>';
echo <<<EOT
print '그는 '해물 요리면 좋을텐데'라고 생각했다.' -> 해물 요리면 좋을텐데를 감싼 ' 앞에 \로 이스케이프 하거나 전체를 감싼 '를 "로
EOT;
echo '<br/><br/>';


echo '==== 문제2 ====<br/>';
$hamburger = 4.95;
$shake = 1.95;
$cola = 0.85;

$tip_rate = 0.16;
$tax_rate = 0.075;

$food = (2 * $hamburger) + $shake + $cola;
$tip = $food * $tip_rate;
$tax = $food * $tax_rate;

$total = $food + $tip + $tax;

echo "총 가격: \$$total";
echo '<br/><br/>';

echo '==== 문제3 ====<br/>';
$hamburger = 4.95;
$shake = 1.95;
$cola = 0.85;

$tip_rate = 0.16;
$tax_rate = 0.075;

$food = (2 * $hamburger) + $shake + $cola;
$tip + $food * $tip_rate;
$tax = $food * $tax_rate;

$total = $food + $tip + $tax;

printf("%s \%.2f %d개: \%5.2f<br/>", '햄버거', $hamburger, 2, 2 * $hamburger);
printf("%s \%.2f %d개: \%5.2f<br/>", '쉐이크', $shake, 1, $shake);
printf("%s \%.2f %d개: \%5.2f<br/>", '콜라', $cola, 1, $cola);
printf("%s \%.2f<br/>", '음식 가격 합계', $food);
printf("%s \%.2f<br/>", '음식 가격, 부가세 합계', $food + $tax);
printf("%s \%.2f<br/>", '음식 가격, 부가세, 팁 합계', $total);


// 문제4. 이름 출력
echo '==== 문제4 ====<br/>';
$firstName = 'yk';
$lastName = 'p';
echo "$lastName $firstName";
echo '<br/><br/>';


// 문제5. ++이용 1~5출력, *= 이용하여 2^1~2^5 출력
echo '==== 문제5 ====<br/>';
for ($i = 1; $i <= 5; $i++) {
    echo "$i<br/>";
}
echo '<br/>';
$pow = 1;
for ($i = 1; $i <= 5; $i++) {
    $pow *= 2;
    echo "2^$i = $pow<br />";
}
