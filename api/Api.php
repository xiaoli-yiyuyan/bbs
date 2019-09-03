<?php
namespace api;

use think\Db;
use Iam\Url;
use Iam\View;
use Iam\Page;
use Iam\Session;
use Iam\Request;
use Iam\Response;
use Model\User;
use comm\Setting;

class Api
{
    /**
     * 错误提示
     */
    private $errorMessage;
    /**
     * 错误码
     */
    private $errorCode = 0;
    /**
     * 操作提示
     */
    private $message;
    /**
     * 自定义返回数据
     */
    private $data = [];

    public function __construct()
    {
    }

    /**
     * 获取/获取 错误信息
     */
    public function error($errorCode = '', $errorMessage = '')
    {
        if ($errorCode !== '' || $errorMessage !== '') {
            $this->errorCode = $errorCode;
            $this->errorMessage = $errorMessage;
        }
        if ($this->getErrorCode() != 0) {
            return [
                'error' => $this->errorCode,
                'message' => $this->errorMessage,
            ];
        }
    }

    public function getErrorCode()
    {
        return $this->errorCode;
    }

    /**
     * 设置操作提示信息
     */
    public function message($message = '')
    {
        if ($message !== '') {
            $this->message = $message;
        }
        return $this->message;
    }

    /**
     * 获取最终返回数据
     */
    public function getReturn()
    {
        $msg = $this->message;
        if ($this->errorCode > 0) {
            $msg = $this->errorMessage;
        }
        return [
            'err' => $this->errorCode,
            'msg' => $msg,
            'data' => $this->data
        ];
    }

    /**
     * 获取/设置数据
     */
    public function data($data = '')
    {
        if ($data !== '') {
            $this->data = $data;
        }
        return $this->data;
    }
}
