<?php

declare(strict_types=1);

use Core\Utils\Enums\Users\MaritalStatusEnum;
use Core\Utils\Enums\Users\SexEnum;
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
 * Class ***`CreatePeopleTable`***
 *
 * A migration class for creating the "people" table with UUID primary key and timestamps.
 *
 * @package ***`\Database\Migrations\CreatePeopleTable`***
 */
class CreatePeopleTable extends Migration
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

            Schema::create('people', function (Blueprint $table) {
                // Define a UUID primary key for the 'people' table
                $this->uuidPrimaryKey($table);

                // Define a unique string column for the role name
                $table->string('last_name');

                // Define a unique string column for the role name
                $table->string('first_name');

                // Middle name as JSONB, defaulting to an empty JSON object
                //$table->jsonb('middle_name')->default('{}');
                $table->jsonb('middle_name')->default(json_encode([]));


                // "sex" column with default value "male"
                $table->enum('sex', SexEnum::values())->default(SexEnum::DEFAULT);

                // "marital_status" column with a default value "single"
                $table->enum('marital_status', MaritalStatusEnum::values())->default(MaritalStatusEnum::DEFAULT);

                // Birth date column, nullable
                $table->date('birth_date')->nullable();

                // NIP column, nullable and unique
                $table->bigInteger('nip')->unique()->nullable();

                // IFU column, nullable and unique
                $table->bigInteger('ifu')->unique()->nullable();

                // Nationality column, nullable
                $table->string('nationality')->nullable();

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
                    nullable: true          // Specify whether the foreign key column can be nullable (false means it not allows NULL)
                );

                /**
                 * Add composite indexes for efficient searching on columns :
                 * "last_name", "first_name", 'middle_name',
                 * "marital_status", "sex", created_by, status and can_be_delete
                 */
                $this->compositeKeys(table: $table, keys: [
                        'last_name',
                        'first_name',
                        'middle_name',
                        'sex',
                        "marital_status",
                        'created_by',
                        'status', 'can_be_delete'
                    ]
                );

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
                message: 'Failed to migrate "people" table: ' . $exception->getMessage(),
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
            // Drop the "people" table if it exists
            Schema::dropIfExists('people');

            // Commit the transaction
            DB::commit();
        } catch (\Throwable $exception) {
            // Rollback the transaction in case of an exception
            DB::rollBack();

            // Handle the exception (e.g., logging, notification, etc.)
            throw new \Core\Utils\Exceptions\DatabaseMigrationException(
                message: 'Failed to drop "people" table: ' . $exception->getMessage(),
                previous: $exception
            );
        }
    }
}
