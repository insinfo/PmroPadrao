<?php


/**
 * Created by PhpStorm.
 * User: Isaque
 * Date: 14/07/2017
 * Time: 12:54
 */

namespace PmroPadraoLib\Model\DAL;

use PmroPadraoLib\Util\ContentValues;
use PmroPadraoLib\Util\DBHandle;
use \PDOException;
use \Exception;
use \PDO;
use \PmroPadraoLib\Model\VO\PessoaJuridica;
use \PmroPadraoLib\Model\VO\Pessoa;

class PessoaJuridicaDAL
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
     * @param PessoaJuridica $object
     * @return integer $id
     * @throws Exception exceção generica
     **/
    public function Incluir(PessoaJuridica $object)
    {
        $pessoaDAL = new PessoaDAL($this->db);
        $idPessoa = $pessoaDAL->Incluir($object);
        $result = $idPessoa;

        $cv = new ContentValues;
        $cv->put($object::ID_PESSOA, $idPessoa);
        $cv->put($object::CNPJ, $object->getCnpj());
        $cv->put($object::NOME_FANTASIA, $object->getNomeFantasia());
        $cv->put($object::INSCRICAO_ESTADUAL, $object->getInscricaoEstadual());
        $this->db->Insert($object::TABLE_NAME, $cv);
        return $result;
    }

    /**
     * Função para alterar registro da tabela
     * @access public
     * @param PessoaJuridica $object
     * @return void
     * @throws Exception exceção generica
     **/
    public function Alterar(PessoaJuridica $object)
    {
        $pessoaDAL = new PessoaDAL($this->db);
        $pessoaDAL->Alterar($object);

        $cv = new ContentValues;
        $cv->put($object::CNPJ, $object->getCnpj());
        $cv->put($object::NOME_FANTASIA, $object->getNomeFantasia());
        $cv->put($object::INSCRICAO_ESTADUAL, $object->getInscricaoEstadual());

        $cv->setTableName($object::TABLE_NAME);
        $cv->setWhereConditions(array($object::ID_PESSOA => $object->getId()));
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
        $pessoaDAL = new PessoaDAL($this->db);
        $pessoaDAL->Excluir($id);
        $this->db->Delete(PessoaJuridica::TABLE_NAME, PessoaJuridica::ID_PESSOA . "=" . $id);
    }

    /**
     * Função para retornar um registro da tabela enderecoPessoa
     * @access public
     * @param integer $id
     * @param string $returnType
     * @return PessoaJuridica
     * @throws Exception exceção generica
     **/
    public function Consultar($id, $returnType = 'object')
    {
        $query = 'SELECT * FROM "' . Pessoa::TABLE_NAME_PESSOA . '"';
        $query .= ' LEFT JOIN "' . PessoaJuridica::TABLE_NAME . '" ON "' . Pessoa::TABLE_NAME_PESSOA . '"."' . Pessoa::KEY_ID_PESSOA . '" = "' . PessoaJuridica::TABLE_NAME . '"."' . PessoaJuridica::ID_PESSOA . '"';
        $query .= ' WHERE "' . Pessoa::KEY_ID_PESSOA . '" = ' . '\'' . $id . '\'';
        return $this->db->SelectRAW($query, $returnType, 'single');
    }

    /**
     * Função para retornar um registro da tabela enderecoPessoa
     * filtrado por campo/valor e como vai retorna os dados
     * @access public
     * @param  string $campo
     * @param  string $valor
     * @param  string $returnType
     * @return PessoaJuridica
     * @throws Exception exceção generica
     **/
    public function ConsultarPorCampo($campo, $valor, $returnType = 'object')
    {
        $sqlFunctionName = 'remove_acentos';
        $query = 'SELECT * FROM "' . Pessoa::TABLE_NAME_PESSOA . '"';
        $query .= ' LEFT JOIN "' . PessoaJuridica::TABLE_NAME . '" ON "' . Pessoa::TABLE_NAME_PESSOA . '"."' . Pessoa::KEY_ID_PESSOA . '" = "' . PessoaJuridica::TABLE_NAME . '"."' . PessoaJuridica::ID_PESSOA . '"';
        $query .= ' WHERE ' . $sqlFunctionName . '("' . $campo . '") ILIKE ' . $sqlFunctionName . '(\'%' . $valor . '%\')';
        return  $this->db->SelectRAW($query, $returnType, 'single');
    }

    public function ListarTodos($returnType = 'object', $limit = null, $offset = 0)
    {
        $lim = '';
        if ($limit != null)
        {
            $lim = ' LIMIT ' . $limit . ' OFFSET ' . $offset . ' ';
        }

        $query = 'SELECT * FROM "' . Pessoa::TABLE_NAME_PESSOA . '"';
        $query .= ' LEFT JOIN "' . PessoaJuridica::TABLE_NAME . '" ON "' . Pessoa::TABLE_NAME_PESSOA . '"."' . Pessoa::KEY_ID_PESSOA . '" = "' . PessoaJuridica::TABLE_NAME . '"."' . PessoaJuridica::ID_PESSOA . '"';
        $query .= $lim;
        return $this->db->SelectRAW($query, $returnType);
    }

    public function ListarPorCampo($campo, $valor, $returnType = 'object', $limit = null, $offset = 0)
    {
        $lim = '';
        if ($limit != null)
        {
            $lim = ' LIMIT ' . $limit . ' OFFSET ' . $offset . ' ';
        }

        $sqlFunctionName = 'remove_acentos';

        $query = 'SELECT * FROM "' . Pessoa::TABLE_NAME_PESSOA . '"';
        $query .= ' LEFT JOIN "' . PessoaJuridica::TABLE_NAME . '" ON "' . Pessoa::TABLE_NAME_PESSOA . '"."' . Pessoa::KEY_ID_PESSOA . '" = "' . PessoaJuridica::TABLE_NAME . '"."' . PessoaJuridica::ID_PESSOA . '"';
        $query .= ' WHERE ' . $sqlFunctionName . '("' . $campo . '") ILIKE ' . $sqlFunctionName . '(\'%' . $valor . '%\')';
        $query .= $lim;
        return $this->db->SelectRAW($query, $returnType);
    }

    public function ProcurarPorCampo($campo, $valor, $returnType = 'object', $limit = null, $offset = 0)
    {
        $lim = '';
        if ($limit != null)
        {
            $lim = ' LIMIT ' . $limit . ' OFFSET ' . $offset . ' ';
        }
        $sqlFunctionName = 'remove_acentos';
        $query = 'SELECT * FROM "' . Pessoa::TABLE_NAME_PESSOA . '"';
        $query .= ' LEFT JOIN "' . PessoaJuridica::TABLE_NAME . '" ON "' . Pessoa::TABLE_NAME_PESSOA . '"."' . Pessoa::KEY_ID_PESSOA . '" = "' . PessoaJuridica::TABLE_NAME . '"."' . PessoaJuridica::ID_PESSOA . '"';
        if ($campo != null)
        {
            $query .= ' WHERE ' . $sqlFunctionName . '("' . $campo . '") ILIKE ' . $sqlFunctionName . '(\'%' . $valor . '%\')';
        }
        $query .= $lim;
        return $this->db->SelectRAW($query, $returnType);
    }

    public function ProcurarPorCampos($conditions, $returnType = 'object', $limit = null, $offset = 0,&$count =0)
    {
        $lim = '';
        if ($limit != null)
        {
            $lim = ' LIMIT ' . $limit . ' OFFSET ' . $offset . ' ';
        }
        $result = null;
        $sqlFunctionForLike = 'remove_acentos';

        $query = 'SELECT * FROM "' . Pessoa::TABLE_NAME_PESSOA . '"';
        $query .= ' LEFT JOIN "' . PessoaJuridica::TABLE_NAME . '" ON "' . Pessoa::TABLE_NAME_PESSOA . '"."' . Pessoa::KEY_ID_PESSOA . '" = "' . PessoaJuridica::TABLE_NAME . '"."' . PessoaJuridica::ID_PESSOA . '"';

        $query2 = 'SELECT count('.Pessoa::TABLE_NAME_PESSOA.'.id) as contador FROM "' . Pessoa::TABLE_NAME_PESSOA . '"';
        $query2 .= ' LEFT JOIN "' . PessoaJuridica::TABLE_NAME . '" ON "' . Pessoa::TABLE_NAME_PESSOA . '"."' . Pessoa::KEY_ID_PESSOA . '" = "' . PessoaJuridica::TABLE_NAME . '"."' . PessoaJuridica::ID_PESSOA . '"';

        if ($conditions != null)
        {
            $query .= ' WHERE "'.Pessoa::TABLE_NAME_PESSOA.'".'.Pessoa::TIPO_PESSOA.' ILIKE \'juridica\' and ' . $this->db->implodeConditions($conditions, 'like', $sqlFunctionForLike, ' OR ');
            $query2 .= ' WHERE "'.Pessoa::TABLE_NAME_PESSOA.'".'.Pessoa::TIPO_PESSOA.' ILIKE \'juridica\' and ' . $this->db->implodeConditions($conditions, 'like', $sqlFunctionForLike, ' OR ');
        }
        $query .= $lim;

        $count = $this->db->SelectRAW($query2)[0]['contador'];

        return $this->db->SelectRAW($query, $returnType);
    }

}

