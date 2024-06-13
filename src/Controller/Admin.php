<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;

class Admin extends AbstractController
{
    public function __construct()
    {
        
    }

    #[Route('/admin')]
    public function admin()
    {
        $data = [ 
            'family_name'=>$_SESSION['family_name'], 
            'given_name' => $_SESSION['given_name'],
            'mail' => $_SESSION['upn'],
          ];
        return $this->render('admin.html', $data);
    }
}