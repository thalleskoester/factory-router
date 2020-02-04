<?php
require dirname(__DIR__) . '/src/FactoryRouter.php';

use ThallesDella\FactoryRouter\Exceptions\ClassNotFoundException;
use ThallesDella\FactoryRouter\Exceptions\UpdateRouterMissingMethodException;
use ThallesDella\FactoryRouter\Exceptions\DirectoryNotFoundException;
use ThallesDella\FactoryRouter\Exceptions\FileNotFoundException;
use ThallesDella\FactoryRouter\FactoryRouter;

$factory = new FactoryRouter('http://exemple.com.br', __DIR__, 'Source\Controllers');

try {
    $factory->addDir('routes');
} catch (ClassNotFoundException $exception) {

} catch (UpdateRouterMissingMethodException $exception) {

} catch (DirectoryNotFoundException $exception) {

} catch (FileNotFoundException $exception) {

}

$router = $factory->build();

$router->dispatch();

if ($router->error()) {
    $router->redirect('website.error', ['code' => $router->error()]);
}