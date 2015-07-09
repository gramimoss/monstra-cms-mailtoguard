<?php

    /**
     *	Mailto Guard plugin
     *
     *	@package Monstra
     *  @subpackage Plugins
     *	@author Graeme Moss / Gambi
     *	@copyright 2014 Graeme Moss / Gambi
     *	@version 1.0.0
     *
     */


    // Register plugin
    Plugin::register( __FILE__,                    
                    __('Mailto Guard'),
                    __('Mailto Guard plugin for Monstra.'),  
                    '1.0.0',
                    'Gambi',                 
                    'http://www.gambi.co.za');

    // Add shortcode
    Shortcode::add('mailtoguard', 'mailtoguard::_shortcode');

    class mailtoguard {
        
        public static function _shortcode($attributes) {
        
            return mailtoguard::mailtoencode($attributes['email'],$attributes['cc']);
	}
        
        public static function display($email="",$cc="") {
        
            echo mailtoguard::mailtoencode($email,$cc);
	}
        
        public static function mailtoencode($email="",$cc=""){
            
            $character_set = '+-.0123456789@ABCDEFGHIJKLMNOPQRSTUVWXYZ_abcdefghijklmnopqrstuvwxyz';            
            
            if (isset($email)) {
                $guardemail = $email;
                $keyemail = str_shuffle($character_set); $cipher_text = ''; $id = 'e'.rand(1,999999999);
                for ($i=0;$i<strlen($guardemail);$i+=1) $cipher_text.= $keyemail[strpos($character_set,$guardemail[$i])];
            }
            
            if (isset($cc)) {
                $guardcc = $cc;
                $keycc = str_shuffle($character_set); $cipher_textcc = ''; $id = 'e'.rand(1,999999999);
                for ($i=0;$i<strlen($guardcc);$i+=1) $cipher_textcc.= $keycc[strpos($character_set,$guardcc[$i])];
            }

            
            
            if ((isset($keyemail))  && (empty($keycc))){
                $script = 'var a="'.$keyemail.'";var b=a.split("").sort().join("");var c="'.$cipher_text.'";var d="";';
                $script.= 'for(var e=0;e<c.length;e++)d+=b.charAt(a.indexOf(c.charAt(e)));';
                $script.= 'document.getElementById("'.$id.'").innerHTML="<a href=\\"mailto:"+d+"\\">"+d+"</a>"';
                $script = "eval(\"".str_replace(array("\\",'"'),array("\\\\",'\"'), $script)."\")"; 
                $script = '<script type="text/javascript">/*<![CDATA[*/'.$script.'/*]]>*/</script>';
                return '<span id="'.$id.'">[javascript protected email address]</span>'.$script;
                
            } elseif ((isset($keyemail)) && (isset($keycc))) {
                
                $script = 'var a="'.$keyemail.'";var b=a.split("").sort().join("");var c="'.$cipher_text.'";var d="";';
                $script.= 'for(var e=0;e<c.length;e++)d+=b.charAt(a.indexOf(c.charAt(e)));';
        
                $script.= 'var ac="'.$keycc.'";var bc=ac.split("").sort().join("");var cc="'.$cipher_textcc.'";var dc="";';
                $script.= 'for(var ec=0;ec<cc.length;ec++)dc+=bc.charAt(ac.indexOf(cc.charAt(ec)));';
                $script.= 'document.getElementById("'.$id.'").innerHTML="<a href=\\"mailto:"+d+"?cc="+dc+"\\">"+d+"</a>"';
                $script = "eval(\"".str_replace(array("\\",'"'),array("\\\\",'\"'), $script)."\")"; 
                $script = '<script type="text/javascript">/*<![CDATA[*/'.$script.'/*]]>*/</script>';
                return '<span id="'.$id.'">[javascript protected email address]</span>'.$script;   
            }
        }

    }
