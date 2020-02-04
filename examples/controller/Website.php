<?php

namespace Controllers;

use CoffeeCode\Router\Router;

/**
 * Factory Router | Class Website [ EXAMPLE ]
 *
 * @category Examples\Controllers
 * @package  FactoryRouter\Examples\Controllers
 * @author   Thalles D. koester <thallesdella@gmail.com>
 * @license  https://choosealicense.com/licenses/mit/ MIT
 * @link     https://github.com/thallesdella/factory-router
 */
class Website extends Controller
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
     * @param array|null $data
     *
     * @return void
     */
    public function login(?array $data): void
    {
        if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
            $this->router->redirect('app.home');
        }
    
        $html = '';
        if (!empty($data['msg'])) {
            $cleanMsg = filter_var(
                base64_decode($data['msg']),
                FILTER_SANITIZE_STRIPPED
            );
            $html .= "{$cleanMsg}<br><br>";
        }
        
        $action = $this->router->route('auth.login');
        $html .= "<form action='{$action}' method='post'>
            <label>
                <span>User:</span><input type='text' name='user' required>
            </label><br>
            <label>
                <span>Pass:</span><input type='password' name='pass' required>
            </label><br>
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
        $html = "Erro {$data['code']}";
        echo $html;
    }
}