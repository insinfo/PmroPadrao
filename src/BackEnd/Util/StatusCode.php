<?php
/**
 * Created by PhpStorm.
 * User: Isaque
 * Date: 26/07/2017
 * Time: 15:04
 */

namespace PmroPadraoLib\Util;

class StatusCode
{
    public static $ERROR = -1;
    public static $SUCCESS = 200;//ok
    public static $CREATED = 201;//Criado
    public static $ACCEPTED = 202;//Aceito
    public static $UNAUTHORIZED_INFORMATION = 203;//Informações não autorizadas
    public static $NO_CONTENT = 204;// No Content
    public static $BAD_REQUEST = 400;//A solicitação não pôde ser entendida devido à sintaxe mal formada.
    public static $UNAUTHORIZED = 401;//Não autorizado O pedido requer autenticação do usuário
    public static $FORBIDDEN = 403;
    public static $NOT_FOUND = 404;
    public static $REQUEST_TIMEOUT = 408;
    public static $INTERNAL_SERVER_ERROR = 500;//Internal Server Error
}