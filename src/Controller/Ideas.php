<?php
namespace App\Controller;

use App\Entity\Idea;
use App\Entity\Comment;
use DateTimeInterface;
use App\Form\CommentsType;
use App\Repository\IdeaRepository;
use App\Repository\AccountRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class Ideas extends AbstractController
{

    private AccountRepository $accountRepository;
    private IdeaRepository $ideaRepository;

    public function __construct(EntityManagerInterface $entityManager, AccountRepository $accountRepository, IdeaRepository $ideaRepository)
    {
        $this->entityManager = $entityManager;
        $this->ideaRepository = $ideaRepository;
        $this->accountRepository = $accountRepository;
    }

    #[Route('/idea')]
    public function ideas(Request $request) : RedirectResponse
    {
       
        $author = $this->accountRepository->find($_SESSION['account_id']);
        
        $idea = new Idea();
        $idea->setTitle($request->request->get('title_idea'));
        $idea->setDetails($request->request->get('details_idea'));
        $idea->setChoiceMesures($request->request->get('mesures'));
        $idea->setDetailsMesures($request->request->get('details_mesures'));
        $idea->setChoiceFunding($request->request->get('funding'));
        $idea->setDetailsFunding($request->request->get('funding_details'));
        $idea->setAuthor($author);
        $idea->setTeam($request->request->get('team'));
        $idea->setState("waiting_approval");
        $idea->setCreationDateTime(new \DateTime());
        
        
        $this->entityManager->persist($idea);
        $this->entityManager->flush();
        
        return new RedirectResponse('/idea/'.$idea->getId());
    }
    // Récuperer les données de l'idée 
    // (titre, détails, choix pour les mesures que l'utilisateur prend, 
    // du financement et du quel responsable à envoyer le projet) 
    // Tout ça dans les tables idea et manager ! 
    // Enfin faire en sorte de l'afficher sur une page récapitulative avec les infos de l'utilisateur et de l'idée.

    #[Route('/idea/{id}')]
    public function display_idea($id)
    {
        $idea = $this->ideaRepository->find($id);
        $ideas = [];
        foreach($idea as $_idea){
            $ideas[] = [
                "title_idea" => $_idea->getTitle(),
                "details_idea" => $_idea->getDetails(),
                "choice_mesures" => $_idea->getChoiceMesures(),
                "details_mesures" => $_idea->getDetailsMesures(),
                "choice_funding" => $_idea->getChoiceFunding(),
                "funding_details" => $_idea->getDetailsFunding(),
                "team" => $_idea->getTeam(),
                "author_id" => $_idea->getAuthor()->getId(),
                "idea_id" => $_idea->getId(),
                "role" => $_SESSION['role'],
                "first_name" => $_idea->getAuthor()->getGivenName(),
                "family_name" => $_idea->getAuthor()->getFamilyName(),
                "creationDateTime" => $_idea->getCreationDateTime(),
                "state_idea" => $_idea->getState(),
            ]; 
        }
        
        $data = [
            "title_idea" => $idea->getTitle(),
            "details_idea" => $idea->getDetails(),
            "choice_mesures" => $idea->getChoiceMesures(),
            "details_mesures" => $idea->getDetailsMesures(),
            "choice_funding" => $idea->getChoiceFunding(),
            "funding_details" => $idea->getDetailsFunding(),
            "team" => $idea->getTeam(),
            "author_id" => $idea->getAuthor()->getId(),
            "idea_id" => $idea->getId(),
            'is_admin' => in_array('admin', $_SESSION['role']) ? 'true' : 'false',
            "state" => $idea->getState(),
            "user_id" => $_SESSION['account_id'],
            "comments" => $idea->getComments(),
            "ideas" => $ideas,
        ];


        return $this->render('/idea/recap_idea.html.twig', $data);
    }

    
    /**
     * @Route("/idea/{id}/valid", name="idea_validate")
    */
    public function validateIdea(Request $request, $id) : RedirectResponse
    {
        $idea = $this->ideaRepository->find($id);

        $idea->setState('in_progress');
        $this->entityManager->persist($idea);
        $this->entityManager->flush();
        
        return new RedirectResponse('/home');
    }

    /**
     * @Route("/idea/{id}/refuse", name="idea_refuse")
    */
    public function refusedIdea(Request $request, $id) : RedirectResponse
    {
        $idea = $this->ideaRepository->find($id);

        $idea->setState('refused');
        $this->entityManager->persist($idea);
        $this->entityManager->flush();

        return new RedirectResponse('/home');
    }


    /**
     * @Route("/idea/{id}/archived", name="idea_archived")
    */
    public function archivedIdea(Request $request, $id) : RedirectResponse
    {
        $idea = $this->ideaRepository->find($id);

        $idea->setState('is_archived');
        $this->entityManager->persist($idea);
        $this->entityManager->flush();

        return new RedirectResponse('/home');
    }

    /**
     * @Route("/idea/{id}/delete", name="idea_delete")
    */
    public function deleteIdea(Request $request, $id) : RedirectResponse
    {
        $idea = $this->ideaRepository->find($id);
        $this->entityManager->remove($idea);
        $this->entityManager->flush();

        return new RedirectResponse('/home');
    }
}