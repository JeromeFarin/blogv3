<?php

use PHPUnit\Framework\TestCase;
use Application\Manager\BookManager;

class BookManagerTest extends TestCase
{
    public function testFindAllDoneIfExecute()
    {
        $manager = new BookManager();
        $manager->findAllDone();

        $this->assertIsObject($manager);
    }

    // public function testFindAllDoneIfThrow()
    // {
    //     $manager = $this->getMockBuilder('Application\Manager\BookManager')
    //     ->disableOriginalConstructor()
    //     ->setMethods(['findAllDone'])
    //     ->getMock();

    //     $manager->method('findAllDone')->willReturn(new \Exception);

    //     $this->expectException(InvalidArgumentException::class);
    // }
}
