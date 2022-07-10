<?php

use RyanChandler\Rql\Rql;

require_once __DIR__ . '/vendor/autoload.php';

$rql = new Rql;

$rql->compile(<<<'rql'
using Order;

select { id, price };
rql);
