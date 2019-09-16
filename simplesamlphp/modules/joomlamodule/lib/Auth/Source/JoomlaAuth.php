<?php
namespace SimpleSAML\Module\joomlamodule\Auth\Source;

use SimpleSAML\Error\Exception;

class JoomlaAuth extends \SimpleSAML\Auth\Source {
  const STAGE_INIT = 'joomlamodule:init';
  const AUTH_ID_INDEX = 'joomlamodule:AuthId';

  private $redirect_url;
  private $verify_url;

  public function __construct($info, $config) {
    parent::__construct($info, $config);

    if (!array_key_exists('redirect_url', $config)) {
      throw new \SimpleSAML\Error\Exception('Invalid config: missing auth URL.');
    }

    $this->redirect_url = $config['redirect_url'];
    $this->verify_url = $config['verify_url'];
  }

  public function authenticate(&$state) {
    $state[self::AUTH_ID_INDEX] = $this->authId;
    $state_id = \SimpleSAML\Auth\State::saveState($state, self::STAGE_INIT);

    $login_URL =
      $this->redirect_url.
      (strpos($this->redirect_url, '?') ? '&' : '?').'redirect_uri='.
      urlencode(
        \SimpleSAML\Module::getModuleURL('joomlamodule').
        '/linkback.php'.
        '?state_id='.base64_encode($state_id)
      );
    try {
      \SimpleSAML\Utils\HTTP::redirectTrustedURL($login_URL);
    } catch (Exception $error) {
      throw new Exception('Cannot redirect to redirect_url. Please check your configuration.');
    }
  }

  public function verify_token(&$state) {
    $idp_url =
      $this->redirect_url.
      (strpos($this->redirect_url, '?') ? '&' : '?').'task=verify_token'
      .'&token='.$state['joomlamodule:verification_token'];

    $contents = file_get_contents($idp_url);

    if ($contents === false) {
      throw new \SimpleSAML\Error\Exception('Joomla Auth source not reachable. Please retry later.');
    }

    $contents = json_decode($contents);

    if (!$contents->status) {
      throw new \SimpleSAML\Error\Exception($contents->message);
    }

    $state['Attributes'] = ['user' => [$contents->user]];
  }

  public function logout(&$state) {
    $logout_URL =
      $this->redirect_url.
      (strpos($this->redirect_url, '?') ? '&' : '?').'task=logout';

    session_destroy();

    \SimpleSAML\Utils\HTTP::redirectTrustedURL($logout_URL);
  }
}
