<?php
defined('_JEXEC') or die('Restricted access');

class SOSUsersController extends JControllerLegacy {
  function verify_token() {
    $app = JFactory::getApplication();
    $db = JFactory::getDbo();

    $token = $db->quote($app->input->get('token', NULL, 'ALNUM'));

    $query = $db->getQuery(true);
    $query
      ->update($db->quoteName('#__LoginTokens'))
      ->set($db->quoteName('exp').' =  NOW()')
      ->where($db->quoteName('token').' = '.$token)
      ->andWhere($db->quoteName('exp').' >= NOW()');

    $db->setQuery($query);
    $result = $db->execute();

    if ($db->getAffectedRows($result) === 0) {
      die(json_encode([
        'message' => 'Token is incorrect.',
        'statusCode' => 403,
        'status' => false,
      ]));
    }

    $query = $db->getQuery(true);
    $query
      ->select('user_id')
      ->from($db->quoteName('#__LoginTokens'))
      ->where($db->quoteName('token').' = '.$token);

    $db->setQuery($query);
    $user_id = $db->loadResult();

    $user_data = \Joomla\Utilities\ArrayHelper::fromObject(JFactory::getUser($user_id));

    die(json_encode([
      'message' => 'Token is correct, user is authenticated.',
      'statusCode' => 200,
      'status' => true,
      'user' => $user_data['username'],
    ]));
  }
}
//TODO add logout
//TODO add google sync
