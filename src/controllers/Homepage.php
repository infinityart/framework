<?php
/**
 * User: Jonty
 * Date: 6/5/2017
 */

namespace Framework\Controllers;

use Http\Response;

class Homepage
{
    private $response;

    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    public function show()
    {
        $this->response->setContent('Hello World');
    }

}