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
 * Class ***`CreateOauthRefreshTokensTable`***
 *
 * A migration class for creating the "oauth_refresh_tokens" table with UUID primary key and timestamps.
 *
 * @package ***`\Database\Migrations\CreateOauthRefreshTokensTable`***
 */
class CreateOauthRefreshTokensTable extends Migration
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
        
            Schema::create('oauth_refresh_tokens', function (Blueprint $table) {
                // Define a UUID primary key for the 'oauth_refresh_tokens' table
                $this->uuidPrimaryKey($table);

                // Define a foreign key for 'access_token_id', referencing the 'oauth_access_tokens' table
                $this->foreignKey(
                    table: $table,          // The table where the foreign key is being added
                    column: 'access_token_id',   // The column to which the foreign key is added ('access_token_id' in this case)
                    references: 'oauth_access_tokens',    // The referenced table (oauth_access_tokens) to establish the foreign key relationship
                    onDelete: 'cascade',    // Action to perform when the referenced record is deleted (cascade deletion)
                    nullable: false          // Specify whether the foreign key column can be nullable (false means it not allows to be NULL)
                );

                $table->boolean('revoked');
                $table->dateTime('expires_at')->nullable();

                // Add a boolean column 'status' to the table
                $table->boolean('status')
                    ->default(TRUE) // Set the default value to TRUE
                    ->comment('Record status: 
                            - TRUE: Active record or soft delete record
                            - FALSE: permanently Deleted and can be archived in another datastore'
                        ); // Describe the meaning of the 'status' column
                    
                // Add a boolean column 'can_be_delete' with default value false
                $this->addCanDeleteColumn(table: $table, column_name: 'can_be_delete', can_be_delete: true);


                // Create a composite index for efficient searching on the combination of access_token_id, status and can_be_delete
                $this->compositeKeys(table: $table, keys: ['access_token_id', 'status', 'can_be_delete']);

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
                message: 'Failed to migrate "oauth_refresh_tokens" table: ' . $exception->getMessage(),
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
            // Drop the "oauth_refresh_tokens" table if it exists
            Schema::dropIfExists('oauth_refresh_tokens');

            // Commit the transaction
            DB::commit();
        } catch (\Throwable $exception) {
            // Rollback the transaction in case of an exception
            DB::rollBack();

            // Handle the exception (e.g., logging, notification, etc.)
            throw new \Core\Utils\Exceptions\DatabaseMigrationException(
                message: 'Failed to drop "oauth_refresh_tokens" table: ' . $exception->getMessage(),
                previous: $exception
            );
        }
    }
}