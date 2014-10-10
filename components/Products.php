<?php namespace DShoreman\Shop\Components;

use Cms\Classes\ComponentBase;
use DShoreman\Shop\Models\Category as ShopCategory;
use DShoreman\Shop\Models\Product as ShopProduct;

class Products extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name'        => 'Shop Product List',
            'description' => 'Display products from a given category',
        ];
    }

    public function defineProperties()
    {
        return [
            'categoryFilter' => [
                'title'       => 'Category filter',
                'description' => 'Enter a category slug or URL parameter to filter the posts by. Leave empty to show all posts.',
                'type'        => 'string',
                'default'     => ''
            ],
        ];
    }

    public function onRun() {
        $this->category = $this->page['category'] = $this->loadCategory();
        $this->products = $this->page['products'] = $this->listProducts();
    }

    public function loadCategory()
    {
        if (!$categoryId = $this->propertyOrParam('categoryFilter'))
            return null;

        if (!$category = ShopCategory::whereSlug($categoryId))
            return null;

        return $category->first();
    }

    public function listProducts()
    {
        return ShopProduct::whereCategoryId($this->category->id)->get();
    }

}
