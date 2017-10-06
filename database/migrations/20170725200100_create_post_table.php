<?php

use Phinx\Migration\AbstractMigration;

class CreatePostTable extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        $table = $this->table('posts');
        $table->addColumn('user_id', 'integer');
        $table->addColumn('category_id', 'integer');
        $table->addColumn('name', 'string');
        $table->addColumn('slug', 'string');
        $table->addColumn('amazon_url', 'string');
        $table->addColumn('price', 'string');
        $table->addColumn('image_set', 'text');
        $table->addColumn('image_set_large', 'text');
        $table->addColumn('small_image_url', 'text');
        $table->addColumn('medium_image_url', 'text');
        $table->addColumn('large_image_url', 'text');
        $table->addColumn('content', 'text');
        $table->addColumn('description', 'text');
        $table->addColumn('details', 'string');
        $table->addColumn('created', 'datetime');

        $table->addForeignKey('user_id', 'users', 'id', ['delete' => 'SET NULL']);
        $table->addForeignKey('category_id', 'categories', 'id', ['delete' => 'SET NULL']);

        $table->create();
    }
}
