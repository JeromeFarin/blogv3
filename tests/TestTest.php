<?php
use PHPUnit\Framework\TestCase;
use Psr\Log\InvalidArgumentException;

class TestTest extends TestCase
{
    public function testEmpty()
    {
        $stack = [];
        $this->assertEmpty($stack);

        return $stack;
    }

    /**
     * @depends testEmpty
     */
    public function testNotEmpty(array $stack)
    {
        array_push($stack, 'foo');
        $this->assertNotEmpty($stack);

        return $stack;
    }

    /**
     * @depends testNotEmpty
     */
    public function testIsString(array $stack)
    {
        foreach ($stack as $value) {
            $this->assertIsString($value);
        }
        
        return $stack;
    }

    public function testIsTrue()
    {
        $this->assertTrue(true);
    }
}
