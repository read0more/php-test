<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
try {
    $db = new PDO("mysql:host=127.0.0.1;dbname=test;", 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    echo "$e->getMessage()<br />";
}

/**
 * 문제 1. 모든 메뉴 가격 순으로 출력
 */
$stmt = $db->query("SELECT * FROM dishes ORDER BY price");
while ($row = $stmt->fetch()) {
    echo "메뉴:$row[dish_name] 가격 : $row[price]<br />";
}

/**
 * 문제 2. 폼으로 가격 받아서 받은 가격 이상인 메뉴들 테이블에 출력
 */
if (($_POST['question'] ?? '') === 'q2') {
    $price = $_POST['price'];
    $stmt = $db->prepare("SELECT * FROM dishes WHERE ? <= price ORDER BY price");
    $stmt->execute([$price]);
    printDishTable($stmt);
}

function printDishTable($dishStmt)
{
    if ($dishStmt->rowCount() === 0) {
        echo '해당하는 메뉴가 없습니다.<br />';
        return;
    }

    echo <<<table
    <table>
        <tr>
            <th>메뉴명</th>
            <th>가격</th>
            <th>매운음식</th>
        </tr>
    table;

    while ($row = $dishStmt->fetch()) {
        $isSpicy = $row['is_spicy'] ? 'O' : "X";
        echo <<<tr
            <tr>
                <td>$row[dish_name]</td>
                <td>$row[price]</td>
                <td>$isSpicy</td>
            </tr>
        tr;
    }

    echo "</table>";
}

/**
 * 문제 3. DB에서 메뉴 가져와서 select로 출력하고 폼 제출하면 선택한 상품 상세 정보 출력
 */
if (($_POST['question'] ?? '') === 'q3') {
    $dishName = $_POST['dish_name'];
    $stmt = $db->prepare("SELECT * FROM dishes WHERE dish_name = ? ORDER BY price");
    $stmt->execute([$dishName]);
    printDishTable($stmt);
}

function printSelectMenuFormFromDB()
{
    $db = $GLOBALS['db'];
    $stmt = $db->query("SELECT * FROM dishes ORDER BY price");
    echo <<<q3
        <form method="post">
            <select name="dish_name">       
    q3;

    while ($row = $stmt->fetch()) {
        echo "<option>$row[dish_name]</option>";
    }

    echo <<<q3
            </select>
            <input type="hidden" name="question" value="q3"/>
            <button type="submit">제출</button>
        </form>
    q3;
}

/**
 * 문제4. 레스토랑 고객 정보 테이블 생성 / 고객 정보 받아서 테이블에 넣기. 좋아하는 메뉴는 select로 출력
 */
if (($_POST['question'] ?? '') === 'q4') {
    try {
        $stmt = $db->prepare('INSERT INTO customers (tel, favorite_dish_id) VALUES (:tel, :dish_id)');
        $stmt->execute([':tel' => $_POST["tel"], ':dish_id' => $_POST["dish_id"]]);
        echo "유저 생성 성공<br />";
    } catch (Exception $e) {
        var_dump($e);
    }

}

try {
    $db->exec(
        "
            CREATE TABLE customers(
                id INT PRIMARY KEY AUTO_INCREMENT,
                tel VARCHAR(13),
                favorite_dish_id INT,
                FOREIGN KEY(favorite_dish_id) REFERENCES dishes(dish_id)
            )                              
        "
    );
} catch (Exception $e) {
    echo '이미 테이블이 있음<br />';
}


function printNewCustomerFormFromDB()
{
    $db = $GLOBALS['db'];
    $stmt = $db->query("SELECT * FROM dishes ORDER BY price");
    echo <<<q4
        <form method="post">
            전화번호 <input type="tel" name="tel" />
            좋아하는 메뉴 : <select name="dish_id">       
    q4;

    while ($row = $stmt->fetch()) {
        echo "<option value='$row[dish_id]'>$row[dish_name]</option>";
    }

    echo <<<q4
            </select>
            <input type="hidden" name="question" value="q4"/>
            <button type="submit">제출</button>
        </form>
    q4;
}

?>
<b>문제 2번 form...받은 가격이상인 메뉴 출력</b>
<form method="post">
    <input type="number" name="price" min="0"/>
    <input type="hidden" name="question" value="q2"/>
    <button type="submit">제출</button>
</form>

<b>문제 3번 form...DB에서 가져온 메뉴</b>
<?php printSelectMenuFormFromDB(); ?>

<b>문제 4번 form...추가할 사용자</b>
<?php printNewCustomerFormFromDB(); ?>
