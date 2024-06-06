<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;

class Home extends AbstractController
{
    public function __construct()
    {
        
    }

    #[Route('/home')]
    public function home()
    {
        return $this->render('home.html');
    }
}