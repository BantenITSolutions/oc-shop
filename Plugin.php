<?php namespace DShoreman\Shop;

use Backend;
use System\Classes\PluginBase;

/**
 * Shop Plugin Information File
 */
class Plugin extends PluginBase
{

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
                ],
            ],
        ];
    }

    public function registerPermissions()
    {
        return [
            'dshoreman.shop.access_products'   => ['label' => "Manage the shop's products"],
            'dshoreman.shop.access_categories' => ['label' => "Manage the shop categories"],
        ];
    }

}
