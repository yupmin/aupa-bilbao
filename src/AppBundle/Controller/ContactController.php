<?php

namespace AppBundle\Controller;

use AppBundle\Form\Type\ContactType;
use AppBundle\Service\AppMailer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ContactController extends Controller
{
    /**
     * @Route("/contact")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function contactAction(Request $request)
    {
        $form = $this->createForm(new ContactType(), null, [
            'action' => $this->generateUrl('app_contact_contact'),
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /**
             * @var AppMailer $appmailer
             */
            $appmailer = $this->get('appmailer');
            $text = 'From: ' . $form->get('name')->getData();
            $text .= ' Email: ' . $form->get('email')->getData();
            $text .= ' Message: ' . $form->get('message')->getData();

            $appmailer->sendEmail(
                'youremail@domain.com',
                'Contact Form',
                $text
            );

            return $this->redirectToRoute('app_contact_contact');
        }

        $requestStack = $this->get('request_stack')->getParentRequest();
        if ($requestStack) {
            $modalContent = $this->renderView('component/contact_form.html.twig', [
               'contactform' => $form->createView(),
            ]);

            return $this->render('component/modal.html.twig', [
                'identifier' => 'contactModal',
                'title' => 'Contact Form',
                'content' => $modalContent,
            ]);
        }

        return $this->render('contact/contact.html.twig', [
            'contactform' => $form->createView(),
        ]);
    }
}
