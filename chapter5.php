<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'chapter5-2.php';
/*
 * 문제1. HTML의 <img /> 태그를 반환하는 함수를 작성. 필수 인수는 URL, 선택 인수는 alt, height, width
 *
 */
echo '==== 문제1 ====<br/>';

function getImg($url, $alt = "", $height = "", $width = "")
{
    return "<img src='$url' alt='$alt' width='$width' height='$height'/>";
}

echo getImg('https://picsum.photos/400/500', 'test', 400, 500);
echo '<br/><br/>';

/**
 * 문제2. 함수 내부에서 파일명 앞에 전역변수를 붙여 전체 URL 생성
 */
echo '==== 문제2 ====<br/>';

$root = 'https://picsum.photos';


function getImg2($alt = "", $height = "", $width = "")
{
    return "<img src='$GLOBALS[root]/$width/$height' alt='$alt' width='$width' height='$height'/>";
}

echo getImg2('alt...', '400', 500);
echo '<br/><br/>';


echo '==== 문제3 ====<br/>';
/**
 * 문제3. 문제2 함수 다른 파일에 넣고 require하고 호출
 */
echo getImg3('3번문제', 200, 500);
echo '<br/><br/>';

echo '==== 문제4 ====<br/>';
/**
 * 문제4. 코드 결과 출력
 */
function restaurantCheck($meal, $tax, $tip)
{
    $tax_amount = $meal * ($tax / 100);
    $tip_amount = $meal * ($tip / 100);

    return $meal + $tax_amount + $tip_amount;
}

$cash_on_hand = 31;
$meal = 25;
$tax = 10;
$tip = 10;

while (($cost = restaurantCheck($meal, $tax, $tip)) < $cash_on_hand) {
    $tip++;
    print "팁으로 $tip%($cost) 정도는 낼 수 있지<br/>";
}
echo '<br/><br/>';

/**
 * 문제5. rgb에서 hex로 바꿔주는 함수 작성
 */

function rgbToHex($red, $green, $black)
{
    return '#' . str_pad(dechex($red), 2, 0) . str_pad(dechex($green), 2, 0) . str_pad(dechex($black), 2, 0);
}

$color = [255, 0, 255];
// Spread Operator는 7.4이상
echo implode(',', $color) . ' = ' . rgbToHex(...$color);