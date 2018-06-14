<?php
/**
 * Created by PhpStorm.
 * User: Isaque
 * Date: 14/07/2017
 * Time: 16:04
 */

namespace PmroPadraoLib\Model\VO;


class Telefone
{
    const TABLE_NAME = "telefones";
    const KEY_ID = "id";
    const ID_PESSOA = "idPessoa";
    const TIPO = "tipo";
    const NUMERO = "numero";

    const TIPO_COMERCIAL = 'Comercial';
    const TIPO_RESIDENCIAL = 'Residencial';
    const TIPO_MOVEL = 'Movel';
    const TIPO_OUTRO = 'Outro';

    private $id;
    private $idPessoa;
    private $tipo;
    private $numero;

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
    public function getIdPessoa()
    {
        return $this->idPessoa;
    }

    /**
     * @param mixed $idPessoa
     */
    public function setIdPessoa($idPessoa)
    {
        $this->idPessoa = $idPessoa;
    }

    /**
     * @return mixed
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * @param mixed $tipo
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
    }

    /**
     * @return mixed
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * @param mixed $numero
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;
    }

    public static function getClassName()
    {
        return get_called_class();
    }
}