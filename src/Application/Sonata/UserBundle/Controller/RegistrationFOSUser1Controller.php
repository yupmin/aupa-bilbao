<?php

namespace Application\Sonata\UserBundle\Controller;

use FOS\UserBundle\Model\UserInterface;
use Sonata\UserBundle\Controller\RegistrationFOSUser1Controller as BaseController;
use Symfony\Component\HttpFoundation\RedirectResponse;

class RegistrationFOSUser1Controller extends BaseController
{
    public function registerAction()
    {
        $user = $this->getUser();

        if ($user instanceof UserInterface) {
            $this->get('session')->getFlashBag()->set('sonata_user_error', 'sonata_user_already_authenticated');

            return $this->redirect($this->generateUrl('sonata_user_profile_show'));
        }

        $form = $this->get('sonata.user.registration.form');
        $formHandler = $this->get('sonata.user.registration.form.handler');
        $confirmationEnabled = $this->container->getParameter('fos_user.registration.confirmation.enabled');

        $process = $formHandler->process($confirmationEnabled);
        if ($process) {
            $user = $form->getData();

            $authUser = false;
            if ($confirmationEnabled) {
                $this->get('session')->set('fos_user_send_confirmation_email/email', $user->getEmail());
                $url = $this->generateUrl('fos_user_registration_check_email');
            } else {
                $authUser = true;
                $route = $this->get('session')->get('sonata_basket_delivery_redirect');

                if (null !== $route) {
                    $this->get('session')->remove('sonata_basket_delivery_redirect');
                    $url = $this->generateUrl($route);
                } else {
                    $url = $this->get('session')->get('sonata_user_redirect_url');
                }

                if (null === $route) {
                    $url = $this->generateUrl('sonata_user_profile_show');
                }
            }

            $this->setFlash('fos_user_success', 'registration.flash.user_created');

            $response = new RedirectResponse($url);

            if ($authUser) {
                $this->authenticateUser($user, $response);
            }

            return $response;
        }

        $this->get('session')->set('sonata_user_redirect_url', $this->get('request')->headers->get('referer'));

        // Check if it's a subrequest
        $requestStack = $this->container->get('request_stack')->getParentRequest();
        if ($requestStack) {
            return $this->render('default/register.html.'.$this->getEngine(), [
                'form' => $form->createView(),
            ]);
        }

        return $this->render('FOSUserBundle:Registration:register.html.'.$this->getEngine(), array(
            'form' => $form->createView(),
        ));
    }
}
