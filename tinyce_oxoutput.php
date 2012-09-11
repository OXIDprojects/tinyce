<?php
/*
 * TinyCE
 * @copyright GN2 netwerk
 * @link http://www.gn2-netwerk.de/
 * @author Dave Holloway
 * @version   SVN: $Id: tinyce_oxoutput.php 64 2011-08-04 13:29:30Z cs $
 */

class tinyce_oxoutput extends tinyce_oxoutput_parent {
	
	public function __construct() {
		ob_start(array($this,'tiny_outputFilter'));
		register_shutdown_function('ob_end_flush');
		parent::__construct();
	}
	
	public function tiny_outputFilter($output) {
		$class = oxConfig::getParameter('cl');
		
		$allowed = array(
			'article_main',
			'category_text',
			'content_main',
			'newsletter_main',
			'payment_main',
			'news_text',
			'adminlinks_main',
			'adminguestbook_main',
			'gn2_art_extrainfo'
		);
		
		if (in_array($class,$allowed)) {
		
			
			$code = '';

// Theme options - original
		// theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,formatselect,fontselect,fontsizeselect",
		// theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
		// theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|fullscreen",
		
$code = <<<EOT
<script type="text/javascript" src="../modules/tinyce/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
	function tinyce_copyLongDesc(ident) {
		var tiny = tinyMCE.get('editor_'+ident);
		var content = tiny.getContent();
		var destination = document.getElementsByName('editval['+ident+']');
		destination[0].value = content;
		return true;
	}
	tinyMCE.init({
		mode : "textareas",
		theme : "advanced",
		plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,iespell,insertdatetime,media,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave",

		// Theme options
		theme_advanced_buttons1 : "formatselect,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,bullist,numlist,|,outdent,indent,|,hr,removeformat,|,sub,sup,|,charmap",
		theme_advanced_buttons2 : "link,unlink,anchor,image,|,cleanup,code,|,cut,copy,paste,pastetext,pasteword,|,undo,redo,|,tablecontrols",
		theme_advanced_buttons3 : "",

		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_resizing : true

	});
</script>
EOT;
			$output = str_replace('return copyLongDesc(','return tinyce_copyLongDesc(',$output);
			$output = str_replace('onSubmit="copyLongDesc','onSubmit="tinyce_copyLongDesc',$output);
			
			$output = str_replace('</head>',$code.'</head>',$output);
		}
		
		return $output;
	}

}
?>