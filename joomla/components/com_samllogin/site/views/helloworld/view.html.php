<?php

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

class HelloWorldViewHelloWorld extends JViewLegacy {
  function random_str($length = 64, $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ') {
    if ($length < 1) {
      $length = 64;
    }
    $pieces = [];
    $max = mb_strlen($keyspace, '8bit') - 1;
    for ($i = 0; $i < $length; ++$i) {
      $pieces []= $keyspace[random_int(0, $max)];
    }
    return implode('', $pieces);
  }

	function display($tpl = null) {
    $app  = JFactory::getApplication();
    $redirect_uri = $app->input->get('redirect_uri', false, 'STRING');
    if (!$redirect_uri) {
      $this->msg='Qualcosa è andato storto, riprova.';

       return parent::display($tpl);
    }
    $id = JFactory::getUser()->id;
    if($id == 0)  {
      $this->msg='Esegui il login con le credenziali della tua scuola per continuare.';

      return parent::display($tpl);
    }

    $db = JFactory::getDbo();
    $query = $db->getQuery(true);

    $token = $db->quote($this->random_str(63));
    $exp = 'FROM_UNIXTIME('.(time() + 5 * 60).')';

    $columns = array('token', 'user_id', 'exp');
    $values = array($token, $id, $exp);

    $query
      ->insert($db->quoteName('#__LoginTokens'))
      ->columns($db->quoteName($columns))
      ->values(implode(',', $values));
    $query.=
      ' ON DUPLICATE KEY UPDATE '.
      $db->quoteName('token').' = '.$token.', '.
      $db->quoteName('exp').' = '.$exp;

    $db->setQuery($query);
    $db->execute();

    $app->redirect($redirect_uri.(strpos($redirect_uri, '?') ? '&' : '?').'token='.str_replace('\'',"", $token));
	}
}
