<?php

namespace NGPP\GmsagcBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use \NGPP\GmsagcBundle\Entity\Relations;
use \NGPP\GmsagcBundle\Entity\Orders;

/**
 * @Route("/orders")
 */
class OrdersController extends Controller
{
    /**
     * @Route("/{page}", name="ngpp_gmsagc_orders", requirements={"page" = "\d+"}, defaults={"page" = null})
     * @Template
     */
    public function indexAction($page = null)
    {
        //Use default value if user not logged in
        $max_items = !is_null($this->getUser()) ? 
                $this->getUser()->getResultsPerPage() : $this->container->getParameter('ngpp_gmsagc.results_per_page');
        
        $repo = $this->getDoctrine()->getManager()->getRepository('NGPPGmsagcBundle:Orders');
        
        $offset = is_null($page) ? null : $max_items * ($page - 1);
        $criteria = is_null($this->getRequest()->get('f')) ? null : $this->getRequest()->get('f');
        
        $orders = $repo->getList($criteria, $max_items, $offset);
        $pages = ceil($repo->getTotal($criteria) / $max_items);
        
        return array('orders' => $orders, 'pages' => $pages);
    }
    
    /**
     * @Route("/save/{id}", name="ngpp_gmsagc_orders_save", requirements={"id" = "\d+"}, defaults={"id" = null})
     * @Template
     */
    public function saveAction($id = null)
    {
        $em = $this->getDoctrine()->getManager();
        
        if(is_null($id) || is_null($order = $em->getRepository('NGPPGmsagcBundle:Orders')->find($id)))
        {
            $order = new Orders();
            
            $customer_relation = new Relations();
            $customer_type_id = $this->container->getParameter('ngpp_gmsagc.types')['customer'];
            $customer_relation->setType($em->getRepository('NGPPGmsagcBundle:Types')->findOneById($customer_type_id));
            $order->addRelations($customer_relation);
            
            $owner_relation = new Relations();
            $owner_type_id = $this->container->getParameter('ngpp_gmsagc.types')['owner'];
            $owner_relation->setType($em->getRepository('NGPPGmsagcBundle:Types')->findOneById($owner_type_id));
            $order->addRelations($owner_relation);
        }
        
        $form = $this->createForm($this->get('ngpp_gmsagc.form.orders'), $order);
        $form->handleRequest($this->getRequest());
            
        if ($form->isValid()) {

            $em->persist($order);
            $em->flush();

            //Update relations now that order_id is set
            foreach($order->getRelations() as $relation)
            {
                $relation->setOrder($order);

                $em->persist($relation);
            }
            $em->flush();

            $this->get('session')->getFlashBag()->add('success',
                $this->get('translator')->trans('orders.saved'));

            return $this->redirect($this->generateUrl('ngpp_gmsagc_orders'));
        }
        
        return array('form' => $form->createView());
    }
    
    /**
     * @Route("/delete/{id}", name="ngpp_gmsagc_orders_delete", requirements={"id" = "\d+"})
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $order = $em->getRepository('NGPPGmsagcBundle:Orders')->find($id);

        if ($order)
        {
            foreach ($order->getRelations() as $relation) {
                $em->remove($relation);
            }
            
            $em->remove($order);
            $em->flush();
            
            $this->get('session')->getFlashBag()->add('success',
                    $this->get('translator')->trans('orders.deleted'));
        }
        else
            $this->get('session')->getFlashBag()->add('error',
                    $this->get('translator')->trans('orders.nodeleted'));
        
        return $this->redirect($this->generateUrl('ngpp_gmsagc_orders'));
    }
    
    /**
     * @Route("/ajax/save", name="ngpp_gmsagc_ajax_orders_save")
     * @Template("NGPPGmsagcBundle:Orders:save.html.twig")
     */
    public function ajaxsaveAction()
    {
        $form = $this->createForm($this->get('ngpp_gmsagc.form.orders'), new Orders());
        $form->handleRequest($this->getRequest());
        
        return array('form' => $form->createView());
    }
}
