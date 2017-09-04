<?php

namespace App\Http\Middleware;

use Closure;

class Redirect
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $root = $request->root(); //http://localhost/faveo/Faveo-Helpdesk-Pro-fork/public
        $url = $this->setAppUrl($request);
        if ($url == $root) {
            return $next($request);
        }
        $seg = '';
        $segments = $request->segments();
        if (count($segments) > 0) {
            foreach ($segments as $segment) {
                $seg .= '/'.$segment;
            }
        }
        $url = $url.$seg;

        return redirect($url);
    }

    public function setAppUrl($request)
    {
        $url = $request->root();
        if (isInstall()) {
            $schema = new \App\Model\helpdesk\Settings\CommonSettings();
            $row = $schema->getOptionValue('url', 'app_url', true);
            if ($row) {
                $url = $row->option_value;
            }
        }

        return $url;
    }
}
