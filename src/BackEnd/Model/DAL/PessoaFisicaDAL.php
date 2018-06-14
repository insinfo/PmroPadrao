<?php
/**
 * Created by PhpStorm.
 * User: Isaque
 * Date: 20/07/2017
 * Time: 15:15
 */

namespace PmroPadraoLib\Model\DAL;

use PmroPadraoLib\Util\ContentValues;
use PmroPadraoLib\Util\DBHandle;
use \PDOException;
use \Exception;
use \PDO;
use \PmroPadraoLib\Model\VO\PessoaFisica;
use \PmroPadraoLib\Model\VO\Pessoa;

class PessoaFisicaDAL
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
     * @param PessoaFisica $object
     * @return integer $idPessoa
     * @throws Exception exceção generica
     **/
    public function Incluir(PessoaFisica $object)
    {
        $pessoaDAL = new PessoaDAL($this->db);
        $idPessoa = $pessoaDAL->Incluir($object);
        $result = $idPessoa;

        $cv = new ContentValues;
        $cv->put($object::KEY_ID, $idPessoa);
        $cv->put($object::CPF, $object->getCpf());
        $cv->put($object::RG, $object->getRg());
        if ($object->getDataEmissao() != '')
        {
            $cv->put($object::DATA_EMISSAO, $object->getDataEmissao());
        }
        if ($object->getDataNascimento() != '')
        {
            $cv->put($object::DATA_NASCIMENTO, $object->getDataNascimento());
        }
        $cv->put($object::ORGAO_EMISSOR, $object->getOrgaoEmissor());
        $cv->put($object::ID_UF_ORGAO_EMISSOR, $object->getIdUfOrgaoEmissor());
        $cv->put($object::ID_PAIS_NACIONALIDADE, $object->getIdPaisNacionalidade());
        $cv->put($object::SEXO, $object->getSexo());

        //campos novos 27.03.2018
        $cv->put($object::GRUPO_SANGUINEO, $object->getGrupoSanguineo());
        $cv->put($object::FATOR_RH, $object->getFatorRH());
        $cv->put($object::PROFISSAO, $object->getProfissao());

        $cv->put($object::PIS, $object->getPis());
        $cv->put($object::ESTADO_CIVIL, $object->getEstadoCivil());
        $cv->put($object::NOME_PAI, $object->getNomePai());
        $cv->put($object::NOME_MAE, $object->getNomeMae());

        $cv->put($object::NATURALIDADE_MUNICIPIO, $object->getNaturalidadeMunicipio());
        $cv->put($object::NATURALIDADE_UF, $object->getNaturalidadeUF());

        $this->db->Insert($object::TABLE_NAME, $cv);
        return $result;
    }

    /**
     * Função para alterar registro da tabela
     * @access public
     * @param PessoaFisica $object
     * @return void
     * @throws Exception exceção generica
     **/
    public function Alterar(PessoaFisica $object)
    {
        $pessoaDAL = new PessoaDAL($this->db);
        $pessoaDAL->Alterar($object);

        $cv = new ContentValues;
        $cv->put($object::KEY_ID, $object->getIdPessoa());
        $cv->put($object::CPF, $object->getCpf());
        $cv->put($object::RG, $object->getRg());
        $cv->put($object::DATA_EMISSAO, $object->getDataEmissao());
        $cv->put($object::ORGAO_EMISSOR, $object->getOrgaoEmissor());
        $cv->put($object::ID_UF_ORGAO_EMISSOR, $object->getIdUfOrgaoEmissor());
        $cv->put($object::ID_PAIS_NACIONALIDADE, $object->getIdPaisNacionalidade());
        $cv->put($object::DATA_NASCIMENTO, $object->getDataNascimento());
        $cv->put($object::SEXO, $object->getSexo());

        //campos novos 27.03.2018
        $cv->put($object::GRUPO_SANGUINEO, $object->getGrupoSanguineo());
        $cv->put($object::FATOR_RH, $object->getFatorRH());
        $cv->put($object::PROFISSAO, $object->getProfissao());

        $cv->put($object::PIS, $object->getPis());
        $cv->put($object::ESTADO_CIVIL, $object->getEstadoCivil());
        $cv->put($object::NOME_PAI, $object->getNomePai());
        $cv->put($object::NOME_MAE, $object->getNomeMae());

        $cv->put($object::NATURALIDADE_MUNICIPIO, $object->getNaturalidadeMunicipio());
        $cv->put($object::NATURALIDADE_UF, $object->getNaturalidadeUF());

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
        $pessoaDAL = new PessoaDAL($this->db);
        $pessoaDAL->Excluir($id);
        $this->db->Delete(PessoaFisica::TABLE_NAME, PessoaFisica::KEY_ID . "=" . $id);
    }

    /**
     * Função para retornar um registro da tabela enderecoPessoa
     * @access public
     * @param integer $id
     * @param string $returnType
     * @return PessoaFisica
     * @throws Exception exceção generica
     **/
    public function Consultar($id, $returnType = 'object')
    {
        $query = 'SELECT * FROM "' . Pessoa::TABLE_NAME_PESSOA . '"';
        $query .= ' LEFT JOIN "' . PessoaFisica::TABLE_NAME . '" ON "' . Pessoa::TABLE_NAME_PESSOA . '"."' . Pessoa::KEY_ID_PESSOA . '" = "' . PessoaFisica::TABLE_NAME . '"."' . PessoaFisica::KEY_ID . '"';
        $query .= ' WHERE "' . Pessoa::KEY_ID_PESSOA . '" = ' . '\'' . $id . '\'';
        $result = $this->db->SelectRAW($query, $returnType, 'single');
        return $result;
    }

    /**
     * Função para retornar um registro da tabela enderecoPessoa
     * filtrado por campo/valor e como vai retorna os dados
     * @access public
     * @param  string $campo
     * @param  string $valor
     * @param  string $returnType
     * @return PessoaFisica
     * @throws Exception exceção generica
     **/
    public function ConsultarPorCampo($campo, $valor, $returnType = 'object')
    {
        $query = 'SELECT * FROM "' . Pessoa::TABLE_NAME_PESSOA . '"';
        $query .= 'LEFT JOIN "' . PessoaFisica::TABLE_NAME . '" ON "' . Pessoa::TABLE_NAME_PESSOA . '"."' . Pessoa::KEY_ID_PESSOA . '" = "' . PessoaFisica::TABLE_NAME . '"."' . PessoaFisica::KEY_ID . '"';
        $query .= ' WHERE "'.Pessoa::TABLE_NAME_PESSOA.'".'.Pessoa::TIPO_PESSOA.' = \'fisica\' and "'.$campo.'"=\''.$valor.'\'' ;

        $result = $this->db->SelectRAW($query, $returnType,'single');
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
        $advOptions = 'ORDER BY ' . PessoaFisica::KEY_ID_PESSOA . ' ASC' . ' ' . $lim;
        $result = $this->db->SelectAll(PessoaFisica::TABLE_NAME_PESSOA, null, null, $returnType, $advOptions);

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
        $advOptions = 'ORDER BY ' . PessoaFisica::KEY_ID_PESSOA . ' ASC' . ' ' . $lim;
        $result = $this->db->SelectAll(PessoaFisica::TABLE_NAME_PESSOA, null, $conditions, $returnType, $advOptions);

        return $result;
    }

    public function ProcurarPorCampo($campo, $valor, $returnType = 'object', $limit = null, $offset = 0)
    {
        $lim = '';
        if ($limit != null)
        {
            $lim = ' LIMIT ' . $limit . ' OFFSET ' . $offset . ' ';
        }

        $result = null;
        $sqlFunctionName = 'remove_acentos';

        $query = 'SELECT * FROM "' . Pessoa::TABLE_NAME_PESSOA . '"';
        $query .= ' LEFT JOIN "' . PessoaFisica::TABLE_NAME . '" ON "' . Pessoa::TABLE_NAME_PESSOA . '"."' . Pessoa::KEY_ID_PESSOA . '" = "' . PessoaFisica::TABLE_NAME . '"."' . PessoaFisica::KEY_ID . '"';
        if ($campo != null)
        {
            $query .= ' WHERE ' . $sqlFunctionName . '("' . $campo . '") ILIKE ' . $sqlFunctionName . '(\'%' . $valor . '%\')';
        }
        $query .= $lim;
        $result = $this->db->SelectRAW($query, $returnType);

        return $result;
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
        $query .= 'LEFT JOIN "' . PessoaFisica::TABLE_NAME . '" ON "' . Pessoa::TABLE_NAME_PESSOA . '"."' . Pessoa::KEY_ID_PESSOA . '" = "' . PessoaFisica::TABLE_NAME . '"."' . PessoaFisica::KEY_ID . '"';

        $query2 = 'SELECT count('.Pessoa::TABLE_NAME_PESSOA.'.id) as contador FROM "' . Pessoa::TABLE_NAME_PESSOA . '"';
        $query2 .= 'LEFT JOIN "' . PessoaFisica::TABLE_NAME . '" ON "' . Pessoa::TABLE_NAME_PESSOA . '"."' . Pessoa::KEY_ID_PESSOA . '" = "' . PessoaFisica::TABLE_NAME . '"."' . PessoaFisica::KEY_ID . '"';

        if ($conditions != null)
        {
            $query .= ' WHERE "'.Pessoa::TABLE_NAME_PESSOA.'".'.Pessoa::TIPO_PESSOA.' ILIKE \'fisica\' and ' . $this->db->implodeConditions($conditions, 'like', $sqlFunctionForLike, ' OR ');
            $query2 .= ' WHERE "'.Pessoa::TABLE_NAME_PESSOA.'".'.Pessoa::TIPO_PESSOA.' ILIKE \'fisica\' and ' . $this->db->implodeConditions($conditions, 'like', $sqlFunctionForLike, ' OR ');
        }

        $query .= ' order by  '.Pessoa::NOME_PESSOA;

        $count = $this->db->SelectRAW($query2)[0]['contador'];

        $query .= $lim;
        $result = $this->db->SelectRAW($query, $returnType);

        return $result;
    }


}