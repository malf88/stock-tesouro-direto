<?php
/**
 * Created by PhpStorm.
 * User: marcoaurelio
 * Date: 23/09/2018
 * Time: 17:41
 */
include 'vendor/autoload.php';

$foo = new StockTesouroDireto\StockTesouroDireto('LOGIN','SENHA');
//var_dump($foo->getTitulos());
//var_dump($foo->findTitulo(\StockTesouroDireto\StockTesouroDireto::TESOURO_IPCA_2045));
print '<pre>';
//var_dump($foo->findTitulo(\StockTesouroDireto\StockTesouroDireto::TESOURO_IPCA_2045));
var_dump($foo->getStatus());