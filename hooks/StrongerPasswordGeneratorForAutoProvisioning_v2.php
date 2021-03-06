<?php

/**
 * Stronger Password Generator for WHMCS Provisioning v2
 *
 * @package     WHMCS
 * @copyright   Katamaze
 * @link        https://katamaze.com
 * @author      Davide Mantenuto <info@katamaze.com>
 */

use WHMCS\Database\Capsule;

add_hook('PreModuleCreate', 1, function($vars)
{
    $chars              = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $specialChars       = '!@#$%^&*?'; // Plesk does not consider (, ), -, = and + as special characters
    $password           = substr(str_shuffle($chars), 0, $length = '9');
    $randomPos          = rand(0, strlen($password) - 1);
    $randomSpecialChar  = $specialChars[rand(0,strlen($specialChars)-1)];
    $password           = substr($password, 0, $randomPos) . $randomSpecialChar . substr($password, $randomPos);

    Capsule::table('tblhosting')->where('id', $vars['params']['serviceid'])->update(['password' => Encrypt($password)]);
});
