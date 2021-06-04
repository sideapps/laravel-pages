<?php


namespace Sideapps\LaravelPages\Pages;

use Illuminate\Contracts\View\View;
use JoeDixon\Translation\Drivers\Translation;
use Sideapps\LaravelPages\Breadcrumb\Breadcrumb;
use Sideapps\LaravelPages\Breadcrumb\BreadcrumbItem;

abstract class BasePage implements Page {

    protected CreatePageFactory $createPageFactory;

    protected static string $translation_key;

    protected static string $view;

    protected static bool $metaIndex = true;

    protected bool $useRestrictLocales = false;

    public function __construct() {
        $this->createPageFactory = resolve(CreatePageFactory::class);
    }

    public function restrictLocales(): array {
        return [];
    }

    public function getAllAlternatesUrls():array {
        /** @var Translation $translations */
        $translations = resolve(Translation::class);
        if ($this->useRestrictLocales) $locales = $this->restrictLocales();
        else $locales = $translations->allLanguages()->keys();

        $urls = [];
        if (count($locales) > 0) {
            foreach ($locales as $locale) {
                $urls[$locale] = $this->getUrl($locale);
            }
        }
        return $urls;
    }

    public function getAlternatesUrls():array {
        $urls = $this->getAllAlternatesUrls();
        if (count($urls) > 0) {
            return array_filter($urls, function (string $url, string $locale) {
                return app()->getLocale() !== $locale;
            }, ARRAY_FILTER_USE_BOTH);
        }
        return [];
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

    public function trans(string $key, ?string $locale = null):?string {
        if (!$locale) $locale = app()->getLocale();
        return trans(static::$translation_key . '.' . $key, [], $locale);
    }

    public function getLangAttribute(): string {
        return str_replace('_', '-', app()->getLocale());
    }

    public function render(array $vars = []):View {
        $vars['page'] = $this;
        return \view(static::$view, $vars);
    }

}
