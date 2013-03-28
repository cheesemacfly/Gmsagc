<?php

namespace NGPP\GmsagcBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use \NGPP\GmsagcBundle\Entity\Contacts;
use \NGPP\GmsagcBundle\Form\Type\ContactsType;

class ContactsController extends Controller
{
    public function indexAction()
    {
        return $this->render('NGPPGmsagcBundle:Contacts:index.html.twig',
                array('contacts' => $this->getDoctrine()->getRepository('NGPPGmsagcBundle:Contacts')->findAll()));
    }
    
    public function saveAction($id = null)
    {
        $em = $this->getDoctrine()->getManager();
        
        //Determine if editing or creating
        $contact = !is_null($id) && !is_null($contact = $em->getRepository('NGPPGmsagcBundle:Contacts')->find($id)) ? 
                $contact : new Contacts();
        
        $form = $this->createForm(new ContactsType(), $contact);

        if ($this->getRequest()->isMethod('POST')) {
            
            //Hanldes delete of address
            $originalAddresses = array();
            // Create an array of the current Addresses objects in the database
            foreach ($contact->getAddresses() as $address) {
                $originalAddresses[] = $address;
            }
            
            $form->bind($this->getRequest());
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
        }
        
        return $this->render('NGPPGmsagcBundle:Contacts:save.html.twig',
                array('form' => $form->createView()));
    }
    
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
