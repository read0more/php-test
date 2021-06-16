<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require "chapter6-2.php";
use \Chapter\Q4\Ingredient;

class Entree {
    private $name;
    protected $ingredients = [];

    public function getName () {
        return $this->name;
    }

    public function __construct($name, $ingredients)
    {
        if (!is_array($ingredients)) {
            throw Exception('$ingredients가 배열이 아닙니다.');
        }
        $this->name = $name;
        $this->ingredients = $ingredients;
    }

    public function hasIngredients($ingredient) {
        return in_array($ingredient, $this->ingredients);
    }
}

/*
 * 문제1. 이름과 가격 속성을 가진 Ingredient 클래스 작성
 *
 */
echo '==== 문제1,2 ====<br/>';
$ingredients = new Ingredient('마늘', 600);
echo "{$ingredients->getName()} : {$ingredients->getPrice()}원<br />";
$ingredients->setPrice(700);
echo "{$ingredients->getName()} : 가격변경후...{$ingredients->getPrice()}원";
echo '<br/><br/>';


// 문제3. Entree 하위클래스 생성(ingredients속성을 Ingredient의 배열로 받는), 전체 요리의 총 가격을 반환하는 메서드 작성
class Q3 extends Entree {
    public function __construct($name, $ingredients)
    {
        parent::__construct($name, $ingredients);
        foreach ($this->ingredients as $ingredient) {
            if (!$ingredient instanceof Ingredient) {
                throw Exception('ingredients의 요소는 Ingredient이여야 함.');
            }
        }
    }

    public function getTotalPrice() {
        return array_reduce($this->ingredients, function ($acc, $item) {
           return $acc + $item->getPrice();
        }, 0);
    }
}

$a = new Q3('무언가', [new Ingredient('마늘', 600), new Ingredient('파', 1600), new Ingredient('두부', 2120)]);
echo $a->getTotalPrice();