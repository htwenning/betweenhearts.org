<?php

class lj{
function mynotification_add($touid, $type, $note, $notevars = array(), $system = 0,$uid,$username) {
		$_G['uid']=$uid;
		$_G['member']['username']=$username;
		$_G['username']=$username;
		if(!($tospace = getuserbyuid($touid))) {
			return false;
		}
		space_merge($tospace, 'field_home');
		$filter = empty($tospace['privacy']['filter_note'])?array():array_keys($tospace['privacy']['filter_note']);

		if($filter && (in_array($type.'|0', $filter) || in_array($type.'|'.$_G['uid'], $filter))) {
			return false;
		}
		
		$notevars['actor'] = "<a href=\"home.php?mod=space&uid=$_G[uid]\">".$_G['member']['username']."</a>";
		if(!is_numeric($type)) {
			$vars = explode(':', $note);
			
			if(count($vars) == 2) {
				$notestring = lang('plugin/'.$vars[0], $vars[1], $notevars);
			} else {
				//debug($notevars);
				$notestring = lang('notification', $note, $notevars);
				
			}
			$frommyapp = false;
		} else {
			$frommyapp = true;
			$notestring = $note;
		}

		$oldnote = array();
		if($notevars['from_id'] && $notevars['from_idtype']) {
			$oldnote = DB::fetch_first("SELECT * FROM ".DB::table('home_notification')."
			WHERE from_id='$notevars[from_id]' AND from_idtype='$notevars[from_idtype]' AND uid='$touid'");
		}
		if(empty($oldnote['from_num'])) $oldnote['from_num'] = 0;
		$notevars['from_num'] = $notevars['from_num'] ? $notevars['from_num'] : 1;
		$setarr = array(
			'uid' => $touid,
			'type' => $type,
			'new' => 1,
			'authorid' => $_G['uid'],
			'author' => $_G['username'],
			'note' => $notestring,
			'dateline' => time(),
			'from_id' => $notevars['from_id'],
			'from_idtype' => $notevars['from_idtype'],
			'from_num' => ($oldnote['from_num']+$notevars['from_num'])
		);

		if($system) {
			$setarr['authorid'] = 0;
			$setarr['author'] = '';
		}
		$pkId = 0;
		if($oldnote['id']) {
			DB::update('home_notification', $setarr, array('id'=>$oldnote['id']));
			$pkId = $oldnote['id'];
		} else {
			$oldnote['new'] = 0;
			$pkId = DB::insert('home_notification', $setarr);
		}
		$banType = array('task');
		if($_G['setting']['cloud_status'] && !in_array($type, $banType)) {
			$noticeService = Cloud::loadClass('Service_Client_Notification');
			if($oldnote['id']) {
				$noticeService->update($touid, $pkId, $setarr['from_num'], $setarr['dateline']);
			} else {
				$extra = $type == 'post' ? array('pId' => $notevars['pid']) : array();
				$noticeService->add($touid, $pkId, $type, $setarr['authorid'], $setarr['author'], $setarr['from_id'], $setarr['from_idtype'], $setarr['note'], $setarr['from_num'], $setarr['dateline'], $extra);
			}
		}

		if(empty($oldnote['new'])) {
			DB::query("UPDATE ".DB::table('common_member')." SET newprompt=newprompt+1 WHERE uid='$touid'");

			require_once libfile('function/mail');
			$mail_subject = lang('notification', 'mail_to_user');
			sendmail_touser($touid, $mail_subject, $notestring, $frommyapp ? 'myapp' : $type);
		}

		if(!$system && $_G['uid'] && $touid != $_G['uid']) {
			DB::query("UPDATE ".DB::table('home_friend')." SET num=num+1 WHERE uid='$_G[uid]' AND fuid='$touid'");
		}
	}
	function g2u($a) {
	return is_array($a) ? array_map('g2u', $a) : iconv('GBK', 'UTF-8', $a);
} 
function u2g($a) {
	return is_array($a) ? array_map('u2g', $a) : iconv('UTF-8', 'GBK', $a);
} 
function is_utf8($word) {
	if (preg_match("/^([" . chr(228) . "-" . chr(233) . "]{1}[" . chr(128) . "-" . chr(191) . "]{1}[" . chr(128) . "-" . chr(191) . "]{1}){1}/", $word) == true || preg_match("/([" . chr(228) . "-" . chr(233) . "]{1}[" . chr(128) . "-" . chr(191) . "]{1}[" . chr(128) . "-" . chr(191) . "]{1}){1}$/", $word) == true || preg_match("/([" . chr(228) . "-" . chr(233) . "]{1}[" . chr(128) . "-" . chr(191) . "]{1}[" . chr(128) . "-" . chr(191) . "]{1}){2,}/", $word) == true) {
		return true;
	} else {
		return false;
	} 
} 
function downremoteimg($message, $uid)
{
	global $_G;
    //$message = str_replace(array("\r", "\n"),  "\\n", $message);
    preg_match_all("/\[img\]\s*([^\[\<\r\n]+?)\s*\[\/img\]|\[img=\d{1,4}[x|\,]\d{1,4}\]\s*([^\[\<\r\n]+?)\s*\[\/img\]/is",
        $message, $image1, PREG_SET_ORDER);
    preg_match_all("/\<img.+src=('|\"|)?(.*)(\\1)([\s].*)?\>/ismUe", $message, $image2,
        PREG_SET_ORDER);
    $temp = $aids = $existentimg = array();
    $rem = array();
    if (is_array($image1) && !empty($image1))
    {
        foreach ($image1 as $value)
        {
            $temp[] = array('0' => $value[0], '1' => trim(!empty($value[1]) ? $value[1] : $value[2]));
            $suf = explode(".", substr(strrev($temp['0']['1']), 0, 7));
            if (!isset($suf[1]))
            {
                $temp['0']['1'] .= ".gif";
            }
        }
    }
    if (is_array($image2) && !empty($image2))
    {
        foreach ($image2 as $value)
        {
            $temp[] = array('0' => $value[0], '1' => trim($value[2]));
        }
    }
    //if (empty($temp)) { $rem['err']=1;}

    require_once libfile('class/image');
    if (is_array($temp) && !empty($temp))
    {
        $upload = new discuz_upload();
        $attachaids = array();

        foreach ($temp as $value)
        {
            $imageurl = $value[1];
            $hash = md5($imageurl);
            if (strlen($imageurl))
            {
                $imagereplace['oldimageurl'][] = $value[0];
                if (!isset($existentimg[$hash]))
                {
                    $existentimg[$hash] = $imageurl;
                    $attach['ext'] = $upload->fileext($imageurl);
                    if (!$upload->is_image_ext($attach['ext']))
                    {
                        continue;
                    }
                    $content = '';
                    if (preg_match('/^(http:\/\/|\.)/i', $imageurl))
                    {
                        $content = dfsockopen($imageurl);
                    } elseif (preg_match('/^(' . preg_quote(getglobal('setting/attachurl'), '/') .
                    ')/i', $imageurl))
                    {
                        $imagereplace['newimageurl'][] = $value[0];
                    }
                    if (empty($content))
                        continue;
                    $patharr = explode('/', $imageurl);
                    $attach['name'] = trim($patharr[count($patharr) - 1]);
                    $attach['thumb'] = '';

                    $attach['isimage'] = $upload->is_image_ext($attach['ext']);
                    $attach['extension'] = $upload->get_target_extension($attach['ext']);
                    $attach['attachdir'] = $upload->get_target_dir('forum');
                    $attach['attachment'] = $attach['attachdir'] . $upload->get_target_filename('forum') .
                        '.' . $attach['extension'];
                    $attach['target'] = getglobal('setting/attachdir') . './forum/' . $attach['attachment'];

                    if (!@$fp = fopen($attach['target'], 'wb'))
                    {
                        continue;
                    } else
                    {
                        flock($fp, 2);
                        fwrite($fp, $content);
                        fclose($fp);
                    }
                    if (!$upload->get_image_info($attach['target']))
                    {
                        @unlink($attach['target']);
                        continue;
                    }
                    $attach['size'] = filesize($attach['target']);
                    $upload->attach = $attach;
                    $thumb = $width = 0;
                    if ($upload->attach['isimage'])
                    {
                        if ($_G['setting']['thumbsource'] && $_G['setting']['sourcewidth'] && $_G['setting']['sourceheight'])
                        {
                            $image = new image();
                            $thumb = $image->Thumb($upload->attach['target'], '', $_G['setting']['sourcewidth'],
                                $_G['setting']['sourceheight'], 1, 1) ? 1 : 0;
                            $width = $image->imginfo['width'];
                            $upload->attach['size'] = $image->imginfo['size'];
                        }
                        if ($_G['setting']['thumbstatus'])
                        {
                            $image = new image();
                            $thumb = $image->Thumb($upload->attach['target'], '', $_G['setting']['thumbwidth'],
                                $_G['setting']['thumbheight'], $_G['setting']['thumbstatus'], 0) ? 1 : 0;
                            $width = $image->imginfo['width'];
                        }
                        if ($_G['setting']['thumbsource'] || !$_G['setting']['thumbstatus'])
                        {
                            list($width) = @getimagesize($upload->attach['target']);
                        }
                        if ($_G['setting']['watermarkstatus'] && empty($_G['forum']['disablewatermark']))
                        {
                            $image = new image();
                            $image->Watermark($attach['target'], '', 'forum');
                            $upload->attach['size'] = $image->imginfo['size'];
                        }
                    }

                    $aids[] = $aid = getattachnewaid($uid);
                    $setarr = array(
                        'aid' => $aid,
                        'dateline' => $_G['timestamp'],
                        'filename' => $upload->attach['name'],
                        'filesize' => $upload->attach['size'],
                        'attachment' => $upload->attach['attachment'],
                        'isimage' => $upload->attach['isimage'],
                        'uid' => $uid,
                        'thumb' => $thumb,
                        'remote' => '0',
                        'width' => $width);
                    //C::t("forum_attachment_unused")->insert($setarr);
                    $attachaids[$hash] = $imagereplace['newimageurl'][] = '[attach]' . $aid .
                        '[/attach]';

                } else
                {
                    $imagereplace['newimageurl'][] = $attachaids[$hash];
                }
            }
        }
        if (!empty($aids))
        {
            require_once libfile('function/post');
        }
        $message = str_replace($imagereplace['oldimageurl'], $imagereplace['newimageurl'],
            $message);
        //$message = addcslashes($message, '/"');

    }
    $mess['aid'] = $aid;
    $mess['message'] = $message;
    $mess['setarr'] = $setarr;
    return $mess;
}
	
function updatemessage($pid)
{
    
    $arr_mes = DB::fetch_first("SELECT tid,first,authorid,message FROM " . DB::
        table("forum_post") . " WHERE pid=$pid");
    $atableid = $arr_mes['tid'] % 10;
    $uid = $arr_mes['authorid'];
    $re_mes = $this->downremoteimg($arr_mes['message'], $uid);
    if (empty($re_mes['aid']))
    {
        return 0;
    } else
    {
        
        DB::update('forum_attachment', array(
            'pid' => $pid,
            'tid' => $arr_mes['tid'],
            'tableid' => $atableid,
            'uid' => $uid), "aid = " . $re_mes['aid']);
        DB::insert("forum_attachment_" . $atableid, array(
            'aid' => $re_mes['aid'],
            'pid' => $pid,
            'tid' => $arr_mes['tid'],
            'dateline' => time(),
            'uid' => $uid,
            'filename' => $re_mes['setarr']['filename'],
            'filesize' => $re_mes['setarr']['filesize'],
            'attachment' => $re_mes['setarr']['attachment'],
            'isimage' => 1,
            'width' => $re_mes['setarr']['width']));
        DB::insert("forum_threadimage", array('tid' => $arr_mes['tid'], 'attachment' =>
                $re_mes['setarr']['attachment']));

        if (1 == $arr_mes['first'])
        {
            global $_G;
            loadcache('plugin');
            $iscover = $_G['cache']['plugin']['localization_picture'];
            if (1 == $iscover['iscover'])
            {
                $g = setcover($pid, $arr_mes['tid'], $re_mes['aid']);
                if($g) echo 'ghj';

            }
            DB::update("forum_thread", array('attachment' => '2'), "tid = " . $arr_mes['tid']);
        } else
        {
            DB::update("forum_thread", array('attachment' => '2'), "tid = " . $arr_mes['tid']);
        }

        DB::update("forum_post", array('attachment' => '2', 'message' => $re_mes['message']),
            "pid=$pid");
    }
    return 1;
}
function midToStr($mid) {
	settype($mid, 'string');
	$mid_length = strlen($mid);
	$url = '';
	$str = strrev($mid);
	$str = str_split($str, 7);

	foreach ($str as $v) {
		$char = $this->intTo62(strrev($v));
		$char = str_pad($char, 4, "0");
		$url .= $char;
	} 

	$url_str = strrev($url);

	return ltrim($url_str, '0');
} 

function str62keys_int_62($key) { // 62进制字典
	$str62keys = array ("0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q",
		"r", "s", "t", "u", "v", "w", "x", "y", "z", "A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q",
		"R", "S", "T", "U", "V", "W", "X", "Y", "Z"
		);
	return $str62keys[$key];
} 

/**
 * url 10 进制 转62进制
 */

function intTo62($int10) {
	$s62 = '';
	$r = 0;
	while ($int10 != 0) {
		$r = $int10 % 62;
		$s62 .= $this->str62keys_int_62($r);
		$int10 = floor($int10 / 62);
	} 

	return $s62;
} 
function _soso_smiles($smilieid = '', $maxsmilies = -1, $pid = 0, $imgcode = 0) {
		static $smiliecount;
		$imgsrc = '';
		$pid = intval($pid);
		$maxsmilies = intval($maxsmilies);
		$smilieid = $smiliekey = (string) $smilieid;
		$imgid = "soso_{$smilieid}";
		if($maxsmilies == 0) {
			return "{:soso_$smilieid:}";
		}
		if(strpos($smilieid, '_') === 0) {
			$realsmilieid = $smiliekey = substr($smilieid, 0, -2);
			$serverid = intval(substr($smilieid, -1));
			$imgsrc = "http://piccache{$serverid}.soso.com/face/{$realsmilieid}";
		} elseif(strpos($smilieid, 'e') === 0) {
			$imgsrc = "http://cache.soso.com/img/img/{$smilieid}.gif";
		} else {
			return "{:soso_$smilieid:}";
		}
		if($maxsmilies > 0) {
			if(!isset($smiliecount)) {
				$smiliecount = array();
			}
			$smiliekey = addslashes("{$pid}_{$smiliekey}");
			if(empty($smiliecount[$smiliekey])) {
				$smiliecount[$smiliekey] = 1;
			} else {
				$smiliecount[$smiliekey]++;
			}
			if($smiliecount[$smiliekey] > $maxsmilies) {
				return "{:soso_$smilieid:}";
			}
		}
		if($imgcode) {
			return "{$imgsrc}";
		} else {
			return "{$imgsrc}";
		}
	}

	function _soso_bbcode2html(&$message, $strpos = false, $smileyoff = 1, $maxsmilies = -1, $pid = 0) {
		if(!empty($message)) {
			if(!$smileyoff || ($strpos && strpos($message, '{:soso_') !== false)) {
				$message = preg_replace("/\{\:soso_((e\d+)|(_\d+_\d))\:\}/e", '$this->_soso_smiles("\\1", "'.$maxsmilies.'", "'.$pid.'")', $message);
			}
		}
		return $message;
	}
}
?>