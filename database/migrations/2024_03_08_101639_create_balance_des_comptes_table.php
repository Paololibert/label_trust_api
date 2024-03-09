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
 * Class ***`CreateBalanceDesComptesTable`***
 *
 * A migration class for creating the "balance_des_comptes" table with UUID primary key and timestamps.
 *
 * @package ***`\Database\Migrations\CreateBalanceDesComptesTable`***
 */
class CreateBalanceDesComptesTable extends Migration
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

            Schema::create('balance_des_comptes', function (Blueprint $table) {
                // Define a UUID primary key for the 'balance_des_comptes' table
                $this->uuidPrimaryKey($table);

                // Define the decimal column 'solde_debit' to store the total debit amount for the account, with 12 digits, 2 of which represent decimal places
                $table->decimal('solde_debit', 12, 2)
                    ->comment('Total debit balance for the account.');

                // Define the decimal column 'solde_credit' to store the total credit amount for the account, with 12 digits, 2 of which represent decimal places
                $table->decimal('solde_credit', 12, 2)
                    ->comment('Total credit balance for the account.');
                
                // The reporting date of the account balance
                $table->date('date_report')
                    ->comment('Indicate when the balance date is report');

                // Account balance closing date for an exercice comptable
                $table->date('date_cloture')->nullable()
                    ->comment('Indicate when the balance date is end up');

                $table->uuidMorphs('balanceable');
                
                // Define a foreign key for 'exercice_comptable_id', referencing the 'exercices_comptable' table
                $this->foreignKey(
                    table: $table,         // The table where the foreign key is being added
                    column: 'exercice_comptable_id',   // The column to which the foreign key is added ('exercice_comptable_id' in this case)
                    references: 'exercices_comptable', // The referenced table (exercices_comptable) to establish the foreign key relationship
                    onDelete: 'cascade',   // Action to perform when the referenced record is deleted (cascade deletion)
                    nullable: false        // Specify whether the foreign key column can be nullable (false means it not allows to be NULL)
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
                
                // Create a composite index for efficient searching on the combination of solde_debit, solde_credit, status and can_be_delete
                $this->compositeKeys(table: $table, keys: ['solde_debit', 'solde_credit', 'date_report', 'date_cloture', 'status', 'can_be_delete']);

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
                message: 'Failed to migrate "balance_des_comptes" table: ' . $exception->getMessage(),
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
            // Drop the "balance_des_comptes" table if it exists
            Schema::dropIfExists('balance_des_comptes');

            // Commit the transaction
            DB::commit();
        } catch (\Throwable $exception) {
            // Rollback the transaction in case of an exception
            DB::rollBack();

            // Handle the exception (e.g., logging, notification, etc.)
            throw new \Core\Utils\Exceptions\DatabaseMigrationException(
                message: 'Failed to drop "balance_des_comptes" table: ' . $exception->getMessage(),
                previous: $exception
            );
        }
    }
}