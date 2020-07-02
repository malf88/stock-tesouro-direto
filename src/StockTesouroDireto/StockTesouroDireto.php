<?php
/**
 * Created by PhpStorm.
 * User: marcoaurelio
 * Date: 23/09/2018
 * Time: 17:40
 */

namespace StockTesouroDireto;


use Curl\Curl;
use GuzzleHttp\Client;

use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\Cookie\FileCookieJar;
use GuzzleHttp\Cookie\SessionCookieJar;
use GuzzleHttp\Psr7\Uri;

class StockTesouroDireto
{
    //Constantes para Tesouro IPCA+
    const TESOURO_IPCA_2019 = 'Tesouro IPCA+ 2019';
    const TESOURO_IPCA_2024 = 'Tesouro IPCA+ 2024';
    const TESOURO_IPCA_2035 = 'Tesouro IPCA+ 2035';
    const TESOURO_IPCA_2045 = 'Tesouro IPCA+ 2045';
    const TESOURO_IPCA_2020_SEMESTRAL = 'Tesouro IPCA+ com Juros Semestrais 2020';
    const TESOURO_IPCA_2024_SEMESTRAL = 'Tesouro IPCA+ com Juros Semestrais 2024';
    const TESOURO_IPCA_2026_SEMESTRAL = 'Tesouro IPCA+ com Juros Semestrais 2026';
    const TESOURO_IPCA_2035_SEMESTRAL = 'Tesouro IPCA+ com Juros Semestrais 2035';
    const TESOURO_IPCA_2045_SEMESTRAL = 'Tesouro IPCA+ com Juros Semestrais 2045';
    const TESOURO_IPCA_2050_SEMESTRAL = 'Tesouro IPCA+ com Juros Semestrais 2050';

    //Constantes para Tesouro prefixado
    const TESOURO_PREFIXADO_2020 = 'Tesouro Prefixado 2020';
    const TESOURO_PREFIXADO_2021 = 'Tesouro Prefixado 2021';

    const TESOURO_PREFIXADO_2022 = 'Tesouro Prefixado 2022';
    const TESOURO_PREFIXADO_2023 = 'Tesouro Prefixado 2023';
    const TESOURO_PREFIXADO_2025 = 'Tesouro Prefixado 2025';
    const TESOURO_PREFIXADO_2021_SEMESTRAL = 'Tesouro Prefixado com Juros Semestrais 2021';
    const TESOURO_PREFIXADO_2023_SEMESTRAL = 'Tesouro Prefixado com Juros Semestrais 2023';
    const TESOURO_PREFIXADO_2025_SEMESTRAL = 'Tesouro Prefixado com Juros Semestrais 2025';
    const TESOURO_PREFIXADO_2027_SEMESTRAL = 'Tesouro Prefixado com Juros Semestrais 2027';
    const TESOURO_PREFIXADO_2029_SEMESTRAL = 'Tesouro Prefixado com Juros Semestrais 2029';

    //Constantes para Tesouro SELIC
    const TESOURO_SELIC_2021 = 'Tesouro Selic 2021';
    const TESOURO_SELIC_2023 = 'Tesouro Selic 2023';
    const TESOURO_SELIC_2025 = 'Tesouro Selic 2025';

    //Constantes para Tesouro IGPM+
    const TESOURO_IGPM_2021_SEMESTRAL = 'Tesouro IGPM+ com Juros Semestrais 2021';
    const TESOURO_IGPM_2031_SEMESTRAL = 'Tesouro IGPM+ com Juros Semestrais 2031';


    const COLUNA_TICKER = 0;
    const COLUNA_VENCIMENTO = 2;
    const COLUNA_TAXA = 4;
    const COLUNA_VALOR_MINIMO = 6;
    const COLUNA_VALOR_VENDA = 6;
    const COLUNA_VALOR_COMPRA = 8;
    const URL = 'https://www.tesourodireto.com.br//json/br/com/b3/tesourodireto/service/api/treasurybondsinfo.json';
    /**
     * 0 - Ticker
     * 2 - Vencimento
     * 4 - Taxa
     * 6 - Valor minimo
     * 8 - Valor
     */


    /**
     * @return \DOMNodeList|false
     * @throws \GuzzleHttp\Exception\GuzzleException
     */

    public function getTitulos(){
        $client = new Client([
            'verify' => false
        ]);
        $r = $client->request('GET', self::URL);
        


        $jsonTitulos = \GuzzleHttp\json_decode($r->getBody()->getContents());

        $arrayTitulos = $jsonTitulos->response->TrsrBdTradgList;




        $tickers = [];

        foreach($arrayTitulos as $tituloTD){
            $titulo = new Titulo();
            $titulo->setTitulo($tituloTD->TrsrBd->nm);
            $titulo->setVencimento(new \DateTime($tituloTD->TrsrBd->mtrtyDt));
            $titulo->setPrecoCompra($tituloTD->TrsrBd->untrInvstmtVal);
            $titulo->setPrecoVenda($tituloTD->TrsrBd->untrRedVal);
            $titulo->setRentabilidade($tituloTD->TrsrBd->anulInvstmtRate);
            $titulo->setRentabilidadeResgate($tituloTD->TrsrBd->anulRedRate);

            $tickers[$tituloTD->TrsrBd->nm] = $titulo;

        }

        return $tickers;

    }

    /**
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @deprecated
     */

    public function getStatus(){
        //$result = $this->getJson();
        
        //return ($result->length > 1);
        return true;
    }

    /**
     * @param $elements array
     * @return array|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @deprecated
     */
    private function populate($elements){


    }



    /**
     * @param $date
     * @return \DateTime
     * @throws \Exception
     */
    private function revertDate($date){

        $data = explode('/',trim($date));

        $newDate = new \DateTime();
        $newDate->setDate($data[2],$data[1],$data[0]);
        $newDate->setTime(00,00,00);
        return $newDate;
    }

    /**
     * @param $ticker
     * @return Titulo
     */
    public function findTitulo($tickerValue){

        $listTicker = $this->getTitulos();
        if(isset($listTicker[$tickerValue])){
            return $listTicker[$tickerValue];
        }else{
            throw new \Exception('Ticker não encontrado');
        }

    }


    public function getFloatValue($valor){

        $value = str_replace(array('R$','.'),array('',''),$valor);
        return (float)str_replace(array(','),array('.'),$value);
    }

}