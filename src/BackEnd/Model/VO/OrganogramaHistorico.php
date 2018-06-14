<?php
/**
 * Created by PhpStorm.
 * User: Isaque
 * Date: 24/08/2017
 * Time: 16:12
 */

namespace PmroPadraoLib\Model\VO;
use \JsonSerializable;

class OrganogramaHistorico
{
    use \PmroPadraoLib\Util\TraitFillFromArray;
    const TABLE_NAME = "organograma_historico";
    const KEY_ID = "idOrganograma";
    const DATA_INICIO = "dataInicio";
    const SIGLA = "sigla";
    const NOME = "nome";
    const NUMERO_LEI = "numeroLei";
    const IS_OFICIAL = "isOficial";
    const ANO_LEI = "anoLei";
    const DATA_DIARIO = "dataDiario";
    const NUMERO_DIARIO = "numeroDiario";
    const ID_PAI = "idPai";

    public $idOrganograma;
    public $dataInicio;
    public $sigla;
    public $nome;
    public $numeroLei;
    public $isOficial;
    public $anoLei;
    public $dataDiario;
    public $numeroDiario;
    public $idPai;

    /**
     * @return mixed
     */
    public function getIdOrganograma()
    {
        return $this->idOrganograma;
    }

    /**
     * @param mixed $idOrganograma
     */
    public function setIdOrganograma($idOrganograma)
    {
        $this->idOrganograma = $idOrganograma;
    }

    /**
     * @return mixed
     */
    public function getDataInicio()
    {
        return $this->dataInicio;
    }

    /**
     * @param mixed $dataInicio
     */
    public function setDataInicio($dataInicio)
    {
        $this->dataInicio = $dataInicio;
    }

    /**
     * @return mixed
     */
    public function getSigla()
    {
        return $this->sigla;
    }

    /**
     * @param mixed $sigla
     */
    public function setSigla($sigla)
    {
        $this->sigla = $sigla;
    }

    /**
     * @return mixed
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @param mixed $nome
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    /**
     * @return mixed
     */
    public function getNumeroLei()
    {
        return $this->numeroLei;
    }

    /**
     * @param mixed $numeroLei
     */
    public function setNumeroLei($numeroLei)
    {
        $this->numeroLei = $numeroLei;
    }

    /**
     * @return mixed
     */
    public function getIsOficial()
    {
        return $this->isOficial;
    }

    /**
     * @param mixed $isOficial
     */
    public function setIsOficial($isOficial)
    {
        $this->isOficial = $isOficial;
    }

    /**
     * @return mixed
     */
    public function getAnoLei()
    {
        return $this->anoLei;
    }

    /**
     * @param mixed $anoLei
     */
    public function setAnoLei($anoLei)
    {
        $this->anoLei = $anoLei;
    }

    /**
     * @return mixed
     */
    public function getDataDiario()
    {
        return $this->dataDiario;
    }

    /**
     * @param mixed $dataDiario
     */
    public function setDataDiario($dataDiario)
    {
        $this->dataDiario = $dataDiario;
    }

    /**
     * @return mixed
     */
    public function getNumeroDiario()
    {
        return $this->numeroDiario;
    }

    /**
     * @param mixed $numeroDiario
     */
    public function setNumeroDiario($numeroDiario)
    {
        $this->numeroDiario = $numeroDiario;
    }

    /**
     * @return mixed
     */
    public function getIdPai()
    {
        return $this->idPai;
    }

    /**
     * @param mixed $numeroDiario
     */
    public function setIdPai($idPai)
    {
        $this->idPai = $idPai;
    }



    public static function getClassName()
    {
        return get_called_class();
    }


}