<?php
namespace app\admin;

use Iam\View;
use Iam\Page;
use Iam\Cache;
use Iam\Response;
use Model\Forum as ForumModel;
use comm\Setting;

class Theme extends \comm\core\Home
{
    public function __construct()
    {
        parent::__construct();
        if ($this->user['id'] != 1) {
            Page::error('仅限管理员访问');
            exit();
        }
        View::setConfig([
            'PATH' => 'system'
        ]);
    }

    public function setting()
    {
        View::load('admin/tpl_setting');
    }
    public function settingIframe()
    {
        View::load('admin/theme_setting_iframe');
    }

    public function getSchema()
    {
        $str = '{
            "title": "主题配置",
            "type": "object",
            "required": [
              "name",
              "age",
              "date",
              "favorite_color",
              "gender",
              "location",
              "pets"
            ],
            "properties": {
              "name": {
                "type": "string",
                "description": "First and Last name",
                "minLength": 4,
                "default": "Jeremy Dorn"
              },
              "age": {
                "type": "integer",
                "default": 25,
                "minimum": 18,
                "maximum": 99
              },
              "favorite_color": {
                "type": "string",
                "format": "color",
                "title": "favorite color",
                "default": "#ffa500"
              },
              "gender": {
                "type": "string",
                "enum": [
                  "male",
                  "female"
                ]
              },
              "date": {
                "type": "string",
                "format": "date",
                "options": {
                  "flatpickr": {}
                }
              },
              "location": {
                "type": "object",
                "title": "Location",
                "properties": {
                  "city": {
                    "type": "string",
                    "default": "San Francisco"
                  },
                  "state": {
                    "type": "string",
                    "default": "CA"
                  },
                  "citystate": {
                    "type": "string",
                    "description": "This is generated automatically from the previous two fields",
                    "template": "{{city}}, {{state}}",
                    "watch": {
                      "city": "location.city",
                      "state": "location.state"
                    }
                  }
                }
              },
              "pets": {
                "type": "array",
                "format": "table",
                "title": "Pets",
                "uniqueItems": true,
                "items": {
                  "type": "object",
                  "title": "Pet",
                  "properties": {
                    "type": {
                      "type": "string",
                      "enum": [
                        "cat",
                        "dog",
                        "bird",
                        "reptile",
                        "other"
                      ],
                      "default": "dog"
                    },
                    "name": {
                      "type": "string"
                    }
                  }
                },
                "default": [
                  {
                    "type": "dog",
                    "name": "Walter"
                  }
                ]
              }
            }
          }';
        
        $themeSchema = '{}';
        $themeSchemaPath = './theme/' . Setting::get('theme') . '/schema.json';
        if (file_exists($themeSchemaPath)) {
            $themeSchema = file_get_contents($themeSchemaPath);
        }
        return Response::write($themeSchema);
        // View::load('admin/tpl_setting', ['setting' => $setting], true);
    }

    /**
     * 获取配置
     */
    public function getSetting()
    {
        $themePath = './theme/' . Setting::get('theme');
        $cache = new Cache($themePath, 'setting');
        return Response::json($cache->get());
    }

    /**
     * 保存配置
     */
    public function saveSetting($setting = '')
    {
        if (!$setting = json_decode($setting, true)) {
            return Response::json(['err' => 1, 'msg' => '保存失败']);
        }
        
        $themePath = './theme/' . Setting::get('theme');
        $cache = new Cache($themePath, 'setting');
        $cache->set($setting);
        
        return Response::json(['msg' => '保存成功']);
    }

    /**
     * 解析配置为可编辑内容
     */
    private function parseEdit($setting = [])
    {

    }
}
