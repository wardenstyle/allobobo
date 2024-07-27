<?php 
/**
 * Cette classe a pour but de générer les éléments Html dont on a besoin (un titre, un tableau, un formulaire)
 */
class HtmlGenerator {

    public $html = '';
	// Retour chariot / return line
	private $char_rl;
	public $auto_newline;
	public $auto_div;
	private $indice_name = 0;

    function __construct() {
        $this->char_rl = chr(10);
		$this->auto_newline = false;
        $this->auto_div = true;
    }

	function generate(){
		echo $this->html;
		$this->html = '';
	}

    /**
	* créer un nom unique à partir du name d'un élément Html
	*
	* @param [text] $basename
	* @return $basename incrémenté +1
	*/
	private function get_indice_name($basename) {

		return 'ab_'.$basename."_".($this->indice_name++);

	}

	/**
	* La fonction shortcode_atts de wordpress permettant du fusionner les attributs html sera réécrite ici
	*/
	function shortcode_atts($pairs, $atts, $shortcode = '') {
		$atts = (array) $atts;
		$out = array();
	
		foreach ($pairs as $name => $default) {
			if (array_key_exists($name, $atts)) {
				$out[$name] = $atts[$name];
			} else {
				$out[$name] = $default;
			}
		}
	
		return $out;
	}

    /**
    * Génrérer un titre
    */
    function add_title($atts, $add_flush_html = true){

		$a = $this->shortcode_atts( array(
			'name' => $this->get_indice_name('title'), // création du nom unique
			'title' => 'titre',
			'level' => 2, // h2 par défaut
			'class' => 'wp-heading-inline',
			), $atts );
		 
		$r = '<h'.$a['level'].' class="'.$a['class'].'" id="add_'.$a['name'].'" >'.$a['title'].'</h'.$a['level'].''.' name="'.$a['name'].'">';

		// Retour chariot pour meilleure lecture html
		$r .= $this->char_rl;

		// on concaténe pour le flush
		if ($add_flush_html) $this->html .= $r;
		
		return $r;
	}

		/**
		* générer un tableau 
		*/
		function add_tab($atts, $add_flush_html = true){
			$a = $this->shortcode_atts( array(
				'columns' => array('titre'),
				'values' =>array(),
				), $atts );
				
			if (is_array($a['columns'])) $colonne = $a['columns']; else $colonne = explode(',', $a['columns']);
			
			// Formatage des colonnes
			foreach ($colonne as $k => $v) {
			  if (!is_array($v)) $v = array('title' => $v);
			  $v = array_merge(array(
				'title' => "",
				'checkbox' => false,
				'hidden' => false
				), $v);
			  $colonne[$k] = $v;
			}
	
			// Formatage des lignes
			$rows = array();
			foreach($a['values'] as $v){
			  array_push($rows, $v);  
			}
			// si vous avez bootstrap vous pouvez indiquer la classe souhaitée
			$r = '<table class="table table-striped"><thead><tr>'.$this->char_rl;
			// le th
			foreach($colonne as $c){
				$r.= '<th'.($c['hidden'] ? ' style="display:none"' : "").'>'.$c['title'].'</th>'.$this->char_rl;
			}
			$r.= '</tr></thead><tbody>'.$this->char_rl;
			//  tr
			foreach($rows as $v){
				$r.= '<tr>';
				$i = 0;
					//et les td
				foreach($v as $k => $value){
	//~ 				$r.= '<td class="name column-name">'.$value.'</td>'.$this->char_rl;
					$r.= '<td'.($colonne[$i]['hidden'] ? ' style="display:none"' : "").' class="name column-name">'.$this->char_rl;
	
					if ($colonne[$i]['checkbox']) {
						$r .= $this->add_checkbox(array(
							'name' => $value,
							'option' => array(""),
							), false);
					} else
					if (isset($colonne[$i]['callback'])) {
						$r .= call_user_func($colonne[$i]['callback'], $value);
					} else
					{
						$r .= $value.$this->char_rl;
					}
					$r.= '</td>'.$this->char_rl;
					$i++;
				}
				$r.= '</tr>'.$this->char_rl;
			}
			$r.= '</tbody></table>';	
	
			// Retour chariot pour meilleure lecture html
			$r .= $this->char_rl;
			
			// on concaténe pour le flush
			if ($add_flush_html) $this->html .= $r;
			
			return $r;
		}
    
    /** générer une div */
    function add_begin_div($atts, $add_flush_html = true){
		$a = $this->shortcode_atts( array(
			'class_name' => 'name',
 			'newline' =>  $this->auto_newline,
			), $atts );

        $r = "<div class='{$a['class_name']}'>";
		
 		if ($a['newline']) $r .= '<br>';
		
		// Retour chariot pour meilleure lecture html
		$r .= $this->char_rl;
	
		// on concaténe pour le flush
		if ($add_flush_html) $this->html .= $r;
		
		return $r;
	}

	function add_end_div($atts, $add_flush_html = true){
		$a = $this->shortcode_atts( array(
			"newline" => true,
			), $atts );

		 $r = '</div>' ; 
		
		if ($a['newline']) $r .= '<br>';
		
		// Retour chariot pour meilleure lecture html
		$r .= $this->char_rl;
		
		// on concaténe pour le flush
		if ($add_flush_html) $this->html .= $r;
		
		return $r;
	}

    /** générer un formulaire */
    function add_begin_form($atts, $add_flush_html = true){
		$a = $this->shortcode_atts( array(
			'name' => 'pl_post',
			'method' => 'post', 
			'action' =>  "",
			'title' => null, 
			'newline' =>  $this->auto_newline,
			), $atts );

		$r = '<form class="generate-form" id="add_'.$a["name"].'" name="'.$a["name"].'" method="' .$a["method"].'"  action="' .$a["action"]. '">';

//~ 		if ($a['newline']) $r .= '<br>';
		
		// Retour chariot pour meilleure lecture html
		$r .= $this->char_rl;

		if (isset($a["title"])) $r .= $this->add_title(array('title' => $a["title"]), false);
		
		// on concaténe pour le flush
		if ($add_flush_html) $this->html .= $r;
		
		return $r;
	}

	function add_end_form($atts, $add_flush_html = true){
		$a = $this->shortcode_atts( array(
//~ 			'newline' =>  $this->auto_newline,
			), $atts );

		 $r = '</form>' ; 
		
//~ 		if ($a['newline']) $r .= '<br>';
		
		// Retour chariot pour meilleure lecture html
		$r .= $this->char_rl;
		
		// on concaténe pour le flush
		if ($add_flush_html) $this->html .= $r;
		
		return $r;
	}

	/**générer les input des formulaires */
	function add_input($atts, $add_flush_html = true){
		$a = $this->shortcode_atts( array(
			'name' => 'ab_input',
			'label' => null,
			'type' => 'text',
			'value' => null,
			'mandatory' => false,
			'newline' =>  $this->auto_newline,
			'div' => $this->auto_div,
			'placeholder' => null,
			'label-align' => 'left',
			), $atts );

		$r = "";
		$r_label= "";
		
		if ($a['div']) $r .= $this->add_begin_div(array(), false);

		$r_label .= '<label for="'.$a["name"].'">'.$a["label"];
		if ($a['mandatory'])
		{
			$r_label .= '<span style="color:orange;"> *</span>';
			$r2 = " required";
		}
		$r_label .=  '</label>'.$this->char_rl;
		 
		if ($a['label-align'] == 'left')
		{
			$r .= $r_label;
		}

		$r .= '<input class="form-control" id="add_'.$a["name"].'" type="'.$a["type"].'" name="'.$a["name"].'" value="'.$a["value"].'"';

		if (isset($a['placeholder']))
		{
			$r .= ' placeholder ="'.$a['placeholder'].'"';
		}

		if ($a['mandatory'])
		{
			$r .= " required";
		}

		$r .= '>';

		if ($a['label-align'] == 'right')
		{
			$r .= $r_label;
		}

		if ($a['newline']) $r .= '<br>';
		
		// Retour chariot pour meilleure lecture html
		$r .= $this->char_rl;

		if ($a['div']) $r .= $this->add_end_div(array(), false);

		// on concaténe pour le flush
		if ($add_flush_html) $this->html .= $r;
		
		return $r;
	}

	/** générer un bouton
	 */
	function add_button($atts, $add_flush_html = true){
		$a= $this->shortcode_atts (array( 
			'name' => 'ab_button' ,
			'value'=> null , 
			'type' => 'button',
			'class'=> 'generate-button',
			'style'=>null,
			'disabled' => false,
			'autofocus' => false,
			'newline' =>  $this->auto_newline,
			), $atts ) ; 

		$r = '<button id="add_'.$a["name"].'" type="'.$a["type"].'" name="'.$a["name"].'" value="'.$a["value"].'" class="'.$a["class"].'" style="'.$a["style"].'"';

		if ($a['disabled']) $r .= ' disabled';
		if ($a['autofocus']) $r .= ' autofocus';
		$r .= '>'.$a["value"].'</button>' ;
	
		if ($a['newline']) $r .= '<br>';

		// Retour chariot pour meilleure lecture html
		$r .= $this->char_rl;

		// on concaténe pour le flush
		if ($add_flush_html) $this->html .= $r;
		
		return $r;
	}
}
?>