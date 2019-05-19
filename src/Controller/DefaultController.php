<?php
namespace Application\Controller;

use Framework\Controller;

/**
 * Class DefaultController
 * @package Application\Controller
 */
class DefaultController extends Controller
{
    /**
     * Home page
     *
     * @return render
     */
    public function home()
    {
        return $this->render('home.twig', array(
            'title' => 'Home Page'
        ));
    }
}
