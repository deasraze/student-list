<?php

namespace App\Controllers;

use App\Components\Request;

class FrontController
{
    private static FrontController $instance;
    private Request $request;

    /**
     * @return FrontController
     */
    public static function getInstance(): FrontController
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function __construct()
    {
        $this->request = new Request();
    }

    public function route()
    {
    }


    private function __clone()
    {
    }


}