<?php

return [
    'keycloak_realm_sig_key_algorithm' => env('KEYCLOAK_REALM_SIG_KEY_ALGORITHM', 'RS256'),
    'keycloak_realm_sig_public_key' => env('KEYCLOAK_REALM_SIG_PUBLIC_KEY', 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAvEkUrO6ADsC3K+ydgTuV8C64jvtfvfY0lKD+zRwcVUZGKp+6YxnmrEdhlN5cDcWIfsvZQZUuYclzegcXGddKTNqemktjvA9J4FguYlQuAV5et1N8Vb8ZL/Olp95pMOlWQX8ij58/Ppvx+N757goR4SKKREAQBfvxqUrXDCPEo8OLzKfBQO2yVI5LNgz7Farfb2uJrvjX7Zkpguf7vwk8nnW7V8zVIQskCWtnX5Al5V/jsE8K7YH0ZTmt/wRBn/OqhrVYeyjQTH5m3ZsTb+fmNxzosZX4TGiSvyXpXMazJmP+CQYMQFHz/idgI+CO9Yp8ja/MUEabb4+Xl3+4d+rPMwIDAQAB'),
    'keycloak_private_url' => env('KEYCLOAK_PRIVATE_URL', 'http://keycloak-sample:8080'),
    'keycloak_realm' => env('KEYCLOAK_REALM', 'master'),
    'keycloak_client_id' => env('KEYCLOAK_CLIENT_ID', 'keycloak-sample'),
    'keycloak_user' => env('KEYCLOAK_USER', 'admin'),
    'keycloak_password' => env('KEYCLOAK_PASSWORD', 'admin'),
    'keycloak_grant_type' => env('KEYCLOAK_GRANT_TYPE', 'password'),
];
