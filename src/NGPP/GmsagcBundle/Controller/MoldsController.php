<?php

namespace NGPP\GmsagcBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use \NGPP\GmsagcBundle\Entity\Molds;
use \NGPP\GmsagcBundle\Form\Type\MoldsType;

/**
 * @Route("/molds")
 */
class MoldsController extends Controller
{
    /**
     * @Route("/{page}", name="ngpp_gmsagc_molds", requirements={"page" = "\d+"}, defaults={"page" = null})
     * @Template
     */
    public function indexAction($page = null)
    {
        //Use default value if user not logged in
        $max_items = !is_null($this->getUser()) ? 
                $this->getUser()->getResultsPerPage() : $this->container->getParameter('ngpp_gmsagc.results_per_page');
        
        $repo = $this->getDoctrine()->getManager()->getRepository('NGPPGmsagcBundle:Molds');
        
        $offset = is_null($page) ? null : $max_items * ($page - 1);
        $criteria = is_null($this->getRequest()->get('f')) ? null : $this->getRequest()->get('f');
        
        $molds = $repo->getList($criteria, $max_items, $offset);
        $pages = ceil($repo->getTotal($criteria) / $max_items);
        
        return array('molds' => $molds, 'pages' => $pages);
    }
    
    /**
     * @Route("/save/{id}", name="ngpp_gmsagc_molds_save", requirements={"id" = "\d+"}, defaults={"id" = null})
     * @Template
     */
    public function saveAction($id = null)
    {
        $em = $this->getDoctrine()->getManager();
        
        //Determine if editing or creating
        $mold = !is_null($id) && !is_null($mold = $em->getRepository('NGPPGmsagcBundle:Molds')->find($id)) ? 
                $mold : new Molds($em->getRepository('NGPPGmsagcBundle:Molds')->getNewId());
                        
        $form = $this->createForm(new MoldsType(), $mold);
        $form->handleRequest($this->getRequest());
        
        if ($form->isValid()) {

            $em->persist($mold);
            $em->flush();

            $this->get('session')->getFlashBag()->add('success',
                $this->get('translator')->trans('molds.saved'));

            return $this->redirect($this->generateUrl('ngpp_gmsagc_molds'));
        }
        
        return array('form' => $form->createView());
    }
    
    /**
     * @Route("/delete/{id}", name="ngpp_gmsagc_molds_delete", requirements={"id" = "\d+"})
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $mold = $em->getRepository('NGPPGmsagcBundle:Molds')->find($id);

        if ($mold)
        {
            $em->remove($mold);
            $em->flush();
            
            $this->get('session')->getFlashBag()->add('success',
                    $this->get('translator')->trans('molds.deleted'));
        }
        else
            $this->get('session')->getFlashBag()->add('error',
                    $this->get('translator')->trans('molds.nodeleted'));
        
        return $this->redirect($this->generateUrl('ngpp_gmsagc_molds'));
    }
}
