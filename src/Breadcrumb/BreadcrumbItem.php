<?php


namespace Sideapps\LaravelPages\Breadcrumb;

class BreadcrumbItem {

    private ?string $url;

    private string $anchor;

    /**
     * BreadcrumbItem constructor.
     * @param ?string $url
     * @param string $anchor
     */
    public function __construct(string $anchor, ?string $url = null) {
        $this->url = $url;
        $this->anchor = $anchor;
    }

    /**
     * @return string|null
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * @return string
     */
    public function getAnchor(): string
    {
        return $this->anchor;
    }

    public function hasUrl():bool {
        return (bool) $this->url;
    }


}
