<?php namespace DShoreman\Shop\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateOrdersTable extends Migration
{

    public function up()
    {
        Schema::create('dshoreman_shop_orders', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('email');
            $table->text('items');
            $table->decimal('total', 7, 2);
            $table->boolean('is_paid')->default(false);
            $table->string('stripe_token');
            $table->string('billing_name');
            $table->string('billing_street');
            $table->string('billing_town');
            $table->string('billing_county');
            $table->string('billing_postcode');
            $table->string('shipping_name');
            $table->string('shipping_street');
            $table->string('shipping_town');
            $table->string('shipping_county');
            $table->string('shipping_postcode');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dshoreman_shop_orders');
    }

}
