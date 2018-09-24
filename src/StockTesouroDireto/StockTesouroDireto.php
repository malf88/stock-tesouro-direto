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
}