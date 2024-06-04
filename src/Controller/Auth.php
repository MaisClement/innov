<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use League\OAuth2\Client\Provider\GenericProvider;
use TheNetworg\OAuth2\Client\Provider\Azure;
use Symfony\Component\Routing\Annotation\Route;

class Auth extends AbstractController
{
    private String $azureClientId;
    private String $azureClientSecret;
    private String $azureRedirectUri;
    private String $azureTenantId;

    public function __construct(String $azureClientId, String $azureClientSecret, String $azureRedirectUri, String $azureTenantId)
    {
        session_start();
        $this->azureClientId = $azureClientId;
        $this->azureClientSecret = $azureClientSecret;
        $this->azureRedirectUri = $azureRedirectUri;
        $this->azureTenantId = $azureTenantId;
    }

    #[Route('/login/microsoft')]
    public function microsoftLogin(): RedirectResponse
    {
        $provider = new Azure([
            'clientId'          => $_ENV['AZURE_CLIENT_ID'],
            'clientSecret'      => $_ENV['AZURE_CLIENT_SECRET'],
            'redirectUri'       => $_ENV['AZURE_REDIRECT_URI'],
            'urlAuthorize'            => 'https://login.microsoftonline.com/' . $this->azureTenantId . '/oauth2/v2.0/authorize',
            'urlAccessToken'          => 'https://login.microsoftonline.com/' . $this->azureTenantId . '/oauth2/v2.0/token',
            'urlResourceOwnerDetails' => '',
            'scopes'            => ['User.Read.All', 'https://graph.microsoft.com/.default'],
        ]);

        $authUrl = $provider->getAuthorizationUrl();
        $_SESSION['oauth2state'] = $provider->getState();

        return new RedirectResponse($authUrl);
    }

    #[Route('/login/microsoft/callback')]
    public function microsoftCallback(Request $request): RedirectResponse
    {
        $provider = new Azure([
            'clientId'          => $_ENV['AZURE_CLIENT_ID'],
            'clientSecret'      => $_ENV['AZURE_CLIENT_SECRET'],
            'redirectUri'       => $_ENV['AZURE_REDIRECT_URI'],
        ]);

        $code = $request->query->get('code');
        $state = $request->query->get('state');

        if (empty($state) || ($state !== $_SESSION['oauth2state'])) {
            unset($_SESSION['oauth2state']);
            exit('State value does not match the one initially sent');
        }

        $token = $provider->getAccessToken('authorization_code', [
            'code' => $code,
        ]);

        $_SESSION['token'] = $token;
        
        return $this->redirect('/account');
    }
}
