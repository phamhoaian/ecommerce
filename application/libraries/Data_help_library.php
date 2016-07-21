<?php

/**
 * Data class
 * m.haba
 */
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}


class Data_help_library {


    function nl2br_p($str)
    {
		#$CI =& get_instance();	
		#$CI->load->library('typography');
		
		$str = str_replace(array("\r\n", "\r"), "\n", $str);
		$str = str_replace("\n\n", "</p><p>", $str);
		$str = str_replace("\n", "<br />\n", $str);
		$str = str_replace("</p><p>", "</p>\n\n<p>", $str);
		
		$str = "<p>".$str."</p>";
		
		$str = str_replace(array("<br /><br />", "<p></p>","<br />\n<br />"), "", $str);
		$str = str_replace("/p><p", "/p>\n\n<p", $str);

		return $str;
    }


    function nl2br_reverse($str)
    {
		$str = str_replace(array("<p>", "</p>", "<br />"), "", $str);
		return $str;
    }


    function reverse_array($str)
    {
		$str = htmlspecialchars_decode($str);
		$str = unserialize($str);
		return $str;
    }


	#
	# 数字の整形
	#
	function get_int_dispose($tmp_int,$keta=2,$rev=""){
		$tmp = mb_convert_kana($tmp_int,"akR");
		if (strlen($tmp) < $keta) {
			$str = $keta-strlen($tmp);
			if($rev){
				for ($i=0; $i<$str; $i++) $tmp = $tmp.' ';
			}else{
				for ($i=0; $i<$str; $i++) $tmp = ' '.$tmp;
			}
		}
		return $tmp;
	}



	#
	# 数字の整形(桁数が少ないときに0と追加して合わせる)
	#
	function get_int_dispose_zero($tmp_int,$keta=2){
		$tmp = mb_convert_kana($tmp_int,"akR");
		if (strlen($tmp) < $keta) {
			$str = $keta-strlen($tmp);
			for ($i=0; $i<$str; $i++) $tmp = '0'.$tmp;
		}
		return $tmp;
	}

	# 12桁の数字から日付を取得する （$scopeは year day hour minute）
    function get_date_format($str,$scope="minute")
    {
		if ( preg_match("/^(\d{4})(\d{2})(\d{2})(\d{2})(\d{2})$/", $str, $this->regs) ){
			$this->year = $this->regs[1];
			$this->month = $this->regs[2];
			$this->day = $this->regs[3];
			$this->hour = $this->regs[4];
			$this->minute = $this->regs[5];
			
			if($scope =="day"){
				$str = (int)$this->month."/".(int)$this->day;
			}elseif($scope =="hour"){
				$str = (int)$this->month."/".(int)$this->day." ".(int)$this->hour."時";
			}elseif($scope =="minute"){
				$str = (int)$this->month."/".(int)$this->day." ".(int)$this->hour.":".(int)$this->minute;
			}elseif($scope =="year"){
				$str = $this->year."/".(int)$this->month."/".(int)$this->day." ".(int)$this->hour.":".$this->minute;
			}else{
				$str = "";
			}
			
		}else{
			$str = "";
		}
		return $str;
    }
    
    
    
    
    

    //
	// 日付のフォーマットを返す(mysqlのdatetime用)
	//
	function get_datetime_format($timestamp,$format='daytime')
	{
		if( ! preg_match("/^([0-9]{4})-([0-9]{2})-([0-9]{2}) ([0-9]{2}):([0-9]{2}):([0-9]{2})/s", $timestamp ,$regex))
		{
			return FALSE;
		}
		
		
		if( $format == 'daytime' )
		{
			return $regex[2]."/".$regex[3]." ".$regex[4].":".$regex[5];
		}
		else if( $format == 'day' )
		{
			return $regex[1] ."/". $regex[2]."/".$regex[3];
		}
		else
		{
			return $regex[1]."/".$regex[2]."/".$regex[3]." ".$regex[4].":".$regex[5];
		}
	}
    
    
    
    
    


	function truncate($string, $length = 80, $etc = '...', $break_words = true)
	{
		if ($length == 0)
			return '';
		
		
		$string = $this->delete_emoji_tag($string);
		$string = strip_tags($string);
		
		
		$from = array('&amp;', '&lt;', '&gt;', '&quot;', '&#039;',"\r","\n");
		$to   = array('&', '<', '>', '"', "'",'','');
		$string = str_replace($from, $to, $string);
		
		if (strlen($string) > $length) {
			$length -= strlen($etc);
			if (!$break_words)
				$string = preg_replace('/\s+?(\S+)?$/', '', substr($string, 0, $length+1));

			$string = mb_strimwidth($string, 0, $length) . $etc;
		}
		return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
	}


    function get_one_paragraph($str)
    {
    	$str_return = "";
    	if ( preg_match("/^(.*)\n\n/", $str, $this->regs) ){
    		$str_return = $this->regs[1];
    	}else{
    		$str_return = $this->truncate($str,"100");
    	}
    	return $str_return;
    }


    function get_one_sentence($str)
    {
    	$str_return = "";
    	$str = $this->truncate($str,"160");
    	if ( preg_match("/^(.*?。).*/", $str, $this->regs) ){
    		$str_return = $this->regs[1];
    	}else{
    		#$str_return = $this->truncate($str,"100");
    		$str_return = $str;
    	}
    	return $str_return;
    }





    function delete_emoji_tag($str)
    {
    	$moji_pattern = '/\[([ies]:[0-9]{1,3})\]/';
    	return preg_replace($moji_pattern,'', $str);
    }
	



    function get_player_battle_style($flag_shake = false,$flag_pen= false,$flag_cut= false){
        // load language
        $this->ci =& get_instance();
        $this->ci->lang->load('data_help');
        
        $battle_style = "";
        if($flag_shake){
            $battle_style .= $this->ci->lang->line('player_battle_style_shake_attack');
        }
        if($flag_pen){
            if($battle_style){
                $battle_style .= $this->ci->lang->line('player_battle_style_comma');
            }
            $battle_style .= $this->ci->lang->line('player_battle_style_pen_holder'); 
        }
        if($flag_cut){
            if($battle_style){
                $battle_style .= $this->ci->lang->line('player_battle_style_comma');
            }
            $battle_style .= $this->ci->lang->line('player_battle_style_cut_type'); 
        } 
        return $battle_style;
    }



	/*
	 * Google Translate API Reference
	 * Language supported: https://cloud.google.com/translate/v2/translate-reference#supported_languages
	 * $source : The language of the source text. The value should be one of the language codes listed in language supported above
	 * $target : The language to translate the source text into. The value should be one of the language codes listed in language supported above
	 * $data : source array (or text) want to traslate, the value text length should be < 2000 characters
	 * If the value length > 2000 character, the text will not translate
	 * 
	 * EX1: (normal data)
	 * ** data source is array:
	 * $data = array(
	 * 		"text1" => "text1_value",
	 * 		"text2" => "text2_value",
	 * 		...
	 * );
	 * 
	 * $result = array(
	 * 		"text1" => "text1_translated",
	 * 		"text2" => "text2_translated",
	 * 		...
	 * );
	 * ===============================
	 * ** data source is text:
	 * $data = "text_data_value";
	 * $result = "text_data_translated";
	 * 
	 * 
	 * 
	 * 
	 * EX2: (data with text too long)
	 * ** data source is array:
	 * $data = array(
	 * 		"text1" => "text1_value",
	 * 		"text2" => "text2_value",
	 * 		"text3" => "text3_value", // text3_value lenght > 2000 characters
	 * 		"text4" => "text4_value",
	 * 		...
	 * );
	 * 
	 * $result = array(
	 * 		"text1" => "text1_translated",
	 * 		"text2" => "text1_translated",
	 * 		"text3" => "text3_value", // text3_value did not translate because lenght > 2000 characters
	 * 		"text4" => "text1_translated",
	 * 		...
	 * );
	 * 
	 * ===============================
	 * ** data source is text:
	 * $data = "text_data_value"; // text_data_value lenght > 2000 characters
	 * $result = "text_data_value"; // text_data_value did not translate because lenght > 2000 characters
	 * 
	 */
	 
	function translate_google_api($source,$target,$data){
		if($source == $target){
			return $data;
		}
		
		$google_api_key = GOOGLE_TRANSLATE_API_KEY;
		$url = "https://www.googleapis.com/language/translate/v2?key=$google_api_key&source=$source&target=$target";
		$request = "";
		$data_request = array();
		$max_n = 0;
		$min_n = 0;
		$is_string = false;
		if(!is_array($data)){
			$is_string = true;
			$data = array($data);
		}
		foreach($data as $key => $value){
			$_request = "&q=".rawurlencode($value);
			if((strlen($url) + strlen($request) + strlen($_request)) > 2000){
				if($request){
					array_push($data_request,array("url"=>$url.$request,"max_key"=>$max_n-1,"min_key"=>$min_n,"text_long"=>0));
					$request = "";
					$min_n = $max_n;
				}
				
				if((strlen($url) + strlen($_request) > 2000)){
					// text too long
					// this param will not request translate google api: "text_long" = true
					array_push($data_request,array("url"=>"","max_key"=>$max_n,"min_key"=>$max_n,"text_long"=>1,"text_value"=>$value));
					$max_n++;
					$request = "";
					$_request = "";
					$min_n = $max_n;
					continue;
				}
			}
			$max_n++;
			$request .= $_request;
		}
		if($request){
			array_push($data_request,array("url"=>$url.$request,"max_key"=>$max_n-1,"min_key"=>$min_n,"text_long"=>0));
		}
		// print_r($data_request);exit;
		
		if($data_request){
			$result = array();
			foreach($data_request as $arr_reqest_url){
				$reqest_url = $arr_reqest_url["url"];
				$max_key = $arr_reqest_url["max_key"];
				$min_key = $arr_reqest_url["min_key"];
				$text_long = $arr_reqest_url["text_long"];
				
				if($text_long == 0){
					$ch = curl_init($reqest_url);
				    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				    $translate_response = curl_exec($ch);                 
				    curl_close($ch);
					$translate_response = json_decode($translate_response,true); //true converts stdClass to associative array.
					if($translate_response != null)
					{
					    if(!isset($translate_response['error']))
					    {
					    	$translated = $translate_response['data']['translations'];
							$translate_data = array();
							$i = 0;
							$j = 0;
							foreach($data as $key=>$val){
								if($i == $min_key){
									$j = 0;
								}
								if($i >= $min_key && $i <= $max_key){
									$translate_data[$key] = htmlspecialchars_decode($translated[$j]["translatedText"]);
								}
								$j++;
								$i++;
							}
							$result = array_merge($result,$translate_data);
					    }
					}
				}else{
					// text too long, use post to google trnaslate API
					$values = array(
						'q' => $arr_reqest_url["text_value"]
					);
					 
					$formData = http_build_query($values);
					
					$ch = curl_init($url);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($ch, CURLOPT_POSTFIELDS, $formData); // write the form data to the request in the post body
					curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-HTTP-Method-Override: GET'));// include the header to make Google treat this post request as a get request
					$json = curl_exec($ch);
					curl_close($ch);
					$translate_response = json_decode($json,true); //true converts stdClass to associative array.
					
					$translated = $arr_reqest_url["text_value"];
					if($translate_response != null)
					{
					    if(!isset($translate_response['error']))
					    {
					    	$translated = $translate_response['data']['translations'][0]['translatedText'];
					    }
					}
					
					$translate_data = array();
					$i = 0;
					foreach($data as $key=>$val){
						if($i >= $min_key && $i <= $max_key){
							$translate_data[$key] = htmlspecialchars_decode($translated);
						}
						$i++;
					}
					
					$result = array_merge($result,$translate_data);
				}
			}

			if(!array_diff_key($data, $result)){
				// 
				$data = $result;
			}
		}
		if($is_string){
			return $data[0];
		}
		return $data;
	}

}

?>