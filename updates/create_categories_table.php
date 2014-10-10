<?php namespace DShoreman\Shop\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateCategoriesTable extends Migration
{

    public function up()
    {
        Schema::create('dshoreman_shop_categories', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('title')->index();
            $table->string('description')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dshoreman_shop_categories');
    }

}
