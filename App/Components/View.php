<?php

namespace App\Components;

use App\Components\Interfaces\RendererInterface;

class View implements RendererInterface
{
    /**
     * Default path for the view
     * @var string
     */
    private string $defaultPath;

    /**
     * Default extension for the view
     * @var string
     */
    private string $defaultExtension;

    /**
     * View constructor.
     * @param string $defaultPath
     * @param string $defaultExtension
     */
    public function __construct(string $defaultPath, string $defaultExtension)
    {
        $this->defaultPath = $defaultPath;
        $this->defaultExtension = $defaultExtension;
    }

    /**
     * Render the view and returning the result as a string
     * @param string $template
     * @param array $args
     * @return string
     * @throws \Exception
     */
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
     * Getting full path to file
     * @param string $fileName
     * @return string
     * @throws \Exception
     */
    private function getFile(string $fileName): string
    {
        $file = $this->defaultPath . "$fileName." . $this->defaultExtension;
        if ($this->checkFileExist($file)) {
            return $file;
        }

        throw new \Exception("Template file $file not exist");
    }

    /**
     * Checking the requested file for the presence in the directory
     * @param string $file
     * @return bool
     * @throws \Exception
     */
    private function checkFileExist(string $file): bool
    {
        return is_file($file);
    }
}
