<?php
/**
 * Account Manager System (https://github.com/PsyduckMans/accountmanager)
 *
 * @link      https://github.com/PsyduckMans/accountmanager for the canonical source repository
 * @copyright Copyright (c) 2014 PsyduckMans (https://ninth.not-bad.org)
 * @license   https://github.com/PsyduckMans/accountmanager/blob/master/LICENSE MIT
 * @author    Psyduck.Mans
 */

namespace Propel;

use Zend\ModuleManager\ModuleManager;

/**
 * Class Module
 * @package Propel
 */
class Module
{
    public function init(ModuleManager $moduleManager)
    {
        \Propel::init(realpath(__DIR__ . '/config/zf2-domain-model-conf.php'));
        set_include_path(realpath(__DIR__ . '/src') . PATH_SEPARATOR . get_include_path());
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            )
        );
    }
}