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

    public function index()
    {
        $this->vars['ordersTotal'] = Order::count();
        $this->vars['ordersTotalLast'] = 17;

        $this->vars['ordersPaid'] = Order::where('is_paid', 1)->count();
        $this->vars['ordersPending'] = $this->vars['ordersTotal'] - $this->vars['ordersPaid'];

        $c = $this->vars['ordersCount'] = Order::createdThisMonth()->count();
        $cl = $this->vars['ordersCountLast'] = Order::createdLastMonth()->count();
        $this->vars['ordersCountClass'] = $this->scoreboardClass($cl, $c);

        $v = $this->vars['ordersValue'] = Order::createdThisMonth()->sum('total');
        $vl = $this->vars['ordersValueLast'] = Order::createdLastMonth()->sum('total');
        $this->vars['ordersValueClass'] = $this->scoreboardClass($vl, $v);

        return $this->asExtension('ListController')->index();
    }

    public function scoreboardClass($oldVal, $newVal)
    {
        if ($newVal > $oldVal)
            return 'positive';

        if ($oldVal > $newVal)
            return 'negative';

        return '';
    }

    public function update($recordId, $context = null)
    {
        $this->bodyClass = 'compact-container';

        $this->vars['itemCount'] = 0;

        $order = Order::find($recordId);

        foreach ($order->items as $item) {
            $this->vars['itemCount'] += $item->qty;
        }

        return $this->asExtension('FormController')
                    ->update($recordId, $context);
    }

}
