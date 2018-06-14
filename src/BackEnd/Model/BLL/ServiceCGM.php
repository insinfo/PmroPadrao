<?php
/**
 * Created by PhpStorm.
 * User: Isaque
 * Date: 16/08/2017
 * Time: 11:48
 */

namespace PmroPadraoLib\Model\BLL;

use PmroPadraoLib\Util\DBHandle;
use PDOException;
use Exception;
use PmroPadraoLib\Util\Exceptions\NoContentException;

class ServiceCGM
{
    private $db = null;
    private $tableNameFisica = 'sw_cgm_pessoa_fisica';
    private $tableNameJuridica = 'sw_cgm_pessoa_juridica';
    private $colFilterFisica = 'cpf';//
    private $colFilterJuridica = 'cnpj';
    private $colRequired = 'numcgm';//Numero do CGM
    private $schemaName = 'public';//nome do esquema
    private $conectionName = 'saliProducao';//nome da conexão de banco de dados configurada no arquivo DBConfig

    function __construct()
    {
        $this->db = new DBHandle();
        $this->db->Connect($this->conectionName);
        $this->db->SetScheme($this->schemaName);
    }

    public function Buscar($cpfCnpj, $tipoPessoa)
    {
        $result = null;

        if (strtolower($tipoPessoa) == 'fisica') {
            $conditions = array($this->colFilterFisica => $cpfCnpj);
            $fields = array();
            $fields[] = $this->colRequired;
            $re = $this->db->Select($this->tableNameFisica, $fields, $conditions);
            if ($re == null) {
                return null;
            }
            $result = $re[$this->colRequired];
        } else {
            $conditions = array($this->colFilterJuridica => $cpfCnpj);
            $fields = array();
            $fields[] = $this->colRequired;
            $re = $this->db->Select($this->tableNameJuridica, $fields, $conditions);
            if ($re == null) {
                return null;
            }
            $result = $re[$this->colRequired];
        }

        return $result;
    }
}