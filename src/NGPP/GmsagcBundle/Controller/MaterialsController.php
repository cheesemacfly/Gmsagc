<?php

namespace NGPP\GmsagcBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class MaterialsController extends Controller
{
    public function listAction($name = null, $limit = 10)
    {
        $repo = $this->getDoctrine()->getEntityManager()->getRepository('NGPPGmsagcBundle:Materials');
        $materials = $repo->getList($name, $limit);
        
        return new JsonResponse($materials);
    }
}
