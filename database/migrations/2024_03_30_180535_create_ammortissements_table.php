<?php

declare(strict_types=1);

use Core\Utils\Enums\MethodeImmobilisationEnum;
use Core\Utils\Enums\TypeImmobilisationEnum;
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
 * Class ***`CreateAmmortissementsTable`***
 *
 * A migration class for creating the "ammortissements" table with UUID primary key and timestamps.
 *
 * @package ***`\Database\Migrations\CreateAmmortissementsTable`***
 */
class CreateAmmortissementsTable extends Migration
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

            Schema::create('ammortissements', function (Blueprint $table) {
                // Define a UUID primary key for the 'ammortissements' table
                $this->uuidPrimaryKey($table);

                // Define the decimal column 'montant' for storing the monetary amount with 12 digits, 2 of which are decimal places
                $table->decimal('montant', 12, 2)->comment('');

                // Date debut de l'ammortissement
                $table->date('date_debut')
                    ->comment("Date debut de l'ammortissement");

                // Date fin de l'ammortissement
                $table->date('date_fin')->nullable()
                    ->comment("Date fin de l'ammortissement");

                // Define the integer column 'annete' for storing the monetary amount with 12 digits, 2 of which are integer places
                $table->integer('annete')->comment('');

                // Define the decimal column 'taux' for storing the monetary amount with 12 digits, 2 of which are decimal places
                $table->decimal('taux', 12, 2)->comment('');

                // Define the decimal column 'valeur_ammortissable' for storing the monetary amount with 12 digits, 2 of which are decimal places
                $table->decimal('valeur_ammortissable', 12, 2)->comment("Valeur ammortissable");

                // Define the decimal column 'valeur_comptable' for storing the monetary amount with 12 digits, 2 of which are decimal places
                $table->decimal('valeur_comptable', 12, 2)->comment("Valeur ammortissable");

                // Define a foreign key for 'immobilisation_id', referencing the 'immobilisations' table
                $this->foreignKey(
                    table: $table,          // The table where the foreign key is being added
                    column: 'immobilisation_id',   // The column to which the foreign key is added ('immobilisation_id' in this case)
                    references: 'immobilisations',    // The referenced table (immobilisations) to establish the foreign key relationship
                    onDelete: 'cascade',    // Action to perform when the referenced record is deleted (cascade deletion)
                    nullable: false          // Specify whether the foreign key column can be nullable (false means it not allows to be NULL)
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


                // Create a composite index for efficient searching on the combination of code, name, status and can_be_delete
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
                message: 'Failed to migrate "ammortissements" table: ' . $exception->getMessage(),
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
            // Drop the "ammortissements" table if it exists
            Schema::dropIfExists('ammortissements');

            // Commit the transaction
            DB::commit();
        } catch (\Throwable $exception) {
            // Rollback the transaction in case of an exception
            DB::rollBack();

            // Handle the exception (e.g., logging, notification, etc.)
            throw new \Core\Utils\Exceptions\DatabaseMigrationException(
                message: 'Failed to drop "ammortissements" table: ' . $exception->getMessage(),
                previous: $exception
            );
        }
    }
}
