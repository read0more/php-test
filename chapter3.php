<?php

/*
* 문제1. 참 거짓 판별
*/
echo '==== 문제1 ====<br/>';
$case1 = 100.00 - 100;
$case2 = "zero";
$case3 = "false";
$case4 = 0 + "true";
$case5 = 0.000;
$case6 = "0.0";

echo "100.00 - 100 / 출력: $case1 / 참여부 :" . ($case1 ? 'true' : 'false') . "<br />";
echo "zero / 출력: $case2 / 참여부 :" . ($case2 ? 'true' : 'false') . "<br />";
echo "false(문자열) / 출력: $case3 / 참여부 :" . ($case3 ? 'true' : 'false') . "<br />";
echo "0 + 'true' / 출력: $case4 / 참여부 :" . ($case4 ? 'true' : 'false') . "<br />";
echo "0.000 / 출력: $case5 / 참여부 :" . ($case5 ? 'true' : 'false') . "<br />";
echo "0.0 / 출력: $case6 / 참여부 :" . ($case6 ? 'true' : 'false') . "<br />";

echo '<br/><br/>';

/*
 * 문제2. 출력 결과 확인
 */
echo '==== 문제2 ====<br/>';
$question2 = <<<'CODE'
$age = 12;
$shoe_size = 13;
if ($age > $shoe_size) {
    print "1번 메시지.";
} elseif (($shoe_size++) && ($age > 20)) {
    print "2번 메시지.";
} else {
    print "3번 메시지.";
}

print "나이: $age. 신발 치수: $shoe_size";
CODE;

$age = 12;
$shoe_size = 13;
if ($age > $shoe_size) {
    print "1번 메시지.";
} elseif (($shoe_size++) && ($age > 20)) {
    print "2번 메시지.";
} else {
    print "3번 메시지.";
}

print "나이: $age. 신발 치수: $shoe_size";

$a = 1;
echo '<br/><br/>';


/*
 * 문제3. 화씨 -50도 ~ 화씨 50도까지 온도 화씨와 섭씨로 출력
 */
echo '==== 문제3 ====<br/>';
$fahrenheit = -50;
while ($fahrenheit <= 50) {
    $celsius = ($fahrenheit - 32) * (5 / 9);
    printf("화씨: %d도 / 섭씨 %d도<br />", $fahrenheit, $celsius);
//    echo "화씨: $fahrenheit / 섭씨 $celsius<br />";
    $fahrenheit += 5;
}
echo '<br/><br/>';


/*
 * 문제4. 3을 for로
 */
echo '==== 문제4 ====<br/>';
for ($f = -50; $f <= 50; $f += 5) {
    $c = ($f - 32) * (5 / 9);
    printf("화씨: %d도 / 섭씨 %d도<br />", $f, $c);
}