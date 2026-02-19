<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DatabaseMigrationsCreateRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->string('customer_no')->unique();
            $table->enum('customer_type', ['new', 'existing']);
            $table->enum('family_included', ['yes', 'no']);
            $table->integer('adults_count')->nullable();
            $table->integer('child_count')->nullable();
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->text('address');
            $table->string('state');
            $table->text('notes')->nullable();
            $table->decimal('total_amount', 10, 2);
            $table->string('payment_type');
            $table->string('payment_receipt')->nullable();
            $table->string('qr_code')->nullable();
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
        Schema::dropIfExists('registrations');
    }
}
