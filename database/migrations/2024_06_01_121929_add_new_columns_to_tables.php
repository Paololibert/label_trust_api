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
 * Class `AddNewColumnsToTables`
 *
 * A migration class for creating the "credentials" table with UUID primary key and timestamps.
 *
 * @package `\Database\Migrations\AddNewColumnsToTables`
 */
class AddNewColumnsToTables extends Migration
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

            if (Schema::hasTable('roles')) {
                // Check if the "created_by" column does not exist in the "roles" table
                if (!Schema::hasColumn('roles', 'created_by')) {
                    // Modify the "roles" table
                    Schema::table('roles', function (Blueprint $table) {

                        // Define a foreign key for 'created_by', referencing the 'users' table
                        $this->foreignKey(
                            table: $table,          // The table where the foreign key is being added
                            column: 'created_by',   // The column to which the foreign key is added ('created_by' in this case)
                            references: 'users',    // The referenced table (users) to establish the foreign key relationship
                            onDelete: 'cascade',    // Action to perform when the referenced record is deleted (cascade deletion)
                            nullable: true          // Specify whether the foreign key column can be nullable (true means it allows NULL)
                        );

                        // Create an index for efficient searching on the combination of created_by
                        $this->compositeKeys(table: $table, keys: ['created_by']);
                    });
                }
            }

            if (Schema::hasTable('role_has_permissions')) {
                // Check if the "attached_by" column does not exist in the "role_has_permissions" table
                if (!Schema::hasColumn('role_has_permissions', 'attached_by')) {
                    // Modify the "role_has_permissions" table
                    Schema::table('role_has_permissions', function (Blueprint $table) {

                        // Define a foreign key for 'attached_by', referencing the 'users' table
                        $this->foreignKey(
                            table: $table,          // The table where the foreign key is being added
                            column: 'attached_by',  // The column to which the foreign key is added ('attached_by' in this case)
                            references: 'users',    // The referenced table (users) to establish the foreign key relationship
                            onDelete: 'cascade',    // Action to perform when the referenced record is deleted (cascade deletion)
                            nullable: false         // Specify whether the foreign key column can be nullable (false means it not allows to be NULL)
                        );

                        // Create an index for efficient searching on the combination of attached_by
                        $this->compositeKeys(table: $table, keys: ['attached_by']);
                    });
                }
            }

            if (Schema::hasTable('users')) {
                // Check if the "created_by" column does not exist in the "users" table
                if (!Schema::hasColumn('users', 'created_by')) {
                    // Modify the "users" table
                    Schema::table('users', function (Blueprint $table) {

                        // Define a foreign key for 'created_by', referencing the 'users' table
                        $this->foreignKey(
                            table: $table,          // The table where the foreign key is being added
                            column: 'created_by',  // The column to which the foreign key is added ('created_by' in this case)
                            references: 'users',    // The referenced table (users) to establish the foreign key relationship
                            onDelete: 'cascade',    // Action to perform when the referenced record is deleted (cascade deletion)
                            nullable: false         // Specify whether the foreign key column can be nullable (true means it allows NULL)
                        );

                        // Create an index for efficient searching on the combination of created_by
                        $this->compositeKeys(table: $table, keys: ['created_by']);
                    });
                }
            }

            if (Schema::hasTable('categories_of_employees')) {
                // Check if the "category_id" column does not exist in the "categories_of_employees" table
                if (!Schema::hasColumn('categories_of_employees', 'category_id')) {
                    // Modify the "categories_of_employees" table
                    Schema::table('categories_of_employees', function (Blueprint $table) {
                        // Define a foreign key for 'category_id', referencing the 'categories_of_employees' table
                        $this->foreignKey(
                            table: $table,                // The table where the foreign key is being added
                            column: 'category_id',        // The column to which the foreign key is added ('category_id' in this case)
                            references: 'categories_of_employees',    // The referenced table (categories_of_employees) to establish the foreign key relationship
                            onDelete: 'cascade',         // Action to perform when the referenced record is deleted (cascade deletion)
                            nullable: true              // Specify whether the foreign key column can be nullable (false means it is not allows to be NULL)
                        );
                    });
                }
            }

            if (Schema::hasTable('contracts')) {
                // Check if the "contract_id" column does not exist in the "contracts" table
                if (!Schema::hasColumn('contracts', 'contract_id')) {
                    // Modify the "contracts" table
                    Schema::table('contracts', function (Blueprint $table) {
                        // Define a foreign key for 'contract_id', referencing the 'contracts' table
                        $this->foreignKey(
                            table: $table,                // The table where the foreign key is being added
                            column: 'contract_id',        // The column to which the foreign key is added ('category_id' in this case)
                            references: 'contracts',    // The referenced table (contracts) to establish the foreign key relationship
                            onDelete: 'cascade',         // Action to perform when the referenced record is deleted (cascade deletion)
                            nullable: true              // Specify whether the foreign key column can be nullable (false means it is not allows to be NULL)
                        );
                    });
                }
            }

            // Commit the transaction
            DB::commit();
        } catch (\Throwable $exception) {
            // Rollback the transaction in case of an exception
            DB::rollBack();

            // Handle the exception (e.g., logging, notification, etc.)
            throw new \Core\Utils\Exceptions\DatabaseMigrationException(
                message: 'Failed to migrate table: ' . $exception->getMessage(),
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

            // Commit the transaction
            DB::commit();
        } catch (\Throwable $exception) {
            // Rollback the transaction in case of an exception
            DB::rollBack();

            // Handle the exception (e.g., logging, notification, etc.)
            throw new \Core\Utils\Exceptions\DatabaseMigrationException(
                message: 'Failed to drop "credentials" table: ' . $exception->getMessage(),
                previous: $exception
            );
        }
    }
}