<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$routes = app('router')->getRoutes();
foreach ($routes as $route) {
    if (str_contains($route->uri(), 'admin/login')) {
        echo "URI: {$route->uri()}\n";
        echo "Methods: " . implode(', ', $route->methods()) . "\n";
        echo "Name: {$route->getName()}\n\n";
    }
}
