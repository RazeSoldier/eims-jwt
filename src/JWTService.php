<?php
/**
 * Author: RazeSoldier (razesoldier@outlook.com)
 * License: Apache-2.0
 */

namespace RazeSoldier\EIMS\Jwt;

use Lcobucci\JWT\{
    Encoding\JoseEncoder,
    Token,
    Token\Parser,
    Validation\Constraint,
    Validation\Validator,
};

/**
 * 为EIMS提供JWT服务。可以通过本实例获得EVE SSO访问令牌的角色名、角色ID
 */
class JWTService
{
    public const ISSUER = 'login.evepc.163.com';

    private Parser $parser;
    private Validator $validator;

    public function __construct()
    {
        $this->parser = new Parser(new JoseEncoder());
        $this->validator = new Validator();
    }

    /**
     * 验证EVE SSO的访问令牌
     */
    public function validateAccessToken(string $token): bool
    {
        $token = $this->parser->parse($token);
        return $this->validator->validate($token, ...$this->getConstraints());
    }

    /**
     * 从EVE SSO的访问令牌中获得该令牌的角色名称
     */
    public function getCharacterName(string $token): string
    {
        $res = $this->parser->parse($token);
        return $res->claims()->get('name');
    }

    /**
     * 从EVE SSO的访问令牌中获得该令牌的角色ID
     */
    public function getCharacterId(string $token): int
    {
        $res = $this->parser->parse($token);
        // sub的格式类似`CHARACTER:EVE:<character_id>`
        $sub = $res->claims()->get('sub');
        preg_match('/^CHARACTER:EVE:(?<id>[0-9]*)$/', $sub, $matches);
        return $matches['id'];
    }

    public function parse(string $token): Token
    {
        return $this->parser->parse($token);
    }

    private function getConstraints(): array
    {
        $issuedBy = new Constraint\IssuedBy(self::ISSUER);
        return [$issuedBy];
    }
}
