<?php


namespace Sideapps\LaravelPages\Pages;

class CreatePageFactory {

    public function getPage(string $class, ?Pageable $pageable = null):Page {
        if ($pageable) return new $class($pageable);
        return new $class;
    }

    public static function make():self {
        return new self();
    }

}
