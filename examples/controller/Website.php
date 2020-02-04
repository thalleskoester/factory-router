<?php

namespace Controllers;

use CoffeeCode\Router\Router;

/**
 * Factory Router | Class Website [ EXAMPLE ]
 *
 * @category FactoryRouter\Examples\Controllers
 * @package  Routes
 * @author   Thalles D. koester <thallesdella@gmail.com>
 * @license  https://choosealicense.com/licenses/mit/ MIT
 * @link     https://github.com/thallesdella/factory-router
 */
class Website extends Controller
{
    /**
     * Website constructor.
     *
     * @param Router $router
     */
    public function __construct(Router $router)
    {
        parent::__construct($router);
    }
    
    /**
     * @return void
     */
    public function home(): void
    {
        $action = $this->router->route('website.login');
        $html = "<a title='Fazer Login' href='{$action}'>Fazer Login</a>";
        echo $html;
    }
    
    /**
     * @return void
     */
    public function login(): void
    {
        $action = $this->router->route('auth.login');
        $html = "<form action='{$action}'>
            <label><span>User:</span><input type='text' name='user' required></label>
            <label><span>Pass:</span><input type='password' name='pass' required></label>
            <button>Submit</button></form>";
        
        echo $html;
    }
    
    /**
     * @param array $data
     *
     * @return void
     */
    public function error(array $data): void
    {
    
    }
}