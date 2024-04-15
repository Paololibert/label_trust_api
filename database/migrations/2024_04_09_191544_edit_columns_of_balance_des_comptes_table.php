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
 * Class `EditColumnsOfBalanceDesComptesTable`
 *
 * A migration class for creating the "données" table with UUID primary key and timestamps.
 *
 * @package `\Database\Migrations\EditColumnsOfBalanceDesComptesTable`
 */
class EditColumnsOfBalanceDesComptesTable extends Migration
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

            if (Schema::hasTable('balance_des_comptes')) {
                DB::table('balance_des_comptes')->truncate();

                // Drop the column solde_credit from the "balance_des_comptes" table
                if (Schema::hasColumn('balance_des_comptes', 'solde_credit')) {
                    Schema::table('balance_des_comptes', function (Blueprint $table) {
                        // Define a unique string column for the balance_des_comptes intitule
                        $table->dropColumn(['solde_credit']);
                    });
                }

                // Drop the column solde_debit from the "balance_des_comptes" table
                if (Schema::hasColumn('balance_des_comptes', 'solde_debit')) {
                    Schema::table('balance_des_comptes', function (Blueprint $table) {
                        // Define a unique string column for the balance_des_comptes intitule
                        $table->dropColumn(['solde_debit']);
                    });
                }

                if (!Schema::hasColumn('balance_des_comptes', 'solde')) {
                    Schema::table('balance_des_comptes', function (Blueprint $table) {

                        // Define the decimal column 'solde' to store the total debit amount for the account, with 12 digits, 2 of which represent decimal places
                        $table->decimal('solde', 12, 2)
                            ->comment('Solde of an account.');
                    });
                }

                if (!Schema::hasColumn('balance_des_comptes', 'type_solde_compte')) {
                    Schema::table('balance_des_comptes', function (Blueprint $table) {
                        // "type_solde_compte" column with default value "debiteur"
                        $table->enum('type_solde_compte', TypeSoldeCompteEnum::values())->default(TypeSoldeCompteEnum::DEFAULT);
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

            if (Schema::hasTable('balance_des_comptes')) {

                if (!Schema::hasColumn('balance_des_comptes', 'solde')) {
                    Schema::table('balance_des_comptes', function (Blueprint $table) {
                        $table->dropColumn(['solde']);
                    });
                }

                if (!Schema::hasColumn('balance_des_comptes', 'type_solde_compte')) {
                    Schema::table('balance_des_comptes', function (Blueprint $table) {
                        // "type_solde_compte" column with default value "debiteur"
                        $table->dropColumn(['type_solde_compte']);
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
