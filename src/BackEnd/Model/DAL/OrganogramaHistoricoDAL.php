<?php
/**
 * Created by PhpStorm.
 * User: Isaque
 * Date: 20/07/2017
 * Time: 15:17
 */

namespace PmroPadraoLib\Model\DAL;

use PmroPadraoLib\Model\VO\OrganogramaHistorico;
use PmroPadraoLib\Util\ContentValues;
use PmroPadraoLib\Util\DBHandle;
use PmroPadraoLib\Util\DBLayer;
use PDOException;
use Exception;

class OrganogramaHistoricoDAL
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
     * @param OrganogramaHistorico $object
     * @return integer $id
     * @throws Exception exceção generica
     **/
    public function Incluir(OrganogramaHistorico $object)
    {
        $result = null;

        $cv = new ContentValues;
        $cv->put($object::KEY_ID, $object->getIdOrganograma());
        $cv->put($object::DATA_INICIO, $object->getDataInicio());
        $cv->put($object::SIGLA, $object->getSigla());
        $cv->put($object::NOME, $object->getNome());
        $cv->put($object::NUMERO_LEI, $object->getNumeroLei());
        $cv->put($object::IS_OFICIAL, $object->getIsOficial());
        $cv->put($object::ANO_LEI, $object->getAnoLei());
        $cv->put($object::DATA_DIARIO, $object->getDataDiario());
        $cv->put($object::NUMERO_DIARIO, $object->getNumeroDiario());
        $cv->put($object::ID_PAI, $object->getIdPai());

        $result = $this->db->Insert($object::TABLE_NAME, $cv);

        return $result;
    }

    /**
     * Função para alterar registro da tabela
     * @access public
     * @param OrganogramaHistorico $object
     * @return void
     * @throws Exception exceção generica
     **/
    public function Alterar(OrganogramaHistorico $object)
    {

        $cv = new ContentValues;
        $cv->put($object::DATA_INICIO, $object->getDataInicio());
        $cv->put($object::SIGLA, $object->getSigla());
        $cv->put($object::NOME, $object->getNome());
        $cv->put($object::NUMERO_LEI, $object->getNumeroLei());
        $cv->put($object::IS_OFICIAL, $object->getIsOficial());
        $cv->put($object::ANO_LEI, $object->getAnoLei());
        $cv->put($object::DATA_DIARIO, $object->getDataDiario());
        $cv->put($object::NUMERO_DIARIO, $object->getNumeroDiario());
        $cv->put($object::ID_PAI, $object->getIdPai());

        $cv->setTableName($object::TABLE_NAME);
        $cv->setWhereConditions(array($object::KEY_ID => $object->getIdOrganograma(), $object::DATA_INICIO => $object->getDataInicio() ));

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

        $this->db->Delete(OrganogramaHistorico::TABLE_NAME, OrganogramaHistorico::KEY_ID . "=" . $id);


    }

    /**
     * Função para retornar um registro da tabela enderecoPessoa
     * @access public
     * @param integer $id
     * @return OrganogramaHistorico
     * @throws Exception exceção generica
     **/
    public function Consultar($id)
    {
        $result = null;

        $conditions = array(OrganogramaHistorico::KEY_ID => $id);
        $result = $this->db->Select(OrganogramaHistorico::TABLE_NAME, null, $conditions, OrganogramaHistorico::getClassName());

        return $result;
    }

    /**
     * Função para retornar um registro da tabela enderecoPessoa
     * filtrado por campo/valor
     * @access public
     * @param  string $campo
     * @param  string $valor
     * @return OrganogramaHistorico
     * @throws Exception exceção generica
     **/
    public function ConsultarPorCampo($campo, $valor)
    {
        $result = null;

        $conditions = array($campo => $valor);
        $result = $this->db->Select(OrganogramaHistorico::TABLE_NAME, null, $conditions, OrganogramaHistorico::getClassName());


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
        $advOptions = 'ORDER BY ' . OrganogramaHistorico::KEY_ID . ' ASC' . ' ' . $lim;
        $retType = null;
        if ($returnType == 'object')
        {
            $retType = OrganogramaHistorico::getClassName();
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

        $result = $this->db->SelectAll(OrganogramaHistorico::TABLE_NAME, null, null, $retType, $advOptions);

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
        $advOptions = 'ORDER BY ' . OrganogramaHistorico::KEY_ID . ' ASC' . ' ' . $lim;
        $retType = null;
        if ($returnType == 'object')
        {
            $retType = OrganogramaHistorico::getClassName();
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

        $result = $this->db->SelectAll(OrganogramaHistorico::TABLE_NAME, null, $conditions, $retType, $advOptions);

        return $result;
    }

    /**
     * Função para retornar todos os registros de um determinado setor no organograma
     * @access public
     * @param integer $id
     * @return OrganogramaHistorico
     * @throws Exception exceção generica
     **/
    public function ConsultarHistorico($idOrganograma)
    {
        //$result = null;

        //$conditions = array(OrganogramaHistorico::KEY_ID => $idOrganograma);
        //$result = $this->db->SelectAll(OrganogramaHistorico::TABLE_NAME, null, $conditions, OrganogramaHistorico::getClassName());
/*
        //select * from organograma_historico a, organograma_historico b where a."idPai"=b."idOrganograma";
        $query = '';
        $query .= ' SELECT * FROM "'.OrganogramaHistorico::TABLE_NAME.'" a';
        $query .= ' LEFT OUTER JOIN "'.OrganogramaHistorico::TABLE_NAME.'" b ON a."'.OrganogramaHistorico::ID_PAI.'" = b."'.OrganogramaHistorico::KEY_ID . '" AND a."dataInicio" >= b."dataInicio"';
        $query .= ' WHERE a."' . OrganogramaHistorico::KEY_ID . '" = ' . $idOrganograma . ' ';
        $query .= ' ORDER BY a."dataInicio"';

        $result = $this->db->SelectRAW($query);
*/
        DBLayer::Connect();
        $query = DBLayer::table('"' . OrganogramaHistorico::TABLE_NAME . '" sh')
            ->from(DBLayer::raw('"' . OrganogramaHistorico::TABLE_NAME . '" sh'))
            ->select(DBLayer::raw(' sh.*, s."' . OrganogramaHistorico::SIGLA . '" as "siglaPai", s."' . OrganogramaHistorico::NOME . '" as "nomePai"'))
            ->leftjoin(DBLayer::raw('func_organograma(sh."' . OrganogramaHistorico::DATA_INICIO . '") s'), DBLayer::raw('sh."' . OrganogramaHistorico::ID_PAI . '"'), '=', DBLayer::raw('s."' . OrganogramaHistorico::KEY_ID . '"'))
            ->where('sh.' . OrganogramaHistorico::KEY_ID, '=', $idOrganograma)
            ->orderBy('sh.dataInicio')
            ;

        //print_r($result);

        return $query->get();
    }

    public function ConsultaNumeroLei($valor)
    {
        //traz o ano mais recente com o numero da Lei informada
        $result = null;

        $conditions = array("numeroLei" => $valor);
        $result = $this->db->Select(OrganogramaHistorico::TABLE_NAME, null, $conditions, OrganogramaHistorico::getClassName(), 'ORDER BY "anoLei" DESC');


        return $result;
    }
}