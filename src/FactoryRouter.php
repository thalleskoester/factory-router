<?php

namespace ThallesDella\FactoryRouter;

use ArrayObject;
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
     * Router object
     *
     * @var Router
     */
    private $router;
    
    /**
     * Target ArrayObject
     *
     * @var ArrayObject
     */
    private $target;
    
    /**
     * Project root folder
     *
     * @var string
     */
    private $project_root;
    
    /**
     * FactoryRouter constructor.
     *
     * @param string $projectUrl  Base url of project
     * @param string $projectRoot Path to the project root folder
     * @param string $namespace   Default namespace of the controllers
     */
    public function __construct(string $projectUrl, string $projectRoot, string $namespace)
    {
        $this->router = new Router($projectUrl);
        $this->router->namespace($namespace);
    
        $this->project_root = $projectRoot;
    
        $this->target = new ArrayObject();
    }
    
    /**
     * Scan directory for targets
     *
     * @param string $dir Relative path of directory
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
        $path = "{$this->project_root}/{$dir}";
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
     * Add file as target
     *
     * @param string $file Relative path of file
     *
     * @return FactoryRouter
     *
     * @throws ClassNotFoundException
     * @throws FileNotFoundException
     * @throws UpdateRouterMissingMethodException
     */
    public function addFile(string $file): FactoryRouter
    {
        $fileInfo = new ArrayObject(
            [
                "filename" => $this->getFileName($file),
                "handler" => $this->pathToNamespace($file),
                "path" => "{$this->project_root}/{$file}"
            ],
            ArrayObject::ARRAY_AS_PROPS
        );
        
        if (!file_exists($fileInfo->path) || !is_file($fileInfo->path)) {
            $error = new FileNotFoundException('File not found');
            $error->file = $fileInfo->filename;
            throw $error;
        }
        include_once $fileInfo->path;
    
        $this->checkClass($fileInfo);
        $this->target->append([$fileInfo]);
        return $this;
    }
    
    /**
     * Build router
     *
     * @return Router
     */
    public function build(): Router
    {
        foreach ($this->target->getIterator() as $file) {
            /**
             * Instance of the router manager
             *
             * @var Routes $routes
             */
            $routes = new $file->handler($this->router);
            $routes->updateRouter();
        }
        return $this->router;
    }
    
    /**
     * Check if is a valid class
     *
     * @param ArrayObject $fileInfo ArrayObject containing file's information
     *
     * @return void
     *
     * @throws ClassNotFoundException
     * @throws UpdateRouterMissingMethodException
     */
    private function checkClass(ArrayObject $fileInfo): void
    {
        if (!class_exists($fileInfo->handler)) {
            $error = new ClassNotFoundException("Class not found");
            $error->file = $fileInfo->filename;
            throw $error;
        }
        
        if (!method_exists($fileInfo->handler, 'updateRouter')) {
            $error = new UpdateRouterMissingMethodException("Method updateRouter not found");
            $error->file = $fileInfo->filename;
            throw $error;
        }
        
        return;
    }
    
    /**
     * Converts a path to a file into the file's namespace
     *
     * @param string $path Path to be transform
     *
     * @return string
     */
    private function pathToNamespace(string $path): string
    {
        $buffer = str_replace('/', '\\', ucwords($path, '/'));
        return explode('.', $buffer)[0];
    }
    
    /**
     * Get the file name, without extension
     *
     * @param string $path Path of file
     *
     * @return string
     */
    private function getFileName(string $path): string
    {
        $array = explode('/', $path);
        $file = end($array);
        return explode('.', $file)[0];
    }
    
}
