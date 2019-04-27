# stock-tesouro-direto
Biblioteca para consulta de valor do tesouro direto.
##Instalation
`composer require malf88/stock-tesouro-direto`

##Usage
```
$foo = new StockTesouroDireto\StockTesouroDireto('CPF','SENHA');
$foo->findTitulo(\StockTesouroDireto\StockTesouroDireto::TESOURO_IPCA_2045);

$foo->getStatus();
$foo->getTitulos();
```
