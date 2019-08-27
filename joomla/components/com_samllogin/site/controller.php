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
      ->select('COUNT(*)')
      ->from($db->quoteName('#__LoginTokens'))
      ->where($db->quoteName('token').' = '.$db->quote($app->input->get('token')))
      ->andWhere($db->quoteName('exp').' >= NOW()');

    $db->setQuery($query);
    $row = $db->loadResult();

    echo json_encode([
      'message' =>  'Token is correct, user is authenticated.',
      'statusCode' => 200,
      'status' => (bool)$row
    ]);
    die;
  }

  function test() {
    //'&redirect_uri='.urlencode(\SimpleSAML\Module::getModuleURL('authwindowslive').'/linkback.php').
    //'&state='.urlencode($stateID).
    //$this->msg="Accedi con il tuo account della scuola per proseguire.";
    $url=JUri::getInstance();
    $matches = [];
    preg_match('/(https?:\/\/).*?(\/.*)/', $url, $matches);
    $this->msg.=$url.$matches."<br>";

    //$query = $db->getQuery(true);
//
    //$query
    //  ->select($db->quoteName('*'))
    //  ->from($db->quoteName('#__LoginTokens'));
//
    //$db->setQuery($query);
    //$row = $db->loadRowList();
    //$this->msg=$row[0][0];
  }
}
