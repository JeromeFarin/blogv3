<?php

use PHPUnit\Framework\TestCase;
use Zend\Diactoros\ServerRequest;
use Framework\Container;
use Zend\Diactoros\UploadedFile;

class BookFormTest extends TestCase
{
    public function testHandleWithoutPOST()
    {
        $request = new ServerRequest();
        $container = new Container();
        $form = $container->get('Application\Form\BookForm');

        $form->handle($request);

        $this->assertIsObject($form);
    }

    public function testHandleWithPOST()
    {
        $request = new ServerRequest();
        $container = new Container();

        $request = $request->withMethod('POST');
        $request = $request->withParsedBody(['book' => [
            'id'=>'1',
            'name'=>'book_1',
            'owner'=>'Denis',
            'cover' => '1.png',
            'finished_date' => '2019-01-01'
            ]]);
        
        $form = $container->get('Application\Form\BookForm');

        $form->handle($request);

        $this->assertTrue($form->submitted);

        $this->assertIsNumeric($form->model->getId());
        $this->assertIsString($form->model->getName());
        $this->assertIsString($form->model->getOwner());
        $this->assertIsString($form->model->getCover());
        $this->assertIsString($form->model->getFinished_date());

        return $request;
    }


    /**
     * @depends testHandleWithPOST
     */
    public function testHandleWithCover(ServerRequest $request)
    {
        $container = new Container();
        $file = new UploadedFile('/tmp/',123456,0,'yes.png','yes');

        $request = $request->withUploadedFiles(['book_cover' => $file]);
        
        $form = $container->get('Application\Form\BookForm');

        $form->handle($request);


        $this->assertArrayHasKey('book_cover',$request->getUploadedFiles());
        $this->assertGreaterThan(0,$request->getUploadedFiles()['book_cover']->getSize());
    }
}
