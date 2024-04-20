<?php

declare(strict_types=1);

use Core\Utils\Traits\Database\Migrations\CanDeleteTrait;
use Core\Utils\Traits\Database\Migrations\HasCompositeKey;
use Core\Utils\Traits\Database\Migrations\HasForeignKey;
use Core\Utils\Traits\Database\Migrations\HasTimestampsAndSoftDeletes;
use Core\Utils\Traits\Database\Migrations\HasUuidPrimaryKey;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Class `AddNewColumnToOperationsComptableTable`
 *
 * A migration class for creating the "données" table with UUID primary key and timestamps.
 *
 * @package `\Database\Migrations\AddNewColumnToOperationsComptableTable`
 */
class AddNewColumnToOperationsComptableTable extends Migration
{
    use CanDeleteTrait, HasCompositeKey, HasForeignKey, HasTimestampsAndSoftDeletes, HasUuidPrimaryKey;

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

            if (Schema::hasTable('operations_comptable')) {
                if (!Schema::hasColumn('operations_comptable', 'exercice_comptable_id')) {
                    Schema::table('operations_comptable', function (Blueprint $table) {
                        // Define a foreign key for 'exercice_comptable_id', referencing the 'exercices_comptable' table
                        $this->foreignKey(
                            table: $table,          // The table where the foreign key is being added
                            column: 'exercice_comptable_id',   // The column to which the foreign key is added ('exercice_comptable_id' in this case)
                            references: 'exercices_comptable',    // The referenced table (exercices_comptable) to establish the foreign key relationship
                            onDelete: 'cascade',    // Action to perform when the referenced record is deleted (cascade deletion)
                            nullable: false          // Specify whether the foreign key column can be nullable (false means it not allows to be NULL)
                        );
                    });
                }
            }

            // Commit the transaction
            DB::commit();
        } catch (\Throwable $exception) {
            // Rollback the transaction in case of an exception
            DB::rollBack();

            // Handle the exception (e.g., logging, notification, etc.)
            throw new \Core\Utils\Exceptions\DatabaseMigrationException(
                message: 'Failed to migrate table: ' . $exception->getMessage(),
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

            if (Schema::hasTable('operations_comptable')) {
                if (Schema::hasColumn('operations_comptable', 'exercice_comptable_id')) {
                    Schema::table('operations_comptable', function (Blueprint $table) {
                        $table->dropForeign(['exercice_comptable_id']);
                        // Drop the 'exercice_comptable_id' column if it exists
                        $table->dropColumn('exercice_comptable_id');
                    });
                }
            }

            // Commit the transaction
            DB::commit();
        } catch (\Throwable $exception) {
            // Rollback the transaction in case of an exception
            DB::rollBack();

            // Handle the exception (e.g., logging, notification, etc.)
            throw new \Core\Utils\Exceptions\DatabaseMigrationException(
                message: 'Failed to drop "données" table: ' . $exception->getMessage(),
                previous: $exception
            );
        }
    }
}
