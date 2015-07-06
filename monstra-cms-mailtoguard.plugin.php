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


		/**
		 * Maps Shortcode
		 *
		 *  <code>
		 *      {googlemap latlng="-28.4792625,24.6727135" markers="Point1,-28.7197555,24.7763009"}
		 *
		 *      {googlemap height="480" latlng="-28.4792625,24.6727135" markers="point1,-28.7197555,24.7763009|point2,-28.7228392,24.7570326"}
		 *
		 *      {googlemap height="480" latlng="-28.4792625,24.6727135" polylines="-29.60465,30.33349/-29.61269,30.34017|-29.61269,30.34017/-29.60604,30.36988"}
		 *
		 *      {googlemap height="480" latlng="-28.4792625,24.6727135" markers="Backup Site,-29.60465,30.33349|main Site,-29.61269,30.34017" polylines="-29.60465,30.33349/-29.61269,30.34017|-29.61269,30.34017/-29.60604,30.36988"}
		 *  </code>
		 *
		 */
    class mailtoguard {
        
        public static function _shortcode($attributes) {
            // Extract
            extract($attributes);
            $character_set = '+-.0123456789@ABCDEFGHIJKLMNOPQRSTUVWXYZ_abcdefghijklmnopqrstuvwxyz';            
            
            if (isset($email)) {
                $guardemail = $email;
                $keyemail = str_shuffle($character_set); $cipher_text = ''; $id = 'e'.rand(1,999999999);
                for ($i=0;$i<strlen($guardemail);$i+=1) $cipher_text.= $keyemail[strpos($character_set,$guardemail[$i])];
            }
            
            if (isset($cc)) {
                $guardcc = $cc;
                $keycc = str_shuffle($character_set); $cipher_text = ''; $id = 'e'.rand(1,999999999);
                for ($i=0;$i<strlen($guardcc);$i+=1) $cipher_text.= $keycc[strpos($character_set,$guardcc[$i])];
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
                $script.= 'var ac="'.$keyemail.'";var bc=ac.split("").sort().join("");var c="'.$cipher_text.'";var dc="";';
                $script.= 'for(var ec=0;ec<cc.length;ec++)dc+=bc.charAt(ac.indexOf(cc.charAt(ec)));';
                $script.= 'document.getElementById("'.$id.'").innerHTML="<a href=\\"mailto:"+d+"?cc="+dc+"\\">"+d+"</a>"';
                $script = "eval(\"".str_replace(array("\\",'"'),array("\\\\",'\"'), $script)."\")"; 
                $script = '<script type="text/javascript">/*<![CDATA[*/'.$script.'/*]]>*/</script>';
                return '<span id="'.$id.'">[javascript protected email address]</span>'.$script;   
            }
            
            
	}

    }
