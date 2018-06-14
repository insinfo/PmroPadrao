<?php
/**
 * Created by PhpStorm.
 * User: Isaque
 * Date: 20/07/2017
 * Time: 15:19
 */

namespace PmroPadraoLib\Model\DAL;

use PmroPadraoLib\Model\VO\Bairro;
use PmroPadraoLib\Model\DAL\TelefoneDAL;
use PmroPadraoLib\Model\DAL\EnderecoPessoaDAL;
use PmroPadraoLib\Model\DAL\PessoaJuridicaDAL;
use PmroPadraoLib\Util\ContentValues;
use PmroPadraoLib\Util\DBHandle;
use PDOException;
use Exception;

class BairroDAL
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
     * @param Bairro $object
     * @return integer $id do bairro
     * @throws Exception exceção generica
     **/
    public function Incluir(Bairro $object)
    {
        $result = null;

        $cv = new ContentValues;
        $cv->put($object::NOME, $object->getNome());
        $cv->put($object::IBGE, $object->getIbge());
        $cv->put($object::ID_MUNICIPIO, $object->getIdMunicipio());

        $result = $this->db->Insert($object::TABLE_NAME, $cv, true);

        return $result;
    }

    /**
     * Função para alterar registro da tabela
     * @access public
     * @param Bairro $object
     * @return void
     * @throws Exception exceção generica
     **/
    public function Alterar(Bairro $object)
    {

        $cv = new ContentValues;
        $cv->put($object::NOME, $object->getNome());
        $cv->put($object::IBGE, $object->getIbge());
        $cv->put($object::ID_MUNICIPIO, $object->getIdMunicipio());

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

        $this->db->Delete(Bairro::TABLE_NAME, Bairro::KEY_ID . "=" . $id);


    }

    /**
     * Função para retornar um registro da tabela enderecoPessoa
     * @access public
     * @param integer $id
     * @return Bairro
     * @throws Exception exceção generica
     **/
    public function Consultar($id)
    {
        $result = null;

        $conditions = array(Bairro::KEY_ID => $id);
        $result = $this->db->Select(Bairro::TABLE_NAME, null, $conditions, Bairro::getClassName());

        return $result;
    }

    /**
     * Função para retornar um registro da tabela enderecoPessoa
     * filtrado por campo/valor
     * @access public
     * @param  string $campo
     * @param  string $valor
     * @return Bairro
     * @throws Exception exceção generica
     **/
    public function ConsultarPorCampo($campo, $valor, $returnType = 'object')
    {
        $result = null;

        $retType = null;
        if ($returnType == 'object')
        {
            $retType = Bairro::getClassName();
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
        $conditions = array($campo => $valor);
        $result = $this->db->Select(Bairro::TABLE_NAME, null, $conditions, $retType);

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
        $advOptions = 'ORDER BY ' . Bairro::KEY_ID . ' ASC' . ' ' . $lim;
        $retType = null;
        if ($returnType == 'object')
        {
            $retType = Bairro::getClassName();
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

        $result = $this->db->SelectAll(Bairro::TABLE_NAME, null, null, $retType, $advOptions);

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
        $advOptions = 'ORDER BY ' . Bairro::KEY_ID . ' ASC' . ' ' . $lim;
        $retType = null;
        if ($returnType == 'object')
        {
            $retType = Bairro::getClassName();
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

        $result = $this->db->SelectAll(Bairro::TABLE_NAME, null, $conditions, $retType, $advOptions);

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
        $advOptions = 'ORDER BY ' . Bairro::KEY_ID . ' ASC' . ' ' . $lim;
        $retType = null;
        if ($returnType == 'object')
        {
            $retType = Bairro::getClassName();
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

        $result = $this->db->SelectAll(Bairro::TABLE_NAME, null, $conditions, $retType, $advOptions);

        return $result;
    }

    public function SeExisteByNome($nome)
    {
        return $this->db->CheckIfRowExist(Bairro::TABLE_NAME, $nome, Bairro::NOME, Bairro::KEY_ID);
    }

    public function SeExisteByNomeAndMunicipio($nome,$idMunicipio)
    {
        $sql = 'SELECT * FROM "bairros" where "idMunicipio" = \''.$idMunicipio.'\' and nome ilike '.$this->db->escape('%'.trim($nome).'%').';';
        $data = $this->db->SelectRAW($sql);

        if($data)
        {
            return $data[0]['id'];
        }
        return null;
    }

}