<?php


namespace myPHPnotes\Slacker\Middlewares;

use App\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware {
    public function addToExcept(string $route_identifier)
    {
        $this->except[] = $route_identifier;
    }
}
