<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: mobileoem.class.php 34006 2013-09-18 05:38:59Z nemohou $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

function mobileoem_discuzcode($param) {
	global $_G;

	list($message, $smileyoff, $bbcodeoff, $htmlon, $allowsmilies, $allowbbcode, $allowimgcode, $allowhtml, $jammer, $parsetype, $authorid, $allowmediacode, $pid, $lazyload, $pdateline, $first) = $param;
	static $authorreplyexist;

	if($pid && strpos($message, '[/password]') !== FALSE) {
		if($authorid != $_G['uid'] && !$_G['forum']['ismoderator']) {
			$message = preg_replace("/\s?\[password\](.+?)\[\/password\]\s?/ie", "parsepassword('\\1', \$pid)", $message);
			if($_G['forum_discuzcode']['passwordlock'][$pid]) {
				return '';
			}
		} else {
			$message = preg_replace("/\s?\[password\](.+?)\[\/password\]\s?/ie", "", $message);
			$_G['forum_discuzcode']['passwordauthor'][$pid] = 1;
		}
	}

	//note 先将 [code][/code] 标签中的代码保护起来
	if($parsetype != 1 && !$bbcodeoff && $allowbbcode && (strpos($message, '[/code]') || strpos($message, '[/CODE]')) !== FALSE) {
		$message = preg_replace("/\s?\[code\](.+?)\[\/code\]\s?/ies", "mobileoem_parsecode('\\1')", $message);
	}

	$msglower = strtolower($message);

	$htmlon = $htmlon && $allowhtml ? 1 : 0;

	if(!$htmlon) {
		$message = dhtmlspecialchars($message);
	} else {
		$message = preg_replace("/<script[^\>]*?>(.*?)<\/script>/i", '', $message);
	}

	//note 表情解析
	if(!$smileyoff && $allowsmilies) {
		$message = mobileoem_parsesmiles($message);
	}

	if($_G['setting']['allowattachurl'] && strpos($msglower, 'attach://') !== FALSE) {
		$message = preg_replace("/attach:\/\/(\d+)\.?(\w*)/ie", "parseattachurl('\\1', '\\2', 1)", $message);
	}

	if($allowbbcode) {
		if(strpos($msglower, 'ed2k://') !== FALSE) {
			$message = preg_replace("/ed2k:\/\/(.+?)\//e", "parseed2k('\\1')", $message);
		}
	}

	if(!$bbcodeoff && $allowbbcode) {
		//note URL 解析
		if(strpos($msglower, '[/url]') !== FALSE) {
			$message = preg_replace("/\[url(=((https?|ftp|gopher|news|telnet|rtsp|mms|callto|bctp|thunder|qqdl|synacast){1}:\/\/|www\.|mailto:)?([^\r\n\[\"']+?))?\](.+?)\[\/url\]/ies", "parseurl('\\1', '\\5', '\\2')", $message);
		}
		//note E-mail 解析
		if(strpos($msglower, '[/email]') !== FALSE) {
			$message = preg_replace("/\[email(=([a-z0-9\-_.+]+)@([a-z0-9\-_]+[.][a-z0-9\-_.]+))?\](.+?)\[\/email\]/ies", "strip_tags(parseemail('\\1', '\\4'))", $message);
		}

		//note 表格解析 允许嵌套 4 层
		$nest = 0;
		while(strpos($msglower, '[table') !== FALSE && strpos($msglower, '[/table]') !== FALSE){
			$message = preg_replace("/\[table(?:=(\d{1,4}%?)(?:,([\(\)%,#\w ]+))?)?\]\s*(.+?)\s*\[\/table\]/ies", "parsetable('\\1', '\\2', '\\3')", $message);
			if(++$nest > 4) break;
		}

		//note CSS 相关代码解析
		$message = str_replace(array(
			'[/color]', '[/backcolor]', '[/size]', '[/font]', '[/align]', '[b]', '[/b]', '[s]', '[/s]', '[hr]', '[/p]',
			'[i=s]', '[i]', '[/i]', '[u]', '[/u]', '[list]', '[list=1]', '[list=a]',
			'[list=A]', "\r\n[*]", '[*]', '[/list]', '[indent]', '[/indent]', '[/float]'
			), array(
			'</font>', '', '', '', '', '<strong>', '</strong>', '<strike>', '</strike>', '<hr class="l" />', '</p>', '', '',
			'', '', '', '<ul>', '<ul type="1" class="litype_1">', '<ul type="a" class="litype_2">',
			'<ul type="A" class="litype_3">', '<li>', '<li>', '</ul>', '', '', ''
			), preg_replace(array(
			"/\[color=([#\w]+?)\]/i",
			"/\[color=((rgb|rgba)\([\d\s,]+?\))\]/i",
			"/\[backcolor=([#\w]+?)\]/i",
			"/\[backcolor=((rgb|rgba)\([\d\s,]+?\))\]/i",
			"/\[size=(\d{1,2}?)\]/i",
			"/\[size=(\d{1,2}(\.\d{1,2}+)?(px|pt)+?)\]/i",
			"/\[font=([^\[\<]+?)\]/i",
			"/\[align=(left|center|right)\]/i",
			"/\[p=(\d{1,2}|null), (\d{1,2}|null), (left|center|right)\]/i",
			"/\[float=left\]/i",
			"/\[float=right\]/i"
			), array(
			"<font color=\"\\1\">",
			"<font style=\"color:\\1\">",
			"",
			"",
			"",
			"",
			"",
			"",
			"<p>",
			"",
			""
			), $message));

		//note 帖子背景图
		$message = preg_replace("/\s?\[postbg\]\s*([^\[\<\r\n;'\"\?\(\)]+?)\s*\[\/postbg\]\s?/is", "", $message);

		if($parsetype != 1) {
			if(strpos($msglower, '[/quote]') !== FALSE) {
				$message = preg_replace("/\s?\[quote\][\n\r]*(.+?)[\n\r]*\[\/quote\]\s?/is", mobileoem_quote(), $message);
			}
			if(strpos($msglower, '[/free]') !== FALSE) {
				$message = preg_replace("/\s*\[free\][\n\r]*(.+?)[\n\r]*\[\/free\]\s*/is", mobileoem_free(), $message);
			}
		}
		//note 多媒体代码解析
		if(strpos($msglower, '[/media]') !== FALSE) {
			$message = preg_replace("/\[media=([\w,]+)\]\s*([^\[\<\r\n]+?)\s*\[\/media\]/ies", "bbcodeurl('\\2', '<a href=\"{url}\" target=\"_blank\">{url}</a>')", $message);
		}
		if(strpos($msglower, '[/audio]') !== FALSE) {
			$message = preg_replace("/\[audio(=1)*\]\s*([^\[\<\r\n]+?)\s*\[\/audio\]/ies", "bbcodeurl('\\2', '<a href=\"{url}\" target=\"_blank\">{url}</a>')", $message);
		}
		if(strpos($msglower, '[/flash]') !== FALSE) {
			$message = preg_replace("/\[flash(=(\d+),(\d+))?\]\s*([^\[\<\r\n]+?)\s*\[\/flash\]/ies", "bbcodeurl('\\4', '<a href=\"{url}\" target=\"_blank\">{url}</a>')", $message);
		}

		//note 自定义 Discuz! 代码解析
		if($parsetype != 1 && $allowbbcode < 0 && isset($_G['cache']['bbcodes'][-$allowbbcode])) {
			$message = preg_replace($_G['cache']['bbcodes'][-$allowbbcode]['searcharray'], $_G['cache']['bbcodes'][-$allowbbcode]['replacearray'], $message);
		}
		//note hide 代码解析
		if($parsetype != 1 && strpos($msglower, '[/hide]') !== FALSE && $pid) {
			if($_G['setting']['hideexpiration'] && $pdateline && (TIMESTAMP - $pdateline) / 86400 > $_G['setting']['hideexpiration']) {
				$message = preg_replace("/\[hide[=]?(d\d+)?[,]?(\d+)?\]\s*(.*?)\s*\[\/hide\]/is", "\\3", $message);
				$msglower = strtolower($message);
			}
			if(strpos($msglower, '[hide=d') !== FALSE) {
				$message = preg_replace("/\[hide=(d\d+)?[,]?(\d+)?\]\s*(.*?)\s*\[\/hide\]/ies", "expirehide('\\1','\\2','\\3', $pdateline)", $message);
				$msglower = strtolower($message);
			}
			if(strpos($msglower, '[hide]') !== FALSE) {
				if($authorreplyexist === null) {						
					if($_G['forum']['ismoderator']) {
						$authorreplyexist = TRUE;
					}
				}
				if($authorreplyexist) {
					$message = preg_replace("/\[hide\]\s*(.*?)\s*\[\/hide\]/is", mobileoem_hide_reply(), $message);
				} else {
					$message = preg_replace("/\[hide\](.*?)\[\/hide\]/is", mobileoem_hide_reply_hidden(), $message);
				}
			}
			if(strpos($msglower, '[hide=') !== FALSE) {
				$message = preg_replace("/\[hide=(\d+)\]\s*(.*?)\s*\[\/hide\]/ies", "creditshide(\\1,'\\2', $pid, $authorid)", $message);
			}
		}
	}

	if(strpos($message, '[/tthread]') !== FALSE) {
		$matches = array();
		preg_match('/\[tthread=(.+?),(.+?)\](.*?)\[\/tthread\]/', $message, $matches);
		$message = preg_replace('/\[tthread=(.+?)\](.*?)\[\/tthread\]/', lang('plugin/qqconnect', 'connect_tthread_message', array('username' => $matches[1], 'nick' => $matches[2])), $message);
	}

	//note img 代码解析
	if(!$bbcodeoff) {
		if($parsetype != 1 && strpos($msglower, '[swf]') !== FALSE) {
			$message = preg_replace("/\[swf\]\s*([^\[\<\r\n]+?)\s*\[\/swf\]/ies", "bbcodeurl('\\1', ' <img src=\"'.STATICURL.'image/filetype/flash.gif\" align=\"absmiddle\" alt=\"\" /> <a href=\"{url}\" target=\"_blank\">Flash: {url}</a> ')", $message);
		}

		$attrsrc = !IS_ROBOT && $lazyload ? 'file' : 'src';
		if(strpos($msglower, '[/img]') !== FALSE) {
			$message = preg_replace(array(
				"/\[img\]\s*([^\[\<\r\n]+?)\s*\[\/img\]/ies",
				"/\[img=(\d{1,4})[x|\,](\d{1,4})\]\s*([^\[\<\r\n]+?)\s*\[\/img\]/ies"
			), $allowimgcode ? array(
				"mobileoem_parseimg(0, 0, '\\1', ".intval($lazyload).", ".intval($pid).", 'onmouseover=\"img_onmouseoverfunc(this)\" ".($lazyload ? "lazyloadthumb=\"1\"" : "onload=\"thumbImg(this)\"")."')",
				"mobileoem_parseimg('\\1', '\\2', '\\3', ".intval($lazyload).", ".intval($pid).")"
			) : ($allowbbcode ? array(
				(!defined('IN_MOBILE') ? "bbcodeurl('\\1', '<a href=\"{url}\" target=\"_blank\">{url}</a>')" : "bbcodeurl('\\1', '')"),
				(!defined('IN_MOBILE') ? "bbcodeurl('\\3', '<a href=\"{url}\" target=\"_blank\">{url}</a>')" : "bbcodeurl('\\3', '')"),
			) : array("bbcodeurl('\\1', '{url}')", "bbcodeurl('\\3', '{url}')")), $message);
		}
	}

	//note 还原 [code][/code] 标签中的代码
	for($i = 0; $i <= $_G['forum_discuzcode']['pcodecount']; $i++) {
		$message = str_replace("[\tDISCUZ_CODE_$i\t]", $_G['forum_discuzcode']['codehtml'][$i], $message);
	}

	unset($msglower);	
	$message = preg_replace("/(\[groupid=\d+\].*\[\/groupid\])/i", '', $message);
	return $message;
}
	
function mobileoem_template($file) {
	global $_G;
	$defaulttpldir = 'source/plugin/mobileoem/template';
	$mobileoemtpldir = empty($_G['setting']['mobileoemtpldir']) ? $defaulttpldir : $_G['setting']['mobileoemtpldir'];
	$tpldir = $mobileoemtpldir.'/mobileoem/';
	$tplfile = $tpldir.$file.'.htm';
	if(!file_exists($tplfile)) {
		$tpldir = $defaulttpldir.'/mobileoem/';
		$tplfile = $tpldir.$file.'.htm';
		if(!file_exists($tplfile)) {
			mobile_core::result(array('error' => 'mobileoem_template_not_exists'));
		}
	}
	$cachefile = './data/template/mobileoem_'.str_replace(array('\\', '/'), '_', $tplfile).'.tpl.php';
	checktplrefresh($tplfile, $tplfile, @filemtime(DISCUZ_ROOT.$cachefile), 0, $cachefile, $tpldir, $file);
	return DISCUZ_ROOT.$cachefile;
}

function mobileoem_parsecode($code) {
	global $_G;
	$_G['forum_discuzcode']['pcodecount']++;
	$code = dhtmlspecialchars(str_replace('\\"', '"', $code));
	$code = str_replace("\n", "<li>", $code);
	$_G['forum_discuzcode']['codehtml'][$_G['forum_discuzcode']['pcodecount']] = mobileoem_codedisp($code);
	$_G['forum_discuzcode']['codecount']++;
	return "[\tDISCUZ_CODE_".$_G['forum_discuzcode']['pcodecount']."\t]";
}

function mobileoem_parseimg($width, $height, $url) {
	global $_G;
	$url = htmlspecialchars(str_replace(array('<', '>'), '', str_replace('\\"', '\"', $url)));
	if(strtolower(substr($url, 0, 7)) == 'static/') {
		$url = $_G['siteurl'].$url;
	}
	if(!in_array(strtolower(substr($url, 0, 6)), array('http:/', 'https:', 'ftp://'))) {
		$url = 'http://'.$url;
	}
	$extra = ($width > 0 ? 'width="'.$width.'" ' : '').($height > 0 ? 'height="'.$height.'" ' : '');
	if(fileext($url) == 'gif') {
		return mobileoem_gif($url, $extra);
	} else {
		return mobileoem_image($url, $extra);
	}
}

function mobileoem_parsesmiles(&$message) {
	global $_G;
	static $enablesmiles;
	if($enablesmiles === null) {
		$enablesmiles = false;
		if(!empty($_G['cache']['smilies']) && is_array($_G['cache']['smilies'])) {
			foreach($_G['cache']['smilies']['replacearray'] AS $key => $smiley) {
				$enablesmiles[$key] = '<img src="'.$_G['siteurl'].STATICURL.'image/smiley/'.$_G['cache']['smileytypes'][$_G['cache']['smilies']['typearray'][$key]]['directory'].'/'.$smiley.'" />';
			}
		}
	}
	$enablesmiles && $message = preg_replace($_G['cache']['smilies']['searcharray'], $enablesmiles, $message, $_G['setting']['maxsmilies']);
	return $message;
}

?>