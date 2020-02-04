<?php

namespace Routes;

use CoffeeCode\Router\Router;
use ThallesDella\FactoryRouter\Routes;

/**
 * Factory Router | Class Website [ EXAMPLE ]
 *
 * @category FactoryRouter\Examples\Routes
 * @package  Routes
 * @author   Thalles D. koester <thallesdella@gmail.com>
 * @license  https://choosealicense.com/licenses/mit/ MIT
 * @link     https://github.com/thallesdella/factory-router
 */
class Website extends Routes
{
    /**
     * Website constructor.
     *
     * @param Router $router Router object
     */
    public function __construct(Router $router)
    {
        $pieces = explode('\\', __CLASS__);
        $controller = end($pieces);
        parent::__construct($router, $controller);
    }
    
    /**
     * @return Router
     */
    public function updateRouter(): Router
    {
        $this->main();
        $this->categories();
        $this->posts();
        $this->user();
        $this->error();
        return $this->router;
    }
    
    /**
     * @return void
     */
    private function main(): void
    {
        $this->group(null);
        $this->get("/", "home");
        $this->get("/{search}", "search");
        $this->get("/contato", "contact");
    }
    
    /**
     * @return void
     */
    private function categories(): void
    {
        $this->group('cat');
        $this->get("/", "categories");
        $this->get("/{cat_name}", "category");
    }
    
    /**
     * @return void
     */
    private function posts(): void
    {
        $this->group('posts');
        $this->get("/", "posts");
        $this->get("/{post_name}", "post");
    }
    
    /**
     * @return void
     */
    private function user(): void
    {
        $this->group('me');
        $this->get("/", "login");
        $this->get("/registrar", "register");
        $this->get("/recuperar", "forget");
        $this->get("/resetar", "reset");
    }
    
    /**
     * @return void
     */
    private function error(): void
    {
        $this->get('/error/{code}', 'error');
    }
}