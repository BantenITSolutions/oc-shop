<?php namespace DShoreman\Shop\Components;

use Cms\Classes\ComponentBase;
use DShoreman\Shop\Models\Category as ShopCategory;
use DShoreman\Shop\Models\Product as ShopProduct;

class Product extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name'        => 'Shop Product',
            'description' => 'Display a single product', 
        ];
    }

    public function defineProperties()
    {
        return [
            'idParam' => [
                'title' => 'Slug',
                'default' => ':slug',
                'type' => 'string',
            ],
        ];
    }

    public function onRun() {
        $this->product = $this->page['product'] = $this->loadProduct();
    }

    public function loadProduct()
    {
        $productId = $this->propertyOrParam('idParam');

        return ShopProduct::whereSlug($productId)->first();
    }

}
