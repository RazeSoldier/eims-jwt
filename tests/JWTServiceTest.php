<?php
/**
 * Author: RazeSoldier (razesoldier@outlook.com)
 * License: Apache-2.0
 */

use Orchestra\Testbench\TestCase;
use RazeSoldier\EIMS\Jwt\JWTService;
use RazeSoldier\EIMS\Jwt\JWTServiceProvider;

class JWTServiceTest extends TestCase
{
    public function testParse()
    {
        $service = resolve(JWTService::class);
        $token = 'eyJhbGciOiJSUzI1NiIsImtpZCI6IkpXVC1TaWduYXR1cmUtS2V5IiwidHlwIjoiSldUIn0.eyJzY3AiOiJlc2ktY29udHJhY3RzLnJlYWRfY2hhcmFjdGVyX2NvbnRyYWN0cy52MSIsImp0aSI6IjgxOTY2N2FjLTkxMzYtNDVjYS1iY2UyLTBlNjgyMzJmMzVjMCIsImtpZCI6IkpXVC1TaWduYXR1cmUtS2V5Iiwic3ViIjoiQ0hBUkFDVEVSOkVWRToyMTEyMjU5MzYzIiwiYXpwIjoiYmM5MGFhNDk2YTQwNDcyNGE5M2Y0MWI0ZjRlOTc3NjEiLCJ0ZW5hbnQiOiJzZXJlbml0eSIsInRpZXIiOiJsaXZlIiwicmVnaW9uIjoiY2hpbmEiLCJuYW1lIjoiUmF6ZVNvbGRpZXIiLCJvd25lciI6IlYyclhhY1B4VURuc3FSVGFCNm51NXZlQ05IST0iLCJleHAiOjE2MzU0MzMxODgsImlzcyI6ImxvZ2luLmV2ZXBjLjE2My5jb20ifQ.AAA';
        $res = $service->parser()->parse($token);
        $this->assertTrue($res->hasBeenIssuedBy('login.evepc.163.com'));
        $this->assertFalse($res->hasBeenIssuedBy('login.eveonline.com'));
    }

    public function testValidate()
    {
        $service = resolve(JWTService::class);
        $token = 'eyJhbGciOiJSUzI1NiIsImtpZCI6IkpXVC1TaWduYXR1cmUtS2V5IiwidHlwIjoiSldUIn0.eyJzY3AiOiJlc2ktY29udHJhY3RzLnJlYWRfY2hhcmFjdGVyX2NvbnRyYWN0cy52MSIsImp0aSI6IjgxOTY2N2FjLTkxMzYtNDVjYS1iY2UyLTBlNjgyMzJmMzVjMCIsImtpZCI6IkpXVC1TaWduYXR1cmUtS2V5Iiwic3ViIjoiQ0hBUkFDVEVSOkVWRToyMTEyMjU5MzYzIiwiYXpwIjoiYmM5MGFhNDk2YTQwNDcyNGE5M2Y0MWI0ZjRlOTc3NjEiLCJ0ZW5hbnQiOiJzZXJlbml0eSIsInRpZXIiOiJsaXZlIiwicmVnaW9uIjoiY2hpbmEiLCJuYW1lIjoiUmF6ZVNvbGRpZXIiLCJvd25lciI6IlYyclhhY1B4VURuc3FSVGFCNm51NXZlQ05IST0iLCJleHAiOjE2MzU0MzMxODgsImlzcyI6ImxvZ2luLmV2ZXBjLjE2My5jb20ifQ.AAA';
        $this->assertTrue($service->validateAccessToken($token));
    }

    public function testCharacterName()
    {
        $service = resolve(JWTService::class);
        $token = 'eyJhbGciOiJSUzI1NiIsImtpZCI6IkpXVC1TaWduYXR1cmUtS2V5IiwidHlwIjoiSldUIn0.eyJzY3AiOiJlc2ktY29udHJhY3RzLnJlYWRfY2hhcmFjdGVyX2NvbnRyYWN0cy52MSIsImp0aSI6IjgxOTY2N2FjLTkxMzYtNDVjYS1iY2UyLTBlNjgyMzJmMzVjMCIsImtpZCI6IkpXVC1TaWduYXR1cmUtS2V5Iiwic3ViIjoiQ0hBUkFDVEVSOkVWRToyMTEyMjU5MzYzIiwiYXpwIjoiYmM5MGFhNDk2YTQwNDcyNGE5M2Y0MWI0ZjRlOTc3NjEiLCJ0ZW5hbnQiOiJzZXJlbml0eSIsInRpZXIiOiJsaXZlIiwicmVnaW9uIjoiY2hpbmEiLCJuYW1lIjoiUmF6ZVNvbGRpZXIiLCJvd25lciI6IlYyclhhY1B4VURuc3FSVGFCNm51NXZlQ05IST0iLCJleHAiOjE2MzU0MzMxODgsImlzcyI6ImxvZ2luLmV2ZXBjLjE2My5jb20ifQ.AAA';
        $this->assertSame('RazeSoldier', $service->getCharacterName($token));
    }

    public function testCharacterId()
    {
        $service = resolve(JWTService::class);
        $token = 'eyJhbGciOiJSUzI1NiIsImtpZCI6IkpXVC1TaWduYXR1cmUtS2V5IiwidHlwIjoiSldUIn0.eyJzY3AiOiJlc2ktY29udHJhY3RzLnJlYWRfY2hhcmFjdGVyX2NvbnRyYWN0cy52MSIsImp0aSI6IjgxOTY2N2FjLTkxMzYtNDVjYS1iY2UyLTBlNjgyMzJmMzVjMCIsImtpZCI6IkpXVC1TaWduYXR1cmUtS2V5Iiwic3ViIjoiQ0hBUkFDVEVSOkVWRToyMTEyMjU5MzYzIiwiYXpwIjoiYmM5MGFhNDk2YTQwNDcyNGE5M2Y0MWI0ZjRlOTc3NjEiLCJ0ZW5hbnQiOiJzZXJlbml0eSIsInRpZXIiOiJsaXZlIiwicmVnaW9uIjoiY2hpbmEiLCJuYW1lIjoiUmF6ZVNvbGRpZXIiLCJvd25lciI6IlYyclhhY1B4VURuc3FSVGFCNm51NXZlQ05IST0iLCJleHAiOjE2MzU0MzMxODgsImlzcyI6ImxvZ2luLmV2ZXBjLjE2My5jb20ifQ.AAA';
        $this->assertSame(2112259363, $service->getCharacterId($token));
    }

    protected function getPackageProviders($app)
    {
        return [JWTServiceProvider::class];
    }
}
