<?php

namespace App\Event;

use Doctrine\ORM\Tools\Event\GenerateSchemaEventArgs;

class DoctrineIgnoreTableEventListener
{
    private $ignoredTables = [
        'vw_finding',
    ];

    public function postGenerateSchema(GenerateSchemaEventArgs $args)
    {
        $schema = $args->getSchema();

        $tableNames = $schema->getTableNames();
        foreach ($tableNames as $tableName) {

            $tableName = explode('.', $tableName)[1];
            if (in_array($tableName, $this->ignoredTables)) {
                // remove table from schema
                $schema->dropTable($tableName);
            }

        }
    }

}