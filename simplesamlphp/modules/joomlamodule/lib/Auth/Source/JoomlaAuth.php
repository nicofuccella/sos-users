<?php

namespace SimpleSAML\Module\joomlamodule\Auth\Source;

class JoomlaAuth extends \SimpleSAML\Auth\Source {
  const STAGE_INIT = 'joomlamodule:init';
  const AUTHID = 'joomlamodule:AuthId';

  private $auth_url;

  public function __construct($info, $config) {
    // Call the parent constructor first, as required by the interface
    parent::__construct($info, $config);

    if (!array_key_exists('auth_url', $config)) {
      throw new \Exception('Invalid config: missing auth URL.');
    }

    $this->auth_url = $config['auth_url'];
  }

  public function authenticate(&$state) {
    assert(is_array($state));

    $state[self::AUTHID] = $this->authId;

    $stateID = \SimpleSAML\Auth\State::saveState($state, self::STAGE_INIT);

    $authorizeURL =
      $this->auth_url.
      (strpos($this->auth_url, '?') ? '&' : '?').'redirect_uri='.
      urlencode(
        \SimpleSAML\Module::getModuleURL('joomlamodule').
        '/linkback.php'.
        '?state_id='.base64_encode($stateID)
      );
    \SimpleSAML\Utils\HTTP::redirectTrustedURL($authorizeURL);
  }

  public function check_auth(&$state) {
    $url =
      $this->auth_url .
      (strpos($this->auth_url, '?') ? '&' : '?') . 'task=verify_token'
      . '&token=' . $state['joomlamodule:verification_code'];
    //Use file_get_contents to GET the URL in question.
    $contents = file_get_contents($url);

    //If $contents is not a boolean FALSE value.
    if ($contents !== false) {
      //Print out the contents.
      echo $contents;
    }
  }
}
