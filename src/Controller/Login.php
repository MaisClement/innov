<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;

class Login extends AbstractController
{
    public function __construct()
    {
       
    }

    #[Route('/login')]
    public function login()
    {
        $token = $_SESSION['token'] ?? null;

        if ($token != null) {
            return $this->redirect('/account');
        }
        return $this->render('login.html');
    }

    #[Route('/logout')]
    public function logout(): Response
    {
        unset($_SESSION);
        return $this->redirect('/login');
        // $success = 'Vous êtes bien déconnecté';
        // return $this->render('login.html', [
        //     'error' => $message ?? null,
        //     'success' => $success,
        // ]);
    }
}