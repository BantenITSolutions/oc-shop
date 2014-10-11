<?php namespace DShoreman\Shop\Components;

use Cart;
use Cms\Classes\Page;
use Cms\Classes\ComponentBase;
use DShoreman\Shop\Models\Product as ShopProduct;

class Basket extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name'        => 'Basket Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [
            'productPage' => [
                'title'       => 'Product Page',
                'description' => 'Name of the product page for the product titles. This property is used by the default component partial.',
                'type'        => 'dropdown',
                'default'     => 'shop/product',
                'group'       => 'Links',
            ],
        ];
    }

    public function getProductPageOptions()
    {
        return Page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');
    }

    public function onRun()
    {
        $this->productPage = $this->page['productPage'] = $this->property('productPage');

        $this->basketItems = $this->page['basketItems'] = Cart::content();
        $this->basketCount = $this->page['basketCount'] = Cart::count();
        $this->basketTotal = $this->page['basketTotal'] = Cart::total();
    }

    public function onAddProduct()
    {
        $id = post('id');
        $quantity = post('quantity');

        $product = ShopProduct::find($id);

        Cart::add($id, $product->title, $quantity, $product->price);

        $this->page['basketCount'] = Cart::count();
        $this->page['basketItems'] = Cart::content();
        $this->page['basketTotal'] = Cart::total();
    }

}
