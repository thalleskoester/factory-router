<?php

namespace ThallesDella\FactoryRouter;

use CoffeeCode\Router\Router;
use ThallesDella\FactoryRouter\Exceptions\ClassNotFoundException;
use ThallesDella\FactoryRouter\Exceptions\DirectoryNotFoundException;
use ThallesDella\FactoryRouter\Exceptions\FileNotFoundException;
use ThallesDella\FactoryRouter\Exceptions\UpdateRouterMissingMethodException;

/**
 * Factory Router | Class FactoryRouter
 *
 * @category FactoryRouter
 * @package  ThallesDella\FactoryRouter
 * @author   Thalles D. koester <thallesdella@gmail.com>
 * @license  https://choosealicense.com/licenses/mit/ MIT
 * @link     https://github.com/thallesdella/factory-router
 */
class FactoryRouter
{
    /**
     * @var Router
     */
    private $router;
    
    /**
     * @var array
     */
    private $target;
    
    /**
     * FactoryRouter constructor.
     *
     * @param string $projectUrl
     * @param string $namespace
     */
    public function __construct(string $projectUrl, string $namespace)
    {
        $this->router = new Router($projectUrl);
        $this->router->namespace($namespace);
        
        $this->target = [];
    }
    
    /**
     * @param string $dir
     *
     * @return FactoryRouter
     *
     * @throws ClassNotFoundException
     * @throws DirectoryNotFoundException
     * @throws FileNotFoundException
     * @throws UpdateRouterMissingMethodException
     */
    public function addDir(string $dir): FactoryRouter
    {
        $path = dirname(__DIR__, 2) . "/{$dir}";
        if (!file_exists($dir) || !is_dir($dir)) {
            $error = new DirectoryNotFoundException('Directory not found');
            $error->file = $dir;
            throw $error;
        }
        
        $dirFiles = scandir($path);
        
        foreach ($dirFiles as $file) {
            if ($file == '.' || $file == '..') {
                continue;
            }
            $this->addFile("{$dir}/{$file}");
        }
        return $this;
    }
    
    /**
     * @param string $file
     *
     * @return FactoryRouter
     *
     * @throws ClassNotFoundException
     * @throws FileNotFoundException
     * @throws UpdateRouterMissingMethodException
     */
    public function addFile(string $file): FactoryRouter
    {
        $fileInfo = [
            "filename" => $this->_getFileName($file),
            "handler" => $this->_pathToNamespace($file),
            "path" => dirname(__DIR__, 2) . "/{$file}"
        ];
        
        if (!file_exists($fileInfo['path']) || !is_file($fileInfo['path'])) {
            $error = new FileNotFoundException('File not found');
            $error->file = $fileInfo['filename'];
            throw $error;
        }
        include_once $fileInfo['path'];
        
        $this->_checkClass($fileInfo);
        $this->target = array_merge($this->target, [$fileInfo]);
        return $this;
    }
    
    /**
     * @return Router
     */
    public function build(): Router
    {
        foreach ($this->target as $file) {
            /**
             * @var Routes $routes
             */
            $routes = new $file['handler']($this->router);
            $routes->updateRouter();
        }
        return $this->router;
    }
    
    /**
     * @param array $fileInfo
     *
     * @return void
     *
     * @throws ClassNotFoundException
     * @throws UpdateRouterMissingMethodException
     */
    private function _checkClass(array $fileInfo): void
    {
        if (!class_exists($fileInfo['handler'])) {
            $error = new ClassNotFoundException("Class not found");
            $error->file = $fileInfo['filename'];
            throw $error;
        }
        
        if (!method_exists($fileInfo['handler'], 'updateRouter')) {
            $error = new UpdateRouterMissingMethodException("Method updateRouter not found");
            $error->file = $fileInfo['filename'];
            throw $error;
        }
        
        return;
    }
    
    /**
     * @param string $path
     *
     * @return string
     */
    private function _pathToNamespace(string $path): string
    {
        $buf = str_replace('/', '\\', ucwords($path, '/'));
        return explode('.', $buf)[0];
    }
    
    /**
     * @param string $path
     *
     * @return string
     */
    private function _getFileName(string $path): string
    {
        $arr = explode('/', $path);
        $file = end($arr);
        return explode('.', $file)[0];
    }
    
}
