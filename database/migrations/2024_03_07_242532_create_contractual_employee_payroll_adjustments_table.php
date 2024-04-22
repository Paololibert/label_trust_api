<?php

declare(strict_types=1);

use Core\Utils\Enums\AdjustementCategoryEnum;
use Core\Utils\Enums\AdjustementTypeEnum;
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
 * Class ***`CreateContractualEmployeePayrollAdjustmentsTable`***
 *
 * A migration class for creating the "contractual_employee_payroll_adjustments" table with UUID primary key and timestamps.
 *
 * @package ***`\Database\Migrations\CreateContractualEmployeePayrollAdjustmentsTable`***
 */
class CreateContractualEmployeePayrollAdjustmentsTable extends Migration
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

            Schema::create('contractual_employee_payroll_adjustments', function (Blueprint $table) {
                // Define a UUID primary key for the 'contractual_employee_payroll_adjustments' table
                $this->uuidPrimaryKey($table);
                
                $table->enum('ajustement_category', AdjustementCategoryEnum::values())->default(AdjustementCategoryEnum::DEFAULT)->comment("Categorie d'ajustement");
                
                $table->enum('ajustement_type', AdjustementTypeEnum::values())->default(AdjustementTypeEnum::DEFAULT)->comment("Type d'ajustement");
                
                $table->string('ajustement_name')->comment("Nom ou description de l'ajustement.");

                // Define the decimal column 'ajustement_value' for storing the monetary amount with 8 digits, 2 of which are decimal places
                $table->decimal('ajustement_value', 8, 2)->comment("Valeur de l'ajustement.");
                
                $table->enum('ajustement_value_type', ["fixe", "variable"])->default("variable")->comment("Type de valeur de l'ajustement.");

                // Define the decimal column 'base_value' for storing the monetary amount with 8 digits, 2 of which are decimal places
                $table->decimal('base_value', 8, 2)->default(0.00)->comment("Valeur de base sur laquelle l'ajustement est appliqué.");

                // Issue date
                $table->date('valid_from')->comment("Date de début de validité de l'ajustement.");

                // Issue date
                $table->date('valid_to')->comment("Date de fin de validité de l'ajustement (optionnel).");

                //Define if the ajustement is paid or not
                $table->boolean('ajustement_status')->default(false)->comment("Statut de l'ajustement true/false.");

                // Define a foreign key for 'employee_contractuel_id', referencing the 'employee_contractuels' table
                $this->foreignKey(
                    table: $table,          // The table where the foreign key is being added
                    column: 'employee_contractuel_id',   // The column to which the foreign key is added ('employee_contractuel_id' in this case)
                    references: 'employee_contractuels',    // The referenced table (employee_contractuels) to establish the foreign key relationship
                    onDelete: 'cascade',    // Action to perform when the referenced record is deleted (cascade deletion)
                    nullable: false          // Specify whether the foreign key column can be nullable (false means it is not allows to be NULL)
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

                // Create a composite index for efficient searching on the combination of name, status and can_be_delete
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
                message: 'Failed to migrate "contractual_employee_payroll_adjustments" table: ' . $exception->getMessage(),
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

            // Drop the "contractual_employee_payroll_adjustments" table if it exists
            Schema::dropIfExists('contractual_employee_payroll_adjustments');

            // Commit the transaction
            DB::commit();
        } catch (\Throwable $exception) {
            // Rollback the transaction in case of an exception
            DB::rollBack();

            // Handle the exception (e.g., logging, notification, etc.)
            throw new \Core\Utils\Exceptions\DatabaseMigrationException(
                message: 'Failed to drop "contractual_employee_payroll_adjustments" table: ' . $exception->getMessage(),
                previous: $exception
            );
        }
    }
}