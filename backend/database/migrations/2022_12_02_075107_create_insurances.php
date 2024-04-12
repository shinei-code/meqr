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
        Schema::create('insurances', function (Blueprint $table) {
            $table->integerIncrements('id')->unsigned()->comment('ID');
            $table->string('type', 10)->nullable()->comment('種別');
            $table->string('code', 12)->nullable()->comment('保険者名番号');
            $table->string('kana_name', 100)->nullable()->comment('保険者名カナ');
            $table->string('name', 100)->nullable()->comment('保険者名');
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
        Schema::dropIfExists('insurances');
    }
};
