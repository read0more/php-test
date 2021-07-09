<?php declare(strict_types=1);

include "FormHelper.php";
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
     * 문제 3-1. 연관배열을 select에 인수로 전달하고 결과 검사
     */
    public function testQuestion3_1()
    {
        $formHelper = new FormHelper();
        $select = $formHelper->select(['value1' => '첫 번째']);
        $this->assertStringContainsString('<option value="value1">첫 번째</option>', $select);
    }

    /**
     * 문제 3-2. 연관배열을 select에 인수로 전달하고 결과 검사
     */
    public function testQuestion3_2()
    {
        $formHelper = new FormHelper();
        $select = $formHelper->select(['아이고']);
        $this->assertStringContainsString('<option value="0">아이고</option>', $select);
    }

    /**
     * 문제 3-3. select의 두 번째 인수를 전달하지 않으면 select 태그는 어떤 속성도 포함하지 않아야 함
     */
    public function testQuestion3_3()
    {
        $formHelper = new FormHelper();
        $select = $formHelper->select(['아이고']);
        $this->assertStringContainsString('<select>', str_replace(' ', '', $select));
    }

    /**
     * 문제 3-4. 두 번째 인수의 연관 배열 요소의 값이 true라면 select 태그의 속성에는 속성명만 나와야 함
     */
    public function testQuestion3_4()
    {
        $formHelper = new FormHelper();
        $select = $formHelper->select(['option'], ['selected' => true]);
        $this->assertStringContainsString('<select selected>', $select);
    }

    /**
     * 문제 3-5. 두 번째 인수의 연관 배열 요소의 값이 false라면 select 태그의 속성에는 나오지 말아야 한다
     */
    public function testQuestion3_5()
    {
        $formHelper = new FormHelper();
        $select = $formHelper->select(['option'], ['selected' => false]);
        $this->assertStringContainsString('<select>', str_replace(' ', '', $select));
    }

    /**
     * 문제 3-6. 두 번째 인수의 연관 배열 요소의 값이 true, false가 아니라면 속성명=속성값으로 들어감
     */
    public function testQuestion3_6()
    {
        $formHelper = new FormHelper();
        $select = $formHelper->select(['option'], ['data-id' => "000001123"]);
        $this->assertStringContainsString('data-id="000001123"', $select);
    }

    /**
     * 문제 3-7. multiple 속성이 있다면 name의 값의 뒤에 []가 붙어야 함.
     */
    public function testQuestion3_7()
    {
        $formHelper = new FormHelper();
        $select = $formHelper->select(['option'], ['multiple' => true, 'name' => 'menu']);
        $this->assertStringContainsString('name="menu[]"', $select);
    }

    /**
     * 문제 3-8. 속성 값과 option텍스트는 htmlentity로 변환된다.
     */
    public function testQuestion3_8()
    {
        $formHelper = new FormHelper();
        $select = $formHelper->select(['option' => '&&!asd'], ['multiple' => "1<2 & 4>3"]);
        $this->assertStringContainsString('<select multiple="1&lt;2 &amp; 4&gt;3"><option value="option">&amp;&amp;!asd</option></select>', $select);
    }

    /**
     * 문제 4. button태그 submit, reset, button만 받게
     * 4-1. submit 받아서 들어가지는지
     */
    public function testQuestion4_1()
    {
        $formHelper = new FormHelper();
        $button = $formHelper->button('submit');
        $this->assertStringContainsString('<button type="submit"', $button);
    }

    /**
     * 4-2. reset 받아서 들어가지는지
     */
    public function testQuestion4_2()
    {
        $formHelper = new FormHelper();
        $button = $formHelper->button('reset');
        $this->assertStringContainsString('<button type="reset"', $button);
    }

    /**
     * 4-3. button 받아서 들어가지는지
     */
    public function testQuestion4_3()
    {
        $formHelper = new FormHelper();
        $button = $formHelper->button('button');
        $this->assertStringContainsString('<button type="button"', $button);
    }

    /**
     * 4-4. value가 버튼 태그안에 들어가는지
     */
    public function testQuestion4_4()
    {
        $formHelper = new FormHelper();
        $button = $formHelper->button('submit', '제출');
        $this->assertStringContainsString('제출', $button);
    }

    /**
     * 4-5. submit, reset, button 이외라면 type을 넣지 않는다.
     */
    public function testQuestion4_5()
    {
        $formHelper = new FormHelper();
        $button = $formHelper->button('test');
        $this->assertStringNotContainsString('test', $button);
    }

    /**
     * 4-6. 버튼안의 텍스트는 htmlentity로 변환된다.
     */
    public function testQuestion4_6()
    {
        $formHelper = new FormHelper();
        $button = $formHelper->button('submit', '<제출>');
        $this->assertStringContainsString('&lt;제출&gt;', $button);
    }
}
