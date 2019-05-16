<?php
class IamApp
{
    protected static $conf = [];
    protected static $app = [];

    private $module;
    private $name;
    private $data = [];

    public function __construct($module)
    {
        $this->module = $module;
    }

    public static function config($conf = [])
    {
        if (!empty($conf)) {
            self::$conf = $conf;
        }
    }
    private static function http($url, $params, $method = 'GET', $header = array(), $multi = false)
    {
        $opts = array(
                CURLOPT_TIMEOUT        => 30,
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false,
                //CURLOPT_HEADER => TRUE,
                CURLOPT_HTTPHEADER     => $header
        );

        /* 根据请求类型设置特定参数 */
        switch(strtoupper($method)){
            case 'GET':
                $opts[CURLOPT_URL] = $url . '?' . http_build_query($params);
                break;
            case 'POST':
                //判断是否传输文件
                $params = json_encode($params); //$multi ? $params : http_build_query($params);
                print_r($params);
                $opts[CURLOPT_URL] = $url;
                $opts[CURLOPT_POST] = 1;
                $opts[CURLOPT_POSTFIELDS] = $params;
                break;
            default:
                throw new Exception('不支持的请求方式！');
        }
        /* 初始化并执行curl请求 */
        $ch = curl_init();
        curl_setopt_array($ch, $opts);
        $data  = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);
        if($error) throw new Exception('请求发生错误：' . $error);
        return  $data;
    }

    private function emit()
    {
        $module = $this->module;
        $name = $this->name;
        $data = $this->data;

        $key = self::$conf['key'];
        $appid = self::$conf['appid'];
        $host = self::$conf['host'];
        $sign = md5(json_encode($data) . $module . $name . $key . $appid);
        $params = http_build_query([
            'key' => $key,
            'appid' => $appid,
            'sign' => $sign,
            'module' => $module,
            'name' => $name
        ]);
        $url = $host . '?' . $params;
        return self::http($url, $data, 'POST');
    }

    public function use($module)
    {
        if (empty($app[$module])) {
            self::$app[$module] = new IamApp($module);
        }
        return self::$app[$module];
    }

    public function data($data = [])
    {
        $this->data = $data;
        return $this;
    }

    public function action($name)
    {
        $this->name = $name;
        return $this->emit();
    }
}
IamApp::config([
    'key' => '15s4d4a3444df4tsd4fa5sd487a',
    'appid' => '1',
    'host' => 'api.app.ianmi.com'
]);
IamApp::use('chat')->data()->action('add');
