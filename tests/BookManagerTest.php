<?php

use PHPUnit\Framework\TestCase;
use Application\Manager\BookManager;

class BookManagerTest extends TestCase
{
    public function testFindAllDoneIfExecute()
    {
        // $param = $this
        //     ->getMockBuilder('Application\Manager\BookManager')
        //     ->setMethods(array('findAllDone'))
        //     ->getMock();

            
        $manager = new BookManager();
        // $manager->findAllDone();
        // $manager->findAllDone();

        // dd($manager::getInfo());
        $this->assertIsObject($manager);
    }

    // public function testFindAllDoneIfThrow()
    // {
        
    // }
}
