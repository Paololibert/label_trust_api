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
 * Class ***`CreatePaySlipsTable`***
 *
 * A migration class for creating the "pay_slips" table with UUID primary key and timestamps.
 *
 * @package ***`\Database\Migrations\CreatePaySlipsTable`***
 */
class CreatePaySlipsTable extends Migration
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

            Schema::create('pay_slips', function (Blueprint $table) {
                // Define a UUID primary key for the 'pay_slips' table
                $this->uuidPrimaryKey($table);
                
                $table->string('reference')->unique();

                // Issue date
                $table->date('issue_date');

                // Issue date
                $table->date('periode_date');

                // Issue date
                $table->date('start_date');

                // Issue date
                $table->date('end_date');

                //Define if the pay_slip is paid or not
                $table->boolean('pay_slip_status')->default(false);

                // Define the decimal column 'total_hors_taxe' for storing the monetary amount with 8 digits, 2 of which are decimal places
                $table->decimal('total_hors_taxe', 8, 2)->default(0.00)->comment("Total hors taxe");

                // Define the decimal column 'tva' for storing the monetary amount with 8 digits, 2 of which are decimal places
                $table->decimal('tva', 8, 2)->default(0.00)->comment("TVA");

                // Define the decimal column 'ttc' for storing the monetary amount with 8 digits, 2 of which are decimal places
                $table->decimal('ttc', 8, 2)->default(0.00)->comment("Total tout taxe comprise");

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
                message: 'Failed to migrate "pay_slips" table: ' . $exception->getMessage(),
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

            // Drop the "pay_slips" table if it exists
            Schema::dropIfExists('pay_slips');

            // Commit the transaction
            DB::commit();
        } catch (\Throwable $exception) {
            // Rollback the transaction in case of an exception
            DB::rollBack();

            // Handle the exception (e.g., logging, notification, etc.)
            throw new \Core\Utils\Exceptions\DatabaseMigrationException(
                message: 'Failed to drop "pay_slips" table: ' . $exception->getMessage(),
                previous: $exception
            );
        }
    }
}