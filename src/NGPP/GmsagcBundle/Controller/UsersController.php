<?php

namespace NGPP\GmsagcBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use \NGPP\GmsagcBundle\Entity\Users;
use \NGPP\GmsagcBundle\Form\Type\UsersType;
use \NGPP\GmsagcBundle\Form\Type\UsersPasswordEditType;

class UsersController extends Controller
{
    public function loginAction()
    {
        $request = $this->getRequest();
        $session = $request->getSession();

        // get the login error if there is one
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(
                SecurityContext::AUTHENTICATION_ERROR
            );
        } else {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        }

        return $this->render(
            'NGPPGmsagcBundle:Users:login.html.twig',
            array(
                // last username entered by the user
                'last_username' => $session->get(SecurityContext::LAST_USERNAME),
                'error'         => $error,
            )
        );
    }
    
    public function indexAction($page = null)
    {
        //Use default value if user not logged in
        $max_items = !is_null($this->getUser()) ? 
                $this->getUser()->getResultsPerPage() : $this->container->getParameter('ngpp_gmsagc.results_per_page');
        
        $repo = $this->getDoctrine()->getManager()->getRepository('NGPPGmsagcBundle:Users');
        
        $offset = is_null($page) ? null : $max_items * ($page - 1);
        $criteria = is_null($this->getRequest()->get('f')) ? null : $this->getRequest()->get('f');
        
        $users = $repo->getList($criteria, $max_items, $offset);
        $pages = ceil($repo->getTotal($criteria) / $max_items);
        
        return $this->render('NGPPGmsagcBundle:Users:index.html.twig', array('users' => $users, 'pages' => $pages));
    }
    
    public function saveAction($id = null)
    {
        $em = $this->getDoctrine()->getManager();
        
        //Determine if editing or creating
        $user = !is_null($id) && !is_null($user = $em->getRepository('NGPPGmsagcBundle:Users')->find($id)) ? 
                $user : new Users();
        
        $form = $this->createForm(new UsersType(), $user);
        $form->handleRequest();

        if ($form->isValid()) {

            //Encode password only when creating user
            if($user->getId() === null)
            {
                $encoder = $this->container->get('security.encoder_factory')->getEncoder($user);
                $user->setPassword($encoder->encodePassword($user->getPassword(), $user->getSalt()));
            }

            $em->persist($user);
            $em->flush();

            $this->get('session')->getFlashBag()->add('success',
                $this->get('translator')->trans('users.saved'));

            return $this->redirect($this->generateUrl('ngpp_gmsagc_users'));
        }
        
        return $this->render('NGPPGmsagcBundle:Users:save.html.twig',
                array('form' => $form->createView()));
    }
    
    public function passwordAction($id = null)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('NGPPGmsagcBundle:Users')->find($id);

        if ($user){
            
            $form = $this->createForm(new UsersPasswordEditType(), $user);
            $form->handleRequest();
            
            if ($form->isValid()) {

                $encoder = $this->container->get('security.encoder_factory')->getEncoder($user);
                $user->setPassword($encoder->encodePassword($user->getPassword(), $user->getSalt()));

                $em->persist($user);
                $em->flush();

                $this->get('session')->getFlashBag()->add('success',
                    $this->get('translator')->trans('users.saved'));

                return $this->redirect($this->generateUrl('ngpp_gmsagc_users'));
            }
        }
        else        
            return $this->redirect($this->generateUrl('ngpp_gmsagc_users'));
        
        return $this->render('NGPPGmsagcBundle:Users:password.html.twig',
                array('form' => $form->createView()));
    }
    
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('NGPPGmsagcBundle:Users')->find($id);

        if ($user){
            
            $em->remove($user);
            $em->flush();
            
            $this->get('session')->getFlashBag()->add('success',
                    $this->get('translator')->trans('users.deleted'));
        }
        else
            $this->get('session')->getFlashBag()->add('error',
                    $this->get('translator')->trans('users.nodeleted'));
        
        return $this->redirect($this->generateUrl('ngpp_gmsagc_users'));
    }
}