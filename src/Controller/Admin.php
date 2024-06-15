<?php
namespace App\Controller;

use App\Entity\Idea;
use App\Entity\Account;
use App\Repository\IdeaRepository;
use App\Repository\AccountRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class Admin extends AbstractController
{
    private IdeaRepository $ideaRepository;
    private AccountRepository $accountRepository;
    private $entityManager;

    public function __construct(IdeaRepository $ideaRepository, AccountRepository $accountRepository, EntityManagerInterface $entityManager)
    {
        $this->ideaRepository = $ideaRepository;
        $this->accountRepository = $accountRepository;
        $this->entityManager = $entityManager;
    }

    #[Route('/admin')]
    public function admin()
    {
        $data = [ 
            'family_name'=>$_SESSION['family_name'], 
            'given_name' => $_SESSION['given_name'],
            'mail' => $_SESSION['upn'],
          ];
        return $this->render('admin/admin.html', $data);
    }

    // ROUTE DES PAGES POUR GÉRER LES IDÉES

    #[Route('/admin/manage_ideas')]
    public function manageidea()
    {
        $_ideas = $this->ideaRepository->findAll(); 

        $ideas = [];
        foreach($_ideas as $idea){
            $ideas[] = [
                "title_idea" => $idea->getTitle(),
                "details_idea" => $idea->getDetails(),
                "choice_mesures" => $idea->getChoiceMesures(),
                "details_mesures" => $idea->getDetailsMesures(),
                "choice_funding" => $idea->getChoiceFunding(),
                "funding_details" => $idea->getDetailsFunding(),
                "team" => $idea->getTeam(),
                "author_id" => $idea->getAuthor()->getId(),
                "idea_id" => $idea->getId(),
                "first_name" => $idea->getAuthor()->getGivenName(),
                "family_name" => $idea->getAuthor()->getFamilyName(),
                "creationDateTime" => $idea->getCreationDateTime(),
                "state_idea" => $idea->getState(),
        ];
    }
        $data = [
            "ideas" => $ideas,
        ];

        return $this->render('admin/manage_ideas.html.twig', $data);
    }

    #[Route('/admin/show_ideas')]
    public function showidea()
    {
        $_ideas = $this->ideaRepository->findAll(); 

        $ideas = [];
        foreach($_ideas as $idea){
            $ideas[] = [
                "title_idea" => $idea->getTitle(),
                "details_idea" => $idea->getDetails(),
                "choice_mesures" => $idea->getChoiceMesures(),
                "details_mesures" => $idea->getDetailsMesures(),
                "choice_funding" => $idea->getChoiceFunding(),
                "funding_details" => $idea->getDetailsFunding(),
                "team" => $idea->getTeam(),
                "author_id" => $idea->getAuthor()->getId(),
                "idea_id" => $idea->getId(),
                "first_name" => $idea->getAuthor()->getGivenName(),
                "family_name" => $idea->getAuthor()->getFamilyName(),
                "creationDateTime" => $idea->getCreationDateTime(),
                "state_idea" => $idea->getState(),
        ];

        $data = [ 
            "ideas" => $ideas, 
        ];
    }
        return $this->render('admin/show_ideas.html.twig', $data);
    }

    #[Route('/admin/modify_ideas/{id}')]
    public function modifyidea(Request $request, $id)
    {
        $_idea = $this->ideaRepository->find($id);
        
        $data = [
            "title_idea" => $_idea->getTitle(),
            "details_idea" => $_idea->getDetails(),
            "choice_mesures" => $_idea->getChoiceMesures(),
            "details_mesures" => $_idea->getDetailsMesures(),
            "choice_funding" => $_idea->getChoiceFunding(),
            "funding_details" => $_idea->getDetailsFunding(),
            "idea_id" => $_idea->getId(),
            "team" => $_idea->getTeam(),
            "author_id" => $_idea->getAuthor()->getId(),
            "state" => $_idea->getState(),
        ];
        
        return $this->render('admin/modify_ideas.html.twig', $data);
    }
    

    
    // ROUTES DES PAGES POUR GÉRER LES PROFILS

    #[Route('/admin/show_profiles')]
    public function showprofiles()
    {
        $_accounts = $this->accountRepository->findAll(); 

        $accounts = [];
        foreach($_accounts as $account){
            $accounts[] = [
                "account_id" => $account->getId(),
                "family_name" => $account->getFamilyName(),
                "given_name" => $account->getGivenName(),
                "mail" => $account->getEmail(),
                "msOid" => $account->getMsOid(),
        ];

        $data = [ 
            "accounts" => $accounts, 
        ];
    }

        return $this->render('admin/show_profiles.html.twig', $data);
    }

}