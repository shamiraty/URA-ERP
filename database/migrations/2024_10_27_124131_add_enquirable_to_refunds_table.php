<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('refunds', function (Blueprint $table) {
            // Add the polymorphic fields
            $table->unsignedBigInteger('enquirable_id')->nullable(); // This will store the ID of the associated enquiry
            $table->string('enquirable_type')->nullable(); // This will store the model type of the associated enquiry

            // You may want to add indexes for better performance
            $table->index(['enquirable_id', 'enquirable_type']);
        });
    }

    public function down()
    {
        Schema::table('refunds', function (Blueprint $table) {
            // Remove the polymorphic fields when rolling back
            $table->dropIndex(['enquirable_id', 'enquirable_type']); // Drop the index first
            $table->dropColumn(['enquirable_id', 'enquirable_type']); // Then drop the columns
        });
    }
};
