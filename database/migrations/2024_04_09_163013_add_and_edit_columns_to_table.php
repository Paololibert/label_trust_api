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
 * Class `AddAndEditColumnsToTable`
 *
 * A migration class for creating the "données" table with UUID primary key and timestamps.
 *
 * @package `\Database\Migrations\AddAndEditColumnsToTable`
 */
class AddAndEditColumnsToTable extends Migration
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

            if (Schema::hasTable('classes_de_compte')) {
                DB::table('classes_de_compte')->truncate();

                if (!Schema::hasColumn('classes_de_compte', 'intitule')) {
                    Schema::table('classes_de_compte', function (Blueprint $table) {
                        // Define a unique string column for the classes_de_compte intitule
                        $table->string('intitule')->unique()
                            ->comment('The unique intitule of the classe de compte');
                    });
                }

                if (!Schema::hasColumn('classes_de_compte', 'class_number')) {
                    Schema::table('classes_de_compte', function (Blueprint $table) {
                        // Define a unique integer column for the classes_de_compte class_number
                        $table->integer('class_number')->unique()
                            ->comment('The unique class_number of the classe de compte');
                    });
                }

                // Drop the column name from the "classes_de_compte" table
                if (Schema::hasColumn('classes_de_compte', 'name')) {
                    Schema::table('classes_de_compte', function (Blueprint $table) {
                        // Define a unique string column for the classes_de_compte intitule
                        $table->dropColumn(['name']);
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

            if (Schema::hasTable('classes_de_compte')) {
                if (Schema::hasColumn('classes_de_compte', 'intitule')) {
                    Schema::table('classes_de_compte', function (Blueprint $table) {
                        $table->dropColumn(['intitule']);
                    });
                }

                if (Schema::hasColumn('classes_de_compte', 'class_number')) {
                    Schema::table('classes_de_compte', function (Blueprint $table) {
                        $table->dropColumn(['class_number']);
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
