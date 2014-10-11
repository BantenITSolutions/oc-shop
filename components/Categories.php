<?php namespace DShoreman\Shop\Components;

use Cms\Classes\Page;
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
        return [
            'categoryPage' => [
                'title'       => 'Category page',
                'description' => 'Name of the page file to use for the category links. This property is used by the default component partial.',
                'type'        => 'dropdown',
                'default'     => 'shop/category',
                'group'       => 'Links',
            ],
        ];
    }

    public function getCategoryPageOptions()
    {
        return Page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');
    }

    public function onRun()
    {
        $this->categoryPage = $this->page['categoryPage'] = $this->property('categoryPage');

        $this->categories = $this->page['categories'] = $this->listCategories();
    }

    public function listCategories()
    {
        $categories = ShopCategory::all();

        $categories->each(function($category)
        {
            $category->setUrl($this->categoryPage, $this->controller);
        });

        return $categories;
    }

}
