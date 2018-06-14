<?php
/**
 * Created by PhpStorm.
 * User: Isaque
 * Date: 20/07/2017
 * Time: 15:14
 */

namespace PmroPadraoLib\Model\DAL;

use PmroPadraoLib\Model\DAL\Dal;

use PmroPadraoLib\Util\ContentValues;
use PmroPadraoLib\Util\DBHandle;
use PDOException;
use PmroPadraoLib\Util\Result;
use PmroPadraoLib\Util\StatusCode;
use PmroPadraoLib\Util\StatusMessage;
use Exception;

use PmroPadraoLib\Model\VO\Municipio;


class MunicipioDAL
{
    private $db = null;

    function __construct($dbHandle = null)
    {
        if ($dbHandle == null)
        {
            $this->db = new DBHandle();
            $this->db->Connect();
        }
        else
        {
            $this->db = $dbHandle;
        }
    }

    /**
     * Função para incluir registro na tabela
     * @access public
     * @param Municipio $object
     * @return integer $id
     * @throws Exception exceção generica
     **/
    public function Incluir(Municipio $object)
    {
        $result = null;

        $cv = new ContentValues;
        $cv->put($object::NOME, $object->getNome());
        $cv->put($object::IBGE, $object->getIbge());
        $cv->put($object::ID_UF, $object->getIdUF());
        $cv->put($object::SIGLA_UF, $object->getSiglaUF());

        $result = $this->db->Insert($object::TABLE_NAME, $cv);

        return $result;
    }

    /**
     * Função para alterar registro da tabela
     * @access public
     * @param Municipio $object
     * @return void
     * @throws Exception exceção generica
     **/
    public function Alterar(Municipio $object)
    {

        $cv = new ContentValues;
        $cv->put($object::NOME, $object->getNome());
        $cv->put($object::IBGE, $object->getIbge());
        $cv->put($object::ID_UF, $object->getIdUF());
        $cv->put($object::SIGLA_UF, $object->getSiglaUF());

        $cv->setTableName($object::TABLE_NAME);
        $cv->setWhereConditions(array($object::KEY_ID => $object->getId()));
        $this->db->UpdateSimple($cv);


    }

    /**
     * Função para exclui registro da tabela
     * @access public
     * @param integer $id
     * @return void
     * @throws Exception exceção generica
     **/
    public function Excluir($id)
    {

        $this->db->Delete(Municipio::TABLE_NAME, Municipio::KEY_ID . "=" . $id);


    }

    /**
     * Função para retornar um registro da tabela enderecoPessoa
     * @access public
     * @param integer $id
     * @return Municipio
     * @throws Exception exceção generica
     **/
    public function Consultar($id)
    {
        $result = null;

        $conditions = array(Municipio::KEY_ID => $id);
        $result = $this->db->Select(Municipio::TABLE_NAME, null, $conditions, Municipio::getClassName());


        return $result;
    }

    /**
     * Função para retornar um registro da tabela enderecoPessoa
     * filtrado por campo/valor
     * @access public
     * @param  string $campo
     * @param  string $valor
     * @return Municipio
     * @throws Exception exceção generica
     **/
    public function ConsultarPorCampo($campo, $valor)
    {
        $result = null;

        $conditions = array($campo => $valor);
        $result = $this->db->Select(Municipio::TABLE_NAME, null, $conditions, Municipio::getClassName());


        return $result;
    }

    public function ListarTodos($returnType = 'object', $limit = null, $offset = 0)
    {
        $result = null;

        $lim = '';
        if ($limit = !null)
        {
            $lim = ' LIMIT ' . $limit . ' OFFSET ' . $offset . ' ';
        }
        $advOptions = 'ORDER BY ' . Municipio::KEY_ID . ' ASC' . ' ' . $lim;
        $retType = null;
        if ($returnType == 'object')
        {
            $retType = Municipio::getClassName();
        }
        else if ($returnType == 'json')
        {
            $retType = DBHandle::$JSON_FORMAT;
        }
        else if ($returnType == 'array')
        {
            $retType = DBHandle::$ARRAY_FORMAT;
        }
        else
        {
            $retType = DBHandle::$ARRAY_FORMAT;
        }

        $result = $this->db->SelectAll(Municipio::TABLE_NAME, null, null, $retType, $advOptions);

        return $result;
    }

    public function ListarPorCampo($campo, $valor, $returnType = 'object', $limit = null, $offset = 0)
    {
        $result = null;

        $conditions = array($campo => $valor);
        $lim = '';
        if ($limit == !null)
        {
            $lim = ' LIMIT ' . $limit . ' OFFSET ' . $offset . ' ';
        }
        $advOptions = 'ORDER BY ' . Municipio::KEY_ID . ' ASC' . ' ' . $lim;
        $retType = null;
        if ($returnType == 'object')
        {
            $retType = Municipio::getClassName();
        }
        else if ($returnType == 'json')
        {
            $retType = DBHandle::$JSON_FORMAT;
        }
        else if ($returnType == 'array')
        {
            $retType = DBHandle::$ARRAY_FORMAT;
        }
        else
        {
            $retType = DBHandle::$ARRAY_FORMAT;
        }

        $result = $this->db->SelectAll(Municipio::TABLE_NAME, null, $conditions, $retType, $advOptions);

        return $result;
    }

    public function ListarByFilter($conditions, $returnType = 'object', $limit = null, $offset = 0)
    {
        $result = null;

        $lim = '';
        if ($limit == !null)
        {
            $lim = ' LIMIT ' . $limit . ' OFFSET ' . $offset . ' ';
        }
        $advOptions = 'ORDER BY ' . Municipio::KEY_ID . ' ASC' . ' ' . $lim;
        $retType = null;
        if ($returnType == 'object')
        {
            $retType = Municipio::getClassName();
        }
        else if ($returnType == 'json')
        {
            $retType = DBHandle::$JSON_FORMAT;
        }
        else if ($returnType == 'array')
        {
            $retType = DBHandle::$ARRAY_FORMAT;
        }
        else
        {
            $retType = DBHandle::$ARRAY_FORMAT;
        }

        $result = $this->db->SelectAll(Municipio::TABLE_NAME, null, $conditions, $retType, $advOptions);

        return $result;
    }

}