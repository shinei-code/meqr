<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('codes', function (Blueprint $table) {
            $table->integerIncrements('id')->comment('ID');
            $table->string('category', 30)->nullable()->comment('カテゴリー');
            $table->string('key', 10)->nullable()->comment('キー');
            $table->string('value', 80)->nullable()->comment('値');
            $table->string('sub_value', 100)->nullable()->comment('値2');
            $table->integer('display_order')->default(1)->comment('表示順');
            $table->boolean('is_not_display')->default(0)->comment('非表示(０：表示　１：非表示)');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('codes');
    }
};
