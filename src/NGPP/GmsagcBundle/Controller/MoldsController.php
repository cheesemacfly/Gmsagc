<?php

namespace NGPP\GmsagcBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use \NGPP\GmsagcBundle\Entity\Molds;
use \NGPP\GmsagcBundle\Form\Type\MoldsType;

class MoldsController extends Controller
{
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
        
        return $this->render('NGPPGmsagcBundle:Molds:index.html.twig', array('molds' => $molds, 'pages' => $pages));
    }
    
    public function saveAction($id = null)
    {
        $em = $this->getDoctrine()->getManager();
        
        //Determine if editing or creating
        $mold = !is_null($id) && !is_null($mold = $em->getRepository('NGPPGmsagcBundle:Molds')->find($id)) ? 
                $mold : new Molds($em->getRepository('NGPPGmsagcBundle:Molds')->getNewId());
                        
        $form = $this->createForm(new MoldsType(), $mold);

        if ($this->getRequest()->isMethod('POST')) {
            
            if ($form->bind($this->getRequest())->isValid()) {
                
                $em->persist($mold);
                $em->flush();

                $this->get('session')->getFlashBag()->add('success',
                    $this->get('translator')->trans('molds.saved'));
                
                return $this->redirect($this->generateUrl('ngpp_gmsagc_molds'));
            }
        }
        
        return $this->render('NGPPGmsagcBundle:Molds:save.html.twig',
                array('form' => $form->createView()));
    }
    
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
