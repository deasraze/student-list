<?php
/*
 * Student List application
 * @author theifel
 * @link https://github.com/theifel/student-list/
 * @copyright Copyright (c) 2021
 * @license https://github.com/theifel/student-list/blob/main/LICENSE.md
 */

namespace App\Controllers;

use App\Components\DIContainer;
use App\Components\Exceptions\ContainerException;
use App\Components\Exceptions\FileNotExistException;
use App\Components\Response;

abstract class Controller
{
    /**
     * @var DIContainer
     */
    public DIContainer $container;

    /**
     * @var Response
     */
    public Response $response;

    /**
     * Controller constructor.
     * @param DIContainer $container
     * @param Response $response
     */
    public function __construct(DIContainer $container, Response $response)
    {
        $this->container = $container;
        $this->response = $response;
    }

    /**
     * Filling in the view and returning the result to the App
     * @param string $template
     * @param array $args
     * @return Response
     * @throws ContainerException
     * @throws FileNotExistException in render()
     */
    public function show(string $template, array $args): Response
    {
        $body = $this->container->get('view')->render($template, $args);
        return $this->response->withBody($body);
    }

}
