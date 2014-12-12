<?php namespace DShoreman\Shop\Components;

use Cms\Classes\ComponentBase;
use DShoreman\Shop\Models\Order as ShopOrder;

class Order extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name'        => 'Order Component',
            'description' => 'Display details from an order',
        ];
    }

    public function defineProperties()
    {
        return [
            'idParam' => [
                'title'   => 'Identifier',
                'default' => ':order_id',
                'type'    => 'string',
            ],
        ];
    }

    public function onRun()
    {
        $this->order = $this->page['order'] = $this->loadOrder();
    }

    public function loadOrder()
    {
        $orderId = $this->propertyOrParam('idParam');

        return ShopOrder::find($orderId);
    }

}
