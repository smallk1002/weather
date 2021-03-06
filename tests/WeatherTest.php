<?php
/**
 * Name: 测试类.
 * User: Small_K
 * Date: 2018/12/28
 * Time: 14:00
 */

namespace Smallk\Weather\Tests;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Response;
use Mockery\Matcher\AnyArgs;
use Smallk\Weather\Exceptions\HttpException;
use Smallk\Weather\Exceptions\InvalidArgumentException;
use Smallk\Weather\Weather;
use PHPUnit\Framework\TestCase;


class WeatherTest extends TestCase
{
    /**
     * 检测 $type 参数
     *
     * @throws HttpException
     * @throws InvalidArgumentException
     */
    public function testGetWeatherWithInvalidType()
    {
        $w = new Weather('mock-key');
        // 断言会抛出此类异常
        $this->expectException(InvalidArgumentException::class);

        // 断言异常消息为 'Invalid type value(base/all): foo'
        $this->expectExceptionMessage('Invalid type value(base/all): foo');

        $w->getWeather('上海', 'foo');

        $this->fail('Failed to assert getWeather throw exception with invalid argument.');
    }

    public function testGetWeatherWithInvalidFormat()
    {
        $w = new Weather('mock-key');

        // 断言会抛出此异常
        $this->expectException(InvalidArgumentException::class);

        // 断言异常消息为 'Invalid response format: array'
        $this->expectExceptionMessage('Invalid response format: array');

        // 因为支持格式为 xml/json, 所以传入 array 会抛出异常
        $w->getWeather('上海', 'base', 'array');

        // 如果没有抛出异常，就会运行到这行，标记为当前测试没有成功
        $this->fail('Failed to assert getWeather throw exception with invalid argument.');
    }

    public function testGetWeather()
    {
        // json
        $response = new Response(200, [], '{"success": true}');
        $client = \Mockery::mock(Client::class);
        $client->allows()->get('https://restapi.amap.com/v3/weather/weatherInfo', [
            'query' => [
                'key' => 'mock-key',
                'city' => '上海',
                'output' => 'json',
                'extensions' => 'base'
            ],
        ])->andReturn($response);

        $w = \Mockery::mock(Weather::class, ['mock-key'])->makePartial();
        $w->allows()->getHttpClient()->andReturn($client);

        $this->assertSame(['success' => true], $w->getWeather('上海'));

        // xml
        $response = new Response(200, [], '<hello>content</hello>');
        $client = \Mockery::mock(Client::class);
        $client->allows()->get('https://restapi.amap.com/v3/weather/weatherInfo', [
            'query' => [
                'key' => 'mock-key',
                'city' => '上海',
                'extensions' => 'all',
                'output' => 'xml',
            ],
        ])->andReturn($response);

        $w = \Mockery::mock(Weather::class, ['mock-key'])->makePartial();
        $w->allows()->getHttpClient()->andReturn($client);

        $this->assertSame('<hello>content</hello>', $w->getWeather('上海', 'all', 'xml'));
    }

    public function testGetWeatherWithGuzzleRuntimeException()
    {
        $client = \Mockery::mock(Client::class);
        $client->allows()
            ->get(new AnyArgs())// 由于上面的用例已经验证过参数传递，所有这里就不关心参数了。
            ->andThrow(new \Exception('request timeout')); // 当前调用 get 方法时会抛出异常。
        $w = \Mockery::mock(Weather::class, ['mock-key'])->makePartial();
        $w->allows()->getHttpClient()->andReturn($client);

        // 接着需要断言调用时会产生异常
        $this->expectException(HttpException::class);
        $this->expectExceptionMessage('request timeout');

        $w->getWeather('上海');
    }

    public function testGetHttpClient()
    {
        $w = new Weather('mock-key');

        // 断言返回结果为 GuzzleHttp\ClientInterface 实例
        $this->assertInstanceOf(ClientInterface::class, $w->getHttpClient());
    }

    public function testSetGuzzleOptions()
    {
        $w = new Weather('mock-key');

        // 设置参数前， timeout 为 null
        $this->assertNull($w->getHttpClient()->getConfig('timeout'));

        // 参数设置
        $w->setGuzzleOptions(['timeout' => 5000]);

        // 设置参数后， timeout  为5000
        $this->assertSame(5000, $w->getHttpClient()->getConfig('timeout'));
    }
}