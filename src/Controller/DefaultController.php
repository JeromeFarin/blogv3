<?php
namespace Application\Controller;

use Framework\Controller;

class DefaultController extends Controller
{
    public function home()
    {
        return $this->render('home.twig', array(
            'title' => 'Home Page'
        ));
    }
}
