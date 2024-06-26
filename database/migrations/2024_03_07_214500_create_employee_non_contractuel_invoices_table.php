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
 * Class ***`CreateEmployeeNonContractuelInvoicesTable`***
 *
 * A migration class for creating the "employee_non_contractuel_invoices" table with UUID primary key and timestamps.
 *
 * @package ***`\Database\Migrations\CreateEmployeeNonContractuelInvoicesTable`***
 */
class CreateEmployeeNonContractuelInvoicesTable extends Migration
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

            Schema::create('employee_non_contractuel_invoices', function (Blueprint $table) {
                // Define a UUID primary key for the 'employee_non_contractuel_invoices' table
                $this->uuidPrimaryKey($table);

                $table->string('invoice_number')->unique();

                // Define the decimal column 'total' for storing the monetary amount with 8 digits, 2 of which are decimal places
                $table->decimal('total', 8, 2)->comment('The monetary amount associated with the "montants" entry');

                // Invoice issue date
                $table->date('issue_date')->useCurrent(); 

                // Invoice due date
                $table->date('due_date')->useCurrent(); 

                //Define if the invoice is paid or not
                $table->boolean('invoice_status')->default(false);               
                
                // Define a foreign key for 'employee_non_contractuel_id', pointing to the 'employee_non_contractuels' table
                $this->foreignKey(
                    table: $table,          // The table where the foreign key is being added
                    column: 'employee_non_contractuel_id',   // The column to which the foreign key is added ('employee_non_contractuel_id' in this case)
                    references: 'employee_non_contractuels',    // The referenced table (employee_non_contractuels) to establish the foreign key relationship
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
                message: 'Failed to migrate "employee_non_contractuel_invoices" table: ' . $exception->getMessage(),
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
            // Drop the "employee_non_contractuel_invoices" table if it exists
            Schema::dropIfExists('employee_non_contractuel_invoices');

            // Commit the transaction
            DB::commit();
        } catch (\Throwable $exception) {
            // Rollback the transaction in case of an exception
            DB::rollBack();

            // Handle the exception (e.g., logging, notification, etc.)
            throw new \Core\Utils\Exceptions\DatabaseMigrationException(
                message: 'Failed to drop "employee_non_contractuel_invoices" table: ' . $exception->getMessage(),
                previous: $exception
            );
        }
    }
}