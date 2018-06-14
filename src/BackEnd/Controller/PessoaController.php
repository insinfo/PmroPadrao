<?php
/**
 * Created by PhpStorm.
 * User: Isaque
 * Date: 20/07/2017
 * Time: 16:12
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
use PmroPadraoLib\Util\DBLayer;
use PmroPadraoLib\Util\DBConfig;
use \PDO;
use PmroPadraoLib\Model\VO\Constants;

class PessoaController
{
    const JSON_FORMAT = 'json';
    const ARRAY_ASSOC_FORMAT = 'array';
    //const ARRAY_NUM_FORMAT = 'arrayNum';
    const ARRAY_OBJECT = 'object';

    //salva uma pessoa no banco
    public static function save($responseArray, PDO $pdoInstance = null)
    {
        //evita exiber noticia Notice: Undefined offset
        //error_reporting(E_ALL ^ E_NOTICE ^ E_STRICT ^ E_DEPRECATED);
        $dbHandle = new DBHandle();

        if ($pdoInstance != null) {
            $dbHandle->Connect(DBConfig::DEFAULT_CONNECTION, $pdoInstance);
        } else {
            $dbHandle->Connect();
            $dbHandle->Begin();
        }

        $imageNova = null;
        try {
            $tipoPessoa = trim(strtolower($responseArray['tipo']));

            $pessoa = null;
            $idPessoa = null;

            $serviceCGM = new ServiceCGM();

            //1º salva pessoa
            if ($tipoPessoa == 'fisica') {

                $cpf = $responseArray['cpf'];
                //checar se ja existe
                if(self::isExistFisica($cpf,$pdoInstance) != null){
                    throw new Exception("Esta pessoa já esta cadastrada");
                }

                $cgm = null;
                if ($cpf != '') {
                    $cgm = $serviceCGM->Buscar($cpf, $tipoPessoa);
                }

                $pessoa = new PessoaFisica();

                if(array_key_exists('idPessoa',$responseArray)){
                    unset($responseArray['idPessoa']);
                }

                $responseArray['cgm'] =$cgm;
                //populate o objeto PessoaFisica com os dados novos
                $pessoa->fillFromArray($responseArray);

                //se o parametro imagem for passado
                if (isset($responseArray['imagem'])) {

                    $imageDataURI = $responseArray['imagem'];
                    //check se os dados são validos
                    if (Utils::isDataURI($imageDataURI)) {

                        //salva a imagem da pessoa
                        $imageNova = Utils::base64ToJpegFileSave($imageDataURI, Constants::PROFILE_IMAGE_PATH_FULL);
                        $pessoa->setImagem(Constants::PROFILE_IMAGE_WEB_PATH . $imageNova);
                    }else {
                        $pessoa->setImagem('/cdn/Assets/icons/userNoImage.jpg');
                    }
                }

                $pessoaDAl = new PessoaFisicaDAL($dbHandle);
                $idPessoa = $pessoaDAl->Incluir($pessoa);

            } else if ($tipoPessoa == 'juridica') {

                $cnpj = $responseArray['cnpj'];

                //checar se ja existe
                if(self::isExistJuridica($cnpj,$pdoInstance) != null){
                    throw new Exception("Esta pessoa já esta cadastrada");
                }

                $cgm = null;
                if ($cnpj != '') {
                    $cgm = $serviceCGM->Buscar($cnpj, $tipoPessoa);
                }

                $pessoa = new PessoaJuridica();
                $responseArray['cgm'] = $cgm;

                $pessoa->fillFromArray($responseArray);

                //se o parametro imagem for passado
                if (isset($responseArray['imagem'])) {

                    $imageDataURI = $responseArray['imagem'];
                    //check se os dados são validos
                    if (Utils::isDataURI($imageDataURI)) {

                        //salva a imagem da pessoa
                        $imageNova = Utils::base64ToJpegFileSave($imageDataURI, Constants::PROFILE_IMAGE_PATH_FULL);
                        $pessoa->setImagem(Constants::PROFILE_IMAGE_WEB_PATH . $imageNova);
                    }else {
                        $pessoa->setImagem('/cdn/Assets/icons/userNoImage.jpg');
                    }
                }

                $pessoaDAl = new PessoaJuridicaDAL($dbHandle);
                $idPessoa = $pessoaDAl->Incluir($pessoa);
            }

            //2º salva telefones
            $arrayTelefones = $responseArray['telefones'];
            if ($arrayTelefones != null) {

                $telefoneDAL = new TelefoneDAL($dbHandle);

                foreach ($arrayTelefones as $value) {

                    $telefone = new Telefone();
                    $telefone->setNumero($value['numeroTelefone']);
                    $telefone->setTipo($value['tipoTelefone']);
                    $telefone->setIdPessoa($idPessoa);
                    $telefoneDAL->Incluir($telefone);
                }
            }

            //3º salva endereços
            $arrayEnderecos = $responseArray['enderecos'];
            if ($arrayEnderecos != null) {
                $bairroDAL = new BairroDAL($dbHandle);
                $enderecoDAL = new EnderecoDAL($dbHandle);
                $enderecoPessoaDAL = new EnderecoPessoaDAL($dbHandle);
                foreach ($arrayEnderecos as $value) {
                    $cep = $value['cep'];

                    $bairro = new Bairro();
                    $bairro->setNome($value['bairro']);
                    $bairro->setIdMunicipio($value['municipio']);

                    //checa se o bairro existe se não existir faz um insert
                    $idBairro = $bairroDAL->SeExisteByNomeAndMunicipio($value['bairro'], $value['municipio']);

                    if ($idBairro == null) {
                        $idBairro = $bairroDAL->Incluir($bairro);
                    }

                    //checa se o endereço existe se não existir faz um insert
                    $idEndereco = $enderecoDAL->SeExisteBy($value['logradouro'], $idBairro, $cep);

                    if ($idEndereco == null) {

                        $endereco = new Endereco();
                        $endereco->setCep($cep);
                        $endereco->setIdBairro($idBairro);
                        $endereco->setIdMunicipio($value['municipio']);
                        $endereco->setIdUf($value['uf']);
                        $endereco->setIdPais($value['pais']);
                        $endereco->setLogradouro($value['logradouro']);
                        $endereco->setValidacao($value['validacao'] === true ? 't' : 'f');
                        $endereco->setDivergente($value['divergente'] === true ? 't' : 'f');
                        $endereco->setTipoLogradouro($value['tipoLogradouro']);
                        $idEndereco = $enderecoDAL->Incluir($endereco);
                    }

                    $enderecoPessoa = new EnderecoPessoa();
                    $enderecoPessoa->setIdPessoa($idPessoa);
                    $enderecoPessoa->setComplemento($value['complemento']);
                    $enderecoPessoa->setIdEndereco($idEndereco);
                    $enderecoPessoa->setNumero($value['numeroLogradouro']);
                    $enderecoPessoa->setTipo($value['tipoEndereco']);

                    $enderecoPessoaDAL->Incluir($enderecoPessoa);
                }
            }

            if ($pdoInstance == null) {
                $dbHandle->End();
            }
            return $idPessoa;
        } catch (Exception $e) {
            if ($pdoInstance == null) {
                $dbHandle->RollBack();
            }
            //deleta imagem
            if (isset($responseArray['imagem'])) {
                Utils::deleteFile(Constants::PMRO_PADRAO_PATH_FULL . Constants::PROFILE_IMAGE_WEB_PATH . $imageNova);
            }
            throw $e;
        }
    }

    //atualiza uma pessoa no banco
    public static function update($responseArray, \PDO $pdoInstance = null)
    {
        //evita exiber noticia Notice: Undefined offset
        //error_reporting(E_ALL ^ E_NOTICE ^ E_STRICT ^ E_DEPRECATED);
        $dbHandle = new DBHandle();

        if ($pdoInstance != null) {
            $dbHandle->Connect(DBConfig::DEFAULT_CONNECTION, $pdoInstance);
        } else {
            $dbHandle->Connect();
            $dbHandle->Begin();
        }

        $imagemAntiga = null;
        $imageNova = null;

        try {
            $tipoPessoa = trim(strtolower($responseArray['tipo']));

            $pessoa = null;
            $idPessoa = $responseArray['idPessoa'];

            $serviceCGM = new ServiceCGM();

            //1º salva pessoa
            if ($tipoPessoa == 'fisica') {
                $cpf = $responseArray['cpf'];
                $cgm = null;
                if ($cpf != '') {
                    $cgm = $serviceCGM->Buscar($cpf, $tipoPessoa);
                }

                //acessa o banco pra pegar as informações antigas da pessoa fisica
                $pessoaDAl = new PessoaFisicaDAL($dbHandle);
                $pessoaOld = $pessoaDAl->ConsultarPorCampo(Pessoa::KEY_ID_PESSOA, $idPessoa, 'array');
                $imagemAntiga = $pessoaOld[Pessoa::IMAGEM];

                $pessoa = new PessoaFisica();
                //populate o objeto PessoaFisica com os dados antigos
                $pessoa->fillFromArray($pessoaOld);

                $responseArray['idPessoa'] =$idPessoa;
                $responseArray['id'] =$idPessoa;
                $responseArray['cgm'] =$cgm;

                //populate o objeto PessoaFisica com os dados novos
                $pessoa->fillFromArray($responseArray);

                //se o parametro imagem for passado
                if (isset($responseArray['imagem'])) {

                    $imageDataURI = $responseArray['imagem'];
                    //check se os dados são validos
                    if (Utils::isDataURI($imageDataURI)) {

                        //salva a imagem da pessoa
                        $imageNova = Utils::base64ToJpegFileSave($imageDataURI, Constants::PROFILE_IMAGE_PATH_FULL);
                        $pessoa->setImagem(Constants::PROFILE_IMAGE_WEB_PATH . $imageNova);
                    }else{
                        $pessoa->setImagem($imagemAntiga);
                    }
                }
                //salva as alterações
                $pessoaDAl->Alterar($pessoa);

            } else if ($tipoPessoa == 'juridica') {

                $cnpj = $responseArray['cnpj'];
                $cgm = null;
                if ($cnpj != '') {
                    $cgm = $serviceCGM->Buscar($cnpj, $tipoPessoa);
                }

                //acessa o banco pra pegar as informações antigas da pessoa fisica
                $pessoaDAl = new PessoaJuridicaDAL($dbHandle);
                $pessoaOld = $pessoaDAl->ConsultarPorCampo(Pessoa::KEY_ID_PESSOA, $idPessoa, 'array');
                $imagemAntiga = $pessoaOld[Pessoa::IMAGEM];

                $pessoa = new PessoaJuridica();
                //populate o objeto PessoaFisica com os dados antigos
                $pessoa->fillFromArray($pessoaOld);

                $responseArray['idPessoa'] =$idPessoa;
                $responseArray['id'] = $idPessoa;
                $responseArray['cgm'] = $cgm;
                $responseArray['cnpj'] = $cnpj;

                //populate o objeto PessoaFisica com os dados novos
                $pessoa->fillFromArray($responseArray);

                //se o parametro imagem for passado
                if (isset($responseArray['imagem'])) {

                    $imageDataURI = $responseArray['imagem'];
                    //check se os dados são validos
                    if (Utils::isDataURI($imageDataURI)) {

                        //salva a imagem da pessoa
                        $imageNova = Utils::base64ToJpegFileSave($imageDataURI, Constants::PROFILE_IMAGE_PATH_FULL);
                        $pessoa->setImagem(Constants::PROFILE_IMAGE_WEB_PATH . $imageNova);
                    }else{
                        $pessoa->setImagem($imagemAntiga);
                    }
                }
                //salva as alterações
                $pessoaDAl->Alterar($pessoa);
            }

            //2º salva telefones
            $arrayTelefones = $responseArray['telefones'];
            if ($arrayTelefones != null) {
                $telefoneDAL = new TelefoneDAL($dbHandle);
                $telefoneDAL->DeleteByIdPessoa($idPessoa);

                foreach ($arrayTelefones as $value) {
                    $telefone = new Telefone();
                    $telefone->setNumero($value['numeroTelefone']);
                    $telefone->setTipo($value['tipoTelefone']);
                    $telefone->setIdPessoa($idPessoa);
                    $telefoneDAL->Incluir($telefone);
                }
            }

            //3º salva endereços
            $arrayEnderecos = $responseArray['enderecos'];
            if ($arrayEnderecos != null) {
                $bairroDAL = new BairroDAL($dbHandle);
                $enderecoDAL = new EnderecoDAL($dbHandle);
                $enderecoPessoaDAL = new EnderecoPessoaDAL($dbHandle);
                $enderecoPessoaDAL->DeleteByIdPessoa($idPessoa);

                foreach ($arrayEnderecos as $value) {
                    $cep = $value['cep'];

                    $bairro = new Bairro();
                    $bairro->setNome($value['bairro']);
                    $bairro->setIdMunicipio($value['municipio']);

                    //checa se o bairro existe se não existir faz um insert
                    $idBairro = $bairroDAL->SeExisteByNomeAndMunicipio($value['bairro'], $value['municipio']);

                    if ($idBairro == null) {
                        $idBairro = $bairroDAL->Incluir($bairro);
                    }

                    //checa se o endereço existe se não existir faz um insert
                    $idEndereco = $enderecoDAL->SeExisteBy($value['logradouro'], $idBairro, $cep);

                    if ($idEndereco == null) {

                        $endereco = new Endereco();
                        $endereco->setCep($cep);
                        $endereco->setIdBairro($idBairro);
                        $endereco->setIdMunicipio($value['municipio']);
                        $endereco->setIdUf($value['uf']);
                        $endereco->setIdPais($value['pais']);
                        $endereco->setLogradouro($value['logradouro']);
                        $endereco->setValidacao($value['validacao']);
                        $endereco->setDivergente($value['divergente']);
                        $endereco->setTipoLogradouro($value['tipoLogradouro']);
                        $idEndereco = $enderecoDAL->Incluir($endereco);
                    }

                    $enderecoPessoa = new EnderecoPessoa();
                    $enderecoPessoa->setIdPessoa($idPessoa);
                    $enderecoPessoa->setComplemento($value['complemento']);
                    $enderecoPessoa->setIdEndereco($idEndereco);
                    $enderecoPessoa->setNumero($value['numeroLogradouro']);
                    $enderecoPessoa->setTipo($value['tipoEndereco']);

                    $enderecoPessoaDAL->Incluir($enderecoPessoa);
                }
            }

            if ($pdoInstance == null) {
                $dbHandle->End();
            }
            //deleta imagem/foto antiga da pessoa se o parametro imagem for passado e for valido
            if (isset($responseArray['imagem'])) {
                if(Utils::isDataURI($responseArray['imagem'])) {
                    Utils::deleteFile(Constants::PMRO_PADRAO_PATH_FULL . $imagemAntiga);
                }
            }

        } catch (Exception $e) {
            if ($pdoInstance == null) {
                $dbHandle->RollBack();
            }
            if (isset($responseArray['imagem'])) {
                if(Utils::isDataURI($responseArray['imagem'])) {
                    Utils::deleteFile(Constants::PMRO_PADRAO_PATH_FULL . Constants::PROFILE_IMAGE_WEB_PATH . $imageNova);
                }
            }
            throw $e;
        }
    }

    //obtem uma pessoa do banco
    public static function get($responseArray)
    {
        $tipoPessoa = trim(strtolower($responseArray['tipo']));
        $idPessoa = $responseArray['id'];
        $result = array();

        if ($tipoPessoa == 'fisica') {
            $pessoaDAl = new PessoaFisicaDAL();
            $result = $pessoaDAl->Consultar($idPessoa, 'array');

            /*$result['dataNascimento'] = $result['dataNascimento'];
            $result['dataEmissao'] = $result['dataEmissao'];*/
        } else {
            $pessoaDAl = new PessoaJuridicaDAL();
            $result = $pessoaDAl->Consultar($idPessoa, 'array');
        }

        $telefoneDAL = new TelefoneDAL();
        $result['telefones'] = $telefoneDAL->ListarPorCampo(Telefone::ID_PESSOA, $idPessoa, 'array');

        $enderecoPessoaDAL = new EnderecoPessoaDAL();
        $enderecoPessoa = $enderecoPessoaDAL->ListarPorCampo(EnderecoPessoa::ID_PESSOA, $idPessoa, 'array');


        $result['enderecos'] = array();

        foreach ($enderecoPessoa as $item) {
            $idEndereco = $item['idEndereco'];

            $enderecoDAL = new EnderecoDAL();
            $enderecoPessoaData = $enderecoDAL->ConsultarPorCampo(Endereco::KEY_ID, $idEndereco, 'array');

            $enderecoPessoaData['tipo'] = $item['tipo'];
            $enderecoPessoaData['numero'] = $item['numero'];
            $enderecoPessoaData['complemento'] = $item['complemento'];

            $idBairro = $enderecoPessoaData['idBairro'];
            $bairroDAL = new BairroDAL();
            $bairroData = $bairroDAL->ConsultarPorCampo(Bairro::KEY_ID, $idBairro, 'array');

            $enderecoPessoaData['bairro'] = $bairroData['nome'];

            array_push($result['enderecos'], $enderecoPessoaData);

        }
        return $result;
    }

    //lista pessoas para datatable
    public static function getAll($parameters)
    {
        $result = array();
        $tipoPessoa = strtolower(trim($parameters['tipo']));

        $start = $parameters['start'];
        $draw = $parameters['draw'];
        $length = $parameters['length'];

        $searchValue = is_array($parameters['search']) ? $parameters['search']['value'] : $parameters['search'];
        //parametros enviados
        //order[0]column order[0]dir search[value] length draw tipoPessoa

        $result['draw'] = '';
        $result['recordsTotal'] = '';
        $result['recordsFiltered'] = '';
        $result['data'] = array();
        $recordsTotal = 0;

        if ($tipoPessoa == 'fisica') {

            $conditions = array(
                Pessoa::NOME_PESSOA => $searchValue,
                PessoaFisica::CPF => $searchValue
            );

            $pessoaDAL = new PessoaFisicaDAL();
            $data = $pessoaDAL->ProcurarPorCampos($conditions, 'array', $length, $start, $recordsTotal);
            //pega os nomes das colunas
            if ($data) {
                $temp = array();
                $colunas = array_keys($data[0]);
                foreach ($colunas as $value) {
                    if (array_key_exists($value, PessoaFisica::DISPLAY_NAMES)) {
                        $temp[] = array('title' => PessoaFisica::DISPLAY_NAMES[$value], 'data' => $value);
                    }
                }
                $result['columns'] = $temp;
            }
            $result['data'] = $data !== null ? $data : [];

        } else {

            $conditions = array(Pessoa::NOME_PESSOA => $searchValue);
            $pessoaDAL = new PessoaJuridicaDAL();
            $data = $pessoaDAL->ProcurarPorCampos($conditions, 'array', $length, $start, $recordsTotal);
            //pega os nomes das colunas
            if ($data) {
                $temp = array();
                $colunas = array_keys($data[0]);
                foreach ($colunas as $value) {
                    if (array_key_exists($value, PessoaJuridica::DISPLAY_NAMES)) {
                        $temp[] = array('title' => PessoaJuridica::DISPLAY_NAMES[$value], 'data' => $value);
                    }
                }
                $result['columns'] = array_filter($temp);
            }
            $result['data'] = $data !== null ? $data : [];
        }

        //$recordsTotal = count($result['data']);
        $result['recordsTotal'] = $recordsTotal;
        $result['recordsFiltered'] = $recordsTotal;
        $result['draw'] = $draw;

        return $result;
    }

    public static function isExistFisica($cpf, \PDO $pdoInstance = null)
    {
        $dbHandle = new DBHandle();
        if ($pdoInstance != null) {
            $dbHandle->Connect(DBConfig::DEFAULT_CONNECTION, $pdoInstance);
        } else {
            $dbHandle->Connect();
        }

        $pessoaDAl = new PessoaFisicaDAL($dbHandle);
        $data = $pessoaDAl->ConsultarPorCampo(PessoaFisica::CPF,$cpf,'array');

        if ($data != null) {
            return $data[PessoaFisica::KEY_ID];
        }
        return null;
    }

    public static function isExistJuridica($cnpj, \PDO $pdoInstance = null)
    {
        $dbHandle = new DBHandle();
        if ($pdoInstance != null) {
            $dbHandle->Connect(DBConfig::DEFAULT_CONNECTION, $pdoInstance);
        } else {
            $dbHandle->Connect();
        }

        $pessoaDAl = new PessoaJuridicaDAL($dbHandle);
        $data = $pessoaDAl->ConsultarPorCampo(PessoaJuridica::CNPJ,$cnpj,'array');

        if ($data != null) {
            return $data[PessoaJuridica::ID_PESSOA];
        }
        return null;
    }

    public static function deleteByIds($idsPessoa, $tipoPessoa)
    {
        /*sequencia de delete
        pessoas_enderecos
        telefones
        pessoas_fisicas
        pessoa
        */

        $idsCount = count($idsPessoa);
        $itensDeletadosCount = 0;

        DBLayer::Connect();

        DBLayer::transaction(function () use (&$idsPessoa, $tipoPessoa, &$itensDeletadosCount) {

            foreach ($idsPessoa as $idPessoa) {

                //1º Deleta Endereço da Pessoa
                DBLayer::table(EnderecoPessoa::TABLE_NAME)
                    ->where(EnderecoPessoa::ID_PESSOA, '=', $idPessoa)->delete();

                //2º Deleta Telefone da Pessoa
                DBLayer::table(Telefone::TABLE_NAME)
                    ->where(Telefone::ID_PESSOA, '=', $idPessoa)->delete();

                if (strtolower(trim($tipoPessoa)) === 'fisica') {

                    //3º Deleta Pessoa fisica
                    DBLayer::table(PessoaFisica::TABLE_NAME)
                        ->where(PessoaFisica::KEY_ID, '=', $idPessoa)->delete();

                    //4º Deleta Pessoa
                    $deletePessoa = DBLayer::table(Pessoa::TABLE_NAME_PESSOA)
                        ->where(Pessoa::KEY_ID_PESSOA, '=', $idPessoa)->delete();

                    if ($deletePessoa) {
                        $itensDeletadosCount++;
                    }

                } else {
                    //3º Deleta Pessoa juridica
                    DBLayer::table(PessoaJuridica::TABLE_NAME)
                        ->where(PessoaJuridica::ID_PESSOA, '=', $idPessoa)->delete();


                    //4º Deleta Pessoa
                    $deletePessoa = DBLayer::table(Pessoa::TABLE_NAME_PESSOA)
                        ->where(Pessoa::KEY_ID_PESSOA, '=', $idPessoa)->delete();

                    if ($deletePessoa) {
                        $itensDeletadosCount++;
                    }

                }
            }

        });

        return $itensDeletadosCount;
    }
}