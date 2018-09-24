<?php
/**
 * Created by PhpStorm.
 * User: marcoaurelio
 * Date: 24/09/2018
 * Time: 00:34
 */

namespace StockTesouroDireto;


class Ticker
{
    /**
     * @var string
     */
    private $ticker;
    /**
     * @var \DateTime
     */
    private $vencimento;
    /**
     * @var double
     */
    private $taxaRendimento;
    /**
     * @var double
     */
    private $preco;

    /**
     * Ticker constructor.
     * @param string $ticker
     * @param \DateTime $vencimento
     * @param float $taxaRendimento
     * @param float $preco
     */
    public function __construct($ticker, \DateTime $vencimento, $taxaRendimento, $preco)
    {
        $this->ticker = $ticker;
        $this->vencimento = $vencimento;
        $this->taxaRendimento = $taxaRendimento;
        $this->preco = $preco;
    }

    /**
     * @return string
     */
    public function getTicker()
    {
        return $this->ticker;
    }

    /**
     * @return \DateTime
     */
    public function getVencimento()
    {
        return $this->vencimento;
    }

    /**
     * @return float
     */
    public function getTaxaRendimento()
    {
        return $this->taxaRendimento;
    }

    /**
     * @return float
     */
    public function getPreco()
    {
        return $this->preco;
    }


}