<?php
/**
 * Created by PhpStorm.
 * User: Isaque
 * Date: 17/07/2017
 * Time: 13:48
 */


namespace PmroPadraoLib\Model\DAL;

use Exception;

interface DAL
{
    /**
     * Função para incluir registro na tabela
     * @access public
     * @param object $object
     * @return integer $id
     * @throws Exception exceção generica
     **/
    public function Incluir($object);
    /**
     * Função para alterar registro da tabela
     * @access public
     * @param object $object
     * @return void
     * @throws Exception exceção generica
     **/
    public function Alterar($object);
    /**
     * Função para exclui registro da tabela
     * @access public
     * @param integer $id
     * @return void
     * @throws Exception exceção generica
     **/
    public function Excluir($id);
    /**
     * Função para retornar um registro da tabela enderecoPessoa
     * @access public
     * @param integer $id
     * @return object
     * @throws Exception exceção generica
     **/
    public function Consultar($id);
    /**
     * Função para retornar um registro da tabela enderecoPessoa
     * filtrado por campo/valor
     * @access public
     * @param  string $campo
     * @param  string $valor
     * @return object
     * @throws Exception exceção generica
     **/
    public function ConsultarPorCampo($campo, $valor);

    public function ListarTodos($returnType='object',$limit=null,$offset=0);

    public function ListarPorCampo($campo, $valor,$returnType='object',$limit=null,$offset=0);



}