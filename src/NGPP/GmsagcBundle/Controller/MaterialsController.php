<?php

namespace NGPP\GmsagcBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Route("/materials")
 */
class MaterialsController extends Controller
{
    /**
     * @Route("/list/{name}/{limit}", name="ngpp_gmsagc_ajax_materials_list", 
     * requirements={"limit" = "\d+"}, 
     * defaults={"name" = null, "limit" = 10})
     */
    public function listAction($name = null, $limit = 10)
    {
        $repo = $this->getDoctrine()->getManager()->getRepository('NGPPGmsagcBundle:Materials');
        $materials = $repo->getList($name, $limit);
        
        $materialsJSON = array();
        foreach ($materials as $material)
        {
            $materialsJSON[] = $material->getName();
        }
        
        return new JsonResponse($materialsJSON);
    }
}
