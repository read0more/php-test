<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/*
 * 문제1. 아래의 HTML에서 noodle은세 번째 옵션을 선택하고, sweet은 첫 번째와 세번째 옵션을 선택하고,
 * 텍스트 박스에 4를 입력하고 제출하면 $_POST는 어떻게 보이는가
 *
 */
echo '==== 문제1 ====<br/>';
echo htmlentities('
<form method="POST">
    <select name="noodle">
        <option>게살</option>
        <option>버섯</option>
        <option>돼지고기</option>
        <option>저민 생강</option>
    </select>
    ');
echo htmlentities(
    '<select name="sweet[]" multiple>
        <option value="puff">참깨 퍼프
        <option value="square">코코넛 우유 젤리
        <option value="cake">흑설탕 케이크
        <option value="ricemeat">찹쌀 경단
    </select>'
);
echo "<br/>";
echo htmlentities(
    '수량: <input type="text" name="sweet_qty">'
);
echo "<br />";
echo htmlentities('<input type = "submit" name = "submit" value = "주문" ></form >');

echo '<br />';
echo 'array(4) {["noodle"]=> string(12) "돼지고기" ["sweet"]=> array(2) {[0]=> string(4) "puff" [1]=> string(4) "cake" } ["sweet_qty"]=> string(1) "4" ["submit"]=> string(6) "주문"}';
echo '<br/><br/>';

/*
 * 문제2. 모든 폼 매개변수와 각각의 값 출력하는 process_form() 함수 작성. 폼 매개변수의 값은 모두 스칼라 값이라 가정
 *
 * 문제5. 폼 매개변수 출력
 */
echo '==== 문제2 ====<br/>';
echo '
<form name="q2" method="post">
    항목1<input name="q2_one" type="text" value="1">
    항목2<input name="q2_two" type="text" value="2">
    항목3<input name="q2_three" type="text" value="3">    
    <input type="submit">
</form>
';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    process_form();
}

function print_array($arr)
{
    echo '<ul>';
    foreach ($arr as $key => $value) {
        if (is_array($value)) {
            echo '<li>' . htmlentities($key) . ':</li>';
            print_array($value);
        } else {
            echo '<li>' . htmlentities($key) . ' = ' . htmlentities($value) . ':</li>';
        }
    }
    echo '</ul>';
}


function process_form()
{
    print_array($_POST);
}

echo '<br/><br/>';

/*
 * 문제3. 두 텍스트 박스에 수를 입력하고 <select> 메뉴로 덧셈, 뺄셈, 곱셈, 나눗셈 연산자 고르는 폼 출력
 * 입력값이 숫자인지, 선택한 연산에 적당한지 검증
 * 폼 처리 함수는 두 수, 연산자, 계산 결과가 포함된 수식을 출력(4 * 2 = 8)
 */
echo '==== 문제3 ====<br/>';
$operators = ['+', '-', '*', '/'];
echo '
    <form method="post">
    숫자1<input name="q3_one" type="number">
    숫자2<input name="q3_two" type="number">
    <select name="q3_operator">
    ';

foreach ($operators as $operator) {
    echo "<option>$operator</option>";
}
echo '
    </select>        
    <input type="submit">
    </form>
';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    [$values, $errors] = q3Validation();

    if (count($errors)) {
        foreach ($errors as $error) {
            echo $error;
        }
    } else {
        echo q3GetResult(...$values);
    }
}

function q3GetResult($one, $two, $operator)
{
    switch ($operator) {
        case "+":
            $result = $one + $two;
            break;
        case "-":
            $result = $one - $two;
            break;
        case "*":
            $result = $one * $two;
            break;
        case "/":
            $result = $one / $two;
            break;
    }

    return "$one $operator $two = $result";
}

function q3Validation()
{
    $errors = [];
    $operator = filter_input(INPUT_POST, 'q3_operator');
    $one = filter_input(INPUT_POST, 'q3_one', FILTER_VALIDATE_INT);

    if ($one === false) {
        $errors[] = '숫자1에 숫자를 입력해 주세요.<br />';
    }

    $two = filter_input(INPUT_POST, 'q3_two', FILTER_VALIDATE_INT);
    if ($two === false) {
        $errors[] = '숫자2에 숫자를 입력해 주세요.<br />';
    }

    if (!$operator) {
        $errors[] = '연산자를 선택해주세요.<br />';
    }

    if ($operator === '/' && $two === 0) {
        $errors[] = '0으로 나눌 수 없습니다.<br />';
    }

    if (!in_array($operator, $GLOBALS['operators'])) {
        $errors[] = '사용할 수 없는 연산자입니다.<br />';
    }

    return [[$one, $two, $operator], $errors];
}

echo '<br/><br/>';


/*
 * 문제4. 출발 주소, 배송 주소, 화물 제원, 무게 폼 입력 항목을 받는다
 * 검증은 무게가 150파운드 이하인지 가장 긴 부분의 길이가 36인치 이하인지 검사
 * 우편번호가 형식에 맞는지 확인한다
 *
 */
echo '==== 문제4 ====<br/>';
echo '
    <form method="post">
    출발 주소<input name="q4_start" type="text">
    배송 주소<input name="q4_end" type="text">
    우편번호<input name="q4_postcode" type="text">
    무게<input name="q4_pound" type="text">
    길이<input name="q4_length" type="text">
       <input type="submit">
    </form>   
    ';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    [$values, $errors] = q4Validation();

    if (count($errors)) {
        foreach ($errors as $error) {
            echo $error;
        }
    } else {
        echo q4GetResult($values);
    }
}

function q4GetResult($values)
{
    [$start, $end, $postcode, $pound, $length] = $values;
    return <<<q4
        출발 주소 : $start<br />
        배송 주소 : $end<br />
        우편번호 : $postcode<br />
        무게(파운드) : $pound<br />
        길이(인치) : $length<br />
    q4;
}

function q4Validation()
{
    $errors = [];
    $start = filter_input(INPUT_POST, 'q4_start');
    $end = filter_input(INPUT_POST, 'q4_end');
    $postcode = filter_input(INPUT_POST, 'q4_postcode', FILTER_VALIDATE_INT);
    $pound = filter_input(INPUT_POST, 'q4_pound', FILTER_VALIDATE_INT);
    $length = filter_input(INPUT_POST, 'q4_length', FILTER_VALIDATE_INT);
    $values = [$start, $end, $postcode, $pound, $length];

    if ($postcode === false) {
        $errors[] = '우편번호에 숫자를 입력해주세요.<br />';
    } else {
        if (strlen($postcode) !== 5) {
            $errors[] = '우편번호는 5자리 숫자입니다.<br />';
        }
    }

    if ($pound === false) {
        $errors[] = '무게(파운드)에 숫자를 입력해주세요.<br />';
    } else {
        if (150 < $pound) {
            $errors[] = '무게(파운드)는 150파운드 이여야 합니다.<br />';
        }
    }

    if ($length === false) {
        $errors[] = '길이(인치)에 숫자를 입력해주세요.<br />';
    } else {
        if (36 < $length) {
            $errors[] = '길이(인치)는 36인치 이여야 합니다.<br />';
        }
    }

    return [$values, $errors];
}

?>
