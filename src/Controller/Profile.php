<?php
namespace App\Controller;

use App\Entity\Idea;
use App\Repository\IdeaRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;

class Profile extends AbstractController
{
    private IdeaRepository $ideaRepository;
    public function __construct(IdeaRepository $ideaRepository)
    {
        $this->ideaRepository = $ideaRepository;
    }

    #[Route('/profile')]
    public function profile()
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
                'user_id' => $_SESSION['account_id'],
            ];
        }
            $data = [ 
                'family_name'=>$_SESSION['family_name'], 
                'given_name' => $_SESSION['given_name'],
                'mail' => $_SESSION['upn'],
                'ideas' => $ideas,
            ];
            return $this->render('profile.html.twig', $data);
    }
}