<?php

namespace Krak\LavaCodeIgniter;

use Krak\Lava;

function ciHtmlRenderError() {
    return function($error, $req, $next) {
        $_error = load_class('Exceptions', 'core');

        if ($error->status == 404) {
            return $next->response()->html(500, [], $_error->show_error(
                '404 Page Not Found',
                'The page you requested was not found.',
                'error_404'
            ));
        }

        $app = $next->getApp();
        $e = $error->getException();
        if (!$app['debug'] || !$e) {
            $message = $error->message;
        } else {
            $html = <<<HTML
%s<br/>
<code>
%s
</code>
HTML;
            $message = sprintf($html, $error->message, nl2br($e));
        }

        return $next->response()->html(500, [], $_error->show_error(
            'An Error Was Encountered',
            $message
        ));
    };
}

/** creates a view marshalResponse for the routing component marshal responses */
function ciViewMarshalResponse() {
    return function($res, $req, $next) {
        if (!Lava\Util\isTuple($res, 'string', 'array')) {
            return $next($res, $req);
        }

        $ci = $next['codeigniter'];

        list($view_path, $view_data) = $res;
        return $next->response()->html(200, [], $ci->load->view($view_path, $view_data, true));
    };
}
