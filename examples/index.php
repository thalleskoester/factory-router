<?php
require __DIR__ . '/autoload.php';

ob_start();

use ThallesDella\FactoryRouter\Exceptions\ClassNotFoundException;
use ThallesDella\FactoryRouter\Exceptions\UpdateRouterMissingMethodException;
use ThallesDella\FactoryRouter\Exceptions\DirectoryNotFoundException;
use ThallesDella\FactoryRouter\Exceptions\FileNotFoundException;
use ThallesDella\FactoryRouter\FactoryRouter;

$factory = new FactoryRouter(
    'http://localhost/factory-router/examples',
    __DIR__,
    'Controllers'
);

try {
    $factory->addDir('routes');
} catch (ClassNotFoundException | UpdateRouterMissingMethodException $exception) {
    trigger_error(
        "{$exception->getMessage()} in file {$exception->file}",
        E_USER_WARNING
    );
} catch (DirectoryNotFoundException | FileNotFoundException $exception) {
    trigger_error(
        "{$exception->file} {$exception->getMessage()}\n",
        E_USER_ERROR
    );
}

$router = $factory->build();

$router->dispatch();

if ($router->error()) {
    $router->redirect('website.error', ['code' => $router->error()]);
}

ob_end_flush();