<?php

namespace SimpleSAML\Module\joomlamodule\Auth\Source;

define( '_JEXEC', 1 );
define('JPATH_BASE', '/var/www/html/sample-scuola' );
define( 'DS', DIRECTORY_SEPARATOR );

require_once ( JPATH_BASE.DS.'includes'.DS.'defines.php' );
//require_once ( JPATH_BASE.DS.'includes'.DS.'framework.php' );

class JoomlaAuth extends \SimpleSAML\Module\core\Auth\UserPassBase {
  protected function login($username, $password) {
    print(`printenv`);

    $credentials = [
      'username' => 'a',
      'password' => 'a'
    ];

    $options = [];

    //$authenticate = JAuthentication::getInstance();
    //$response   = $authenticate->authenticate($credentials, $options);

    return [
      'uid' => ['theusername'],
      'displayName' => ['Some Random User'],
      'eduPersonAffiliation' => ['member', 'employee'],
    ];
  }
}
