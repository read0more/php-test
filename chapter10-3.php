<?php
session_start();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if ($_POST['is_complete']) {
            unset($_SESSION['products']);
            echo "주문이 완료되었습니다.";
            return;
        }

        echo "<b>주문내역</b><br />";
        foreach ($_POST as $product => $qty) {
            if (preg_match('/-qty$/', $product, $output_array)) {
                echo "$product 수량 : $qty<br />";
                $productName = explode('-', $product)[0];
                $_SESSION['products'][$productName]['name'] = $productName;
                $_SESSION['products'][$productName]['qty'] = $qty;
            }
        }
    } else {
        echo "정상적인 접근이 아닙니다.";
    }
?>
<form method="post">
    <input type="hidden" name="is_complete" value="true"/>
    <button type="submit">제출</button>
</form>
<a href="javascript:history.go(-1)">뒤로가기</a>
</body>
</html>