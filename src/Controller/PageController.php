<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PageController extends AbstractController
{
    /**
     * @Route("/hello", name="hello")
     */
    public function index(): Response
    {
        return $this->render('page/index.html.twig');
    }

    /**
     * @Route("/auth", name="auth")
     * @IsGranted("ROLE_USER")
     */
    public function auth(): Response
    {
        return $this->render('page/index.html.twig');
    }

    /**
     * @Route("/admin", name="admin")
     * @IsGranted("ROLE_ADMIN")
     */
    public function admin(): Response
    {
        return $this->render('page/index.html.twig');
    }
}
