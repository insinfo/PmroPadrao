<?php
/**
 * Created by PhpStorm.
 * User: Isaque
 * Date: 24/08/2017
 * Time: 16:08
 */

namespace PmroPadraoLib\Model\VO;
use \JsonSerializable;

class Organograma extends OrganogramaHistorico
{
    use \PmroPadraoLib\Util\TraitFillFromArray;
    const TABLE_NAME = "organograma";
    const KEY_ID = "id";
    const ID_PAI = "idPai";
    const COR = "cor";
    const ATIVO = "ativo";

    public $id;
    public $idPai;
    public $cor;
    public $ativo;
    public $setoresFilhos;

    /**
     * @return mixed
     */
    public function getSetoresFilhos()
    {
        return $this->setoresFilhos;
    }

    /**
     * @param mixed $setoresFilhos
     */
    public function setSetoresFilhos($setoresFilhos)
    {
        $this->setoresFilhos = $setoresFilhos;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getIdPai()
    {
        return $this->idPai;
    }

    /**
     * @param mixed $idPai
     */
    public function setIdPai($idPai)
    {
        $this->idPai = $idPai;
    }

    /**
     * @return mixed
     */
    public function getCor()
    {
        return $this->cor;
    }

    /**
     * @param mixed $cor
     */
    public function setCor($cor)
    {
        $this->cor = $cor;
    }

    /**
     * @return mixed
     */
    public function getAtivo()
    {
        return $this->ativo;
    }

    /**
     * @param mixed $ativo
     */
    public function setAtivo($ativo)
    {
        $this->ativo = $ativo;
    }


    public static function getClassName()
    {
        return get_called_class();
    }

}