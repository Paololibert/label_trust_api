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
 * Class ***`CreateExerciceComptableJournauxTable`***
 *
 * A migration class for creating the "exercice_comptable_journaux" table with UUID primary key and timestamps.
 *
 * @package ***`\Database\Migrations\CreateExerciceComptableJournauxTable`***
 */
class CreateExerciceComptableJournauxTable extends Migration
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

            Schema::create('exercice_comptable_journaux', function (Blueprint $table) {
                // Define a UUID primary key for the 'exercice_comptable_journaux' table
                $this->uuidPrimaryKey($table);   
                
                // Define a foreign key for 'exercice_comptable_id', referencing the 'exercices_comptable' table
                $this->foreignKey(
                    table: $table,          // The table where the foreign key is being added
                    column: 'exercice_comptable_id',   // The column to which the foreign key is added ('exercice_comptable_id' in this case)
                    references: 'exercices_comptable',    // The referenced table (exercices_comptable) to establish the foreign key relationship
                    onDelete: 'cascade',    // Action to perform when the referenced record is deleted (cascade deletion)
                    nullable: false          // Specify whether the foreign key column can be nullable (false means it not allows to be NULL)
                );       
                
                // Define a foreign key for 'journal_id', referencing the 'journaux' table
                $this->foreignKey(
                    table: $table,          // The table where the foreign key is being added
                    column: 'journal_id',   // The column to which the foreign key is added ('journal_id' in this case)
                    references: 'journaux',    // The referenced table (journaux) to establish the foreign key relationship
                    onDelete: 'cascade',    // Action to perform when the referenced record is deleted (cascade deletion)
                    nullable: false          // Specify whether the foreign key column can be nullable (false means it not allows to be NULL)
                );    

                // Define the decimal column 'total' for storing the monetary amount with 8 digits, 2 of which are decimal places
                $table->decimal('total', 12, 2)->comment('');

                // Define the decimal column 'total_debit' for storing the monetary amount with 8 digits, 2 of which are decimal places
                $table->decimal('total_debit', 12, 2)->comment('');
                
                // Define the decimal column 'total_credit' for storing the monetary amount with 8 digits, 2 of which are decimal places
                $table->decimal('total_credit', 12, 2)->comment('');

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
                

                // Create a composite index for efficient searching on the combination of total, total_debit, total_credit, status and can_be_delete
                $this->compositeKeys(table: $table, keys: ['total', 'total_debit', 'total_credit', 'status', 'can_be_delete']);

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
                message: 'Failed to migrate "exercice_comptable_journaux" table: ' . $exception->getMessage(),
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
            // Drop the "exercice_comptable_journaux" table if it exists
            Schema::dropIfExists('exercice_comptable_journaux');

            // Commit the transaction
            DB::commit();
        } catch (\Throwable $exception) {
            // Rollback the transaction in case of an exception
            DB::rollBack();

            // Handle the exception (e.g., logging, notification, etc.)
            throw new \Core\Utils\Exceptions\DatabaseMigrationException(
                message: 'Failed to drop "exercice_comptable_journaux" table: ' . $exception->getMessage(),
                previous: $exception
            );
        }
    }
}