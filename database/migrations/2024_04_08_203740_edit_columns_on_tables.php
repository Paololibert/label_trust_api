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
 * Class `EditColumnsOnTables`
 *
 * A migration class for creating the "données" table with UUID primary key and timestamps.
 *
 * @package `\Database\Migrations\EditColumnsOnTables`
 */
class EditColumnsOnTables extends Migration
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

            // Drop the column code from the "devises" table
            if (Schema::hasTable('devises')) {
                if (Schema::hasColumn('devises', 'code')) {
                    Schema::table('devises', function (Blueprint $table) {
                        $table->dropColumn(['code']);
                    });
                }
            }

            // Drop the column code from the "categories_de_compte" table
            if (Schema::hasTable('categories_de_compte')) {
                if (Schema::hasColumn('categories_de_compte', 'code')) {
                    Schema::table('categories_de_compte', function (Blueprint $table) {
                        $table->dropColumn(['code']);
                    });
                }
            }

            // Drop the column code from the "classes_de_compte" table
            if (Schema::hasTable('classes_de_compte')) {
                if (Schema::hasColumn('classes_de_compte', 'code')) {
                    Schema::table('classes_de_compte', function (Blueprint $table) {
                        $table->dropColumn(['code']);
                    });
                }
            }

            // Drop the column code from the "comptes" table
            if (Schema::hasTable('comptes')) {
                if (Schema::hasColumn('comptes', 'code')) {
                    Schema::table('comptes', function (Blueprint $table) {
                        $table->dropColumn(['code']);
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

    }
}
