<?php namespace DShoreman\Shop\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Carbon\Carbon;
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

        $this_month_start = Carbon::now()->startOfMonth();
        $last_month_start = Carbon::now()->subMonth()->startOfMonth();
        $last_month_end = Carbon::now()->subMonth()->endOfMonth();

        $this->vars['ordersCount'] = Order::where('created_at', '>=', $this_month_start)->count();
        $this->vars['ordersCountLast'] = Order::whereBetween('created_at', [$last_month_start, $last_month_end])->count();
        $this->vars['ordersCountClass'] = $this->scoreboardClass($this->vars['ordersCountLast'], $this->vars['ordersCount']);

        $this->vars['ordersValue'] = Order::where('created_at', '>=', $this_month_start)->sum('total');
        $this->vars['ordersValueLast'] = Order::whereBetween('created_at', [$last_month_start, $last_month_end])->sum('total');
        $this->vars['ordersValueClass'] = $this->scoreboardClass($this->vars['ordersValueLast'], $this->vars['ordersValue']);

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
        $this->vars['itemCount'] = 0;

        $order = Order::find($recordId);

        foreach (json_decode($order->items) as $item) {
            $this->vars['itemCount'] += $item->qty;
        }

        return $this->asExtension('FormController')
                    ->update($recordId, $context);
    }

}
