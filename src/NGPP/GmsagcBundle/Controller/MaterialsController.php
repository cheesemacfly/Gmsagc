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
        
        $materialsJSON = array();
        foreach ($materials as $material)
        {
            $materialsJSON[] = $material->getName();
        }
        
        return new JsonResponse($materialsJSON);
    }
}
