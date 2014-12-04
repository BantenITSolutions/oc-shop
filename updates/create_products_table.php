<?php namespace DShoreman\Shop\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateProductsTable extends Migration
{

    public function up()
    {
        Schema::create('dshoreman_shop_products', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('category_id')->unsigned();
            $table->string('title')->index();
            $table->string('slug')->index()->unique();
            $table->longText('description');
            $table->decimal('price', 7, 2);
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('dshoreman_shop_categories');
        });
    }

    public function down()
    {
        Schema::dropIfExists('dshoreman_shop_products');
    }

}
