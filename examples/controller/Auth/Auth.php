<?php

namespace Controllers\Auth;

use CoffeeCode\Router\Router;
use Controllers\Controller;

/**
 * Factory Router | Class Auth [ EXAMPLE ]
 *
 * @category FactoryRouter\Examples\Controllers
 * @package  Routes
 * @author   Thalles D. koester <thallesdella@gmail.com>
 * @license  https://choosealicense.com/licenses/mit/ MIT
 * @link     https://github.com/thallesdella/factory-router
 */
class Auth extends Controller
{
    /**
     * Website constructor.
     *
     * @param Router $router
     */
    public function __construct(Router $router)
    {
        parent::__construct($router);
        session_start();
    }
    
    public function login(): void
    {
        $user = filter_input(INPUT_POST, 'user', FILTER_DEFAULT);
        $pass = filter_input(INPUT_POST, 'pass', FILTER_DEFAULT);
        
        if ($user != 'admin' || $pass != 'admin') {
            $this->router->redirect('website.login');
            return;
        }
        
        $_SESSION['login'] = true;
    }
}