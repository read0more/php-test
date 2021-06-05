<?php

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

/*
 * 문제2, 3
 *
 */
echo '==== 문제2,3 ====<br/>';
function centToDollar($cent)
{
    return $cent * 0.01;
}

$menuList = [['hamberger' => 4950], ['hamberger' => 4950], ['milk shake' => 1950], ['coke' => 85]];
$taxRate = 7.5;
$tipRate = 16;
$total = [];
foreach ($menuList as $menu) {
    foreach ($menu as $food => $price) {
        $tax = $price * ($taxRate / 100);
        $tip = $price * ($tipRate / 100);

        $total[$food]['name'] = $food;
        $total[$food]['price'] = $total[$food]['price'] ? $total[$food]['price'] + $price : $price;
        $total[$food]['count'] = $total[$food]['count'] ? $total[$food]['count'] + 1 : 1;
        $total[$food]['total'] = $total[$food]['total'] ? $total[$food]['total'] * $total[$food]['count'] : $price + $tax + $tip;
    }
}

echo "메뉴    가격  수량  총 가격<br/>";
echo "==========================<br/>";
foreach ($total as $line) {
    $price = centToDollar($line['price']);
    $total = centToDollar($line['total']);
    echo "$line[name]   $price$    $line[count]    $total<br>";
}
echo '<br/><br/>';

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
echo '<br>';
$pow = 1;
for ($i = 1; $i <= 5; $i++) {
    $pow *= 2;
    echo "2^$i = $pow<br />";
}