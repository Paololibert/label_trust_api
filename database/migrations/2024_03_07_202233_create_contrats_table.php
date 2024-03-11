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
 * Class ***`CreateContractsTable`***
 *
 * A migration class for creating the "contrats" table with UUID primary key and timestamps.
 *
 * @package ***`\Database\Migrations\CreateContractsTable`***
 */
class CreateContractsTable extends Migration
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

            Schema::create('contracts', function (Blueprint $table) {
                // Define a UUID primary key for the 'contracts' table
                $this->uuidPrimaryKey($table);

                //the unique reference of the contracts
                $table->string('reference')->unique()->comment('The unique reference of the contracts');

                // "type_contract" column with default value "cdd"
                $table->enum('type_contract', TypeContratEnum::values())->default(TypeContratEnum::DEFAULT);

                //the duration of the contracts
                $table->float('duree', 3, 1)->comment('The duration of the contracts');

                // the starting date of the contrat
                $table->date('date_debut')
                    ->comment('Indicate when the contracts was created');

                // Indicathe the ending date
                $table->date('date_fin')->nullable()
                    ->comment('Indicate when the contracts was created');

                // "contract_status" column with default value "personal"
                $table->enum('contract_status', StatutContratEnum::values())->default(StatutContratEnum::DEFAULT);

                // Add a boolean column 'renouvelable' to the table
                $table->boolean('renouvelable')
                    ->default(TRUE)->comment('Indicate if the contract is renouveble'); // Set the default value to TRUE

                // Add a boolean column 'est_renouveler' to the table
                $table->boolean('est_renouveler')
                    ->default(FALSE)->comment('Indicate if the contract is realy renew'); // Set the default value to TRUE
                
                // Define a foreign key for 'poste_id', pointing to the 'postes' table
                $this->foreignKey(
                    table: $table,          // The table where the foreign key is being added
                    column: 'poste_id',   // The column to which the foreign key is added ('poste_id' in this case)
                    references: 'postes',    // The referenced table (postes) to establish the foreign key relationship
                    onDelete: 'cascade',    // Action to perform when the referenced record is deleted (cascade deletion)
                    nullable: false          // Specify whether the foreign key column can be nullable (false means it not allows NULL)
                );
                
                // Define a foreign key for 'employee_contractuel_id', pointing to the 'employee_contractuels' table
                $this->foreignKey(
                    table: $table,          // The table where the foreign key is being added
                    column: 'employee_contractuel_id',   // The column to which the foreign key is added ('employee_contractuel_id' in this case)
                    references: 'employee_contractuels',    // The referenced table (employee_contractuels) to establish the foreign key relationship
                    onDelete: 'cascade',    // Action to perform when the referenced record is deleted (cascade deletion)
                    nullable: false          // Specify whether the foreign key column can be nullable (false means it not allows NULL)
                );

                // Define a foreign key for 'unite_mesures_id', pointing to the 'unite_mesuress' table
                $this->foreignKey(
                    table: $table,          // The table where the foreign key is being added
                    column: 'unite_mesures_id',   // The column to which the foreign key is added ('unite_mesures_id' in this case)
                    references: 'unite_mesures',    // The referenced table (unite_mesuress) to establish the foreign key relationship
                    onDelete: 'cascade',    // Action to perform when the referenced record is deleted (cascade deletion)
                    nullable: false          // Specify whether the foreign key column can be nullable (false means it not allows NULL)
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
                $this->compositeKeys(table: $table, keys: ['reference', 'status', 'can_be_delete']);

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
                message: 'Failed to migrate "contrats" table: ' . $exception->getMessage(),
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
            // Drop the "contrats" table if it exists
            Schema::dropIfExists('contrats');

            // Commit the transaction
            DB::commit();
        } catch (\Throwable $exception) {
            // Rollback the transaction in case of an exception
            DB::rollBack();

            // Handle the exception (e.g., logging, notification, etc.)
            throw new \Core\Utils\Exceptions\DatabaseMigrationException(
                message: 'Failed to drop "contrats" table: ' . $exception->getMessage(),
                previous: $exception
            );
        }
    }
}
