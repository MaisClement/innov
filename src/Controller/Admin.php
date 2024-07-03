<?php
namespace App\Controller;

use Knp\Component\Pager\PaginatorInterface;
use App\Entity\Account;
use App\Entity\Answer;
use App\Entity\Comment;
use App\Entity\Idea;
use App\Entity\Role;
use App\Entity\Files;
use App\Repository\AccountRepository;
use App\Repository\AnswerRepository;
use App\Repository\CommentRepository;
use App\Repository\IdeaRepository;
use App\Repository\FilesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use DateTimeInterface;
use App\Service\Functions;

class Admin extends AbstractController
{
    private IdeaRepository $ideaRepository;
    private AccountRepository $accountRepository;
    private AnswerRepository $answerRepository;
    private FilesRepository $filesRepository;
    private $entityManager;
    private Functions $functions;

    public function __construct(Functions $functions,FilesRepository $filesRepository, IdeaRepository $ideaRepository, AccountRepository $accountRepository, AnswerRepository $answerRepository, CommentRepository $commentRepository, EntityManagerInterface $entityManager)
    {
        $this->ideaRepository = $ideaRepository;
        $this->filesRepository = $filesRepository;
        $this->accountRepository = $accountRepository;
        $this->answerRepository = $answerRepository;
        $this->commentRepository = $commentRepository;
        $this->entityManager = $entityManager;
    }

    #[Route('/admin')]
    public function admin()
    {
        Functions::checkUserSession($this->accountRepository);
        Functions::checkRoleAdmin();

        $idea = $this->ideaRepository->findAll();

        $ideas = [];
        foreach ($idea as $_idea) {
            $ideas[] = [
                'title_idea' => $_idea->getTitle(),
                'details_idea' => $_idea->getDetails(),
                'choice_mesures' => $_idea->getChoiceMesures(),
                'details_mesures' => $_idea->getDetailsMesures(),
                'choice_funding' => $_idea->getChoiceFunding(),
                'funding_details' => $_idea->getDetailsFunding(),
                'team' => $_idea->getTeam(),
                'author_id' => $_idea->getAuthor()->getId(),
                'idea_id' => $_idea->getId(),
                // 'validator_id' => $idea->getValidator() != null ? $idea->getValidator()->getId() : "",
                //'validator_givenname' => $idea->getValidator() != null ? $idea->getValidator()->getGivenName() : "",
                // 'validator_familyname' => $idea->getValidator() != null ? $idea->getValidator()->getFamilyName() : "",
                'first_name' => $_idea->getAuthor()->getGivenName(),
                'family_name' => $_idea->getAuthor()->getFamilyName(),
                'creationDateTime' => $_idea->getCreationDateTime(),
                'state_idea' => $_idea->getState(),
            ];
        }
        $data = [
            'family_name' => $_SESSION['family_name'],
            'given_name' => $_SESSION['given_name'],
            'mail' => $_SESSION['upn'],
            'ideas' => $ideas,
        ];
        return $this->render('admin/admin.html.twig', $data);
    }

    // ROUTE DES PAGES POUR GÉRER LES IDÉES

    #[Route('/admin/manage_ideas')]
    public function manageidea()
    {
        Functions::checkUserSession($this->accountRepository);
        Functions::checkRoleAdmin();

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
                'validator_id' => $idea->getValidator() != null ? $idea->getValidator()->getId() : "",
                'validator_givenname' => $idea->getValidator() != null ? $idea->getValidator()->getGivenName() : "",
                'validator_familyname' => $idea->getValidator() != null ? $idea->getValidator()->getFamilyName() : "",
                'creationDateTime' => $idea->getCreationDateTime(),
                'state_idea' => $idea->getState(),
            ];
        }
        $data = [
            'ideas' => $ideas,
        ];

        return $this->render('admin/manage_ideas.html.twig', $data);
    }

    #[Route('/admin/show_ideas')]
    public function showidea(PaginatorInterface $paginator, Request $request)
    {
        Functions::checkUserSession($this->accountRepository);
        Functions::checkRoleAdmin();

        $data =  $this->ideaRepository->findAll();
        
        $ideas = [];
        foreach ($data as $idea) {
            $ideas[] = [
                'title_idea' => $idea->getTitle(),
                'details_idea' => $idea->getDetails(),
                'choice_mesures' => $idea->getChoiceMesures(),
                'details_mesures' => $idea->getDetailsMesures(),
                'choice_funding' => $idea->getChoiceFunding(),
                'funding_details' => $idea->getDetailsFunding(),
                'team' => $idea->getTeam(),
                'isarchived' => $idea->isArchived() ? 'true' : 'false',
                'author_id' => $idea->getAuthor()->getId(),
                'idea_id' => $idea->getId(),
                'first_name' => $idea->getAuthor()->getGivenName(),
                'family_name' => $idea->getAuthor()->getFamilyName(),
                'creationDateTime' => $idea->getCreationDateTime(),
                'state_idea' => $idea->getState(),
            ];
        }
        
        
        $_ideas = $paginator->paginate(
            $ideas, 
            $request->query->getInt('page', 1),
            20
        );
        
        $files = $this->filesRepository->findAll();
        $_files = [];
        foreach ($files as $file) {
            $_files[] = [
                "file_id" => $file,
            ];
        }
        
        return $this->render('admin/show_ideas.html.twig',[ 
            "ideas" => $_ideas,
            "files" => $_files,
        ]);
    }

    #[Route('/admin/show_archived_ideas')]
    public function showideaarchived()
    {
        Functions::checkUserSession($this->accountRepository);
        Functions::checkRoleAdmin();

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
                'is_archived' => $idea->isArchived() ? 'true' : 'false',
                'author_id' => $idea->getAuthor()->getId(),
                'idea_id' => $idea->getId(),
                'first_name' => $idea->getAuthor()->getGivenName(),
                'family_name' => $idea->getAuthor()->getFamilyName(),
                'creationDateTime' => $idea->getCreationDateTime(),
                'state_idea' => $idea->getState(),
            ];
        }

        $data = [
            'ideas' => $ideas,
        ];
        return $this->render('admin/show_ideas_archived.html.twig', $data);
    }

    #[Route('/admin/modify_ideas/{id}')]
    public function modifyidea(Request $request, $id)
    {
        Functions::checkUserSession($this->accountRepository);
        Functions::checkRoleAdmin();

        $_idea = $this->ideaRepository->find($id);

        $data = [
            'title_idea' => trim($_idea->getTitle()),
            'details_idea' => trim($_idea->getDetails()),
            'choice_mesures' => $_idea->getChoiceMesures(),
            'details_mesures' => trim($_idea->getDetailsMesures()),
            'choice_funding' => $_idea->getChoiceFunding(),
            'funding_details' => trim($_idea->getDetailsFunding()),
            'idea_id' => $_idea->getId(),
            'team' => $_idea->getTeam(),
            'author_id' => $_idea->getAuthor()->getId(),
            'is_admin' => in_array('admin', $_SESSION['role']) ? 'true' : 'false',
            'state' => $_idea->getState(),
        ];

        $idea = $this->ideaRepository->find($id);

        if ($request->isMethod('POST')) {
            $idea->setTitle($request->request->get('modify_title_idea'));
            $idea->setDetails($request->request->get('modify_details_idea'));
            $idea->setDetailsMesures($request->request->get('modify_details_mesures'));
            $idea->setDetailsFunding($request->request->get('modify_funding_details'));

            $this->entityManager->persist($idea);
            $this->entityManager->flush();
            return $this->redirect('/admin/show_ideas');
        }

        return $this->render('admin/modify_ideas.html.twig', $data);
    }

    // ROUTES DES PAGES POUR GÉRER LES PROFILS

    #[Route('/admin/show_profiles')]
    public function showprofiles()
    {
        Functions::checkUserSession($this->accountRepository);
        Functions::checkRoleAdmin();

        $_accounts = $this->accountRepository->findAll();

        $accounts = [];
        foreach ($_accounts as $account) {
            $roles = [];
            foreach ($account->getRole() as $_role) {
                $roles[] = $_role->getRole();
            }

            $accounts[] = [
                'account_id' => $account->getId(),
                'family_name' => $account->getFamilyName(),
                'given_name' => $account->getGivenName(),
                'mail' => $account->getEmail(),
                'msOid' => $account->getMsOid(),
                'user_roles' => implode(',', $roles),
            ];
        }

        $data = [
            'accounts' => $accounts,
        ];

        return $this->render('admin/show_profiles.html.twig', $data);
    }

    #[Route('/admin/show_profiles/roles_added/{id}')]
    public function addRoles(Request $request, $id)
    {
        Functions::checkUserSession($this->accountRepository);
        Functions::checkRoleAdmin();

        $user = $this->accountRepository->find($id);

        // On récupère tout les roles de l'utilisateur
        $roles = [];
        foreach ($user->getRole() as $_role) {
            $roles[] = $_role;
        }
        if ($request->isMethod('POST')) {
            // On supprime tout les roles de l'utilisateur
            foreach ($roles as $role) {
                $this->entityManager->remove($role);
            };
            $this->entityManager->flush();
            // On récupère la liste des nouveaux roles
            $new_roles = explode(',', $request->request->get('rolestags'));

            // On crée les roles de l'utilisateurs
            foreach ($new_roles as $new_role) {
                $role = new Role;
                $role->setRole($new_role);
                $this->entityManager->persist($role);
                $user->addRole($role);
            }

            // On enregistre tout cela
            $this->entityManager->flush();
        }

        return $this->redirect('/admin/show_profiles');
    }

    #[Route('/idea/{id}/comment/{comment_id}/answer')]
    public function answer(Request $request, $comment_id, $id)
    {
        Functions::checkUserSession($this->accountRepository);
        Functions::checkRoleAdmin();

        $comment = $this->commentRepository->find($comment_id);
        $author = $this->accountRepository->find($_SESSION['account_id']);

        if (isset($_POST['send_answer'])) {
            $answer = new Answer;
            $answer->setAnswerContent($request->request->get('answer_comment'));
            $answer->setAnswerAuthorId($_SESSION['account_id']);
            $answer->setRelatedCommentId($comment);
            $answer->setAnswerDateTime(new \DateTime);
            $this->entityManager->persist($answer);
            $this->entityManager->flush();
        }
        
        return $this->redirect('/home');
    }

} 
