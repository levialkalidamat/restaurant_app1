<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('menus', function (Blueprint $table) {
            $table->string('type');
            $table->decimal('coutEstime', 10, 2);
            $table->integer('allergique')->default('0');
            $table->integer('vegetarien')->default('0');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('menus', function (Blueprint $table) {
            $table->dropColumn('type');
            $table->dropColumn('coutEstime');
            $table->dropColumn('allergique');
            $table->dropColumn('vegetarien');
        });
    }
}
