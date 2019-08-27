<?php

namespace SimpleSAML\Module\joomlamodule\Auth\Source;

class JoomlaAuth extends \SimpleSAML\Auth\Source {
  protected function authenticate() {
    define('DS', DIRECTORY_SEPARATOR);
    define('_JEXEC', 1);
    define('JPATH_BASE', '/var/www/html/sample-scuola');

    require_once JPATH_BASE.DS.'includes'.DS.'defines.php';
    require_once JPATH_BASE.DS.'includes'.DS.'framework.php';

    $db = \JFactory::getDbo();

    $query = $db->getQuery(true)
      ->select('id, password')
      ->from('#__users')
      ->where('username=' . $db->quote($username));
    $db->setQuery($query);
    $result = $db->loadObject();

    if ($result && \JUserHelper::verifyPassword($password, $result->password, $result->id)) {
      return [
        'uid' => [$username],
      ];
    }


    //$user = JFactory::getUser();        // Get the user object
//
    //if ($user->id != 0)
    //{
    //  // you are logged in
    //}

    throw new \SimpleSAML\Error\Error('WRONGUSERPASS');
  }
}
