<?php


class OperatorsTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    private static $operator;

    protected function _before()
    {
        if(self::$operator === null) {
            self::$operator = new \SuiteCRM\API\JsonApi\v1\Filters\Operators\Operator();
        }
    }

    protected function _after()
    {
    }

    public function testToFilterOperator()
    {
        $tag = self::$operator->toFilterTag('test');
        $this->assertEquals('[test]', $tag);
    }

    public function testIsValidTagWithInvalidType()
    {
        $this->tester->expectException(
            new \SuiteCRM\Exception\Exception('[JsonApi][v1][Operator][expected type to be string] $operator'),
            function() {
                self::$operator->isValid(array());
            }
        );
    }

    public function testIsValidTagWithInvalidName()
    {
        $this->assertFalse(self::$operator->isValid(self::$operator->toFilterTag('eq2')));
    }

    public function testIsValidTagWithInvalidSymbol()
    {
        $this->assertFalse(self::$operator->isValid(self::$operator->toFilterTag('+')));
    }

    public function testIsValidTagWithValidNames()
    {
        $this->assertTrue(self::$operator->isValid(self::$operator->toFilterTag('eq')));
        $this->assertTrue(self::$operator->isValid(self::$operator->toFilterTag('equalsUser')));
        $this->assertTrue(self::$operator->isValid(self::$operator->toFilterTag('eq_user')));
        $this->assertTrue(self::$operator->isValid(self::$operator->toFilterTag('eq-user')));
    }
}