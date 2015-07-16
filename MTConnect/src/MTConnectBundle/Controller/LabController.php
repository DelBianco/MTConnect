<?php

namespace MTConnectBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class LabController extends Controller
{
    public function indexAction()
    {
        return $this->render('MTConnectBundle:Lab:index.html.twig', array());
    }

    public function recordAction()
    {
        return $this->render('MTConnectBundle:Lab:record.html.twig', array());
    }

    public function configAction()
    {
        return $this->render('MTConnectBundle:Lab:config.html.twig', array());
    }



}
