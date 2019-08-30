<?php
if (!array_key_exists('state_id', $_REQUEST)) {
  throw new \SimpleSAML\Error\Exception('Lost Client State. Please retry');
}

$state = \SimpleSAML\Auth\State::loadState(
  base64_decode($_REQUEST['state_id']),
  \SimpleSAML\Module\joomlamodule\Auth\Source\JoomlaAuth::STAGE_INIT
);

if (!array_key_exists('token', $_REQUEST)) {
  throw new SimpleSAML\Error\Exception('Missing token. Please retry');
}

$state['joomlamodule:verification_token'] = $_REQUEST['token'];

assert(array_key_exists(\SimpleSAML\Module\joomlamodule\Auth\Source\JoomlaAuth::AUTH_ID_INDEX, $state));
$sourceId = $state[\SimpleSAML\Module\joomlamodule\Auth\Source\JoomlaAuth::AUTH_ID_INDEX];

$source = \SimpleSAML\Auth\Source::getById($sourceId);

if ($source === null) {
  throw new \Exception("Could not find authentication source with id $sourceId");
}

$source->verify_token($state);

\SimpleSAML\Auth\Source::completeAuth($state);
