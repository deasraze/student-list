<?php


namespace App\Controllers;


interface Controller
{

    /**
     * Start page processing method
     */
    function actionIndex();

    /**
     * Filling in the view and returning the result to the FrontController
     * @param string $fileName
     */
    function render(string $fileName);
}