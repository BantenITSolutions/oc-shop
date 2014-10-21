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
            'basketComponent' => [
                'title'       => 'Basket Component',
                'description' => 'Component to use when adding products to basket',
                'default'     => 'shopBasket',
            ],
            'basketPartial' => [
                'title'       => 'Basket Partial',
                'description' => 'Partial to use when adding products to basket',
                'default'     => 'shopBasket::default',
            ],
            'tableClass' => [
                'title'       => 'Table',
                'group'       => 'CSS Classes',
            ],
            'nameColClass' => [
                'title'       => 'Name Column',
                'group'       => 'CSS Classes',
            ],
            'qtyColClass' => [
                'title'       => 'Quaantity Column',
                'group'       => 'CSS Classes',
            ],
            'priceColClass' => [
                'title'       => 'Price Column',
                'group'       => 'CSS Classes',
            ],
            'subtotalColClass' => [
                'title'       => 'Subtotal Column',
                'group'       => 'CSS Classes',
            ],
            'totalLabelClass' => [
                'title'       => 'Total Label',
                'group'       => 'CSS Classes',
                'description' => 'Class given to the cell containing the "Total" label.',
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

    public function onRender()
    {
        $this->prepareVars('render');
    }

    public function prepareVars($on = 'run')
    {
        if ($on == 'run') {
            $this->paymentPage = $this->page['paymentPage'] = $this->property('paymentPage');
            $this->productPage = $this->page['productPage'] = $this->property('productPage');

            $this->basketComponent = $this->page['basketComponent'] = $this->property('basketComponent');;
            $this->basketPartial = $this->page['basketPartial'] = $this->property('basketPartial');;
            $this->basketItems = $this->page['basketItems'] = Cart::content();
            $this->basketCount = $this->page['basketCount'] = Cart::count();
            $this->basketTotal = $this->page['basketTotal'] = Cart::total();
        }

        if ($on == 'render') {
            $this->tableClass = $this->page['tableClass'] = $this->propertyOrParam('tableClass');
            $this->nameColClass = $this->page['nameColClass'] = $this->property('nameColClass');
            $this->qtyColClass = $this->page['qtyColClass'] = $this->property('qtyColClass');
            $this->priceColClass = $this->page['priceColClass'] = $this->property('priceColClass');
            $this->subtotalColClass = $this->page['subtotalColClass'] = $this->property('subtotalColClass');
            $this->totalLabelClass = $this->page['totalLabelClass'] = $this->property('totalLabelClass');
        }

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
