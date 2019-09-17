<?php
defined('_JEXEC') or die('Restricted access');

use \Joomla\CMS\MVC\View\HtmlView;

class SAMLLoginViewSAMLLogin extends HtmlView {
	function display($tpl = null) {
    $app = JFactory::getApplication();
    $db = JFactory::getDbo();

    $redirect_uri = $app->input->get('redirect_uri', false, 'STRING');

    if (!$redirect_uri) {
      $redirect_uri = base64_decode($app->input->get('redirect_uri_base64', false, 'STRING'));
    }

    $id = JFactory::getUser()->id;
    if($id == 0)  {
      $redirectUrl = urlencode(base64_encode("index.php?option=com_samllogin&redirect_uri_base64=" . base64_encode($redirect_uri)));

      $app->redirect("index.php?option=com_users&view=login&return=$redirectUrl",'');
    }

    $token = $db->quote(JFactory::getSession()->getId());
    $exp = 'FROM_UNIXTIME('.(time() + JFactory::getSession()->getExpire()).')';

    $columns = ['token', 'user_id', 'exp'];
    $values = [$token, $id, $exp];

    $query = $db->getQuery(true);
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

    if ($redirect_uri) {
      $app->redirect(
        $redirect_uri.
        (strpos($redirect_uri, '?') ? '&' : '?').
        'token='.str_replace('\'',"", $token)
      );
    } else {
      $app->redirect(
        "/"
      );
    }
	}
}
