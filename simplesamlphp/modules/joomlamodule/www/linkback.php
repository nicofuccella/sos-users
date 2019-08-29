<?php

if (!array_key_exists('state_id', $_REQUEST)) {
  throw new \Exception('Lost Client State');
}
$state = \SimpleSAML\Auth\State::loadState(
  base64_decode($_REQUEST['state_id']),
  \SimpleSAML\Module\joomlamodule\Auth\Source\JoomlaAuth::STAGE_INIT
);

//if (!array_key_exists('token', $_REQUEST)) {
//  throw new \Exception('Missing token');
//}
$state['joomlamodule:verification_code'] = $_REQUEST['token'];

assert(array_key_exists(\SimpleSAML\Module\joomlamodule\Auth\Source\JoomlaAuth::AUTHID, $state));
$sourceId = $state[\SimpleSAML\Module\joomlamodule\Auth\Source\JoomlaAuth::AUTHID];

$source = \SimpleSAML\Auth\Source::getById($sourceId);

if ($source === null) {
  throw new \Exception('Could not find authentication source with id '.$sourceId);
}

$source->final_step($state);

\SimpleSAML\Auth\Source::completeAuth($state);
