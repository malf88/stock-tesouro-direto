# stock-tesouro-direto
Biblioteca para consulta de valor do tesouro direto.

<h3>Como usar</h3>
Instalar pelo composer:
`composer require malf88/stock-tesouro-direto`

Código:
include 'vendor/autoload.php';
//Aqui deverá ser configurada o login e a senha do portal do investidor da BM&F Bovespa.
$foo = new StockTesouroDireto\StockTesouroDireto('CPF','SENHA');

//Buscar por um título especifico
$titulo = $foo->findTitulo(\StockTesouroDireto\StockTesouroDireto::TESOURO_IPCA_2045);

//Listar todos os títulos
$lista = $foo->getTitulos();
