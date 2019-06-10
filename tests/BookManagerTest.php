<?php

use PHPUnit\Framework\TestCase;
use Application\Manager\BookManager;

class BookManagerTest extends TestCase
{
    public function testFindAllDoneIfExecute()
    {
        $observer = $this->getMockBuilder(BookManager::class)
                         ->getMock();
        $observer->method('findAllDone')
                 ->willReturn(new stdClass);

        $this->assertInstanceOf('stdClass',$observer->findAllDone());
    }

    public function testFindAllDoneIfThrow()
    {
        $observer = $this->getMockBuilder(BookManager::class)
                         ->disableOriginalConstructor()
                         ->getMock();
        
        $observer->method('findAllDone')
                 ->will($this->throwException(new \Exception("Error findAllDone()")));

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Error findAllDone()");
        
        $observer->findAllDone();
    }
}
