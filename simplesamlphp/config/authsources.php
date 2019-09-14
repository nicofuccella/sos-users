<?php
$config = [
  'joomlamodule:JoomlaAuth' => [
    'joomlamodule:JoomlaAuth',
    'redirect_url' => 'http://DOMAIN_NAME/index.php?option=com_samllogin',
    'verify_url' => 'http://localhost/index.php?option=com_samllogin',
  ],
  'admin' => [
    'core:AdminPassword',
  ],
];
