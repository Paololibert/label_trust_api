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
 * Class ***`CreateCategoryOfEmployeeTauxTable`***
 *
 * A migration class for creating the "category_of_employee_taux" table with UUID primary key and timestamps.
 *
 * @package ***`\Database\Migrations\CreateCategoryOfEmployeeTauxTable`***
 */
class CreateCategoryOfEmployeeTauxTable extends Migration
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

            Schema::create('category_of_employee_taux', function (Blueprint $table) {
                // Define a UUID primary key for the 'category_of_employee_taux' table
                $this->uuidPrimaryKey($table);

                // Add a boolean column 'est_le_taux_de_base' to the table
                $table->boolean('est_le_taux_de_base')
                    ->default(FALSE) // Set the default value to FALSE
                    ->comment('');
                
                // Define a foreign key for 'category_of_employee_id', referencing the 'categories_of_employees' table
                $this->foreignKey(
                        table: $table,          // The table where the foreign key is being added
                        column: 'category_of_employee_id',   // The column to which the foreign key is added ('category_of_employee_id' in this case)
                        references: 'categories_of_employees',    // The referenced table (categories_of_employees) to establish the foreign key relationship
                        onDelete: 'cascade',    // Action to perform when the referenced record is deleted (cascade deletion)
                        nullable: false          // Specify whether the foreign key column can be nullable (false means it not allows to be NULL)
                    );
    
                // Define a foreign key for 'taux_id', referencing the 'taux_and_salaries' table
                $this->foreignKey(
                        table: $table,          // The table where the foreign key is being added
                        column: 'taux_id',   // The column to which the foreign key is added ('taux_id' in this case)
                        references: 'taux_and_salaries',    // The referenced table (taux_and_salaries) to establish the foreign key relationship
                        onDelete: 'cascade',    // Action to perform when the referenced record is deleted (cascade deletion)
                        nullable: false          // Specify whether the foreign key column can be nullable (true means it allows to be NULL)
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
                
                // Create a composite index for efficient searching on the combination of est_le_taux_de_base, status and can_be_delete
                $this->compositeKeys(table: $table, keys: ['est_le_taux_de_base', 'status', 'can_be_delete']);

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
                message: 'Failed to migrate "category_of_employee_taux" table: ' . $exception->getMessage(),
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
            // Drop the "category_of_employee_taux" table if it exists
            Schema::dropIfExists('category_of_employee_taux');

            // Commit the transaction
            DB::commit();
        } catch (\Throwable $exception) {
            // Rollback the transaction in case of an exception
            DB::rollBack();

            // Handle the exception (e.g., logging, notification, etc.)
            throw new \Core\Utils\Exceptions\DatabaseMigrationException(
                message: 'Failed to drop "category_of_employee_taux" table: ' . $exception->getMessage(),
                previous: $exception
            );
        }
    }
}