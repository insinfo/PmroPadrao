<?php
/**
 * Created by PhpStorm.
 * User: Isaque
 * Date: 31/08/2017
 * Time: 11:37
 */

namespace PmroPadraoLib\Controller;

use PmroPadraoLib\Util\LdapAuth;

class AutenticacaoController
{
    const JSON_FORMAT = 'json';
    const ARRAY_ASSOC_FORMAT = 'array';
    //const ARRAY_NUM_FORMAT = 'arrayNum';
    const ARRAY_OBJECT = 'object';

    public static $admUser = 'ZGVzZW52b2x2aW1lbnRv';
    public static $admPass = 'b3N0cmFz';

    public static function ListaUsuarios($responseJson, $returnType = self::JSON_FORMAT)
    {
        $user = 'isaque.neves';//base64_decode(self::$admUser);
        $pass = 'Ins257257';///base64_decode(self::$admPass);

        $draw = $responseJson['draw'];
        $length = $responseJson['length'];
        $search = is_array($responseJson['search']) ? $responseJson['search']['value'] : $responseJson['search'];
        $start = $responseJson['start'];

        $ldapAuth = new LdapAuth();
        $ldapAuth->setHost('ldap://192.168.133.10');
        $ldapAuth->setDomain('DC=dcro,DC=gov');
        $ldapAuth->setUserDomain('@dcro.gov');
        $ldapAuth->authenticate($user, $pass);

        $result = array();
        $result['draw'] = $draw;
        $result['recordsTotal'] = '';
        $result['recordsFiltered'] = '';
        $result['data'] = array();

        if ($search == '' || $search == null)
        {
            $recordsTotal = $ldapAuth->countRegisteredUsers();
            $result['recordsTotal'] = $recordsTotal;
            $result['recordsFiltered'] = $recordsTotal;
            $result['data'] = $ldapAuth->getAllUserByLimit($start, $length);
        }
        else
        {
            $r = $ldapAuth->findUserByName($search,10);
            $recordsTotal = count($r);
            $result['recordsTotal'] = $recordsTotal;
            $result['recordsFiltered'] = $recordsTotal;
            $result['data'] = $r;
        }

        switch ($returnType)
        {
            case self::JSON_FORMAT:
                return json_encode($result);
                break;
            case self::ARRAY_ASSOC_FORMAT:
                return $result;
                break;
        }

        return json_encode($result);
    }

    public static function IncluirUsuario($responseJson)
    {
        $name = $responseJson['name'];
        $user = $responseJson['user'];
        $pass = $responseJson['pass'];

        $ldapAuth = new LdapAuth();
        $ldapAuth->setHost('ldap://192.168.133.10');
        $ldapAuth->setDomain('DC=dcro,DC=gov');
        $ldapAuth->setUserDomain('@dcro.gov');
        $ldapAuth->authenticate($user, $pass);
        $ldapAuth->createNewUser($name, $user, $pass);
    }

    public static function Atenticar($responseJson)
    {
        $user = $responseJson['user'];
        $pass = $responseJson['pass'];

        $ldapAuth = new LdapAuth();
        $ldapAuth->setHost('ldap://192.168.133.10');
        $ldapAuth->setDomain('DC=dcro,DC=gov');
        $ldapAuth->setUserDomain('@dcro.gov');
        $ldapAuth->authenticate($user, $pass);
    }
}