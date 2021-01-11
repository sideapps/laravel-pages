<?php


namespace Sideapps\LaravelPages\Pages;

abstract class StaticPage extends BasePage{

    protected static string $translation_key;

    protected static string $metaTitleKey;

    protected static string $metaDescriptionKey;

    protected static string $breadcrumbKey;

    protected static string $titleKey;

    protected static string $route;

    public function __construct() {
        self::$metaTitleKey = config('page.translations_key_meta_title');
        self::$metaDescriptionKey = config('page.translations_key_meta_description');
        self::$breadcrumbKey = config('page.translations_key_breadcrumb');
        self::$titleKey = config('page.translations_key_title');
        parent::__construct();
    }

    public function getMetaTitle(): string
    {
        return trans(static::$translation_key . '.' . static::$metaTitleKey);
    }

    public function getMetaDescription(): ?string
    {
        return trans(static::$translation_key . '.' . static::$metaDescriptionKey);
    }

    public function getBreadcrumbAnchor():string {
        return trans(static::$translation_key . '.' . static::$breadcrumbKey);
    }

    public function getTitle(): string
    {
        return trans(static::$translation_key . '.' . static::$titleKey);
    }

    public function getUrl(?string $locale = null): string {
        $locale = $locale ?? app()->getLocale();
        return route(static::$route, ['locale' => $locale]);
    }

}
