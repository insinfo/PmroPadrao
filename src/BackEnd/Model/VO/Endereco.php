<?php
/**
 * Created by PhpStorm.
 * User: Isaque
 * Date: 17/07/2017
 * Time: 08:37
 */

namespace PmroPadraoLib\Model\VO;


class Endereco
{
    const TABLE_NAME = "enderecos";
    const KEY_ID = "id";
    const CEP = "cep";
    const ID_PAIS = "idPais";
    const ID_BAIRRO = "idBairro";
    const ID_MUNICIPIO = "idMunicipio";
    const ID_UF = "idUf";
    const LOGRADOURO = "logradouro";
    const VALIDACAO = "validacao";
    const DIVERGENTE = "divergente";
    const TIPO_LOGRADOURO = "tipoLogradouro";

    private $id;//int
    private $cep;//string
    private $idBairro;//int
    private $idMunicipio;//int
    private $idUf;//int
    private $idPais;//int
    private $logradouro;//string
    private $validacao;//bool
    private $divergente;//bool
    private $tipoLogradouro;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getCep()
    {
        return $this->cep;
    }

    /**
     * @param mixed $cep
     */
    public function setCep($cep)
    {
        $this->cep = $cep;
    }

    /**
     * @return mixed
     */
    public function getIdBairro()
    {
        return $this->idBairro;
    }

    /**
     * @param mixed $idBairro
     */
    public function setIdBairro($idBairro)
    {
        $this->idBairro = $idBairro;
    }

    /**
     * @return mixed
     */
    public function getIdMunicipio()
    {
        return $this->idMunicipio;
    }

    /**
     * @param mixed $idMunicipio
     */
    public function setIdMunicipio($idMunicipio)
    {
        $this->idMunicipio = $idMunicipio;
    }

    /**
     * @return mixed
     */
    public function getIdUf()
    {
        return $this->idUf;
    }

    /**
     * @param mixed $idUf
     */
    public function setIdUf($idUf)
    {
        $this->idUf = $idUf;
    }

    /**
     * @return mixed
     */
    public function getIdPais()
    {
        return $this->idPais;
    }

    /**
     * @param mixed $idPais
     */
    public function setIdPais($idPais)
    {
        $this->idPais = $idPais;
    }

    /**
     * @return mixed
     */
    public function getLogradouro()
    {
        return $this->logradouro;
    }

    /**
     * @param mixed $logradouro
     */
    public function setLogradouro($logradouro)
    {
        $this->logradouro = $logradouro;
    }

    /**
     * @return mixed
     */
    public function getValidacao()
    {
        return $this->validacao;
    }

    /**
     * @param mixed $validacao
     */
    public function setValidacao($validacao)
    {
        $this->validacao = $validacao;
    }

    /**
     * @return mixed
     */
    public function getDivergente()
    {
        return $this->divergente;
    }

    /**
     * @param mixed $divergente
     */
    public function setDivergente($divergente)
    {
        $this->divergente = $divergente;
    }

    /**
     * @return mixed
     */
    public function getTipoLogradouro()
    {
        return $this->tipoLogradouro;
    }

    /**
     * @param mixed $tipoLogradouro
     */
    public function setTipoLogradouro($tipoLogradouro)
    {
        $this->tipoLogradouro = $tipoLogradouro;
    }//string



    public static function getClassName()
    {
        return get_called_class();
    }
}
