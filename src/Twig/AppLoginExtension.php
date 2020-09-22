<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AppLoginExtension extends AbstractExtension
{
    private $authenticationUtils;
    private $authenticationError = null;

    public function __construct(AuthenticationUtils $authenticationUtils)
    {   
        $this->authenticationUtils = $authenticationUtils;
    }

    public function getFilters(): array 
    {
        return [
            // If your filter generates SAFE HTML, you should add a third
            // parameter: ['is_safe' => ['html']]
            // Reference: https://twig.symfony.com/doc/2.x/advanced.html#automatic-escaping
            // new TwigFilter('filter_name', [$this, 'doSomething']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            /*indique a twig les fonction à executer*/
            new TwigFunction('login_error', [$this, 'loginError']),
            new TwigFunction('login_user_name', [$this, 'loginUserName']),
        ];
    }

    public function loginError()
    {
        if($this->authenticationError === null){
            $this->authenticationError = $this->authenticationUtils->getLastAuthenticationError();
        }
        // get the login error if there is one
        return $this->authenticationError;
    }

    public function loginUserName()
    {
        //recuperation du dernier login de l'utilisateur dans les cookies
        return $this->authenticationUtils->getLastUsername();
    }
}
