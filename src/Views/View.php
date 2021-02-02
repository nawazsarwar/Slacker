<?php

namespace myPHPnotes\Slacker\Views;

class View {
    protected static $prefix = "slacker";
    public static function path(string $path)
    {
        $mainPath = resource_path("views" . DIRECTORY_SEPARATOR . View::$prefix . DIRECTORY_SEPARATOR . trim($path, DIRECTORY_SEPARATOR ));
        if (file_exists($mainPath . ".blade.php")) {
            return View::$prefix. "." . $path ;
        }
        return "slacker::" . $path;
    }
}
