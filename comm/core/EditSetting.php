<?php
namespace comm\core;
class EditSetting
{
    
    function render($setting = [])
    {
        $html = '';
        foreach ($setting as $key => $value) {
            if (gettype($value) == 'array') {
                $html .= $this->getList($key, $this->render($value));
            } else {
                $html .= $this->getValue($key, $value);
            }
        }
        return $html;
    }

    public function getList($name, $value)
    {
        if (is_numeric($name)) {      
            return $this->getIndex($name, $value);      
        }
        $html = 
        '<div class="setting-list">
            <div class="setting-title">
                <div class="setting-group-title">' . $name . '</div>
                <div class="settion-add-item">+</div>
            </div>
            <div class="setting-group">' . $value . '</div>
        </div>';
        return $html;
    }


    public function getIndex($name, $value)
    {
        return
        '<div class="setting-index">
            <div class="setting-index-num">' . ($name + 1) . '</div>
            <div class="setting-index-group">' . $value . '</div>
        </div>';
    }

    public function getValue($name, $value)
    {
        return
        '<div class="setting-item">
            <div class="setting-name">' . $name . '</div>
            <div class="setting-value">
                <input class="input" value="' . $value . '">
            </div>
        </div>';
    }
}
