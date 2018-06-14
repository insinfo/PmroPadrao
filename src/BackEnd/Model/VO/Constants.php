<?php
/**
 * Created by PhpStorm.
 * User: isaque
 * Date: 03/05/2018
 * Time: 18:32
 */

namespace PmroPadraoLib\Model\VO;

class Constants
{
    const STORAGE_DIRECTORY = 'storage';
    const PROFILE_IMAGE_DIRECTORY = 'profile';
    const PROFILE_IMAGE_WEB_PATH = '/storage/pmropadrao/profile/';

    const SERVER_PATH = '/var/www/html';
    const PMRO_PADRAO_PATH_FULL = Constants::SERVER_PATH .'/pmroPadrao';
    const STORAGE_PATH = '/storage';
    const STORAGE_PATH_FULL = Constants::SERVER_PATH . Constants::STORAGE_PATH;
    const PROFILE_IMAGE_PATH_FULL = Constants::STORAGE_PATH_FULL .'/pmropadrao/profile';
}