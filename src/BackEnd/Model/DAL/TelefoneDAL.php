<?php
/**
 * Created by PhpStorm.
 * User: Isaque
 * Date: 20/07/2017
 * Time: 15:09
 */

namespace PmroPadraoLib\Model\DAL;


use PmroPadraoLib\Model\VO\Telefone;
use PmroPadraoLib\Util\ContentValues;
use PmroPadraoLib\Util\DBHandle;
use PDOException;
use Exception;

class TelefoneDAL
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
     * @param Telefone $object
     * @return integer $id
     * @throws Exception exceção generica
     **/
    public function Incluir(Telefone $object)
    {
        $result = null;

        $cv = new ContentValues;
        $cv->put($object::NUMERO, $object->getNumero());
        $cv->put($object::TIPO, $object->getTipo());
        $cv->put($object::ID_PESSOA, $object->getIdPessoa());

        $result = $this->db->Insert($object::TABLE_NAME, $cv);

        return $result;
    }

    /**
     * Função para alterar registro da tabela
     * @access public
     * @param Telefone $object
     * @return void
     * @throws Exception exceção generica
     **/
    public function Alterar(Telefone $object)
    {

        $cv = new ContentValues;
        $cv->put($object::NUMERO, $object->getNumero());
        $cv->put($object::TIPO, $object->getTipo());
        $cv->put($object::ID_PESSOA, $object->getIdPessoa());

        $cv->setTableName($object::TABLE_NAME);
        $cv->setWhereConditions(array($object::KEY_ID => $object->getId()));
        $this->db->UpdateSimple($cv);

    }

    public function AlterarByIdPessoa(Telefone $object)
    {

        $cv = new ContentValues;
        $cv->put($object::NUMERO, $object->getNumero());
        $cv->put($object::TIPO, $object->getTipo());
        $cv->put($object::ID_PESSOA, $object->getIdPessoa());

        $cv->setTableName($object::TABLE_NAME);
        $cv->setWhereConditions(array($object::ID_PESSOA => $object->getIdPessoa()));
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
        $this->db->Delete(Telefone::TABLE_NAME, Telefone::KEY_ID . "=" . $id);
    }

    public function DeleteByIdPessoa($id)
    {
        $this->db->Delete(Telefone::TABLE_NAME, [Telefone::ID_PESSOA => $id]);
    }

    /**
     * Função para retornar um registro da tabela enderecoPessoa
     * @access public
     * @param integer $id
     * @return Telefone
     * @throws Exception exceção generica
     **/
    public function Consultar($id)
    {
        $result = null;

        $conditions = array(Telefone::KEY_ID => $id);
        $result = $this->db->Select(Telefone::TABLE_NAME, null, $conditions, Telefone::getClassName());


        return $result;
    }

    /**
     * Função para retornar um registro da tabela enderecoPessoa
     * filtrado por campo/valor e como vai retorna os dados
     * @access public
     * @param  string $campo
     * @param  string $valor
     * @param  string $returnType
     * @return Telefone
     * @throws Exception exceção generica
     **/
    public function ConsultarPorCampo($campo, $valor, $returnType = 'object')
    {
        $result = null;

        $conditions = array($campo => $valor);
        if ($returnType == 'object')
        {
            $retType = Telefone::getClassName();
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
        $result = $this->db->Select(Telefone::TABLE_NAME, null, $conditions, $retType);

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
        $advOptions = 'ORDER BY ' . Telefone::KEY_ID . ' ASC' . ' ' . $lim;
        $retType = null;
        if ($returnType == 'object')
        {
            $retType = Telefone::getClassName();
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

        $result = $this->db->SelectAll(Telefone::TABLE_NAME, null, null, $retType, $advOptions);

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
        $advOptions = 'ORDER BY ' . Telefone::KEY_ID . ' ASC' . ' ' . $lim;
        $retType = null;
        if ($returnType == 'object')
        {
            $retType = Telefone::getClassName();
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

        $result = $this->db->SelectAll(Telefone::TABLE_NAME, null, $conditions, $retType, $advOptions);

        return $result;
    }

    public function ProcurarPorCampo($campo, $valor, $returnType = 'object', $limit = null, $offset = 0)
    {
        $result = null;
        $conditions = array($campo => $valor);
        $retType = null;
        if ($returnType == 'object')
        {
            $retType = Telefone::getClassName();
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

        $result = $this->db->SelectAllAdvanced(Telefone::TABLE_NAME, null, $conditions, 'like', 'remove_acentos', $retType, $limit, $offset);
        return $result;
    }

    public function ProcurarPorCampos($conditions, $returnType = 'object', $limit = null, $offset = 0)
    {
        $result = null;

        $retType = null;
        if ($returnType == 'object')
        {
            $retType = Telefone::getClassName();
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

        $result = $this->db->SelectAllAdvanced(Telefone::TABLE_NAME, null, $conditions, 'like', 'remove_acentos', $retType, $limit, $offset);
        return $result;
    }


}