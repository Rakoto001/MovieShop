<?php
namespace App\Controller\BO;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="bo_main")
     */
    public function main()
    {
        dump('here');

        return $this->render('BO/common/base-bo.html.twig');
    }

}