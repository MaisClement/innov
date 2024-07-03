<?php
namespace App\Controller;

use App\Entity\Idea;
use App\Repository\AccountRepository;
use App\Repository\IdeaRepository;
use App\Service\Functions;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Profile extends AbstractController
{
    private IdeaRepository $ideaRepository;
    private AccountRepository $accountRepository;
    private Functions $functions;
    
    public function __construct(IdeaRepository $ideaRepository, AccountRepository $accountRepository, Functions $functions)
    {
        $this->ideaRepository = $ideaRepository;
        $this->accountRepository = $accountRepository;
        $this->functions = $functions;
    }

    #[Route('/profile')]
    public function profile()
    {
        Functions::checkUserSession($this->accountRepository);

        $_ideas = $this->ideaRepository->findAll();
        $ideas = [];
        foreach ($_ideas as $idea) {
            $ideas[] = [
                'title_idea' => $idea->getTitle(),
                'details_idea' => $idea->getDetails(),
                'choice_mesures' => $idea->getChoiceMesures(),
                'details_mesures' => $idea->getDetailsMesures(),
                'choice_funding' => $idea->getChoiceFunding(),
                'funding_details' => $idea->getDetailsFunding(),
                'team' => $idea->getTeam(),
                'author_id' => $idea->getAuthor()->getId(),
                'idea_id' => $idea->getId(),
                'first_name' => $idea->getAuthor()->getGivenName(),
                'family_name' => $idea->getAuthor()->getFamilyName(),
                'creationDateTime' => $idea->getCreationDateTime(),
                'validator_id' => $idea->getValidator() != null ? $idea->getValidator()->getId() : "",
                'validator_givenname' => $idea->getValidator() != null ? $idea->getValidator()->getGivenName() : "",
                'validator_familyname' => $idea->getValidator() != null ? $idea->getValidator()->getFamilyName() : "",
                'state_idea' => $idea->getState(),
                'user_id' => $_SESSION['account_id'],
            ];
        }

        $account = $this->accountRepository->find($_SESSION['account_id']);
        $comments = $account->getComments();
        $idea = $account->getIdeas();
        $_comments = [];
        foreach ($comments as $commentary) {
            $_comments[] = [
                'comment_id' => $commentary->getId(),
                'author_givenname' => $commentary->getAuthor()->getGivenName(),
                'author_familyname' => $commentary->getAuthor()->getFamilyName(),
                'comment_idea_id' => $commentary->getRelatedIdea()->getTitle(),
                'content_comment' => $commentary->getMessage(),
                'create_comment' => $commentary->getCreationDateTime(),
            ];
        }

        $data = [
            'is_admin' => in_array('admin', $_SESSION['role']) ? 'true' : 'false',
            'family_name' => $_SESSION['family_name'],
            'given_name' => $_SESSION['given_name'],
            'mail' => $_SESSION['upn'],
            'account_id' => $_SESSION['account_id'],
            'ideas' => $ideas,
            'comments' => $_comments,
        ];
        return $this->render('profile.html.twig', $data);
    }
}
