<?php

declare(strict_types=1);

use Core\Utils\Enums\TypeEcritureCompteEnum;
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
 * Class ***`CreateEcrituresAnalytiqueTable`***
 *
 * A migration class for creating the "ecritures_analytique" table with UUID primary key and timestamps.
 *
 * @package ***`\Database\Migrations\CreateEcrituresAnalytiqueTable`***
 */
class CreateEcrituresAnalytiqueTable extends Migration
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

            Schema::create('ecritures_analytique', function (Blueprint $table) {
                // Define a UUID primary key for the 'ecritures_analytique' table
                $this->uuidPrimaryKey($table);

                // Define a string column 'libelle' to store the description or label of the ecriture comptable (accounting entry).
                $table->string('libelle')
                    ->comment('Description or label of the accounting entry.');

                // Define the decimal column 'montant' for storing the total monetary amount on the debit side with 12 digits, 2 of which are decimal places.cimal places.
                $table->decimal('montant', 12, 2)
                    ->comment('Total amount on the debit side.');

                // "type_ecriture_compte" column with default value "debit"
                $table->enum('type_ecriture_compte', TypeEcritureCompteEnum::values())->default(TypeEcritureCompteEnum::DEFAULT);

                $table->uuidMorphs('accountable');

                // The ecriture comptable date, indicating when the accounting entry is recorded or written.
                $table->date('date_ecriture')
                    ->comment('Date when the accounting entry is recorded or written.');

                // Define a foreign key for 'exercice_comptable_journal_id', referencing the 'exercice_comptable_journaux' table
                $this->foreignKey(
                    table: $table,         // The table where the foreign key is being added
                    column: 'exercice_comptable_journal_id',   // The column to which the foreign key is added ('exercice_comptable_journal_id' in this case)
                    references: 'exercice_comptable_journaux', // The referenced table (exercice_comptable_journaux) to establish the foreign key relationship
                    onDelete: 'cascade',   // Action to perform when the referenced record is deleted (cascade deletion)
                    nullable: true        // Specify whether the foreign key column can be nullable (false means it not allows to be NULL)
                );

                // Define a foreign key for 'projet_production_id', referencing the 'projets_production' table
                $this->foreignKey(
                    table: $table,         // The table where the foreign key is being added
                    column: 'projet_production_id',   // The column to which the foreign key is added ('operation_disponible_id' in this case)
                    references: 'projets_production', // The referenced table (projets_production) to establish the foreign key relationship
                    onDelete: 'cascade',   // Action to perform when the referenced record is deleted (cascade deletion)
                    nullable: false        // Specify whether the foreign key column can be nullable (false means it not allows to be NULL)
                );

                // Define a foreign key for 'operation_disponible_id', referencing the 'operations_comptable' table
                $this->foreignKey(
                    table: $table,         // The table where the foreign key is being added
                    column: 'operation_disponible_id',   // The column to which the foreign key is added ('operation_disponible_id' in this case)
                    references: 'operations_comptable', // The referenced table (operations_comptable) to establish the foreign key relationship
                    onDelete: 'cascade',   // Action to perform when the referenced record is deleted (cascade deletion)
                    nullable: true        // Specify whether the foreign key column can be nullable (false means it not allows to be NULL)
                );

                // Add a boolean column 'status' to the table
                $table->boolean('status')
                    ->default(TRUE) // Set the default value to TRUE
                    ->comment(
                        'Record status: 
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
                $this->compositeKeys(table: $table, keys: ['status', 'can_be_delete']);

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
                message: 'Failed to migrate "ecritures_analytique" table: ' . $exception->getMessage(),
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
            // Drop the "ecritures_analytique" table if it exists
            Schema::dropIfExists('ecritures_analytique');

            // Commit the transaction
            DB::commit();
        } catch (\Throwable $exception) {
            // Rollback the transaction in case of an exception
            DB::rollBack();

            // Handle the exception (e.g., logging, notification, etc.)
            throw new \Core\Utils\Exceptions\DatabaseMigrationException(
                message: 'Failed to drop "ecritures_analytique" table: ' . $exception->getMessage(),
                previous: $exception
            );
        }
    }
}
