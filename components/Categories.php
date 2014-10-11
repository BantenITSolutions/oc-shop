<?php namespace DShoreman\Shop\Components;

use Cms\Classes\ComponentBase;
use DShoreman\Shop\Models\Category as ShopCategory;

class Categories extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name'        => 'Shop Category List',
            'description' => 'Displays a list of shop categories on the page.',
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function onRun()
    {
        $this->categories = $this->page['categories'] = $this->listCategories();
    }

    public function listCategories()
    {
        return ShopCategory::all();
    }

}
