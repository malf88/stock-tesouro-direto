<?php
/**
 * Created by PhpStorm.
 * User: marcoaurelio
 * Date: 24/09/2018
 * Time: 00:34
 */

namespace StockTesouroDireto;


class Titulo
{
    /**
     * @var string
     */
    private $titulo;
    /**
     * @var \DateTime
     */
    private $vencimento;
    /**
     * @var double
     */
    private $rentabilidade;
    /**
     * @var double
     */
    private $rentabilidadeResgate;
    /**
     * @var double
     */
    private $precoCompra;
    /**
     * @var double
     */
    private $precoVenda;

    /**
     * Titulo constructor.
     * @param string $titulo
     * @param \DateTime $vencimento
     * @param float $rentabilidade
     * @param float $rentabilidadeResgate
     * @param float $precoCompra
     * @param float $precoVenda
     */
    public function __construct($titulo, \DateTime $vencimento, $rentabilidade, $rentabilidadeResgate, $precoCompra, $precoVenda)
    {
        $this->titulo = $titulo;
        $this->vencimento = $vencimento;
        $this->rentabilidade = $rentabilidade;
        $this->rentabilidadeResgate = $rentabilidadeResgate;
        $this->precoCompra = $precoCompra;
        $this->precoVenda = $precoVenda;
    }

    /**
     * @return string
     */
    public function getTitulo()
    {
        return $this->titulo;
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
    public function getRentabilidade()
    {
        return $this->rentabilidade;
    }

    /**
     * @return float
     */
    public function getRentabilidadeResgate()
    {
        return $this->rentabilidadeResgate;
    }

    /**
     * @return float
     */
    public function getPrecoCompra()
    {
        return $this->precoCompra;
    }

    /**
     * @return float
     */
    public function getPrecoVenda()
    {
        return $this->precoVenda;
    }



}