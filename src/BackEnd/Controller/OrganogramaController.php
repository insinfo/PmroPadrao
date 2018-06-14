<?php
/**
 * Created by PhpStorm.
 * User: Isaque
 * Date: 24/08/2017
 * Time: 16:48
 */

namespace PmroPadraoLib\Controller;

use PmroPadraoLib\Util\DBLayer;
use PmroPadraoLib\Model\DAL\OrganogramaDAL;
use PmroPadraoLib\Model\VO\Organograma;

use PmroPadraoLib\Model\DAL\OrganogramaHistoricoDAL;
use PmroPadraoLib\Model\VO\OrganogramaHistorico;

class OrganogramaController
{
    const JSON_FORMAT = 'json';
    const ARRAY_ASSOC_FORMAT = 'array';
    //const ARRAY_NUM_FORMAT = 'arrayNum';
    const ARRAY_OBJECT = 'object';

    public static function getAllSecretarias($pData = null)
    {
        if ($pData == null) {
            date_default_timezone_set('America/Sao_Paulo');
            $pData = date('d/m/Y');
        }
        $setorDAL = new OrganogramaDAL();
        return $setorDAL->ListarSecretarias($pData);
    }
    //obtem a arvore de organograma
    public static function getHierarquia($pData = null)
    {
        if ($pData == null) {
            date_default_timezone_set('America/Sao_Paulo');
            $pData = date('d/m/Y');
        }
        $setorDAL = new OrganogramaDAL();
        return $setorDAL->ListarTodosByData($pData);
    }
    //obtem a arvore de organogramas filhos
    public static function getAllChildren($idPai = null, $pData = null)
    {
        if ($pData == null) {
            date_default_timezone_set('America/Sao_Paulo');
            $pData = date('d/m/Y');
        }
        $setorDAL = new OrganogramaDAL();
        return $setorDAL->ListarSetoresFilhosByData($idPai, $pData);
    }

    public static function save($data, $historico)
    {
        $organograma = new Organograma();
        $organograma->fillFromArray($data);
        $setorDAL = new OrganogramaDAL();
        //$setorDAL->Incluir($organograma);

        if(!isset($historico['idOrganograma']))
        {
            //recuperar ID para relacionar no historico_organograma
            $idOrganograma = DBLayer::Connect()->table(Organograma::TABLE_NAME)->insertGetId($data);
            //print_r($historico);
        }

        if(isset($historico))
        {
            //se existir idOrganograma => gravar um novo setor. Senao apenas criar um historico para um setor existente(que apenas alterou o nome)
            if(isset($idOrganograma))
                $historico['idOrganograma'] = $idOrganograma;

            //print_r($historico);
            $orgHistorico = new OrganogramaHistorico();
            $orgHistorico->fillFromArray($historico);
            $historicoDAL = new OrganogramaHistoricoDAL();
            //print_r($orgHistorico);
            $historicoDAL->Incluir($orgHistorico);
        }
    }

    public static function update($data, $historico)
    {
        $organograma = new Organograma();
        $organograma->fillFromArray($data);
        $setorDAL = new OrganogramaDAL();
        $setorDAL->Alterar($organograma);

        $orgHistorico = new OrganogramaHistorico();
        $orgHistorico->fillFromArray($historico);
        $historicoDAL = new OrganogramaHistoricoDAL();
        $historicoDAL->Alterar($orgHistorico);
    }

    //obtem o historico de nomes de um determinado setor
    public static function getHistoricoOrganograma($idPai = null, $pData = null)
    {
        if ($pData == null) {
            date_default_timezone_set('America/Sao_Paulo');
            $pData = date('d/m/Y');
        }
        $historicoDAL = new OrganogramaHistoricoDAL();
        return $historicoDAL->ConsultarHistorico($idPai);
    }

    public static function getNumeroLei($numeroLei)
    {
        $historicoDAL = new OrganogramaHistoricoDAL();
        return $historicoDAL->ConsultaNumeroLei($numeroLei);
    }
}