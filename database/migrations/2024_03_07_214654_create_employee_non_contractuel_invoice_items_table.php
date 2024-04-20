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
 * Class ***`CreateEmployeeNonContractuelInvoiceItemsTable`***
 *
 * A migration class for creating the "employee_non_contractuel_invoice_items" table with UUID primary key and timestamps.
 *
 * @package ***`\Database\Migrations\CreateEmployeeNonContractuelInvoiceItemsTable`***
 */
class CreateEmployeeNonContractuelInvoiceItemsTable extends Migration
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

            Schema::create('employee_non_contractuel_invoice_items', function (Blueprint $table) {
                // Define a UUID primary key for the 'employee_non_contractuel_invoice_items' table
                $this->uuidPrimaryKey($table);

                // Define a foreign key for 'unite_travaille_id', pointing to the 'unite_travailles' table
                $this->foreignKey(
                    table: $table,          // The table where the foreign key is being added
                    column: 'unite_travaille_id',   // The column to which the foreign key is added ('unite_travaille_id' in this case)
                    references: 'unite_travailles',    // The referenced table (unite_travailles) to establish the foreign key relationship
                    onDelete: 'cascade',    // Action to perform when the referenced record is deleted (cascade deletion)
                    nullable: false          // Specify whether the foreign key column can be nullable (false means it not allows NULL)
                );

                $table->decimal('quantity', 8, 2);

                // Define the decimal column 'unit_price'
                $table->decimal('unit_price', 8, 2)->comment('The monetary unit_price associated with the "unit_price" entry');          
                
                // Define the decimal column 'total'
                $table->decimal('total', 8, 2)->comment('The monetary total associated with the "unit_price" entry');          
                
                // Define a foreign key for 'employee_non_contractuel_invoice_id', pointing to the 'employee_non_contractuel_invoices' table
                $this->foreignKey(
                    table: $table,          // The table where the foreign key is being added
                    column: 'employee_non_contractuel_invoice_id',   // The column to which the foreign key is added ('employee_non_contractuel_invoice_id' in this case)
                    references: 'employee_non_contractuel_invoices',    // The referenced table (employee_non_contractuel_invoices) to establish the foreign key relationship
                    onDelete: 'cascade',    // Action to perform when the referenced record is deleted (cascade deletion)
                    nullable: false          // Specify whether the foreign key column can be nullable (false means it not allows NULL)
                );

                $table->nullableUuidMorphs('detail');

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
                message: 'Failed to migrate "employee_non_contractuel_invoice_items" table: ' . $exception->getMessage(),
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
            // Drop the "employee_non_contractuel_invoice_items" table if it exists
            Schema::dropIfExists('employee_non_contractuel_invoice_items');

            // Commit the transaction
            DB::commit();
        } catch (\Throwable $exception) {
            // Rollback the transaction in case of an exception
            DB::rollBack();

            // Handle the exception (e.g., logging, notification, etc.)
            throw new \Core\Utils\Exceptions\DatabaseMigrationException(
                message: 'Failed to drop "employee_non_contractuel_invoice_items" table: ' . $exception->getMessage(),
                previous: $exception
            );
        }
    }
}