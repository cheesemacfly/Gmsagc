<?php

namespace NGPP\GmsagcBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use \NGPP\GmsagcBundle\Entity\Press;

class PressController extends Controller
{
    public function listAction($limit = 10)
    {
        $repo = $this->getDoctrine()->getEntityManager()->getRepository('NGPPGmsagcBundle:Press');
        $press = $repo->createQueryBuilder('p')
                ->where('p.name LIKE :name')
                ->setParameter('name', '%ert%')
                ->getQuery()->getResult();
        
        return new JsonResponse($press);
    }
}
