<?php
namespace app\common;

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
        return '<div class="ubb_tips '. $type .'">' . $msg . '</div>';
    }

    public static function getLink($text, $href)
    {
        return '<a href="' . $href . '">' . $text . '</a>';
    }
}
