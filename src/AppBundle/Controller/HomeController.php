<?php

namespace AppBundle\Controller;

use Doctrine\Common\Persistence\ObjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller
{
    /**
     * @Route("/home", name="home")
     */
    public function indexAction()
    {
        /**
         * @var ObjectManager $em
         */
        $em = $this->getDoctrine()->getManager();
        $fimageRepository = $em->getRepository('AppBundle:FeaturedImage');
        $featuredImages = $fimageRepository->findCarouseImages();

        return $this->render('home/index.html.twig', [
            'featuredImages' => $featuredImages,
        ]);
    }
}
