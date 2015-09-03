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
            $message = \Swift_Message::newInstance()
                ->setSubject('Contact enquiry from EnglishClass')
                ->setFrom('cheynede@gmail.com') # ADRESSE MAIL DU SITE
                ->setTo($this->container->getParameter('blogger_blog.emails.contact_email'))
                ->setBody($this->renderView('BloggerBlogBundle:Page:contactEmail.txt.twig', array('enquiry' => $oEnquiry)));
            $this->get('mailer')->send($message);

            $request->getSession()->getFlashBag()->add('notice','Your contact enquiry was successfully sent. Thank you!');



            // Perform some action, such as sending an email
//            $em = $this->getDoctrine()->getManager();
//            $em->persist($oEnquiry);
//            $em->flush();
            return $this->redirect($this->generateUrl('BloggerBlogBundle_contact'));
        }

        return $this->render('BloggerBlogBundle:Page:contact.html.twig', array(
            'form' => $form->createView()
        ));

        return $this->render('BloggerBlogBundle:Page:contact.html.twig');
    }
}