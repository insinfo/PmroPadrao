<?php
/**
 * Created by PhpStorm.
 * User: Isaque
 * Date: 20/07/2017
 * Time: 15:16
 */

namespace PmroPadraoLib\Model\DAL;


use PmroPadraoLib\Util\ContentValues;
use PmroPadraoLib\Util\DBHandle;
use PDOException;
use PmroPadraoLib\Util\Result;
use PmroPadraoLib\Util\StatusCode;
use PmroPadraoLib\Util\StatusMessage;
use Exception;
use PmroPadraoLib\Model\VO\UF;

class UFDAL
{
    private $db = null;

    function __construct(DBHandle $dbHandle = null)
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
     * @param UF $object
     * @return integer $id
     * @throws Exception exceção generica
     **/
    public function Incluir(UF $object)
    {
        $result = null;

        $cv = new ContentValues;
        $cv->put($object::NOME, $object->getNome());
        $cv->put($object::IBGE, $object->getIbge());
        $cv->put($object::ID_PAIS, $object->getIdPais());
        $cv->put($object::SIGLA, $object->getSigla());

        $result = $this->db->Insert($object::TABLE_NAME, $cv);


        return $result;
    }

    /**
     * Função para alterar registro da tabela
     * @access public
     * @param UF $object
     * @return void
     * @throws Exception exceção generica
     **/
    public function Alterar(UF $object)
    {

        $cv = new ContentValues;
        $cv->put($object::NOME, $object->getNome());
        $cv->put($object::IBGE, $object->getIbge());
        $cv->put($object::ID_PAIS, $object->getIdPais());
        $cv->put($object::SIGLA, $object->getSigla());
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
        $this->db->Delete(UF::TABLE_NAME, UF::KEY_ID . "=" . $id);

    }

    /**
     * Função para retornar um registro da tabela enderecoPessoa
     * @access public
     * @param integer $id
     * @return UF
     * @throws Exception exceção generica
     **/
    public function Consultar($id)
    {
        $result = null;
        $conditions = array(UF::KEY_ID => $id);
        $result = $this->db->Select(UF::TABLE_NAME, null, $conditions, UF::getClassName());

        return $result;
    }

    /**
     * Função para retornar um registro da tabela enderecoPessoa
     * filtrado por campo/valor
     * @access public
     * @param  string $campo
     * @param  string $valor
     * @return UF
     * @throws Exception exceção generica
     **/
    public function ConsultarPorCampo($campo, $valor)
    {
        $result = null;

        $conditions = array($campo => $valor);
        $result = $this->db->Select(UF::TABLE_NAME, null, $conditions, UF::getClassName());

        return $result;
    }

    public function ListarTodos($returnType = 'object', $limit = null, $offset = 0)
    {
        $result = null;

        $lim = '';
        if ($limit == !null)
        {
            $lim = ' LIMIT ' . $limit . ' OFFSET ' . $offset . ' ';
        }
        $advOptions = 'ORDER BY ' . UF::KEY_ID . ' ASC' . ' ' . $lim;
        $retType = null;
        if ($returnType == 'object')
        {
            $retType = UF::getClassName();
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

        $result = $this->db->SelectAll(UF::TABLE_NAME, null, null, $retType, $advOptions);

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
        $advOptions = 'ORDER BY ' . UF::KEY_ID . ' ASC' . ' ' . $lim;
        $retType = null;
        if ($returnType == 'object')
        {
            $retType = UF::getClassName();
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

        $result = $this->db->SelectAll(UF::TABLE_NAME, null, $conditions, $retType, $advOptions);

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
        $advOptions = 'ORDER BY ' . UF::KEY_ID . ' ASC' . ' ' . $lim;
        $retType = null;
        if ($returnType == 'object')
        {
            $retType = UF::getClassName();
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

        $result = $this->db->SelectAll(UF::TABLE_NAME, null, $conditions, $retType, $advOptions);

        return $result;
    }

}