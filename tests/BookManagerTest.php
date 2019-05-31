<?php

use PHPUnit\Framework\TestCase;

class BookManagerTest extends TestCase
{
    private $manager;

    public function testFindAllDoneIfExecute()
    {
        $this->manager = $this->getMockBuilder('BookManager')
        ->setMethods(array('findAllDone'))
        ->getMock();

        
        $this->manager->method('findAllDone')->willReturn($this->manager);

        // $this->manager->findAllDone();
        
        $this->assertIsObject($this->manager->findAllDone());

    }

    // public function testFindAllDoneIfThrow()
    // {
        
    // }
}
