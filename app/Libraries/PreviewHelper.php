<?php
/**
 * Created by PhpStorm.
 * User: ARodriguez
 * Date: 12/8/15
 * Time: 15:48
 */

namespace Admins\Libraries;


class PreviewHelper
{

    private static $NAME_ROUTE = array(
        'profile::index' => 'Perfil',
        'campaigns::index' => 'Campañas',
        'issuetracker::index' => 'Issues Track',
        'admin::clients::index' => 'Clientes',
        'network::index' => 'Redes'
    );

    public static function getNameRoute($route)
    {
        if(array_key_exists($route , self::$NAME_ROUTE))
        {
            return self::$NAME_ROUTE[$route];
        }
        return 'indefinida';
    }
}