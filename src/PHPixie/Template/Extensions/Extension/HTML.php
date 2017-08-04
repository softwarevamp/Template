<?php

namespace PHPixie\Template\Extensions\Extension;

class HTML implements \PHPixie\Template\Extensions\Extension
{
    public function name()
    {
        return 'html';
    }
    
    public function methods()
    {
        return array(
            'htmlEscape' => 'escape',
            'htmlOutput' => 'output',
            'if'         => 'shortIf'
        );
    }
    
    public function aliases()
    {
        return array(
            '_' => 'escape'
        );
    }

    public function escape($string)
    {
        // TODO: translate with i18n
        $translations = array(
            'phase' => '阶段',
            'region' => '地域',
            'date' => '时间'
        );
        
        if (isset($translations[$string])) {
            $string = $translations[$string];
        }
        
        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }
    
    public function output($string)
    {
        echo $this->escape($string);
    }

    public function shortIf($condition, $ifTrue, $ifFalse = null)
    {
        return $condition ? $ifTrue : $ifFalse;
    }
}