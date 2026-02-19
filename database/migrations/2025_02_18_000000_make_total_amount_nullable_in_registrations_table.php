<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class MakeTotalAmountNullableInRegistrationsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    // Using raw SQL to modify the column to be nullable
    DB::statement('ALTER TABLE registrations MODIFY total_amount DECIMAL(10,2) NULL');
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    // Reverse: make the column not nullable again
    DB::statement('ALTER TABLE registrations MODIFY total_amount DECIMAL(10,2) NOT NULL');
  }
}
