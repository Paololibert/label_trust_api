<?php

declare(strict_types=1);

use Core\Utils\Enums\TypeSoldeCompteEnum;
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
 * Class `EditColumnsFromTwoTable`
 *
 * A migration class for creating the "données" table with UUID primary key and timestamps.
 *
 * @package `\Database\Migrations\EditColumnsFromTwoTable`
 */
class EditColumnsFromTwoTable extends Migration
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

            if (Schema::hasTable('plan_comptable_comptes')) {
                //DB::table('plan_comptable_comptes')->truncate();

                if (Schema::hasColumn('plan_comptable_comptes', 'account_number')) {
                    Schema::table('plan_comptable_comptes', function (Blueprint $table) {
                        // Define a unique string column for the account number
                        $table->string('account_number')->unique(false)->change()
                            ->comment('The unique account number');
                    });
                }
            }

            if (Schema::hasTable('plan_comptable_compte_sous_comptes')) {
                //DB::table('plan_comptable_compte_sous_comptes')->truncate();

                if (Schema::hasColumn('plan_comptable_compte_sous_comptes', 'account_number')) {
                    Schema::table('plan_comptable_compte_sous_comptes', function (Blueprint $table) {
                        // Define a unique string column for the account number
                        $table->string('account_number')->unique(false)->change()
                            ->comment('The unique account number');
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

            if (Schema::hasTable('plan_comptable_comptes')) {
                //DB::table('plan_comptable_comptes')->truncate();

                if (Schema::hasColumn('plan_comptable_comptes', 'account_number')) {
                    Schema::table('plan_comptable_comptes', function (Blueprint $table) {
                        // Revert the column type change
                        $table->string('account_number')->unique()->change()
                            ->comment('The unique account number');
                    });
                }
            }

            if (Schema::hasTable('plan_comptable_compte_sous_comptes')) {
                //DB::table('plan_comptable_compte_sous_comptes')->truncate();

                if (Schema::hasColumn('plan_comptable_compte_sous_comptes', 'account_number')) {
                    Schema::table('plan_comptable_compte_sous_comptes', function (Blueprint $table) {
                        // Revert the column type change
                        $table->string('account_number')->unique()->change()
                            ->comment('The unique account number');
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
                message: 'Failed to drop "données" table: ' . $exception->getMessage(),
                previous: $exception
            );
        }
    }
}
