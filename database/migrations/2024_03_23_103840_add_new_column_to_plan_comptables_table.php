<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddNewColumnToPlanComptablesTable extends Migration
{
    /**
     * Run the migrations.
     * 
     * @return void
     * 
     * @throws \Core\Utils\Exceptions\DatabaseMigrationException If the migration fails.
     */
    public function up(): void
    {
        // Begin the database transaction
        DB::beginTransaction();

        try {

            if (Schema::hasTable('plans_comptable')) {
                Schema::table('plans_comptable', function (Blueprint $table) {

                    if (!Schema::hasColumn('plans_comptable', 'est_valider')) {
                        // Add a boolean column 'est_valider' to the table
                        $table->boolean('est_valider')->default(false);
                    }
                });
            }

            // Commit the transaction
            DB::commit();
        } catch (\Throwable $exception) {
            // Rollback the transaction in case of an exception
            DB::rollBack();

            // Handle the exception (e.g., logging, notification, etc.)
            throw new \Core\Utils\Exceptions\DatabaseMigrationException(
                message: 'Failed to migrate "plans_comptable" table: ' . $exception->getMessage(),
                previous: $exception
            );
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     *
     * @throws \Core\Utils\Exceptions\DatabaseMigrationException If the migration fails.
     */
    public function down(): void
    {
        // Begin the database transaction
        DB::beginTransaction();

        try {
            if (Schema::hasTable('plans_comptable')) {
                Schema::table('plans_comptable', function (Blueprint $table) {

                    if (Schema::hasColumn('plans_comptable', 'est_valider')) {
                        // Drop the 'est_valider' column if it exists
                        $table->dropColumn('est_valider');
                    }
                });
            }

            // Commit the transaction
            DB::commit();
        } catch (\Throwable $exception) {
            // Rollback the transaction in case of an exception
            DB::rollBack();

            // Handle the exception (e.g., logging, notification, etc.)
            throw new \Core\Utils\Exceptions\DatabaseMigrationException(
                message: 'Failed to drop "est_valider" column: ' . $exception->getMessage(),
                previous: $exception
            );
        }
    }
}
