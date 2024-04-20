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
 * Class ***`CreateProjetsProductionTable`***
 *
 * A migration class for creating the "projets_production" table with UUID primary key and timestamps.
 *
 * @package ***`\Database\Migrations\CreateProjetsProductionTable`***
 */
class CreateProjetsProductionTable extends Migration
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

            Schema::create('projets_production', function (Blueprint $table) {
                // Define a UUID primary key for the 'projets_production' table
                $this->uuidPrimaryKey($table);

                // Define a string column 'intitule' to store the description or label of the ecriture comptable (accounting entry).
                $table->string('intitule')
                    ->comment('Intitule du projet de production');

                // Define a string column 'description' to store the description or label of the ecriture comptable (accounting entry).
                $table->text('description')->nullable()
                    ->comment('Description du projet de production');

                // Date debut du projet de production
                $table->date('date_debut')
                    ->comment("Date debut du projet de production");

                // Date fin du projet de production
                $table->date('date_fin')->nullable()
                    ->comment("Date fin du projet de production");                
                    
                // Define a foreign key for 'ligne_de_production_id', referencing the 'lignes_de_production' table
                $this->foreignKey(
                    table: $table,          // The table where the foreign key is being added
                    column: 'ligne_de_production_id',   // The column to which the foreign key is added ('ligne_de_production_id' in this case)
                    references: 'lignes_de_production',    // The referenced table (lignes_de_production) to establish the foreign key relationship
                    onDelete: 'cascade',    // Action to perform when the referenced record is deleted (cascade deletion)
                    nullable: false          // Specify whether the foreign key column can be nullable (false means it not allows to be NULL)
                );
                    
                // Define a foreign key for 'article_id', referencing the 'articles' table
                $this->foreignKey(
                    table: $table,          // The table where the foreign key is being added
                    column: 'article_id',   // The column to which the foreign key is added ('article_id' in this case)
                    references: 'articles',    // The referenced table (articles) to establish the foreign key relationship
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

                // Create a composite index for efficient searching on the combination of status and can_be_delete
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
                message: 'Failed to migrate "projets_production" table: ' . $exception->getMessage(),
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
            // Drop the "projets_production" table if it exists
            Schema::dropIfExists('projets_production');

            // Commit the transaction
            DB::commit();
        } catch (\Throwable $exception) {
            // Rollback the transaction in case of an exception
            DB::rollBack();

            // Handle the exception (e.g., logging, notification, etc.)
            throw new \Core\Utils\Exceptions\DatabaseMigrationException(
                message: 'Failed to drop "projets_production" table: ' . $exception->getMessage(),
                previous: $exception
            );
        }
    }
}
