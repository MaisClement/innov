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
    // Commentaires
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

        try {
            $user = $provider->getResourceOwner($token);

            $json = array(
                'user'  => $user->toArray(),
            );
            return $this->json($json);

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

            // $this->accountRepository->findOneByMSOID(  )

        } catch (\Exception $e) {
            return new JsonResponse($this->functions->ErrorMessage(500, $e->getMessage()), 500);
        }
    }
}