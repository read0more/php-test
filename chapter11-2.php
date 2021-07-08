<?php
$date = $_COOKIE['date'] ?? false;
setcookie('date', (new DateTime())->format('Y-m-d H:i:s'));
echo $date ? "마지막 방문 시각 $date" : "첫 방문";
