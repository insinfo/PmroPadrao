<?php
/**
 * Created by PhpStorm.
 * User: Isaque
 * Date: 17/07/2017
 * Time: 08:43
 */

namespace PmroPadraoLib\Model\VO;

class Bairro
{
    const TABLE_NAME = "bairros";
    const KEY_ID = "id";
    const NOME = "nome";
    const ID_MUNICIPIO = "idMunicipio";
    const IBGE = "ibge";

    private $id;
    private $nome;
    private $idMunicipio;
    private $ibge;

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

    public static function getClassName()
    {
        return get_called_class();
    }
}