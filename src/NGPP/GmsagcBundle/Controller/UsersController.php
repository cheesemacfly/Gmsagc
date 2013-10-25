<?php

namespace NGPP\GmsagcBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Core\SecurityContext;
use \NGPP\GmsagcBundle\Entity\Users;
use \NGPP\GmsagcBundle\Form\Type\UsersType;
use \NGPP\GmsagcBundle\Form\Type\UsersPasswordEditType;

/**
 * @Route("/users")
 */
class UsersController extends Controller
{
    /**
     * @Route("/login", name="login")
     * @Template
     */
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

        if(isset($error))
        {
            $this->get('session')->getFlashBag()->add('error', $this->get('translator')->trans($error->getMessageKey()));
        }

        return array('last_username' => $session->get(SecurityContext::LAST_USERNAME));
    }

    /**
     * @Route("/{page}", name="ngpp_gmsagc_users", requirements={"page" = "\d+"}, defaults={"page" = null})
     * @Template
     */
    public function indexAction($page = null)
    {
        //Use default value if user not logged in
        $max_items = !is_null($this->getUser()) ?
                $this->getUser()->getResultsPerPage() : $this->container->getParameter('ngpp_gmsagc.results_per_page');

        $repo = $this->getDoctrine()->getManager()->getRepository('NGPPGmsagcBundle:Users');

        $offset = is_null($page) ? null : $max_items * ($page - 1);
        $criteria = is_null($this->getRequest()->get('f')) ? null : $this->getRequest()->get('f');

        $users = $repo->getPaginator($criteria, $max_items, $offset);
        $pages = ceil(count($users) / $max_items);

        return array('users' => $users, 'pages' => $pages);
    }

    /**
     * @Route("/save/{id}", name="ngpp_gmsagc_users_save", requirements={"id" = "\d+"}, defaults={"id" = null})
     * @Template
     */
    public function saveAction($id = null)
    {
        $em = $this->getDoctrine()->getManager();

        //Determine if editing or creating
        $user = !is_null($id) && !is_null($user = $em->getRepository('NGPPGmsagcBundle:Users')->find($id)) ?
                $user : new Users();

        $form = $this->createForm(new UsersType(), $user);
        $form->handleRequest($this->getRequest());
        if ($form->isValid()) {

            //Encode password only when creating user
            if($user->getId() === null)
            {
                $encoder = $this->container->get('security.encoder_factory')->getEncoder($user);
                $user->setPassword($encoder->encodePassword($user->getPassword(), $user->getSalt()));
            }
            $em->persist($user);
            $em->flush();

            $this->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('users.saved'));
            return $this->redirect($this->generateUrl('ngpp_gmsagc_users'));
        }
        return array('form' => $form->createView());
    }

    /**
     * @Route("/password/{id}", name="ngpp_gmsagc_users_password", requirements={"id" = "\d+"}, defaults={"id" = null})
     * @Template
     */
    public function passwordAction($id = null)
    {
        if(is_null($id) && is_null($this->getUser()))
        {
            return $this->redirect($this->generateUrl('ngpp_gmsagc_home'));
        }

        $id = is_null($id) ? $this->getUser()->getId() : $id;

        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('NGPPGmsagcBundle:Users')->find($id);

        if ($user){
            $form = $this->createForm(new UsersPasswordEditType(), $user);
            $form->handleRequest($this->getRequest());

            if ($form->isValid()) {
                $encoder = $this->container->get('security.encoder_factory')->getEncoder($user);
                $user->setPassword($encoder->encodePassword($user->getPassword(), $user->getSalt()));

                $em->persist($user);
                $em->flush();

                $this->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('users.saved'));

                return $this->redirect($this->generateUrl('ngpp_gmsagc_users'));
            }
        }
        else
        {
            return $this->redirect($this->generateUrl('ngpp_gmsagc_home'));
        }

        return array('form' => $form->createView());
    }

    /**
     * @Route("/delete/{id}", name="ngpp_gmsagc_users_delete", requirements={"id" = "\d+"})
     */
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
        {
            $this->get('session')->getFlashBag()->add('error', $this->get('translator')->trans('users.nodeleted'));
        }

        return $this->redirect($this->generateUrl('ngpp_gmsagc_users'));
    }
}