<?php
/**
 * Created by PhpStorm.
 * User: Isaque
 * Date: 20/07/2017
 * Time: 15:13
 */

namespace PmroPadraoLib\Model\DAL;

use PmroPadraoLib\Model\VO\EnderecoPessoa;
use PmroPadraoLib\Util\ContentValues;
use PmroPadraoLib\Util\DBHandle;
use \Exception;

class EnderecoPessoaDAL
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
     * Função para incluir registro na tabela enderecoPessoa
     * @access public
     * @param EnderecoPessoa $enderecoPessoa
     * @return integer $id
     * @throws Exception exceção generica
     **/
    public function Incluir(EnderecoPessoa $enderecoPessoa)
    {
        $result = null;

        $cv = new ContentValues;
        $cv->put($enderecoPessoa::ID_PESSOA, $enderecoPessoa->getIdPessoa());
        $cv->put($enderecoPessoa::NUMERO, $enderecoPessoa->getNumero());
        $cv->put($enderecoPessoa::COMPLEMENTO, $enderecoPessoa->getComplemento());
        $cv->put($enderecoPessoa::ID_ENDERECO, $enderecoPessoa->getIdEndereco());
        $cv->put($enderecoPessoa::TIPO, $enderecoPessoa->getTipo());
        $result = $this->db->Insert($enderecoPessoa::TABLE_NAME, $cv);

        return $result;
    }

    /**
     * Função para alterar registro da tabela enderecoPessoa
     * @access public
     * @param EnderecoPessoa $enderecoPessoa
     * @return void
     * @throws Exception exceção generica
     **/
    public function Alterar(EnderecoPessoa $object)
    {

        $cv = new ContentValues;
        $cv->put($object::ID_PESSOA, $object->getIdPessoa());
        $cv->put($object::NUMERO, $object->getNumero());
        $cv->put($object::COMPLEMENTO, $object->getComplemento());
        $cv->put($object::ID_ENDERECO, $object->getIdEndereco());
        $cv->put($object::TIPO, $object->getTipo());
        $cv->setTableName($object::TABLE_NAME);
        $cv->setWhereConditions(array($object::KEY_ID => $object->getId()));

        $this->db->UpdateSimple($cv);

    }

    public function AlterarByIdPessoa(EnderecoPessoa $object)
    {

        $cv = new ContentValues;
        $cv->put($object::ID_PESSOA, $object->getIdPessoa());
        $cv->put($object::NUMERO, $object->getNumero());
        $cv->put($object::COMPLEMENTO, $object->getComplemento());
        $cv->put($object::ID_ENDERECO, $object->getIdEndereco());
        $cv->put($object::TIPO, $object->getTipo());
        $cv->setTableName($object::TABLE_NAME);
        $cv->setWhereConditions(array($object::ID_PESSOA => $object->getIdPessoa()));

        $this->db->UpdateSimple($cv);

    }

    /**
     * Função para exclui registro da tabela enderecoPessoa
     * @access public
     * @param integer $id
     * @return void
     * @throws Exception exceção generica
     **/
    public function Excluir($id)
    {
        $this->db->Delete(EnderecoPessoa::TABLE_NAME, EnderecoPessoa::KEY_ID . "=" . $id);
    }

    public function DeleteByIdPessoa($id)
    {
        $this->db->Delete(EnderecoPessoa::TABLE_NAME, [EnderecoPessoa::ID_PESSOA => $id]);
    }

    /**
     * Função para retornar um registro da tabela enderecoPessoa
     * @access public
     * @param integer $id
     * @return EnderecoPessoa
     * @throws Exception exceção generica
     **/
    public function Consultar($id)
    {
        $result = null;

        $conditions = array(EnderecoPessoa::KEY_ID => $id);
        $result = $this->db->Select(EnderecoPessoa::TABLE_NAME, null, $conditions, EnderecoPessoa::getClassName());


        return $result;
    }

    /**
     * Função para retornar um registro da tabela enderecoPessoa
     * filtrado por campo/valor e como vai retorna os dados
     * @access public
     * @param  string $campo
     * @param  string $valor
     * @param  string $returnType
     * @return EnderecoPessoa
     * @throws Exception exceção generica
     **/
    public function ConsultarPorCampo($campo, $valor, $returnType = 'object')
    {
        $result = null;

        $conditions = array($campo => $valor);
        if ($returnType == 'object')
        {
            $retType = EnderecoPessoa::getClassName();
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
        $result = $this->db->Select(EnderecoPessoa::TABLE_NAME, null, $conditions, $retType);

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
        $advOptions = 'ORDER BY ' . EnderecoPessoa::KEY_ID . ' ASC' . ' ' . $lim;
        $retType = null;
        if ($returnType == 'object')
        {
            $retType = EnderecoPessoa::getClassName();
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

        $result = $this->db->SelectAll(EnderecoPessoa::TABLE_NAME, null, null, $retType, $advOptions);

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
        $advOptions = 'ORDER BY ' . EnderecoPessoa::KEY_ID . ' ASC' . ' ' . $lim;
        $retType = null;
        if ($returnType == 'object')
        {
            $retType = EnderecoPessoa::getClassName();
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

        $result = $this->db->SelectAll(EnderecoPessoa::TABLE_NAME, null, $conditions, $retType, $advOptions);

        return $result;
    }

    public function ProcurarPorCampo($campo, $valor, $returnType = 'object', $limit = null, $offset = 0)
    {
        $result = null;
        $conditions = array($campo => $valor);
        $retType = null;
        if ($returnType == 'object')
        {
            $retType = EnderecoPessoa::getClassName();
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

        $result = $this->db->SelectAllAdvanced(EnderecoPessoa::TABLE_NAME, null, $conditions, 'like', 'remove_acentos', $retType, $limit, $offset);
        return $result;
    }

    public function ProcurarPorCampos($conditions, $returnType = 'object', $limit = null, $offset = 0)
    {
        $result = null;

        $retType = null;
        if ($returnType == 'object')
        {
            $retType = EnderecoPessoa::getClassName();
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

        $result = $this->db->SelectAllAdvanced(EnderecoPessoa::TABLE_NAME, null, $conditions, 'like', 'remove_acentos', $retType, $limit, $offset);
        return $result;
    }


}