<?php
namespace JSantos\Auth;

use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Pimple\Container;

class Token
{
    /**
     * @var Builder
     */
    private $builder;
    /**
     * @var Sha256
     */
    private $signer;
    /**
     * @var Container
     */
    private $app;
    /**
     * @var array
     */
    private $data;
    public function __construct(Builder $builder, Sha256 $signer = null)
    {
        $this->builder = $builder;
        $this->signer  = $signer;
    }
    public function setApplication(Container $app)
    {
        $this->app = $app;
    }
    public function setPayloadData($data)
    {
        $this->data = $data;
    }
    public function generateToken()
    {
        $token = $this->builder
            ->setIssuer($this->app['iss'])
            ->setId($this->app['jti'], true)
            ->setIssuedAt(time())
            ->setNotBefore(time() + 60)
            ->setExpiration(time() + $this->app['expires']);
        foreach($this->data as $k => $d) {
            $token->set($k, $d);
        }
        if(!is_null($this->signer)) {
            $token->sign($this->signer, $this->app['secret']);
        }
        return $token->getToken()->__toString();
    }
    public function validateToken($token = null)
    {
        if(is_null($token)) {
            throw new \Exception("Token can not be null");
        }
        $parser = new Parser();
        $parser = $parser->parse((string) $token);
        return $parser->verify(new Sha256(), $this->app['secret']);
    }
}