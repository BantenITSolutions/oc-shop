<?php namespace DShoreman\Shop\Components;

use Cart;
use Flash;
use Redirect;
use Session;
use Cms\Classes\Page;
use Cms\Classes\ComponentBase;
use DShoreman\Shop\Models\Order as ShopOrder;
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
            'paymentPage' => [
                'title'       => 'Checkout Page',
                'description' => 'Name of the page to redirect to when a user clicks Proceed to Checkout.',
                'default'     => 'checkout/payment',
                'group'       => 'Links',
            ],
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
        $this->prepareVars();
    }

    public function prepareVars()
    {
        $this->paymentPage = $this->page['paymentPage'] = $this->property('paymentPage');
        $this->productPage = $this->page['productPage'] = $this->property('productPage');

        $this->basketItems = $this->page['basketItems'] = Cart::content();
        $this->basketCount = $this->page['basketCount'] = Cart::count();
        $this->basketTotal = $this->page['basketTotal'] = Cart::total();

        if (Session::has('orderId')) {
            $this->orderId = $this->page['orderId'] = Session::get('orderId');
        }
    }

    public function onAddProduct()
    {
        $id = post('id');
        $quantity = post('quantity') ?: 1;

        $product = ShopProduct::find($id);

        Cart::add($id, $product->title, $quantity, $product->price);

        $this->page['basketCount'] = Cart::count();
        $this->page['basketItems'] = Cart::content();
        $this->page['basketTotal'] = Cart::total();
    }

    public function onCheckout()
    {
        $this->prepareVars();

        $this->stripMissingItems();

        if ($this->items_removed > 0) {

            $removed_many = $this->items_removed > 1;

            Flash::error(sprintf(
                "%d %s couldn't be found and %s removed automatically. Please checkout again.",
                $this->items_removed,
                ($removed_many ? 'item' : 'items'),
                ($removed_many ? 'were' : 'was')
            ));

            return Redirect::back();
        }

        $order = new ShopOrder;
        $order->items = json_encode(Cart::content()->toArray());
        $order->total = Cart::total();
        $order->save();

        Session::put('orderId', $order->id);

        return Redirect::to($this->paymentPage);
    }

    protected function stripMissingItems()
    {
        $this->items_removed = 0;

        foreach (Cart::content() as $item)
        {
            if ( ! ShopProduct::find($item->id)) {
                Cart::remove($item->rowid);

                $this->items_removed++;
            }
        }

        return;
    }

}
