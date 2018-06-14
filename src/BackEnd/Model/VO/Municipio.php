<?php

/**
 * Created by PhpStorm.
 * User: Isaque
 * Date: 16/07/2017
 * Time: 09:11
 */
namespace PmroPadraoLib\Model\VO;

class Municipio
{
    const TABLE_NAME = "municipios";
    const KEY_ID = "id";
    const ID_UF = "idUF";
    const NOME = "nome";
    const IBGE = "ibge";
    const SIGLA_UF = "siglaUF";

    private $id;
    private $idUF;
    private $nome;
    private $ibge;
    private $siglaUF;

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
    public function getIdUF()
    {
        return $this->idUF;
    }

    /**
     * @param mixed $idUF
     */
    public function setIdUF($idUF)
    {
        $this->idUF = $idUF;
    }

    /**
     * @return mixed
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @param mixed $nome
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    /**
     * @return mixed
     */
    public function getIbge()
    {
        return $this->ibge;
    }

    /**
     * @param mixed $ibge
     */
    public function setIbge($ibge)
    {
        $this->ibge = $ibge;
    }

    /**
     * @return mixed
     */
    public function getSiglaUF()
    {
        return $this->siglaUF;
    }

    /**
     * @param mixed $siglaUF
     */
    public function setSiglaUF($siglaUF)
    {
        $this->siglaUF = $siglaUF;
    }

    public static function getClassName()
    {
        return get_called_class();
    }


}