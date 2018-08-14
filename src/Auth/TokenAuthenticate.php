<?php
namespace App\Auth;

use Cake\Auth\BaseAuthenticate;
use Cake\Controller\ComponentRegistry;
use Cake\Http\Response;
use Cake\Http\ServerRequest;
use Cake\Log\Log;
use Cake\Utility\Security;
use Exception;
use Firebase\JWT\JWT;

class TokenAuthenticate extends BaseAuthenticate
{
    /**
     * Parsed token.
     *
     * @var string|null
     */
    protected $_token;
    /**
     * Payload data.
     *
     * @var object|null
     */
    protected $_payload;

    public function __construct(ComponentRegistry $registry, $config)
    {
        $defaultConfig = [
            'cookie' => false,
            'header' => 'authorization',
            'prefix' => 'bearer',
            'parameter' => 'token',
            'queryDatasource' => false,
            'key' => null,
        ];

        $this->setConfig($defaultConfig);
        if (empty($config['allowedAlgs'])) {
            $config['allowedAlgs'] = ['HS256'];
        }
        parent::__construct($registry, $config);
    }

    public function authenticate(ServerRequest $request, Response $response)
    {
        return $this->getUser($request);
    }


    public function getUser(ServerRequest $request)
    {
        $payload = $this->getPayload($request);
        if (empty($payload)) {
            Log::write('error', 'Khong co payload');
            return false;
        }
        if (!$this->_config['queryDatasource']) {
            return json_decode(json_encode($payload), true);
        }
        return $payload;
    }

    public function getPayload($request = null)
    {
        if (!$request) {
            return $this->_payload;
        }
        $payload = null;
        $token = $this->getToken($request);
        if ($token) {
            $payload = $this->_decode($token);
        }
        return $this->_payload = $payload;
    }


    public function getToken($request = null)
    {
        $config = $this->_config;
        if ($request === null) {
            return $this->_token;
        }

        $header = $request->getHeaderLine($config['header']);
        if ($header && stripos($header, $config['prefix']) === 0) {
            return $this->_token = str_ireplace($config['prefix'] . ' ', '', $header);
        }

        if (!empty($this->_config['parameter'])) {
            $token = $request->getQuery($this->_config['parameter']);
            if ($token !== null) {
                $token = (string)$token;
            }
            return $this->_token = $token;
        }
        return $this->_token;
    }


    protected function _decode($token)
    {
        $config = $this->_config;
        try {
            $payload = JWT::decode(
                $token,
                $config['key'] ?: Security::getSalt(),
                $config['allowedAlgs']
            );
            return $payload;
        } catch (Exception $e) {
            Log::write('error', $e->getMessage());
            return false;
        }
    }

    public function unauthenticated(ServerRequest $request, Response $response)
    {
        $response->type('application/json');
        $body = [
            'success' => false,
            'message' => 'You are not authorized to access that location.',
            'code' => 401
        ];
        $response->body(json_encode($body));
        return $response;
    }
}