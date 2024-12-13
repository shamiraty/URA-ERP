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
        Schema::table('enquiries', function (Blueprint $table) {
            $table->unsignedBigInteger('enquirable_id')->nullable(); // For polymorphic ID
            $table->string('enquirable_type')->nullable(); // For polymorphic Type

            // Optionally, add an index for better performance
            $table->index(['enquirable_id', 'enquirable_type']);
        });
    }

    public function down()
    {
        Schema::table('enquiries', function (Blueprint $table) {
            // Drop the index first
            $table->dropIndex(['enquirable_id', 'enquirable_type']);
            // Drop the polymorphic fields
            $table->dropColumn(['enquirable_id', 'enquirable_type']);
        });
    }
};
