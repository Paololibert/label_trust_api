<?php

declare(strict_types=1);

use Core\Utils\Enums\StatutContratEnum;
use Core\Utils\Enums\StatutEmployeeEnum;
use Core\Utils\Enums\TypeContratEnum;
use Core\Utils\Enums\TypeEmployeeEnum;
use Core\Utils\Enums\TypeUniteTravailleEnum;
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
 * Class ***`CreateSalairesTable`***
 *
 * A migration class for creating the "salaires" table with UUID primary key and timestamps.
 *
 * @package ***`\Database\Migrations\CreateSalairesTable`***
 */
class CreateSalairesTable extends Migration
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

            Schema::create('salaires', function (Blueprint $table) {
                // Define a UUID primary key for the 'salaires' table
                $this->uuidPrimaryKey($table);

                $table->decimal('montant', 10, 2);
                // 
                $table->date('date_debut')->useCurrent()
                    ->comment('Indicate when the contract was created');
                // 
                $table->date('date_fin')->nullable()
                    ->comment('Indicate when the contract was created');

                // Add a boolean column '' to the table
                $table->boolean('est_valide')
                    ->default(TRUE); // Set the default value to TRUE
                
                // Define a foreign key for 'user_id', referencing the 'contracts' table
                $this->foreignKey(
                    table: $table,          // The table where the foreign key is being added
                    column: 'contract_id',   // The column to which the foreign key is added ('user_id' in this case)
                    references: 'contracts',    // The referenced table (contracts) to establish the foreign key relationship
                    onDelete: 'cascade',    // Action to perform when the referenced record is deleted (cascade deletion)
                    nullable: false          // Specify whether the foreign key column can be nullable (false means it not allows to be NULL)
                );
    
                // Define a foreign key for 'poste_salarie_id', referencing the 'poste_salaries' table
                $this->foreignKey(
                    table: $table,          // The table where the foreign key is being added
                    column: 'poste_salarie_id',   // The column to which the foreign key is added ('poste_salarie_id' in this case)
                    references: 'poste_salaries',    // The referenced table (poste_salaries) to establish the foreign key relationship
                    onDelete: 'cascade',    // Action to perform when the referenced record is deleted (cascade deletion)
                    nullable: true          // Specify whether the foreign key column can be nullable (false means it not allows to be NULL)
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
                
                // Create a composite index for efficient searching on the combination of name, slug, key, status and can_be_delete
                $this->compositeKeys(table: $table, keys: [ 'status', 'can_be_delete']);

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
                message: 'Failed to migrate "salaires" table: ' . $exception->getMessage(),
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
            // Drop the "salaires" table if it exists
            Schema::dropIfExists('salaires');

            // Commit the transaction
            DB::commit();
        } catch (\Throwable $exception) {
            // Rollback the transaction in case of an exception
            DB::rollBack();

            // Handle the exception (e.g., logging, notification, etc.)
            throw new \Core\Utils\Exceptions\DatabaseMigrationException(
                message: 'Failed to drop "salaires" table: ' . $exception->getMessage(),
                previous: $exception
            );
        }
    }
}
