<?php
namespace App\Controller;

use App\Entity\Idea;
use App\Entity\Role;
use App\Repository\IdeaRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;

class Home extends AbstractController
{
    private IdeaRepository $ideaRepository;

    public function __construct(IdeaRepository $ideaRepository)
    {
        $this->ideaRepository = $ideaRepository;
    }

    #[Route('/')]
    #[Route('/home')]
    public function home(Request $request) 
    {
        if ($_SESSION == null) {
            return $this->redirect('/login');
        }
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

    // dd($_SESSION['role']);
    // dd(in_array('admin',$_SESSION['role']) ? 'true' : 'false');
    $data = [
        'given_name' => $_SESSION['given_name'],
        'family_name'=>$_SESSION['family_name'],
        'user_id' => $_SESSION['account_id'],
        'is_admin' => in_array('admin', $_SESSION['role']) ? 'true' : 'false',
        'ideas' => $ideas,
    ];
    return $this->render('home.html.twig', $data);
    }
}