<?php
/**
 * Created by PhpStorm.
 * User: Isaque
 * Date: 14/07/2017
 * Time: 11:22
 */

namespace PmroPadraoLib\Model\VO;

class PessoaJuridica extends Pessoa
{
    use \PmroPadraoLib\Util\TraitFillFromArray;

    const TABLE_NAME = "pessoas_juridicas";
    const ID_PESSOA = "idPessoa";
    const CNPJ = "cnpj";
    const NOME_FANTASIA = "nomeFantasia";
    const INSCRICAO_ESTADUAL = "inscricaoEstadual";

    const DISPLAY_NAMES =
        [
            'cnpj' => 'CNPJ',
            'nomeFantasia' => 'Nome Fantasia',
            'inscricaoEstadual' => 'Inscricão Estadual',
            'nome' => 'Nome',
            'emailPrincipal' => 'E-mail'
        ];

    public $idPessoa;
    public $cnpj;
    public $nomeFantasia;
    public $inscricaoEstadual;

    /*public function fillFromArray($pessoaDataArray)
    {
        if($pessoaDataArray != null)
        {
            foreach ($pessoaDataArray as $key => $val)
            {
                if (property_exists(__CLASS__, $key))
                {
                    $method="set".ucfirst($key);
                    $this->$method($val);
                }
            }
        }
    }*/

    public function getCnpj()
    {
        return $this->cnpj;
    }

    public function setCnpj($cnpj)
    {
        $this->cnpj = $cnpj;
    }

    /**
     * @return mixed
     */
    public function getIdPessoa()
    {
        return $this->idPessoa;
    }

    /**
     * @param mixed $idPessoa
     */
    public function setIdPessoa($idPessoa)
    {
        $this->idPessoa = $idPessoa;
    }

    /**
     * @return mixed
     */
    public function getNomeFantasia()
    {
        return $this->nomeFantasia;
    }

    /**
     * @param mixed $nomeFantasia
     */
    public function setNomeFantasia($nomeFantasia)
    {
        $this->nomeFantasia = $nomeFantasia;
    }

    /**
     * @return mixed
     */
    public function getInscricaoEstadual()
    {
        return $this->inscricaoEstadual;
    }

    /**
     * @param mixed $inscricaoEstadual
     */
    public function setInscricaoEstadual($inscricaoEstadual)
    {
        $this->inscricaoEstadual = $inscricaoEstadual;
    }


    public static function getClassName()
    {
        return get_called_class();
    }
}

