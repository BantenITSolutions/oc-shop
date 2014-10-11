<?php namespace DShoreman\Shop\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateAddressesTable extends Migration
{

    public function up()
    {
        Schema::create('dshoreman_shop_addresses', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
            $table->string('street');
            $table->string('town');
            $table->string('county');
            $table->string('postcode');
            $table->string('country');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dshoreman_shop_addresses');
    }

}
