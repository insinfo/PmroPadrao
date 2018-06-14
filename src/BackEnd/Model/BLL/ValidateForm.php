<?php
/**
 * Created by PhpStorm.
 * User: Isaque
 * Date: 17/08/2017
 * Time: 11:59
 */

namespace PmroPadraoLib\Model\BLL;

class ValidateForm
{
    public function ValidaPessoa($dataArray)
    {

    }

    public function ValidaNome($nome)
    {
        if (empty($nome))
        {
            return false;
        }
        if (strlen($nome) < 5)
        {
            return false;
        }
        return true;
    }

    public function ValidaCPF($cpf)
    {
        // Verifica se um número foi informado
        if (empty($cpf))
        {
            return false;
        }

        // Elimina possivel mascara
        $cpf = preg_replace('[^0-9]', '', $cpf);
        $cpf = str_pad($cpf, 11, '0', STR_PAD_LEFT);

        // Verifica se o numero de digitos informados é igual a 11
        if (strlen($cpf) != 11)
        {
            return false;
        }
        // Verifica se nenhuma das sequências invalidas abaixo
        // foi digitada. Caso afirmativo, retorna falso
        else
        {
            if ($cpf == '00000000000' || $cpf == '11111111111' || $cpf == '22222222222' || $cpf == '33333333333' || $cpf == '44444444444' || $cpf == '55555555555' || $cpf == '66666666666' || $cpf == '77777777777' || $cpf == '88888888888' || $cpf == '99999999999')
            {
                return false;
                // Calcula os digitos verificadores para verificar se o
                // CPF é válido
            }
            else
            {
                for ($t = 9; $t < 11; $t++)
                {
                    for ($d = 0, $c = 0; $c < $t; $c++)
                    {
                        $d += $cpf{$c} * (($t + 1) - $c);
                    }
                    $d = ((10 * $d) % 11) % 10;
                    if ($cpf{$c} != $d)
                    {
                        return false;
                    }
                }
                return true;
            }
        }
    }

    public function ValidaEmail($email)
    {
        $conta = "^[a-zA-Z0-9\._-]+@";
        $domino = "[a-zA-Z0-9\._-]+.";
        $extensao = "([a-zA-Z]{2,4})$";
        $pattern = $conta . $domino . $extensao;
        if (preg_match($pattern, $email))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function ValidaData($data)
    {
        // data é menor que 8
        if (strlen($data) < 8)
        {
            return false;
        }
        else
        {
            // verifica se a data possui
            // a barra (/) de separação
            if (strpos($data, "/") !== FALSE)
            {
                //
                $partes = explode("/", $data);
                // pega o dia da data
                $dia = $partes[0];
                // pega o mês da data
                $mes = $partes[1];
                // prevenindo Notice: Undefined offset: 2
                // caso informe data com uma única barra (/)
                $ano = isset($partes[2]) ? $partes[2] : 0;

                if (strlen($ano) < 4)
                {
                    return false;
                }
                else
                {
                    // verifica se a data é válida
                    if (checkdate($mes, $dia, $ano))
                    {
                        return true;
                    }
                    else
                    {
                        return false;
                    }
                }
            }
            else
            {
                return false;
            }
        }
    }

}

