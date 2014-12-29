<?php namespace Dshoreman\Shop\FormWidgets;

use Backend\Classes\FormField;
use Backend\Classes\FormWidgetBase;
use Backend\Widgets\Grid;

class ItemGrid extends FormWidgetBase {

    public function widgetDetails()
    {
        return [
            'name' => 'Item Grid',
            'description' => 'Renders a grid of items from an order',
        ];
    }

    public function render()
    {
        $this->prepareVars();

        return $this->makePartial('itemgrid');
    }

    public function prepareVars()
    {
        $this->vars['items'] = $this->formField->value;
    }

    public function getSaveData($value)
    {
        return FormField::NO_SAVE_DATA;
    }

}
