<?php


namespace Sideapps\LaravelPages\Pages;


use Illuminate\Support\Str;

abstract class DynamicPage extends BasePage {

    protected static string $route;

    protected static array $routeParams;

    protected Pageable $model;

    protected static string $metaTitleKey;

    protected static string $metaDescriptionKey;

    protected static string $breadcrumbKey;

    protected static string $titleKey;

    protected static string $contentKey;

    public function __construct(Pageable $model)
    {
        $this->model = $model;
        self::$metaTitleKey = config('page.model_key_meta_title');
        self::$metaDescriptionKey = config('page.model_key_meta_description');
        self::$breadcrumbKey = config('page.model_key_breadcrumb');
        self::$titleKey = config('page.model_key_title');
        self::$contentKey = config('page.model_key_content');
        parent::__construct();
    }

    public function getMetaTitle():string {
        $metaTitleKey = static::$metaTitleKey;
        $titleKey = static::$titleKey;
        if ($this->model->$metaTitleKey) return $this->model->$metaTitleKey;
        return $this->model->$titleKey;
    }

    public function getMetaDescription():?string {
        $metaDescriptionKey = static::$metaDescriptionKey;
        $contentKey = static::$contentKey;
        if ($this->model->$metaDescriptionKey) return $this->model->$metaDescriptionKey;
        elseif($this->model->$contentKey) return Str::limit($this->model->$contentKey, 200, ' ...');
        return null;
    }

    public function getBreadcrumbAnchor():string {
        $breadcrumbKey = static::$breadcrumbKey;
        $titleKey = static::$titleKey;
        if ($this->model->$breadcrumbKey) return $this->model->$breadcrumbKey;
        return $this->model->$titleKey;
    }

    public function getTitle(): string {
        $titleKey = static::$titleKey;
        return $this->model->$titleKey;
    }

    public function getUrl(?string $locale = null): string {
        if (!$locale) $locale = app()->getLocale();
        $params = ['locale' => $locale];
        foreach (static::$routeParams as $routeParam) $params[$routeParam] = $this->model->getTranslation($routeParam, $locale);
        return route(static::$route, $params);
    }

}
