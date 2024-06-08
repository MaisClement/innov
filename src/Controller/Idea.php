<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;

class Idea extends AbstractController
{
    public function __construct()
    {
        
    }

    #[Route('/idea')]
    public function idea()
    {   
        $data = [
            'family_name' => $_SESSION['family_name'],
            'given_name' => $_SESSION['given_name'],
            'mail' =>  $_SESSION['upn'],
        ];
        return $this->render('idea.html.twig', $data);
    }
}