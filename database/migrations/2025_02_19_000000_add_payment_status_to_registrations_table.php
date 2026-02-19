<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddPaymentStatusToRegistrationsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('registrations', function (Blueprint $table) {
      $table->enum('payment_status', ['verified', 'non-verified'])->default('non-verified')->after('payment_type');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('registrations', function (Blueprint $table) {
      $table->dropColumn('payment_status');
    });
  }
}
