<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;

class Demo extends AbstractController
{
    public function __construct()
    {
        
    }

    #[Route('/demo')]
    public function demo()
    {
        return $this->render('demo.html');
    }
}