<?php
namespace SimpleSAML\Module\joomlamodule\Auth\Source;

class JoomlaAuth extends \SimpleSAML\Auth\Source {
  const STAGE_INIT = 'joomlamodule:init';
  const AUTH_ID_INDEX = 'joomlamodule:AuthId';

  private $auth_url;

  public function __construct($info, $config) {
    parent::__construct($info, $config);

    if (!array_key_exists('auth_url', $config)) {
      throw new \Exception('Invalid config: missing auth URL.');
    }

    $this->auth_url = $config['auth_url'];
  }

  public function authenticate(&$state) {
    $state[self::AUTH_ID_INDEX] = $this->authId;
    $state_id = \SimpleSAML\Auth\State::saveState($state, self::STAGE_INIT);

    $login_URL =
      $this->auth_url.
      (strpos($this->auth_url, '?') ? '&' : '?').'redirect_uri='.
      urlencode(
        \SimpleSAML\Module::getModuleURL('joomlamodule').
        '/linkback.php'.
        '?state_id='.base64_encode($state_id)
      );

    \SimpleSAML\Utils\HTTP::redirectTrustedURL($login_URL);
  }

  public function verify_token(&$state) {
    $idp_url =
      $this->auth_url.
      (strpos($this->auth_url, '?') ? '&' : '?').'task=verify_token'
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
      $this->auth_url.
      (strpos($this->auth_url, '?') ? '&' : '?').'task=logout';

    \SimpleSAML\Utils\HTTP::redirectTrustedURL($logout_URL);
  }
}
