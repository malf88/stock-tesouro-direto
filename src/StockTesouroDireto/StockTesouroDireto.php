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

    private $login = '';
    private $senha = '';

    /**
     * StockTesouroDireto constructor.
     * @param string $login
     * @param string $senha
     */
    public function __construct($login, $senha)
    {
        $this->login = $login;
        $this->senha = $senha;
    }

    /**
     * @return \DOMNodeList|false
     * @throws \GuzzleHttp\Exception\GuzzleException
     */

    public function getJson(){
        $client = new Client(['cookies' => true]);
        $jar1 = new CookieJar();

        /*****
         * Request dos campos do form
         */

        $r = $client->request('GET', 'https://tesourodireto.bmfbovespa.com.br/portalinvestidor',
            [
                'cookies' => $jar1,
                'verify' => false
            ]);
        
        $dom = new \DOMDocument();
        //var_dump($r);
        $html = $r->getBody()->getContents();
        libxml_use_internal_errors(true);
        $dom->loadHTML($html);
        libxml_clear_errors();

        $camposRequeridos = $dom->getElementById('BodyContent_hdnCamposRequeridos')->getAttribute('value');
        $camposViewState = $dom->getElementById('__VIEWSTATE')->getAttribute('value');
        $camposViewStateGeneration = $dom->getElementById('__VIEWSTATEGENERATOR')->getAttribute('value');
        $camposViewEventValidation = $dom->getElementById('__EVENTVALIDATION')->getAttribute('value');
        //die();
        $variavel = [
                        'ctl00$BodyContent$txtLogin' => $this->getLogin(),
                        'ctl00$BodyContent$txtSenha'=> $this->getSenha(),
                        'ctl00$BodyContent$btnLogar'=>'Entrar',
                        'ctl00$BodyContent$hdnCamposRequeridos'=>$camposRequeridos,
                        '__VIEWSTATEGENERATOR' => $camposViewStateGeneration,
                        '__EVENTVALIDATION' => $camposViewEventValidation,
                        '__VIEWSTATE' => $camposViewState
                    ];
        /***
         * Request do login
         */


        $request = $client->request('POST','https://tesourodireto.bmfbovespa.com.br/portalinvestidor/login.aspx',[
            'form_params' => $variavel,
            'verify' => false,
            'cookies' => $jar1,
            'allow_redirects' => [
                'max'             => 10,        // allow at most 10 redirects.
                'strict'          => true,      // use "strict" RFC compliant redirects.
                'referer'         => true,      // add a Referer header
                'protocols'       => ['https'], // only allow https URLs
                //'on_redirect'     => $onRedirect,
                'track_redirects' => true
            ],
            'headers' => [
                'User-Agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.92 Safari/537.36'
            ]

        ]);

        $domTableDados = new \DOMDocument();
        $domTableDados->loadHTML($request->getBody()->getContents());

        $xpath = new \DOMXPath($domTableDados);
        $table = $xpath->query('//*[@class=\'nowrap\']');

        return $table;

    }

    /**
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getStatus(){
        $result = $this->getJson();
        
        return ($result->length > 1);
    }

    /**
     * @param $elements array
     * @return array|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function populate($elements){

        if(!$this->getStatus()){
            return null;
        }
        $tickers = array();
        foreach ($elements as $item) {

            $td = $item->getElementsByTagName('td');

            if($td->length == 1) continue;
            $tickers[] = new Titulo(
                                    trim($td[0]->nodeValue),
                                    $this->revertDate(trim($td[1]->nodeValue)),
                                    (float)str_replace(array(','),array('.'),trim($td[2]->nodeValue)),
                                    (float)str_replace(array(','),array('.'),trim($td[3]->nodeValue)),
                                    (float)str_replace(array('.','R$',','),array('','','.'),trim($td[4]->nodeValue)),
                                    (float)str_replace(array('.','R$',','),array('','','.'),trim($td[5]->nodeValue))
                                    );

        }
        return $tickers;
    }

    /**
     * @return array|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getTitulos(){
        $elementsResgate = $this->getJson();

        return $this->populate($elementsResgate);
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
        foreach($listTicker as $ticker){

          //  var_dump($ticker);
            if($ticker->getTitulo() == $tickerValue){
                return $ticker;
            }
        }
    }

    /**
     * @return string
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * @param string $login
     */
    public function setLogin($login)
    {
        $this->login = $login;
    }

    /**
     * @return string
     */
    public function getSenha()
    {
        return $this->senha;
    }

    /**
     * @param string $senha
     */
    public function setSenha($senha)
    {
        $this->senha = $senha;
    }

}