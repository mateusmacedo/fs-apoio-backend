<?php


namespace App\Services\Application;


use SplEnum;

class HttpMethodEnum extends SplEnum
{
    const __default = self::GET;

    const GET = 0;
    const POST = 1;
    const PUT = 2;
    const DELETE = 3;
    const PATCH = 4;
    const HEAD = 5;
    const OPTIONS = 6;
    const CONNECT = 7;
    const TRACE = 8;

}
