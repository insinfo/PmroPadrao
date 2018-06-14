<?php

/**
 * Created by PhpStorm.
 * User: Isaque
 * Date: 16/07/2017
 * Time: 09:03
 * UF representa União Federativa ou seja um estado do Brasil
 * Esta class representa a entidade ou tipo UF (VO - value object)
 */
namespace PmroPadraoLib\Model\VO;

class UF
{
    const TABLE_NAME = "ufs";
    const KEY_ID = "id";
    const SIGLA = "sigla";
    const NOME = "nome";
    const IBGE = "ibge";
    const ID_PAIS = "idPais";

    private $id;
    private $nome;
    private $sigla;
    private $ibge;
    private $idPais;

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
    public function getSigla()
    {
        return $this->sigla;
    }

    /**
     * @param mixed $sigla
     */
    public function setSigla($sigla)
    {
        $this->sigla = $sigla;
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


    public static function getClassName()
    {
        return get_called_class();
    }

}