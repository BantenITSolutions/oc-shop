<?php namespace DShoreman\Shop\Components;

use Cms\Classes\Page;
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
            'basketContainer' => [
                'title' => 'Basket container element to update when adding products to cart',
            ],
            'addButtonText' => [
                'title' => 'Buy button text',
            ],
            'productPage' => [
                'title'       => 'Product Page',
                'description' => 'Name of the product page for the product titles. This property is used by the default component partial.',
                'type'        => 'dropdown',
                'default'     => 'shop/product',
                'group'       => 'Links',
            ],
            'imageClass' => [
                'title' => 'Image',
                'group' => 'CSS Classes',
            ],
            'rowClass' => [
                'title' => 'Row',
                'group' => 'CSS Classes',
                'default' => 'row',
            ],
            'productColumnClass' => [
                'title' => 'Product column',
                'group' => 'CSS Classes',
            ],
            'productContainerClass' => [
                'title' => 'Product container',
                'group' => 'CSS Classes',
            ],
            'detailContainerClass' => [
                'title' => 'Detail container',
                'group' => 'CSS Classes',
            ],
            'priceClass' => [
                'title' => 'Price',
                'group' => 'CSS Classes',
            ],
            'priceContainerClass' => [
                'title' => 'Price container',
                'group' => 'CSS Classes',
            ],
            'addButtonClass' => [
                'title' => 'Buy button',
                'group' => 'CSS Classes',
            ],
            'addButtonContainerClass' => [
                'title' => 'Buy button container',
                'group' => 'CSS Classes',
            ],
        ];
    }

    public function getProductPageOptions()
    {
        return Page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');
    }

    public function onRun()
    {
        $this->prepareVars();

        if ($this->category) {
            $this->products = $this->page['products'] = $this->listProducts();
        }
    }

    public function prepareVars()
    {
        $this->productPage = $this->page['productPage'] = $this->property('productPage');
        $this->category = $this->page['category'] = $this->loadCategory();

        $this->productColumnClass = $this->page['productColumnClass'] = $this->property('productColumnClass');
        $this->productContainerClass = $this->page['productContainerClass'] = $this->property('productContainerClass');
        $this->imageClass = $this->page['imageClass'] = $this->property('imageClass');
        $this->detailContainerClass = $this->page['detailContainerClass'] = $this->property('detailContainerClass');
        $this->rowClass = $this->page['rowClass'] = $this->property('rowClass');
        $this->priceContainerClass = $this->page['priceContainerClass'] = $this->property('priceContainerClass');
        $this->addButtonContainerClass = $this->page['addButtonContainerClass'] = $this->property('addButtonContainerClass');
        $this->addButtonClass = $this->page['addButtonClass'] = $this->property('addButtonClass');
        $this->basketContainer = $this->page['basketContainer'] = $this->property('basketContainer');
        $this->addButtonText = $this->page['addButtonText'] = $this->property('addButtonText');
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
        $products = ShopProduct::whereCategoryId($this->category->id)->get();

        $products->each(function($product)
        {
            $product->setUrl($this->productPage, $this->controller);
        });

        return $products;
    }

}
