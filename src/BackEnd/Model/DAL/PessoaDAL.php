<?php
/**
 * Created by PhpStorm.
 * User: Isaque
 * Date: 18/07/2017
 * Time: 16:29
 */

namespace PmroPadraoLib\Model\DAL;

use PmroPadraoLib\Model\DAL\Dal;
use PmroPadraoLib\Model\VO\Pessoa;
use PmroPadraoLib\Util\ContentValues;
use PmroPadraoLib\Util\DBHandle;
use Exception;
use PmroPadraoLib\Util\Utils;

class PessoaDAL
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
     * @param Pessoa $object
     * @return integer $id
     * @throws Exception exceção generica
     **/
    public function Incluir(Pessoa $object)
    {
        $result = -1;

        $cv = new ContentValues;
        $cv->put($object::CGM_PESSOA, $object->getCgm());
        $cv->put($object::EMAIL_ADICIONAL, $object->getEmailAdicional());
        $cv->put($object::EMAIL_PRINCIPAL, $object->getEmailPrincipal());
        $cv->put($object::NOME_PESSOA, $object->getNome());
        $cv->put($object::TIPO_PESSOA, $object->getTipo());
        $cv->put($object::DATA_INCLUSAO, Utils::GetDateTimeNow());

        $cv->put($object::IMAGEM, $object->getImagem());

        $result = $this->db->Insert($object::TABLE_NAME_PESSOA, $cv, true);

        return $result;
    }

    /**
     * Função para alterar registro da tabela
     * @access public
     * @param Pessoa $object
     * @return void
     * @throws Exception exceção generica
     **/
    public function Alterar(Pessoa $object)
    {

        $cv = new ContentValues;
        $cv->put($object::CGM_PESSOA, $object->getCgm());
        $cv->put($object::EMAIL_ADICIONAL, $object->getEmailAdicional());
        $cv->put($object::EMAIL_PRINCIPAL, $object->getEmailPrincipal());
        $cv->put($object::NOME_PESSOA, $object->getNome());
        $cv->put($object::TIPO_PESSOA, $object->getTipo());
        $cv->put($object::DATA_ALTERACAO, Utils::GetDateTimeNow());

        $cv->put($object::IMAGEM, $object->getImagem());

        $cv->setTableName($object::TABLE_NAME_PESSOA);
        $cv->setWhereConditions(array($object::KEY_ID_PESSOA => $object->getId()));

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

        $this->db->Delete(Pessoa::TABLE_NAME_PESSOA, Pessoa::KEY_ID_PESSOA . "=" . $id);

    }

    /**
     * Função para retornar um registro da tabela enderecoPessoa
     * @access public
     * @param integer $id
     * @return Pessoa
     * @throws Exception exceção generica
     **/
    public function Consultar($id)
    {
        $result = null;

        $conditions = array(Pessoa::KEY_ID_PESSOA => $id);
        $result = $this->db->Select(Pessoa::TABLE_NAME_PESSOA, null, $conditions, Pessoa::getClassName());

        return $result;
    }

    /**
     * Função para retornar um registro da tabela enderecoPessoa
     * filtrado por campo/valor e como vai retorna os dados
     * @access public
     * @param  string $campo
     * @param  string $valor
     * @param  string $returnType
     * @return Pessoa
     * @throws Exception exceção generica
     **/
    public function ConsultarPorCampo($campo, $valor, $returnType = 'object')
    {
        $result = null;

        $conditions = array($campo => $valor);
        if ($returnType == 'object')
        {
            $retType = Pessoa::getClassName();
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
        $result = $this->db->Select(Pessoa::TABLE_NAME_PESSOA, null, $conditions, $retType);

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
        $advOptions = 'ORDER BY ' . Pessoa::KEY_ID_PESSOA . ' ASC' . ' ' . $lim;
        $retType = null;
        if ($returnType == 'object')
        {
            $retType = Pessoa::getClassName();
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

        $result = $this->db->SelectAll(Pessoa::TABLE_NAME_PESSOA, null, null, $retType, $advOptions);

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
        $advOptions = 'ORDER BY ' . Pessoa::KEY_ID_PESSOA . ' ASC' . ' ' . $lim;
        $retType = null;
        if ($returnType == 'object')
        {
            $retType = Pessoa::getClassName();
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

        $result = $this->db->SelectAll(Pessoa::TABLE_NAME_PESSOA, null, $conditions, $retType, $advOptions);

        return $result;
    }

    public function ProcurarPorCampo($campo, $valor, $returnType = 'object', $limit = null, $offset = 0)
    {
        $result = null;
        $conditions = array($campo => $valor);
        $retType = null;
        if ($returnType == 'object')
        {
            $retType = Pessoa::getClassName();
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

        $result = $this->db->SelectAllAdvanced(Pessoa::TABLE_NAME_PESSOA, null, $conditions, 'like', 'remove_acentos', $retType, $limit, $offset);
        return $result;
    }

    public function ProcurarPorCampos($conditions, $returnType = 'object', $limit = null, $offset = 0)
    {
        $result = null;

        $retType = null;
        if ($returnType == 'object')
        {
            $retType = Pessoa::getClassName();
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

        $result = $this->db->SelectAllAdvanced(Pessoa::TABLE_NAME_PESSOA, null, $conditions, 'like', 'remove_acentos', $retType, $limit, $offset);
        return $result;
    }

}