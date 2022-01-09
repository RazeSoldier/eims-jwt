<?php
/**
 * Author: RazeSoldier (razesoldier@outlook.com)
 * License: Apache-2.0
 */

namespace RazeSoldier\EIMS\Jwt;

use Lcobucci\JWT\{
    Configuration,
    UnencryptedToken,
    Validation\Constraint,
};

/**
 * 为EIMS提供JWT服务。可以通过本实例获得EVE SSO访问令牌的角色名、角色ID
 * @mixin Configuration
 */
class JWTService
{
    public const ISSUER = 'login.evepc.163.com';

    private Configuration $jwtConfig;

    public function __construct()
    {
        $this->jwtConfig = Configuration::forUnsecuredSigner();
    }

    /**
     * 验证EVE SSO的访问令牌
     */
    public function validateAccessToken(string $token): bool
    {
        $token = $this->jwtConfig->parser()->parse($token);
        return $this->jwtConfig->validator()->validate($token, ...$this->getConstraints());
    }

    /**
     * 从EVE SSO的访问令牌中获得该令牌的角色名称
     */
    public function getCharacterName(string $token): string
    {
        /** @var UnencryptedToken $res */
        $res = $this->jwtConfig->parser()->parse($token);
        return $res->claims()->get('name');
    }

    /**
     * 从EVE SSO的访问令牌中获得该令牌的角色ID
     */
    public function getCharacterId(string $token): int
    {
        /** @var UnencryptedToken $res */
        $res = $this->jwtConfig->parser()->parse($token);
        // sub的格式类似`CHARACTER:EVE:<character_id>`
        $sub = $res->claims()->get('sub');
        preg_match('/^CHARACTER:EVE:(?<id>[0-9]*)$/', $sub, $matches);
        return $matches['id'];
    }

    public function __call(string $name, array $arguments)
    {
        return $this->jwtConfig->$name(...$arguments);
    }

    private function getConstraints(): array
    {
        $issuedBy = new Constraint\IssuedBy(self::ISSUER);
        return [$issuedBy];
    }
}
