<?php


namespace Sideapps\LaravelPages\Pages;

use Illuminate\Contracts\View\View;
use JoeDixon\Translation\Drivers\Translation;
use Sideapps\LaravelPages\Breadcrumb\Breadcrumb;
use Sideapps\LaravelPages\Breadcrumb\BreadcrumbItem;

abstract class BasePage {

    protected CreatePageFactory $createPageFactory;

    protected static bool $metaIndex = true;

    public function __construct() {
        $this->createPageFactory = resolve(CreatePageFactory::class);
    }

    public function getAllAlternatesUrls():array {
        /** @var Translation $translations */
        $translations = resolve(Translation::class);
        $array = [];
        foreach ($translations->allLanguages()->keys() as $locale) {
            $array[$locale] = $this->getUrl($locale);
        }
        return $array;
    }

    public function getAlternatesUrls():array {
        return array_filter($this->getAllAlternatesUrls(), function (string $url, string $locale) {
            return app()->getLocale() !== $locale;
        }, ARRAY_FILTER_USE_BOTH);
    }

    public function generateAlternateLinks():View {
        $urls = $this->getAlternatesUrls();
        return view('laravelPage::alternatesUrls', compact('urls'));
    }

    public function generateMetaIndex():?View {
        if (!static::$metaIndex) {
            return view('laravelPage::metaNoIndex');
        }
        return null;
    }

    public function generateSwitchLanguageLinks():View {
        $urls = $this->getAllAlternatesUrls();
        return view('laravelPage::switchLanguage', compact('urls'));
    }

    public function getBreadcrumb():?Breadcrumb {
        return null;
    }

    public function generateBreadcrumb():View {
        $breadcrumb = $this->getBreadcrumb();
        return view('laravelPage::breadcrumb', compact('breadcrumb'));
    }

    public function getBreadcrumbItem(bool $withUrl = true): BreadcrumbItem {
        return new BreadcrumbItem($this->getBreadcrumbAnchor(), $withUrl ? $this->getUrl() : null);
    }

}
