<?php
class JoomlaAuth extends \SimpleSAML\Module\core\Auth\UserPassBase {
    protected function login($username, $password) {
        if ($username !== 'theusername' || $password !== 'thepassword') {
            throw new \SimpleSAML\Error\Error('WRONGUSERPASS');
        }
        return [
            'uid' => ['theusername'],
            'displayName' => ['Some Random User'],
            'eduPersonAffiliation' => ['member', 'employee'],
        ];
    }
}
