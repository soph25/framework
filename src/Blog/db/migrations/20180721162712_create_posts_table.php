<?php


use Phinx\Migration\AbstractMigration;

class CreatePostsTable extends AbstractMigration
{
    public function change()
    {
        $this->table('posts')
            ->addColumn('name', 'string')
            ->addColumn('slug', 'string')
            ->addColumn('content', 'text')
            ->addColumn('updated_at', 'datetime')
            ->addColumn('created_at', 'datetime')
            ->create();
    }
}
