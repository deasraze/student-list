<?php

namespace App\Components;

use App\Components\Interfaces\RendererInterface;

class View implements RendererInterface
{
    protected string $defaultPath = ROOT . '/../App/Views/';

    protected string $defaultExtension = 'php';

    public function __construct()
    {
    }

    public function render(string $template, array $args): string
    {
        $file = $this->getFile($template);
        extract($args);
        ob_start();
        require_once "$file";
        return ob_get_clean();
    }

    /**
     * Upload the required file
     * @param string $fileName
     * @return string
     * @throws \Exception
     */
    public function getFile(string $fileName): string
    {
        return $this->checkFileExist($fileName);
    }

    /**
     * @param string $defaultPath
     */
    public function setDefaultPath(string $defaultPath): void
    {
        $this->defaultPath = $defaultPath;
    }

    /**
     * @param string $defaultExtension
     */
    public function setDefaultExtension(string $defaultExtension): void
    {
        $this->defaultExtension = $defaultExtension;
    }

    /**
     * Checking the requested file for the presence in the directory
     * @param string $fileName
     * @return string
     * @throws \Exception
     */
    protected function checkFileExist(string $fileName): string
    {
        $file = $this->defaultPath . "$fileName." . $this->defaultExtension;
        if (is_file($file)) {
            return $file;
        }

        throw new \Exception("File $file not exist");
    }
}