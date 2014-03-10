<?php

namespace MikeFunk\Bookymark\BookmarksBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('MikeFunkBookymarkBookmarksBundle:Default:index.html.twig', array('name' => $name));
    }
}
