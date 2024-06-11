<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;

class Ideas extends AbstractController
{
    public function __construct()
    {
        
    }

    #[Route('/recap_idea')]
    public function ideas()
    {
        $data = [
            "title_idea" => $_POST['title_idea'],
            "details_idea" => $_POST['details_idea'],
            "choice_mesures" => $_POST['mesures'],
            "details_mesures" => $_POST['details_mesures'],
            "choice_funding" => $_POST['funding'],
            "funding_details" => $_POST['funding_details'],
            "team" => $_POST['team'],

            // Récuperer les données de l'idée 
            // (titre, détails, choix pour les mesures que l'utilisateur prend, 
            // du financement et du quel responsable à envoyer le projet) 
            // Tout ça dans les tables idea et manager ! 
            // Enfin faire en sorte de l'afficher sur une page récapitulative avec les infos de l'utilisateur et de l'idée.
        ];
        return $this->render('recap_idea.html.twig', $data);
    }

    // Créer une fonction permettant d'ajouter dans la base de données l'idée complète.
    // Puis créer une fonction permettant de gérer le statut de l'idée.
}