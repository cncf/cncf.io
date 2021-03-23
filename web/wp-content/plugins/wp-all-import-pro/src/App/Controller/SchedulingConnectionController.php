<?php

namespace Wpai\App\Controller;


use Wpai\Http\JsonResponse;

class SchedulingConnectionController
{
    public function indexAction()
    {
        return new JsonResponse(array('success' => true));
    }
}