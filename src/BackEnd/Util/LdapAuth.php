<?php
/**
 * Created by PhpStorm.
 * User: Isaque
 * Date: 30/08/2017
 * Time: 17:24
 */

namespace PmroPadraoLib\Util;

use PmroPadraoLib\Util\Exceptions\ArgumentNullOrEmptyException;
use PmroPadraoLib\Util\Exceptions\InvalidCredentialsException;
use PmroPadraoLib\Util\Utils;
use \Exception;

class LdapAuth
{
    private $ldapHost = 'ldap://192.168.133.10';//active airectory server ex "server.college.school.edu"
    private $ldapPort = '';
    private $ldapDomain = 'DC=dcro,DC=gov';//active directory domain name DN (base location of ldap search) ex "OU=Departments,DC=college,DC=school,DC=edu"
    private $ldapUserGroup = null;// active directory user group name ex  KAnboard_users
    private $ldapManagerGroup = null;// active directory manager group name ex Kanboard_gerente
    private $ldapUserDomain = '@dcro.gov';// domain, for purposes of constructing $user ex '@college.school.edu'
    private $ldapConnection = null;
    private $authenticatedUser = null;

    public function setHost($ldapHost)
    {
        $this->ldapHost = $ldapHost;
    }

    public function setPort($ldapPort)
    {
        $this->ldapPort = $ldapPort;
    }

    public function setDomain($ldapDomain)
    {
        $this->ldapDomain = $ldapDomain;
    }

    public function setUserGroup($ldapUserGroup)
    {
        $this->ldapUserGroup = $ldapUserGroup;
    }

    public function setManagerGroup($ldapManagerGroup)
    {
        $this->ldapManagerGroup = $ldapManagerGroup;
    }

    public function setUserDomain($ldapUserDomain)
    {
        $this->ldapManagerGroup = $ldapUserDomain;
    }

    private function connect()
    {
        $this->ldapConnection = ldap_connect($this->ldapHost);
    }

    public function authenticate($user, $password)
    {
        if (empty($user))
        {
            throw new ArgumentNullOrEmptyException('Usuario não pode ser nulo ou vazio!');
        }
        if (empty($password))
        {
            throw new ArgumentNullOrEmptyException('Senha não pode ser nula ou vazia!');
        }

        $this->connect();

        $ldaprdn = $user . $this->ldapUserDomain;

        ldap_set_option($this->ldapConnection, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($this->ldapConnection, LDAP_OPT_REFERRALS, 0);

        // verifica usuario e senha
        if ($bind = @ldap_bind($this->ldapConnection, $ldaprdn, $password))
        {
            $this->authenticatedUser = $user;
            return true;
            /*
            // válido
            // verificar presença em grupos
            $filter = "(sAMAccountName=" . $user . ")";
            $attr = array("memberof");
            $result = ldap_search($this->ldapConnection, $this->ldapDomain, $filter, $attr) or exit("Unable to search LDAP server");
            $entries = ldap_get_entries($this->ldapConnection, $result);
            ldap_unbind($this->ldapConnection);

            $access = 0;
            // Verificar se o usuario pertence a um grupo
            foreach ($entries[0]['memberof'] as $grps)
            {
                // É gerente, então interronpa o loop
                if (strpos($grps, $this->ldapManagerGroup))
                {
                    $access = 2;
                    break;
                }

                // É usuário
                if (strpos($grps, $this->ldapUserGroup))
                {
                    $access = 1;
                }
            }

            if ($access != 0)
            {
                // Estabelecer variáveis de sessão
                $_SESSION['user'] = $user;
                $_SESSION['access'] = $access;
                return true;
            }
            else
            {
                // O usuário não possui direitos
                return false;
            }*/
        }
        else
        {
            //credencial invalida
            // nome ou senha invalido
            throw new InvalidCredentialsException();
        }
        return false;
    }

    public function getAllUser()
    {
        if ($this->ldapConnection == null && $this->authenticatedUser == null)
        {
            new Exception('Autentique primeiro!', 400);
        }
        $conn = $this->ldapConnection;
        $base = $this->ldapDomain;
        //$filter="(cn=*)";
        //$filter="(sAMAccountName=*)";
        $filter = "(&(objectClass=user)(objectCategory=person)(sn=*))";
        $justthese = array();
        $pageSize = 300;
        $cookie = '';
        $count = 0;
        $data = array();
        do
        {
            ldap_control_paged_result($conn, $pageSize, true, $cookie);

            $result = ldap_search($conn, $base, $filter, $justthese);
            $entries = ldap_get_entries($conn, $result);

            if (!empty($entries))
            {
                for ($i = 0; $i < $entries["count"]; $i++)
                {
                    $data[] = array(
                        'name' => $entries[$i]["cn"][0],
                        'username' => $entries[$i]["samaccountname"][0]
                    );
                    $count++;
                }
            }
            ldap_control_paged_result_response($conn, $result, $cookie);

        }
        while ($cookie !== null && $cookie != '');
        array_multisort($data);//ordena o array alfabeticamente
        return $data;
    }

    public function countRegisteredUsers()
    {
        if ($this->ldapConnection == null && $this->authenticatedUser == null)
        {
            new Exception('Autentique primeiro!', 400);
        }

        return count($this->getAllUser());
    }

    public function countTotalNumberOfPages($recordsPerPage)
    {
        $totalRecords = $this->countRegisteredUsers();
        $totalNumberOfPages = ceil($totalRecords / $recordsPerPage);
        return $totalNumberOfPages;
    }

    public function getAllUserByLimit($offset = 1, $recordsPerPage = 50)
    {
        if ($this->ldapConnection == null && $this->authenticatedUser == null)
        {
            new Exception('Autentique primeiro!', 400);
        }
        $lista = array();

        $entries = $this->getAllUser();
        $entriesCount = count($entries);

        for ($i = $offset; $i < $offset + $recordsPerPage; $i++)
        {
            $item = array();
            $item['nome'] = $entries[$i]['name'];
            $item['login'] =$entries[$i]['username'];
            array_push($lista, $item);
        }
        return $lista;
    }

    /** procura usuario pelo nome **/
    public function findUserByName($name, $limit = null)
    {
        if ($this->ldapConnection == null && $this->authenticatedUser == null)
        {
            new Exception('Autentique primeiro!', 400);
        }

        $lista = array();
        $entries = $this->getAllUser();
        $entriesCount = count($entries);

        $name = strtolower(Utils::RemoveAccents($name));

        for ($i = 0; $i < $entriesCount; $i++)
        {

            if (strpos(strtolower($entries[$i]['name']), $name) !== false)
            {
                $item = array();
                $item['nome'] = $entries[$i]['name'];
                $item['login'] =$entries[$i]['username'];
                array_push($lista, $item);
            }
            if ($limit != null)
            {
                if ($limit == count($lista))
                {
                    break;
                }
            }
        }

        return $lista;
    }

    /**alteracao de senha no ldap**/
    public function changePassword($newPassword)
    {
        if ($this->ldapConnection == null && $this->authenticatedUser == null)
        {
            new Exception('Autentique primeiro!', 400);
        }
        $ldaprdn = $this->authenticatedUser . $this->ldapUserDomain;

        $info["userPassword"] = $newPassword;

        $rs = ldap_mod_replace($this->ldapConnection, $ldaprdn, $info);

        if ($rs)
        {
            return true;
        }
        return false;
    }

    public function createNewUser($conpleteName, $username, $password, $email = '')
    {
        if ($this->ldapConnection == null && $this->authenticatedUser == null)
        {
            new Exception('Autentique primeiro!', 400);
        }

        // Prepare data
        $info['cn'] = $conpleteName;
        $info['sn'] = " ";
        $info['mail'] = $email;
        $info['objectclass'] = "inetOrgPerson";
        $info['userpassword'] = $password;
        $info['samaccountname'] = $username;

        // Add data to directory
        $rs = ldap_add($this->ldapConnection, "cn=$conpleteName," . $this->ldapDomain, $info);
        ldap_close($this->ldapConnection);
        if ($rs)
        {
            return true;
        }
        return false;
    }

    public function deleteUser($userName)
    {
        if ($this->ldapConnection == null && $this->authenticatedUser == null)
        {
            new Exception('Autentique primeiro!', 400);
        }

        $base = $this->ldapDomain;
        $filter = "(sAMAccountName=$userName)";
        $result = ldap_search($this->ldapConnection, $base, $filter);
        $info = ldap_get_entries($this->ldapConnection, $result);
        $dn = $info[0]["dn"];
        $rs = ldap_delete($this->ldapConnection, $dn);
        ldap_close($this->ldapConnection);

        if ($rs)
        {
            return true;
        }
        return false;
    }


}