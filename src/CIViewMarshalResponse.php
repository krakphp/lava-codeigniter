<?php

namespace Krak\LavaCodeIgniter;

use Krak\Lava;

class CIViewMarshalResponse
{
    public function handle($res, $req, $next) {
        if (!Lava\Util\isTuple($res, 'string', 'array')) {
            return $next($res, $req);
        }

        $ci = $next['codeigniter'];

        list($view_path, $view_data) = $res;
        return $next->response()->html(200, [], $ci->load->view($view_path, $view_data, true));
    }
}
