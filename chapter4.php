<?php

/*
* 문제1. 배열 정의 및 출력
*/
function printFromQ1ToQ3($cities)
{
    $totalPopulation = 0;
    foreach ($cities as $city => $population) {
        echo "$city : $population<br />";
        $totalPopulation += $population;
    }
    echo "총 인구: $totalPopulation";
}

echo '==== 문제1 ====<br/>';
$cities = [
    'Suwon, GG' => 1194313,
    'Changwon, GN' => 1059241,
    'Goyang, GG' => 990073,
    'Yongin, GG' => 971327,
    'Cheongju, CB' => 833276,
    'Jeonju, JB' => 658172,
    'Cheonan, CN' => 629062,
    'Gimhae, GN' => 534124,
    'Pohang, GB' => 511804,
    'Jinju, GN' => 349788,
];
printFromQ1ToQ3($cities);

echo '<br/><br/>';

/*
 * 문제2. 인구 순서대로 출력 / 도시명 순서대로 출력
 */
echo '==== 문제2 ====<br/>';
echo "인구 순<br/>";
asort($cities);
printFromQ1ToQ3($cities);

echo '<br/><br/>';

echo "도시명 순<br/>";
ksort($cities);
printFromQ1ToQ3($cities);
echo '<br/><br/>';

/*
 * 문제3. 도별 인구 총합 출력
 */
echo '==== 문제3 ====<br/>';
$newArr = [];
foreach ($cities as $city => $population) {
    $newKey = trim(explode(',', $city)[1]);
    $newArr[$newKey] = $newArr[$newKey] ? $newArr[$newKey] + $population : $population;
}

printFromQ1ToQ3($newArr);
echo '<br/><br/>';


/*
 * 문제4.
 */
echo 'a. 한 학급을 구성하는 학생들의 성적과 학번';
echo <<<'A'
$students = [
    'Hong' => ['grade' => '100', 'id' => 111],
    'Kim' => ['grade' => '90', 'id' => 112],
];
A;

echo 'b. 상품별 재고량';
echo <<<'A'
$productStock = [
    'toy' => 10,
    'food' => 5,
];
A;

echo 'c. 주간 점심 메뉴표의 요일별 구성(가격, 전채, 사이드, 음료, 기타)';
echo <<<'A'
$menu = [
    'monday' => [
        'price' => 10000,
        'appetizer' => '애피타이저1',
        'side' => '사이드1',
        'drink' => '음료1',
        '기타' => '기타1',
    ],
    'tuesday' => [
        'price' => 10002,
        'appetizer' => '애피타이저2',
        'side' => '사이드2',
        'drink' => '음료2',
        '기타' => '기타2',
    ],
    'wednesday' => [
        'price' => 10003,
        'appetizer' => '애피타이저3',
        'side' => '사이드3',
        'drink' => '음료3',
        '기타' => '기타3',
    ],
    'thursday' => [
        'price' => 10004,
        'appetizer' => '애피타이저4',
        'side' => '사이드4',
        'drink' => '음료4',
        '기타' => '기타4',
    ],
    'friday' => [
        'price' => 10005,
        'appetizer' => '애피타이저5',
        'side' => '사이드5',
        'drink' => '음료5',
        '기타' => '기타5',
    ],
    'saturday' => [
        'price' => 10006,
        'appetizer' => '애피타이저6',
        'side' => '사이드6',
        'drink' => '음료6',
        '기타' => '기타6',
    ],
    'sunday' => [
        'price' => 10007,
        'appetizer' => '애피타이저7',
        'side' => '사이드7',
        'drink' => '음료7',
        '기타' => '기타7',
    ],
];
A;

echo 'd . 가족 구성원의 이름';
echo <<<'A'
$family = [
    '이름1',
    '이름2',
    '이름3'
];
A;

echo 'e . 가족 구성원의 이름, 나이, 본인과의 관계';
echo <<<'A'
$family = [
    '어머니' => ['name' => '이름1', 'age' => 50, 'relations' => '어머니'],
    '아버지' => ['name' => '이름2', 'age' => 52, 'relations' => '아버지'],
    '동생' => ['name' => '이름3', 'age' => 20, 'relations' => '동생'],
];
A;
