<?php

use Phalcon\Mvc\Controller;

class ControllerBase extends Controller
{

    protected function initialize()
    {
        $this->tag->prependTitle('Acumen Consulting | ');
        $this->view->setTemplateAfter('main');
    }
}
