<?php namespace DShoreman\Shop;

use App;
use Backend;
use System\Classes\PluginBase;
use Illuminate\Foundation\AliasLoader;

/**
 * Shop Plugin Information File
 */
class Plugin extends PluginBase
{

    public function boot()
    {
        // Register service providers
        App::register('\Gloudemans\Shoppingcart\ShoppingcartServiceProvider');

        // Register facades
        $facade = AliasLoader::getInstance();
        $facade->alias('Cart', '\Gloudemans\Shoppingcart\Facades\Cart');
    }

    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'Shop',
            'description' => 'No description provided yet...',
            'author'      => 'Dave Shoreman',
            'icon'        => 'icon-shopping-cart'
        ];
    }

    public function registerComponents()
    {
        return [
            'DShoreman\Shop\Components\Basket' => 'shopBasket',
            'DShoreman\Shop\Components\Categories' => 'shopCategories',
            'DShoreman\Shop\Components\Product' => 'shopProduct',
            'DShoreman\Shop\Components\Products' => 'shopProducts',
        ];
    }

    public function registerNavigation()
    {
        return [
            'shop' => [
                'label'       => 'Shop',
                'url'         => Backend::url('dshoreman/shop/products'),
                'icon'        => 'icon-shopping-cart',
                'permissions' => ['dshoreman.shop.*'],
                'order'       => 300,

                'sideMenu' => [
                    'products' => [
                        'label'       => 'Products',
                        'url'         => Backend::url('dshoreman/shop/products'),
                        'icon'        => 'icon-gift',
                        'permissions' => ['dshoreman.shop.access_products']
                    ],
                    'categories' => [
                        'label'       => 'Categories',
                        'url'         => Backend::url('dshoreman/shop/categories'),
                        'icon'        => 'icon-list-ul',
                        'permissions' => ['dshoreman.shop.access_categories'],
                    ],
                    'orders' => [
                        'label'       => 'Orders',
                        'url'         => Backend::url('dshoreman/shop/orders'),
                        'icon'        => 'icon-gbp',
                        'permissions' => ['dshoreman.shop.access_orders'],
                    ],
                ],
            ],
        ];
    }

    public function registerFormWidgets()
    {
        return [
            'Dshoreman\Shop\FormWidgets\ItemGrid' => [
                'label' => 'Order Item Grid',
                'alias' => 'itemgrid',
            ],
        ];
    }

    public function registerPermissions()
    {
        return [
            'dshoreman.shop.access_products'   => ['label' => "Manage the shop's products"],
            'dshoreman.shop.access_categories' => ['label' => "Manage the shop categories"],
            'dshoreman.shop.access_orders' => ['label' => "Manage the shop orders"],
        ];
    }

}
