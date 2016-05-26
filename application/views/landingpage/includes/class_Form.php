<?
class Form {
	var $DISPLAY_FORMAT = "HTML";
	var $Action = "";
	var $Method = "post";
	var $Target = false;
	var $Enctype = false;
	
	var $Capitalize = false;

	var $f_type_group = array();	
	var $f_type = array();	
	var $f_name = array();
	var $f_value = array();
	var $f_label = array();
	var $f_options = array();
	var $f_size = array();
	var $prefix = array();
	var $postfix = array();

	function Form($format = NULL)
	{
		$this->DISPLAY_FORMAT = $format;
	}
	
	function field() 
	{
		$args = func_get_args();
		$type = strtoupper( array_shift($args) );
		$name = array_shift($args);
		$value = $label = $prefix = $postfix = $size = NULL;
		
		switch($type) {
			case "LABEL":
				$type_group = 0;
				$value = NULL;
				$label =  array_shift($args);
				$size = NULL;
				$options = NULL;
				break;
			
			case "HIDDEN":
				$type_group = 1;
				$value =  array_shift($args);
				$label = NULL;
				$size = NULL;
				$options = NULL;
				break;
			
			case "TEXT":
			case "NUMBER":
			case "PASSWORD":
				$type_group = 1;
				$value = array_shift($args);
				$label = array_shift($args);
				$size = array_shift($args);
				$prefix = array_shift($args);
				$postfix = array_shift($args);
				$options = NULL;
				break;
				
			case "FILE":
				$type_group = 1;
				$this->Enctype = "multipart/form-data";
				$value = array_shift($args);
				$label = array_shift($args);
				$size = array_shift($args);
				$options = NULL;
				break;
						
			case "SELECT":
			case "RADIO":
			case "CHECKBOX":
				$type_group = 2;
				$value = array_shift($args);
				$label = array_shift($args);
				$options = array_shift($args);
				$size = array_shift($args);
				break;
			
						
			case "TEXTAREA":
				$type_group = 3;
				$value = array_shift($args);
				$label = array_shift($args);
				$options = array_shift($args);
				break;
			
			case "IMAGE":
				$type_group = 4;
				$value = array_shift($args);
				$label = array_shift($args);
				$options = array_shift($args);
				break;
				
			case "SUBMIT":
			case "RESET":
				$type_group = 5;
				$value = $name;
				$label = NULL;
				$options = array_shift($args);
					
				break;
		}
	
		array_push($this->f_type_group, $type_group );	
		array_push($this->f_type, $type );
		array_push($this->f_name, stripslashes($name) );
		array_push($this->f_value, stripslashes($value) );
		array_push($this->f_label, stripslashes($label) );
		array_push($this->f_options, $options);
		array_push($this->f_size, (int)$size);
		array_push($this->prefix, $prefix);
		array_push($this->postfix, $postfix);
	}
	
	function code()
	{
#		$code = "This is the ". $this->DISPLAY_FORMAT ." version<br />\n\n";
		$code = "";
		
		if($this->DISPLAY_FORMAT == 'HTML' || $this->DISPLAY_FORMAT == 'XHTML') {
			$code .= $this->generate_html();
		} elseif($this->DISPLAY_FORMAT == 'WML') {
			$code .= $this->generate_wml();
		}
		return $code;
	}
	
	function generate_html() 
	{
		$out = array();
		$out[] = "<p align=\"center\"><form style=\"text-align:left;\" ".
			"action=\"{$this->Action}\" ".
			"method=\"{$this->Method}\" ".
			($this->Target? "target=\"{$this->Target}\" ":"").
			($this->Enctype? "enctype=\"{$this->Enctype}\" ":"").
			">";
		
		for($i = 0; $i < sizeof($this->f_type); $i++) {
			$out[] = $this->generate_field($i);
		}
		
		$out[] = "</form></p>\n";
		return implode("\n", $out);
	}
	
	function generate_wml() 
	{
		$out = array();

		for($i = 0; $i < sizeof($this->f_type); $i++) {
			$out[] = $this->generate_field($i);
		}
		
        $out[] = "<anchor>";

		if( in_array("IMAGE", $this->f_type) ) {
			$key = array_search("IMAGE",$this->f_type);
        	$out[] = "<input type=\"image\" src=\"". $this->f_value[$key] ."\" border=\"0\" />";
		} elseif( in_array("SUBMIT", $this->f_type) ) {
			$key = array_search("SUBMIT",$this->f_type);
#        	$out[] = "<input type=\"submit\" value=\"". $this->f_value[$key] ."\" />";
			$out[] = $this->f_value[$key];
		} else {
			$out[] = "[Continue]";
		}
	
        $out[] = "<go href=\"".$this->Action."\" method=\"".$this->Method."\">";
		for($i = 0; $i < sizeof($this->f_type); $i++) {
			if( strtoupper($this->f_type[$i]) != 'SUBMIT' && strtoupper($this->f_type[$i]) != 'IMAGE' && strtoupper($this->f_type[$i]) != 'RESET' )
				$out[] = "<postfield name=\"". $this->f_name[$i] ."\" value=\"$(". $this->f_name[$i] .")\" />";
		}		
        $out[] = "</go>";
        $out[] = "</anchor>";

		$out[] = "<do type=\"accept\" label=\"Submit\">";
        $out[] = "<go href=\"".$this->Action."\" method=\"".$this->Method."\">";
		for($i = 0; $i < sizeof($this->f_type); $i++) {
			if( strtoupper($this->f_type[$i]) != 'SUBMIT' && strtoupper($this->f_type[$i]) != 'IMAGE' && strtoupper($this->f_type[$i]) != 'RESET' )
				$out[] = "<postfield name=\"". $this->f_name[$i] ."\" value=\"$(". $this->f_name[$i] .")\" />";
		}		
        $out[] = "</go>";
		$out[] = "</do>";

		return implode("\n", $out);		
	}
	
	function generate_field($i) 
	{
		$code = ($this->prefix[$i]? $this->prefix[$i]:"");
		if($this->f_type_group[$i] == 1) 
		{
			if($this->f_type[$i] == "NUMBER") {
				$code .= "<input type=\"text\" name=\"". $this->f_name[$i] ."\"  unedited=\"true\" value=\"". $this->f_value[$i] ."\" ". ($this->f_size[$i]? "size=\"".$this->f_size[$i]."\"":"") ."  format=\"*N\" emptyok=\"false\" />";
			} elseif($this->f_type[$i] == "FILE") {
				$code .= "<input type=\"". strtolower($this->f_type[$i]) ."\" name=\"". $this->f_name[$i] ."\" unedited=\"true\" /><br />".
						"<small>[current: <a href=\"". $this->f_value[$i] ."\" target=\"preview\">". $this->f_value[$i] ."</a>]</small>";
			} else {
				$code .= "<input type=\"". strtolower($this->f_type[$i]) ."\" name=\"". $this->f_name[$i] ."\" value=\"". $this->f_value[$i] ."\" ". ($this->f_size[$i]? "size=".$this->f_size[$i]:"") ." />";
			}		
			
		} 
		elseif($this->f_type_group[$i] == 2) 
		{
			if($this->f_type[$i] == "SELECT") {
				$code .= "<select size=". $this->f_size[$i] ." name=\"". $this->f_name[$i] ."\">\n";
				foreach($this->f_options[$i] as $key=>$val) {
					$code .= "<option value=\"{$key}\" ". ($key == $this->f_value[$i]? "SELECTED":"") .">{$val}</option>";
				}
				$code .= "</select>\n";
			} else {
				if($this->DISPLAY_FORMAT == 'HTML' || $this->DISPLAY_FORMAT == 'XHTML') {
					if( is_array($this->f_options[$i]) ) {
						foreach($this->f_options[$i] as $key=>$val) {
							if ($this->f_type[$i] == "CHECKBOX") {
								$code .= "<input type=\"". strtolower($this->f_type[$i]) ."\" name=\"". $this->f_name[$i] ."[]\" value=\"{$key}\" ". ($key == $this->f_value[$i]? "CHECKED":"") ." id=\"". md5($this->f_name[$i] ."_".$key) ."\"> <label for=\"". md5($this->f_name[$i] ."_".$key) ."\">". stripslashes($val) ."</label> ";
							} else {
								$code .= "<input type=\"". strtolower($this->f_type[$i]) ."\" name=\"". $this->f_name[$i] ."\" value=\"{$key}\" ". ($key == $this->f_value[$i]? "CHECKED":"") ." id=\"". md5($this->f_name[$i] ."_".$key) ."\"> <label for=\"". md5($this->f_name[$i] ."_".$key) ."\">". stripslashes($val) ."</label> ";
							}
						}
					} else {
						$code .= "<input title=\"". $this->f_name[$i] ."\" type=\"". strtolower($this->f_type[$i]) ."\" name=\"". $this->f_name[$i] ."\" value=\"". $this->f_options[$i] ."\" ". ($this->f_options[$i] == $this->f_value[$i]? "CHECKED":"") ." id=\"". md5($this->f_name[$i] ."_". $this->f_options[$i]) ."\"> <label for=\"". md5($this->f_name[$i] ."_". $this->f_options[$i]) ."\">". stripslashes($this->f_options[$i]) ."</label> ";
					}
				} elseif($this->DISPLAY_FORMAT == 'WML') {
					$code .= "<select name=\"". $this->f_name[$i] ."\">";
					$code .= "<optgroup title=\"". $this->f_label[$i] ."\" ivalue=\"". $this->f_value[$i] ."\" value=\"". $this->f_value[$i] ."\">";
					if( is_array($this->f_options[$i]) ) {
						foreach($this->f_options[$i] as $key=>$val) {
							$code .= "<option value=\"{$key}\">". stripslashes($val) ."</option> ";
						}
					} else {
						$code .= "<option value=\"". $this->f_options[$i] ."\">". stripslashes($this->f_options[$i]) ."</option> ";
					}			
					$code .= "</optgroup></select>";
				
				}
			}

		} 
		elseif($this->f_type_group[$i] == 3) 
		{
			$code .= "<textarea name=\"". $this->f_name[$i] ."\" unedited=\"true\" ". $this->f_options[$i] .">". $this->f_value[$i] ."</textarea>";

		} 
		elseif($this->f_type_group[$i] == 4 && $this->DISPLAY_FORMAT != 'WML')
		{
			$code .= "<input type=\"". strtolower($this->f_type[$i]) ."\" name=\"". $this->f_name[$i] ."\" src=\"". $this->f_value[$i] ."\" />";

		} 
		elseif($this->f_type_group[$i] == 5 && $this->DISPLAY_FORMAT != 'WML') 
		{
			$code .= "<input type=\"". strtolower($this->f_type[$i]) ."\" ". (strtolower($this->f_type[$i]) == "cancel"? "class=\"clearButton\"":"class=\"bigButton\"") ." unedited=\"true\" value=\"". $this->f_value[$i] ."\" />";
		}
		
		$code .= ($this->postfix[$i]? $this->postfix[$i]:"");

		
		$out = array();
		if($this->DISPLAY_FORMAT == 'HTML' || $this->DISPLAY_FORMAT == 'XHTML') 
		{
		
			if($this->f_type[$i] != 'HIDDEN') $out[] = "<div class=\"FieldGroup\">";
			if($this->f_label[ $i ] && $this->f_type[$i] != 'HIDDEN') $out[] = "<div class=\"Label\">". $this->f_label[ $i ] ."</div>";
			if(isset($code)) $out[] = $code;
			if($this->f_type[$i] != 'HIDDEN') $out[] = "</div>";
			
		} 
		elseif($this->DISPLAY_FORMAT == 'WML')
		 {
#			$out[] = "<p>";
			if($this->f_label[ $i ]) $out[] = "<b>". $this->f_label[ $i ] ."</b><br />";
			if(isset($code)) $out[] = $code ."<br />";
#			$out[] = "</p>";
		}	
		return implode("\n\t", $out);
	}
	

	function draw() 
	{
		echo $this->code();
	}

}
?>