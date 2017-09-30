<?php

// something interesting
\Core\Start::getApp()->add(function ($request, $response, $next) {
    $route = $request->getAttribute('route');
    $this['args'] = $route ? $route->getArguments() : "";
    return $next($request, $response);
});

// load application file
require CORE_PATH."/Application.php";

if (file_exists(APP_PATH."/Dependencies.php")) {
    require APP_PATH."/Dependencies.php";
}

// load route file
foreach (glob(APP_PATH.'/Route/*.route.php') as $path) {
    require $path;
}

\Core\Start::run();
