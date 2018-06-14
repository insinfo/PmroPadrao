<?php
/**
 * Created by PhpStorm.
 * User: Isaque
 * Date: 20/07/2017
 * Time: 15:17
 */

namespace PmroPadraoLib\Model\DAL;

use PmroPadraoLib\Model\VO\Organograma;
use PmroPadraoLib\Model\VO\OrganogramaHistorico;
use PmroPadraoLib\Util\ContentValues;
use PmroPadraoLib\Util\DBHandle;
use PDOException;
use Exception;

class OrganogramaDAL
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
     * @param Organograma $object
     * @return integer $id
     * @throws Exception exceção generica
     **/
    public function Incluir(Organograma $object)
    {
        $result = null;

        $cv = new ContentValues;
        $cv->put($object::ID_PAI, $object->getIdPai());
        $cv->put($object::COR, $object->getCor());
        $cv->put($object::ATIVO, $object->getAtivo());

        $result = $this->db->Insert($object::TABLE_NAME, $cv);

        return $result;
    }

    /**
     * Função para alterar registro da tabela
     * @access public
     * @param Organograma $object
     * @return void
     * @throws Exception exceção generica
     **/
    public function Alterar(Organograma $object)
    {

        $cv = new ContentValues;
        $cv->put($object::ID_PAI, $object->getIdPai());
        $cv->put($object::COR, $object->getCor());
        $cv->put($object::ATIVO, $object->getAtivo());

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

        $this->db->Delete(Organograma::TABLE_NAME, Organograma::KEY_ID . "=" . $id);

    }

    /**
     * Função para retornar um registro da tabela enderecoPessoa
     * @access public
     * @param integer $id
     * @return Organograma
     * @throws Exception exceção generica
     **/
    public function Consultar($id)
    {
        $result = null;

        $conditions = array(Organograma::KEY_ID => $id);
        $result = $this->db->Select(Organograma::TABLE_NAME, null, $conditions, Organograma::getClassName());

        return $result;
    }

    /**
     * Função para retornar um registro da tabela enderecoPessoa
     * filtrado por campo/valor
     * @access public
     * @param  string $campo
     * @param  string $valor
     * @return Organograma
     * @throws Exception exceção generica
     **/
    public function ConsultarPorCampo($campo, $valor)
    {
        $result = null;

        $conditions = array($campo => $valor);
        $result = $this->db->Select(Organograma::TABLE_NAME, null, $conditions, Organograma::getClassName());

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
        $advOptions = 'ORDER BY ' . Organograma::KEY_ID . ' ASC' . ' ' . $lim;
        $retType = null;
        if ($returnType == 'object')
        {
            $retType = Organograma::getClassName();
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

        $result = $this->db->SelectAll(Organograma::TABLE_NAME, null, null, $retType, $advOptions);

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
        $advOptions = 'ORDER BY ' . Organograma::KEY_ID . ' ASC' . ' ' . $lim;
        $retType = null;
        if ($returnType == 'object')
        {
            $retType = Organograma::getClassName();
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

        $result = $this->db->SelectAll(Organograma::TABLE_NAME, null, $conditions, $retType, $advOptions);

        return $result;
    }

    public function GetAllSetoresInObjects($pData)
    {
        return $this->getSetoresFilhosInObjects(null, $pData);
    }

    public function GetSetoresFilhosInObjects($pId, $pData)
    {
        $lista = new \ArrayObject();
        $idPai = '';
        if ($pId == null)
        {
            $idPai = 'is NULL';
        }
        else
        {
            $idPai = '=' . $pId;
        }

        $query = '';
        $query .= ' SELECT * FROM "' . Organograma::TABLE_NAME . '" s, "' . OrganogramaHistorico::TABLE_NAME . '" sh ';
        $query .= ' WHERE s."' . Organograma::KEY_ID . '" = sh."' . OrganogramaHistorico::KEY_ID . '" AND sh."' . Organograma::ID_PAI . '" ' . $idPai . ' ';
        $query .= ' AND sh."' . OrganogramaHistorico::DATA_INICIO . '" = (SELECT max("' . OrganogramaHistorico::DATA_INICIO . '") FROM "' . OrganogramaHistorico::TABLE_NAME . '" ';
        $query .= 'WHERE "' . OrganogramaHistorico::KEY_ID . '" = s."' . Organograma::KEY_ID . '" AND "' . OrganogramaHistorico::DATA_INICIO . '" <= ' . "'" . $pData . "')";
        $query .= "ORDER BY sh.nome";

        $result = $this->db->SelectRAW($query);

        if ($result != null)
        {
            foreach ($result as $value)
            {
                $idSetor = $value['idSetor'];
                $setor = new Organograma();
                $setor->setId($idSetor);
                $setor->setIdPai($value['idPai']);
                $setor->setCor($value['cor']);
                $setor->setAtivo($value['ativo']);
                $setor->setId($value['idHistorico']);
                $setor->setDataInicio($value['dataInicio']);
                $setor->setSigla($value['sigla']);
                $setor->setNome($value['nome']);

                $filhos = $this->listarSetoresFilhos($idSetor, $pData);
                if ($filhos->count() == 0)
                {
                    $filhos = null;
                }
                $setor->setSetoresFilhos($filhos);
                $lista->append($setor);
            }
        }
        return $lista;
    }

    public function ListarTodosByData($pData)
    {
        return $this->ListarSetoresFilhosByData(null, $pData);
    }

    public function ListarSetoresFilhosByData($pId, $pData)
    {
        $idPai = '';
        if ($pId == null)
        {
            $idPai = 'is NULL';
        }
        else
        {
            $idPai = '=' . $pId;
        }

        $query = '';
        $query .= ' SELECT * FROM "' . Organograma::TABLE_NAME . '" s, "' . OrganogramaHistorico::TABLE_NAME . '" sh ';
        $query .= ' WHERE s."' . Organograma::KEY_ID . '" = sh."' . OrganogramaHistorico::KEY_ID . '" AND sh."' . Organograma::ID_PAI . '" ' . $idPai . ' ';
        $query .= ' AND sh."' . OrganogramaHistorico::DATA_INICIO . '" = (SELECT max("' . OrganogramaHistorico::DATA_INICIO . '") FROM "' . OrganogramaHistorico::TABLE_NAME . '" ';
        $query .= 'WHERE "' . OrganogramaHistorico::KEY_ID . '" = s."' . Organograma::KEY_ID . '" AND "' . OrganogramaHistorico::DATA_INICIO . '" <= ' . "'" . $pData . "')";
        $query .= "ORDER BY sh.nome";

        $result = $this->db->SelectRAW($query);
        $lista = array();

        if ($result != null)
        {
            foreach ($result as $value)
            {
                $idSetor = $value[OrganogramaHistorico::KEY_ID];
                $setor = array();
                $setor[OrganogramaHistorico::KEY_ID] = $idSetor;
                $setor[Organograma::ID_PAI] = $value[Organograma::ID_PAI];
                $setor[OrganogramaHistorico::DATA_INICIO] = $value[OrganogramaHistorico::DATA_INICIO];
                $sigla = $value[OrganogramaHistorico::SIGLA] ? $value[OrganogramaHistorico::SIGLA] . ' - ' : "";
                $setor['text'] = $sigla . $value[OrganogramaHistorico::NOME];
                $setor[OrganogramaHistorico::NOME] = $value[OrganogramaHistorico::NOME];
                $setor[OrganogramaHistorico::SIGLA] = $value[OrganogramaHistorico::SIGLA];

                $filhos = $this->ListarSetoresFilhosByData($idSetor, $pData);
                if ($filhos != null)
                {
                    $setor['nodes'] = $filhos;
                }
                array_push($lista, $setor);
            }
        }
        return $lista;
    }

    public function ListarSecretarias($pData)
    {

        $query = '';
        $query .= ' SELECT * FROM "' . Organograma::TABLE_NAME . '" s, "' . OrganogramaHistorico::TABLE_NAME . '" sh ';
        $query .= ' WHERE s."' . Organograma::KEY_ID . '" = sh."' . OrganogramaHistorico::KEY_ID . '" AND sh."' . Organograma::ID_PAI . '" is null ';
        $query .= ' AND sh."' . OrganogramaHistorico::DATA_INICIO . '" = (SELECT max("' . OrganogramaHistorico::DATA_INICIO . '") FROM "' . OrganogramaHistorico::TABLE_NAME . '" ';
        $query .= 'WHERE "' . OrganogramaHistorico::KEY_ID . '" = s."' . Organograma::KEY_ID . '" AND "' . OrganogramaHistorico::DATA_INICIO . '" <= ' . "'" . $pData . "')";
        $query .= "ORDER BY sh.nome";

        $result = $this->db->SelectRAW($query);

        foreach ($result as &$value)
        {
            $value['text'] = $value[OrganogramaHistorico::SIGLA] . ' - ' . $value[OrganogramaHistorico::NOME];
        }
        return $result;
    }

}
