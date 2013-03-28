<?php

namespace NGPP\GmsagcBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class PressController extends Controller
{
    public function listAction($name = null, $limit = 10)
    {
        $repo = $this->getDoctrine()->getEntityManager()->getRepository('NGPPGmsagcBundle:Press');
        $press = $repo->getList($name, $limit);
        
        return new JsonResponse($press);
    }
}
