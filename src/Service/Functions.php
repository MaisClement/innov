<?php

namespace App\Service;

use App\Repository\AccountRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;

class Functions
{
    private AccountRepository $accountRepository;



    public function __construct(AccountRepository $accountRepository)
    {
        $this->accountRepository = $accountRepository;
    }

    public static function ErrorMessage($http_code, $details = '')
    {
        return array(
            'error' => array(
                'code' => (int) $http_code,
                'message' => (string) null,
                'details' => (string) $details == '' ? '' : $details,
            )
        );
    }

    public static function checkUserSession(AccountRepository $accountRepository) 
    {
        if (isset($_SESSION['account_id']) && $_SESSION != null) {
            $account = $accountRepository->find($_SESSION['account_id']);

            if ($account != null) {
                $roles = [];
                foreach ($account->getRole() as $_role) {
                    $roles[] = $_role->getRole();
                }
                $_SESSION['role'] = $roles;
            } else {
                $response = new RedirectResponse('/login');
                $response->send();
                exit();
            }
        } else {
            $response = new RedirectResponse('/login');
            $response->send();
            exit();
        }
    }

    public static function checkRoleAdmin()
    {
        if (!in_array('admin', $_SESSION['role'])){
            $response = new RedirectResponse('/error403');
            $response->send();
            exit();
        }
    }
}
