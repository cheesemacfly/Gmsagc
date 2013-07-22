<?php

namespace NGPP\GmsagcBundle\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="ngpp_gmsagc_home")
     * @Template
     */
    public function indexAction()
    {
        return array();
    }
}
