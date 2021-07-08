<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

function restaurantCheck($meal, $tax, $tip, $isIncludeTaxInTip = false)
{
    $taxAmount = $meal * ($tax / 100);
    if ($isIncludeTaxInTip) {
        $tipBase = $meal + $taxAmount;
    } else {
        $tipBase = $meal;
    }
    $tipAmount = $tipBase * ($tip / 100);
    $totalAmount = $meal + $taxAmount + $tipAmount;

    return $totalAmount;
}

function validateForm($submitted)
{
    $errors = [];
    $input = [];

    $input['age'] = filter_var($submitted['age'] ?? null, FILTER_VALIDATE_INT);
    if ($input['age'] === false) {
        $errors[] = '나이를 정확하게 입력해주세요.';
    }

    $input['price'] = filter_var($submitted['price'] ?? null, FILTER_VALIDATE_FLOAT);
    if ($input['price'] === false) {
        $errors[] = '가격을 정확하게 입력해주세요.';
    }

    $input['name'] = trim($submitted['name'] ?? '');
    if (strlen($input['name']) === 0) {
        $errors[] = '이름을 입력해주세요.';
    }

    return [$errors, $input];
}

class Chapter13TestWithEtc extends TestCase
{
    public function testWithTaxAndTip()
    {
        $meal = 100;
        $tax = 10;
        $tip = 20;
        $result = restaurantCheck($meal, $tax, $tip);
        $this->assertEquals(130, $result);
    }

    public function testWithNoTip()
    {
        $meal = 100;
        $tax = 10;
        $tip = 0;
        $result = restaurantCheck($meal, $tax, $tip);
        $this->assertEquals(110, $result);
    }

    public function testDecimalAgeNotValid()
    {
        $submitted = array(
            'age' => '6.7',
            'price' => '100',
            'name' => 'yk'
        );

        [$erros, $input] = validateForm($submitted);
        $this->assertContains('나이를 정확하게 입력해주세요.', $erros);
        $this->assertCount(1, $erros);
    }

    public function testDollarSignPriceNotValid()
    {
        $submitted = array(
            'age' => '6',
            'price' => '$100',
            'name' => 'yk'
        );

        [$erros, $input] = validateForm($submitted);
        $this->assertContains('가격을 정확하게 입력해주세요.', $erros);
        $this->assertCount(1, $erros);
    }

    public function testValidDataOk()
    {
        $submitted = array(
            'age' => '11',
            'price' => '12.55',
            'name' => '   yk '
        );

        [$erros, $input] = validateForm($submitted);
        $this->assertCount(0, $erros);
        $this->assertCount(3, $input);
        $this->assertSame($submitted['input'], $submitted['input']);
        $this->assertSame($submitted['price'], $submitted['price']);
        $this->assertSame($submitted['name'], $submitted['name']);
    }

    public function testTipShouldIncludeTax()
    {
        $meal = 100;
        $tax = 10;
        $tip = 10;
        $result = restaurantCheck($meal, $tax, $tip, true);
        $this->assertEquals(121, $result);
    }

    public function testTipShouldNotIncludeTax()
    {
        $meal = 100;
        $tax = 10;
        $tip = 10;
        $result = restaurantCheck($meal, $tax, $tip);
        $this->assertEquals(120, $result);
    }

    /**
     * 문제 1. PHPUnit 설치하고, 간단한 검사 해보기
     */
    public function testQuestion1()
    {
        $this->assertEquals(121, 110+11);
        $this->assertEquals([1,2,3],[1,2,3]);
    }

    /**
     * 문제 2. validateForm에서 이름 입력 안했을 때 테스트
     */
    public function testQuestion2()
    {
        $submitted = array(
            'age' => '6',
            'price' => '55.55',
            'name' => ''
        );

        [$erros, $input] = validateForm($submitted);
        $this->assertContains('이름을 입력해주세요.', $erros);
        $this->assertCount(1, $erros);
    }

    /**
     * 문제 3. validateForm에서 이름 입력 안했을 때 테스트
     */
}