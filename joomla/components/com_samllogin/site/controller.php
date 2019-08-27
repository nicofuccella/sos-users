<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_helloworld
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
/**
 * Hello World Component Controller
 *
 * @since  0.0.1
 */
class HelloWorldController extends JControllerLegacy {
  function verify_token() {
    $app  = JFactory::getApplication();
    $db = JFactory::getDbo();

    $query = $db->getQuery(true);
    $query
      ->select('user_id')
      ->from($db->quoteName('#__LoginTokens'))
      ->where($db->quoteName('token').' = '.$db->quote($app->input->get('token')))
      ->andWhere($db->quoteName('exp').' >= NOW()');

    $db->setQuery($query);
    $user_id = $db->loadResult();
    print json_encode([
      'message' =>  'Token is '.((bool)$user_id ? 'correct, user is authenticated.' : 'incorrect.'),
      'statusCode' => 200,
      'status' => (bool)$user_id,
      //'user' => $app->getUser($user_id),
    ]);
    die();
  }

  function test() {
    //'&redirect_uri='.urlencode(\SimpleSAML\Module::getModuleURL('authwindowslive').'/linkback.php').
    //'&state='.urlencode($stateID).
    //$this->msg="Accedi con il tuo account della scuola per proseguire.";
    //$url=JUri::getInstance();
    //$matches = [];
    //preg_match('/(https?:\/\/).*?(\/.*)/', $url, $matches);
    //$this->msg.=$url.$matches."<br>";
    $db = JFactory::getDbo();
    $query = $db->getQuery(true);

    $query
      ->select($db->quoteName('*'))
      ->from($db->quoteName('#__LoginTokens'));

    $db->setQuery($query);
    $row = $db->loadRowList();
    echo $row[0][0];
  }
}
