<?php namespace Dshoreman\Shop\Models;

use Model;

class Settings extends Model {

    public $implement = ['System.Behaviors.SettingsModel'];

    public $settingsCode = 'dshoreman_shop_settings';

    public $settingsFields = 'fields.yaml';

}
