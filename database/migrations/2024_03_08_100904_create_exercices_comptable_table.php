<?php

declare(strict_types=1);

use Core\Utils\Enums\StatusExerciceEnum;
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
 * Class ***`CreateExercicesComptableTable`***
 *
 * A migration class for creating the "exercices_comptable" table with UUID primary key and timestamps.
 *
 * @package ***`\Database\Migrations\CreateExercicesComptableTable`***
 */
class CreateExercicesComptableTable extends Migration
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

            Schema::create('exercices_comptable', function (Blueprint $table) {
                // Define a UUID primary key for the 'exercices_comptable' table
                $this->uuidPrimaryKey($table);
                
                //the year of the exercice
                $table->year('fiscal_year')->useCurrent()->comment('The year of the exerice');

                // the openning date of the exercice
                $table->date('date_ouverture')
                    ->comment('Indicate when the exercice start');

                // the closing date of the exercice
                $table->date('date_fermeture')->nullable()
                    ->comment('Indicate when the exercice end up');

                // "status_exercice" column with default value "ouvert"
                $table->enum('status_exercice', StatusExerciceEnum::values())->default(StatusExerciceEnum::DEFAULT);
    
                // Define a foreign key for 'periode_exercice_id', referencing the 'periodes_exercice' table
                $this->foreignKey(
                    table: $table,          // The table where the foreign key is being added
                    column: 'periode_exercice_id',   // The column to which the foreign key is added ('periode_exercice_id' in this case)
                    references: 'periodes_exercice',    // The referenced table (periodes_exercice) to establish the foreign key relationship
                    onDelete: 'cascade',    // Action to perform when the referenced record is deleted (cascade deletion)
                    nullable: true          // Specify whether the foreign key column can be nullable (true means it allows to be NULL)
                );
                
                // Define a foreign key for 'plan_comptable_id', referencing the 'plans_comptable' table
                $this->foreignKey(
                    table: $table,         // The table where the foreign key is being added
                    column: 'plan_comptable_id',   // The column to which the foreign key is added ('plan_comptable_id' in this case)
                    references: 'plans_comptable', // The referenced table (plans_comptable) to establish the foreign key relationship
                    onDelete: 'cascade',   // Action to perform when the referenced record is deleted (cascade deletion)
                    nullable: false        // Specify whether the foreign key column can be nullable (false means it not allows to be NULL)
                );

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
                
                // Create a composite index for efficient searching on the combination of fiscal_year, date_ouverture, date_fermeture, status_exercice, status and can_be_delete
                $this->compositeKeys(table: $table, keys: ['fiscal_year', 'date_ouverture', 'date_fermeture', 'status_exercice', 'status', 'can_be_delete']);

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
                message: 'Failed to migrate "exercices_comptable" table: ' . $exception->getMessage(),
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
            // Drop the "exercices_comptable" table if it exists
            Schema::dropIfExists('exercices_comptable');

            // Commit the transaction
            DB::commit();
        } catch (\Throwable $exception) {
            // Rollback the transaction in case of an exception
            DB::rollBack();

            // Handle the exception (e.g., logging, notification, etc.)
            throw new \Core\Utils\Exceptions\DatabaseMigrationException(
                message: 'Failed to drop "exercices_comptable" table: ' . $exception->getMessage(),
                previous: $exception
            );
        }
    }
}