<?php

namespace Controllers;

use CoffeeCode\Router\Router;

/**
 * Factory Router | Class App [ EXAMPLE ]
 *
 * @category FactoryRouter\Examples\Controllers
 * @package  Routes
 * @author   Thalles D. koester <thallesdella@gmail.com>
 * @license  https://choosealicense.com/licenses/mit/ MIT
 * @link     https://github.com/thallesdella/factory-router
 */
class App extends Controller
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
        
        if (!isset($_SESSION['login']) || $_SESSION['login'] != true) {
            $this->router->redirect('website.login');
        }
    }
    
    /**
     * @return void
     */
    public function home(): void
    {
        $action = $this->router->route('app.logout');
        $html = "Bem vindo, deseja <a title='Logout' href='{$action}'>sair</a>?";
        echo $html;
    }
    
    /**
     * @return void
     */
    public function logout(): void
    {
        $_SESSION['login'] = false;
        $this->router->redirect('website.login');
    }
}
    
    
