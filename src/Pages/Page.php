<?php


namespace Sideapps\LaravelPages\Pages;


use Illuminate\Contracts\View\View;
use Sideapps\LaravelPages\Breadcrumb\Breadcrumb;
use Sideapps\LaravelPages\Breadcrumb\BreadcrumbItem;

interface Page {

    public function getUrl(?string $locale = null):string;

    public function getAllAlternatesUrls():array;

    public function getAlternatesUrls():array;

    public function getBreadcrumb():?Breadcrumb;

    public function generateAlternateLinks():View;

    public function generateSwitchLanguageLinks():View;

    public function generateBreadcrumb():View;

    public function generateMetaIndex():?View;

    public function getMetaTitle():string;

    public function getMetaDescription():?string;

    public function getBreadcrumbAnchor():string;

    public function getTitle():string;

    public function getBreadcrumbItem(bool $withUrl = true):BreadcrumbItem;

}
