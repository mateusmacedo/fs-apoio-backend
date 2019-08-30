<?php


namespace App\Services\Application\Factories;


use App\Services\Application\ClaroHttpService;
use App\Services\Application\GvtHttpService;
use App\Services\Application\HeroHttpService;
use App\Services\Application\Interfaces\ClaroHttpService as IClaroHttpService;
use App\Services\Application\Interfaces\GvtHttpService as IGvtHttpService;
use App\Services\Application\Interfaces\HeroHttpService as IHeroHttpService;
use App\Services\Application\Interfaces\OiHttpService as IOiHttpService;
use App\Services\Application\Interfaces\TimHttpService as ITimHttpService;
use App\Services\Application\Interfaces\VivoHttpService as IVivoHttpService;
use App\Services\Application\OiHttpService;
use App\Services\Application\TimHttpService;
use App\Services\Application\VivoHttpService;
use GuzzleHttp\Client;
use UnexpectedValueException;

class HttpServiceFactory
{
    public static function create(string $httpService)
    {
        switch ($httpService) {
            case IClaroHttpService::class:
                return static::CreateClaroHttpService();
                break;
            case IGvtHttpService::class:
                return static::CreateGvtHttpService();
                break;
            case IHeroHttpService::class:
                return static::CreateHeroHttpService();
                break;
            case ITimHttpService::class:
                return static::CreateTimHttpService();
                break;
            case IOiHttpService::class:
                return static::CreateOiHttpService();
                break;
            case IVivoHttpService::class:
                return static::CreateVivoHttpService();
                break;
            default:
                throw new UnexpectedValueException('Namespace not valid');
                break;
        }
    }

    private static function CreateClaroHttpService()
    {
        $options = [
            'base_uri' => env('CLARO_BASE_URI', ''),
            'timeout' => 2.0
        ];
        $httpClient = new Client($options);
        return new ClaroHttpService($httpClient);
    }

    private static function CreateGvtHttpService()
    {
        $options = [
            'base_uri' => env('GVT_BASE_URI', ''),
            'timeout' => 2.0
        ];
        $httpClient = new Client($options);
        return new GvtHttpService($httpClient);
    }

    private static function CreateHeroHttpService()
    {
        $options = [
            'base_uri' => env('HERO_BASE_URI', ''),
            'timeout' => 2.0
        ];
        $httpClient = new Client($options);
        return new HeroHttpService($httpClient);
    }

    private static function CreateTimHttpService()
    {
        $options = [
            'base_uri' => env('TIM_BASE_URI', ''),
            'timeout' => 2.0
        ];
        $httpClient = new Client($options);
        return new TimHttpService($httpClient);
    }

    private static function CreateOiHttpService()
    {
        $options = [
            'base_uri' => env('OI_BASE_URI', ''),
            'timeout' => 2.0
        ];
        $httpClient = new Client($options);
        return new OiHttpService($httpClient);
    }

    private static function CreateVivoHttpService()
    {
        $options = [
            'base_uri' => env('VIVO_BASE_URI', ''),
            'timeout' => 2.0
        ];
        $httpClient = new Client($options);
        return new VivoHttpService($httpClient);
    }
}
