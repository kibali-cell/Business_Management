<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Modify currencies table
        Schema::table('currencies', function (Blueprint $table) {
            if (Schema::hasColumn('currencies', 'rate')) {
                $table->dropColumn('rate'); // Check before dropping
            }

            // Add the new 'rate' column
            $table->decimal('rate', 10, 4)->default(1.0000)->after('is_default');
        });

        // Modify bank_accounts table
        Schema::table('bank_accounts', function (Blueprint $table) {
            if (Schema::hasColumn('bank_accounts', 'currency')) {
                $table->dropColumn('currency'); // Check before dropping
            }

            if (!Schema::hasColumn('bank_accounts', 'currency_id')) {
                // Add currency_id without specifying "after" if account_type doesn't exist
                $table->foreignId('currency_id')->nullable()
                    ->constrained('currencies') // References the 'currencies' table
                    ->onDelete('restrict');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reverse changes to bank_accounts table
        Schema::table('bank_accounts', function (Blueprint $table) {
            if (Schema::hasColumn('bank_accounts', 'currency_id')) {
                $table->dropForeign(['currency_id']); // Drop the foreign key constraint
                $table->dropColumn('currency_id');   // Drop the column
            }

            if (!Schema::hasColumn('bank_accounts', 'currency')) {
                $table->string('currency')->nullable(); // Re-add the original column
            }
        });

        // Reverse changes to currencies table
        Schema::table('currencies', function (Blueprint $table) {
            if (Schema::hasColumn('currencies', 'rate')) {
                $table->dropColumn('rate'); // Drop the new rate column
            }
        });
    }
};
