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
    public function __construct($titulo = '', \DateTime $vencimento = null, $rentabilidade = null, $rentabilidadeResgate = null, $precoCompra = null, $precoVenda = null)
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

    /**
     * @param string $titulo
     * @return Titulo
     */
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;
        return $this;
    }

    /**
     * @param \DateTime $vencimento
     * @return Titulo
     */
    public function setVencimento($vencimento)
    {
        $this->vencimento = $vencimento;
        return $this;
    }

    /**
     * @param float $rentabilidade
     * @return Titulo
     */
    public function setRentabilidade($rentabilidade)
    {
        $this->rentabilidade = $rentabilidade;
        return $this;
    }

    /**
     * @param float $rentabilidadeResgate
     * @return Titulo
     */
    public function setRentabilidadeResgate($rentabilidadeResgate)
    {
        $this->rentabilidadeResgate = $rentabilidadeResgate;
        return $this;
    }

    /**
     * @param float $precoCompra
     * @return Titulo
     */
    public function setPrecoCompra($precoCompra)
    {
        $this->precoCompra = $precoCompra;
        return $this;
    }

    /**
     * @param float $precoVenda
     * @return Titulo
     */
    public function setPrecoVenda($precoVenda)
    {
        $this->precoVenda = $precoVenda;
        return $this;
    }



}