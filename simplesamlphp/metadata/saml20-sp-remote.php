<?php
/*
   * This example shows an example config that works with G Suite (Google Apps) for education.
   * What is important is that you have an attribute in your IdP that maps to the local part of the email address
   * at G Suite. E.g. if your google account is foo.com, and you have a user with email john@foo.com, then you
   * must set the simplesaml.nameidattribute to be the name of an attribute that for this user has the value of 'john'.
   */
$metadata['https://www.google.com/a/g.feide.no'] = [
  'AssertionConsumerService'   => 'https://www.google.com/a/g.feide.no/acs',
  'NameIDFormat'               => 'urn:oasis:names:tc:SAML:1.1:nameid-format:emailAddress',
  'simplesaml.nameidattribute' => 'uid',
  'simplesaml.attributes'      => false
];
