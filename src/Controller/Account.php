<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use League\OAuth2\Client\Provider\GenericProvider;
use Symfony\Component\HttpFoundation\JsonResponse;
use TheNetworg\OAuth2\Client\Provider\Azure;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\Functions;
use App\Repository\AccountRepository;

class Account extends AbstractController
{
    private Functions $functions;

    private AccountRepository $accountRepository;

    
    public function __construct(Functions $functions, AccountRepository $accountRepository)
    {
        session_start();

        $this->functions = $functions; 

        $this->accountRepository = $accountRepository; 
    }

    #[Route('/account')]
    public function account(): JsonResponse
    {
        $token = $_SESSION['token'] ?? null;

        if ($token == null) {
            return new JsonResponse($this->functions->ErrorMessage(401, 'You are not logged'), 401);
        }           

        $provider = new Azure([
            'clientId'          => $_ENV['AZURE_CLIENT_ID'],
            'clientSecret'      => $_ENV['AZURE_CLIENT_SECRET'],
            'redirectUri'       => $_ENV['AZURE_REDIRECT_URI'],
        ]);

        // try {
            $user = $provider->getResourceOwner($token)->toArray();

            //$json = array(
             //   'user'  => $user,
            //);
            //return $this->json($json);

                // import the given repository
                // line13   use App\Repository\StationsRepository;

                // Define the repository
                // line19   private AccountRepository $accountRepository;
                
                // Pass it to the constructor
                // line21   
                //  before  public function __construct(Functions $functions)
                //  after   public function __construct(Functions $functions, AccountRepository $accountRepository)

                // asign the repository as a class member (to be easily accesible)
                // line 27  $this->accountRepository = $accountRepository;

                // $this->accountRepository->findOneByMSOID()

            // you can access user details using
            // $user['family_name'];
            // $msoId = $request->get('mso_id');

            $msoId = $user['oid'];
            
            $account = $this->accountRepository->findOneByMSOID($msoId);
            
            if ($account) // the user has an account, we open the session and register the connection
            {         
                // $user = new Login();
                $login = new Login();
                $date = new DateTime();
                $login->setDatetime($date);
                $entityManager->persist($login);  

                $account->addLogin($login);
                // $user->setFamilyName($_SESSION->get('family_name')); // Le compte existe déja, pas besoin de remplir les infos
                // $user->setGivenName($_SESSION->get('given_name'));   // Le compte existe déja, pas besoin de remplir les infos
                // $user->setEmail($_SESSION->get('email'));            // Le compte existe déja, pas besoin de remplir les infos
                // $user->setMsOid($account);                           // Le compte existe déja, pas besoin de remplir les infos
            
                // $role = new Role();                                  // Le compte existe déja, pas besoin de remplir les infos

                // $role = setRole('default');                          // Le compte existe déja, pas besoin de remplir les infos
                // $user->setRole($role);                               // Le compte existe déja, pas besoin de remplir les infos
                // $entityManager->persist($user);                      // Le compte existe déja, pas besoin de remplir les infos
                $entityManager->flush();                                
            
                // $this->$_SESSION->set('user', $account); // Ne fonctionne pas
                $_SESSION = $account;

            } else { // the user doesn't have an account, so we create one for him and give him the ‘default’ role
                $user = new Account();
                $user->setMSOID($msoId);
                $user->setFamilyName($user['family_name']);
                $user->setGivenName($user['given_name']);
                $user->setEmail($user['email']);

                $role = new Role();
                $role->setRole('default');
                $user->setRole($role);

                
                
                $login = new Login();
                $login->setAccount($account);
                $entityManager->persist($user);
                $entityManager->persist($login);
                $entityManager->flush();
            
                // Création de la session
                $_SESSION = $user;
            
                return new JsonResponse('New account created with id'.$user->getId());        
            } 

       // } catch (\Exception $e) {
          //  return new JsonResponse($this->functions->ErrorMessage(500, $e->getMessage()), 500);
        //}
    }

    public function createAccount(EntityManagerInterface $entityManager, Request $request): Response
   {
        // $msoId = $request->get('mso_id');
        //
        // $account = $this->accountRepository->findOneMSOID($msoId);
        //
        // if ($account) // user is already register, open the session
        // {         
        //     $user = new Login();   
        //     $user->setFamilyName($_SESSION->get('family_name'));
        //     $user->setGivenName($_SESSION->get('given_name'));           
        //     $user->setEmail($_SESSION->get('email'));
        //     $user->setMsOid($account);
        // 
        //     $role = new Role();
        // 
        //     $role = setRole('default');
        //     $user->setRole($role);
        //     $entityManager->persist($user);
        //     $entityManager->flush();
        // 
        //     $this->$_SESSION->set('user', $account);
        //     
        // } else { // user is already register, open the session
        //     $user = new Account();
        //     $user->setMSOID($msoId);
        //     $account->setRole($this->roleRepository->findOneByLabel('default'));
        //     $entityManager->persist($user);
        //     $entityManager->flush();
        // 
        //     $login = new Login();
        //     $login->setAccount($account);
        //     $entityManager->persist($login);
        //     $entityManager->flush();
        // 
        //     // Création de la session
        //     $this->session->set('user', $account);
        // 
        //     return new JsonResponse('New account created with id'.$user->getId());        
        // } 
        return new RedirectResponse('/account');  
    }
}