<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBranchIdToMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('members', function (Blueprint $table) {
            // Add branch_id column, set to nullable
            $table->unsignedBigInteger('branch_id')->nullable()->default(null);

            // Define foreign key constraint
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('members', function (Blueprint $table) {
            // Drop foreign key constraint and the column
            $table->dropForeign(['branch_id']);
            $table->dropColumn('branch_id');
        });
    }
}