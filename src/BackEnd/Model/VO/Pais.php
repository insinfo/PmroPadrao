<?php

/**
 * Created by PhpStorm.
 * User: Isaque
 * Date: 16/07/2017
 * Time: 08:51
 * Esta class representa a entidade ou tipo Pais (VO - value object)
 */
namespace PmroPadraoLib\Model\VO;

class Pais
{
    const TABLE_NAME = "paises";
    const KEY_ID = "id";
    const NOME = "nome";

    private $id;
    private $nome;

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



    public static function getClassName()
    {
        return get_called_class();
    }

}