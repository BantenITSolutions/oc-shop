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
            $table->string('stripe_token');
            $table->integer('billing_address')->unsigned();
            $table->integer('shipping_address')->unsigned();
            $table->text('items');
            $table->decimal('total', 7, 2);
            $table->boolean('is_paid')->default(false);
            $table->timestamps();

            $table->foreign('billing_address')->references('id')->on('dshoreman_shop_addresses');
            $table->foreign('shipping_address')->references('id')->on('dshoreman_shop_addresses');
        });
    }

    public function down()
    {
        Schema::dropIfExists('dshoreman_shop_orders');
    }

}
