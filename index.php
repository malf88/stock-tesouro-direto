<?php
/**
 * Created by PhpStorm.
 * User: marcoaurelio
 * Date: 23/09/2018
 * Time: 17:41
 */
include 'vendor/autoload.php';

$foo = new StockTesouroDireto\StockTesouroDireto();
var_dump($foo->findTicker(\StockTesouroDireto\StockTesouroDireto::TESOURO_IPCA_2045));