<?php
namespace App\Controller\back;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    /**
     * @Route("/bo/main", name="bo_main")
     */
    public function main()
    {
        // dump('here');

        // return $this->render('BO/back-main.html.twig');
        return $this->render('Security/login_bo.html.twig');
    }

}