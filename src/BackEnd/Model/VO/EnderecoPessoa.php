<?php
/**
 * Created by PhpStorm.
 * User: Isaque
 * Date: 17/07/2017
 * Time: 13:01
 */

namespace PmroPadraoLib\Model\VO;


class EnderecoPessoa
{
    const TABLE_NAME = "pessoas_enderecos";
    const KEY_ID = "id";
    const ID_PESSOA = "idPessoa";
    const ID_ENDERECO = "idEndereco";
    const TIPO = "tipo";
    const NUMERO = "numero";
    const COMPLEMENTO = "complemento";

    const TIPO_ENDERECO_COMERCIAL = 'Comercial';
    const TIPO_ENDERECO_RESIDENCIAL = 'Residencial';

    private $id;
    private $idPessoa;
    private $idEndereco;
    private $tipo;
    private $numero;
    private $complemento;

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
    public function getIdEndereco()
    {
        return $this->idEndereco;
    }

    /**
     * @param mixed $idEndereco
     */
    public function setIdEndereco($idEndereco)
    {
        $this->idEndereco = $idEndereco;
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

    /**
     * @return mixed
     */
    public function getComplemento()
    {
        return $this->complemento;
    }

    /**
     * @param mixed $complemento
     */
    public function setComplemento($complemento)
    {
        $this->complemento = $complemento;
    }

    public static function getClassName()
    {
        return get_called_class();
    }

}