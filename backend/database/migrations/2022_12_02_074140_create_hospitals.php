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
        Schema::create('hospitals', function (Blueprint $table) {
            $table->integerIncrements('id')->unsigned()->comment('ID');
            $table->string('type', 10)->nullable()->comment('医療機関種別');
            $table->string('code', 10)->nullable()->comment('医療機関コード');
            $table->string('name', 100)->nullable()->comment('医療機関名');
            $table->string('postal_code', 100)->nullable()->comment('郵便番号');
            $table->string('address', 100)->nullable()->comment('住所');
            $table->string('tel', 15)->nullable()->comment('電話番号');
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
        Schema::dropIfExists('hospitals');
    }
};
