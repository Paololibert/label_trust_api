<?php

declare(strict_types=1);

use Core\Utils\Enums\TypeEcritureCompteEnum;
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
 * Class ***`CreateLignesEcritureComptableTable`***
 *
 * A migration class for creating the "lignes_ecriture_comptable" table with UUID primary key and timestamps.
 *
 * @package ***`\Database\Migrations\CreateLignesEcritureComptableTable`***
 */
class CreateLignesEcritureComptableTable extends Migration
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

            Schema::create('lignes_ecriture_comptable', function (Blueprint $table) {
                // Define a UUID primary key for the 'lignes_ecriture_comptable' table
                $this->uuidPrimaryKey($table);
                                
                // Define a 
                $table->string('libelle')->nullable()
                    ->comment('Libelle of the ecriture comptable');

                // "type_ecriture_compte" column with default value "debit"
                $table->enum('type_ecriture_compte', TypeEcritureCompteEnum::values())->default(TypeEcritureCompteEnum::DEFAULT);

                // Define the decimal column 'montant' for storing the monetary amount with 12 digits, 2 of which are decimal places
                $table->decimal('montant', 12, 2)->comment('');

                $table->uuidMorphs('accountable');

                $table->uuidMorphs('ligneable');

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
                
                // Create a composite index for efficient searching on the combination of montant, ligneable_type, date_ecriture, status and can_be_delete
                $this->compositeKeys(table: $table, keys: ['montant', 'ligneable_id', 'ligneable_type', 'status', 'can_be_delete']);

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
                message: 'Failed to migrate "lignes_ecriture_comptable" table: ' . $exception->getMessage(),
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
            // Drop the "lignes_ecriture_comptable" table if it exists
            Schema::dropIfExists('lignes_ecriture_comptable');

            // Commit the transaction
            DB::commit();
        } catch (\Throwable $exception) {
            // Rollback the transaction in case of an exception
            DB::rollBack();

            // Handle the exception (e.g., logging, notification, etc.)
            throw new \Core\Utils\Exceptions\DatabaseMigrationException(
                message: 'Failed to drop "lignes_ecriture_comptable" table: ' . $exception->getMessage(),
                previous: $exception
            );
        }
    }
}