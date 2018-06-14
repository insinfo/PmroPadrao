<?php
/**
 * Created by PhpStorm.
 * User: isaque
 * Date: 03/04/2018
 * Time: 11:09
 */

namespace PmroPadraoLib\Controller;


use PmroPadraoLib\Model\DAL;
use PmroPadraoLib\Model\DAL\TelefoneDAL;
use PmroPadraoLib\Model\DAL\EnderecoPessoaDAL;
use PmroPadraoLib\Model\DAL\BairroDAL;
use PmroPadraoLib\Model\DAL\PessoaDAL;
use PmroPadraoLib\Model\DAL\PessoaJuridicaDAL;
use PmroPadraoLib\Model\DAL\PaisDAL;
use PmroPadraoLib\Model\DAL\UFDAL;
use PmroPadraoLib\Model\DAL\MunicipioDAL;
use PmroPadraoLib\Model\DAL\PessoaFisicaDAL;
use PmroPadraoLib\Model\DAL\EnderecoDAL;

use PmroPadraoLib\Model\VO\Bairro;
use PmroPadraoLib\Model\VO\Endereco;
use PmroPadraoLib\Model\VO\EnderecoPessoa;
use PmroPadraoLib\Model\VO\Pessoa;
use PmroPadraoLib\Model\VO\PessoaJuridica;
use PmroPadraoLib\Model\VO\PessoaFisica;
use PmroPadraoLib\Model\VO\Telefone;
use PmroPadraoLib\Model\VO\Pais;
use PmroPadraoLib\Model\VO\UF;

use PmroPadraoLib\Util\Exceptions\NoInternetException;
use PmroPadraoLib\Util\StatusCode;
use PmroPadraoLib\Util\StatusMessage;
use PmroPadraoLib\Util\Correios;
use PmroPadraoLib\Model\BLL\ServiceCGM;
use PmroPadraoLib\Util\DBHandle;
use PmroPadraoLib\Util\Utils;
use Exception;

class UtilController
{
    //Retorna array de todos os paises em JSON
    public static function getAllPaises()
    {
        $dal = new PaisDAL();
        return $dal->ListarTodos('array');
    }

    //Retorna array de estados baseado em id de pais
    public static function getAllUFs($params)
    {
        $conditions = $params;
        if ($conditions == null) {
            throw new Exception(StatusMessage::$REQUIRED_PARAMETERS, StatusCode::$BAD_REQUEST);
        }
        $dal = new UFDAL();
        return $dal->ListarByFilter($conditions, 'array');
    }

    //Retorna array de municipios  baseado em id estado
    public static function getAllMunicipios($params)
    {
        $result = null;
        $conditions = $params;
        if ($conditions == null) {
            throw new Exception(StatusMessage::$REQUIRED_PARAMETERS, StatusCode::$BAD_REQUEST);
        }

        $dal = new MunicipioDAL();
        return $dal->ListarByFilter($conditions, 'array');
    }

    /** Obtem o endereço atraves do CEP em JSON**/
    public static function getEnderecoByCep($cep)
    {
        return Correios::GetEndereco($cep);
    }

    /** retorna JSON para um DataTable contendo os CEPs a partir de um endereco**/
    public static function getCepByEndereco($param)
    {
        $draw = $param['draw'];
        $length = $param['length'];
        $start = $param['start'];
        $endereco2 = $param['endereco'];
        if ($length >= 100) {
            $length = 50;
        }

        if (empty($endereco2)) {
            throw new Exception('O logradouro não pode ser vazio', 400);
        }

        return Correios::GetCEPVersion2($endereco2, $start + 1, $draw, $length);

    }


}