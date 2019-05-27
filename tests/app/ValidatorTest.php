<?php
use Framework\Validator;
use PHPUnit\Framework\TestCase;
use Application\Model\Book;

class ValidatorTest extends TestCase
{
    public function testIfHaveObject()
    {
        $object = $this->getMockBuilder(Book::class)
            ->getMock();
        
        $validator = $this->getMockBuilder(Validator::class)
            ->setConstructorArgs([$object])
            ->setMethods(['valid'])
            ->getMock();

        $validator->expects($this->once())
            ->method('valid')
            ->with(true);
    
        $this->assertTrue($validator);
    }
}
