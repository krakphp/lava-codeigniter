<?php

namespace Krak\LavaCodeIgniter;

use Krak\Lava;
use Zend\Diactoros;

use function Krak\Http\Middleware\injectRequestAttribute;

class CodeIgniterPackage implements Lava\Package
{
    private $ci;

    public function __construct(\CI_Controller $ci) {
        $this->ci = $ci;
    }

    public function with(Lava\App $app) {
        $app['codeigniter'] = $this->ci;
        $app->wrap(Diactoros\Response\EmitterInterface::class, function($emitter, $app) {
            return new CIEmitter($app['codeigniter']->output);
        });
        $app->renderErrorStack()->push(ciHtmlRenderError(), 0, 'ciHtml');
        $app->marshalResponseStack()->push(ciViewMarshalResponse(), 0, 'ciView');
        $app->httpStack()->push(injectRequestAttribute('ci', $this->ci));
    }
}
