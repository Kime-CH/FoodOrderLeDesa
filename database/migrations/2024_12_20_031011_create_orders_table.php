<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID
            $table->unsignedBigInteger('user_id'); // Foreign key for the user
            $table->unsignedBigInteger('menu_id'); // Foreign key for the menu item
            $table->integer('quantity'); // Quantity of the ordered item
            $table->decimal('total_price', 8, 2); // Total price of the order
            $table->timestamps(); // Created at and updated at timestamps

            // Foreign key constraints (if you have users and menus tables)
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('menu_id')->references('id')->on('menus')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}