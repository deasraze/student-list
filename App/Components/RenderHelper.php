<?php


namespace App\Components;


class RenderHelper
{
    protected string $defaultPath = ROOT . '/../App/Views/';
    protected string $defaultExtension = 'php';


    public function __construct()
    {
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
}