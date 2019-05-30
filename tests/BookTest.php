<?php

use PHPUnit\Framework\TestCase;
use Application\Model\Book;

class BookTest extends TestCase
{       
    public function testGetInfo()
    {
        $book = new Book();
        $this->assertIsArray($book->getInfo());
    }
    public function testSetID()
    {
        $book = new Book();
        $this->assertIsObject($book->setId(1));
    }
    
    public function testGetID()
    {    
        $book = new Book();
        $book->setId(1);
        $this->assertIsInt($book->getId());
    }

    public function testSetName()
    {
        $book = new Book();
        $this->assertIsObject($book->setName('test'));
    }
    
    public function testGetName()
    {  
        $book = new Book();
        $book->setName('test');
        $this->assertIsString($book->getName());
    }

    public function testSetOwner()
    {
        $book = new Book();
        $this->assertIsObject($book->setOwner('test'));
    }
    
    public function testGetOwner()
    {  
        $book = new Book();
        $book->setOwner('test');
        $this->assertIsString($book->getOwner());
    }

    public function testSetCover()
    {
        $book = new Book();
        $this->assertIsObject($book->setCover('test'));
    }
    
    public function testGetCover()
    {  
        $book = new Book();
        $book->setCover('test');
        $this->assertIsString($book->getCover());
    }

    public function testSetFinished_date()
    {
        $book = new Book();
        $this->assertIsObject($book->setFinished_date('test'));
    }
    
    public function testGetFinished_date()
    {  
        $book = new Book();
        $book->setFinished_date('test');
        $this->assertIsString($book->getFinished_date());
    }
}
