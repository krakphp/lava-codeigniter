<?php

namespace Krak\LavaCodeIgniter;

class CIHtmlRenderError
{
    public function handle($error, $req, $next) {
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
    }
}
