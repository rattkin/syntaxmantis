<?php
/**
 * Plugin syntaxmantis: Displays link to Mantis-BT
 *
 * Syntax: ~~Mantis:123~~ - will be replaced with link to Mantis issue 123 with icon next to it
 * 
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * based on: https://www.mantisbt.org/wiki/doku.php/mantisbt:issue:8253?rev=1194413581
 * and https://www.mantisbt.org/wiki/doku.php/mantisbt:issue:7075:integration_with_dokuwiki#mantis_syntax_plug-in
 */
 
if(!defined('DOKU_INC')) define('DOKU_INC',realpath(dirname(__FILE__).'/../../').'/');
if(!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(DOKU_PLUGIN.'syntax.php');
 
class syntax_plugin_syntaxmantis extends DokuWiki_Syntax_Plugin {

    function getInfo(){
        return array(
            'author' => 'Jan Müller',
            'email'  => 'muller.jan@gmail.com',
            'date'   => '2015-03-23',
            'name'   => 'syntax mantis',
            'desc'   => 'Creates links into Mantis BT from ~~Mantis:123~~ ',
            'url'    => 'http://www.dokuwiki.org/plugin:syntaxmantis',
        );
    } 
 
    function getType(){
        return 'substition';
    }
 
    function getPType(){
        return 'normal';
    }
 
    function getSort(){
        return 998;
    }
 
    function connectTo($mode) {
    	$this->Lexer->addSpecialPattern('~~Mantis:[0-9]+~~',$mode,'plugin_syntaxmantis');
    }
 
    function handle($match, $state, $pos, &$handler){
	$match = substr( $match, 9, -2 ); // strip "~~Mantis:" from start and "~~" from end
        return array(strtolower( $match ));
    }

    function render($mode, &$renderer, $data) {
        if($mode == 'xhtml'){
		$link['target'] = $conf['target']['wiki'];
		$link['style']  = '';
		$link['pre']    = '';
		$link['suf']    = '';
		$link['more']   = '';
		$link['class']  = 'mantislink';
		$link['url']    = MANTIS_URL . 'view.php?id=' . $data[0];
		$link['name']   = $this->getConf('LinkPrefix') . $data[0];
		$link['title']  = $renderer->_xmlEntities($url);
	 
		//output formatted
		$renderer->doc .= $renderer->_formatLink($link);
	}
        return true;
    }
}
?>
