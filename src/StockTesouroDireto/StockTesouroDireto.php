<?php
/**
 * Created by PhpStorm.
 * User: marcoaurelio
 * Date: 23/09/2018
 * Time: 17:40
 */

namespace StockTesouroDireto;


use Curl\Curl;

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
    const TESOURO_PREFIXADO_2019 = 'Tesouro Prefixado 2019';
    const TESOURO_PREFIXADO_2020 = 'Tesouro Prefixado 2020';
    const TESOURO_PREFIXADO_2021 = 'Tesouro Prefixado 2021';
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

    //Constantes para Tesouro IGPM+
    const TESOURO_IGPM_2021_SEMESTRAL = 'Tesouro IGPM+ com Juros Semestrais 2021';
    const TESOURO_IGPM_2031_SEMESTRAL = 'Tesouro IGPM+ com Juros Semestrais 2031';

    public function getJsonResgate(){
        $cURL = new Curl();
        $cURL->get('http://www.tesouro.fazenda.gov.br/tesouro-direto-precos-e-taxas-dos-titulos');

        $dom = new \DOMDocument();
        $tags = strip_tags($cURL->response,"<table><th><tr><td>");
        $dom->loadHTML($tags);


        $xpath = new \DOMXPath($dom);
        $table = $xpath->query('//*[@class=\'camposTesouroDireto\']');

        return $table;

    }

    public function getJsonCompra(){
        $cURL = new Curl();
        $cURL->get('http://www.tesouro.fazenda.gov.br/tesouro-direto-precos-e-taxas-dos-titulos');

        $dom = new \DOMDocument();
        $tags = strip_tags($cURL->response,"<table><th><tr><td>");
        $dom->loadHTML($tags);
        //echo $tags;
        $xpath = new \DOMXPath($dom);
        $table = $xpath->query('//*[@class=\'tabelaPrecoseTaxas\']//*[@class=\'camposTesouroDireto\']');
        var_dump($table);
        return $table;

    }

    private function populate($elements){
        $tickers = array();
        foreach ($elements as $item) {

            $td = $item->getElementsByTagName('td');
            $tickers[] = new Ticker(
                                    $td[0]->nodeValue,
                                    $this->revertDate($td[1]->nodeValue),
                                    (float)str_replace(array(',','R$ '),array('.',''),$td[2]->nodeValue),
                                    (float)str_replace(array('.','R$',','),array('','','.'),$td[3]->nodeValue)
                                    );

        }
        return $tickers;
    }
    public function getValuesResgate(){
        $elementsResgate = $this->getJsonResgate();
        return $this->populate($elementsResgate);
    }

    public function getValuesCompra(){
        $elementsResgate = $this->getJsonCompra();
        return $this->populate($elementsResgate);
    }

    private function revertDate($date){
        $data = explode('/',$date);
        $newDate = new \DateTime();
        $newDate->setDate($data[2],$data[1],$data[0]);
        return $newDate;
    }

    /**
     * @param $ticker
     * @return Ticker
     */
    public function findTicker($tickerValue){
        $listTicker = $this->getValuesResgate();
        foreach($listTicker as $ticker){

          //  var_dump($ticker);
            if($ticker->getTicker() == $tickerValue){
                return $ticker;
            }
        }
    }
}