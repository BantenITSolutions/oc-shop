<?php namespace DShoreman\Shop\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Dshoreman\Shop\Models\Order;

/**
 * Orders Back-end Controller
 */
class Orders extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController'
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('DShoreman.Shop', 'shop', 'orders');
    }

    public function update($recordId, $context = null)
    {
        $this->vars['itemCount'] = 0;

        $order = Order::find($recordId);

        foreach (json_decode($order->items) as $item) {
            $this->vars['itemCount'] += $item->qty;
        }

        return $this->asExtension('FormController')
                    ->update($recordId, $context);
    }

}
