<?php

namespace NGPP\GmsagcBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Route("/press")
 */
class PressController extends Controller
{
    /**
     * @Route("/list/{name}/{limit}", name="ngpp_gmsagc_ajax_press_list", 
     * requirements={"limit" = "\d+"}, 
     * defaults={"name" = null, "limit" = 10})
     */
    public function listAction($name = null, $limit = 10)
    {
        $repo = $this->getDoctrine()->getManager()->getRepository('NGPPGmsagcBundle:Press');
        $pressList = $repo->getList($name, $limit);
        
        $pressJSON = array();
        foreach ($pressList as $press)
        {
            $pressJSON[] = $press->getName();
        }
        
        return new JsonResponse($pressJSON);
    }
}
