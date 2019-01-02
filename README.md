<h1 align="center"> weather </h1>

<p align="center"> A weather SDK.</p>


## Installing

```shell
$ composer require smallk/weather -vvv
```
## 使用
```
    use Smallk\Weather\Weather;
    
    $key = 'xxxxxxxxxxxxxxxxxxxxxxxxxxx';
    
    $weather = new Weahter;
```
## 获取实时天气
```
 $response = $weather->getWeather('上海');
```
### 示列
```
{
    "status": "1",
    "count": "1",
    "info": "OK",
    "infocode": "10000",
    "lives": [
        {
            "province": "上海",
            "city": "上海市",
            "adcode": "310000",
            "weather": "晴",
            "temperature": "4",
            "winddirection": "东南",
            "windpower": "≤3",
            "humidity": "60",
            "reporttime": "2019-01-02 10:14:58"
        }
    ]
}
```
## 获取近期天气预报
```
    $response = $weather->getWeather('上海', 'all');
```
### 示列
```
    {
        "status": "1",
        "count": "1",
        "info": "OK",
        "infocode": "10000",
        "forecasts": [
            {
            "city": "上海市",
            "adcode": "310000",
            "province": "上海",
            "reporttime": "2019-01-02 10:14:58",
            "casts": [
                    {
                    "date": "2019-01-02",
                    "week": "3",
                    "dayweather": "多云",
                    "nightweather": "多云",
                    "daytemp": "7",
                    "nighttemp": "4",
                    "daywind": "北",
                    "nightwind": "北",
                    "daypower": "≤3",
                    "nightpower": "≤3"
                    },
                    {
                    "date": "2019-01-03",
                    "week": "4",
                    "dayweather": "阴",
                    "nightweather": "小雨",
                    "daytemp": "10",
                    "nighttemp": "5",
                    "daywind": "东北",
                    "nightwind": "东北",
                    "daypower": "≤3",
                    "nightpower": "≤3"
                    },
                    {
                    "date": "2019-01-04",
                    "week": "5",
                    "dayweather": "小雨",
                    "nightweather": "小雨",
                    "daytemp": "10",
                    "nighttemp": "8",
                    "daywind": "东",
                    "nightwind": "东",
                    "daypower": "≤3",
                    "nightpower": "≤3"
                    },
                    {
                    "date": "2019-01-05",
                    "week": "6",
                    "dayweather": "小雨",
                    "nightweather": "小雨",
                    "daytemp": "9",
                    "nighttemp": "5",
                    "daywind": "东北",
                    "nightwind": "东北",
                    "daypower": "4",
                    "nightpower": "4"
                    }
                ]
            }
        ]
    }
```
## 获取XML格式返回
```
 第三个参数返回值类型，可选 json 与 xml 默认 json
 
 $response = $weather->getWather('上海', 'all' ,'json');
 
```
### 示列
```
<response>
    <status>1</status>
    <count>1</count>
    <info>OK</info>
    <infocode>10000</infocode>
    <forecasts type="list">
    <forecast>
    <city>上海市</city>
    <adcode>310000</adcode>
    <province>上海</province>
    <reporttime>2019-01-02 10:14:58</reporttime>
    <casts type="list">
        <cast>
            <date>2019-01-02</date><week>3</week>
            <dayweather>多云</dayweather>
            <nightweather>多云</nightweather>
            <daytemp>7</daytemp>
            <nighttemp>4</nighttemp>
            <daywind>北</daywind>
            <nightwind>北</nightwind>
            <daypower>≤3</daypower>
            <nightpower>≤3</nightpower>
        </cast>
        <cast>
            <date>2019-01-03</date>
            <week>4</week>
            <dayweather>阴</dayweather>
            <nightweather>小雨</nightweather>
            <daytemp>10</daytemp>
            <nighttemp>5</nighttemp>
            <daywind>东北</daywind>
            <nightwind>东北</nightwind>
            <daypower>≤3</daypower>
            <nightpower>≤3</nightpower>
        </cast>
        <cast>
            <date>2019-01-04</date>
            <week>5</week>
            <dayweather>小雨</dayweather>
            <nightweather>小雨</nightweather>
            <daytemp>10</daytemp>
            <nighttemp>8</nighttemp>
            <daywind>东</daywind>
            <nightwind>东</nightwind>
            <daypower>≤3</daypower>
            <nightpower>≤3</nightpower>
        </cast>
        <cast>
            <date>2019-01-05</date>
            <week>6</week>
            <dayweather>小雨</dayweather>
            <nightweather>小雨</nightweather>
            <daytemp>9</daytemp>
            <nighttemp>5</nighttemp>
            <daywind>东北</daywind>
            <nightwind>东北</nightwind>
            <daypower>4</daypower>
            <nightpower>4</nightpower>
        </cast>
    </casts>
    </forecast></forecasts>
</response>
```
## 参数说明
```$xslt
array | string   getWeather(string $city, string $type = 'base', string $format = 'json')
```
字段 | 值 | 说明
---|---|---
city| string | 城市名('上海')
type| string | 返回内容类型: base : 返回实况天气 / all : 返回预报天气
format | string | 输出的数据格式，默认为 json 格式，当 output 设置为 “xml” 时，输出的为 XML 格式的数据。

## 在 Laravel 中使用
  ### 1. 在Laravel 中使用也是一样的安装方式,配置写在 config/services.php中
  ```
  [
    'weather' => [
        key => env('WEATHER_API_KEY'),
    ]
  ]
  ```
  ### 2.然后在 .env 中配置 WEATHER_API_KEY
  ```
    WEATHER_API_KEY=xxxxxxxxxxxxxxxxxxxxx
  ```
  ### 3. 方法注入参数
  ```
    public function edit (Weather $weather) 
    {
        $response = $weather->getWather('上海');    
    }
  ```
  ### 4. 服务器访问名字
  ```
    public funtion edit ()
    {
        $response = app->('weather')->getWather('上海');
    }
  ```
  
## 参考
 <a href="https://lbs.amap.com/api/webservice/guide/api/weatherinfo/">高德开放平台天气接口</a>
 
 ## License
 
 MIT