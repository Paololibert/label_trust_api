<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Core\Utils\Traits\Database\Migrations\CanDeleteTrait;
use Core\Utils\Traits\Database\Migrations\HasCompositeKey;
use Core\Utils\Traits\Database\Migrations\HasForeignKey;
use Core\Utils\Traits\Database\Migrations\HasTimestampsAndSoftDeletes;
use Core\Utils\Traits\Database\Migrations\HasUuidPrimaryKey;

class AddNewColumnsToCategorieArticlesTable extends Migration
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

            if (Schema::hasTable('categorie_articles')) {
                Schema::table('categorie_articles', function (Blueprint $table) {
                    if (!Schema::hasColumn('categorie_articles', 'categorie_article_id')) {
                        // Define a foreign key for 'categorie_article_id', referencing the 'categorie_articles' table
                        $this->foreignKey(
                            table: $table,                // The table where the foreign key is being added
                            column: 'categorie_article_id',        // The column to which the foreign key is added ('category_id' in this case)
                            references: 'categorie_articles',    // The referenced table (categorie_articles) to establish the foreign key relationship
                            onDelete: 'cascade',         // Action to perform when the referenced record is deleted (cascade deletion)
                            nullable: true              // Specify whether the foreign key column can be nullable (false means it is not allows to be NULL)
                        );
                    }
                });
            }

            // Commit the transaction
            DB::commit();
        } catch (\Throwable $exception) {
            // Rollback the transaction in case of an exception
            DB::rollBack();

            // Handle the exception (e.g., logging, notification, etc.)
            throw new \Core\Utils\Exceptions\DatabaseMigrationException(
                message: 'Failed to migrate "articles" table: ' . $exception->getMessage(),
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

            if (Schema::hasTable('categorie_articles')) {
                Schema::table('categorie_articles', function (Blueprint $table) {
                    if (Schema::hasColumn('categorie_articles', 'categorie_article_id')) {
                        // Drop foreign key constraint for 'categorie_article_id'
                        $table->dropForeign(['categorie_article_id']);
                        // Drop the 'categorie_article_id' column if it exists
                        $table->dropColumn('categorie_article_id');
                    }
                });
            }

            // Commit the transaction
            DB::commit();
        } catch (\Throwable $exception) {
            // Rollback the transaction in case of an exception
            DB::rollBack();

            // Handle the exception (e.g., logging, notification, etc.)
            throw new \Core\Utils\Exceptions\DatabaseMigrationException(
                message: 'Failed to drop "price" column: ' . $exception->getMessage(),
                previous: $exception
            );
        }
    }
}
