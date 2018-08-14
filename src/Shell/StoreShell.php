<?php

namespace App\Shell;

use Cake\Console\Shell;
use Cake\ORM\TableRegistry;

define('TABLE_PREFIX', 'pqd_');
define('ENABLED', 1);
define('CLOSED', 3);

class StoreShell extends Shell
{
    //1 0 * * * /usr/bin/php bin/cake.php store;
    function main(...$args)
    {
        $this->update_status();
    }

    function update_status()
    {
        $date     = date('Y-m-d');
        $storeTbl = TableRegistry::get('Stores');
        $query    = $storeTbl->find('all', [
            'conditions' => [
                'closed_to' => $date,
                'status'    => CLOSED,
            ],
        ]);
        if ($query->count() > 0) {
            foreach ($query as $item) {
                $storeTbl->updateAll(['status' => ENABLED],
                    ['id' => $item->id]);
            }
        }
    }
}