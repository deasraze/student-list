<?php

namespace App\Components;

use App\Components\Interfaces\RendererInterface;

class View implements RendererInterface
{
    private string $defaultPath = ROOT . '/../App/Views/';

    private string $defaultExtension = 'php';

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
     * Upload the required file
     * @param string $fileName
     * @return string
     * @throws \Exception
     */
    private function getFile(string $fileName): string
    {
        return $this->checkFileExist($fileName);
    }

    /**
     * Checking the requested file for the presence in the directory
     * @param string $fileName
     * @return string
     * @throws \Exception
     */
    private function checkFileExist(string $fileName): string
    {
        $file = $this->defaultPath . "$fileName." . $this->defaultExtension;
        if (!is_file($file)) {
            throw new \Exception("Template file $file not exist");
        }

        return $file;
    }
}