<?php
// 문제4. namespace 이용
namespace Chapter\Q4;
class Ingredient {
    protected $name;
    protected $price;

    public function __construct($name, $price)
    {
        $this->name = $name;
        $this->price = $price;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    // 문제2. 재료 가격 수정 가능한 메서드 추가
    public function setPrice($price)
    {
        $this->price = $price;
    }
}