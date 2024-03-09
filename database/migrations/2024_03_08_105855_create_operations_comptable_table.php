<?php

declare(strict_types=1);

use Core\Utils\Enums\StatusOperationDisponibleEnum;
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
 * Class ***`CreateOperationsComptableTable`***
 *
 * A migration class for creating the "operations_comptable" table with UUID primary key and timestamps.
 *
 * @package ***`\Database\Migrations\CreateOperationsComptableTable`***
 */
class CreateOperationsComptableTable extends Migration
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

            Schema::create('operations_comptable', function (Blueprint $table) {
                // Define a UUID primary key for the 'operations_comptable' table
                $this->uuidPrimaryKey($table);
                
                // Define a string column 'libelle' to store the description or label of the ecriture comptable (accounting entry).
                $table->string('libelle')
                    ->comment('Description or label of the accounting entry.');
                
                // The ecriture comptable date, indicating when the accounting entry is recorded or written.
                $table->date('date_ecriture')
                    ->comment('Date when the accounting entry is recorded or written.');

                // Define the decimal column 'total_debit' to store the total debit amount for the account, with 12 digits, 2 of which represent decimal places
                $table->decimal('total_debit', 12, 2)
                    ->comment('Total debit amount for the account.');

                // Define the decimal column 'total_credit' to store the total credit amount for the account, with 12 digits, 2 of which represent decimal places
                $table->decimal('total_credit', 12, 2)
                    ->comment('Total credit amount for the account.');

                // "status_exercice" column with default value "ouvert"
                $table->enum('status_operation', StatusOperationDisponibleEnum::values())->default(StatusOperationDisponibleEnum::DEFAULT);

                // Add a boolean column 'status' to the table
                $table->boolean('status')
                    ->default(TRUE) // Set the default value to TRUE
                    ->comment('Record status: 
                            - TRUE: Active record or soft delete record
                            - FALSE: permanently Deleted and can be archived in another datastore'
                        ); // Describe the meaning of the 'status' column

                // Add a boolean column 'can_be_delete' with default value false
                $this->addCanDeleteColumn(table: $table, column_name: 'can_be_delete', can_be_delete: true);
                
                // Define a foreign key for 'created_by', pointing to the 'users' table
                $this->foreignKey(
                    table: $table,          // The table where the foreign key is being added
                    column: 'created_by',   // The column to which the foreign key is added ('created_by' in this case)
                    references: 'users',    // The referenced table (users) to establish the foreign key relationship
                    onDelete: 'cascade',    // Action to perform when the referenced record is deleted (cascade deletion)
                    nullable: false          // Specify whether the foreign key column can be nullable (false means it not allows NULL)
                );
                
                // Create a composite index for efficient searching on the combination of total_debit, total_credit, date_ecriture, status and can_be_delete
                $this->compositeKeys(table: $table, keys: ['date_ecriture', 'total_debit', 'total_credit', 'status', 'can_be_delete']);

                // Add timestamp and soft delete columns to the table
                $this->addTimestampsAndSoftDeletesColumns($table);
            });

            // Commit the transaction
            DB::commit();
        } catch (\Throwable $exception) {
            // Rollback the transaction in case of an exception
            DB::rollBack();

            // Handle the exception (e.g., logging, notification, etc.)
            throw new \Core\Utils\Exceptions\DatabaseMigrationException(
                message: 'Failed to migrate "operations_comptable" table: ' . $exception->getMessage(),
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
            // Drop the "operations_comptable" table if it exists
            Schema::dropIfExists('operations_comptable');

            // Commit the transaction
            DB::commit();
        } catch (\Throwable $exception) {
            // Rollback the transaction in case of an exception
            DB::rollBack();

            // Handle the exception (e.g., logging, notification, etc.)
            throw new \Core\Utils\Exceptions\DatabaseMigrationException(
                message: 'Failed to drop "operations_comptable" table: ' . $exception->getMessage(),
                previous: $exception
            );
        }
    }
}