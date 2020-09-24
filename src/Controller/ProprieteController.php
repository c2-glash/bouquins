<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Collections\ArrayCollection;

use function PHPSTORM_META\map;

class ProprieteController extends AbstractController
{
    /**
     * @Route("/meslivres", name="propriete")
     */
    public function index()
    {
        return $this->render('propriete/meslivres.html.twig');
    }
}
