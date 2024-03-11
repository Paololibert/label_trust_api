<?php

declare(strict_types=1);

use Core\Utils\Enums\Users\TypeOfAccountEnum;
use Core\Utils\Enums\Users\UserAccountStatus;
use Core\Utils\Traits\Database\Migrations\CanDeleteTrait;
use Core\Utils\Traits\Database\Migrations\HasCompositeKey;
use Core\Utils\Traits\Database\Migrations\HasForeignKey;
use Core\Utils\Traits\Database\Migrations\HasMatricule;
use Core\Utils\Traits\Database\Migrations\HasTimestampsAndSoftDeletes;
use Core\Utils\Traits\Database\Migrations\HasUuidPrimaryKey;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Class ***`CreateUsersTable`***
 *
 * A migration class for creating the "users" table with UUID primary key and timestamps.
 *
 * @package ***`\Database\Migrations\CreateUsersTable`***
 */
class CreateUsersTable extends Migration
{
    use CanDeleteTrait, HasCompositeKey, HasForeignKey, HasMatricule, HasTimestampsAndSoftDeletes, HasUuidPrimaryKey;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Begin the database transaction
        DB::beginTransaction();

        try {

            Schema::create('users', function (Blueprint $table) {
                // Define a UUID primary key for the 'users' table
                $this->uuidPrimaryKey($table);

                // "type_of_account" column with default value "personal"
                $table->enum('type_of_account', TypeOfAccountEnum::values())->default(TypeOfAccountEnum::DEFAULT);

                // Unique username for the user
                $table->string('username')->nullable()->unique()->comment('The unique username of the user');

                // "login_channel" column with default value "email"
                $table->enum('login_channel', ['email', 'phone_number'])->default('email');

                // Phone number stored as JSONB with a uniqueness constraint
                $table->jsonb('phone_number')->unique()->comment('The phone number of the user');

                // Nullable address of the user
                $table->jsonb('address')->nullable()->comment('Address of the user');

                // Nullable and unique email address of the user
                $table->string('email')->unique()->nullable()->comment('Email address of the user');

                /**
                 * Polymorphic relationship columns:
                 * - 'userable_type' (string): Type of the related model
                 * - 'userable_id' (uuid): ID of the related model
                 */
                $table->uuidMorphs('userable');
                //->comment('Polymorphic relationship with other models');

                /**
                 * Polymorphic relationship columns:
                 * - 'profilable' (string): Type of the related model
                 * - 'profilable_id' (uuid): ID of the related model
                 */
                $table->uuidMorphs('profilable');

                // Nullable timestamp for email verification
                $table->timestamp('email_verified_at')->nullable()->comment('Timestamp of email verification');

                /**
                 * Polymorphic relationship columns:
                 * - 'profilable' (string): Type of the related model
                 * - 'profilable_id' (uuid): ID of the related model
                 */
                $table->nullableUuidMorphs('profilable');

                // Nullable timestamp for email verification
                $table->timestamp('email_verified_at')->nullable()->comment('Timestamp of email verification');

                // Boolean flag indicating email verification status
                $table->boolean('email_verified')->default(false)->comment('Email verification status');

                // Boolean flag indicating account activation status
                $table->boolean('account_activated')->default(false)->comment('Account activation status');

                // Nullable timestamp for account activation
                $table->timestamp('account_activated_at')->nullable()->comment('Timestamp of account activation');

                // Boolean flag indicating account verification status
                $table->boolean('account_verified')->default(false)->comment('Account verification status');

                // Nullable timestamp for account verification
                $table->timestamp('account_verified_at')->nullable()->comment('Timestamp of account verification');

                // Nullable token for email verification
                $table->string('email_verification_token')->nullable()->comment('Token for email verification');

                // Boolean flag indicating first login
                $table->boolean('first_login')->default(true)->comment('First connexion');

                // Add a boolean column 'status' to the table
                $table->boolean('status')
                    ->default(TRUE) // Set the default value to TRUE
                    ->comment(
                        'Record status: 
                            - TRUE: Active record or soft delete record
                            - FALSE: permanently Deleted and can be archived in another datastore'
                    ); // Describe the meaning of the 'status' column

                // Add a boolean column 'can_be_delete' with default value false
                $this->addCanDeleteColumn(table: $table, column_name: 'can_be_delete', can_be_delete: true);
                /**
                 * Account status using ENUM:
                 * - Default value: 'pending_activation'
                 * - Possible values: [ 'active', 'pending_password_reset', 'pending_activation', ... ]
                 */
                $table->enum(
                    'account_status',
                    UserAccountStatus::values()
                )->default(UserAccountStatus::DEFAULT);

                // Create a composite index for efficient searching on the combination of status and can_be_delete
                $this->compositeKeys(table: $table, keys: [/* 'matricule', */'username', 'type_of_account', 'phone_number', 'email', 'status', 'can_be_delete']);

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
                message: 'Failed to migrate "users" table: ' . $exception->getMessage(),
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

            // Drop the "users" table if it exists
            Schema::dropIfExists('users');

            // Commit the transaction
            DB::commit();
        } catch (\Throwable $exception) {
            // Rollback the transaction in case of an exception
            DB::rollBack();

            // Handle the exception (e.g., logging, notification, etc.)
            throw new \Core\Utils\Exceptions\DatabaseMigrationException(
                message: 'Failed to drop "users" table: ' . $exception->getMessage(),
                previous: $exception
            );
        }
    }
}
