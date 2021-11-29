<?php
use \Nubersoft\ {
    nApp,
    JWT\Controller as JWT,
    JWTFactory,
    Exception\Ajax as AjaxException
};

function jwtChecker(nApp $nApp)
{
    # Run jwt checks if there is a checker
    if (class_exists('\Nubersoft\JWT\Controller')) {
        # Fetch token secret
        $jwt = JWT::getJwtTokenSecret();
        # If there is a secret
        if ($jwt) {
            if (!empty($nApp->getPost())) {
                try {
                    # Validate the token
                    JWTFactory::get()->get($nApp->dec($nApp->getPost('jwtToken')));
                } catch (\Exception $e) {
                    //throw new Exception\Ajax($nApp->getPost('jwtToken'), 403);
                    # Report back with ajax or same-page
                    if ($nApp->isAjaxRequest())
                        throw new AjaxException('Invalid security token', 403);
                    # Throw normal exception
                    throw new \Exception('Invalid security token', 403);
                }
            }
        }
    }
}