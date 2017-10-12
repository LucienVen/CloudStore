<?php

// something interesting
\Core\Start::getApp()->add(function ($request, $response, $next) {
    $route = $request->getAttribute('route');
    $this['args'] = $route ? $route->getArguments() : "";
    return $next($request, $response);
});

// load slim dependencies
if (file_exists(APP_PATH."/Dependencies.php")) {
    require APP_PATH."/Dependencies.php";
}

// load route file
foreach (glob(APP_PATH.'/Route/*.route.php') as $path) {
    require $path;
}

// run slim
\Core\Start::run();
