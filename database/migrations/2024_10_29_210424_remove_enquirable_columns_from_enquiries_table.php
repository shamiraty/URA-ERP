<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveEnquirableColumnsFromEnquiriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // List of columns to be dropped
        $columnsToDrop = [
            'loan_type',
            'loan_amount',
            'loan_duration',
            'loan_category',
            'refund_amount',
            'refund_duration',
            'share_amount',
            'date_of_retirement',
            'retirement_amount',
            'from_amount',
            'to_amount',
            'withdraw_saving_amount',
            'withdraw_saving_reason',
            'withdraw_deposit_amount',
            'withdraw_deposit_reason',
            'unjoin_reason',
            'category',
            'benefit_amount',
            'benefit_description',
            'benefit_remarks',
            // Add any other columns you've removed from the $fillable array
        ];

        Schema::table('enquiries', function (Blueprint $table) use ($columnsToDrop) {
            foreach ($columnsToDrop as $column) {
                if (Schema::hasColumn('enquiries', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('enquiries', function (Blueprint $table) {
            // Re-add the columns with appropriate data types
            // Adjust the data types and nullable settings as per your requirements

            $table->string('loan_type')->nullable();
            $table->decimal('loan_amount', 15, 2)->nullable();
            $table->integer('loan_duration')->nullable();
            $table->string('loan_category')->nullable();
            $table->decimal('refund_amount', 15, 2)->nullable();
            $table->integer('refund_duration')->nullable();
            $table->decimal('share_amount', 15, 2)->nullable();
            $table->date('date_of_retirement')->nullable();
            $table->decimal('retirement_amount', 15, 2)->nullable();
            $table->decimal('from_amount', 15, 2)->nullable();
            $table->decimal('to_amount', 15, 2)->nullable();
            $table->decimal('withdraw_saving_amount', 15, 2)->nullable();
            $table->string('withdraw_saving_reason')->nullable();
            $table->decimal('withdraw_deposit_amount', 15, 2)->nullable();
            $table->string('withdraw_deposit_reason')->nullable();
            $table->string('unjoin_reason')->nullable();
            $table->string('category')->nullable();
            $table->decimal('benefit_amount', 15, 2)->nullable();
            $table->string('benefit_description')->nullable();
            $table->string('benefit_remarks')->nullable();
            // Add any other columns you've dropped
        });
    }
}
