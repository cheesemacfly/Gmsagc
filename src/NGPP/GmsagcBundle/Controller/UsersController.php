<?php

namespace NGPP\GmsagcBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use \NGPP\GmsagcBundle\Entity\Users;
use \NGPP\GmsagcBundle\Form\Type\UsersType;

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
    
    public function indexAction()
    {
        return $this->render('NGPPGmsagcBundle:Users:index.html.twig',
                array('users' => $this->getDoctrine()->getRepository('NGPPGmsagcBundle:Users')->findAll()));
    }
    
    public function saveAction($id = null)
    {
        $em = $this->getDoctrine()->getManager();
                
        //Determine if editing or creating
        $user = !is_null($id) && !is_null($user = $em->getRepository('NGPPGmsagcBundle:Users')->find($id)) ? 
                $user : new Users();
        
        $form = $this->createForm(new UsersType(), $user);

        if ($this->getRequest()->isMethod('POST')) {
            
            if ($form->bind($this->getRequest())->isValid()) {
                
                $em->persist($user);
                $em->flush();

                $this->get('session')->getFlashBag()->add('success',
                    $this->get('translator')->trans('users.saved'));
                
                return $this->redirect($this->generateUrl('ngpp_gmsagc_users'));
            }
        }
        
        return $this->render('NGPPGmsagcBundle:Users:save.html.twig',
                array('form' => $form->createView()));
    }
    
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('NGPPGmsagcBundle:Users')->find($id);

        if ($user)
        {            
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