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
            'basketContainer' => [
                'title' => 'Basket container element',
                'description' => 'Basket container element to update when adding products to cart',
            ],
            'addButtonText' => [
                'title' => 'Buy button text',
            ],
            'rowClass' => [
                'title' => 'Row',
                'group' => 'CSS Classes',
                'default' => 'row',
            ],
            'imageClass' => [
                'title' => 'Image',
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
            'qtyClass' => [
                'title' => 'Quantity',
                'group' => 'CSS Classes',
            ],
            'qtyWrapperClass' => [
                'title' => 'Quantity Wrapper',
                'group' => 'CSS Classes',
            ],
            'qtyLabelClass' => [
                'title' => 'Quantity Label',
                'group' => 'CSS Classes',
            ],
            'qtyContainerClass' => [
                'title' => 'Quantity container',
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

    public function onRun()
    {
        $this->prepareVars();

        $this->product = $this->page['product'] = $this->loadProduct();
    }

    public function prepareVars()
    {
        $this->basketContainer = $this->page['basketContainer'] = $this->property('basketContainer');
        $this->addButtonText = $this->page['addButtonText'] = $this->property('addButtonText');
        $this->rowClass = $this->page['rowClass'] = $this->property('rowClass');
        $this->imageClass = $this->page['imageClass'] = $this->property('imageClass');
        $this->productContainerClass = $this->page['productContainerClass'] = $this->property('productContainerClass');
        $this->detailContainerClass = $this->page['detailContainerClass'] = $this->property('detailContainerClass');
        $this->qtyClass= $this->page['qtyClass'] = $this->property('qtyClass');
        $this->qtyWrapperClass= $this->page['qtyWrapperClass'] = $this->property('qtyWrapperClass');
        $this->qtyLabelClass= $this->page['qtyLabelClass'] = $this->property('qtyLabelClass');
        $this->qtyContainerClass = $this->page['qtyContainerClass'] = $this->property('qtyContainerClass');
        $this->priceClass= $this->page['priceClass'] = $this->property('priceClass');
        $this->priceContainerClass = $this->page['priceContainerClass'] = $this->property('priceContainerClass');
        $this->addButtonContainerClass = $this->page['addButtonContainerClass'] = $this->property('addButtonContainerClass');
        $this->addButtonClass = $this->page['addButtonClass'] = $this->property('addButtonClass');
    }

    public function loadProduct()
    {
        $productId = $this->propertyOrParam('idParam');

        return ShopProduct::whereSlug($productId)->first();
    }

}
