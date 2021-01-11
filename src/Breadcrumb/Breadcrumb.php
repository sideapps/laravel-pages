<?php


namespace Sideapps\LaravelPages\Breadcrumb;


class Breadcrumb {

    private array $items;

    /**
     * Breadcrumb constructor.
     * @param $items
     */
    public function __construct(array $items) {
        $this->items = $items;
    }

    /**
     * @return array
     */
    public function getItems(): array
    {
        return $this->items;
    }

    public function getBackItemForMobile():BreadcrumbItem {
        return $this->items[count($this->items) - 2];
    }

}
