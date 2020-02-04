<?php

namespace Routes;

use CoffeeCode\Router\Router;
use ThallesDella\FactoryRouter\Routes;

/**
 * Factory Router | Class AAA [ EXAMPLE ]
 *
 * @category Examples\Routes
 * @package  FactoryRouter\Examples\Routes
 * @author   Thalles D. koester <thallesdella@gmail.com>
 * @license  https://choosealicense.com/licenses/mit/ MIT
 * @link     https://github.com/thallesdella/factory-router
 */
class AAA extends Routes
{
    /**
     * main constructor.
     *
     * @param Router $router Router object
     */
    public function __construct(Router $router)
    {
        parent::__construct($router, 'Website');
        $this->namespace('Controllers');
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
        $this->router->get('/{msg}', "Website:login", "website.login.msg");
        
        $this->get("/registrar", "register");
        $this->get("/recuperar", "forget");
        $this->get("/resetar", "reset");
    }
    
    /**
     * @return void
     */
    private function error(): void
    {
        $this->group('error');
        $this->get('/{code}', 'error');
    }
}