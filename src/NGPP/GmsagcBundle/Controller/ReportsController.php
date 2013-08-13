<?php
namespace NGPP\GmsagcBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use \NGPP\GmsagcBundle\Entity\Molds;

/**
 * @Route("/reports")
 */
class ReportsController extends Controller
{
    /**
     * @Route("/{mold_id}", name="ngpp_gmsagc_reports", requirements={"mold_id" = "\d+"})
     * @ParamConverter("mold", class="NGPPGmsagcBundle:Molds", options={"id" = "mold_id"})
     * @Template
     */
    public function indexAction(Molds $mold)
    {       
        $repo = $this->getDoctrine()->getRepository('NGPPGmsagcBundle:Relations');
        $customerType = $this->container->getParameter('ngpp_gmsagc.types')['customer'];
        $relations = $repo->getReports($customerType['id'], $mold->getId());
        
        return array('relations' => $relations);
    }
}
