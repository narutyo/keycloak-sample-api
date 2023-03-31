<?php

namespace App\Guards;

use App\Models\User;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Http\Request;

class KeycloakGuard implements Guard
{
    private $user;
    private $request;
    private $decodedToken;

    public function __construct(UserProvider $provider, Request $request)
    {
        $this->user = null;
        $this->provider = $provider;
        $this->decodedToken = null;
        $this->request = $request;

        $this->authenticate();
    }

    private function authenticate()
    {
        $publicKey = config('keycloak.keycloak_realm_sig_public_key');
        try {
            $this->decodedToken = $this->decodeToken(
                $this->request->bearerToken(),
                $publicKey
            );
        } catch (\Exception $e) {
            return abort(response()->json($e->getMessage(), 401));
        }
        if ($this->decodedToken) {
            $this->validate();
        }
    }

    protected function decodeToken(string $token = null, string $publicKey)
    {
        if (!$token) {
            return null;
        }
        $realmKeyAlgorithm = config('keycloak.keycloak_realm_sig_key_algorithm');
        return JWT::decode(
            $token,
            new Key(
                "-----BEGIN PUBLIC KEY-----\n" . wordwrap($publicKey, 64, "\n", true) . "\n-----END PUBLIC KEY-----",
                $realmKeyAlgorithm
            )
        );
    }


    public function check()
    {
        return !is_null($this->user());
    }

    public function hasUser()
    {
        return !is_null($this->user());
    }

    public function guest()
    {
        return !$this->check();
    }

    public function user()
    {
        if (is_null($this->user)) {
            return null;
        }
        return $this->user;
    }

    public function id()
    {
        if ($user = $this->user()) {
            return $user->id;
        }
    }

    public function validate(array $credentials = [])
    {
        if (!$this->decodedToken) {
            return false;
        }

        $userInDb = User::find($this->decodedToken->sub);
        if (empty($userInDb)) {
          $user = new User;
          $user->id = $this->decodedToken->sub;
          $user->name = $this->decodedToken->preferred_username;
          $user->save();
          $userInDb = $user;
        }
        $this->setUser($userInDb);
        return true;
    }

    public function setUser(Authenticatable $user)
    {
        $this->user = $user;
    }

    public function token()
    {
        return json_encode($this->decodedToken);
    }

    public function hasRole($resource, $role)
    {
        if (!$this->decodedToken) {
            return false;
        }

        $token_resource_access = (array)$this->decodedToken->resource_access;
        if (array_key_exists($resource, $token_resource_access)) {
            $token_resource_values = (array)$token_resource_access[$resource];

            if (
                array_key_exists('roles', $token_resource_values) &&
                in_array($role, $token_resource_values['roles'])
            ) {
                return true;
            }
        }
        return false;
    }
}
