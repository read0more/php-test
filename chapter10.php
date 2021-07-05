<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

/**
 * 문제 1. 쿠키로 사용자가 페이지 몇 번봤는지 지속해서 기록하고 출력
 * 문제 2. 5, 10, 15번째 방문 시 별도의 특별한 메시지 출력. 20회에는 쿠키 삭제하고 열람 횟수 초기화
 */
$visitCount = 1 + ($_COOKIE['visit_count'] ?? 0);
if ($visitCount === 20) {
    setcookie('visit_count', '');
    $msg = "20회 열람 시에는 열람 횟수가 초기화";
} else {
    setcookie('visit_count', $visitCount);
    $msg = "열람횟수 : $visitCount<br />";
    if ($visitCount === 5) {
        $msg .= '5회 째';
    } else if ($visitCount === 10) {
        $msg .= '10회 째';
    } else if ($visitCount === 15) {
        $msg .= '15회 째';
    }
}

echo $msg;

/**
 * 문제 3. 색상 목록을 출력하는 폼을 작성하고, 별도의 페이지를 만들어 사용자가 배경색을 선택한게 나오게
 */
function printFormQ3()
{
    $colors = [
        'cyan',
        'gold',
        'black'
    ];
    $optionHtml = implode('</option><option>', $colors);
    echo <<<form
    <form method="post" action="chapter10-2.php">
        <select name="color">
            <option>
                $optionHtml
            </option>
        </select>
        <button type="submit">제출</button>
    </form>
form;
}
printFormQ3();

/**
 * 문제 4. 주문 수량을 받는 6가지 상품의 폼을 작성. 제출되면 세션에 저장
 * 제출되고나면 저장된 주문의 내용, 주문 페이지로 돌아가는 링크, 주문 완료 버튼을 출력.
 * 돌아갈 경우 세션에 저장된 주문 수량을 텍스트박스에 기본값으로 출력할 것.
 * 주문 완료 버튼이 눌리면 세션을 삭제한다.
 */
function printFormQ4() {
    $products = [
        '상품1',
        '상품2',
        '상품3',
        '상품4',
        '상품5',
        '상품6',
    ];
    echo "<form method='post' action='chapter10-3.php'>";
    foreach ($products as $i => $product) {
        $defaultQty = $_SESSION['products'][$product]['qty'] ?? 0;
        echo "$product 수량 : <input type='text' name='$product-qty' value='$defaultQty' /><br />";
    }
    echo "<button type='submit'>제출</button>";
    echo "</form>";
}
printFormQ4();
