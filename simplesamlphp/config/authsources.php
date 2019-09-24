<?php
// SimpleSAMLphp enabled authentication sources. JoomlaAuth is used to log users into Joomla!, admin is used for
// SimpleSAML administrator page
$config = [
  'joomlamodule:JoomlaAuth' => [
    'joomlamodule:JoomlaAuth',
    'redirect_url' => 'http://localhost/index.php?option=com_samllogin',
    'verify_url' => 'http://localhost/index.php?option=com_samllogin',
  ],
  'admin' => [
    'core:AdminPassword',
  ],
];
