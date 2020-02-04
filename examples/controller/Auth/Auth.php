<?php

namespace Controllers\Auth;

use CoffeeCode\Router\Router;
use Controllers\Controller;

/**
 * Factory Router | Class Auth [ EXAMPLE ]
 *
 * @category Examples\Controllers
 * @package  FactoryRouter\Examples\Controllers
 * @author   Thalles D. koester <thallesdella@gmail.com>
 * @license  https://choosealicense.com/licenses/mit/ MIT
 * @link     https://github.com/thallesdella/factory-router
 */
class Auth extends Controller
{
    /**
     * main constructor.
     *
     * @param Router $router
     */
    public function __construct(Router $router)
    {
        parent::__construct($router);
    }
    
    public function login(array $data): void
    {
        $data = filter_var_array($data, FILTER_DEFAULT);
    
        if ($data['user'] != 'admin' || $data['pass'] != 'admin') {
            $message = base64_encode('Credenciais erradas');
            $this->router->redirect(
                'website.login.msg',
                ['msg' => $message]
            );
            return;
        }
        
        $_SESSION['login'] = true;
        $this->router->redirect('app.home');
    }
}