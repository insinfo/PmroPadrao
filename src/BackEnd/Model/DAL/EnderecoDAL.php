<?php
/**
 * Created by PhpStorm.
 * User: Isaque
 * Date: 20/07/2017
 * Time: 15:18
 */

namespace PmroPadraoLib\Model\DAL;

use PmroPadraoLib\Util\ContentValues;
use PmroPadraoLib\Util\DBHandle;
use \PDOException;
use \Exception;
use \PDO;
use \PmroPadraoLib\Model\VO\Endereco;

class EnderecoDAL
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
     * @param Endereco $object
     * @return integer $id do endereço
     * @throws Exception exceção generica
     **/
    public function Incluir(Endereco $object)
    {
        $result = '-1';

        $cv = new ContentValues;
        $cv->put($object::CEP, $object->getCep());
        $cv->put($object::ID_BAIRRO, $object->getIdBairro());
        $cv->put($object::ID_MUNICIPIO, $object->getIdMunicipio());
        $cv->put($object::ID_UF, $object->getIdUf());
        $cv->put($object::ID_PAIS, $object->getIdPais());
        $cv->put($object::LOGRADOURO, $object->getLogradouro());
        $cv->put($object::VALIDACAO, $object->getValidacao());
        $cv->put($object::DIVERGENTE, $object->getDivergente());
        $cv->put($object::TIPO_LOGRADOURO, $object->getTipoLogradouro());

        $result = $this->db->Insert($object::TABLE_NAME, $cv, true);


        return $result;
    }

    /**
     * Função para alterar registro da tabela
     * @access public
     * @param Endereco $object
     * @return void
     * @throws Exception exceção generica
     **/
    public function Alterar(Endereco $object)
    {

        $cv = new ContentValues;
        $cv->put($object::CEP, $object->getCep());
        $cv->put($object::ID_BAIRRO, $object->getIdBairro());
        $cv->put($object::ID_MUNICIPIO, $object->getIdMunicipio());
        $cv->put($object::ID_UF, $object->getIdUf());
        $cv->put($object::ID_PAIS, $object->getIdPais());
        $cv->put($object::LOGRADOURO, $object->getLogradouro());
        $cv->put($object::VALIDACAO, $object->getValidacao());
        $cv->put($object::DIVERGENTE, $object->getDivergente());
        $cv->put($object::TIPO_LOGRADOURO, $object->getTipoLogradouro());

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
        $this->db->Delete(Endereco::TABLE_NAME, Endereco::KEY_ID . "=" . $id);
    }

    /**
     * Função para retornar um registro da tabela enderecoPessoa
     * @access public
     * @param integer $id
     * @return Endereco
     * @throws Exception exceção generica
     **/
    public function Consultar($id)
    {
        $result = null;

        $conditions = array(Endereco::KEY_ID => $id);
        $result = $this->db->Select(Endereco::TABLE_NAME, null, $conditions, Endereco::getClassName());

        return $result;
    }

    public function SeExisteByCEP($cep)
    {
        return $this->db->CheckIfRowExist(Endereco::TABLE_NAME, $cep, Endereco::CEP, Endereco::KEY_ID);
    }

    public function SeExisteBy($logradouro,$idBairro,$cep)
    {
        $sql = 'SELECT * FROM "enderecos" ';
        $sql .= ' where "idBairro" = \''.$idBairro.'\' ';
        $sql .= ' and "cep" = \''.$cep.'\' ';
        $sql .= ' and "logradouro" ilike '.$this->db->escape('%'.trim($logradouro).'%').';';

        $data = $this->db->SelectRAW($sql);

        if($data)
        {
            return $data[0]['id'];
        }
        return null;
    }


    /**
     * Função para retornar um registro da tabela enderecoPessoa
     * filtrado por campo/valor e como vai retorna os dados
     * @access public
     * @param  string $campo
     * @param  string $valor
     * @param  string $returnType
     * @return Endereco
     * @throws Exception exceção generica
     **/
    public function ConsultarPorCampo($campo, $valor, $returnType = 'object')
    {
        $result = null;

        $conditions = array($campo => $valor);
        if ($returnType == 'object')
        {
            $retType = Endereco::getClassName();
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
        $result = $this->db->Select(Endereco::TABLE_NAME, null, $conditions, $retType);

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
        $advOptions = 'ORDER BY ' . Endereco::KEY_ID . ' ASC' . ' ' . $lim;
        $retType = null;
        if ($returnType == 'object')
        {
            $retType = Endereco::getClassName();
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

        $result = $this->db->SelectAll(Endereco::TABLE_NAME, null, null, $retType, $advOptions);

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
        $advOptions = 'ORDER BY ' . Endereco::KEY_ID . ' ASC' . ' ' . $lim;
        $retType = null;
        if ($returnType == 'object')
        {
            $retType = Endereco::getClassName();
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

        $result = $this->db->SelectAll(Endereco::TABLE_NAME, null, $conditions, $retType, $advOptions);

        return $result;
    }

    public function ProcurarPorCampo($campo, $valor, $returnType = 'object', $limit = null, $offset = 0)
    {
        $result = null;
        $conditions = array($campo => $valor);
        $retType = null;
        if ($returnType == 'object')
        {
            $retType = Endereco::getClassName();
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

        $result = $this->db->SelectAllAdvanced(Endereco::TABLE_NAME, null, $conditions, 'like', 'remove_acentos', $retType, $limit, $offset);
        return $result;
    }

    public function ProcurarPorCampos($conditions, $returnType = 'object', $limit = null, $offset = 0)
    {
        $result = null;

        $retType = null;
        if ($returnType == 'object')
        {
            $retType = Endereco::getClassName();
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

        $result = $this->db->SelectAllAdvanced(Endereco::TABLE_NAME, null, $conditions, 'like', 'remove_acentos', $retType, $limit, $offset);
        return $result;
    }


}