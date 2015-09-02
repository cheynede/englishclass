<?php
// src/Blogger/BlogBundle/Controller/PageController.php

namespace Blogger\BlogBundle\Controller;

use Blogger\BlogBundle\Entity\Enquiry;
use Blogger\BlogBundle\Form\EnquiryType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PageController extends Controller
{
    public function indexAction()
    {
        return $this->render('BloggerBlogBundle:Page:index.html.twig');
    }
    public function aboutAction()
    {
        return $this->render('BloggerBlogBundle:Page:about.html.twig');
    }
    public function contactAction(Request $request)
    {
        $oEnquiry = new Enquiry();

        $form = $this->createForm(new EnquiryType(), $oEnquiry);

        $form->handleRequest($request);

        if ($form->isValid()) {
            // Perform some action, such as sending an email
            $em = $this->getDoctrine()->getManager();
            $em->persist($oEnquiry);
            $em->flush();
            return $this->redirect($this->generateUrl('BloggerBlogBundle_contact'));
            }

        return $this->render('BloggerBlogBundle:Page:contact.html.twig', array(
            'form' => $form->createView()
        ));

        return $this->render('BloggerBlogBundle:Page:contact.html.twig');
    }
}