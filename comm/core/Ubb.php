<?php
namespace comm\core;

use Model\User;

class Ubb
{
    private $tagFix = [
        'begin' => '\[',
        'end'   => '\]'
    ];

    private $tags = [
        'read' => [
            'name' => ['查看', 'read'],
            'value' => [
                'buy' => ['购买', 'buy'],
                'login' => ['登录', 'login'],
                'reply' => ['回复', 'reply'],
                'vip' => ['vip']
            ]
        ]
    ];

    public function rule($content)
    {
        $content = preg_replace_callback('/\[read_login\](.*?)\[\/read_login\]/', function($matches) {
            return $this->login($matches[1]);
        }, $content);
        return $content;
    }

    // [read_login][/read_login]
    // [read_buy][/read_buy]
    // [read_reply][/read_reply]
    // [read_vip1][/read_vip1]
    // [read_vip2][/read_vip2]
    // [read_vip3][/read_vip3]
    // [read_vip4][/read_vip4]
    // [read_vip5][/read_vip5]
    /**
     * 字符串替换 避免正则混淆
     * @access private
     * @param string $str
     * @return string
     */
    private function stripPreg($str)
    {
        return str_replace(
            ['{', '}', '(', ')', '|', '[', ']', '-', '+', '*', '.', '^', '?', '/'],
            ['\{', '\}', '\(', '\)', '\|', '\[', '\]', '\-', '\+', '\*', '\.', '\^', '\?', '\/'],
            $str);
    }

    private function parseTags()
    {
        $tags = [];
        $params = [];
        foreach ($this->tags as $action => $value) {
            foreach ($value['name'] as $name) {
                foreach ($value['value'] as $param => $word) {
                    foreach ($word as $item) {
                        $begin = "{$this->tagFix['begin']}({$name})=({$item}){$this->tagFix['end']}";
                        $end = "{$this->tagFix['begin']}\/({$name}){$this->tagFix['end']}";
                        $tags[] = [
                            'tag' => [$begin, $end],
                            'action' => $action,
                            'param' => $param
                        ];
                    }
                }
            }
        }
        return $tags;
    }

    public function setReadRule($context)
    {
        // $pattern = [];

        // $tags = $this->parseTags();
        // foreach ($tags as $item) {
        //     // $item['tag'][0] = $this->stripPreg($item['tag'][0]);
        //     // $item['tag'][1] = $this->stripPreg($item['tag'][1]);
        //     $pattern[] = $item['tag'][0];
        //     if (!in_array($item['tag'][1], $pattern)) {
        //         $pattern[] = $item['tag'][1];
        //     }
        // }
        // $pattern = '/' . implode('|', $pattern) . '/';
        $pattern = '/\[(查看|read)=(登录|login|回复|reply|vip,\d+)\]|\[\/(查看|read)\]/';

        $context_arr = [];

        // $matContext = preg_split($pattern, $context);
        
        preg_match_all($pattern, $context, $matTags, PREG_SET_ORDER);

        $length = count($matTags);
        for ($i = 0; $i < $length; $i ++) {
            if (count($matTags[$i]) == 4) {
                continue;
            }
            $time = 0;
            $n = 0;
            for ($_i = $i; $_i < $length; $_i ++) {
                if (count($matTags[$_i]) == 4) {
                    $time --;
                    if ($time < 0) {
                        $time = 0;
                        continue;
                    }
                } else {
                    $time ++;
                    $n ++;
                }
                $rule_data = $matTags[$i];
                $first = mb_strpos($context, $rule_data[0]);

                if ($time == 0) {
                    $end = strNPos($context, $matTags[$_i][0], $n);
                    // print_r($end);die();
                    $over_len = $end + mb_strlen($matTags[$_i][0]);

                    $i1 = $first + mb_strlen($rule_data[0]);
                    $i2 = $end - $i1;
                    $cut = mb_substr($context, $i1, $i2);
                    $c1 = $this->checkRule($cut, $rule_data[1], $rule_data[2]);
                    $context = mb_substr($context, 0, $first) . $c1 . mb_substr($context, $over_len);
                    return $this->setReadRule($context);
                    // $context;
                    break;
                }
            }
        }
        return $context;
    }

    private function checkRule($context, $action, $param)
    {
        $params = explode(',', $param);

        foreach ($this->tags as $action => $value) {
            // 判断类型
            if (in_array($action, $value['name'])) {
                foreach ($value['value'] as $param => $word) {
                    // 判断参数
                    if (in_array($params[0], $word)) {
                        return $this->runReadRule($param, $params, $context);
                    }
                }
            }
        }
    }

    private function runReadRule($param, $params, $context)
    {
        if ($this->viewInfo['user_id'] !== $this->user['id']) {
            if ($param == 'login') {
                if (!$this->isLogin()) {
                    $context = '【此内容需要登陆以后浏览】';
                }
            } elseif ($param == 'reply') {
                $list = $this->replyList([
                    'user_id' => $this->user['id'],
                    'forum_id' => $this->viewInfo['id']
                ]);
                if ($list['page']['count'] == 0) {
                    $context = '【此内容需要回复以后浏览】';
                }
            } elseif ($param == 'vip') {
                if (empty($this->user['vip_level']) || $this->user['vip_level'] < $params[1]) {
                    $context = '【此内容仅限 VIP' . $params[1] . ' 可浏览】';
                }
            }
        }
        return $context;
    }

    private function readLogin($context)
    {

    }

    public static function getTips($msg, $type = '')
    {
        return '<div class="_sys_ubb_tips '. $type .'">' . $msg . '</div>';
    }

    public static function getLink($text, $href)
    {
        return '<a href="' . $href . '">' . $text . '</a>';
    }
 
    private static $faceCode = [
        '爱你' => 'aini.gif',
        '抱抱' => 'baobao.gif',
        '不活了' => 'buhuole.gif',
        '不要' => 'buyao.gif',
        '超人' => 'chaoren.gif',
        '大哭' => 'daku.gif',
        '嗯嗯' => 'enen.gif',
        '发呆' => 'fadai.gif',
        '飞呀' => 'feiya.gif',
        '奋斗' => 'fendou.gif',
        '尴尬' => 'ganga.gif',
        '感动' => 'gandong.gif',
        '害羞' => 'haixiu.gif',
        '嘿咻' => 'heixiu.gif',
        '画圈圈' => 'huaquanquan.gif',
        '惊吓' => 'jinxia.gif',
        '敬礼' => 'jingli.gif',
        '快跑' => 'kuaipao.gif',
        '路过' => 'luguo.gif',
        '抢劫' => 'qiangjie.gif',
        '杀气' => 'shaqi.gif',
        '上吊' => 'shangdiao.gif',
        '调戏' => 'tiaoxi.gif',
        '跳舞' => 'tiaowu.gif',
        '万岁' => 'wanshui.gif',
        '我走了' => 'wozoule.gif',
        '喜欢' => 'xihuan.gif',
        '吓死人' => 'xiasiren.gif',
        '嚣张' => 'xiaozhang.gif',
        '疑问' => 'yiwen.gif',
        '做操' => 'zuocao.gif',
    ];

    public static function face($context)
    {
        foreach (self::$faceCode as $key => $value) {
            $context = str_replace("[表情:{$key}]", "<img class=\"face-chat\" src=\"/static/images/face/{$value}\" alt=\"{$key}\">", $context);
        }
        return $context;
    }

    public static function altUser($context)
    {
        $context = preg_replace_callback('/\[@:(\d+)]/', function($matches) {
            if (!$user = User::get($matches[1])) {
                return;
            }
            return '<a class="_i_alt_user" href=' . href('/user/show?id=' . $user->id) . '><span class="_i_alt" style="color: #a7e3ff;">@</span>' . $user->nickname . '</a>';
        }, $context);
        return $context;
    }

    /**
     * 设置图片ubb
     */
    public static function setViewImages($context, $img_data)
    {
        if (!empty($img_data)) {
            $img_arr = explode(',', $img_data);
            foreach ($img_arr as $key => $value) {
                $file = Db::table('file')->find($value);
                $context = str_replace("[img_{$key}]", "<img src=\"{$file['path']}\" alt=\"{$file['name']}\">",$context);
            }
        }
        return $context;
    }
}
