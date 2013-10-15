<?php

namespace NGPP\GmsagcBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use \NGPP\GmsagcBundle\Entity\Contacts;
use \NGPP\GmsagcBundle\Form\Type\ContactsType;

/**
 * @Route("/contacts")
 */
class ContactsController extends Controller
{
    /**
     * @Route("/{page}", name="ngpp_gmsagc_contacts", requirements={"page" = "\d+"}, defaults={"page" = null})
     * @Template
     */
    public function indexAction($page = null)
    {
        //Use default value if user not logged in
        $max_items = !is_null($this->getUser()) ? 
                $this->getUser()->getResultsPerPage() : $this->container->getParameter('ngpp_gmsagc.results_per_page');
        
        $repo = $this->getDoctrine()->getManager()->getRepository('NGPPGmsagcBundle:Contacts');
        
        $offset = is_null($page) ? null : $max_items * ($page - 1);
        $criteria = is_null($this->getRequest()->get('f')) ? null : $this->getRequest()->get('f');

        $contacts = $repo->getPaginator($criteria, $max_items, $offset);
        $pages = ceil(count($contacts) / $max_items);
        
        return array('contacts' => $contacts, 'pages' => $pages);
    }
    
    /**
     * @Route("/save/{id}", name="ngpp_gmsagc_contacts_save", requirements={"id" = "\d+"}, defaults={"id" = null})
     * @Template
     */
    public function saveAction($id = null)
    {
        $em = $this->getDoctrine()->getManager();
                
        //Determine if editing or creating
        $contact = !is_null($id) && !is_null($contact = $em->getRepository('NGPPGmsagcBundle:Contacts')->find($id)) ? 
                $contact : new Contacts();
        
        $form = $this->createForm(new ContactsType(), $contact);
        $form->handleRequest($this->getRequest());

        //Hanldes delete of addresses
        $originalAddresses = array();
        // Create an array of the current Addresses objects in the database
        foreach ($contact->getAddresses() as $address) {
            $originalAddresses[] = $address;
        }

        if ($form->isValid()) {

            // filter $originalAddresses to contain Addresses no longer present
            foreach ($contact->getAddresses() as $address) {
                foreach ($originalAddresses as $key => $toDel) {
                    if ($toDel->getId() === $address->getId()) {
                        unset($originalAddresses[$key]);
                    }
                }
            }

            // remove the relationship between the Addresses and the Contact
            foreach ($originalAddresses as $address) {
                // remove the Address from the Contact
                $contact->getAddresses()->removeElement($address);
                // delete the Address entirely
                $em->remove($address);
            }

            $em->persist($contact);
            $em->flush();

            $this->get('session')->getFlashBag()->add('success',
                $this->get('translator')->trans('contacts.saved'));

            return $this->redirect($this->generateUrl('ngpp_gmsagc_contacts'));
        }
        
        return array('form' => $form->createView());
    }
    
    /**
     * @Route("/delete/{id}", name="ngpp_gmsagc_contacts_delete", requirements={"id" = "\d+"})
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $contact = $em->getRepository('NGPPGmsagcBundle:Contacts')->find($id);

        if ($contact)
        {
            // remove the relationship between the Address and the Contact
            foreach ($contact->getAddresses() as $address) {
                // delete the Address entirely
                $em->remove($address);
            }
            
            $em->remove($contact);
            $em->flush();
            
            $this->get('session')->getFlashBag()->add('success',
                    $this->get('translator')->trans('contacts.deleted'));
        }
        else
            $this->get('session')->getFlashBag()->add('error',
                    $this->get('translator')->trans('contacts.nodeleted'));
        
        return $this->redirect($this->generateUrl('ngpp_gmsagc_contacts'));
    }
}
