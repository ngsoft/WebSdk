<?php
/** Adminer Editor - Compact database editor
* @link https://www.adminer.org/
* @author Jakub Vrana, https://www.vrana.cz/
* @copyright 2009 Jakub Vrana
* @license https://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
* @license https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2 (one or other)
* @version 5.3.0
*/namespace
Adminer;const
VERSION="5.3.0";error_reporting(24575);set_error_handler(function($Xb,$Yb){return!!preg_match('~^Undefined (array key|offset|index)~',$Yb);},E_WARNING|E_NOTICE);$oc=!preg_match('~^(unsafe_raw)?$~',ini_get("filter.default"));if($oc||ini_get("filter.default_flags")){foreach(array('_GET','_POST','_COOKIE','_SERVER')as$X){$Rg=filter_input_array(constant("INPUT$X"),FILTER_UNSAFE_RAW);if($Rg)$$X=$Rg;}}if(function_exists("mb_internal_encoding"))mb_internal_encoding("8bit");function
connection($h=null){return($h?:Db::$instance);}function
adminer(){return
Adminer::$instance;}function
driver(){return
Driver::$instance;}function
connect(){$nb=adminer()->credentials();$H=Driver::connect($nb[0],$nb[1],$nb[2]);return(is_object($H)?$H:null);}function
idf_unescape($t){if(!preg_match('~^[`\'"[]~',$t))return$t;$Fd=substr($t,-1);return
str_replace($Fd.$Fd,$Fd,substr($t,1,-1));}function
q($Q){return
connection()->quote($Q);}function
escape_string($X){return
substr(q($X),1,-1);}function
idx($na,$w,$j=null){return($na&&array_key_exists($w,$na)?$na[$w]:$j);}function
number($X){return
preg_replace('~[^0-9]+~','',$X);}function
number_type(){return'((?<!o)int(?!er)|numeric|real|float|double|decimal|money)';}function
remove_slashes(array$jf,$oc=false){if(function_exists("get_magic_quotes_gpc")&&get_magic_quotes_gpc()){while(list($w,$X)=each($jf)){foreach($X
as$yd=>$W){unset($jf[$w][$yd]);if(is_array($W)){$jf[$w][stripslashes($yd)]=$W;$jf[]=&$jf[$w][stripslashes($yd)];}else$jf[$w][stripslashes($yd)]=($oc?$W:stripslashes($W));}}}}function
bracket_escape($t,$wa=false){static$Bg=array(':'=>':1',']'=>':2','['=>':3','"'=>':4');return
strtr($t,($wa?array_flip($Bg):$Bg));}function
min_version($dh,$Qd="",$h=null){$h=connection($h);$Nf=$h->server_info;if($Qd&&preg_match('~([\d.]+)-MariaDB~',$Nf,$z)){$Nf=$z[1];$dh=$Qd;}return$dh&&version_compare($Nf,$dh)>=0;}function
charset(Db$g){return(min_version("5.5.3",0,$g)?"utf8mb4":"utf8");}function
ini_bool($kd){$X=ini_get($kd);return(preg_match('~^(on|true|yes)$~i',$X)||(int)$X);}function
sid(){static$H;if($H===null)$H=(SID&&!($_COOKIE&&ini_bool("session.use_cookies")));return$H;}function
set_password($ch,$M,$V,$D){$_SESSION["pwds"][$ch][$M][$V]=($_COOKIE["adminer_key"]&&is_string($D)?array(encrypt_string($D,$_COOKIE["adminer_key"])):$D);}function
get_password(){$H=get_session("pwds");if(is_array($H))$H=($_COOKIE["adminer_key"]?decrypt_string($H[0],$_COOKIE["adminer_key"]):false);return$H;}function
get_val($F,$l=0,$db=null){$db=connection($db);$G=$db->query($F);if(!is_object($G))return
false;$I=$G->fetch_row();return($I?$I[$l]:false);}function
get_vals($F,$d=0){$H=array();$G=connection()->query($F);if(is_object($G)){while($I=$G->fetch_row())$H[]=$I[$d];}return$H;}function
get_key_vals($F,$h=null,$Qf=true){$h=connection($h);$H=array();$G=$h->query($F);if(is_object($G)){while($I=$G->fetch_row()){if($Qf)$H[$I[0]]=$I[1];else$H[]=$I[0];}}return$H;}function
get_rows($F,$h=null,$k="<p class='error'>"){$db=connection($h);$H=array();$G=$db->query($F);if(is_object($G)){while($I=$G->fetch_assoc())$H[]=$I;}elseif(!$G&&!$h&&$k&&(defined('Adminer\PAGE_HEADER')||$k=="-- "))echo$k.error()."\n";return$H;}function
unique_array($I,array$v){foreach($v
as$u){if(preg_match("~PRIMARY|UNIQUE~",$u["type"])){$H=array();foreach($u["columns"]as$w){if(!isset($I[$w]))continue
2;$H[$w]=$I[$w];}return$H;}}}function
escape_key($w){if(preg_match('(^([\w(]+)('.str_replace("_",".*",preg_quote(idf_escape("_"))).')([ \w)]+)$)',$w,$z))return$z[1].idf_escape(idf_unescape($z[2])).$z[3];return
idf_escape($w);}function
where(array$Z,array$m=array()){$H=array();foreach((array)$Z["where"]as$w=>$X){$w=bracket_escape($w,true);$d=escape_key($w);$l=idx($m,$w,array());$lc=$l["type"];$H[]=$d.(JUSH=="sql"&&$lc=="json"?" = CAST(".q($X)." AS JSON)":(JUSH=="sql"&&is_numeric($X)&&preg_match('~\.~',$X)?" LIKE ".q($X):(JUSH=="mssql"&&strpos($lc,"datetime")===false?" LIKE ".q(preg_replace('~[_%[]~','[\0]',$X)):" = ".unconvert_field($l,q($X)))));if(JUSH=="sql"&&preg_match('~char|text~',$lc)&&preg_match("~[^ -@]~",$X))$H[]="$d = ".q($X)." COLLATE ".charset(connection())."_bin";}foreach((array)$Z["null"]as$w)$H[]=escape_key($w)." IS NULL";return
implode(" AND ",$H);}function
where_check($X,array$m=array()){parse_str($X,$Ma);remove_slashes(array(&$Ma));return
where($Ma,$m);}function
where_link($r,$d,$Y,$ze="="){return"&where%5B$r%5D%5Bcol%5D=".urlencode($d)."&where%5B$r%5D%5Bop%5D=".urlencode(($Y!==null?$ze:"IS NULL"))."&where%5B$r%5D%5Bval%5D=".urlencode($Y);}function
convert_fields(array$e,array$m,array$K=array()){$H="";foreach($e
as$w=>$X){if($K&&!in_array(idf_escape($w),$K))continue;$oa=convert_field($m[$w]);if($oa)$H
.=", $oa AS ".idf_escape($w);}return$H;}function
cookie($_,$Y,$Kd=2592000){header("Set-Cookie: $_=".urlencode($Y).($Kd?"; expires=".gmdate("D, d M Y H:i:s",time()+$Kd)." GMT":"")."; path=".preg_replace('~\?.*~','',$_SERVER["REQUEST_URI"]).(HTTPS?"; secure":"")."; HttpOnly; SameSite=lax",false);}function
get_settings($kb){parse_str($_COOKIE[$kb],$Rf);return$Rf;}function
get_setting($w,$kb="adminer_settings"){$Rf=get_settings($kb);return$Rf[$w];}function
save_settings(array$Rf,$kb="adminer_settings"){$Y=http_build_query($Rf+get_settings($kb));cookie($kb,$Y);$_COOKIE[$kb]=$Y;}function
restart_session(){if(!ini_bool("session.use_cookies")&&(!function_exists('session_status')||session_status()==1))session_start();}function
stop_session($vc=false){$Yg=ini_bool("session.use_cookies");if(!$Yg||$vc){session_write_close();if($Yg&&@ini_set("session.use_cookies",'0')===false)session_start();}}function&get_session($w){return$_SESSION[$w][DRIVER][SERVER][$_GET["username"]];}function
set_session($w,$X){$_SESSION[$w][DRIVER][SERVER][$_GET["username"]]=$X;}function
auth_url($ch,$M,$V,$i=null){$Vg=remove_from_uri(implode("|",array_keys(SqlDriver::$drivers))."|username|ext|".($i!==null?"db|":"").($ch=='mssql'||$ch=='pgsql'?"":"ns|").session_name());preg_match('~([^?]*)\??(.*)~',$Vg,$z);return"$z[1]?".(sid()?SID."&":"").($ch!="server"||$M!=""?urlencode($ch)."=".urlencode($M)."&":"").($_GET["ext"]?"ext=".urlencode($_GET["ext"])."&":"")."username=".urlencode($V).($i!=""?"&db=".urlencode($i):"").($z[2]?"&$z[2]":"");}function
is_ajax(){return($_SERVER["HTTP_X_REQUESTED_WITH"]=="XMLHttpRequest");}function
redirect($Md,$ae=null){if($ae!==null){restart_session();$_SESSION["messages"][preg_replace('~^[^?]*~','',($Md!==null?$Md:$_SERVER["REQUEST_URI"]))][]=$ae;}if($Md!==null){if($Md=="")$Md=".";header("Location: $Md");exit;}}function
query_redirect($F,$Md,$ae,$rf=true,$cc=true,$hc=false,$sg=""){if($cc){$bg=microtime(true);$hc=!connection()->query($F);$sg=format_time($bg);}$Yf=($F?adminer()->messageQuery($F,$sg,$hc):"");if($hc){adminer()->error
.=error().$Yf.script("messagesPrint();")."<br>";return
false;}if($rf)redirect($Md,$ae.$Yf);return
true;}class
Queries{static$queries=array();static$start=0;}function
queries($F){if(!Queries::$start)Queries::$start=microtime(true);Queries::$queries[]=(preg_match('~;$~',$F)?"DELIMITER ;;\n$F;\nDELIMITER ":$F).";";return
connection()->query($F);}function
apply_queries($F,array$T,$Zb='Adminer\table'){foreach($T
as$R){if(!queries("$F ".$Zb($R)))return
false;}return
true;}function
queries_redirect($Md,$ae,$rf){$mf=implode("\n",Queries::$queries);$sg=format_time(Queries::$start);return
query_redirect($mf,$Md,$ae,$rf,false,!$rf,$sg);}function
format_time($bg){return
lang(0,max(0,microtime(true)-$bg));}function
relative_uri(){return
str_replace(":","%3a",preg_replace('~^[^?]*/([^?]*)~','\1',$_SERVER["REQUEST_URI"]));}function
remove_from_uri($Ne=""){return
substr(preg_replace("~(?<=[?&])($Ne".(SID?"":"|".session_name()).")=[^&]*&~",'',relative_uri()."&"),0,-1);}function
get_file($w,$vb=false,$yb=""){$mc=$_FILES[$w];if(!$mc)return
null;foreach($mc
as$w=>$X)$mc[$w]=(array)$X;$H='';foreach($mc["error"]as$w=>$k){if($k)return$k;$_=$mc["name"][$w];$zg=$mc["tmp_name"][$w];$ib=file_get_contents($vb&&preg_match('~\.gz$~',$_)?"compress.zlib://$zg":$zg);if($vb){$bg=substr($ib,0,3);if(function_exists("iconv")&&preg_match("~^\xFE\xFF|^\xFF\xFE~",$bg))$ib=iconv("utf-16","utf-8",$ib);elseif($bg=="\xEF\xBB\xBF")$ib=substr($ib,3);}$H
.=$ib;if($yb)$H
.=(preg_match("($yb\\s*\$)",$ib)?"":$yb)."\n\n";}return$H;}function
upload_error($k){$Wd=($k==UPLOAD_ERR_INI_SIZE?ini_get("upload_max_filesize"):0);return($k?lang(1).($Wd?" ".lang(2,$Wd):""):lang(3));}function
repeat_pattern($Ve,$Id){return
str_repeat("$Ve{0,65535}",$Id/65535)."$Ve{0,".($Id%65535)."}";}function
is_utf8($X){return(preg_match('~~u',$X)&&!preg_match('~[\0-\x8\xB\xC\xE-\x1F]~',$X));}function
format_number($X){return
strtr(number_format($X,0,".",lang(4)),preg_split('~~u',lang(5),-1,PREG_SPLIT_NO_EMPTY));}function
friendly_url($X){return
preg_replace('~\W~i','-',$X);}function
table_status1($R,$ic=false){$H=table_status($R,$ic);return($H?reset($H):array("Name"=>$R));}function
column_foreign_keys($R){$H=array();foreach(adminer()->foreignKeys($R)as$o){foreach($o["source"]as$X)$H[$X][]=$o;}return$H;}function
fields_from_edit(){$H=array();foreach((array)$_POST["field_keys"]as$w=>$X){if($X!=""){$X=bracket_escape($X);$_POST["function"][$X]=$_POST["field_funs"][$w];$_POST["fields"][$X]=$_POST["field_vals"][$w];}}foreach((array)$_POST["fields"]as$w=>$X){$_=bracket_escape($w,true);$H[$_]=array("field"=>$_,"privileges"=>array("insert"=>1,"update"=>1,"where"=>1,"order"=>1),"null"=>1,"auto_increment"=>($w==driver()->primary),);}return$H;}function
dump_headers($ad,$ge=false){$H=adminer()->dumpHeaders($ad,$ge);$Je=$_POST["output"];if($Je!="text")header("Content-Disposition: attachment; filename=".adminer()->dumpFilename($ad).".$H".($Je!="file"&&preg_match('~^[0-9a-z]+$~',$Je)?".$Je":""));session_write_close();if(!ob_get_level())ob_start(null,4096);ob_flush();flush();return$H;}function
dump_csv(array$I){foreach($I
as$w=>$X){if(preg_match('~["\n,;\t]|^0|\.\d*0$~',$X)||$X==="")$I[$w]='"'.str_replace('"','""',$X).'"';}echo
implode(($_POST["format"]=="csv"?",":($_POST["format"]=="tsv"?"\t":";")),$I)."\r\n";}function
apply_sql_function($q,$d){return($q?($q=="unixepoch"?"DATETIME($d, '$q')":($q=="count distinct"?"COUNT(DISTINCT ":strtoupper("$q("))."$d)"):$d);}function
get_temp_dir(){$H=ini_get("upload_tmp_dir");if(!$H){if(function_exists('sys_get_temp_dir'))$H=sys_get_temp_dir();else{$n=@tempnam("","");if(!$n)return'';$H=dirname($n);unlink($n);}}return$H;}function
file_open_lock($n){if(is_link($n))return;$p=@fopen($n,"c+");if(!$p)return;chmod($n,0660);if(!flock($p,LOCK_EX)){fclose($p);return;}return$p;}function
file_write_unlock($p,$sb){rewind($p);fwrite($p,$sb);ftruncate($p,strlen($sb));file_unlock($p);}function
file_unlock($p){flock($p,LOCK_UN);fclose($p);}function
first(array$na){return
reset($na);}function
password_file($lb){$n=get_temp_dir()."/adminer.key";if(!$lb&&!file_exists($n))return'';$p=file_open_lock($n);if(!$p)return'';$H=stream_get_contents($p);if(!$H){$H=rand_string();file_write_unlock($p,$H);}else
file_unlock($p);return$H;}function
rand_string(){return
md5(uniqid(strval(mt_rand()),true));}function
select_value($X,$y,array$l,$qg){if(is_array($X)){$H="";foreach($X
as$yd=>$W)$H
.="<tr>".($X!=array_values($X)?"<th>".h($yd):"")."<td>".select_value($W,$y,$l,$qg);return"<table>$H</table>";}if(!$y)$y=adminer()->selectLink($X,$l);if($y===null){if(is_mail($X))$y="mailto:$X";if(is_url($X))$y=$X;}$H=adminer()->editVal($X,$l);if($H!==null){if(!is_utf8($H))$H="\0";elseif($qg!=""&&is_shortable($l))$H=shorten_utf8($H,max(0,+$qg));else$H=h($H);}return
adminer()->selectVal($H,$y,$l,$X);}function
is_mail($Ob){$pa='[-a-z0-9!#$%&\'*+/=?^_`{|}~]';$Eb='[a-z0-9]([-a-z0-9]{0,61}[a-z0-9])';$Ve="$pa+(\\.$pa+)*@($Eb?\\.)+$Eb";return
is_string($Ob)&&preg_match("(^$Ve(,\\s*$Ve)*\$)i",$Ob);}function
is_url($Q){$Eb='[a-z0-9]([-a-z0-9]{0,61}[a-z0-9])';return
preg_match("~^(https?)://($Eb?\\.)+$Eb(:\\d+)?(/.*)?(\\?.*)?(#.*)?\$~i",$Q);}function
is_shortable(array$l){return
preg_match('~char|text|json|lob|geometry|point|linestring|polygon|string|bytea~',$l["type"]);}function
count_rows($R,array$Z,$td,array$Gc){$F=" FROM ".table($R).($Z?" WHERE ".implode(" AND ",$Z):"");return($td&&(JUSH=="sql"||count($Gc)==1)?"SELECT COUNT(DISTINCT ".implode(", ",$Gc).")$F":"SELECT COUNT(*)".($td?" FROM (SELECT 1$F GROUP BY ".implode(", ",$Gc).") x":$F));}function
slow_query($F){$i=adminer()->database();$tg=adminer()->queryTimeout();$Tf=driver()->slowQuery($F,$tg);$h=null;if(!$Tf&&support("kill")){$h=connect();if($h&&($i==""||$h->select_db($i))){$Ad=get_val(connection_id(),0,$h);echo
script("const timeout = setTimeout(() => { ajax('".js_escape(ME)."script=kill', function () {}, 'kill=$Ad&token=".get_token()."'); }, 1000 * $tg);");}}ob_flush();flush();$H=@get_key_vals(($Tf?:$F),$h,false);if($h){echo
script("clearTimeout(timeout);");ob_flush();flush();}return$H;}function
get_token(){$pf=rand(1,1e6);return($pf^$_SESSION["token"]).":$pf";}function
verify_token(){list($_g,$pf)=explode(":",$_POST["token"]);return($pf^$_SESSION["token"])==$_g;}function
lzw_decompress($Ca){$Bb=256;$Da=8;$Ua=array();$xf=0;$yf=0;for($r=0;$r<strlen($Ca);$r++){$xf=($xf<<8)+ord($Ca[$r]);$yf+=8;if($yf>=$Da){$yf-=$Da;$Ua[]=$xf>>$yf;$xf&=(1<<$yf)-1;$Bb++;if($Bb>>$Da)$Da++;}}$Ab=range("\0","\xFF");$H="";$kh="";foreach($Ua
as$r=>$Ta){$Nb=$Ab[$Ta];if(!isset($Nb))$Nb=$kh.$kh[0];$H
.=$Nb;if($r)$Ab[]=$kh.$Nb[0];$kh=$Nb;}return$H;}function
script($Vf,$Ag="\n"){return"<script".nonce().">$Vf</script>$Ag";}function
script_src($Wg,$wb=false){return"<script src='".h($Wg)."'".nonce().($wb?" defer":"")."></script>\n";}function
nonce(){return' nonce="'.get_nonce().'"';}function
input_hidden($_,$Y=""){return"<input type='hidden' name='".h($_)."' value='".h($Y)."'>\n";}function
input_token(){return
input_hidden("token",get_token());}function
target_blank(){return' target="_blank" rel="noreferrer noopener"';}function
h($Q){return
str_replace("\0","&#0;",htmlspecialchars($Q,ENT_QUOTES,'utf-8'));}function
nl_br($Q){return
str_replace("\n","<br>",$Q);}function
checkbox($_,$Y,$Oa,$Bd="",$xe="",$Ra="",$Dd=""){$H="<input type='checkbox' name='$_' value='".h($Y)."'".($Oa?" checked":"").($Dd?" aria-labelledby='$Dd'":"").">".($xe?script("qsl('input').onclick = function () { $xe };",""):"");return($Bd!=""||$Ra?"<label".($Ra?" class='$Ra'":"").">$H".h($Bd)."</label>":$H);}function
optionlist($B,$Hf=null,$Zg=false){$H="";foreach($B
as$yd=>$W){$Be=array($yd=>$W);if(is_array($W)){$H
.='<optgroup label="'.h($yd).'">';$Be=$W;}foreach($Be
as$w=>$X)$H
.='<option'.($Zg||is_string($w)?' value="'.h($w).'"':'').($Hf!==null&&($Zg||is_string($w)?(string)$w:$X)===$Hf?' selected':'').'>'.h($X);if(is_array($W))$H
.='</optgroup>';}return$H;}function
html_select($_,array$B,$Y="",$we="",$Dd=""){static$Bd=0;$Cd="";if(!$Dd&&substr($B[""],0,1)=="("){$Bd++;$Dd="label-$Bd";$Cd="<option value='' id='$Dd'>".h($B[""]);unset($B[""]);}return"<select name='".h($_)."'".($Dd?" aria-labelledby='$Dd'":"").">".$Cd.optionlist($B,$Y)."</select>".($we?script("qsl('select').onchange = function () { $we };",""):"");}function
html_radios($_,array$B,$Y="",$L=""){$H="";foreach($B
as$w=>$X)$H
.="<label><input type='radio' name='".h($_)."' value='".h($w)."'".($w==$Y?" checked":"").">".h($X)."</label>$L";return$H;}function
confirm($ae="",$If="qsl('input')"){return
script("$If.onclick = () => confirm('".($ae?js_escape($ae):lang(6))."');","");}function
print_fieldset($s,$Hd,$gh=false){echo"<fieldset><legend>","<a href='#fieldset-$s'>$Hd</a>",script("qsl('a').onclick = partial(toggle, 'fieldset-$s');",""),"</legend>","<div id='fieldset-$s'".($gh?"":" class='hidden'").">\n";}function
bold($Ea,$Ra=""){return($Ea?" class='active $Ra'":($Ra?" class='$Ra'":""));}function
js_escape($Q){return
addcslashes($Q,"\r\n'\\/");}function
pagination($C,$qb){return" ".($C==$qb?$C+1:'<a href="'.h(remove_from_uri("page").($C?"&page=$C".($_GET["next"]?"&next=".urlencode($_GET["next"]):""):"")).'">'.($C+1)."</a>");}function
hidden_fields(array$jf,array$dd=array(),$ef=''){$H=false;foreach($jf
as$w=>$X){if(!in_array($w,$dd)){if(is_array($X))hidden_fields($X,array(),$w);else{$H=true;echo
input_hidden(($ef?$ef."[$w]":$w),$X);}}}return$H;}function
hidden_fields_get(){echo(sid()?input_hidden(session_name(),session_id()):''),(SERVER!==null?input_hidden(DRIVER,SERVER):""),input_hidden("username",$_GET["username"]);}function
enum_input($U,$ra,array$l,$Y,$Rb=null){preg_match_all("~'((?:[^']|'')*)'~",$l["length"],$Td);$H=($Rb!==null?"<label><input type='$U'$ra value='$Rb'".((is_array($Y)?in_array($Rb,$Y):$Y===$Rb)?" checked":"")."><i>".lang(7)."</i></label>":"");foreach($Td[1]as$r=>$X){$X=stripcslashes(str_replace("''","'",$X));$Oa=(is_array($Y)?in_array($X,$Y):$Y===$X);$H
.=" <label><input type='$U'$ra value='".h($X)."'".($Oa?' checked':'').'>'.h(adminer()->editVal($X,$l)).'</label>';}return$H;}function
input(array$l,$Y,$q,$va=false){$_=h(bracket_escape($l["field"]));echo"<td class='function'>";if(is_array($Y)&&!$q){$Y=json_encode($Y,128|64|256);$q="json";}$wf=(JUSH=="mssql"&&$l["auto_increment"]);if($wf&&!$_POST["save"])$q=null;$Dc=(isset($_GET["select"])||$wf?array("orig"=>lang(8)):array())+adminer()->editFunctions($l);$Cb=stripos($l["default"],"GENERATED ALWAYS AS ")===0?" disabled=''":"";$ra=" name='fields[$_]'$Cb".($va?" autofocus":"");$Vb=driver()->enumLength($l);if($Vb){$l["type"]="enum";$l["length"]=$Vb;}echo
driver()->unconvertFunction($l)." ";$R=$_GET["edit"]?:$_GET["select"];if($l["type"]=="enum")echo
h($Dc[""])."<td>".adminer()->editInput($R,$l,$ra,$Y);else{$Nc=(in_array($q,$Dc)||isset($Dc[$q]));echo(count($Dc)>1?"<select name='function[$_]'$Cb>".optionlist($Dc,$q===null||$Nc?$q:"")."</select>".on_help("event.target.value.replace(/^SQL\$/, '')",1).script("qsl('select').onchange = functionChange;",""):h(reset($Dc))).'<td>';$md=adminer()->editInput($R,$l,$ra,$Y);if($md!="")echo$md;elseif(preg_match('~bool~',$l["type"]))echo"<input type='hidden'$ra value='0'>"."<input type='checkbox'".(preg_match('~^(1|t|true|y|yes|on)$~i',$Y)?" checked='checked'":"")."$ra value='1'>";elseif($l["type"]=="set"){preg_match_all("~'((?:[^']|'')*)'~",$l["length"],$Td);foreach($Td[1]as$r=>$X){$X=stripcslashes(str_replace("''","'",$X));$Oa=in_array($X,explode(",",$Y),true);echo" <label><input type='checkbox' name='fields[$_][$r]' value='".h($X)."'".($Oa?' checked':'').">".h(adminer()->editVal($X,$l)).'</label>';}}elseif(preg_match('~blob|bytea|raw|file~',$l["type"])&&ini_bool("file_uploads"))echo"<input type='file' name='fields-$_'>";elseif($q=="json"||preg_match('~^jsonb?$~',$l["type"]))echo"<textarea$ra cols='50' rows='12' class='jush-js'>".h($Y).'</textarea>';elseif(($og=preg_match('~text|lob|memo~i',$l["type"]))||preg_match("~\n~",$Y)){if($og&&JUSH!="sqlite")$ra
.=" cols='50' rows='12'";else{$J=min(12,substr_count($Y,"\n")+1);$ra
.=" cols='30' rows='$J'";}echo"<textarea$ra>".h($Y).'</textarea>';}else{$Lg=driver()->types();$Yd=(!preg_match('~int~',$l["type"])&&preg_match('~^(\d+)(,(\d+))?$~',$l["length"],$z)?((preg_match("~binary~",$l["type"])?2:1)*$z[1]+($z[3]?1:0)+($z[2]&&!$l["unsigned"]?1:0)):($Lg[$l["type"]]?$Lg[$l["type"]]+($l["unsigned"]?0:1):0));if(JUSH=='sql'&&min_version(5.6)&&preg_match('~time~',$l["type"]))$Yd+=7;echo"<input".((!$Nc||$q==="")&&preg_match('~(?<!o)int(?!er)~',$l["type"])&&!preg_match('~\[\]~',$l["full_type"])?" type='number'":"")." value='".h($Y)."'".($Yd?" data-maxlength='$Yd'":"").(preg_match('~char|binary~',$l["type"])&&$Yd>20?" size='".($Yd>99?60:40)."'":"")."$ra>";}echo
adminer()->editHint($R,$l,$Y);$pc=0;foreach($Dc
as$w=>$X){if($w===""||!$X)break;$pc++;}if($pc&&count($Dc)>1)echo
script("qsl('td').oninput = partial(skipOriginal, $pc);");}}function
process_input(array$l){if(stripos($l["default"],"GENERATED ALWAYS AS ")===0)return;$t=bracket_escape($l["field"]);$q=idx($_POST["function"],$t);$Y=$_POST["fields"][$t];if($l["type"]=="enum"||driver()->enumLength($l)){if($Y==-1)return
false;if($Y=="")return"NULL";}if($l["auto_increment"]&&$Y=="")return
null;if($q=="orig")return(preg_match('~^CURRENT_TIMESTAMP~i',$l["on_update"])?idf_escape($l["field"]):false);if($q=="NULL")return"NULL";if($l["type"]=="set")$Y=implode(",",(array)$Y);if($q=="json"){$q="";$Y=json_decode($Y,true);if(!is_array($Y))return
false;return$Y;}if(preg_match('~blob|bytea|raw|file~',$l["type"])&&ini_bool("file_uploads")){$mc=get_file("fields-$t");if(!is_string($mc))return
false;return
driver()->quoteBinary($mc);}return
adminer()->processInput($l,$Y,$q);}function
search_tables(){$_GET["where"][0]["val"]=$_POST["query"];$Jf="<ul>\n";foreach(table_status('',true)as$R=>$S){$_=adminer()->tableName($S);if(isset($S["Engine"])&&$_!=""&&(!$_POST["tables"]||in_array($R,$_POST["tables"]))){$G=connection()->query("SELECT".limit("1 FROM ".table($R)," WHERE ".implode(" AND ",adminer()->selectSearchProcess(fields($R),array())),1));if(!$G||$G->fetch_row()){$hf="<a href='".h(ME."select=".urlencode($R)."&where[0][op]=".urlencode($_GET["where"][0]["op"])."&where[0][val]=".urlencode($_GET["where"][0]["val"]))."'>$_</a>";echo"$Jf<li>".($G?$hf:"<p class='error'>$hf: ".error())."\n";$Jf="";}}}echo($Jf?"<p class='message'>".lang(9):"</ul>")."\n";}function
on_help($Za,$Sf=0){return
script("mixin(qsl('select, input'), {onmouseover: function (event) { helpMouseover.call(this, event, $Za, $Sf) }, onmouseout: helpMouseout});","");}function
edit_form($R,array$m,$I,$Ug,$k=''){$kg=adminer()->tableName(table_status1($R,true));page_header(($Ug?lang(10):lang(11)),$k,array("select"=>array($R,$kg)),$kg);adminer()->editRowPrint($R,$m,$I,$Ug);if($I===false){echo"<p class='error'>".lang(12)."\n";return;}echo"<form action='' method='post' enctype='multipart/form-data' id='form'>\n";if(!$m)echo"<p class='error'>".lang(13)."\n";else{echo"<table class='layout'>".script("qsl('table').onkeydown = editingKeydown;");$va=!$_POST;foreach($m
as$_=>$l){echo"<tr><th>".adminer()->fieldName($l);$j=idx($_GET["set"],bracket_escape($_));if($j===null){$j=$l["default"];if($l["type"]=="bit"&&preg_match("~^b'([01]*)'\$~",$j,$tf))$j=$tf[1];if(JUSH=="sql"&&preg_match('~binary~',$l["type"]))$j=bin2hex($j);}$Y=($I!==null?($I[$_]!=""&&JUSH=="sql"&&preg_match("~enum|set~",$l["type"])&&is_array($I[$_])?implode(",",$I[$_]):(is_bool($I[$_])?+$I[$_]:$I[$_])):(!$Ug&&$l["auto_increment"]?"":(isset($_GET["select"])?false:$j)));if(!$_POST["save"]&&is_string($Y))$Y=adminer()->editVal($Y,$l);$q=($_POST["save"]?idx($_POST["function"],$_,""):($Ug&&preg_match('~^CURRENT_TIMESTAMP~i',$l["on_update"])?"now":($Y===false?null:($Y!==null?'':'NULL'))));if(!$_POST&&!$Ug&&$Y==$l["default"]&&preg_match('~^[\w.]+\(~',$Y))$q="SQL";if(preg_match("~time~",$l["type"])&&preg_match('~^CURRENT_TIMESTAMP~i',$Y)){$Y="";$q="now";}if($l["type"]=="uuid"&&$Y=="uuid()"){$Y="";$q="uuid";}if($va!==false)$va=($l["auto_increment"]||$q=="now"||$q=="uuid"?null:true);input($l,$Y,$q,$va);if($va)$va=false;echo"\n";}if(!support("table")&&!fields($R))echo"<tr>"."<th><input name='field_keys[]'>".script("qsl('input').oninput = fieldChange;")."<td class='function'>".html_select("field_funs[]",adminer()->editFunctions(array("null"=>isset($_GET["select"]))))."<td><input name='field_vals[]'>"."\n";echo"</table>\n";}echo"<p>\n";if($m){echo"<input type='submit' value='".lang(14)."'>\n";if(!isset($_GET["select"]))echo"<input type='submit' name='insert' value='".($Ug?lang(15):lang(16))."' title='Ctrl+Shift+Enter'>\n",($Ug?script("qsl('input').onclick = function () { return !ajaxForm(this.form, '".lang(17)."â€¦', this); };"):"");}echo($Ug?"<input type='submit' name='delete' value='".lang(18)."'>".confirm()."\n":"");if(isset($_GET["select"]))hidden_fields(array("check"=>(array)$_POST["check"],"clone"=>$_POST["clone"],"all"=>$_POST["all"]));echo
input_hidden("referer",(isset($_POST["referer"])?$_POST["referer"]:$_SERVER["HTTP_REFERER"])),input_hidden("save",1),input_token(),"</form>\n";}function
shorten_utf8($Q,$Id=80,$fg=""){if(!preg_match("(^(".repeat_pattern("[\t\r\n -\x{10FFFF}]",$Id).")($)?)u",$Q,$z))preg_match("(^(".repeat_pattern("[\t\r\n -~]",$Id).")($)?)",$Q,$z);return
h($z[1]).$fg.(isset($z[2])?"":"<i>â€¦</i>");}function
icon($Zc,$_,$Yc,$vg){return"<button type='submit' name='$_' title='".h($vg)."' class='icon icon-$Zc'><span>$Yc</span></button>";}if(isset($_GET["file"])){if(substr(VERSION,-4)!='-dev'){if($_SERVER["HTTP_IF_MODIFIED_SINCE"]){header("HTTP/1.1 304 Not Modified");exit;}header("Expires: ".gmdate("D, d M Y H:i:s",time()+365*24*60*60)." GMT");header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");header("Cache-Control: immutable");}@ini_set("zlib.output_compression",'1');if($_GET["file"]=="default.css"){header("Content-Type: text/css; charset=utf-8");echo
lzw_decompress("h:M‡±h´ÄgÌĞ±ÜÍŒ\"PÑiÒm„™cQCa¤é	2Ã³éˆŞd<Ìfóa¼ä:;NBˆqœR;1Lf³9ÈŞu7&)¤l;3ÍÑñÈÀJ/‹†CQXÊr2MÆaäi0›„ƒ)°ìe:LuÃhæ-9ÕÍ23lÈÎi7†³màZw4™†Ñš<-•ÒÌ´¹!†U,—ŒFÃ©”vt2‘S,¬äa´Ò‡FêVXúa˜Nqã)“-—ÖÎÇœhê:n5û9ÈY¨;jµ”-Ş÷_‘9krùœÙ“;.ĞtTqËo¦0‹³­Öò®{íóyùı\rçHnìGS™ Zh²œ;¼i^ÀuxøWÎ’C@Äö¤©k€Ò=¡Ğb©Ëâì¼/AØà0¤+Â(ÚÁ°lÂÉÂ\\ê Ãxè:\rèÀb8\0æ–0!\0FÆ\nB”Íã(Ò3 \r\\ºÛêÈ„a¼„œ'Iâ|ê(iš\n‹\r©¸ú4Oüg@4ÁC’î¼†º@@†!ÄQB°İ	Â°¸c¤ÊÂ¯Äq,\r1EhèÈ&2PZ‡¦ğiGûH9G’\"v§ê’¢££¤œ4r”ÆñÍDĞR¤\n†pJë-A“|/.¯cê“Du·£¤ö:,˜Ê=°¢RÅ]U5¥mVÁkÍLLQ@-\\ª¦ËŒ@9Áã%ÚSrÁÎñMPDãÂIa\rƒ(YY\\ã@XõpÃê:£p÷lLC —Åñè¸ƒÍÊO,\rÆ2]7œ?m06ä»pÜTÑÍaÒ¥Cœ;_Ë—ÑyÈ´d‘>¨²bnğ…«n¼Ü£3÷X¾€ö8\rí[Ë€-)Ûi>V[Yãy&L3¯#ÌX|Õ	†X \\Ã¹`ËC§ç˜å#ÑÙHÉÌ2Ê2.# ö‹Zƒ`Â<¾ãs®·¹ªÃ’£º\0uœhÖ¾—¥M²Í_\niZeO/CÓ’_†`3İòğ1>‹=Ğk3£…‰R/;ä/dÛÜ\0ú‹ŒãŞÚµmùúò¾¤7/«ÖAÎXƒÂÿ„°“Ãq.½sáL£ı— :\$ÉF¢—¸ª¾£‚w‰8óß¾~«HÔj…­\"¨¼œ•¹Ô³7gSõä±âFLéÎ¯çQò_¤’O'WØö]c=ı5¾1X~7;˜™iş´\rí*\n’¨JS1Z¦™ø£ØÆßÍcå‚tœüAÔVí86fĞdÃy;Y]©õzIÀp¡Ñû§ğc‰3®YË]}Â˜@¡\$.+”1¶'>ZÃcpdàéÒGLæá„#kô8PzœYÒAuÏvİ]s9‰ÑØ_AqÎÁ„:†ÆÅ\nK€hB¼;­ÖŠXbAHq,âCIÉ`†‚çj¹S[ËŒ¶1ÆVÓrŠñÔ;¶pŞBÃÛ)#é‰;4ÌHñÒ/*Õ<Â3L Á;lfª\n¶s\$K`Ğ}ÆôÕ”£¾7ƒjx`d–%j] ¸4œ—Y¤–HbY ØJ`¤GG ’.ÅÜK‚òfÊI©)2ÂŠMfÖ¸İX‰RC‰¸Ì±V,©ÛÑ~g\0è‚àg6İ:õ[jí1H½:AlIq©u3\"™êæq¤æ|8<9s'ãQ]JÊ|Ğ\0Â`p ³îƒ«‰jf„OÆbĞÉú¬¨q¬¢\$é©²Ã1J¹>RœH(Ç”q\n#rŠ’à@e(yóVJµ0¡QÒˆ£òˆ6†Pæ[C:·Gä¼‘ İ4©‘Ò^ÓğÃPZŠµ\\´‘è(\nÖ)š~¦´°9R%×Sj·{‰7ä0Ş_šÇs	z|8ÅHê	\"@Ü#9DVLÅ\$H5ÔWJ@—…z®a¿J Ä^	‘)®2\nQvÀÔ]ëÇ†ÄÁ˜‰j (A¸Ó°BB05´6†bË°][ŒèkªA•wvkgôÆ´öºÕ+k[jm„zc¶}èMyDZií\$5e˜«Ê·°º	”A˜ CY%.W€b*ë®¼‚.­Ùóq/%}BÌXˆ­çZV337‡Ê»a™„€ºòŞwW[áLQÊŞ²ü_È2`Ç1IÑi,÷æ›£’Mf&(s-˜ä˜ëÂAÄ°Ø*””DwØÄTNÀÉ»ÅjX\$éxª+;ĞğËFÚ93µJkÂ™S;·§ÁqR{>l;B1AÈIâb) (6±­r÷\rİ\rÚ‡’Ú‚ìZ‘R^SOy/“ŞM#ÆÏ9{k„àê¸v\"úKCâJƒ¨rEo\0øÌ\\,Ñ|faÍš†³hI“©/oÌ4Äk^pî1HÈ^“ÍphÇ¡VÁvox@ø`ígŸ&(ùˆ­ü;›ƒ~ÇzÌ6×8¯*°ÆÜ5®Ü‰±E ÁÂp†éâîÓ˜˜¤´3“öÅ†gŸ™rDÑLó)4g{»ˆä½å³©—Lš&ú>è„»¢ØÚZì7¡\0ú°ÌŠ@×ĞÓÛœffÅRVhÖ²çIŠÛˆ½âğrÓw)‹ ‚„=x^˜,k’Ÿ2ôÒİ“jàbël0uë\"¬fp¨¸1ñRI¿ƒz[]¤wpN6dIªzëõån.7X{;ÁÈ3ØË-I	‹âûü7pjÃ¢R#ª,ù_-ĞüÂ[ó>3À\\æêÛWqŞq”JÖ˜uh£‡ĞFbLÁKÔåçyVÄ¾©¦ÃŞÑ•®µªüVœîÃf{K}S ÊŞ…‰Mş‡·Í€¼¦.M¶\\ªix¸bÁ¡1‡+£Î±?<Å3ê~HıÓ\$÷\\Ğ2Û\$î eØ6tÔOÌˆã\$s¼¼©xÄşx•ó§CánSkVÄÉ=z6½‰¡Ê'Ã¦äNaŸ¢Ö¸hŒÜü¸º±ı¯R¤å™£8g‰¢äÊw:_³î­íÿêÒ’IRKÃ¨.½nkVU+dwj™§%³`#,{é†³ËğÊƒY‡ı×õ(oÕ¾Éğ.¨c‚0gâDXOk†7®èKäÎlÒÍhx;ÏØ İƒLû´\$09*–9 ÜhNrüMÕ.>\0ØrP9ï\$Èg	\0\$\\Fó*²d'ÎõLå:‹bú—ğ42Àô¢ğ9Àğ@ÂHnbì-¤óE #ÄœÉÃ¨\0ÀpY‚ê¨ tÍ Ø\nğ5.©àÊâî\$op l€X\n@`\r€	àˆ\r€Ğ Î ¦ ” ‚ àêğÛ`”\r ´\r £`‚` „0åpä	‘Ş@“\0’ÀĞ	 V\0ò`fÀÏÀª\0¤ Îf€\0j\n f`â	 ®\n`´@˜\$n=`†\0ÈÀƒànIĞ\$ÿP(Âd'Ëğô„Äà·gÉ\n¬4±\n0·¤ˆ.0ÃpËğÒ\r\0‡`–1`“àÎ\n\0_ óqñ1qµ`ß\0¡À”‚ äà˜†\0¢\n@â€ fÍPæ€æ RÇ ŞÇì‚€@ÙrÇFˆ˜¯h\r€@J¶Ñ^LNË!Àé\"\nÒÄeÊ]r:ÊZ7Ò9#\$0¬µ\"gÚ­t”RB×|‘/¼#í”×¸D’1\"®Ff‡\"nºòæ(Yp`W…”YÆ‘Ò]\$ÀFğF¨ğ¯ÜRn\ràw!MrìæK²*s%S\$² Ä¨.s*G*R©(=+‹Ş‹	\n)Òdûò£*mp‘‚\$rĞìä×\$”ÜÀë-â?.2©+r:~²Ğ‚I69+œ4H¼h ú\nz\"Ğ(,2 +Döjuåt@q. ğ³²½RÃ&i,kJ–r`„cÀÕ\"¢CIÑ	êâz8ÚŒ¥¾Û\r´š¯8êÒøİfƒ¢¿ëÃ.\"úÖËä›ê®Ó*h(åé\0ôO‰ªªÍ€Õ r| Ş…M\nĞå¾­o|LJªê²v1N´Ü3E(„R\".fh+FW/ÒÎIšÎ“~ğ/)ÀÚ¦\rÄ‰ï<ÀÛ=h1‰b]¢Ô&Åiœò-òmRôç?ä0Íîú“¦ĞäÔï êïl¦“‰„“ ×®×@ÎÚœo~ò³DÒì—T7t	>k'\$1+î*’ã)2tëzÃ2©<”Y)sæğÓêta4€û1³,\rø+îµ=7l©B/ï;î²×åŠû¯¾ì­)„!>“í<fš¡j]¸ ê\\àÉKç\$Äª5*rQ4‚");}elseif($_GET["file"]=="dark.css"){header("Content-Type: text/css; charset=utf-8");echo
lzw_decompress("h:M‡±h´ÄgÆÈh0ÁLĞàd91¢S!¤Û	Fƒ!°æ\"-6N‘€ÄbdGgÓ°Â:;Nr£)öc7›\rç(HØb81˜†s9¼¤Ük\rçc)Êm8O•VA¡Âc1”c34Of*’ª- P¨‚1©”r41Ùî6˜Ìd2ŒÖ•®Ûo½ÜÌ#3—‰–BÇf#	ŒÖg9Î¦êØŒfc\rÇI™ĞÂb6E‡C&¬Ğ,buÄêm7aVã•ÂÁs²#m!ôèhµårùœŞv\\3\rL:SA”Âdk5İnÇ·×ìšıÊaF†¸3é˜Òe6fS¦ëy¾óør!ÇLú -ÎK,Ì3Lâ@º“J¶ƒË²¢*J äìµ£¤‚»	¸ğ—¹Ášb©cèà9­ˆê9¹¤æ@ÏÔè¿ÃHÜ8£ \\·Ãê6>«`ğÅ¸Ş;‡Aˆà<T™'¨p&q´qEˆê4Å\rl­…ÃhÂ<5#pÏÈR Ñ#I„İ%„êfBIØŞÜ²”¨>…Ê«29<«åCîj2¯î»¦¶7j¬“8jÒìc(nÔÄç?(a\0Å@”5*3:Î´æ6Œ£˜æ0Œã-àAÀlL›•PÆ4@ÊÉ°ê\$¡H¥4 n31¶æ1Ítò0®áÍ™9ŒƒéWO!¨r¼ÚÔØÜÛÕèHÈ†£Ã9ŒQ°Â96èF±¬«<ø7°\rœ-xC\n Üã®@Òø…ÜÔƒ:\$iÜØ¶m«ªË4íKid¬²{\n6\r–…xhË‹â#^'4Vø@aÍÇ<´#h0¦Sæ-…c¸Ö9‰+pŠ«Ša2Ôcy†h®BO\$Áç9öw‡iX›É”ùVY9*r÷Htm	@bÖÑ|@ü/€l’\$z¦­ +Ô%p2l‹˜É.õØúÕÛìÄ7ï;Ç&{ÀËm„€X¨C<l9ğí6x9ïmìò¤ƒ¯À­7RüÀ0\\ê4Î÷PÈ)AÈoÀx„ÄÚqÍO#¸¥Èf[;»ª6~PÛ\rŒa¸ÊTGT0„èìu¸ŞŸ¾³Ş\n3ğ\\ \\ÊƒJ©udªCGÀ§©PZ÷>“³Áûd8ÖÒ¨èéñ½ïåôC?V…·dLğÅL.(tiƒ’­>«,ôƒÖLÀ");}elseif($_GET["file"]=="functions.js"){header("Content-Type: text/javascript; charset=utf-8");echo
lzw_decompress("':œÌ¢™Ğäi1ã³1Ôİ	4›ÍÀ£‰ÌQ6a&ó°Ç:OAIìäe:NFáD|İ!‘Ÿ†CyŒêm2ËÅ\"ã‰ÔÊr<”Ì±˜ÙÊ/C#‚‘Ùö:DbqSe‰JË¦CÜº\n\n¡œÇ±S\rZ“H\$RAÜS+XKvtdÜg:£í6Ÿ‰EvXÅ³j‘ÉmÒ©ej×2šM§©äúB«Ç&Ê®‹L§C°3„åQ0ÕLÆé-xè\nÓìD‘ÈÂyNaäPn:ç›¼äèsœÍƒ( cLÅÜ/õ£(Æ5{ŞôQy4œøg-–‚ı¢êi4ÚƒfĞÎ(ÕëbUıÏk·îo7Ü&ãºÃ¤ô*ACb’¾¢Ø`.‡­ŠÛ\rÎĞÜü»ÏÄú¼Í\n ©ChÒ<\r)`èØ¥`æ7¥CÊ’ŒÈâZùµãXÊ<QÅ1X÷¼‰@·0dp9EQüf¾°ÓFØ\r‰ä!ƒæ‹(hô£)‰Ã\np'#ÄŒ¤£HÌ(i*†r¸æ&<#¢æ7KÈÈ~Œ# È‡A:N6ã°Ê‹©lÕ,§\r”ôJPÎ3£!@Ò2>Cr¾¡¬h°N„á]¦(a0M3Í2”×6…ÔUæ„ãE2'!<·Â#3R<ğÛãXÒæÔCHÎ7ƒ#nä+±€a\$!èÜ2àPˆ0¤.°wd¡r:Yö¨éE²æ…!]„<¹šjâ¥ó@ß\\×pl§_\rÁZ¸€Ò“¬TÍ©ZÉsò3\"²~9À©³jã‰PØ)Q“Ybİ•DëYc¿`ˆzácµÑ¨ÌÛ'ë#t“BOh¢*2ÿ…<Å’Oêfg-Z£œˆÕ# è8aĞ^ú+r2b‰ø\\á~0©áş“¥ùàW©¸ÁŞnœÙp!#•`åëZö¸6¶12×Ã@é²kyÈÆ9\rìäB3çƒpŞ…î6°è<£!pïG¯9àn‘o›6s¿ğ#FØ3íÙàbA¨Ê6ñ9¦ıÀZ£#ÂŞ6ûÊ%?‡s¨È\"ÏÉ|Ø‚§)şbœJc\r»Œ½NŞsÉÛih8Ï‡¹æİŸè:Š;èúHåŞŒõu‹I5û@è1îªAèPaH^\$H×vãÖ@Ã›L~—¨ùb9'§ø¿±S?PĞ-¯˜ò˜0Cğ\nRòmÌ4‡ŞÓÈ“:ÀõÜÔ¸ï2òÌ4œµh(k\njIŠÈ6\"˜EYˆ#¹W’rª\r‘G8£@tĞáXÔ“âÌBS\nc0Ék‚C I\rÊ°<u`A!ó)ĞÔ2”ÖC¢\0=‡¾ æáäPˆ1‘Ó¢K!¹!†åŸpÄIsÑ,6âdÃéÉi1+°ÈâÔk‰€ê<•¸^	á\nÉ20´FÔ‰_\$ë)f\0 ¤C8E^¬Ä/3W!×)Œu™*äÔè&\$ê”2Y\n©]’„EkñDV¨\$ïJ²’‡xTse!RY» R™ƒ`=Lò¸ãàŞ«\nl_.!²V!Â\r\nHĞk²\$×`{1	|± °i<jRrPTG|‚w©4b´\r‰¡Ç4d¤,§E¡È6©äÏ<Ãh[N†q@Oi×>'Ñ©\rŠ¥ó—;¦]#“æ}Ğ0»ASIšJdÑA/QÁ´â¸µÂ@t\r¥UG‚Ä_G<éÍ<y-IÉzò„¤Ğ\" PÂàB\0ıíÀÈÁœq`‘ïvAƒˆaÌ¡Jå RäÊ®)Œ…JB.¦TÜñL¡îy¢÷ Cpp\0(7†cYY•a¨M€é1•em4Óc¢¸r£«S)oñÍà‚pæC!I†¼¾SÂœb0mìñ(d“EHœøš¸ß³„X‹ª£/¬•™P©èøyÆXé85ÈÒ\$+—Ö–»²gdè€öÎÎyİÜÏ³J×Øë ¢lE“¢urÌ,dCX}e¬ìÅ¥õ«mƒ]ˆĞ2 Ì½È(-z¦‚Zåú;Iöî¼\\Š) ,\n¤>ò)·¤æ\rVS\njx*w`â´·SFiÌÓd¯¼,»áĞZÂJFM}ĞŠ À†\\Z¾Pìİ`¹zØZûE]íd¤”ÉŸOëcmÔ]À ¬Á™•‚ƒ%ş\"w4Œ¥\n\$øÉzV¢SQDÛ:İ6«äG‹wMÔîS0B‰-sÆê)ã¾Zí¤cÇ2†˜Î´A;æ¥n©Wz/AÃZh G~cœc%Ë[ÉD£&lFRæ˜77|ªI„¢3¹íg0ÖLƒˆa½äcÃ0RJ‘2ÏÑ%“³ÃFáº SÃ ©L½^‘ trÚîÙtñÃ›¡Ê©;”Ç.å–šÅ”>ù€Ãá[®a‡N»¤Ï^Ã(!g—@1ğğó¢üN·zÔ<béİ–ŒäÛÑõO,ÛóCîuº¸D×tjŞ¹I;)®İ€é\nnäcºáÈ‚íˆW<sµ	Å\0÷hN¼PÓ9ÎØ{ue…¤utëµ•öè°ºó§½ 3ò‡î=ƒg¥ëº¸ÎÓJìÍºòWQ‡0ø•Øw9p-…Àº	ı§”øËğÙ'5»´\nOÛ÷e)MÈ)_kàz\0V´ÖÚúŞ;jîlîÎ\nÀ¦êçxÕPf-ä`CË.@&]#\0Ú¶pğyÍ–Æ›ŒtËdú¶ Ãó¼b}	G1·mßru™ßÀ*ñ_ÀxD²3Çq¼„BÓsQæ÷u€ús%ê\nª5s§ut½„Â{sòy¥€øNŸ¯4¥,J{4@®ş\0»’PÄÊÃ^ºš=“¯l„“²`èe~FÙ¡h3oé\"¤”q·R<iUT°[QàôUˆÇM6üT. ºê0'pe\\¼½ôŞ5ßÖÌ”pCe	Ù•Ô\"* M	”¨¦–D™ş±?ûhüØ2¡ĞãzU@7°CÓ4ıaµ²iE!fË\$üB¤…<œ9o*\$¯ælH™\$ Å@ààÊæ€P\rNÀYn<\$²	ÀQ…=F&¥ *@]\0ÊÏË W'dÖ z\$æĞjĞP[¢ö\$òä¯Ğ0#& _Ì`+†B)„wŒv%	âÔ›LcJ„€RSÀÂi`ÌÅ®	F€W	êË\nBP\nç\r\0}	ï¦®0²Zğ¸‚ò/`j\$«: §8ieüÀØÏ†xâ¹Â±îa ¬GnøsgO¢äU%VU°†@‚NÀ¤Ïúd+®(oJï†@XÆèàzM'FÙ£àWhV®I^Ù¢™1>İ@Ğ\"î¨¤‰ ÈQñR!‘\\¢`[¥¤«¨‰.Ø0fb†F;ëÂ‡çFpÏp/t`Â ô®(§ÀVé¸ø b“È²‰(€ˆHˆl‚œÁÎÔ¯1v­Ş‘€ğHĞï1Tï3ñ“q›àÉ1¦ÑªfË\nT\$°éàNq+Ëí`ŞvÖÇœï\rüVmûÇr°¨Ø'Ï¸±ñg%«\"Lˆm¼…‘(’(CLzˆ\"hâXØm= \\H\n0U‡‚ f&M\$¤g\$ñU`a\rPş>`Ë#gªhôî`†R4H€Ñ'ç©­³²GK;\"M¶Û¨TŒhµBEn\"b> Ú\rÀš©#›\0æ•N:í#_	QQ1{	f:BËÂáRª&àÜã)JµÄBr¹+ÂK.\$ĞPqõ-r®S%TIT&Qö·Ò{#2o(*P¯â5ï`„1H…®¢'	<Tğd±÷ª¾sÀì,NÚÊ ÒÉÔì^\r%ƒ3îĞ\r&à“4Bì/\0ĞkLH\$³4dÓ>ŠàÒ/³à¶µ€Hö€·* ºù3JÇĞ¥<†Hh©pú'‚çO/&ï2I.îx3V.¢s5Óe3íªÛZÛ(õ9E”g§;R—;±J½‘QÃ@ªÓvgz@¶“‚Şó†'dZ&Â,Uã²ßò¦F æb*²D‹òH! ä\r’;%‡x'G#°šÍ w‰Á#°Ö È2;#òBvÀXÉâ”aí\nb”{4K€G¦ß%°†ÒGuE`\\\rB\r\0¨-mW\rM\"¶#EôcFbFÕnzÓóÿ@4JÈÒ[\$Êë%2V”‹%ô&TÔV›ˆdÕ4hemN¯-;EÄ¾%E¥E´r <\"@»FÔPÂ€·L Üß­Ü4EÉğ°ÒÄz`ĞuŒ7éNŠ4¯Ë\0°F:hÎKœh/:\"™MÊZÔö\r+P4\r?¤™Sø™O;B©0\$FCEp‚ÇM\"%H4D´|€LN†FtEÑşgŠş°5å=J\r\"›Ş¼5³õ4à¾KñP\rbZà¨\r\"pEQ'DwKõW0î’g'…l\"hQFïC,ùCcŒ®òIHÒP hF]5µ& fŸTæÌiSTUS¨ÿîÉ[4™[uºNe–\$oüKìÜO àÿb\" 5ï\0›DÅ)EÒ%\"±]Âî/­âÈĞŒJ­6UÂdÿ‡`õña)V-0—DÓ”bMÍ)­šŠïÔ¯ØıÄ`Šæ%ñELtˆ˜+ìÛ6C7jëdµ¤:´V4Æ¡3î -ßR\rGòIT®…#¥<4-CgCP{V…\$'ëˆÓ÷gàûR@ä'Ğ²S=%À½óFñk: ¢k‘Ø9®²¤óe]aO¼ÒG9˜;îù-6Ûâ8WÀ¨*øx\"U‹®YlBïîöò¯ğÖ´°·	§ı\n‚îp®ğÉlšÉìÒZ–m\0ñ5¢òä®ğOqÌ¨ÌÍbÊW1s@ĞùKéº-pîûÆE¦Spw\nGWoQÓqG}vp‹w}q€ñqÓ\\Æ7ÆRZ÷@Ìì¡t‡ıtÆ;pG}w×€/%\"LE\0tÀhâ)§\r€àJÚ\\W@à	ç|D#S³¸ÆƒVÏâR±z‰2Ïõövµú©–‘	ã}¨’‡¢¯(¸\0y<¤X\r×İx±°‹q·<µœIsk1Sñ-Q4Yq8î#Şîv—îĞd.Ö¹S;qË!,'(òƒä<.è±J7Hç\"’š.³·¨ñuŒ°‡ü€#ÊQ\reƒrÀXv[¬h\$â{-éY °ûJBgé‰iM8¸”'Â\nÆ˜tDZ~/‹b‹ÖÕ8¸\$¸¸DbROÂOÆû`O5S>¸ö˜Î[ DÇê”¸¥ä€_3Xø)©À'éÄJd\rX»©¸UDìU X8ò•x¯-æ—…àPÌN` 	à¦\nŠZà‹”@Ra48§Ì:ø©\0éŠx°†ÖN§\\ê0%ãŒ·f“˜\\ ğ>\"@^\0ZxàZŸ\0ZaBr#åXÇğ\r•¨{•àË•¹flFb\0[–Şˆ\0[—6›˜	˜¢° ©=’â\n ¦WBøÆ\$'©kG´(\$yÌe9Ò(8Ù& h®îRÜ”ÙæoØÈ¼ Ç‡øƒ†Y£–4Øô7_’­dùã9'ı‘¢ú Üúï²ûz\r™ÙÖ  Ÿåğşv›G€èO8èØìMOh'æèXöS0³\0\0Ê	¸ı9s?‡öI¹MY¢8Ø 9ğ˜üä£HO“—,4	•xs‘‚P¤*G‡¢çc8·ªQÉ ø˜wB|Àz	@¦	à£9cÉK¤¤QGÄbFjÀXú’oSª\$ˆdFHÄ‚PÃ@Ñ§<å¶´Å,‚}ï®m£–rœÿ\"Å'k‹`Œ¡cà¡x‹¦e»C¨ÑCìì:¼ŞØ:XÌ ¹TŞÂÂ^´dÆÃ†qh¤ÎsÃ¹×LvÊÒ®0\r,4µ\r_vÔLòj¥jMáb[  ğƒlsÀŞ•Z°@øºäÁ¶;f”í`2Ycëeº'ƒMerÊÛF\$È!êê\n ¤	*0\rºAN»LP¥äjÙ“»»¿¼;Æ£VÓQ|(ğ‰3’†ÄÊ[p‰˜8óú¼|Ô^\räBf/DÆØÕÒ Bğ€_¶N5Mô© \$¼\naZĞ¦¶È€~ÀUlï¥eõrÅ§rÒ™Z®aZ³•¹ãøÕ£s8RÀGŒZŒ w®¢ªNœ_Æ±«YÏ£òm­‰âªÀ]’¦;ÆšLÚÿ‚º¶cø™€û°Å°ÆÚIÀQ3¹”Oã‡Ç|’y*`  ê5ÉÚ4ğ;&v8‘#¯Rô8+`XÍbVğ6¸Æ«i•3Fõ×EĞô„Øoc82ÛM­\"¶˜¹©G¦Wb\rOĞC¿VdèÓ­¤w\\äÍ¯*cSiÀQÒ¯“ã³R`úd7}	‚ºš)¢Ï´·,+bd§Û¹½FN£3¾¹L\\ãşeRn\$&\\rôê+dæÕ]O5kq,&\"DCU6j§pçÇÉ\\'‚@oµ~è5N=¨|”&è´!ÏÕBØwˆHÚyyz7Ï·(Çøâ½b5(3Öƒ_\0`zĞb®Ğ£r½‚8	ğ¢ZàvÈ8LË“·)²SİM<²*7\$›º\rRŒb·–âB%ıàÆ´Ds€zÏR>[‚Q½ŒĞ&Q«¨À¯¡Ì'\r‡ppÌz·/<‹‡}L¢#°Î•ÂĞâZ¹ã²\"tÆï\n„.4Şgæ«Pºp®Dìnà¥Ê¹NÈâFàd\0`^—åä\rnÈ‚×³#_âÄ w(ü2÷<7-ªXŞ¹\0··s¬ø,^¹hC,å!:×\rK„Ó.äİÓ¢¯Å¢ï¹ÔØ\\„ò+v˜Zàê\0§Q9eÊ›ËEöw?>°\$}£·D#ªğã cÓ0MV3½%Y»ÛÀ\rûÄtj5ÔÅ7¼ü{ÅšLz=­<ƒë8IøMõ°•õâGØÑÎŞLÅ\$’á2‰€{(ÿpe?uİ,Rïd*Xº4é®ı¿‡Í\0\"@Šˆš}<.@õ’	€ŞN²²\$î«XUjsİ/üî<>\"* è#\$Ôş÷Õ&CPI	ÿèt¿áùü¦î?è †´	ğOËÇ\\ Ì_èÎQ5YH@‹ŠÙbâÑcÑhî·ùæë±––…O0T©' 8¡wü»­öj+H€v_#º„íïì06ÈwÖœX†à»d+£Ü“\\Àå–\n\0	\\ğŸŸ>sî…ÓšA	PFöd8m'@š\nH´\0¬cèOwSßØ’—Yá`²ˆˆ¨¢R×ıDna\" ì™~Â?Ámğ†|@6ä½+ìGxV’ä\0°‰WƒÓ°’nw”„‘.¡Øƒb«Ÿ9Ã¸ˆEÈ|E·ÃÂ\rĞˆr¬\"Ğøx„‘¸-¸êŠâš\rN6n·\$Ò¬ı-BíHæ^Ó)â¥y&ãã×šW–Ç§àbv…Rì	¸¥³N\0°Ànâ	T„–`8X¬ğA\r:{Oş@\" Œ!Á¤\$KÂäqoĞËjYÖªJ´şÂíÜh}d<1IÇxdŠÊÎTT4NeeC0ä¥¿‡:D›FÚ5LŞ*::H”jZå—­FõRªMÖ€nS\n>POó[Œ\$V8;#‰K\\'ùBÖè»R®Ø¯°›RÑ_8Ájé*Ej \\~vÆÂĞvÄÛp@T€X‹\0002dE	…Hí‡Vğñ×D”\"Q'EDJB~A´ƒA¤Il*'\n¶Yå.è›+©9¾ñpg†ƒÒ/\"¸1—8Ä0„IAÊFCÈ¨ŠV*a™èPÀdÖĞ£5H\" AØå6İs¬YİØ;è¨È/¨¸0ãv}y˜\rÍƒâÎ×¥1…u\"Ë‹Šmãñ_º0ç„„`ß¯¿\\B1^\nk\r]lhø}]HBW`±—0½ê¨¹rFf€)”W,ÕÒ§]sm9'O¢xÔ½Í,ê9J8§£? 4ÉÉï¡\"Ò…èÛ½Ì<Ñ-S¨ÉÃşMÃ;ĞvÌñ6y|„ZòÁ‹¨%àa•#8¢ˆTC‘!pºË\nØïCZ(ï½9|Ü¾æª,Ú\nº+Q\$äÅ­ôÈ+İ_+ãÊ\$¸ú%d  eDQ‚JŸØü¥iXˆ}\0P×¾‡²Çü·æ”BPë†¾ÄW?¥úÉè¯Œ‹7áHQ~§üWòşS¾É\n?	Å ç€Êúö>µ!oĞ\0ğR1áÂ9‚c‘x\$bĞ6ŠzB‹ƒ‹”\"ÄY«Ö²‚©ù\$k#w 4„Èr’¿ÆîˆÎ|J y>ãú\$˜¹'İà)æ~8˜ÀÂ„é-¼«ÒD”‡Äu!¥~öCÌ&c–dPú&ö–¡şÈ‚Aîœ<=bnIÿ	\\‰xÑÈX'@ˆ	ùËÛOìƒçSª`XÉ‘[dÓ!ÕŠâ&¹Šèå‡±Aà!I\$'””íUS(&SîÚl¨¼®uk—†GÉ'»¡Rš>WI¡~Òj”Œ™†L¦õ>…ôbË(Ğ™ßé'U²IİÄ’º½¤<òI(¡*Jc¢XBÖ|zGprñÔb+LZ‹U­–fQ±<DáçU\n“Tô\"¥ìñaÃ~SÀ™t¤ÂÙ©E|NRĞ");}elseif($_GET["file"]=="jush.js"){header("Content-Type: text/javascript; charset=utf-8");echo
lzw_decompress('');}elseif($_GET["file"]=="logo.png"){header("Content-Type: image/png");echo"‰PNG\r\n\n\0\0\0\rIHDR\0\0\09\0\0\09\0\0\0~6¶\0\0\0000PLTE\0\0\0ƒ—­+NvYt“s‰£®¾´¾ÌÈÒÚü‘üsuüIJ÷ÓÔü/.üü¯±úüúC¥×\0\0\0tRNS\0@æØf\0\0\0	pHYs\0\0\0\0\0šœ\0\0´IDAT8Õ”ÍNÂ@ÇûEáìlÏ¶õ¤p6ˆG.\$=£¥Ç>á	w5r}‚z7²>€‘På#\$Œ³K¡j«7üİ¶¿ÌÎÌ?4m•„ˆÑ÷t&î~À3!0“0Šš^„½Af0Ş\"å½í,Êğ* ç4¼Œâo¥Eè³è×X(*YÓó¼¸	6	ïPcOW¢ÉÎÜŠm’¬rƒ0Ã~/ áL¨\rXj#ÖmÊÁújÀC€]G¦mæ\0¶}ŞË¬ß‘u¼A9ÀX£\nÔØ8¼V±YÄ+ÇD#¨iqŞnKQ8Jà1Q6²æY0§`•ŸP³bQ\\h”~>ó:pSÉ€£¦¼¢ØóGEõQ=îIÏ{’*Ÿ3ë2£7÷\neÊLèBŠ~Ğ/R(\$°)Êç‹ —ÁHQn€i•6J¶	<×-.–wÇÉªjêVm«êüm¿?SŞH ›vÃÌûñÆ©§İ\0àÖ^Õq«¶)ª—Û]÷‹U¹92Ñ,;ÿÇî'pøµ£!XËƒäÚÜÿLñD.»tÃ¦—ı/wÃÓäìR÷	w­dÓÖr2ïÆ¤ª4[=½E5÷S+ñ—c\0\0\0\0IEND®B`‚";}exit;}if($_GET["script"]=="version"){$n=get_temp_dir()."/adminer.version";@unlink($n);$p=file_open_lock($n);if($p)file_write_unlock($p,serialize(array("signature"=>$_POST["signature"],"version"=>$_POST["version"])));exit;}if(!$_SERVER["REQUEST_URI"])$_SERVER["REQUEST_URI"]=$_SERVER["ORIG_PATH_INFO"];if(!strpos($_SERVER["REQUEST_URI"],'?')&&$_SERVER["QUERY_STRING"]!="")$_SERVER["REQUEST_URI"].="?$_SERVER[QUERY_STRING]";if($_SERVER["HTTP_X_FORWARDED_PREFIX"])$_SERVER["REQUEST_URI"]=$_SERVER["HTTP_X_FORWARDED_PREFIX"].$_SERVER["REQUEST_URI"];define('Adminer\HTTPS',($_SERVER["HTTPS"]&&strcasecmp($_SERVER["HTTPS"],"off"))||ini_bool("session.cookie_secure"));@ini_set("session.use_trans_sid",'0');if(!defined("SID")){session_cache_limiter("");session_name("adminer_sid");session_set_cookie_params(0,preg_replace('~\?.*~','',$_SERVER["REQUEST_URI"]),"",HTTPS,true);session_start();}remove_slashes(array(&$_GET,&$_POST,&$_COOKIE),$oc);if(function_exists("get_magic_quotes_runtime")&&get_magic_quotes_runtime())set_magic_quotes_runtime(false);@set_time_limit(0);@ini_set("precision",'15');function
lang($t,$A=null){if(is_string($t)){$bf=array_search($t,get_translations("en"));if($bf!==false)$t=$bf;}$ma=func_get_args();$ma[0]=Lang::$translations[$t]?:$t;return
call_user_func_array('Adminer\lang_format',$ma);}function
lang_format($Cg,$A=null){if(is_array($Cg)){$bf=($A==1?0:(LANG=='cs'||LANG=='sk'?($A&&$A<5?1:2):(LANG=='fr'?(!$A?0:1):(LANG=='pl'?($A%10>1&&$A%10<5&&$A/10%10!=1?1:2):(LANG=='sl'?($A%100==1?0:($A%100==2?1:($A%100==3||$A%100==4?2:3))):(LANG=='lt'?($A%10==1&&$A%100!=11?0:($A%10>1&&$A/10%10!=1?1:2)):(LANG=='lv'?($A%10==1&&$A%100!=11?0:($A?1:2)):(in_array(LANG,array('bs','ru','sr','uk'))?($A%10==1&&$A%100!=11?0:($A%10>1&&$A%10<5&&$A/10%10!=1?1:2)):1))))))));$Cg=$Cg[$bf];}$Cg=str_replace("'",'â€™',$Cg);$ma=func_get_args();array_shift($ma);$_c=str_replace("%d","%s",$Cg);if($_c!=$Cg)$ma[0]=format_number($A);return
vsprintf($_c,$ma);}function
langs(){return
array('en'=>'English','ar'=>'Ø§Ù„Ø¹Ø±Ø¨ÙŠØ©','bg'=>'Ğ‘ÑŠĞ»Ğ³Ğ°Ñ€ÑĞºĞ¸','bn'=>'à¦¬à¦¾à¦‚à¦²à¦¾','bs'=>'Bosanski','ca'=>'CatalÃ ','cs'=>'ÄŒeÅ¡tina','da'=>'Dansk','de'=>'Deutsch','el'=>'Î•Î»Î»Î·Î½Î¹ÎºÎ¬','es'=>'EspaÃ±ol','et'=>'Eesti','fa'=>'ÙØ§Ø±Ø³ÛŒ','fi'=>'Suomi','fr'=>'FranÃ§ais','gl'=>'Galego','he'=>'×¢×‘×¨×™×ª','hi'=>'à¤¹à¤¿à¤¨à¥à¤¦à¥€','hu'=>'Magyar','id'=>'Bahasa Indonesia','it'=>'Italiano','ja'=>'æ—¥æœ¬èª','ka'=>'áƒ¥áƒáƒ áƒ—áƒ£áƒšáƒ˜','ko'=>'í•œêµ­ì–´','lt'=>'LietuviÅ³','lv'=>'LatvieÅ¡u','ms'=>'Bahasa Melayu','nl'=>'Nederlands','no'=>'Norsk','pl'=>'Polski','pt'=>'PortuguÃªs','pt-br'=>'PortuguÃªs (Brazil)','ro'=>'Limba RomÃ¢nÄƒ','ru'=>'Ğ ÑƒÑÑĞºĞ¸Ğ¹','sk'=>'SlovenÄina','sl'=>'Slovenski','sr'=>'Ğ¡Ñ€Ğ¿ÑĞºĞ¸','sv'=>'Svenska','ta'=>'à®¤â€Œà®®à®¿à®´à¯','th'=>'à¸ à¸²à¸©à¸²à¹„à¸—à¸¢','tr'=>'TÃ¼rkÃ§e','uk'=>'Ğ£ĞºÑ€Ğ°Ñ—Ğ½ÑÑŒĞºĞ°','uz'=>'OÊ»zbekcha','vi'=>'Tiáº¿ng Viá»‡t','zh'=>'ç®€ä½“ä¸­æ–‡','zh-tw'=>'ç¹é«”ä¸­æ–‡',);}function
switch_lang(){echo"<form action='' method='post'>\n<div id='lang'>","<label>".lang(19).": ".html_select("lang",langs(),LANG,"this.form.submit();")."</label>"," <input type='submit' value='".lang(20)."' class='hidden'>\n",input_token(),"</div>\n</form>\n";}if(isset($_POST["lang"])&&verify_token()){cookie("adminer_lang",$_POST["lang"]);$_SESSION["lang"]=$_POST["lang"];redirect(remove_from_uri());}$aa="en";if(idx(langs(),$_COOKIE["adminer_lang"])){cookie("adminer_lang",$_COOKIE["adminer_lang"]);$aa=$_COOKIE["adminer_lang"];}elseif(idx(langs(),$_SESSION["lang"]))$aa=$_SESSION["lang"];else{$da=array();preg_match_all('~([-a-z]+)(;q=([0-9.]+))?~',str_replace("_","-",strtolower($_SERVER["HTTP_ACCEPT_LANGUAGE"])),$Td,PREG_SET_ORDER);foreach($Td
as$z)$da[$z[1]]=(isset($z[3])?$z[3]:1);arsort($da);foreach($da
as$w=>$lf){if(idx(langs(),$w)){$aa=$w;break;}$w=preg_replace('~-.*~','',$w);if(!isset($da[$w])&&idx(langs(),$w)){$aa=$w;break;}}}define('Adminer\LANG',$aa);class
Lang{static$translations;}Lang::$translations=(array)$_SESSION["translations"];if($_SESSION["translations_version"]!=LANG.
3422726030){Lang::$translations=array();$_SESSION["translations_version"]=LANG.
3422726030;}if(!Lang::$translations){Lang::$translations=get_translations(LANG);$_SESSION["translations"]=Lang::$translations;}function
get_translations($Ed){switch($Ed){case"en":$f="%ÌÂ˜(ªn0˜†QĞŞ :œ\r†ó	@a0±p(ša<M§Sl\\Ù;™bÑ¨\\Òz†Nb)Ì…#Fá†Cy–fn7Y	Ìé†Ìh5\rÇQå<›Î°C­\\~\n2›NCÈ(Şr4™Í0ƒ`(:Bag8éÈi:‰&ã™”åy·ˆFó½ĞY­\r´2€ 8ZÓ£<úˆ™'HaĞÑ2†ÜŒ±Ò0Ê\nÒãbæè±ŒŞn:ZÎ°ÉUãQ¦ÕÅ­wÛø€İD¼êmfpQËÎ‰†qœêaÊÁ¯°cq®€w7PÎX3”t‰›„˜o¢	æZB9ÄNzÃÄs;ÙÌ‘Ò„/Å:øõğÃ|<Úâø4µéšjœ'JŠ:0ÂrH1/È+¾Î7(jDÓŠc¢Ğæ ¢Ö0K(œ2ˆä5B8Ê7±\$Bé/Èhò8'ÀRì¼,ñ€ä„E P ÷ÄÃ#”7­Ct|¿\r®`ÊØœŠ·£¸@¼, PJ‹CË8Êá²Î £Ìj A b„œĞµ,@1\0S˜<ãBı=RDÛ#b×Í¨\\ü:àP\$Bhš\nb˜-4ˆò.…£hÚŒ’¦ãŒ³óÈğJÉšF£àÂš‡Ê¸è®».b.íŒ#ÈxŒ!ò;SU^9Ê½gZ¦‰š×`»É“E`„:†„!HbkdVC%p\"ø‰‰”\rÓÄÄàÌ3\r‹[G6Lhå!ŒêÒò*\rè|’7(‚ø:Œc|9ŒÃ¨Ù&ÈØX†Ä(¸Î0Øvº6¶Là\\Ş”ç{=7Í÷~ßòv‚^®†ìáH¶7³±\"]Êæ,9ß—ò:*1nªf3YOË†#&F¿`mt2F53«ŒÁèD4ƒ à9‡Ax^;êr+»«8ÎÉazx„Oãp^ÚÛ6á×õ´Û–ZĞPà4ªã&‰MÏ5VàëZ:¨Ñ‹İ–H;VØ•Õ*04hš6‘¥išv ;êYÕÍªZ¾³iÀm~¿T	+¶-‘³Ãz,‡HÖ˜½²D”Ø4—ŞÒô[{Q¨P…–Ñ>`V`†3öÒ;£wÿmY å¢ÃÌÎZ8­õ–cŠxò; ƒZ{l–ØŒ#d‡ò–­\0··öKıìv“8‹\n@¡@_2ø	¨SW÷ƒ¶\rWA¸ß»ãšeÌ’2„¨ÈÅ„OÊ	&%\0½çü¹MkŞ6¥ğ˜gvUÒ™3#Ì÷/¤¦vOü'”È\$äõúpt¥¥¤%ã:öa?+œ½ÁpÒE‚S\nAËºpÜàTÙ¬zä1ãV<İˆñ \$Dß ôb`‘„„hã†BfQÑ*p\0€ú·bìfX…è•’¶]È±ç ‰-Ñ™òfUÃ‰³T˜Á’VrÕ\"YÙdLñ™ã@{Œ«/^)x´Æ@Â¢Ÿ..)¥ñ\rÉÙàZ4Ÿx–²ò¼+­Œ×FşïŒi1n’\"DÈ©‘œ0¢Ê	2d`#Gæs\rÑb=‰L¡GÄY×I~#¡\$ÎSLĞ‚K<Šq÷Ì¹šb6šFdÍÁI˜XV|Ï›L€¾éª•Ô×œSEV®5;5Räé,\$ÌÅš©ØEçr~‚\r\rÀW ÃHc\rk%V‚.là@mtA¤3/Rğ‚	k´†ĞœP¨h8Yf¸»œÒ:—LRa–i'Üà'‰‚0“ĞÜOzL{ ¡Xî¾¨\"…\nKŠÍ#Ô.†€¦€×Ñ¬8`*JÀºAM©y\n§¤¤Ò×@İ%\n.ô5ëš\n¹ÂadEL—†Ej?:0\0£\0 ®y-*ç¥nÎŠTéM! ªn› È™¿FÁá÷©„_Ójo\rHŒ,:r\\İÑ¢¨”®·G’ü½J\"d°0'„¶—lqh2ÖD1Ù2-eAp";break;case"ar":$f="%ÌÂ˜)²Šl*›–ÂÁ°±CÛ(X²…l¡\"qd+aN.6­…d^\"§ŒÅå(<e°£l ›VÊ&,‡l¢S™\nA”Æ#RÆÂêNd”¥|€X\nFC1 Ôl7`Ó„\$F`†„Ç!2öÊ\r°¯l'àÑE<>‹!”!%ó9J*\rrSÄUT¥e#}´J™ü*¯ƒÆd*VÍil(nñëÕòı±ÛTÒIdŞu'c(€ÜoF“±¤Øe3™Nb¦ êp2NšS¡ Ó³:LZùú¶&Ø\\bä\\uÄZuJ¶Í+´–Ï‰BHd±Nlæ#ŒÇd2Ş¯R\n)èÍ&ã<:³‘\\%7%ÓaSpl|0Ñ~ (ª7\rm8î7(ä9\rã’@\"7NÂ9´£ ŞÙ4Ãxè‚6ã„xæ;Á#\"~¸¿…Š–2Ñ°W,ê\nï¤NºlêEË­¥Rv9Äj\nV¤‘:ÎŸ”h\\p³¾O*ÚX¨åsœò')Š–irÛ*»&ÁVÌ3J;îl1åBÊû+lÂĞø>ìj”\\ÊzÇ1,’ş\$q1büJ±{Í7!S‚.ƒjí6¢Rî±¾	)Œ¼‘i](Ë(Uì\"+EÁºq¹M?¡lÁj¤\$ºWA(Èˆ•\nUCËd4àPH…á gZ†)\rR‘•kZ–‘JJÌ”É\n/hAP¤u\$hRÔ12ÚÉ2e’ÈPë‰°Q1 P\$Bhš\nb˜5\rAxÚ6…âØÃwŒ\"êB†DÅµ1!#!V'\0Ú:p¸x0§ğä2ƒ¨å8d0!à^0‡É‚ˆcxÜ3\r#>2âX¤v=qÜß¸M~GÀ£vRÒß¹eú2\rØÜ98ÔxƒN±MÎCè6Ló@0àá\0Ş3ÃcÖ2Ç«”X¶Î63ò¥ÑnµI’	X\nƒ{P6á£È@:æã¨Æ1¶C˜Ì:\0Ø7ŒïXæ6ƒ–Ì0ŒãK’Ô×óÖ:·a@æ°©5¬Q‘¦¸¾UÂú¶•©\0¨Ñ@\r˜Í–`XÎ# Û§[ÀÇ\r#\$`m3¡Ğ:ƒ€æáxïİ…ÃEÒĞHÎŒ£p_	eÃ¦sãA÷İsÙ*Å³Ù°Æ‰*å4b’C\"È¡l”jôŒW¯Z½ÆÛTµ 	°{v950ô@9Tù à4àñX]pevÉÚ;gpîã¾ta¹<äğŞ+Äf¯œ1 ^˜(I\r¡À×†×Š“#ƒÆô7ªsj¿ƒk4¡¥ fÉpt'âäº–S*E!£Y\"Å€\\\"åöšº9rÁ Ò†Æò˜Ğ æ¹¸†#J3›PyS†ÌüĞÃkm­½¸·6ê\"Y½6‘‚<ıƒá¤0†ÆvHR7}£‘T×ŠcÔ#±ÄÈ#tt@p\0 •Z!¡ƒ#¢¤ˆ”bˆÄxH% T’2 dGsÆĞÔ£Xk€eTèi¡3~…P¼mnaŞQõğP9Q¯¹LHØêDTúÚ\$rU°DF“)à\0sC­±’ C{\nÃpppÔ9¡ôCğc\r3»0A£¥a…€5B“è²)… -¤|¸FUB\"bJŠ‚&>ÅF¥rZƒDª¹¸ñH	I2d)É”¡döÑ‡/ÈĞ˜\"hM™Ëgª`iRÑšÚIáï²`Hy3à€2:™PA,&7ÆÍƒ‡êl¸fAµĞ;øı&:mÍF9N‡M\0#°ĞH¥ö€O\naP‹i^‰¤b¡04T˜¸¥R^Ùé!Ôˆ’2J‘%C%5YCÏSÒ©EªO¦z¢ä[#\"jıÖÂİYg P	@ÎÒ9¶\r»swÀ‚\0&:˜Q	€2£[\00T\n7*pÓĞÛ\$¦4Î”#H‚–3Š\$bÀ£HhXø±q)èëˆui”ñ\$ò{§¥ Z‘\$Q¶œ™Û%æ‹c	K–ôˆ'·ÎK¤`Ù'éSI`èƒ`+§a¤1†¶”Ã\0v´¾N/èJC3f…„€#JüÀ¼Ød¡T*`Zk§¤§²Õ’v®µíËèp-\\[×z\0ªÒ1¸¥µkWlKŒA6ïŞC,FÅk«KÍ+%\$rÕŒ9ØO%nUH·\0‹*\"2ˆ±åÃ0êåÛ””+yü—07Ø0Ú‚PŠ\rXÑß9âBM¤»I3ö:¦GªQËíÉXd¨¹{ö‘O…ıNáL2šø(ˆ1`>¹«)û\\CğİøªéŠ·Ã]Ñ€(\n`í|ÙC/æ`Ä¶¹ö>B2";break;case"bg":$f="%ÌÂ˜) h-Z(6Š ¿„´Q\rëA| ‡´P\rÃAtĞX4Pí”‚)	ŒEVŠL¹h.ÅĞdä™u\r4’eÜ/“-è¨šÖO!AH#8´Æ:œÊ¥4©l¾cZˆ§2Í ¤«.Ú(¦Š\n§Y†ØÚ(˜ŠË\$…É\$1`(`1ÆƒQ°Üp9ƒ(g+8]*¸ŒOqšJÔ_Ğ\r¼ú¾ Gi‘ÙTÆh£ê»~McN\\4PÑÊò‚´›[õ1¼œUkIN¬që–ÖŸĞèå‘º6Á}rZ×´)İ\"QÚr#Y]7Oã¬¸2]õf,¤éµ©–¼—“D5(7£'ê†Æ1|F†Ã'7ÕêQşßLsâ*nËø÷¿Ès¸“¶æ0Ê,¬Ë{ Ä«(œ—H4Ê´ìÁ\0\n£pÖ7\rã¸Ü£ä7I˜ˆ0ƒÄ0c(@2\rã(æD¢:„Q€æ;Å\"¼š¸ë>Pš!\$Âp9r·»Åë‚¸îó0³2Pb&Ù©ì;BÒ«Cš¼°2i‚zê¤¨RF´-Ë\"Ø…-ÊK´A·ªñO©Å‚J<¯ä–\$iØƒ§,«²ßšJãµ)š(fl Äšã§hQÌ´-Ârã:Hz-¾;RÆµ3\\â¶*L4ƒõ=?T¿ÕawZ<¨Ü¡?‘¢B©¥¤S2tìÑ@í³>¦–JÂœ£S¨¢Ê£\"0ÓÍ+(lÛi{Jƒ>È5œ!hHİAªQ-Dp£YÊ:à·4I¹úÑŒ4ÙK·­_~QpM\0£JsªäÁ5«²l­šßŞf‚™`Oe8th&¤æ6Á P·‹dŠaf.…ªy”¶1¡‡7˜ŒÛ*n«ì“ÒjØ@6£œt*Ø|9£ ê9Dc“#ÈxŒ!òg hBŞ7ÃHÏ£Œº~£2„LF­ÅCHç\r‘–uDƒvÑµFûft2 Ê7cN¯3053Öµ? PØ:U–aRÒ«5š	z¯7Šà²CpTb8ùq?Jâš|Œ'nÆH‹Á*ˆ(‰;¦¾\nOVê#×0úÉesq1¨Â ûññh­[Jƒ8Â¼!p—ó‰äÂ‹t	÷F³ôÕ7RÃ£?[\0Bse‡bö¾·on÷6B=Ş§®/æøhg\\¯BíG³ÒÖJÂX†tèŠ&ì&b Ñ¥\rq¸ÌÛëbà€ †@ÚØ‘*Lmì4†DJ\0 \r\r3ĞD tÌğ^á\0.0\"”PÁ{wèÑ·Fôx\"Ğ±@&¼Ô›êt?Â=2ò:P•aM`íæ¤“BíI+åA…-¼åW”ÓŒ\$¤ª»²€¯İ‰MïÉ ó¿	P.‚†	AH- ÔƒĞ€;Â(H‘(.„ğ¦7FìŞ!|1hNYˆ•!»`*\nyî2”¿\r f§@“UVsÒyŒTæˆŠÆxæO©7j]ˆCÒ¤¼ÉÁ1jÜàšs¸F³òK¥\n?”RşCB2!5p@ÃHl\r€€1# à‰_ør\r¡•mÌİƒ’;a0ÌeØl\rá±KpÒ@ ›É³Ì0@Ú\$\rĞ¸0†ÆøAÎ	Í8e‰ãèaÔa#©`ç¥·t±dË”RÄ™1; „ëb3µ0/HvA[%.ÓH‰ñ3jÁº8KH6ƒx È4‡irC<Ä£Hı¶dpÑÔåšAŞb¢âù°zŠ™-©UT•	‰8#î­›ÉSXŸÒ%FTš24ƒ3\n#›u\$8T€’ r[AÜ4Ç6`8gƒñT°ÆYèe¥Å˜*4ÂKù-Šæôµ‘ˆ„4Dq\"ŒL½Ö²zm’¢ƒQ20çHBĞKÑºO	(É=RŞè¢y46\$8œÒœ˜¤PĞ5¬\\Ït¡!©Ş2'ÒGNÕé\\ÒE9IoÌä4ß^[!ñÒ3I\$w¡ı|6F ğ°uÛ1wJT[ÀHßd1ÎQå¼šT&bÓ«?Æ¬X>Äœd©ÃÔ'VÍ”÷;ÃÍtE1ÒS×U\\ÈBÉyUùêÙ\"Ÿ:üˆgŞØ[Bâ›m1w,è¸İS'mÉ!-‡9›Në­lÎâG)ª^òH‹vFç™å\$r<ï]ËDN\0S\n!0–äÒUÉ¼*P±*^y9'rEy:ë¡+ˆrGj}\\Ô\"ç–ªVPW™ÔŞØ€¨^BQ+ÃÓOo)×Z	‡cÂl™Õ’Lk6¥öGâ£ë[£cÌY±¥¸,T¦eŒ¸\n~V^˜û%È{pCŠ6]P4ü!¸@Ø\nËZ]#ìLï-\$qÜr§¹'…Ú»hp9MÆ7±3–©)\r¦ø8\0ª0-º|&Ä	šàR®ÿ,”T›ˆÕ>%¿Æ×/­­7!ìœ<Éš~šI¬LtL=cz.¢vİšhÌRŒü9ò|ğŞjsÈWÆêJ)‡TåÖ*c-‚ùcÙÛTÃ\n\0+SŸsÈ~²N)¤õ‰;‚P	ö©Úæ„Ü§	R½7z~“Î¯Jz—»ÉVC¤ó‘Döì#ˆ\rJï-t‚\\Š·×F¦æôï“\n´®ÕŞÄxV¾š>‚Ñoên'±Ÿm“ÖMã˜µ‚ŒBDİú¯ñ¶u&]ëÅŠ³M×®©v×¦Ÿ_ŞÅŞI¹¥ËØÌ\rR&Ş°ÅæéûªGP";break;case"bn":$f="%ÌÂ˜)À¦UÁ×Ğt<d ƒ¡ ê¨sN‹ƒ¨b\nd¬a\n® êè²6­ƒ«#k˜:jKMÅñµD)À¥RA”Ò%4}O&S+&Êe<JÆĞ°yª#‹FÊj4I„©¡jhjšVë©Á\0”æB›Î`õ›ULŸªÏcqØ½2•`—©”—ÜşS4™C- ¡dOTSÑTôÕLZ(§„©èJyBH§WÎ¢Jh¢šj¦_ÜèØ\rmy—ioCùÒZ†²£N±ôür,ƒ«N®•%Dnà§®ĞµUüõ8O2ôín©Å­r`è(:¾£NS7]|ô†‡µĞÓ8Ø8:>¾ÀĞn<LŞuCéOè§½øßg‹~S+ã~ßj<Ñ.®ê¥¾êyL’/MÄà0NBğS:›lüè9Fù'Ğ1PéBò¼Â¥4/¾jrìò¥.›½¯.jç³åò6Ô«mƒTëÅâdÇ\nÜ7Â-ªè D-êI£lëjá'Êú@Ep‹­\0¾Ò3mÃPäƒÂ´0 éaL—?	‹€2ğ4Ì™­oKa3ÉÒPÿÑ	|2jpáLJÙ`@´}0A/Ä2ƒ®\r,S=ó¥­²jéq\$¨iá&ê ñÔé&£1\\NÅ,O+§Óc …ÑmİFóJôz7VHp{~®³í;º³#sÍ0õÓëÿPî-¶0Jò6ÚÇÔSMo\"vé ísñ§Kİ6¸’Õ|SSÕÙxé?\rûh¸SÃÇSÃÍt¦«´M.üÓ.úòJ§NÍ¦¡Á\n<uE7½y_BHí®ÕÚ‹	pã–‰¨n}éb‘.Ååeà¯ê¶W6T¬‹QğóğP§Q±/bÇö{ñQ?Å;(-Ù¸í?«ì5\\®0®Um¤OÆd£&i:] N{Ÿ­«|ËÂ%Êt–_ÊÙu¡@PHÁ iª†-k¹‰Ô§SUPL eÏ«tEÜ èË—oxî…õP8JÛS’Õtâ\$	Ğš&‡B˜¦pÚcW5¶ªQZm&î¼ï)mG'ÛeqÛm=ü™‡ƒ\nÌElS)zn=S<F& JÜâ­Ì7éãPät½<HÏ«7Ö]?KóQŞwË(çWùÌ?» ù²XÂWÕ“äæ}CmÆ^óç[Pš€Voím+'ÇcxG>ãÅEÚÑªãNã`è93Xfì]ÈAnh«°ı“ÒMTYacÅ9§æBAÙq›b%½@ ²ºÀ™pFÇ„õ/å@)HÛ\"dŠQC9¥–õ‘Z…•Ÿ6õôg×ÑñÊ–«Ç‘	Šì(hÅiù,\"Ô³à	^\$å\rHÂ DH<†Jõ•šrd\r¡¤7PäÍò|>‹-Šdª^OÑ`å5=>_\nİ( \rÈ2†`zƒ@tÀ9ƒ ^Ã¼yÁ†)EH¬ƒxrà¼2†à^xn!Ğ4È^AS(nÕt§ç˜“egëéH¹¥O`D?g%uõ–*‹ZÉa¤mÑC’V·¢q2…q\"+ø„)™r´”9¶rPérÒù¿4Ÿ‹Éïb„lË•ÙT4¬=\"ŞWÌibƒ	ÃåQ+èº*i~äÊªì±R;s€#Lk±¾8Ç8ëãÈwqö*‡) ¤\$†¡à:HPç#d0\"xL½ÂóÊ‚ËŒŠ\"K¾JWYAï'¥õ­ÔJÙí//½íÅÈy-¢Œ¦ÙE«ÎÜ]y€æ˜¸Ì÷ìNÈÙÏ{KÆs ò² kºˆÒâÑèoA‘*¦U‚¶ù¶·OÂ.’M‰ÛQø™N<?l)Z“‡ÑJÅ2¶GÆ±´oB€H\nZ—ÇÊö*½\n¥‡t`R¥¢—fõ9±Ê¸ƒaù³]+é9¯¤ŞXÔë@*Y¥0€Dº_©È¦ c.T©‘V4’©E™Tq*R–‰«]¬åi`4K³3—TUî5&‡proĞe–¤×Lâ+©­(EY)ßÂéDu<¾ªj”©Vr2b\"1\0†ÂF=n¿2®›h½FufmÌÌ*€VÅ“¸(.ÇË\"^ŠÁë™/–S“ÆğPØ<Ü°Â™iR4d÷–´Ü£däªh3lÌÙ{Ö6#ÂZcÒÙø8E%ñt^^oL»Qgñÿ«ºd\"ŒS¤mÊA{QPàüD¥HSÕËë…\nÍlKZ\"º›}“©y»*9Õœ*Q0T?ZH•-µ/\0P	áL*µVØíú´ø²§Ä\"ö\nú¯W‚.x\0ÊÓ`O¸¼zSVU0´Æ\"REƒq\$Æ	É¤c¿è`0T¬n¦SËØÅ(}g…0pácp@ÂˆL¼-\0‡CS:›Ê‘£Öö¸LŠùN‚EzEÜ*—*s#eu…Úâ¥a,V„˜y^P®cTÍ”IÂµ¬ÊfdÕj‰]F×¾&3u—áùÂ_ZœHîS¢6F1hX­XÓJÌ¿:ÅšÙ½E­µ3G\"Í%éäkT’®¾•úºüM‚rĞô’ÛÖ{¼3­M	•9W‹êçêİƒ¬	Õª¨í¾­Ã2â“6EL]:!¿°Ø\néD·½Y5\r,å‰AµG\n¡P#ĞpùLûaQ«é)SEL˜´ÕO“§#lZ½^ÁFÊí&·¬Tcô¹y‰u7_Äİ_°Ú-âÍ£Œq®9¤Û ´ÜJí=Ï°ÉÖÁÖYôş¹|PÛŞ™µ\$62öVÚ ZÒQ,3ÌºPCLnRù…\"ÛLÃâ•©HÁ¨âmJşë¨¿xmãîWe<_r¼hæ0Ö-N×Ğ™^qb‘Å¥7Œ_êI©eªâ*€tåyP?ÀMTÈP[ù~b´îƒï>X„ıV¤ì»Mné¹C¦ìó•@§³Êx»Ù©\r%¨0G1Ğå^(§UWÏ`¹\ná'ZSØs>rzyÜB¦«íÊ'¢7ŒÈ;\\Ù)ÅÙ,¿r,äÈ5G+Ë+ÕÀõï™ªVª ";break;case"bs":$f="%ÌÂ˜(¦l0›FQÂt7¦¸a¸ÓNg)°Ş.Œ&£±•ˆ‡0ÃMç£±¼Ù7Jd¦ÃKi˜Ãañœ20%9¤IÜH×)7Cóœ@ÔiCˆÈf4†ãÈ*ˆ šA\"PCIœêr‹ÁG‘„ôn7‚ç+,àÂlŒ§¡ĞÂb˜d“Ñ¶.e‹Š¦Ó)Óz¾Œ¦CyÛ\n,›Î¢A†J ¸-†“±¤Øe3™NwÓ|dá±\r]øÅ§Ì3c®XÕİ£w²1§@a¦ç¸Öy2Gào7ÜXÎãæ³\$™eàiMÆpVÅtb¨M ¢UìÒkî{C§¬ªn5Üæá”ä9.j¿¹c(Õ4Š:\nXä:4N@æ;®c\"@&¥ÃHÚ\rošš4¬nâ\rã#ä²Ê8@ @H‚Œ™;Í˜§*Ì\0ß¨ƒ ë\r¸Ã²è…±€P¨‰©«Êì´.\"k\$b—Ã#Œ£{:Gòsäºh²l5¸Ïª–Ò±L‘ˆH´ãKDl:âÈ\"bVœ(àP¡*²ÒÚ5'-ÔÏIÂs*”ÅˆKIèĞa\n5/ÔE	COàR) PH…Á gL†)æÆ­£<œ14ÍhÎ2:‚ææ¤rzÚ‹rp‚5Œh¼œÂ/ïóÖ9Œ# \$	Ğš&‡B˜§IBÃhÚcÍœ<‹¬õ\\®‘“`ŠJ\0@6£P€x0¨ó%-F0¿ãòã|[÷†7Ã2Êæ]—tVÕ§Ú†Ú/í=÷OêbÛ¡–ÒçŒ£Â\$7cMè9¤cèğ\r’£0Í\\Ì”H3É¢’Ü¿É(ä	õDù!\ríhÚ„(Î :ŒcT9ŒÃ¨Ø°\rã:p9…‹èå˜Œ5û~Ñ,0Ü:¢A@æ¤ª62½)ÌK=²É\0¨Î¿\rXÍ…£IÀÎ#&”ÿh#&4»¸-¾Î2C0z\r è8aĞ^ûè]^ìã\\¹Œá{²‰‹ëzá}Ä¡ûówB°ÂôĞ\rUl#¸Ö„h3Ó”±jUèÊ£àPšä\"X(á	Bƒ”M†K%xÑ¸î{®ï¼ï{èï¿ìÉÃıÁ\\/†áø\\\"HÚ84ì`Ü:rx¦4D­e¶0¢, Yz“ëÂëš†JYèê“Ä2–2OHÖÍÚh'4…ëCBC‹?ÜÓ3³\0hó_|¦MsgZ‚Ù«7g,ì3èˆA}Ä0˜À@İ¹ˆ>¥İŠ’öJƒàO¦‡ÇºüßªM\"Ğd(€¡\n*\0šJŠj!\$y†â“\0[Ş4f”Óš”Lƒƒ¢ü5eÁr<Ì™ 	Á”Ë\$Ã¼‰Y-7		ÿ1ãh¹ˆ#¯fÇş\"NƒLB!Í	¡P@Í˜cƒ&3·UC#t\$h2Å¨¸åÅñŞ8Á)… Œ‡(.	Ì¦³&ˆ1p% ‚-Å<d™yé1p†2ğÖÄYxl\"Ê)’¢XK‰€iƒ%,—˜ @†	¢7§yC0˜JHyc‘¶ ” éCr&6QœÉêj€f@m²¸5(Ãt°j3ºóS'âá=ç(ğ¦´9’H`¶–2A1O,oÎœRÂ—åâŒ!ˆú›\$ª÷-ªÕz glDÏ©ŸEŒlÍ«øƒò½\n‘±…0¢\$á¦Ÿa¤”„`©\rÈJ&CQAñIÉ¦şƒ“&7%ø;\"§:;\0&4¬ÏRèŞaL9\n1\\)ÒÄT¶ˆÁrâ†’ II‘Û“£‹5!ÌÍÔ²è«ä-PP'¥\$Ê˜«İHCJ°¹óŞqÁü;“ù?ÓN	€u\$-µ»ã` \n¡P#ĞpÁ›TÄ<u;yHFI,^\rÀº¨;u\0fåİŠ©ê%Û§ûddIpËm÷£Š´Ì /ªä6SÊaIà\rî¼‡§ŞwÙ@dŸÇ®·czÒ¹ôG¥íü›kNLÙ•ŸhüÉÖÄjI² Oˆl5óÓ:Kòq¹Ş–AÒ•*qk’³õ=€ †”A’Lè¿E³aL2a†õDê®9	.!ˆTÓ~a	hz1Wå9.2Ú“’%!ï„Í›cËÒ¤IÁHÉ©ƒWª¹ÄKÀ";break;case"ca":$f="%ÌÂ˜(’m8Îg3IˆØeL†£©¸èa9¦Á˜Òt<NBàQ0Â 6šL’sk\r@x4›dç	´Ês“™#qØü†2ÃTœÄ¡\0”æB’c‘éˆ@n7Æ¦3¡”Òx’CˆÈf4†ãÈ(‹T—PfS9Ôä?±ğQ¼äi3šMÆ`(Q4D‰9ŒÂpEÎ¦Ã\r\$É0ÁÖ³•Xñ~À`°‚6#+yªed…“y×a;D*…Üìi‡™æøš‰Ôá+ªâp4(¼8Ë\$\"Mò<Àƒk¶å£Xø¼XÄ“à¯YNTïÃ^yÅ=EèÎ\n)í®ój¼o™Š§M„|õ‘*›u¹º4r9]¸é†Ö¡íš : ²9@ƒƒü9ë°È’\nlê¡`ê«Ø6=É:*œ¢z„2\n«&4ìšŠ9©*Zz§\rI<H4ªŒ²H¿£*‚ˆã¢Á®Ìˆ†‰;I¸!/HÀÒÀğÈˆã+Ğ2‹»\"*\r#„&¡Ä!<&:ÉK3˜»3j‡/sîqLªÿ;CË\"\$ÃHÆ4¤ìb›¡†fğOƒLüÖ&£ÜíŒÃLŒ©³œŒ\0Ä<ª M!IR’0ó#*\0PH…á gP†3bDÃI8ã0\r‹Xì7£ƒ`Ø7Œ`P9'KÚJa•©M Œs¼ı@!öQ]#ˆ\$Bhš\nb˜2xÚ6…âØÃmŒ\"íˆ2ØÑJs\" ª2Q	ÀàÂ£Ì¨è·>Ô2\"ü#ÈxŒ!òIu]“hÜ-¬­ï|Ån3ì£8 Âß`«²4½á—6sD‘2Å‰,9 £dª420ˆ\rã0ÍPğ‚D×Œ“#ˆ1Å48Æ‹B Ş¨¦Cpó²c­ƒ>ÌXAY¯,œ1*çcÎ0¯X2‹H¥#t42…˜Rà&ù€İC¦`ü\\ºH*0’„3aĞ›¼#&¢‘CÒ#7SÊŒÁèD4ƒ à9‡Ax^;ğr%·¤k°Î»A~Z½½‘H^Ü{øï`wÒJ“­h]Y´êà4Oæ»/h\r;O[CçŒh&¿Êª3!pmqÑtƒ,nÃFñ½o›÷Ápƒ¿\r·/I]Åqƒw»X¿¤]ˆ<+FÑÎ\n›ƒ@ßH™ÀÂ5¢ı9g4BI!£•Z ›½‹kš}†P¡\r“D¸Üóla ˆf±Á\0w6p1ğÚc¾\"!™Û V~BÚ\n±\rí‘ğĞnˆ8&ÆpÊ«“Ø_ÊC1Uê¹ó0`ÌÑ…0ïı&,±ÊP	A r.NŠ((À¤¡£BMóïf-…µ¾SXkl‚Pø¡#BĞ!|Vaİß>øJv“¼(`ÁØ—!È\0Éé(Nq7Ò}ŸoKH%»¥\"Ìcƒä¤3·Å\$D#‰œ(Lß³PŞú°C\naH#F8ÊJp fÁÉÔ£ ÜkÈÁ)eØ6˜´”„9›AjÁõ² L©(%ÄÁ3CB` NŒÊ¨â.ŠÉ I aäÒÄU\"€ÓØn|†ìWäUéùLÍµÄBìÕ™ÿ|1Y\"H\r™+ˆ\0€(ğ¦\"~>ÄÈ…’pÎéLœ‘\nNø:œ¨k6™Q/RÑîdòN]ìÈ€Î\"–\0[ 3Ÿ—‚^˜cìm•™uAˆ¼\0¦Ba<!à‚L\0Œ!â†R\$Æd¦R{F¤‘	Bç1}OõFKiA(™š¬C¨–ú]IŒÙÓ\$D^šzZ¢E8%Œ4‘ã½?\"À¸…:O8ê%F?>MOPèÆB1³\" €!¥PØ\næ‚vuUn}«7nSƒmQNÄ`«2H¢Šç™5§P¨h8aìÀÇ†àÏKÎ‰.Ôòªôh•MıM©çÁ Š¦¥ì1¡&òæÁ9æZÖ*w\\De=£ìêˆyZmdíB`:Ìeš2`)ßÔ†ĞëC§Á¹Y†)Ó=­XNüŠÔaˆÈa˜è²Ÿ¢JèUi•&àÈ„Ë‘_NøP1Šè•¶K!ª¼š(HìÅÓÅÊ¤lˆR×€¶Xtv·Ù›¾MŠÍ]Pñ“f\rS®9¶vš³³É*H;?\\b2\0µñ@è";break;case"cs":$f="%ÌÂ˜(œe8Ì†*dÒl7Á¢q„Ğra¨NCyÔÄo9DÓ	àÒmŒ›\rÌ5h‚v7›²µ€ìe6Mfóœlçœ¢TLJs!HŠt	PÊe“ON´Y€0Œ†cA¨Øn8‚‰ç‘„ìd:ÁVHÉèÉ+TÚØªù…¾X\nb¯c7eH€èa1M†³Ìˆ«d³N€¢´AŠ¾Å^/Jà‚{ÂH òˆÔLßlPÌDÜ®Ze2bçclèu:Doø×\rÈbÊ»ŒP€Ã.7šì¬Dn¯[6j1F¤»7ã÷»ó¶ò761T7r©¬Ù{ŒÄE3i„õ­¼Ç“^0òb²âàç©¦p@c4{Ì2\"&·\0¶¢cr…!*Š\r(æˆ\$B€ä%ƒk€:ºCPè‰¨«z†=	ØÜ1µc(Ö(êR˜99*‹^ªF!–Acşµğ“~â()ŠL££H=c(!\r) äÓ<iaŠRB8Ê7±èä4ÈB«¤ÖBã`æ5˜kèè<È\"µ-ˆäçÊíjp	R \nhÒ4;åæŞr¨95úú8NS¢2í&k¸œÕ¼(Kp5ÆA(ÈC,ÑÔ…%/Ò”}#.`PÂ7\ràT°\\•8b÷NCĞ5Œ‘b4ÏÊ†Œ3(&\$ìˆ‚5È/pà9½¹ˆGÍ‚@t&‰¡Ğ¦)C \\6…ÂØåkBí…b:ïğ£„hê9¥\0x0¨áğì²È(İ2‡xÂ\$W=Ò'0ğÌ4Œã¬\rŞ7œH9¹(-_(a}àjr>à&fNÔ”LĞ©mÁaø0¦2¾ƒÛ1bS8”³Ã0ÌœÀJPË>eëÉANÌŒâL¥‰ËµpÔB\"„wægôëB4Á`@=h9Büˆ¾\\6ßÒ£lŠØ6ÀNoœ9ØÛçî„Wè‰vA”8Î•¦\\xcc¥Ô¶§Qú°ÜØ0ºÓ.VçI®¾7çÎ›¡è¨vi¤%›^›·jçªêã¢D'æz>ÒÓ%ĞxÄÒNˆˆìà2ì¦‚ş%Œ&–ß¡0£srˆ#&í—ºUÏC(Ì„C@è:XaĞ^ş]\\õé\n@3…ãæŒƒz*:\r>p^Ô9\r\$-x^Aò(êeê`5eÃœïç&Ó\0åB\rƒ•ëNkµ†O<Ì VÂZåı£¥@OPCí4D±À ”búK#ì?k˜ß‘wlîÓ¼nùà<'ˆ‘Yx.xï%å•.Ÿ8nzk¤\$†ĞàL’ˆnElî®zBŠGiF\0<’çúCÈ‰=%!•òÂìM n.…q®PÄøWq«&*T’%~T€uV/Ø›«*p\0ÃO`Ò¢à„Ÿƒ‡rë•ú²€ÔJÅëVlÎù\nŒĞˆi‹\"è…† ÒH‹É{ˆlQ‹\nÒÆH34©†cãÒ]ig\0002 SÀ \n (øvãós\0 £‚”œˆHjQ…Ì\"2È­xeò=ğÆ@š@N`—Äµ@fˆCıˆq†6ÆõË£¬<Ni?! Ú\\Ìyˆâô:4©’Q›Ÿ<ä./ „ÜDÒˆzeçî@Âs[xk&`€!…0¤p rŠÜP“&‰âhâe¸5\"DƒÈlh‰œIÆyI1œ%K–Z“)ÀBgôI;â¶t… ì_™,İ	0` Ø”xjiĞ}·“®K2\")Ä%“™ë^+î/Ëä¿rÄ¤h.œ;Gô/'ÙÃ|k¤Ô›˜3ÂxS\n’ÿPØR¡a/ì9¨Pú\"‚R 5èuç/µúpÄk˜5.Ô5½\nÀÉV'	p^‚\0¦Ba#Å6cŠù’Ã©#1\$6†øàKB0T’¦ü“ Sb–*ƒK\"iå˜\$LNˆ¾QŠB|›ğæyCÑ\"¶E›ğÅcMõ]¡„œ‡©GdÓ…ˆ1ê1pYwÚMÁ3›“â}²rh¢tie´Š­@k!­®V†ŒÒÃU+dE!d`ºÛÏ’#n­¥\"6şÚ2\"æH‚0\r€¬ï«y\\A1%‡´ªºËäQø]¤L=DJb‘5kE‰rÙ–FÜú\\o4;Y%ÊB F â{ÏA_e}Ÿ¶Wá\\Kqá6¾²’ß(ü	m[Í¬\"8\09Wû%rğuÍ­²à„´äD”[”¬Ú4yƒq‘O2ŞÀô_ÏÈ\n¦ ;—y1A¤/Éu·³âŞÒúB¬0…(Ä9ŒË.5rD0œD`·NÌ˜¨…ÿ&dáZ\ny<tÂÉ(ÂÖO	‘v (!“‡ÂMŸ\n5‰o¨÷B¬CZ™2ÌáÑœå›ÃZ	ì†\0Èƒq=<Wà	t0V*¶¥e3©‰\\'àC¤Q’;3\nt7Ÿ\0À";break;case"da":$f="%ÌÂ˜(–u7Œ¢I¬×:œ\r†ó	’f4›À¢i„Ös4›N¦ÑÒ2lŠ\"ñ“™Ñ†¸9Œ¦Ãœ,Êr	Nd(Ù2e7±óL¶o7†CŒ±±\0(`1ÆƒQ°Üp9gC¬9ÁGCy´o9Læ“q„Ø\n\$›Œô	)„Å36Mãe#)’Õ7¸Œ‡6˜é¹ĞNXZQÊ6D®›L7+Ìâdt“ÍÚD˜Ø 0\\ÈA„ÂÎ—kÅ6G2Ù¶Cyœ@f´0˜aÊıs´Ü[1Ö‚İèØZ7bmÀï8r™ÀåµGS8(ªn5›çzß¯47c×No2œÄ-Î\"pÜˆÓ™ŞĞ2#nÓ¸Ê\0Øµ%ª‚0 hÂòÁ&i¨ä…'#šzŸ¨(Ä!BrFèOKB7¸­²L2B˜è™.C+²¶0±œ2ƒ´b5¹Ë,h´».Û€:#ƒ\0¾7éºØîÀNÚ;\rÈ0Ş‹?àP˜ã-‘@ ›²HPÜÑ\"k\\š'-b…A(ÈSÊÌÓDÔ‚C…\r@PHá hŒR—»£@ì´k+6š:Ë\0&\$#K\$2c\$á\nÌ(ØîÃ¨\$	Ğš&‡B˜¦zH-˜e-SU”¢èJ”Ô»NõÌ¯’E‡ƒ\nt2ã¬&ĞAiˆÂ<‡xÂ#uÍv!ãr03×Ã-‹cÂ®<*Ç¨«²ój­U´…§N*qpŒ£ÂT7\$l9F(ÑÙBÈŞ®Œ-0Ş3Ôš—¦ğ,C)¶Ã¬P*\rñ\$²<„Cì1Œoˆæ3¬üº¶abJ9aÎ0­–´Ú6­ƒªTaJ7€4\n6\rƒÊ”:#b ĞÉ£í½º:¤@ Œ™9bÃÔ4¢ÉÅr\r	Ì„CC08aĞ^ú¨\\ŠçËÒĞ3…ê\0^2Y­Óf…á}°-©2åiÙàçtËJq\r‰zîÑ¡QĞ8ÏÊ¨c£·hZ5Éã+ÿnXM%»FpA£é#.—¦éú§ªú¾z¶kC–¹¯\\·>á²×bHÚ‰6*T9mP@è,ˆ¶mq¾MÂpĞ„:^Ó\"Í„9K=r6)áÛ‚ûÀäúkt	¡cêRñŒöbÍ´Mf„ºO4!~tèLğg^‚¸fˆbM®;ñƒBKîc m÷\\Kr.&%Çfˆ„Qt.ˆ0Ó‘ ‰i/3p\0k€ÄXš€PNK3ÎøS\"Öü¾Öa©{É’¢C¬`1y.iç¢|¡ e‡Œ¾‘°ªÃÈlH .œtÎÈya¹#— ÌŠ<74ı°Õ¬ıHYlˆıÃü“8w\r¤1¿f@fw~ä,1†p¾áüA7æˆ!…0¤id!å¼›˜r\ng|æ¸â@H‰!“5f|30è’Ğ o_ÁÌ5¿æğhÅÁ¶où“¢6Hy^f¢0Ş}d÷(¦ô2‡ê|Mf:ä‘5’q\nc\"g¹úÊ³ö\\Ü\$†‚¡<)…EfjÜl’&òRK9\$ˆûJ@m4œÔ2™J,)\n\0‚â`L éA\r(UÃ¬Õ¯›Í†@=‚DH™&Ï,²€¦B`-AÈ\0\0Œ‚%!­E<é,¦Â_Ò\"†Ò˜‰ÃÖF„©˜šã\nDH†„£ÑZB—%w‰T¦ÔÆùULD=˜&ÄÏIÉÀp¥!¦•¹ÑXla­†³ôª]’6Ñ‚q»£@h d Á¹ òôLıB4ÓŒ*…@Œ#Èeç'¤zJ™ÌX¦)N4ÃZ:©q½1…‚²PGŸYÈ1“)\$=é«æ]K¼ÚI£CT\\‹q¨\"À(¾‡¾ÏÀQ¾/è…\$ÊÄŠj“§ÕŞTš–jk­D“æ	ºŠemhÙ«0.>Ï‰ƒ%Jl™²d}—}0é¶°”ªÓmK¯-ÁœÃ„²&“B)†¥Â·:ôÿ&f¹¯µ…CX[Â”òD5ò¿T‚@";break;case"de":$f="%ÌÂ˜(o1š\r†!”Ü ;áäC	ĞÊiŒ°£9”ç	…ÇMÂàQ4Âx4›L&Á”å:˜¢Â¤XÒg90ÖÌ4ù”@i9S™\nI5‹ËeLº„n4ÂN’A\0(`1ÆƒQ°Üp9Í&ã ‚Å>9ÔMáø(Øe—‰ç)½V\n%ÅÍÓâ¡„Äe6[ä`¢”Âr¿šbÆàQÆfa¯\$W‹Ôún9°Ô‡CÑ–Ig/Ğá¯* )jFQ`€ÉM9ß4xñèê 0šÎ‡Y]šr‡gÎxL»SáÚ¸Â­@w‹ÅBş‹°òx§(6ÊnÍBh:KÖC%ìñ-|i¸éîz9#A:œÎù¨W ª7/ãXÂ7=Ép@##kxä£©©¢*‡PÖæ@£’‚È³ŠL±„€Â9¿Cxä©°ŒRfÊ¡èk¦¤1CË†‡¨¢:³)J\0èß¨HøĞ‰\$‚ĞÂş±‰¨ê6Â‹(´èR[”74Ã£°!,lĞä	Ã+8èCX#Œ£xÛ-.ƒ+	Æ£’3,qâù=+^:DS8İ3²¼=ñè	ƒxÎ±SÜC ÓÖÆK#¬Ëh¨ô«(„<¢ÀM*Rè²\n5 R÷B°\\•8b°®+¿ŠhÄ›®SRöÆ0©ÂÛ\rÃ;îİ\r(”o¡ìênÒ\",`Õ-Sø\$Bhš\nb˜©¡p¶5[ƒP»a±mÃòı”’%(9„kótƒ\nˆ/A\0‚9>ƒÈ@Û'%àÆ5£«øÜã|’]·x–‰Mƒ8êà`‡t\r¬V£°Ö\0ìß´b7ÅMÆ-Œ!í^Ÿ£“ Å%ÎjE‡„ä¢\$‚dtô\rƒ¤®Ğ-.pŞ3ÕŠöÏ¥Ã²â ŒSØ†±‚Óo‹°	ò\\3\rã`Î6\ríˆA@ĞcpZ+%ÃZµ…ÔäLŸßY¥ØÌ'ñ‚Ê&¬q¢|7!BZ±¥C`\\éH‚š·¥£–¡©jš¶°±ëzî¾ÏlR–É³mCµİå7¸N÷è„îãvò’hš0É•p<tµ(ğ“X×C÷C@ Œ˜Šöé¤SÂ„Ñ_Û\rÚĞ¸0z\rà9‡Ax^;ùrÙ%ÁtD3…èo¢‰\"¶Ü„Aó‡ixÒÀsÆ78n°±UàÎ9Œƒ\ré¯Èê`\rÍmgÇp+ÜhÜsÌêWA&<aÈ¨dú¢Ñ¸OÉ÷?Gt]àewÏá<GŒò»Êv%æ¼÷¢Axe,´‘'°»ÂHm½ñ£¶Ò¿Ø>,È5‘²Àš–‘ù\r5©–®ƒ†‰R·(FÙtŸRÖ`ÏùÒBâñõ“\"tÂ€H\n\0´)‘èJfJëcÈí¦(ƒbXĞa>+\0‰=äÔtFt­EÓµäÿZ;¤b%	¤Ø¿£{¢¯µp¾àæGO0hDd¼ÁÀ@ÉY9ÒeF±”V¬Jq”ÌtæÄ è†i¤Š1NDR¯M ((€¤Ÿ” ˆdFÁµÃXİ½^æİ²†–.[ÔN“IùÊÊb Tœ	0&Dÿ†s\"ÍV<yÁ”„ÜÔ\"Õ\"HØ\"®…LœëW.Éc*â~’r½4aÁÖÀpèk_jè†¡UDbĞ¼CY:@„X’0¦‚0 \n¼ÓÕ{1ÑØgl)QüCPŒˆ—QMKü†Wö_‘ñQŸ±†\"’†ó0_q2ŒA¸=\$2XÇPCG@Ğ\$È—ô,BK£\$n4™£\\	ÔG\$\\‡92|ÈÚ°A™çĞÆ‚ÔP–JòƒnÌÓc*¹£~¤ÒxÚ©¹°'ÑU”@ Â˜T¦\\‚K	gQ[1<l&¥Ñ‡¦Aê‰>ää“ÖZÇZr'ê§ÊĞk%4QÅ1Ö3É»šFĞOl\$†'¾§–`¢*Ú#ı…@ h[©{§yÖ IN’\"¨r®3|8'æ@êa\"’9ì,†ÔS\0N‘ò\$R¨;ÚÂ|GLÔªk€‡)8ŒmªjiÅ@Î‰ÚóGf˜–ölÎàp\nlØ6°–¬WÜ³IëIäRÛ+Ò¢ˆáu\"\0@B F àÒ±ÄxAÑ\$SvÌÎZ»…i-1NowÍb“6go³İ%6•£Ç@¸èõx:eõX84Gñ &LaˆKtc(6\$A’æš¯0Æ\"ï'dñT+ÁfIBí)ÌFuÍ%8¼è9’Ho rá³G &ÄÍU±nY™0)Út—éP ·òÔ™Å4YTšF§Üü‘ÕÈB²\r×Ä&4<`H\\ä€T)ËÌVVÛ>™‚X0Àûxf2‘,!Œà[Ô~\0";break;case"el":$f="%ÌÂ˜)œ‘g-èVrõœ±g/Êøx‚\"ÎZ³ĞözŒg cLôK=Î[³ĞQeŒ…‡ŒDÙËøXº¤™Å¢JÖrÍœ¹“F§1†z#@ÑøºÖCÏf+‰œªY.˜S¢“D,ZµOˆ.DS™\nlÎœ/êò*ÌÊÕ	˜¯Dº+9YX˜®fÓa€Äd3\rFÃqÀæ•‰Ğck[œ)>®Hj¨!Üuq‚¨²é*?#BİWğe<“\$¯«]bè†^2‚³¥n´åõ“>–ã¡øz< ³’T•ÚM5'Q+“^rJÙU)q‹s+4,eÁrÎËÄ5˜ºÆ-¬¹ç©3J7’g?g+¹1œ]_CFx|÷-Uƒ±³¤tLê¢»îŒ´)9nƒ?O+øô¿ë¤‹;)û…©î’òŠ©I‹jŒ¶èãt–P#öşÁ0\nQ!ğs”ß'®\n|W+ÌÙ¦©êâI¦HsÙ¬H<?5ĞRPƒ9î»~É%¤3Ó™ÅÙG(-ó4C²OT\n£pÖ7\rã¸Ü£ä7I°ˆ0ƒÄ0c(@2\rã(æK¢:„Á9@æ;Ì\"ÎP#ŠK[ÉDrç())JNë¢O1~ô+LR0=ò8¥¾*€•Âªqt¡.é:M¬cšÎ´­izb­®m\nŒ»­‹ËòÉ:ê¥‰ ÄºšÉQè‘n§¢”´±Ir\"MUq‚Ñ™Ä¤ ˆE>FH	•>Ï!–dhŒ»ˆ“ØÓ·kAF¿v%ôÒPœÙ(Í£l©7*Õ™Ñ}–î¢Í*“)(WQ4àÚ.½¦• ÅÆ§Ú(Ì¦gŠbFDfvFá\n&N™Éå,§'ÎÈá(ÈCÈè29I“MÈ3XŸ³I`\\A j„pÀ±mt#tT~º¢ê„š©¼JÚºú4__97R@¤ºöc‡9ÍGpİAvóÅlÓ=&PH1Rg!ÑœMí{SJ Õùn¢åà^-¦*vô.°ë«¯¯§…ó¨‹a+…{Œ¬\0RÈ\r£¨ç9ƒ\nÈC(è:RØÃÍKÃòã|›r<˜†7Ã0Ò3ó/AÑT¡\0Ó-¬“Ò9ÌÃdÕÅÌàİÜ÷s{ÅŒ£ÆN7cOQS ÛcPAº˜ Ø:H1\$Ó¹1ï ö¦6»>äz¢„ê.m«!>ü:íİ¤\nªü8®İz\"Ÿ­ëõú\$¨ÆÊ´JÿJ1@[\n©Hœ‚–xÊ\n¯@íl× ÷Ä\\™)@±Âs.ÄƒÆÕ¢—c¤ÜZI)DŒFàıJ4¡º¸‡ú§!S~4ÄÀeyK´R¥ø¾6,J	TpÇŞ)#«\nx¬ƒæ2µò2RÈØ¬Vg” È|S‘ÙƒKyÀfL	6\n¡Í†´ŞëvaœÈ]š]‚å†È—A‘¡Ê†`zƒ@tÀ9ƒ ^Ã¼‰Á†7ÇÂ˜8/¡¸¦Ç~T”@úK&HÖëİ¹AñX˜£Œ…	ãùƒdb\n4Dˆ}È‚…”oÊ‡¹tR Â\"+ô.E‹zÿ\\PÉ‘eşw	Ø{àº<†÷cürCÈï\"ähnK ºHI)(ñ^;Éu\0¼95ÖıÌ‘\\«¡öY@|…º”'…QG­ÕIòB;äU£ÔH+'CÜŒ8ô(ÔşrÍš&<%—£’œÿPÊ=ê1â]\"£ì=SÚÑw¡)\nt¦(â8†Æ Ğšƒc“ pÒc\$MAÁ.Æ€äC+#!™“‡\$æÃna˜:ÓØÃ;³¥¡¤:€ASSS¸§\0€1¹Xî¤Àa\r0g,‚ D–	k¤ñk¡§éWˆ½aRä|ù*J0üê´ÂØ¦-éĞ§\"{İT¬£’° € ÁZW‘ª8‚¯ ªÅEÅ¹6táºmR¨×SÃx È4‡j^C=9³Iİ7»tàÓ•Z¨áŞœ›‚‘¥‰'”- ©szôOzè˜‚Æ“%ÔÕi¦psO5Ù%º¡qC€uO	é>&FÃ@iu:8yLª}'ª…ÇRÎ‘”ù¡<hÈ©‚X‚S\nAf1#¨L’Qí_¥Ì55ñ*àìºÂ”ºµ‘œ,«4ñ¶EIõ´rJ9â„m<¸•Rº OB¶*¢4¹®Òàvé)PµAK’’Ït«_‡µÚ³Òåy‹¾qîÓß[9,1-û’Õ0|‹Tnh9JÓáŒ¼N13´÷/)ááZ6ğƒ(×ÚüJ‚\rşP Â˜T½¢qUšlˆPñ³®De(`Ê…a!†×©5û?Š	Ó#lô—2DÅ0“ëDx•†#\$¤^å[ÙBDØÏ\\¶hR»ê\0×Ë~†Š°)…™<Š‰*X<O1DğäŸ#s«±-ó%A¾¥\$+‹8—±u\"2Ó«II.é_šíc¬õÉHÙ§3ÑD0’Ğ>½#ü˜ëF?°á\n£9'¨˜K\"ßJ1))%:ãC\\XÙÍØ)ôÂhQ6Ùv]8x¹2­ÄÇ¶|Ã9@{àÂÔ\r€¬1†Ë¤âZ”ŸJh‹æ™ò…54>˜)GN´¤QZ§(zH¶ªÃ6RNfÔ¢#•?2‘U@ÄQ¡Oª0-Ø2:øP5ÕˆÏ[SdÂfUËèEx7«£jÄP/NqĞ¡–(„¡Y‘˜yoíƒ:ŸV^vI¼7ŠœŸ?ALÍ^9\"Å‚ ¨¼¹Âô¯+¹/’°N\"‰9,B‰|Úc1‰Aï“¨ÜÙ'Mf­\\Kp¥È?nÑ7Ë…VŞ\nYÅ1ŸĞùyˆÁr-£ğùÜÄî{`6äˆ7WĞÄ’#f`Ä‰‹_ÉFî÷ÄâèFÎÒáEúCx¨FåL?\"]s›ª\"®™O.öÜÃy/F»ÒØç–\\+!%y/\0£ù#Q7‘ àÆÃ9óÒCùÉƒ³æÕp”<ïğàŸGØd`5‰Pf¿&ş)`Á=Òã Rwú%òPY#\\‘PB€";break;case"es":$f="%ÌÂ˜(œoNb¼æi1¢„äg‹BM‚±ŒĞi;ÅÀ¢,lèa6˜XkAµ†¡<M°ƒ\$N;ÂabS™\nFE9ÍQé İ2ÌNgC,Œ@\nFC1 Ôl7AL%ı\0é/‚LçS‘¼~\n7MÖ:8(Şr4™íFd‘J¦„x‰„ç#&›Ì†“1¦*rLç+Zí	¼oXË•.ËifS ‚{4ä¢gØÓ¹C¡‘cpÆt:İ\r'¨Ì*O{0ßdd}‰ÈÉŞE·ç!æ(o7-[ØNNn2Á\\öÔAj œ¤üH}CÉ2‚Šf5®Hl™\\ñœ¾S™9ãˆ§+/js1ò\ræ3OFF&5£ü‰¦¡~:5Løæ7¡®ÓZ8/Ã˜î·Œ‰ ·„3È·…\0ê ÃÃs[‹ó ¼¡îB'‰ü@›¨®+Z¤,ÚF'eĞÚ2²àPŒ2£ÍkŒ4-ã!Œ)¬DOPÒé\nLã¦2½Ã(è9elŒ*\r(jš°«K¢…Á¨Ô<9·²zHç-ï„ÒénD¯¥r0˜7®Cs¦Ş¸n;’9N…ŒŒ'£*s(²²»¤³£ò¦4`AG)ˆ(ò…-H…á gN†2;Á¿†g=:.‚& ÈÂ{|É1ÂcÒ¦1#KSL,Ç2%\0	@t&‰¡Ğ¦)C È£h^-Œ6ˆÂ.B´jØ½\r£ˆü¼…¹M@8Ğ¡\0x0§óQˆ:¯H³(6\ráà^0‡ÉÏtÎ#s\n±Ğ•í|Eˆ[%‚¤b\"0µé2FåØz„b\nLQ'ÈSÿ¤è(Ù+¾\nc:Ï¶Ñšôôc£\nF)Ç3¢Äqæ°¡õ4ô&¨óTµ/0D¾›VÈR\$Ûªb½RCk—¡eèPÓC+³\$µ¶à@a•)Œ‘Šƒ@Â7\rhXÍCëPÎ#&Pí¸‡¦®%Î\r`Ì„C@è:˜t…ã¿I;|x-ã8^ÉõHÂå9xDrNR×ß/¥ª\"£&{¬C³,4¸ˆPÆ¸@H êŠD£´‰Ô*CB0›|%-²ÊÈM\0ÿ\\Ínò2ï{îÿÀğ|/Ä­\\_ÇÜxñò¡Ò\$£‚%¼æŞJÌPÆ^ˆdx”ã¯2ŒX>RâlCN4¤íú‰HYAE,tÌ \"ãc……ô†PÔ«ıDd(8(V†uËYŒ>'Ú¨bPdšSZ€ñ’’êÌá’?…ÑöÄq˜Ñ’g*à'6¥áÁ#†!º¢° A…¾	°POI:+â…#RZH‰MTLt˜¢¢ƒÔ)Ú5FrÄRJ	!,½@€äÓSş\$fi7œP^B±vf¸1´h0~O¢@\$äŒ\$Œ¼	Ò?… ½R6„šBˆuö†5°C*;0å¬†>Ë€PT\rá­ƒ„0¦‚4Ä¼ô<@¬¡Cc#,Ó•è—Ü™ª&¤m³Æpê‰K\"\$â:˜3%£c)%ŞòbJP1\"¯v-¾÷øHp.\\â:t1%ŸJE§ˆ4™çÏ\$H™’•§Ä#Ğ\rL­µÅ:“’r#¬'41æ% ğÂdÀP	áL* g'á4`: €Å¶2k4’‹¢DU3rRJÈC³d‰ÎSclª@«q–HÕ&ÙšdÒBÌ.Fd\0S\n!2‚(TùÂ\"a*D&LiÛ}§İÈhÌ‹y#QßÈcÒˆğ\n¨fX–˜#a£\rB‹õ1ˆ„xÿeÒ’Á–l± ÍªŠ‘3µn®Åz¾kã	˜i\\6¸âa¢b1‰™Š¯Cˆú™Î\"ËĞŸ‘´`NW\\k–IŸ“aH¬ƒ/AT*`Z	’2•„Sˆ‰Xl•SQD.Ë äÆÊBd!Ä@‰\$­˜ä®5¥ñ«šœƒÊÉuFHÁÂÂ”Q-ŠSÎÃÕNTçœ\$lÉ[˜æg3STæ­ô˜Ãd¶¦mSD'yˆLëšNÁ½\$¶ 	|øHå‘“\$ B¥½X8ït‰ €fTIe¬@‚ÉÔÂ\nÌ-;&HëÑwKºrcåÿ1	˜yüĞšY¸/¤*›[RìÚG\r•r%B5Qêˆ";break;case"et":$f="%ÌÂ˜(Œa4›\r\"ğØe9›&!¤Úi7D|<@va­bÆQ¬\\\n&˜Mg9’2 3B!G3©Ôäu9ˆ§2	…™apóIĞêd“‹CˆÈf4†ãÈ(–aœÇL¦A®0d2›à£¤4ĞiÎF“<b&l&+\r\n¹BQ(Ô‰DÔÈaÍ'8Ó‚9á\rfu‚¸p¿NÑI9dŞu'hÑ¸ßµ¡&S<@@tÏNó¤hégœáŒPù9NIœ9á°;|)„@jß˜jC¦,@mš\"ûÙ³q†ßï¦|ÈÏŒîôFã=ZqFİÌ¶µ`ëº*›yã¹¸@e9­Rr!‡eX\rúlñÒÕ#ƒ“ü8+˜îµ/‚‚H:½ÌZhè,Ïò\$4Œ¬k¾Â§Cš|™7ã¨Äß©[Ö¾HÄ“‰Ã¨Ú1-iš¶ï5NÊ;:*êÂ‰-\"ã·#HÈKpÂ9B²B9\ra\0PŒ<B8Ê7¯èµ°\n¼0¸)x†ŒQğ)+iSQ\"KO<¸Æ\"ËDù# P˜7­¨#ÂBS†è;\näª°¬“ß+ÃÔ2A*¹¨ MQƒ¢Ğ<¢\0S<°\\”Øb	ã¢X2c@Ë«L\nÕ-`P 4#“\0*4‘špï2t²†Çâ@	¢ht)Š`R6…ÂØóe\"ìŠ‰º`É*ÌIÛï„àÂ‡Ã•N›=Ì`A!ÖCÈxŒ!òOm[‚Ş7Ëbl2Ü÷L2#ËéA¶hÕ¬µ=ãræ_ã•î2\rhÜ–]ğÕÇãd®2ÌÄ†\rã0Ì…#-«àÎH“œêƒc€¸ìøÚÆ!šc 9ŒÃ¨Ø¼ÎˆÀæ4ã–Z0ŒèCİ|ÑîÃÎ2…˜R“ÈÙ+€6g.Â4ÈËrœ\$â£4õ'#6\0œ#8@ ÚhÃáxl|ø[-ğÑoÁèD4ƒ à9‡Ax^;ïr)©ArÔ3…ğ¨^ı`T•Ş„A÷ûl7­ÔÀæcNR÷]÷I(ùä6A™ÂÚÒåÃ«\n…¥ŒHÊ“¥-ÎÙ12rî<Š¶m¬Îá¹n›¶ñ½oƒ¾ı²£<ÂÜ.\náHEn	#hà‡Ê£péÉ^ò«^7«C•#J*6øehÏ­1<µß|lÚ(+YZó>Ê>³S\\c÷èNn]rkÁÉ*•ÀÂkfÈÄ³VnÔkü(¡ Ó¿€æR¨ kx°=`ÒIpE(e½—’…C!ßrÉ26Vˆ`¼n†…š…NıJàP	B!D,ëÊJ'm,.æª_Óa4æ|8FiLz«'0¸ş®0ØÔ»·A†²Ô·ƒZ¢+kŒÆÀWî|	97ÁÍ3%ğ{{á\rÆA Wd¹gpP‹†vè¤\rsøa„œ:µT˜YYF)… ŒçYî#ˆôÃ:@ìZƒk¥tî°•ÆVKˆÓ\$dÄP\$4hCHy†/ná:ÜM™hù‡’L¸ \"¥r*˜CarŞ.š †cå&[#€‚¨V\r5	0	Ê4¤œ(ğ¦jÒ{Di•Ç÷2B û?äÚVI>pÕ4²t“h»NrE8Öôê–„l4\0Za% t2²æAãTÔy¾L-ˆ)…˜L\rƒà€#Hx´—ÃÒUkàÿLd¨Aùğ\$á,ï¦¦¤C¬Gjì8*ºieGÚ£V(Ì8%«¿Ïq[¦.q9VJ	jMP•B¨t|‰Ñ|i§V•ÍÃ’rÑä‹Já°†²Jê¹a'Ô\$äD\0¾B¨TÀ´0ÒENá'z(Š©*‚Yk%Ì°³&B¨øeCô¤Â«pš÷Hf (Åµ´fI£”\ræœ‚`*¤@RkzJÊéæO•Á±Â¼IÓ›ï\r¥¨üŸcfkİ	•S¹PwM#;!Pá¡BJQÍ;6µU¨úÒaË«úEá-¨.ø¶Jë!h¬h ´*XWS£ŒµÈ‰º›\\‹¡p\nHø:—ÛWIi+À";break;case"fa":$f="%ÌÂ˜)²‚l)Û\nöÂÄ@ØT6PğõD&Ú†,\"ËÚ0@Ù@Âc­”\$}\rl,Û\n©B¼\\\n	Nd(z¶	m*[\n¸l=NÙCMáK(”~B§‘¡%ò	2ID6šŠ¾MB†Âåâ\0Sm`Û,›k6ÚÑ¶µm­›kvÚá¶¹ƒ![vÍÉM@¡å2¹ka>\nl+¡2HîµÂ#0\nÈ]SP©U!uxd)cZƒ\"%zB1°´ÀC2êÌ©o\rä*u\\¤o1ŸºÂgØæ{-PÍÓsóéŒWã¤µ•>·--—¶#JìÜKËæÄê›<­Ö‹TÜçsüüF¡ÑT¢…Ì/\nS0&ã>l°`Q\r{US!\\8(ª7\rcpŞ;Á\0Ê9Cxä—ˆƒè0ŒCæ2„ Ş2a: ƒ¨à8APàá	c¼2)d\"æıêrÔ¢Å’>_%,r‚ş6N\"| %m¢T\$ÍŠS%©ˆæ¥¨êJ>B²M[&‹%ES’…<¬ªÀHÚPW;æÂˆ¹'ï²²Z%nºôS´,“‚ÍŒ+>ˆ'.r%!…›œú²R @œµÈ©bÌ»)AhŒ!¨2‚Ÿ³ÚtË>ˆã8²&ò\"”ÿKMLÊ5<²îB°PüÑ*“ÌÏàPJ2<nÑTÕumFÀ\"4‹úî³ÓøH…¡ g^†¬[ğÈ‘2ôXÏŒdĞØ²òÌ>2îìØ¦Ó]N•°Ë¬B%QTÃG’Ë°Ó‰\rB@	¢ht)Š`P¶<ŞƒÈº£hZ2—ƒq\"Ò°şUPÈÚ:pàx0¦Ağä2ƒ¨åŒ8¤0!à^0‡É~†ˆcxÜ3\r#>\$2ãXäŒ=r44p€Ù\n&A\rÙ–iæù¨Ê<ƒ(Ü99ƒ[Œô¢‰! Pä:\rŒi!!å@’)«Âë\"¨RÍT9)QcK0Æ¨´”Â«¦3ª½Ç(:)A6q‘±j›õbÆI¢Ôô\"2ÅZôƒ0#®@µ1³;SmäF®Anlñiº¦©¾õVo›÷\0WÅÍüğ­Ú!q;hÙ:Ü–ã¾³ÅRq«%b2tP¨4b£\\23føCÖ3„È6½p8Xz0Ò2@á\rxÌ„C@è:˜t…ã¿Ä>?“ÁC8_¡ğ¶r:h£p^ßtáå8í\r7Ê1›t˜Qi¶)‡ä½æ°]\n9à2MuM\"¢£\n±°M†½±—&ìaÌyô!EĞá»‡\0B’ˆ.!íœİ³TtôŞ¨ezïeí½×¾ø_åy¹‚çÒúß“?h-\rø¿66Eòİq¤<•2:şTQY?µc|ŠÂŸF/‚!,3Ít #†UÓ#ıƒD¡(¸òByIù%pDÜ—\0§v…c~ˆpÒ` HP8 w€ƒheU„34ä‡CcCÌ3Xòxge±Ø:€A%P£1/1‡½\0Üülhñ¹\$nÛ‰åYÊ‰\"ã|Ÿª¥‹æ”IL™Šh \n (?è²J\"á'#É¾%‚‚d\nRZMSœBµÂ,ÔÑ¹/d!ºG'‡%Ãx È4¦fäÚD(e˜! Ş‡%ò	)©IVmÑ©A=CÊ”zŸ‰|oaì±†ˆäS,@²b\0êˆ‘\"&J°;†€Òä³Èïj=!JÃ³H)… 6[B•ÊU(Óg`QQI’¡rjW4Vnå	>Ç–R©*Ä€¤¸ÙrlVR^6i’—nVˆú*ÊÄw-MÓ—q±X\$0òÃªyó™!0Ü«\$¬åaáÄ:¡„8Hmx¯šHy0CBr^‡!”G8I6*j•+D³]`Ê~KÄb“’¸ELëÚ?e>òõTâE:kvd„¬Cªj9tQ£.DQ¼^)‡ÌíY	Zê‚`IhÀüÀøºª\n3Y\$¡L(„Ç3<Êr¥©ÈÄ‡šuÜ‚0T—°h‹ËHj 0ˆs\nm6DK˜OSÌJpå6™*'b]\\Éğ56‹¬™U*~2MØËØ	…w	|&»ê‘Nš;Ğªœåë»Å,ªmz…ñTwÌ¹_RvOf!É°M´ì+š¢xÜgqé2Ë·˜luÆ‡†µkÌÁL‚¤®Ø™ÒŸí€U\nƒ…Zgâ³{4×Bİ,~nu¾2B÷zu€Š“L(õÚ0#€p‰4d6©_œEşå±‰0púC¤™Ô´§İ’€NMÆRnŠ6ŸÁ39–ğñ¾:Ø6xBÊQâ1µ­B\\ulàápˆ(\$zŸÉ»ƒ&Ñ§¬‹Œ–ŒPØ1„V§qDmrÆRE^ú’ƒIŠ‹™\rÆîß/ìxÀnâwTÔÍŸt£¢³iÅ«F\$­€°´ù«FõÏà~ä„\"ÂMdÒéXÓr._rÉ¨‹";break;case"fi":$f="%ÌÂ˜(¨i2™\rç3¡¼Â 2šDcy¤É6bçHyÀÂl;M†“lˆØeŠgS©ÈÒn‚GägC¡Ô@t„B¡†ó\\ğŞ 7Ì§2¦	…ÃañR,#!˜Ğj6 ¢|œé=‰˜NFÓüt<š\rL5 *>k:œ§+d¼ÊnbQÃ©°êj0ÊI§Yá¬Âa\r';e²ó—HmjIIN_}ŒÄ\"Fù=\0Òk2f‘Û©ØÓ4Æ©&öÃ¥²na¾p0i•Üİˆ*mMÛqza¯ÃÍ¸C^ÂmÅÇ6†É>î¾‘ãšã„å‡;n7Fã,pÃx(Ea˜‚\\\"F\n%Û:ÛiPên:lÙ†˜äh”A¡Ü7Â–½£*bŒnû”½%#Ö×\rCz8—„\nZŒŒ#Sl:c›’Ù¨éÒ &ãä0p*R'©(åBƒJõmø@0³ì@š¹¸£L7E‚^Ô¥Îâğ+G	è#Œ£zJ:%Ï#ÔÔŒš`´#ƒN¼Œ8Ş—={Ù)\$ƒJTÄ3Ğ4L\0ê2 P¶I€à<cË\\5ÍRjî.ì@ª:ÃI»÷\0A(È×Ã¨CQ\r5.cˆA j0ÍÃËGÆ‘Ê>å	«Nø¤àP¥\n·ªJ7JÃ%>+#í;ª\rÏ\\Ü\$Bhš\nb˜8sŠcµ”; Uh™º¡6Ä(a††àÂ¡‡Ã“º–¦üf9:ãÈxŒ!òSm[‚‚3\r#:Z2Ü÷L#Â\nRğÃa\0×'˜e²×Z°z€_Òö€¦¤,İĞ»^‰_LLš\$Q`Ù&+Šò€3É¸§\$M£éE3Í-„Ø/¨[47Ú á(à¶(#s’÷´XD4é-ƒtñ–´QK<¥ËFR—òxˆ³©edñÜTc7%‰Â`¸/É£d,Vj˜fïò!”™î®4h#ÔèÓË`š¹®›:=šŠzĞ\r:¬Ö2ë\n­ë°†Á ì`Pª6!z<õ¥HQ|†£Lš!£ü÷á0SØ:É­®cJÙ¨¢=²‡ğÌ„CBh8aĞ^ıè\\u]-Œázî¡Mºp …á|ø#\\Œ­Hªk®íYI§Ş·P\$ó‚~ìÏÃá ›öí5¦Ú²L2®ìHøAl@ÌÒ›.íJ&«‘\"&uàØ†Wfí]»¹wnô;»÷N]ÄxÁ¹ãƒâÓÌKp* ãBGê÷©,7¥’öO‰ o!•‘\$æC±l…¤¥ğ'²õÌÚ!ca„ì‚Ø[‘” Ê¸—¡ğæaiİ0äÀê“&\rwsè†*9rjØ—óëo,˜³wfWû¢Kæ°÷µÈZs{îp¤¤½…Ï\n	¦ºv.æO \n (!3Ãã3Ca\0 ¡‚—ôˆ	ë;§°Ó\"RØJBË¶¡åY:E¾EM¢‘nd4!\0à–ØÀi“¤ÀˆÃHé\$C÷&dÔÀ¬šÁ&1gv,´†ğrIÊ2¡ä<†ã\\ëJi™N¬ø´ã¤€Ó)·D¤=CÙLHÃbvÇÁÍ,é`üav&)… ŒNÉãEHä\0˜[ÁìÉ(0š`àÎcğ\rÈ »“B	’§&ÅÜ’ÒêçñÓ…ĞÕ)O\"ÃÌå	hì°‚ÄE{	FqÉÑ\"Ú)ë{TKÃàÀ],;„¸ñµµ:¥D’–Ì¸¢9-\"A@'…0¨V-”r…	îmrÓ!ìÃ:CèybDô7/äŠâ)§—\$îeÊç­ˆÑÀ!ôÅo\0¦Bc\$ªgĞ`¨Ó_nì ßXKVŞÊc	É”’\"HHˆáFPh\nOœ™Í'™ú[õğÒĞyìKëÕƒZ§DÖ‹z{ÑgìQC“‹á'“d	vE,¹‹( ¬¹Õ~ (!¤ÀØ\nÍ»¸nõ 9Q¬×NóØCV%´zåäÁ!áT*MğqÌ!:dê0È `%Ä¥¨ÕVë`MÉ±?ïüÓ“c²LÑ³]1|»†YÂN	Pu’Gt3\naÒë¢5×˜â˜t&KÑÍë¶Ù³XkªI³T§z77:´ªÑˆTµ¼e5w›V@°W AnQ¦Qjâ˜åŸuC¡èrôJùê˜s8LI½T#^lPÙ´6*ªå˜çLğ_Ñ5°”\naÜÓöOùŞ&²O‡ğmÃ~8ÌŸ‘Àå\nšÜ€°ÛGpîã¾xAá‡'ŠñÈò%él2<Õ¸{\"ì{ ¸";break;case"fr":$f="%ÌÂ˜(’m8Îg3IˆØeæ˜A¼ät2œ„ñ˜Òc4c\"àQ0Â :M&Èá´ÂxŠc†C)Î;ÆfÓS¤F %9¤„È„zA\"O“qĞäo:Œ0ã,X\nFC1 Ôl7AL4T`æ-;T&Æ8Ì¦˜(2ŠDğQØÓ4E&zdÈA:˜Î¦è„¦©\$&›Ì†˜ôfn9°Õ',vn²G3©²Rt’­BpœÂv2„Ú62SÍ'I´\$ë6™N”èƒ\r@ 5T#VÍŞ§’MÙKáÏxrrBáè@c7Ói‡XÈƒ%‹:{=_S­LÈäû§\n|‚Tnòs\r<ì¦æ›Ñ3Œ6Î„˜Ü3»€Pªğ›\"L£n¥ÎÀÜ7;ŠN15¨‚hˆ»#s\$š´ˆƒ88!(»VÖ£pàÚ7¶‰ôF…ª P¬2©ZÕ°\$\r;Cƒ(ğŒ2 (\nŠœ)ª`çE¢pŞ6ŒL¢\n\"(Ãªƒ(c@Âa•Ì\"\n!/£L¤\nLØÊ0 PÉIì’œ‘B ò8C‘ªVùÊ²ÒÆD¼ô=sën1)ì.ÖE‹ük,»J4«!QÃ¥ ğÒO²Õ£)s¦Œ Tœ¨Œ£c¼TŒ“ì:A(È\rã0:5uaY7H* 4CsÆ¡xHØAŒĞ2¤Í’è4¨¤C+\ræs:JBJŠ6uƒYR‚›\$‡ÛË—)’\0Âû‰@t&‰¡Ğ¦)CPÔ£h^-Œ7ÈÂ.¯ïÊpîµğÄ\r ª\0@6®p@*\0|Ê»1s„0!à^0‡É&‡nÊ=\0002˜Ö9\"&ÊfP’ŒÛöğµÖ¨b¶æc”V’wŒ²²9¨ošÌ3ÎƒE„»ÅRÌ\r³\\½°‰ ¦Œµ>ZTÁÌ\"`ñŠŠxák1ô„›2I¡‚ªŒ5.ó_T“b#s¦Õ°Úí£p®úü/°ërË¦»FÕB;k|Ò*\rFä2n’%_»Â2HÀ3#*Ó3ë/\rÃZl3\"Á¦á\0‚2rˆÎÓ!‰¢5†iŒ Ì„CCv8aĞ^ş\\0õŠbF‹á~zŒÍ&ì…á}æÔ›ÿ“c V¦…ÈRPá3C{N«m«N‘6RÙí1\$ñ{‡:ÈØ<QQƒš “ÇŞû4Tº ĞíÃºñß<„ñiÓy(7<¦xÏ h\"aÄ8*‘RªÍKØ#dœ6§&š…Ø0a#Æa‘Ã(‰OÉO>£BŒ!ªeá¥›°ì÷ù\$fé+C56ıƒ“ø\r•¡¶*{¨&ÁÌŒ6”eºâVFIŠš€Æ‰I´FäØ!–Ø90<†)µÊSÊ‰Ç[F“æv#*C\n (@êˆ°t‹à  #JRŒXs!!¸†œ‚JIÜİMàÕÇ“jµK´/†lÒr”£ª5/G¥˜Ò¤HûÏ3\r³Š”ZU0yb®˜ÌSX[šC%¯ÍEš×ìuJkûÅÈÓoMœ¸i&ò\rtØı‰ T\rá­‚\0†ÂFA…I“C¨‹Ñ‰,m°œ´¸”pQH³\r„¨Ê?|”\".& 6¶¼B	Û\n†Iú™)¯&Ô2¡3¦¤Aæ&Æ”Ó¶Ù0ÏfìT8‰XÊKÈœ•‰ pF\$ÙÕÀ–ÒLšqS­¶…Â ÂÑhD‹Ò˜›\0Â¡(kÀ€3ÄPMN¢i!’‰¶ÙÆJ	TÚÌ	\rRE`dÌü}TØ“ÍD´Š˜3–R!‘³o(‘Ts\n„Ñ›cP ¨ox‡tÁÒÂèÒAİ\naD&\"24‚¤u:ÌôÎ-’6DÈ©;´F‰¢RÕÑC‰ª¡U>©Vœ¢¢=„R{Z÷•]1èT¿#G¬(L°õô¦ÂOcaéd‘[-û(OI=€±¨Ç†™ì­U}‚ï¨›’{h¬qŒ´Â¥ %ÂœXc@²ñ¶™Â5j26Èâ«dHÉ*(Ää9EØi_¨|Pg§byÛI„B F âÎ*ô\nÌ%Š³:<¡¶ô­®úbV6ËÅKÈEØ!\$‚„(†DTzWšAì\0“˜b¢.2™R—T1›&Ö}Â’¥”DÒ\\s  Ğ+ö5DqÌĞOƒLhròøÜ`“Gh	2¯)q/*@F «HBïR“\\HÅ©«ABªe!\"J[¦FpÏ%YpxLuèj–Ô¼†AVò¨Yë‚€æ\nRàl;(<,ó|ë‘ĞÁ+-eË\\‡/ö.\n‘©kŞ]E^1¼6\n<Ñã\\iƒc‰\$ÚE‚)\rÑV,‹ê!¢u›Ÿ³iĞÜ»·zïŞwxoÂ@¬M{õäX2=ŠM\rÎ’J'°€";break;case"gl":$f="%ÌÂ˜(œo7j‘ÀŞs4˜†Q¤Û9'!¼@f4˜ÍSIÈŞ.Ä£i…†±XjÄZ<dŠH\$RI44Êr6šN†“\$z œ§2¢U:‘ÉcÆè@€Ë59²\0(`1ÆƒQ°Üp9k38!”Îu“ÁF#N¤\n7œ3SuÖe7[ÍÆƒ®fb7˜eS%\n6\n\$›sù-ÿÃ]BNFS™ÔÙ¢Ê ğšÑÎz;bsX|67…0˜Î‡[©¤õ«Vp§L>&PG™1ü—\n9“¶ÛäµllhİEöœ]ÄPÓ’ÊqíÇ^½k£Á0óÍà¢äå&uíæQTç*›uC¼&&9J†ÕÓ¢³¨: ƒ¨àŒ@ƒ€Â9cºò2%‚òŒ#´&:¹«Â¸M2®­2CI†Y²JPæ§#é\n¢*®4«*ÚÌ\r©ú?hÒ¬\rËØ!Œ)ÃØ!:èØÒñŠC*p(ßƒ‘†V½‚ Ò‡4ÉÂ@7(j6#ĞÃ§#­.jòö³²3Æ!¡Œ\"€TØ7­“('élè1§á\0Æ„N­ÆƒÂÊ²'Ã£ÆŒ\0Ä<«@MGRàˆJ Ü¨^tøbòC„),œZ”¸¬Ñ)¨.ğ‚1ŒqH\nc*'ZHëèä#<|	@t&‰¡Ğ¦)C È£h^-Œ6¨Â.×ÔëZ¡\rÃ…E ªX@6Ã x0©aó6ÙHKÂ#o8òã|”\\÷Læ-ìİé{DÈª¥¿Q€Â‰\"—'Wa'qCì „DàSÒİ ¬ı~Ñ¥pÿ:&±Ü”W#“R¢×óÂDÜ2h†E©j! µ®ëp)¦?äAf#Iº(ªP¬•F¨#pëEÀH‰˜Íù£M›Q-j“ä1&}ªh9Ì7è¸ëéh|#:Ç°Â(Âåµ²¡EJk¦B£ù4Ã4.ˆ0!\0‚2i)ş}¢	Â9sÇŒØÌ„C@è:˜t…ã¿,H<ò¼Œá{\0¨«ê†„á}Ğ¿Uÿ{ÎRë?·‚Û—kHl&3B°›c>8Zöˆ“¥3ôÚóï‹«NëÖ°PÙ?uİ€\\qGÆqÜ‡%ÊrÃ¿1À:éø]ÎsÃw<<DŸÄ]\"J/CæãVÜh]¢à0SÏ\nO“| <9¼dM3mdId2†&ŒgÑ0ˆÕä:J³k6JôsTòà3ûoE%/\0ÌV;¯Oˆ03à@˜9×‚¥4²FA\n5OÆlœ(Ò]X«DYò1&ÜAR0…!ÃÇÊÛ0P	@‚ôb(()`¤Ü›ÁBR%äD‰’„æÊ}QOÔ‘0ÏPCS4È\rxÄÀÒT^††Z†`BbMEX†÷bÇÓsÅ\r‘Pë‡bfë‚&lŠšfØ‚“ã…ÇX7–kb8°T4\"¥ÆC;QÄP:BõLÚ €o\rm!…0¤˜†2 Ğ‚\0Š¤0­\"…%ß‘Ô²±ƒk6&£áD0¥M#gâM	³^TÄ]/'’…\"^z#áÀÂTAZDÌ‘¡•S\0jM‰#CÆèŸ5jÈ™ÉÏ\"„y¿¹¢¬¢g€pmºvf_R8˜\$'…0¨ÎY”7~œóÏ\$NHd¦Ş_DFq—„àÎÈÆ™¸&ã:!ğ¸İ8ÀR':ÀÂ8†‘I;*@€)…˜×¨bï%„¸˜	raB0T‰‡Zj’êĞ§“ğ2l™.Ÿ’Ó\"L~9ymN€Cy'UJy¨fbÍŞ‘©iMµ?\n«X \nRuªÁåÍmk}VGjŞQX¨CJ!°†9âhb‘„z&8ı‘qÍ¨è ¨Â=Ãˆu\" Ü'ú´HY£Â!!T*`Z	B“\$ŠÔS@b”’´q‹DøAŠ1KpŠ5v·ó²ŠÆ öU‹.©•ı+O“ÉD†P’f*µ2@)%å~{›\\'”„=O“sgz\$5ÏÜ6ÕÒNª1§Õ§\$\0äÍÁ21İo£{Íz)Ÿéƒ>M®9œ3Ê	á>°Ê¢«Uª5A†Ô¢™ŠAUÍ·‡á\r0+âÒ\"z¿}XER;EkF·f\$‚…Cz{6 ©\00063<FÀ";break;case"he":$f="%ÌÂ˜)®”k¨šéÆºA®ªAÚêvºU®‘k©b*ºm®©…ÁàÉ(«]'ˆ§¢mu]2×•C!É˜Œ2\n™AÇB)Ì…„E\"ÑˆÔ6\\×%b1I|½:\n†Ìh5\rÇš;‡* ñÂbJ—Á•u<UBkÚÓ0i›]?³F'1eTk‹&«±èâ†éG»Çä¸~_‰†&¢0ˆE®A¾dæú4¾U™Â¤ñìMæB”ˆ¥¢°i~ã¬ÍÅ•´\"U Éhn2\\+]³’í±[™´v‘GÃb¢Ò¥E¹®—‰ì’(”‚Å·MÆ³q¼înNG#yÈ\\\n\"N†„æe\ræS˜ƒºt‚N/àà÷c»Ê2<è¼Š\$\rCªÎ6ë\"ŒèiJ\$±\"Ék¦§'ˆ*V¡£*Z§9Ğ³w3ˆräk·(²@…s Æ5KâŒ%èäL—-LRúk¤‰{0Í¬Ñ<Z–\$±ì\$ë3iH…6QC`¯É0b>ƒ%©zZ•HhBÄè#dw-9ğ3€†ÌÚ_\n1¦»§“Œ!)„£\$±D\"™A b„œø Îƒ¦TÆn19	.\n|ÌÄ+©\"ôƒ:rbC@Ñz!Kè\$Bhš\nb˜-5(ò.…£hÚŒƒ%£lâ,D	è@6£›ğ)è|9£ ê9<\rŠñŒ#ÈxŒ!óÏ^WÂŞ7ÃHÏaŒ¶]›„KÀ¼â Ò9½ƒcá[<¯İrÜï­Ó[£Àè2Ã˜Óip+,£µËèä:\rŠìk&¨m’¢Äû`µËìâ8±-ª:ø¸ÂIzNš8òªJ¤¡è‹ä,n:<!„¨X°8ä…b–ÁT”#8¢):á†ÌãvĞ!*—ºĞ“ÁPLu\$¬hÂ2\r¶óÅ”FÈŠ@¸Põà@4X0z\r è8aĞ^û]£é#sÄ<£8_zï•Ö:^ãp^É\nÄÆ¶Ğ|ƒ,RƒT•1,¤Ô„´ù:¦Âs»§\$¤Œ©%H‚\$•!Él‚ˆºi#Q©jƒ.­¬kZæ½°l[&”óm;^åxŞw®ã¹×ÜJ(ÄÍ	iG½\")Ä%‡à¨C¦Àå“U!º‹Ğ<nBâÒ*=)%èôŒ%©*\r€Â1î˜@;#`ØO€àñÏ(Ú2ÎCÍyOÈÆ1¾ƒ˜Ì:üc`Ş3ÛŞøÒ@ €Ár>°@Ö\0d^À0†Åòc‹±v£\\Q›,” ˜£@\$\0@\n	è)5*-…- ÜÙâŞğ7‚\0àƒHv|!”3¾È\\Oªã>Á¼ü@×ôßbMc\\³1†j˜‰+’\$‹Ñ®SŞÁâ>è0Cşıéà€qd8Sü€rNAÜ4Ç\0ZHgk/øE°ÆUÈe@¬Œ” bYS’aìl£‰×Éyx\$§LP¸Â†£\\#’!„©H	;83e­äFC!!“¼òÂ†L:P&OÈ ä¤ÁŠx€´ ´‡Nf˜¹z\$•çÂ[¢ad°Dk¼3œÅˆI“’ÑŠ’b\\¬e3E\n<)…I,Dˆ¡f12|£9#…0š\"Ì¨‰L7ŠğLÔÃKÆL“Ò­áp’íÉB0™PÁ¡*AâJC„³6æñ”14 –S+±—¦ÓJƒwÈ\";’JhËµ¡‰µ[\",jŒIg\$…€¦`àÓd}›F)æ‰Tî˜HÓÜOŒ°S KÓ+’!DyÅ›£nKû—§QİM”QN)/4¦`d#ƒ0-y9¦nÇX”v5jT£°Ã4i‰²±„Ø¿TózKI<pf®É”N¢©ÍdAoT â™S«9–oLÅ#HêC	rSP››³zYˆQ‰jÎ‘t*àÑ!f\"Ö®šá&aÑy%aJÍ&„ÊËí\$	5JÂ1dQ! #ÇLNj`Cm4vy*b’y²ªÁFR–Å!Ùºé}N ";break;case"hi":$f="%ÌÂ‘pàR¡à©X*\n\n¡AUpUô¤YAˆX*ª\n²„\"áñ¨b‘aTBñ¥tªA ²Ù4!RÂ‘ÜO_ÂàªIœÂQ@Ìèq¨š’*¤‹Æ`¨j:\n°	Nd(ÒæˆO)´úŒ²Œ‚§!å\"š5)RW”¨	|å`RÎÅ‘*š?RÊTª˜DyKR«!\nØDµJ¯C³u\"¾)ª)Q¨:–’¤¸PT‹i´5@¥İ«ğÑüñ-ÂÌu±e‘ÁQ¤ü¹IŠŒ[õW8m†R[#Õkn¡H¤’U÷È)â‡aéî²%&î;ÅRd²”E\"ÿ…qÙqo3ÌÏ/%+ïó¨¿Î½„Áx/†ŒÍ!íñ>è¦­Tè®oûÏ¦#Ì£½#’®µo[á¢ëSòä§BåºhÑ(«³–§¯Í4µ9‰<é|6êBğŒAÄQ\"\n˜’íŠœ:ÎbAÃ­ñk\n;hÒNôGî+Å#zæèjxÆ9…º(/‹,í ¤¼	\"ñ¢zRCL¡<ëº\nJš³Ï»Q´7)©ìT6û@’\nZºLšFª—Ñ)HšEÌ¢sB’é	ª²[ÈŠÎŒ‘/2êÒ5*¿´e):h+ISÓã2Ä¨M6…À”*.Ï²û¹1R5è±¢ÈúÌR­BÖ‚­ÒsO­‘“(ËJ’´Üò§\nr“PÉ£!ÓÏÃ)%´Kd{R§ÉEÍš;Ïô(J§“Jd)é£EK”ÄÀRG¯ìàñ²îı=%¤ªya\"¹/ŒP…Ş5‹szV´õ&óİ©äOĞºHu…êÑ-=E©òù\0b³ŒÂc1\\Ô8ŒˆÕ½”àNY—:è½¬ãÊ¹.t¬!hHèA«]ƒÃS+qÑä4Æ.nÕ®¥7öŞSÌnÍ©G¦…ö—Mò^\"§Éí2‘qéQÛô	@t&‰¡Ğ¦)BØó»\"èZ6¡hÈ2:°òR4óI¥SJ’*Ğ|‚Ó„ª4HP/„\nÑJtJPã}¬ÀÒoëÊ-ªõñœwX0L¢š^9×©aÎsÊÈç]Õ\nÒÃÄÓ¤\\€ç3¨»÷¬Ç]3ÛøÑÿyÈÍîCñ2ÔW)>2]÷!´?UÖèNŒêØÓÙŒ«®ê\rƒ äö#¨Ñ\"‰ ½ƒ°æ\"åD°`>íÍr¤Ø¢‹*u{î·NŸM©œŸ¾\$Ú”ùM?Œ…„>ä¾š›â>@°¬²Ö¨Æ»49‹\08bà ÈÑ†‚+°ã¼G¸NÑ¬\nYe<ÃÇ4)Œ;•ş\nC2¬ÃzĞ6'E8Wrà#JÀå«\$Âè–=ì€çò5]kÉlk\n8À@eÀô€è€s@¼‡xÌƒd\r¡¤7Päƒxrà¼2†à^xn!Ğ4Ç^œyÍ9‚¡Ú9õjáá\n:†9ğ/èLz¡A2Cj©ö»\nqJ]ƒ:\"šhŠÂÔrĞ1‹’‰ıdŒ—’FQÌÈ”ı\"Ø’uZ'^”#×¬=€gÕ­EuØô.>\$ ‰G]³¸Y²Ê+Eˆµ\"ô`ŒQ’3xÑ£dnÊ:G`Ê¤uqö;'TT\nR–°Í®*¥!e9~ÒNS#Sw!|9Sçˆ‚¥¥’äÃ#R4Õ>O\$V@¹ADÑ2gı\$˜ûŠjhm;=Fs–BCzj¥Ëˆ!£\"Ó\r\"„DUòÉaJ°s¼)b¥NHÍè¨ÇBÏãŠ;”¼ä(„Ş¢×x \n (*µ:ôé’€€ SÏ‰ jªy¬(ÓÒ¤‰x’3­l?ƒDÑ¹”2%yÏ—›G\$I¢PfCÌWJ	Šjˆ8óÓ†œ°“¢õªP\r‡©ö#Ó´‘~+èÏÏªúr+úo¬s¥T=sÂªL¡†>¯ÍŸåŒ\0PÄ•…×‰\"LeTQ2 €!…0¤ã\$¦\n˜…aÅqL9Ò†I9f á9<®-CËc£èÒT´œÿÀSEg\n*5X©¾‡'ÙˆÒõ«H\"NDW…í:êryYúEmkh#T%[Ä\\w*­0@6öH§ƒ]j½w–Ü´¸2îFŠ\"Ie	òÉ”Îlƒ„•2I\0„`H/¹B…\0Â£¿\\…X¼á&làÉ-±{eÖ	(WxdbouîÅÊÓY*h_¹Í’wbíR«ºúÕF†G› @ÂˆL¶B“2‚2‚¥EqNZUrm©ÿ9iîXµímEÈUK\n¬\"5 a}­ ÇY>S›MÙN¬àgû:NI‰à\"šàåÍöB²DÌáyÿ]­‹Û7º,âè‹ºÃÎ©ÉC»Ä‚Sê’®‡™ÈRÕ¦W¡³0Ép‚¥‚ÄjrÏ3gÆ¶Y¤ÿPÅ°Ò/;-°%âÈq2ƒZGÌ]k}÷x¬<FüĞU\nƒŠh­ë[1ÆaÂå@q³f9•ë¶f|Kdü9ë;3ÂCŸq)/Ğ%å™i—´Szy%>ù­\0Ì•(ºZrTÇöNfƒÚªŞ¼TÏOqH¥`‘ƒê}¯†éÊg±+ÍGo½à[?¹ÍYğîŒKÀl›T˜šŠå=Ls¸r­ÊvcêŞ+Âä•ª[Ç¨J Á—š´ÉêÚHåki™NŠÉŠ•¤Cb¼òvÇITEvB\$âZSÂ‚İ\rÄÊ—Ô.pg.®ŠAFuÅv•Û…\r»Ôõ—GÚÉ™ğ,ŒPsÚ—7 ,òÙÜÄÙŒ7>î7Çî³ìZ±Ì3aFGq¤¬¥@†Ïß?`5eçİÈÆ—;aªåÃRÃ€";break;case"hu":$f="%ÌÂk\rBs7™S‘ŒN2›DC©ß3M‡FÚ6e7Dšj‹D!„ği‚¨M†“œ–Nl‚ªNFS €K5!J¥’e @nˆˆ\rŒ5IĞÊz4šåB\0PÀb2£a¸àr\n!OGC|ÔÅ ¤ÁL5äìæ\n†L“ÃL<Òn1ÍcŠ°Ã*)¡†³)ÎÇ`Â˜k£•Úñ56™Læ¨Ô†­:'ŒTˆ‚âdœ›2¢É¼ê 4NÆZ9¼@p9NÆ“fK×NC\r:&hšDÌ7Ó,¨› *müsw&kLšá°xt”Şl<7°c™„Ìêô³VôAgÃbñ¥=UÜÎ\n*GNT¾T<ó;‰1º6B¨Ü5Ãxî73Ãä7IPˆŞ¸oãX‹6ğ*z9·C„àæ;Áƒ\"Tı¿¯ûÊ‘…ĞRŸ&£XÒ§L£çŠl¢ŠR˜§*\nÀ Ãh\" È¢\$ñ\r##9±E³V÷¬/ñBØ­âCşa–cÓzã*.6.ğŒ51*e,\$HáZ8«{éÆr\\Æ6L£Ô¤¥–`P”=3È„)ƒƒ £kèÂCĞ@9H+Y45\"qÚ4£#Î“€M+K¨´Í61S\0Sî·À PHÁ iT† P–¸tA)¼I\"v7.lSê5ÁŠYB:;æ)bÕ¶¶ –Ù?ïâÆîCjËbKÀt8ĞÛ!cÍ¼<‹¡pÚ€Â9;Cb/J2jz)ø|¢ƒ”0ŞğPÂ<‡xÂ%W…ä!ãpÌ4Œãªw~ßñ`@»Århá¶¸tÏ\rØ£XŸ„¾82\npÜ98(æ•	‰£´#lkJÓÜí`Ş3ÉšÀ0C“VÆÙo¥úŠƒ{\\6ßÈ@:äc¨Æ1°£˜Ì:Ç7PÎ»ab&9hÃÎ0â…66®ãªœaK\0¨Ö]Ÿ:	P¨ÔÀi¨Í‹Í¯p@ ´º«y4’†ƒPŒÁèD4ƒ à9‡Ax^;òpÃ¼©l3…é\0^‹c#¦J7á}Î7¯v€;ú@Ö0²*BzÚH5Ñ«2«›DQK;Æ]\rC’şï¿‘ƒ_D•-Jwp) ÑÂpÜGÆqÜ€ïÉrˆ`]Ëó=A‘d˜/Cy	#hàÚõ£§O‡2,ÊÜ%¬&!š\"æÆÃoUÖ\$	àÊø l5Ï¢²@Ë‘L;<Õ¶¢4ÔK@i8§ÀÍ0Æç˜( æÑ»¢›˜r2*X0†g„†[MiíD7µ4ÌÉ¿5‡tÈ‚\0ÆòÎ@i!±“˜âòÚ‘yFK<ú„âïÌ“FPèÍC8¤E\nÒke‘Ä‚\0 „@Fê‚‚~ŠÃ™%L7ˆ.İ‹!¯6&ÌÚÀ…,†—A58(X‘†ÅÔË‘*b%ÃDS±#7…‘6òâÃÉ©\$hu¦0ôfMawMˆqâ\"4ph Œ!ÄsY\$!°aM°N=ÇÑSÌªaL)bF˜)e2äpY‚à@Ë`lŠXò;é^1ó(i’²ZKÉ‰32<Î˜¢ÉìK]äâ:²±‘æxÁ@è˜ˆ\n	\$<š`@I­BäK“‚NÃˆu0¤ô3 ²\$Ş•†H 1®¨ÂoÎ\n\r¸Å£’ÉV	áL*H#zA\0CV\"Ø5˜Cšá\"Šrg˜œ¯DvÕƒ³ZhÇù'¨HÃ‹9ÿ)f`îLV_(PAº]NN„†&˜Q	„”ÚÃfI0T‹+áKàOQy%À‚0³§µ1L€R\"ÙFãVª‰©DÑX™Š®»‰M«G ÅÊBJ”İYG%0ØœÒxTÔíRU¬rœâAuq¬5J¶WjßÃ¡ósô4†:I%!\r“Éø-)Ğš2/%AEİ'¤p \n¡P#ĞpÆìè\rÁ´)b˜{æCgş³×«Ojj=¬/ö¹‹ÔkVL«9)\$P‹\$\\–j3_ˆ’²ú‘Nù	\r6@’;EIK\nJ\0P†0Ò–\0QÒFŸ¥œé=Ú»‘šœ\nBŠ óDÁ ŠØrhAdZ®—µb(U¨ze¾š-\"w9Ğ€\n	—òÑó®ob:êÅ<Œ1,Î‘53æ„ìÙcµ}ò›´öĞ9aÄ~e`¹rUÉá‡¥*<âµK¡+u\\¬Å ×P†µr†3/Êİ†²×ƒğLg7ŒçP";break;case"id":$f="%ÌÂ˜(¨i2MbIÀÂtL¦ã9Ö(g0š#)ÈÖa9‹D#)ÌÂrÇcç1äÃ†M'£Iº>na&ÈÈ€Js!H¤‘é\0€é…Na2)Àb2£a¸àr\n ›¡2ØTÔ~\n5›Îfø *@l4Á©¹Ñ†Œa\$E8µÊS4œÍ'	½ªl­˜¤÷™dŞu'c(€ÜoF“±¤Øe3ÉhÙ©ÂtÆ\r›y‹/s4›aÆàUãU/†l'†ãQÖ!7n³S>·S«ØÎ/W«æÂ9“5í·&n/x\n\$NX)\n3 æâĞ©x(«6ÇçÓ‘¼å\"\"CîißšÇÄyÓ‡š!9œÎşc\$‹¢9:A*7;Â#I0èÄ£XæĞ\rËÒ|¤iRŠù¡(ÒÚ‘+#:>ƒ%ã:068!\0î…AmhèÉ¬¢jÁBSŠ;¢8Ê7¢QZÒ%\"m à‰ÄNØ\"ŒƒHèóB„¹‚š_\"Bj@:rŒ¦…ÇãÚ—¢rİ#i8ê£\"7#9ƒÊJ1àPH…¡ g8† P‡H¨Š^·:m`ª96Ëë¬:\$RµÉ,°Ò4Mƒxîè	Ğš&‡B˜¦cÍ4<‹¡hÚ6…£ ÉD­Ó>æ'è‹¨ˆƒ\n~C,9'\r‚O\0!à^0‡É[Wˆk Ì4¢µu^Bak	½ÊàËÙ/0@‰ÙìmSiU#(ñ/K\$(ôŒÔ ä\r‘XÃ1	;7ŒÃ2Ğ7«š:Æ\\bXÊ6©:7²Ûr\"Ï˜Æ1¤£˜Ì:Äƒ`Ş3¦£˜X£CÊrŒYv\\Êˆ¦­°ÊaJ„±KÔH5Ş÷ËÎƒ1I²X3ZN£x# Úš£¸xÇo!èAV±5ˆÌ„C@è:˜t…ã¾”'Yàó¼Ã8^‰…ït£¬xDjÈ{yc×­jJ4±+‚ó‡äP,ôù¡iæ‘JP~tü?Oå¦<MbşçkpÑŸh‰£iPï¦fY¦ 9jZ¥µn\r:ÈEW‰-S.Ü›“|Í#ÏY%”û£·ò&:=¢,Œ8[Ë@%‘@Ò3\$B ĞÆŒ#°œì´H2(îY-³0ÃpçXüàøNe÷­Û ƒ\n\${ßN4Àğ ‹r\n2Ö¥9şåì‚€(+‰„Š2uI€PŸ…?ÿò\$VİxwY@dŒ¡–3ÈŸbXi‰9\rŒ(;¼T8ƒŒÑG~ä˜4;Wn¬VS± „9‚,¢phŒi5:gÜ7Pä™ƒ¹£di™†v„J^™a„ê/öÉ	ÀC\naH#?b“p 	mèÔ°fÁÃ\r¬!½0ê†A—J,†PÚ‚€(©m˜¬ûbBE&dÔ›Äş€P i\rdİf\0 ’@ÃÉ‡&)š‡2&çÍ,V!Ä:’R (mf%§ÃpØTvzhø0™“Ğz\0P	áL*b:OÁ)\$Ç!T\0E\"§'*Ä%’9&ÉŠ±\re–Ü°Ö) l„üÂÇ(fNë\n'Då3Ä€¦BdI€@€Ê–àŒbOYF¨û:8“ H\"ó#¤ˆ\"¥ó&JC“!2ÄÄÅ7½5›!Ç›H‘\"ÊdÄf¤àU3ŠYNBó;Î(n\$L]ÓÍs@‘ú4PU;\"°Ø\nä@id,²KÀìãé›\".yÙ±\$ŒH‚4Ã‰h>,°ª0-L73tŠE'šf0FL–NÆDLMùæ\$AF r\"Yš¥4«İ(ĞÀÌ@Q¸“ÄX%ï,€QóKç<í HØd“Ù< †íK„¾•)y¦ã,[!5\0(&ùvO1í=Ur¯QóztIâşSÜ…5ÆÙ,ûl¬‰2R#Ak—wORÅ__1õ\\nVÁ'clT!±­4Ì6\"âHë¹Şª€€5#Ğæ";break;case"it":$f="%ÌÂ˜(†a9Lfi”Üt7ˆ†S`€Ìi6Dãy¸A	:œÌf˜€¸L0Ä0ÓqÌÓL'9tÊ%‹F#L5@€Js!I‰1X¼f7eÇ3¡–M&FC1 Ôl7AE8QÔäo‚ÇS|@o„™Í&ãdNˆ&(¤fLM7™\r1xX(“-2ÂdF›}(æu¶GÍ&sšá4M\"™ÂvZ„€ÂgµZ-‡(ÑÄëJ¹.WCa³[¶Œ;fÊ’ 1ÇN–³®Ì§±”Æ­g<	§ Äg‡JşÓerĞKÁDSd®×³&ZÌûĞQTç³\"œ«úH&æ9ƒ:ÉoÑS!‡W3G#ØsÂÑ©8LÎg{A’Lï%,BR‰µ¨ÓP‡%Èë&Ÿ¨J\"t¤©jh@µe:¡¨H\"=Î@´7Îc´4 P„ëÃBÊ¦B8Ê7¡±f*\r#ƒ&‰¢ãrI­£`Nô¡Ñ`Š½\"“º¦¡ñ( ı?ƒÈ2…#Ò^7D¢`Şµ#Ìàä™KJŞ²ÈŠ(2¥‹0J2ò¦3\\Û7©@R\\#€PH…á g>†(3¾ëÜÓD¢|œë¤î´X ÊÉ‚·3Ò+`0¢i Ş	@t&‰¡Ğ¦)C È£h^-5hò.B³ŒŞº£Ğõ½Ì\"~\r©èƒ\n~4ƒ¢¼6CÄ0!à^0‡É5ƒaˆhê.í´–u Ÿl¢=Cn2æŒ\$‰MvˆÜn«Ss¾ªò5]Àél®4¤ÎÊ™¹r0¦2Æî3Í,SI5ö9Ì¦ÁB¢¾ú²rBäİ³ğÌ9=60Ş—%A\0Ù-­abÊ´Œf2„²Ô*á[ó`ÚŞ\$ N7áTƒ\\â+^'Š¬˜Âõcƒv=Œ2Ã.EäŠûdò-iöU–^ëÔŒ£0ÍØĞëp¤0ãÆÃ\ré0¨ÈÃ]º3-B\\7á\0‚2erÀå<Ér&9X	HĞÒÁèD4ƒ à9‡Ax^;ğu1¶°!rĞ3…èp^2#µÊ:„A÷ ¶7{EµhÒi¤®\$TÃÒ0ãÃ¤İ¡c–tÉÓ&º“¥/Êi&ÍŒ²Ö‘¿*1†T¼½än¡ï¨ï[æıÀp\\ ïÃm‹_Å…é'<IHİÊXbHÚ8#3NOÍÛšº^EkÊ#/#èvæ×3lÁ ©É?@Ã^i¼ÊB#ÉtÜªmêJR«Ÿñ1B„u\\¤I˜’ÆÒä-¡¥È5r<Q—¹4#AŒÒ0Ü• ™&«İy ¢—M!ÄJfš \"nPƒÕ~¡@\$O©÷=ÄhğRJƒ™öGAˆ/Pƒ˜Ö#NÄû‘§lfÉj‡pœ;·Ú—Ì1¯pt‡B«\r‘Õ\"p‰‘£Db\")`Ö»ôİ¢ŞP,1¢C6YM b.äÀ‘§ØBÉ	¯\n¼5à@Â˜RÑ‚	¹€Š‹Y˜%/°„ÇPÒj\$FÆà†#g€èf)•ı¡†fyûŠ†DÉÉÒ{‹ˆucD¦J†‰.S	IÌ!„6·İd2rX:·8ı’ä™flö›¸+Á\0P	áL*Hø(WšAW(|ÏJbÉå™*X¬AÌ5¬bÊôjKp“	…'\$¬à9!œ9,’&NJ0S\n!0ÕOVV„‚0T†Á•6´l‹rcshŠ¿¨	êALÇU¶Ë\n š(‘:&Š‹:\"CÃz»8gõ3aÎ\\°‚Ñ•o4¢“GÙm&0AÖ”‘\nVq“INI4´ĞŒd¤9Ì\r€¬1PÆá¹È#Ñ„´Dã:KÉ{J”)×ÒbŠFˆ›3Ğ\rÕøJB¨TÀ´däZIM‡Nı8¦ÂÓ«U‡l	J@\$û\rYu%'ÈÅF\\€Qx/U}R¯çÔü\0R*5ÊTÂU•ui\"§U°«Ê¼•\"½–±î¤Òšr˜Dja¤\$Äx™°Ò0ÅÔÚ7d„%DÒ¦Ò\\ÉTĞİ“\"ü’Jı'¶’ÀVskiŠè‘I‘•+oRĞŒûW\"üöáÒ‚D,—R5^P+	.uêÄ˜»ˆuš ";break;case"ja":$f="%ÌÂ:\$\nq Ò®4†¤„ªá‰(bŠƒ„¥á*ØJò‰q Tòl…}!MÃn4æN ªI*ADq\$Ö]HUâ)Ì„ ÈĞ)™dº†Ïçt'*µ0åN*\$1¤)AJå ¡`(`1ÆƒQ°Üp99UÉ÷B…[“Hiˆ[½xŸ9Õ+«ŠA¡£°”´FCw@ ¡ˆ«Í~UMÀ­Õ”Ú^Œ_¹PªPU×!É ²•ÙF^Ç!• UĞœR<ƒÆÔĞI'2mhæK,/PÄ[™P©t¦Rù§W^°X¥ÎEúvª˜u:ÕkÂLç[&|	®ÏW¯~Gºë×*)Aåí¦‹…mÅŠä©4ª„¡TO;%é~s’…C²\\§10G\$%R­eK‘8myC±d~„©²\\¹„#¡%{A¤	Vr•åñÊ_“éLŒ«¢Ì(ªCe\$\$ÒÈi	\\se	Ê^§1Rºeê&r@I	FÆd	”	\n@Æ°² œ'H‘FÄº-:êÂ´@«Šò˜±œÄ©`ª’éy.RœÄÊ\\àó¡ÊDN¨K–œ¡,¡U1	)ŒdDK•ç)<E¡p†AÄF¡%U%J!1œ<AÈêäMåñSOÒ°„0AJpÓQ#Õ!ÊH¬DFADMEB8A8T!Y¥åpñœäÔk#heŠYI@BœäÛfÙJáÌD\0PJ2)AK—UŸgİ! b„è¥å!8s–…²]—g1GÒ²utÏåµøB.\$Y+nGI\\ÄT\0s‘ñr³!L³Äô—ÏAÔşCH*-9Hò.…ãhÚŒƒ#TeıÄ9ÇExx0¨¡ñÒB‘³ú4İ½D¢ôã}§AL@¹Œ‹&ÊÍépJ™Ä„¢:ÊİçyéĞTµ>‘¥FI®@Ë\$·.êÚÓvs’1Z\n[ˆÈ\$\"HÒD•&ª&´Ö\$ú…Ãkíá8D½»ÄÄ®J»^Û·³ìIFC`è9R´ÊªE™ÎEÇ1 Â›Ó^Ä÷\r£b\"¨eEtövšYÈI™c8’ó‹…1¦qöô@ÁœF«qäg)|ÈEd1t%3M´ÊÒÄµBÖŠ‹]»º¯+œRÆ ŒƒhÒ7£”„’“ùSMnv£5±DŒ@±²ã*ùJh(E‚r±0P™Ø \rÈ2†`zƒ@tÀ9ƒ ^Ã¼Á…ô¾·Úƒxrà¼2†æ`Ãpa¦ğD!'%³ƒàR¥EÙ!‚Ü„“Wxl‰€Ÿ9\"A?ªòîK]Ë¥+kdZ=‡,ößòÈ‘\r•v¯Uù·E)ND#•Qù!LH8Õ?òBù„	p6Á'`¼ğn¾Àå!\$„Á”<HJád&Lö1Ğ(Ä(äÂ,ÃRİbCŒGA:ÄÄPÑÈéÂ‰á7èS™PåEÃ¸zîÈ™0r\rŞI¦Ä¨ÚÓn{„¹[™ Ÿ<TNñN!Ì+Rœ®{\"\rïD¦õ%I¨[£˜R¬1\$\\‹¡v|hU=¤T’RXèI­Eû8ƒ¢‚€H\nrk8)²“Kğˆ(¥ú-ÉH£t¸‡B® •VyĞ5Ä¸sˆ‘rqƒ¨G168#…)ã(MŒXQ»'´¯Óz} t0lIXĞü¥5S\n)Oi)–BÈ8¤DæâÉŒF]q2“ LD’Q\$k2ÚoÄ†ÓWˆ#„øåmµ ˆ#%+©ôú,&`ùÑy‚*‚S\nA„¨åF¯İá-¯Ht·ã¨C¦•–.`±ªuRªè|Ú¦¨˜\"hSÈbSXIIÖˆ-]|‘œ¦£’&9ECYîRX6È Ü\0Sè}QÙ¾ÄRlÔ9DÂ­+ÊªDêè«çu%ÁÊ(¢· «°ØÙ|¨Ô¹»“H¦ë\nååœà	áL*–h­PÛÄ­â’¼w’›Šm¶C(mØ(APMØå\r­-¶²™N[Œlm”W#ë“níëk°fÃK(£-.Â\r\naD&W¢±¤¹,!*Î-Db%%ÚÊYè´V)°Á`²ùc¢U ‘:±Û¬¶Õ>çæiÌ(ĞÄVºÙ6fìŞ›óƒƒ`c(¸	J“@h….¯˜irQQMá¾8\r6ÜÜølvIÍJQ»>&\"ìê\$:10®^&åH	 ª0-\$í|	wk#V\\\\İàÁñ‰s&%›œŠÄ˜£¾–ñ£Ë…\"5ké4(¤ü3FpÏCe’x¿ÍQÖ!2ï1¼ÎfwÑê™ ª#‚_|G´a¥ÑD‡Fèı(|Ï©	´êÔ\\òc{å …¼Ha<'S.ÌE‰±Q<9…Ã¸Ğ3¬„,¶`êUjœ®mİÂ¸r¥}/ÄÏsÕ\\XxÒ—g„¥Q³S&ß@CÁMg€";break;case"ka":$f="%ÌÂ˜)ÂƒRAÒtÄ5B êŠƒ† ÔPt¬2'KÂ¢ª:R>ƒ äÈ5-%A¡(Ä:<ƒPÅSsE,I5AÎâÓdN˜ŠËĞiØ=	  ˆ§2Æi?•ÈcXM­Í\"–)ô–‘ƒÓv‰ÄÄ@\nFC1 Ôl7fIÉ¥	'›Ø\"é1üÉUd Jì	‰”ş.¬ƒ©æóüeiJ‹ª\"|:\r]G¢R1t…Yš•g0<ÉSW¦ÂµÓKå{!©–fëÒÚö–eMÅs¹ıÍ'Im&œK®ÙœÁèÓ=eš×\"±r'š´¾›Q+ÚÅø’”„Ë¿ğÁü}„ş-ÂÕâèœî<“^ûï}nnZ,ó:ÏK<Õ©è;İ§SVè\"­z¼Ÿ©Ğq=oúÛ³*#Ë\0¶LD•¼‰“¦Î¶«SŠ¼ä:÷-JsL¶\"ìÂÔ4MÚi(N\".Ş@è9Zë7ˆËŠ“ÌBÔÅ´Ï»€´¦ì”&ëèªVŞál€7RR®ÇrÂ–ëF\næÓKŒté“-Y(ŠË°Kp¶DÉóLÎ£*ëxú#	“ÜŞ¨¬Š«Sj2S!‰’RÅL,˜âÎ*´ÊiìİDO/³­ºÈÛŠŒÃj\r¶1´ŞĞ§É—K¿Ôìï;hÕ ¦J1ÓÕñJR-E#ÑM;¬Ÿ¥-jÊ 'ôÒV§FmÔzâÃïD:¯GMå6Ò¼òŒˆ¬`›ÓT„ÓJÔO(H…Á gr†)“÷Qo\n÷DØ•\n3)Í•aûÈJ¼ôš0TµÙN©T\"PÄR’I(I[İ<S³m›ÂÖ„4Æ¤Ô/Šâê\röö…Òóº-ã-¾D.·é>ªa\0Ú:c @*˜|9£ ê9\rÁ\0ÃœŒ#ä0!à^0‡Éa™cxÜ3\r#>n2èZ\$Ä\r9Ê§\$¦”}’ÜJ9KiiÔJÒ³©ëúõîšL®*´µa3(Ù\rƒ å’¥Óğ›Ø)º/(¦‰M4µH)ri:![u­C¨é”µ7o8Ö‹¾Jñ9m:ÉKxWÈC¬û¥mG!¬§TüZÍµ½¥{AÔÛ^#uM&˜Z@©[8Ë¦­FšÂ½ƒVœCÚ›ï“s ƒØ×—Pô4ÖG~êËî¼»#.#ÜŒÊ\"È6ê£(å+Qİ|ÛÎ?ËájÒRè›³S·—ËÊV®šÀœæ\0ÑšÁèD4ƒ àÁĞ/áŞàÂõŞÈrÁ¼9p^Cp/(0‡@ÒÒx\"Ímc¨³nFMãòQhÁ¨´V(nzÄt/5„gÜsÕ*öO‹ÕZ–¢2mÎ™¼¥u8IÛ£R‡‰~¢.ß•y7FNÀ âºáÀv)#C¢ÄYï‡§Iº‡\\ı_¸e/íş¿ø\0à,{¹í@¸àˆeÒ8/A2‹pÕ&¡Æ¹	aYYQoM1CÃŠŞÏbT'L÷\"2ùßS£‹%¨î›6Ãb5:fÕ?Ç×›ÊÂÃS%EÂ×Ú¼B)'ğ„¢Bù¿¤y%…jÌâ<¥Vóœ‹ÁCå<W‹	^‰5Àˆ8–á!TT/¸I;¢.ÚR¢‹aÒ,ôÚ*’‘'Qğ­hœU–ÍÄÅHqîh%æØªf¤³&ë­<@\n\n˜)4Êêb¾sç,\"ş~QRb<D¼EÜ›%(±P …–tÍC¾-ŠáÂ·Iª›»€7NñP:Iòó•Ä4 \"\rÕwX&'œUyˆÒjVÎîÔ[MJ¦C\"’2ºÏëÎA®+Êck\"¨å|'Yå\nLtİä¦aE¤0¦‚3Ü¥B\roë’ÜIV´áo‘—Ü%fËjˆD:HÒx–JO¤(Û’¹€§ñ4¡+Â³‘W}La8…d]IB—”X!Éº¡å©÷\"ZYWbZ<J	ˆÓSIÔù]j¬°­)'}FÊĞ£1í|/ê¾³ŠóÔZ5½§¹U¤†Yg¼µÊ³ÛIµs„ Â˜T\"¤dÚ•Ú%E¢eh‰ñ&ŠÒP›…sFá%Ûš.ğJR³AÀ‡ÜNm}±¶vbÛKÇMéÅÉ ³ñ6ÜRV¦¥½qYnM«±»A0[Jù˜2mÔCE5=-KJ!*¹6ïlÊV³2®¦„ ¢Ş	(JêÛ­×^”éZ›xë´Ó ê\0M+)G\"²ì 9ä5ƒV¡ZÈÕÅ¡I[CH>³jpÆÍˆ„«@çxë“:yÓ´l=jâWZ„©¥×bÅ~ÚºïÊN©Ö˜!· Ø\nçúş¾]^¢/US!4½RjÌIÒ€“‹TW[õğ›ŞÔD¨T© àÓ,¼Ağ!'SIılYŠ¾›£œDŞñİ5ÛTgí¸™!ß8øÄÎibS¬v³Öıpv0à\")´MğEˆy¨À™Ku–¤–íÒ…öÓv·bÍÃâ?ÔâUc§Ğ6?Qy?DœP«hÂ]h§¡¡„.ëß7VÓ<[w•2)Æ(½ùu/\"BM6@š1aÅ`›¸D°VI›‡PÍÂøY´ĞRu Ãµg&Z%EéãŠÃ	‘+®¹¢©-Òe™éÎyİÚâg5ÙI-Úì]ÛÓn˜½*MöÒ©pDX";break;case"ko":$f="%ÌÂbÑ\nv£Äêò„‚%Ğ®µ\nqÖ“N©U˜ˆ¡ˆ¥«­ˆ“)ĞˆT2;±db4V:—\0”æB•ÂapØbÒ¡Z;ÊÈÚaØ§›;¨©–O)•‹CˆÈf4†ãÈ)Ø‹R;RÈ˜ÒVœ‹N:–J\n¬™ê\\£à§ZåìKRSÈˆb2Ì›H:ÖkˆB†´u®”Y\rÖ¯h £—ô™½¥!a¼£±/\"’]«díÛ¢äriØ†š&XQ]¨¥Än:ê[##iÍ.Ÿ-(ÌY”\nR—•ÌO)i®¥ıgC#cY¬çNwÏæôú¢	NL‚-’¥‚\0S0&ã>yZìP',ÉlŞ<V„ÑR\n£pÖ7\rã¸Ü£ä7IXˆ0ƒÄ0c(@2\rã(æA @9£€áDC„09ğ€È “\$«šÃçaHH­¤ÁÖAGE)x‚P¦¬ïºàv	RX¡¥ê3bW—#ãµgaU©D‚Ì¸=„\"øV3dñ Ób’SËÇY´·‡a6á'Ñ0JIÑ`¦ÎS «A\0è<òÌK±\$¡(v…ƒÿ\0•2ËbSM+ñÖöe‘v“b(¸–ìÙ:ÆI	ÔZÀv…å6ò\"§U:†1ˆÙZu•EKÈS‘ˆ¹I;A(Èò\r™hİÓSXA b„˜Î¥“˜A‘+áTT\"å”JeXå8„©{-­+ZÌBiN¡Âş¥ ’áa/,äàtu–Ä t‚ âØó\"èZ6¡hÈ2/ÃuDqò	t]DìˆEÈÎ\$“^Ããhê9ÄAàÂŸÃÊ:£”0äğpÂ<‡xÂ%xö@!ãpÌ4Œù(Ë–åñ @ùÆÒ9ÂÃd4Ÿ„7hº<?¥i(ğ:£pæ4æ£šWZ(¥Ø6ƒ’Í\$¤¡u¨”ûBÕ9'a‹SM[W’«ù6AB Ş7„nP<„®¬:Œc<9ŒÃ¨Ø\rƒxÎùadü9pÎ0è}¾¾c®¨aN·¹³{¬ÜA¡øybê«SÔ²òP¨4e\\>3iXÛæ3„È6¾po\$1ë#HÉ„ğ@4dC0z\r è8aĞ^şÈ\\0÷ş#á~ªÃš`é¬\rÁxD|°§wf;6B©Ímo\\”uÉ §ız¬r	Qä-ÕV)Å<oKrE^©!%Ô0Õê*h± ÀğK\"Eï\$0¼·šóŞ‹Óz¯]ì‡w¶÷Cr\rÏñ>–¤Õ³è}L€\$†ĞàÑƒkUÁŸCèz¿ñ¿´4QJ\roĞ¤7BVÛŸ™1*	¹1›D€…I)\"UU+‚Ú×]‰+vhh0†7ÎÍA\0w\r!±Å†\$4 C“¸På_†Í„pĞMÄ¸·ãĞ\\j‡éø4!¦‰A\0cƒPè4†ØÖˆB19§Ô?òR‚€H\njIPOI¥Mc°\\£§ö`rS*©¥C’Ít)ŒÎí?7ÀàƒIòhÁœ2«ôNƒ¢hh€7¢)ãC¼½‰ây\n¡v:ÄSjºÆ)\nÈ™úƒ¡Í8f~‚áüG\rÁÁÏ%’¿á 4†0Ğç;ÑºB! ÆXØe™s6gÍ@Â˜RÄhC.‘nDñŒ0R@CdId9Š@´“Å2&\0€öÖ\"•#\$Èšb6ÙÈÁG¨ı~Axë¥t'À ‡‚–èú:ÈŠ¤z.‚I!¼:¡·1\rÑ\nv!öDCªDA™†×{\nDáAaÆ¡™	0ÑT¼%a@'…0¨yQ­QÂAJa®\"õ¶@×ZV‰&ääÓr)ù­BÄX#²@Òu\r£.¦œºw©òJ´0¢Ñ-m\$Ø#@¡_‡h†u°\$KŠÂ\"DÈ©‰Ò°öà_Ô#n#4tü±1i’±1JnÂ\0*¬Õ«©‚ûŸšao\rZ²k¤öÎºD³ş®¤­¤\\«ƒ® ¡7K•|{ÍÖQ±ZæÜû¹tÀPCl!°ÕÉÚÚK'ÚGUjßbiÎ\$°ĞÓc“Îq\0ª0-\r-âGwu%à#F’òÛjAÉ“¹\$×˜óep˜‚ë7Ô¨Êá±HYˆùøN†˜ûˆƒô:… €:‰xvÁNgL¡ìWÑ’š·E ë&»#Ö)Ä\r“•úáÅ†&Å`c[¢Q[ˆâM«¹¹­Ué|QáJ-æ]a¦@EeDlgq«õLç»#˜B¡‘Öª´[Lß‹*Ø,Åâ½Â\"Âğ®fÜºW\\ĞğY‹Sğ~‘ÙtC0ûh(ŒW˜tØ™#ÉDkFZ¯\$ğ¹-5«¥\ri²4kU7›d¥HB%ÈĞ";break;case"lt":$f="%ÌÂ˜(œe8NÇ“Y¼@ÄWšÌ¦Ã¡¤@f0šM†ñp(ša5œÍ&Ó	°ês‹Æcb!äÈi”DS™\n:F•eã)”Îz˜¦óQ†: #!˜Ğj6 ¢¡¤ÖrŒÁT&*…ˆ4˜AFó‘¤Îi7IgPf\"^° 6MÇH™¥Š³”Œ¦C	‡1ÕŠéç\0N¶ÛâE\rŞ:Y7DˆQ”@n‡,§hÔøË(:C§åĞ@t4L4æÆ:I®œÌ'S9¿°Pì¶›h±¤å§b&NqQÊ÷}…HØˆPVãuµâo¡êüf,k49`¢Ÿ\$ÜgªYnfQ.Jb±¶fMà(ªn5ææá”är²GH†¦²tË=Œû.Û à²9cºÈ2#¯Pêö;\r38¹9aìPÁCbÚŠË±f™iºr”'Ê†¡¨¨è¦5£*úÂò?oì4ßˆÌ`‚Šƒ*Bş ¢ ì2C+ú´&\n¢Ğ5Ç((2ãlŒ²¨ P¬0MB5.í8Ò„¼‹Òø5´+*O+KÒˆµŠqÈàş˜¥ğŞ— ¢‚Ê‘\rC«¾À\n	ÓB;\$ğTî4Ï.úFµÂJ*PÅŒ*êÖŒĞì§@M!I##:3KR4˜è»CË>3\0PH…¡ gT†®hÊ®¡¬89£)*ÃJşò	‰(‚ŠÃ*¬9¤ˆ(‚:<S#È¾=°\$Bhš\nb˜-6Èò.…£hÚŒƒ cÙ. È¡ÊQ\n\nšjO‡ƒ\nh8Êäú7Ãî0!à^0‡ÈíãyˆcxÜ3,Õ¨Ë`\$4ú&Ò`Ö.8rÈú­-k-vb÷`Ê<.ƒrEƒD®ã–Æ# R)[2”°Ë\rã0Ì6-,\\ûHs½Æ:OĞÎÀ\nƒz’\rÃÈA=VƒÆÏc0ê6.zÏ‘8å£9F™Ò#jĞ:®@æ£¢QŠU¥æzïÃì°Ü¡ ŠÊ6ù(¨Ê>	@Í‹¤ë@Î#&¼Z¨Ç’\r##ì^,›Œ3¡Ğ:ƒ€æáxïÍ…ÃšArÈ3…ë^ö-(®„A÷PşoØfî3ô&êSY¢‰C¥˜Î¶¤ApA;&\$õ\n²ĞÛ.ÙHâ=?qp\\¾£Ààß/~4qü'ÊòüÏ6;ó¼ÿ	Ñ]'Mä9İÖ^bHÚ8.7HéÙaÒ“Q9´ú@òPHp>Í¹Fné	G%X<¬SN­H°blçˆ(V~Nˆëw2Á„1º£èÈÓPFZ&ö’’‘!˜ºö’ÒĞcNjm©‚@j\r8h2ÆÉ)\0ÆqœQã\$¬”ÄàÂ‡Pøi\r!¼¶Dc.°3h® ¢ÔU’Š]\n (D.ˆ Ñ²\0¦\n‰äoÏõA“8\\C9{AH ”£0‚I)ïdƒ\$e„H”4mmeºÅĞ\\ƒËv‡G\r6’BZ[[5\$7ÁbJD;šÆifrjHËI8|lÃ›6¥ÑâòtS\nAş‘\"Ò‰A\0B_\$µä7îpÈ´'n„¡s¥äj‹á¿F	då‘Ğ¬oŒ*@]¤€‘BLJ‹‰N%„6¥ÔV 4K§a„ŸIy/>e²P’@ÃÉ‘%% ™R”‰¨5G8‡S>‚C1ø\r®ó8¹&}•0äÕ˜âGBƒ‹/†Ñá„ğ¦\$4Æ\rÆ80êI&Üë4ÓtÎ0Òˆ€ K¢+N”—;\r`å™³•€Æí‰Úï?5±Ëe9ô4dmÏR¥\$Y¨èQ	„\\ÎÅÂ0T‹²í\r?4†¨ ŒàûÓÊ#©]Y¡ Uã£E¯!\$H ÁƒYÔps]ŠĞ5«ZÊ“íl8r½K¨Êâ€Myç¾JĞFl‚­¤¢Â˜Ã–@lt\$4†0Ö5FÄ–FÆèKÃ3F;\$Ş¦®ã‡)ØU\nƒ†0áçPg#¶6Ã¨²\"DÏí€¶Š8‹\$EMºR5øÆ¢;}n\n4}\"\r(Äsø¹H±q.dMàäæm\n¤ø¶†¢FCƒ¥›HÁ[‡’ºŒÀT@/ªìƒBÚ_ñÅ8åøŞ_\"¬WCiÁyhL7ËÛÔ¦Œä…må‘9ÌĞ}En’0Ò–,ç›õx\$é¹\$ ºë%=4óú\0U»­!ÍN6Pq-ÄTL‰†X:^Ï)Àf\0\"’–K[òÆø€\$ªñB¬Hµ\$.IvéD<%åN€·PKÖüNyl\"¡Àå€";break;case"lv":$f="%ÌÂ˜(œe4Œ†S³sL¦Èq‘ˆ“:ÆI°ê : †S‘ÚHaˆÑÃa„@m0šÎf“l:ZiˆBf©3”AÄ€J§2¦WˆŒ¦Y”àé”ˆCˆÈf4†ãÈ(­#æY˜€á9\"F3Iºt9ÁGC©­Š¡‚›ÎF–\"Û6‚‘7C8õŒ'aĞÂb:Ç¥%#)’ø£‹D˜dHèoÍ±bÙ¸Èu”š¦ÚNŒá2šŒ1	i‹@ »›ñ¸ü S0™ö¶ıÿ†ŒMØÓ©Ë_näi2¹|Ï…·È9q#¶{oĞ5˜M¦ş·îaÅˆ˜t™Ï5_6Ì†Q3½¡2¯è€€Öb†)Vù¥,Ã¬HÊÁŒCØ÷%Ã€Â9\rëRR\$I‚Ú7LóüŠ£ãsu		jîıµCj\$6¨CšŒ–\"\nbf÷*\rûÂ4©åàÒõ0mZ å	ºd¯\r#Ö¥ ¢ö½Œ P¨bc\\…Ê7£(è½¶O«î‡5LhÒ×L£æ5³éì½-4\n(Bp¬šÎ3ÀP‚:i#2‰\"	€İ‰C”œ¤é’à£ AÇ˜DÑhàè4ÑôUIBRƒ\"àPH…Á gP† Pš¦\"„›ÎôC(Ä5¹¨p@îËTØ–´3õ[èûET;90¥\\ÍHi'TÒk\"æàŒ# \$	Ğš&‡B˜¦ƒ \\6¡p¶3Ü8»bXÖDø>k¢\n¡¥ã«Üƒ\n†RÓšå½&9#ÈxŒ!òSxŞbŞ7ÃHÎæŒ·ş¢.Z‡§xÙİ‹Ğ@2±C/ˆcW`Ê<˜âgƒÅÎ-ùCGcd·LÀQŞ1?#›fF„šR)¤‰2ö‚Ã¨ Ï!±Bô!Óê.¾Å\rZ>9Æë‚Í	È(“\$	¨¸Î¶ÃË9&1¨TTT7@Y,\\èrÖ‹Ué)~–¿:NŸ¨¢åª¢mF±­k’ÒÌ‹ì†Ç²¢öîÑ¢\r:6‡íÄ™¸éÈ&é©îëVòod·?ïÚ÷±-¼!'næZ “q#šjUëhˆô3ÌÌD‚)Ü+f”Îc,²ò\\=ü:#&Æ’w£²ÁrÜıDÑx%ÃEê3¡Ğ:ƒ€æáxïï…Öo9ËĞÎãxÉƒ°cN„AóôÊÃšv7ë ÒÙ6ˆâdD[»4\r!‘ù‡7zkË!1\\îÌÙ¢\\ŒÊ{£!Ä¤&›6JkvNF\$Ñ°ä”9(z\0éW¨õÃÚ{yğ>\"ÚI(r|ï¥‘²PÜÉÃsğ^a\$6¢PÊ–CtC©iû’ôØe‘k½&íLùÁ÷XGÍË”\"\$œ÷ô²gÌ³;I… ä ‹QM–)‡5RÌs¤Wë¦'ş„ hB.t'§XlË3ˆqG@ˆAÈ1®(”0¢w L1dÀ€(€ bMÔ]Aå<U˜è†‹\"&-5Cğ@\n\n)ƒ†2ÄÊ[L¦,Åìî–¢úäğp/K%£`Ğ‚1Ä¤ƒ·b¢_&ÉY–€ÈéËbîá8±öl]¹ƒB84»ÓÃ2 ù#ñJ·ƒÃ/¬vä@!…0¤À¾MİÌàŞÛ*Åè6‘õÊ¬Èn#ëÔ„†–vlÜähO¤Ä™“QMßéunjIß’@ŞÍ(¾~¦±Ì;–¬ßHËS\$¹\$8AWNŒQÁ~4 Ü¤ƒÄxĞ¼9;Ó¢ˆâÅ\$t´ÄxRoanà'…0©¢Ád!–’:N—Ğp\rIaºµG,ÕÓ¼ğ’¨x˜qN\$K?´’Ôyê‡Ä	ş`ì%…Áñ[â-%%}~–¬ELËx#À€)…˜F‰a\$\$Œ’’s´nÔQ4–AÊ‘“>…Ô)î\"²ÊìRú5Xã7bTšìRtàîyü±Ñn’¤AH+!c€J´)AI¶§içõ©C\$rÑZÛKf,øL,\0¿ÉYìEì\"P2õàDtÒØl\0¬³:„”œIw‚ŞÏ”r[#d\n¡P#ĞqXˆ°“E'‰ÃÙffIr4¨ÔŞk‚F#Åê-§Í³ÃËaoŠŠ½nİ'Â[(ê¦‘ªÚZÅ°RÌ›L¤L‡Vƒf—©–•äbĞ`Yº±®\nÂÍRÍ–¨Í‘Ài\0Ÿ[Ğè	ìA7„ŒÏuÒ»¬¾*!gÖAŸF½xiDdAz‡£\"SÎBë¿WÌ0©SI‘uò4ÁÕruÌ“BYñ-ØP\"“+îĞ/r‡TéJ¸˜ã!Šˆ(T¿ÇĞ)d„íJÊSw)RI`ÂÍ	ÊwÂw®ö^Ûİ{áİğæˆ`ùŸD9BXì;— Éƒ˜>yI‡¶#<Ã•ÁÄ@»€èıÁp";break;case"ms":$f="%ÌÂ˜(šu0ã	¤Ö 3CM‚9†*lŠpÓÔB\$ 6˜Mg3I´êmL&ã8€Èi1a‡#\\¬@a2M†@€Js!FHÑó¡¦s;MGS\$dX\nFC1 Ôl7ADtä@p0œè£ğQ¬Şs7ËVa¤T4Î\"TâLSÈ5„êkš›­÷õìäi9Æk•ê-@e6œ¦éQ¤@k2â(¦Ó)ÜÃ6É/øùfBÂk4›²×S%ÜA©4ÆJr[g‘›NMĞC	´Å“–ofˆÖÓs6œïø!”èe9NyCdyã`Š#h(…<°õHù>©TÜk7Îû¾ÈŞrŒ‘!&ÙÌË.7™Np³|+”8z°c˜î÷©®*vŠ<âvhHêŞ7ÎlŸ¨Hú’¥Á\"pŞß=ëxÂÃiët<(ĞèÃ­BS­Â’V3¦«‹#Œ°ûœÃBRdÄ+éÎ3¼€PŠ—‘œŞ®c„…\"!€P–ù„	ØØ„0B`Ş–¹+ø-K‹òÌ&£`\$¹éC:A(ÈCËÍÓ„äıIPÆ¤@PH…¡ g@† P‡I|P†©¢)ºL˜\$'\nÚF·\nJÚâ>É¨åÒb@t&‰¡Ğ¦)BØóU\"í6…£ ÈS4Ú\\ùÍ¯ÚL±àÂŸ‡Ã“œ:MÚmÓãÈxŒ!ò3_XÒ3\r2%…eÙ©óöÔÛO‹ú\rº~=áep\\OİËqŒ£Ã7\$‹K\\ôúÜ6EjÚº¹¾ÍÒZ7ŒÃ2Ú7¨È 2§iT³-²øB9-î„­	¯n¢'C„Ï·cf.¡øRZŠ¢áb	M.xÒ÷*¢Ì²r¥Jç:­€èŒÌl¯Î‚ê•#\"£ ’®iªH³úÒHo#˜ Œ™®9dØÃ7ŠÆ\0ÜÑ!õğ@4XC0z\r è8aĞ^ûh\\œjN€\\÷ŒázdŒ‹J4­!xD3Šë Ûuè’|*¬é“\$^=0¹S ½­¨Ì¦:.x›AÎ\$<Nqœp]^®{\0Ë±l›6Ñµm›vàÔî[¦ì7n×rex÷€ñ¡Œ\nqfı´-3Œ³+ê6CzÌ–&Ï·ŒJérâ5¨£3 ¸Â1¨«H@;ÓHšc C3ŞÎMãÌçH ê1ŒoĞæ3¨Ÿ&·@t'°û¡8ñd&E/2à\\¡¿z†ØŞÁ\"*nÂ€H\n¥‚\0POÁKÚ-L–§ÂRŠc:ğU³0WĞ%†¼±S:\\á3Ú&\$Íï©g¬âJ1\"7¡ğîá`&¼İÀH˜ãŠùa@È!ó†€ÒÉë5í•¸—Âñ	Ò`¥½é @Â˜RÑ\0Ç!ˆ\rš\r­Î?PÄ{àê'FX†sbw™D1èÅ:C8¸CiŠÍ|œC\"ZKáÚ#{ñÁ”DXMC¡ÌCô‡2Vc\"	yqÍ­³Æ0Ôœá66\nÜÃ‚ Ü_«‘‡ÔÑ	Ì%Qª>)P(ğ¦rblõŸ\0@Ã(cSG0œ¹Ânç™E’ä\$æ÷8mVêú0¡½pÅ’Bˆa#Êj8™#¦#<äè:™`Œ Ú'6Æu¥s,“˜I+#) È:'KË9\r°ö~‰\n‰ˆq¦f¢]&tÒ¸è;Údõ:†”Ó?#ô\rA”º¯0†ŠÃ`+e´1±x j‰Ù–y2ˆÈ’r†g!œ†ªİ˜\$JY‘8U\nƒ‚2L2@¢\$¾y‡&n­)j›&Æ°×C’b™ùÕS+ì8ˆ¤‚AÂ… )œG€“cœ7utR³ÔŠõ(!±2?¥©\"\$R·s‰|7“ƒRÔ™:I†‘Ef!2qÒ&Æ`û%s£)jo¨\$¡ à¦¤RRcÆ\"’4Q“9‘@JW\"æËÍét.ÄéÚ4ÌwÌ9/N’š æ";break;case"nl":$f="%ÌÂ˜(n6›ÌæSa¤ÔkŒ§3¡„Üd¢©ÀØo0™¦áp(ša<M§SldŞe…›1£tF'‹œÌç#y¼éNb)Ì…%!MâÑƒq¤ÊtBÎÆø¼K%FC1 Ôl7AEs->8 4YFSY”ä?,¦pQ¼äi3šMÖS`(ešÅbFË”I;Û`¢¤¾§0‘ß°¹ª¬\n*ÍÕ\nmšm0˜ÍKÄ`ß-‘Zã&€ÃŒÆÎ™Ï.O8æQh6çw5‘ˆÖéÊm‰9[MÛİÖ¿5©›!uYq—ÓæoÁEkqŞÅÈ•5÷Ûùˆäu4âàñ.Tˆ@f7N’R\$ÏY´Õ8±C)×6´,Ã»BÑéèä¦)Ï›\$ó=€bá6‹¦÷£Âh9©Ã˜t¢jB”‹¦È£^¨K(É²H«È¾£¢X8- Ô21‹b(Ã¯CÓª,ƒ†7 ¢rä1kûN§®ã,ó½+rt2¤C2ô4˜e[ˆƒÈà‰B(È4‹´—ÉÃs^6¬pé®Ñ ‚‹\r¨bDåˆHhÔ¹Ìüä	Êpê;¨(ÔĞ£ò4\"#CËƒPÂ/lˆH…¡ gJ† P´—¹K«†9+è¦»#Q,è2ËnH Œm\$¸%Ã4€ê	@t&‰¡Ğ¦)C È£hZ-V(Ô.²J’F¡¶Ë•Z·2*(@•¢\0x0¨¡ôKI«`0U\0òã|’ÚöÈ†ªJC8ëÜ—48 ¦ª*J)´C\nÚ6^oB » —Í÷BÖ\\3yè¤½\$¢bş9c`è93Õş3Èj÷{­ÔıV3N#dç¸hcŞøÕÎ]8NC‚½:a`@8'ˆ’Ü\rãƒ;?¢+Ò÷z£jô:¾Ap*:ËæNù)ÙSŒ™rò7f9j²¸ÙÎw@YóƒEhCsäËŠc¨Æ1¢c›¢×ÓÖD’ŠƒB,5¨oƒŒ:Ã @ Œ›\nİ™j¤0âÚÃ\nÑŒÁèDÑÈt…ã¿\$\$;ğä.Ã8^‘…ã\"¨™* ^ÜôÌÒj—ÎÌP\r³j§(*>Ëi @¿¡ºNqOÔœØÚs“.“¿4ÑMp21Ùç*·ÃŒ¼OŸñÜ‡\$;ò›êô·s—5ÎB°¿B7tvÈ’6£Ã,âÍëP@÷ZSˆè4\rïsO\0*KAŸª\n@r˜ã¯\"kL—“DzhM#%@à€=ã)ªÀ=*8˜\n‘/hœÌş#fm\r¨7¯Æğ‰«ò}ğD†cÜBĞbMI=e\$J_Îá`É*Rb—ÈX \n (0GÅ\0Ès4G¤1óŒ\n\n()\$§p95Ò.Ì ôNG¬Ğ4‡`Ò\\‹ËX=Ì¹R„ëı%ä-bJAáùx#pÁ&ØfBáª(§6•&Íš®^ã G”ÌPhFÖ%œì] ªúv1½ª'\"ğS\nA—@\0A£D8Å¤¨7bVîZË¼?¯`“‚T‹Îr*8P ›\"SÒ|äùn~„)P‚\nu…pIV»ÒpƒK†oY\0\" BÃ!ÎfDÅ¦‘³RlƒSpÓDÀ‘³t¿Œ¸P	áL*Ù¢E]‹À'dö\\E@Ö\\‹Ô+-8¾ÒF';†a2Ì9K°Ï<–“\rËµwº\0ÊILÈk6Nu“à@ÂˆL±\$œ‚:GÉ	Á‹Î#HŠpe!A}•SL‰·7˜ëÜA%AOÃ¼ŒÎ!%¥©•ÉSfE)’‚ZI…F°ÈITR`¦‰åTCæ¢HÅB\r¥¢StØ˜ls¼ô»´`pPà~Æ¢<\$‘¸H,ÔP¥ÀBÍ\n‚¨TÀ´#\0ÜàN+09İÆÂdtê2 €ä‚0Å}#Dj˜Ôƒ(CªÂW‡Á–ÀX+ä¡	š„<ÕšÒ€³C*ÏTÊ¬‹SslrÂy¤\\\"Aˆ-_1Iªæ4D=ª9 œUÃUV`ëÀ¥ğ6¼f°ûÏ²ô&L7“ZCpÌˆP›(ä¸¢3øvá)rˆP‰‡V\$ˆÀRŠ2¶Ê™ÿfyÄA‹†–Ğ[’èxeÖ\rh·ÏzÕ)‘Se²3YóM±Œ5„2ÒØ…N‰NP";break;case"no":$f="%ÌÂ˜(–u7Œ¢I¬×6NgHY¼àp&Áp(ša5œÍ&Ó©´@tÄN‘HÌn&Ã\\FSaÎe9§2t2›„Y	¦'8œC!ÆXè€0Œ†cA¨Øn8‚ˆ³“!Ö	\r‡œ‡à£¡¼Ú\n7œ&sI¸ÂlMÆzœÂbš'Ò‘”ÉkœŠfY\\2q¹İNF%ìD¯L7;Ôæg+µš0”YÎÍ'™ÜÎq›H†¥¡›Œ“16:]ï4é0Âg™‚¶Ûˆ©ŸHr:M°ºqÎÿtÜîõ†ı÷é†¡B¨û­¼Ìå‚½JğG–œÖ\n!½ò©¸Ön7èSƒ•¦:D0ìLQ(YŞeÑú9ç3¬^Òçæ;­#\":+(#pØµ¢a\0Äñ\rmH@0ÉjôÕ&‰²iò€¡#M|:	É(ÚÀ¾(@æ\$ãHÈÁğ-¦LÜ‰Ì è;'ø2¬Ì\"ÔğB	Àè<\núã§hÏ\"<iÂÜ;\rÀP¡@­Ó˜ß-²¨ œ2HPÜçbÛ.+£\$<¢€LÛ7¢ˆ(Ô0HPÒ°^\0H°Iƒ¾4ËK<6³I¨èÁ?ì¦5±o0Ê	˜É®`T6IãsOL	Ğš&‡B˜¦zL-´õ‰JÓ‹´òhßŒğ„	\$)Ø|Ë£’„ÉÂiÂ<‡xÂ#¶„!ãr43Ø£-›gÃŒ48÷¨Ëºõn´ª\rÄ…×-x2 Ü‘Z±˜£\"¼ywÆ#(Z”\rhĞ˜-È²7«Ã–3Ôâ˜Á'ã®&Ka\0ëGŠƒxß^²sJşcğ9ŒÃ¨ØL«eŞ4Kn0­¶ôæ6­¸˜ÊaJ:*™.LßGƒ`Ø<©c¢:*\ršBßâIæ#&`…Y@ÇxÅÊM€\r	˜Ì„CBV8aĞ^û(\\ÆiëÚÒ3…ê^û-ÉEª„AöàøÉÖİ dÀÖçâcb`89áhA{ÁPdÉˆË¡\0àâ\rÓ†„\"W¨[\0lğå7)<¡¾²2ëzî¿°ì{(ï³éËnÔ9m›uÙw^véa	#hà½Dóq½BQ:ÊÆéàÌÒ¸ƒ8Ô˜5Œl02j'¾ïáj^\\%hXÚâÑ³X9Òƒ¨É7qå.†ÍBcä¡éL…É#—9DópÂ3^¨ ëãùFÉYkí “¾€æQ8 gé’ŞˆË‘t(LL;5Rj¥à‰uB†´Î‡B`ö^ P	@ÁH,†ˆX('`¤¡“•øòŠ	tAeĞ­C^ú’q'bçp4ÁRô]!ÿ4e¤&ÏI~fáœ<†ÂşÒÒë:IÍ)ù™ æ–«ç)0Ñ†€XòŞ€d,¶‡&ãs`€;†€Òà#0íy÷ÀRÃu&Ñ.&Äó|Â˜RËì7ò„áŒª:5† ÊdŒ!†¸‘òŠI	1“6,øŒ“@è”ÊoaÏ‚8WPaš\rPË|¸0òÁ\rj.ˆ¡¼ı”İ\0â!3!ÔüğÌ{I3Mm0¸Í Æ™I´ˆˆ\0 ŒiH™¥W&ÅŞ†wˆdd’%Ç¢“4àD15Ì Ù“™VõÉ’.¯•ĞÖµVºÅ\"Qaw—òfßáé„=åx5¬‚\"QÑYBSDœ…0¢idpV/`¨Z\\wJEæ—Y‰°raÆĞ#]JHs;\$QÉÑã]hpši¾ÅÖN`9…K¤u9˜·Èià¨r!í	9&êlR_-9§pÕ†ÀVĞYqÇº°âşÒ*aª¢²Rg!õz÷ôdT*`p¾Ã(g<Á¾?SJ|c)A#RSZ>NJMj­„t%¬‚ÀBÙét.ÅáŸµT”»OÆ6“IæµL	Æ0\\ğ3Š_¬X-BóX…¿3Lj%µS5òÍ†š8mj'+Šèês®Ú¨\n\$GL\$BLÏàl64‘6VpÉOSQ:áX·†uÓ*U¤†µœãDÎ’•s€†W¹Ê‚¡²gÔv·×óVl@e";break;case"pl":$f="%ÌÂ˜(®g9MÆ“(€àl4šÎ¢åŠ‚7ˆ!fSi½Š¼ˆÌ¢àQ4Âk9M¦a¸Â ;Ã\r†¸òmˆ‡‡D\"B¤dJs!I\n¨Ô0@i9#f©(@\nFC1 Ôl7AD3Ñæ5/8Næãxüp:ÒL £”ô =M0 Q\nkm¦É!Èy:M@¢!¼ÈaÁİ¤â‘–hr20Ögy&*ğu8BlpÆ*@dŒ™oæ3Q¦xe5^of™!hÂp¤[î73qä®Øíúi¡¸èy7pB\rçHÄLíõû>\rˆ¯Òy\r¯+ry;Â¡€¢©Ìë¹Ó\\òb†@¢t0õ.ÚÅ\"ìD)“*a=KğûS¢Š†ãæ‹£;†A*ä7·N@@ï—ƒÊn)ƒ Ü2ŒèÊßMĞÊõ¬èt'êˆ5BŠ:’¥©¢pê6Än3Şµˆƒè—´Ãò‚ŠŒr’7¤K¨Ò—PØ)¡‰¸#Œ£|h:K˜*#‚½\n0	£65Œ RüÀ\rã“¸Ë²\"ò‰R.7¹C`ß5#˜Òä:Ã\nääGs¨Ê9SÀ\"+Ìk2A(ÈŠ1 EQƒSGÑcÉàTvò£`PHÁ iP†2Xô:ÌÎ2Hbh6&,t—2°,˜4®C¢¶®Ë!Š›ë8ß0#ôÔFüB@	¢ht)Š`Sì6…ÂØåkBè(Xc\n>Ï¡KZ~\r«KL)ø|=ã“\$1ÎéÄv1\"ã|’]P¦ŞŒÃL90WÅõi†’\nè±úGØ@@6£`ù¸ŒADˆZ_qâ˜´RVêKl6Jş:D¤Ø@7ŒÃ2!\r¤‚œF‘LØlå: “»’×3ğ¢2¯ÛŒÿ3,–-ÈĞÂ šIf18c€Ş²3hkóQk“‚:9p šÿ¢¡Z:wjxœç¦ãÚ€ç©jN­¬#k†?®Èã«±l›6‰£?»^•·C®Îã¨í›ª«ÍJ6·HkÛö<éœR3«\r¨±6–¡‰ ‰V¹’™ÎïPœÑÅ(ÂÉ¯Xú„@ìÛ÷@@41£0z\r è8aĞ^ş(\\0õò<FL£8^‡…í\\:\r:¸^Ívã“85÷%ÏãR^;#<İjÎváÎĞ–ïÈ©¢½¼^WÖoó¥ã:/LCpê`ù_À.ÙÜWtïóÀxOã<‡``ryÏ@2‡†X“³ÖK¨×+‚G)¾`«ä1tÃqô\\”†D\$OÚzKe\$0“.S\nùGd]ø’ Âù‰rel½ GÌA	¦à€(€ I\náÀ~¨\\=!vŞ_!½!EÍ¥'<KISzs'h‰™’ºêªğ\"fıÂ‡4ôÚœ!şŒlxÊ—sÑzDqé\0¡Š.ŞB.Ş<Ç´Jg¢hPBdt’æ XËjjÌaBŒûDÌƒRÁêG@\n	ø)?ñ¤œã¤&N¡M¢ˆGÂŒhxrŠa	Æc°Ca¨n\r¨¦JR6h`oNLĞöÃ3\rCHdMä‰pH(æ\\Øc÷Wòä˜…~¼ m.¸56Xq&ˆa4<¹f,ÈJä#Âğ†‘T/-‘ñÀ>„ö†YLfQ|„ñaÂ@Â˜RĞ)·C†ùXaBá™2®PØOSo…m¢@ÖƒÑó\\„œ”’²[\n—¨zO¸ÉÀ@¡°™%½‘„¤K;„£|Ü Èx¯Í:uJ\\¯÷]ç!ù\r¡¬…š’zËê oAÑê„–BàEC£A#äf8À ´JYºˆŠL“Õ~…äó!.¦•—åaH…œ­]€°9ÄCUiadŸR²CÈ‰¦\naD&N¢>ŸËxw!(œDæÍÑŒÅ¸`©\"¬Z‹?0yZ7µ\0PR1É–ÉEe¼ ™Ş!iğ<’K4¡Ë…\"íêsRXb«Š´¶fÍ™Ça¥«4\rÖÖrF”‚†³ß=Zpm©¸„2ßÜupŒ‚˜Š	P6°ÖNª)0¢y`C*†!QÅ'§d›’@–a¬µw'DMr§b(…‰ÁiGdÅ«Ø‚B F à’\\‹Qn!İ ²aµ«K)vØ¯õœ§¶¨ASĞÃe03Š\$jPÆ\\™i€,úÁøÊÛ#û=\n3hMìõ÷ XK…-ëÌ2‘oYÏ5A8Yªi]â0I\nš–fNÎ)¤\r7zÜT.Ø\$ÉÙÀÕ|C°ÉâŸIƒ>f¢f´r\r“ÎÁÚ-aN’àgŠPi<Ç¢=“tJHk;x\$ÈaK _óv2g(÷Î(ª’‚!˜½f\"’Œ\n­@PIÃ’Ë°Ótª„ÌùŸ4†—‹1¸hJåë¦n”¶Pê`£Ôß%!AÔ";break;case"pt":$f="%ÌÂ˜(œÃQ›Ä5H€ào9œØjÓ±”Ø 2›Æ“	ÈA\n3Lfƒ)¤äoŠ†i„Üh…XjÁ¤Û\n2H\$RI4* œÈR’4îK'¡£,Ôæt2ÊD\0¡€Äd3\rFÃqÀæTe6ˆ\"”åP=Gà£±„ôi7‚ç#IœÒn0› Ô¸Å:¡a:LQc	ÎRM7™\r2tI7ìÒkÜ&úi§Ø#-ÚŸ”–MçQ Ã¤ÂHÙ³:e9ˆ£©ÀÈa¨l–])#c»s+ƒÃÆ,†óqÒïÂXÌ¸¦—Æèq9W|•Ò=£:IÁE==ÜÎ\n\"›&×|q'o–‚Š§<qTÜk7ÎæèÁÊN9%\"#pÁ0£(@œ¶\rHè‚6¨zÎ‡0£˜î¹Œ‰H ¹„3O¬@:¥°;\n¾ª‰†ZÁ*\nˆ£'¡\0Ô™²ìÊRƒ—CjÌˆPå&ÂcÈ’Çâî™®‹ˆ¤éŒ®0Êø¯\n8•\r({c!¤#pÒœ¶#‚,Ú9ÏRÒœ¸¢+Ù¸¢t¡ÀÃ¬Â4Ìk›ÆŒ´ÏC›8¢jÀ¹ÎJÆÉ%ñüÔ;!R[<ÙA(ÈCÊ ÑTeØCÍ(üA j„8B‚N1³À8¸CeP³`ŞÆ¯Bxå!¯(˜õª\0P‚êºâš,2Œk…j#:ç‰@t&‰¡Ğ¦)C È£h^-Œ6ÈÂ.Îmu‚æ9-¼¹D¶#l;‡ƒ\n‚3ƒ¥Jş%Ëü0!à^0‡ÉMÓuˆnbB3Ô£-í|(\rŠï‚À,Ã}((ú<Œáx.‰)±(ça0ÀUn§° PØğMHÀÃxÌ3=Cr£9HÜÈ¯CkØ2H‹®*\réŠ\\<Ãìˆê1¬¨ˆÌ:¢õrìÈ…åX£ƒÒ9İ7¡@æ¥5ölË*‹ØÛ¹kçŸ¶šP•4Ï»b3C˜¸Ü3„É©,ÚHÆæbò=t´¬àÌ„C@è:˜t…ã¿H[¤\0¹Œáz2§+Ãœæá}Ê·6|ÎzÚ˜<	4„0é0t3\ráó¼\r!µ4#Âë°‚#	ÖkïJÎB¡ø4oÜÂpÜG;ñ›šî³Ü‡\$7rCÆ-as7X’6\rtlæóø”l:&[f%£\\4Áröb—##¢R ¶9ª%Jã**°¶¢ç-¸È¨Icrçğ;†ØEÌ,Í±˜2Ä«ch\r•¡´PŞÑÁ|éDlYãí#±Œs,ƒ#\$H„dèˆ·60©?@@@PAˆ8ÀÃ @\n\n)#= æCÒÑ\r„¥~†æU\01²5F²õ1±?(,¼ªàîtÉIî„F00«Ã,]Ã±3=FÜ”¿òÌùÍŠ„²‚ø8n	¹Û!\$)MÙ#|…ÕÁ(Ä\r aC¬­œ>cøÂ˜RÑØF¤¶J\0E#Dpï¡’æ¹ƒa.Ä–>ÖVNÍKi	\"hM¡Š1¯`ˆ@¦¼s’á},¦).èn†Ò„:(‚S0ƒ@ÃÉ£@émB2øÙ±3Š¬§¡’NX[“ƒ‡ğ1ªä<ø\räsì¬(ğ¦;Hdµ‹¤\"ÑğnHrù%†@êZHù½%¤¼…L©öÍÌ1\$ÉD4–ÔØrÃrÿT±”ëdTÈfQ?†ÕW\$\"Ä£¨ \naD&!˜ªÙcÁRåM¡ävAaškÌæZó\0R†3Œ‹²ğNIM23ïÄ˜²E;©É¦a½†Ã'NM'/ğ=(Ô!R¡]L‡¦ Ø\næèiUt€2‡¤ÙƒœŸ%µWèæˆÂg µW\"³\\ù<†’€€*…@ŒAÁ\rÍÜÅ6òR¤Lâ‡!T ¹Õ0]SÌİB3ìZyİ	Ká?JÌ^%Lå¼°“ğ %fP€£bƒ0yZ+\0Î2ÊsRjK”*ñú\0¢oh)ùÅ\n©¾¯O–Réå°1µ˜–2ò×Hé)	¾‹zÄmÌ¸•ôó…fÑÑøÃL|›\$£`Ñ*›a{)D¸ØlìE¨d_-â ®XaÒXSÛc_Ò¡6\n¡…åÅ-KÁ±³f‚ß»;N™¡ÍU¢Ñ%©À";break;case"pt-br":$f="%ÌÂ˜(œÃQ›Ä5H€ào9œØjÓ±”Ø 2›Æ“	ÈA\nœN¦“±¼\\\n*M¦q¢ma¨O“l(É 9H¤£”äm4\r3x\\4Js!IÈ3™”@n„BŒ³3™ĞË'†Ìh5\rÇQXŞcaª„ch€Ç>«Œ#ğQØÂz4›ÁFó‘¤Îi7MjŒb©lµ˜LQc	ÎNE2Pc ¢I¸ç>4œ°œ1¦ªe¶œŒ·ú©Ê!',›Î¢A†+O_cfÍ”çk…NC\rZÖhÏbL[I9OvÍqœˆÅ¸Şn¡±ØÆDé,›‚¹\\Ã(ƒ—¾ÇµGM7k]€3‚ˆ‘c/_4IÈ›å`¢©Ï&U7ÍÆó¹º094Ã’N\"7¬Sî¦í³`: Ò9Aƒƒ9ëàÈ“Šà@35ĞĞêË„ªV7º¦«2Æk(êR˜„RbÎ³é:]\r©ò õ@®j\\9.ÓÈô ¢\0˜¯«Ğ¤2Œƒ(#Œ¯“Ú¾È\" Ò‡¶òhÌÀ(h‚‹7#˜ë\$/ S  ¯¤Å2/Bš2ÖÌÎ„€Í	ƒzşÿ'©úXŒªÈ0Ş§Im#È½£ @1*°BĞôKl4{ö¨^t¸b\n\r0Æ:Î`RDÁ\$Iğ@6,ì'Rk:&Šœ ˜e:¢í=ƒóWCÎ¾H\"@	¢ht)Š`PÈ2ãhÚ‹c\r¤0‹µÃi]9î£x› ª8@6Ãğ`x0¨áóD:TòX#²\0òã|“Üw(†çËc=@2ŞAo0ûõ3ÌSi#èò3ƒ;¶ô5oDèÈç]àbc<ë £cÈ5-Z:îã0Ì60\n½p9#i»’0³)@Ş—¥ƒÌBË£ŞˆŒÃª/TNã˜XµY•}–?Ø\r :J°P9….(Â‰·”;A­ì‹x“ŠkòÛŒĞö&7á\0‚2i	ö~1¹øœš\\mcD3¡Ğ:ƒ€æáxï½…ÃÉ’ÀKàÎ£!znÀ¨Nx^Ü;zô_·pˆ°ª˜àÌïÃÃpê=£([?k´rèdÂk«#Ğ’#\nÕ¬7.ÑBáÚ4mûçºîûÎö;ï»øÜŸÜ7pƒÄQ‰ñAÊ\$£ƒiÓœ‰u:f[º Ëó×†è8­Òøß(#l‰ErÈÊ×¶ÏsXÅ\r9#®›ëCº0Œ|Küß©1o…®“ô˜»3¬jŒÜ9³–v˜\0{&üîŸdr[¢|#±s8›2Êìƒ&ôDúQ)†yh©\0j~æ4‚\nHÁUFfD9ò E±'^á¹á¿ÓĞnq²~¦ÕCC#npOÚ0J ;¤ÂN| Ò[m=[Ã\0‰‹\$jä¡ı#¼mßL=|ÿ=˜ØªBnÁCs€ÃBß/ÍÍ©ABÜPû&\n½ïà†ÂF;Äj0¥Ğ\\)#‡‰\r—ÅÀa°tÉñ“¦t\n~;¤À™HPwbÛÑKÉä %¸ašª]1À‘ä8IHô€zŒ5„’MR\$(h-õç¶p\r¹¢T¥U\ršbÚØÛ)Çø1ª„@öN\nì˜(ğ¦\"=I¤­‰·âÒÆ*à%†@ê\\ˆù‰%d´…Lu'dÂ\\ä’SœàÜ¾U\\0¨µL¶Ò¨oÓä1à@ÂˆLCq,·Ò‚¤0;zU!¼ƒ4Î}L¡â*¹ØhØ¹¦’¡¥ÇîI©2¥\$)®ÒÃztÙ!rÆ”PŞ·©¬‹<8(Åd[jaÇ¶så¡•‘–’©\0¶Ôª˜·\"ä\r€®j†•JAxbŒÄ(»*‡ZG_JL2@µTpEÌ€l*…@ŒAÁ\rÍ È¶N£\r‚¥UšC*›SÁ¦mq`Û\nùç40¤0‡%¹—Zêìê>’RbÃbA	¡¼È†`ò²ƒ(c4AÌ·º€’í\nµ…„µãèP©Ë Tæ\0005S%YÒß´¦-Gâwk)|\$éÖ…“XÌo¸\n¹•ôô…bÒÃLhš\$£lÎ©yÎz&ÑîTU\rb©õˆ½\n‚¦å®Uƒ \nj¡^Pña}¶Á	Å²<¶Òñ6ö|Æ\\	hm}=½‰˜9ªTGäkø";break;case"ro":$f="%ÌÂ˜(œuM¢Ôé0ÕÆãr1˜DcK!2i2œ¦Èa–	!;HEÀ¢4v?!‘ˆ\r¦Á¦a2M'1\0´@%9“åd”ætË¤!ºešÑâÒ±`(`1ÆƒQ°Üp9Î¦ã¡•›4Á\r&s©ÈQÁFsy°o9ZÍ&ã\rÙ†7FÔhÉ&2l´ØAÎÇH:LFSa–VE2l¸H°(’n9ÈL¹ÄˆÄÎf;Ì„Ó+,›áƒ¦šo†^NÆœ©Œ :n§N,èhğ2YYYNû)ÒXyú3ÔXA´˜ÍöKÙ×¬eÌäNZ>‘³¡ÕAõãó#\r¦÷¡ñôyÛ³qœÈLYN[àQ2lÁBz2B¨Ü5ÃxîÀ¤#’ğ•ˆŒS\$0´!\0È7·ğJÇ‚ğ¤ æ;¯\"V#.£xæ­ÆÃ/qpä6¢ÎÂñ²¡ ²´JÒ DêR`’*	Øèë0ãPÂ• ñ¢.B,‹Ô´‰²»?JD¼ÂÉ229#õ\nƒHàÁ/q¸),ÄÛÈ#Œ£xÚ2h2¡²ãJ£`ÒÂ¸+ÈÌ3KÃM9Ë³ãy?±T0¡®£<²Lè˜7ŒñºL8\$)˜Ü2¬ŒêşĞ5ŠZM»Í(J2|Å:5][W¬ãH<¨ÀT¨\\uøbh²M.ëÊÆÃ¬0ıÿ'C¤1Ö«)²ƒ-^èÌ#¨Ú	@t&‰¡Ğ¦)C\$L6¡p¶<ŞÈº°Û6ÛĞ(	ê£„àÂ Ï90#\n9LÈxŒ!òW`¶-†§éäc J	Û–“_+Ät¾QÎB¦_1İA»cšVÿ(ğ Ù:MŠMU£0Í?SîjP³Ë2>ñÎã{qO1s@:Œj(æ9ŒÉˆÙL=ác€9i#\r3ãubt§,¡@æ¨u¨@;\n@ÆÓéª2V*6:x3dWÚö3„\nr½¤:³µ°êeü\rÌ„C@è:˜t…ã¿\$'úT¼á}@Âëäªí…á}Î±[¾/‡Nò²bĞÅk|„ÇCÀá-1Z´¼n°ìëoöÓ#³3,\rP•‰°£ô†DQ åV*›Ç_¨×\n2ğüOÆñü'Êïƒ]ÌsCw4<G™gÄ`HÚ82³šÉÓã)”è4\rõc‚ö\ri34’Æx5@ó­\rÆğ“'PÊƒ©  ‡X)²ñ\0Ë+o\r™0¹óÍá\$2oñº#3ÀBC3Ç1Íµ§µHÔÃ:1ƒàA2B’óÏá¤¾²ãL™‹±|¤‚”cma b7‡Z†2ÒnR=\$Èqg\$sÒ\n\ndX‡mO¦&îp\rÀp7Pß*Ä<ƒ£'ˆh„†Æ¦ÏL[ËeDå s\$! àØF¡ñ&ç´•4ïÏg'„h9¢ŠÙÌ	ÇA¸†¢’‰A\0w9Œ4\"ÖâŒ…Äe}™eˆÂF‹äÀ¥dTblÀ6'Rlf‰4&q©'\"HLÉ©OdIRÔôNĞô•0P¢¢éM«x¡¨¼ÌÇI&É•Y\rn~Ç 0âañAÄ-½9b™\"ŒcjhTãœ”Bo!F!¨˜…\0Â¤81qhÑÃÇ*Â¡yZ)´´“2ÒCUªŸBÆ*%Ç2dE‹Ëf°Á:“şÅlÎ-”´™“Ç‰J?†ÌØ“pÚ™8v	¼0¢\nJ97dh#@ BfÓg}h}³”€Í8É8r%/x*3Ç\nJ:`\$iº/Â<fÃ“¹d®£ZYÅL˜Æ¤7 “5ª­W©F|Õ¥ø{É	ŠÁb¯ÀÚıCI#18ŸªÉxjåñ–!„TÒ‘[ÌÍr¡•Ö®W‚–kÖ\"u\r€®uÆÉ*­Ø¾†öp§£7²V¸Øä–K \"ú_m…P¨h8dgià†rV¬ƒ”¼U’š0 \\¬Ue±\"a¶êwm`Œ7!D0‡BeS†°oå2ìk€f+¤£ËªT2lêÕ[4²µ•²öXÅ‘Âetlõtmd&z(c	N\r\$!Wg+‘Bí—Ùf¼^B?·ù»€¥\nKà\n\$iT™´RxÃÖ1D|WcT©M¸°¸aA-‹YC\"Äjj|è„Wd‡Ìõ¿‰Ë9×IysVÊw2FR¢˜k”á:‡Xà‡@";break;case"ru":$f="%ÌÂ˜) h-D\rAhĞX4móEÑFxƒAfÑ@C#mÃE…¡#«˜”i{… a2‚Êf€A“‘ÕÔZHĞ^GWq†‚õ¢‹h.ahêŞhµh¢)-I¥ÓhyL®%0q ‚)Ì…9h(§‘HôR»–DÖèLÆÑDÌâè)¬Š ‚œˆCˆÈf4†ãÌ%G…ÃfÕ\nbÖ¬‹Á—÷{ÜR\r%‹¡mú5!s,kP¨tv_¥h¡n—ø]ò#ª‰ÉPÖ…'[ß\$´ÅôÖ!&Œc¢ÒhìÚK'FA¡IE\$Ÿe—6…jl°‹läÑ¬İ2\"²º\\íš©mËK×VŠ7™Å¥s6õıÕĞP¢Šhˆ¾NC¢h@©ª®zP’<‰£Š‡¸¨™lì:\nË,‡¸c†¶;ğjƒA0ÍÀÈÑpï9m³#)™©Ä¥ïŠ~ZÄc(™º1^ªåÓ”¤0é7Ïš8ÉÅª«ÀG£H©ŸµEÒ ´*ˆŠ8õCŠ«`Ù*­c¯	µ±ü.ùÄ.£®ğ8ˆ’0´	ôÏ9’\"\\ÇÒ«ZöÅHÚû8MŠ²ğ\"ò¼?>jRÊ´ŠñvÈšºåkÂôæKòL´îÂd¹ Ä£ÛEQc* \$|z“Î2ÑqR¸Î*JC²êÄ<hñªşäš›|â¨5ú˜’ÕËJ~Í‘o\"Ø¡Ï(ãİS·Ï‚’ƒ7°Úxû¤11VJ•å¢ZN3À¾2Ê’O¸ó Ç-“ã„ƒÒ‹ÏS£]Âô'Í|­Çˆ<@ãÜ2ıÅ:!(ÈÔ¥i0…a‹ƒõ‡áfƒU‰/uhXI‹ø¡pHäAŠ\rvVÉôŒš£J‹-…â5bÊ8JĞ³‹¿%šÚ~ ¹õ£µ(¹Ñ ÇÉT‚ì©&qD Õ	N	Ù9ª@\n‡–r¶^ÂÚÚYìbì‹iNJÊBŠü.—®aàÂ²‡Î4~£S0Ê·D_©¨xŒ!òs¹n˜ùX-‘†ÿÀ¬ƒ›½Æ­ªù-eÚt0ºíiûrï¡¢GrÎ{èó9tRŸJœËçÍÑñ«®Ğs© 6ƒ”ÙÅŠDî‰¾OäXÑBoúo»[º:¯yvPCø¨ö6&fª¸»!|ñ!°ç-1ÙÎ-˜ûó½ûG-£YEy	mÜúŸ=·2\\Gì±n²bº­¼¡på7>dµç+O¤õ\rû×(êq=¨Æ^é}xü>ØyOY\"y\n\\™>“¾úŞî~<ù·ƒ\"ß³ø;	]ı”ÿ‹re\$OY\\=ˆ\nøÄ[ÜOy448©%ó.‚bôS–}ª	ˆ¸:]Ì·3‹ˆ¨%uÕ“ówËõšªÁğ“{}5OLê¢¤ì¸Ö‹@ˆìÈCHn¡È(s–LŠ	qˆÖcŠG#Š•z´”7 @eÀô€è€s@¼‡yƒg1¬ğäÁxe\rÀ¼2ğÜC i“À¼7Tî¥‰œŒN¡Å¸\$z¬[a¾O†tç*Ø~T¹2>h­Q‚¨.£lRmå¹ôF'8~óŠ†tËÇêN<Ì\$\0µq'Á‹ÙSs°6?H	!\$4ˆ‘R2Gy!\$£Pr’²^LÉ°Ê¤šrŠM‚'\n¶J?)Ğô„Ê×_Í­9î\$•šOˆzé_ÄË?ø\n”H¨LE]°+èŞOåãmBÆ\\ÔÀtMœó }†\\´*f‡-##åM'Œ¾»¥™^ƒÙ'ÇÀÈÅø›(rhreK¨«3„16¦ù ¥-M_aÌ4±XÆ:–ĞAÓ<i)D…VïM;[DVlÓ¯Ï’~4…±ÿÕG˜¢İB}ğ½®<4Ö¹ª\$6@ ²‚’Ğøˆ}!ˆHˆÖC7Æ±Ñy_¡µZUšú)L™ÁfI–XÀe2L’ÑWä\\GÕ}»«(¤Ö9œ¸]ÚäŒKıu(75_\"Ğ-IÎ4Ó,\\Y]ÅÕM·¨tÌMP¦<ÊGa¶&ŠÜŸ×?e–Õ'•QÑ<+’”Â˜RÀ¶á{\rÜ•9®]K’¢*S**ÌH¨r7IP	>m’1—‡eÓ{¹¶pÆá^İí}¥÷\\J¤ÁzNE^2ğİË(n(Û³Ëëæ:Ñ %iš¥®â‡‘r\\¢»WÔÃ£Ã>£,èsƒÔãÔ.Î\"1ŸØ®_Ì\$f,1\n¯”®~òIU\0Â¤ÔL6ˆXnÊcù‡Ì\0«ÊÎV ˆŠ›V/!à4ÈêĞ\"µÏçäì—l¬R@\$j”bUzË»¤Äüâšõã,kAÁ'êufàæóÎ-¾¶˜”ã´ôRÌ1®NÆå`)…™u	Qp%°`¨IÕ_ö.ÏPû‡ÖšçAö\ré²Mæ-_ËÒ3\nçÊ:†ÄRmMbïºÉoVjVæh1_=JtÎ¯u¬ÜáW.U«&#”¥Î«9b2‰…„’vÅºÆB\"°g^¿vnÏ‹›EbÓµu³L;mŸ X|İ¨lc@T­W,qkôÎ†%K'ç³‡/½#@¢:à¸A¯mÛdnîdæA”ŠRfµ\nÇ£ãp3ùèy¦·Ld´B‚¨Tº`á:´Ï*YÍ…&B>+¶ıÖùAãú]ò\"¾Âù)lVP‡”éd=ËMqnä“eXÜ…(˜H\\Aö…L«„aSh™H³ªı3ò!Š:ŞàšÍ©ˆCuÏ.;9zT¤•Ôb­N0ç.*ÎÒĞ[ñãª\"“ê}÷Æ}ê–ÒŞÓ>ã‰x_;Ú7ìõd«Ÿ[I!w¨Èé\$\$4ttdTúFDhÚ´JŸìXâ9àìf¿3ÇÕ¾4Š·±4u7©Õ\\ûOè“\0®wæù‘b˜­ò+/gÌwƒgI>r¥°4Wóm„Ó,ğV¹Ø¿wıojãÈœ2wÊ¦R.7tãˆRZßO\"\n¿ÚëR#â‰–é6Ğëá†ÉÄX";break;case"sk":$f="%ÌÂ˜(¦Ã]ç(!„@n2œ\ræC	ÈÒl7ÃÌ&ƒ‘…Š¥‰¦Á¤ÚÃP›\rĞè‘ØŞl2›¥±•ˆ¾5›Îqø\$\"r:ˆ\rFQ\0”æBÁá0¸y”Ë%9´9€0Œ†cA¨Øn8‚‰ÆyèÂj‚)AèÉBÍ&sLÊR\nb¯M&}èa1fæ³Ì„«k01ğQZ0Å_bÔ·‹Õò  ‹_0’q–N¡:Q\rö¹AÚ n4Ñ%b	®¤a6ORƒ¦ƒ¡5#7ü\n\n*ãò8Î	¿!’Ö\"F¸ëo;G”³A#vÚ8.D8íÜ1û*…†­àÍ—É™ÌÂ\n-L6la+æy5ãO&(î3:=.Ï@1ØÂˆƒx¶¡È‚\$2\"J†\r(æŒ\$\"€ä<ãjhıŒ£“B¡«z‚=	ÈÜ1º\rHÖ¢jJ|¦)ãJ¢©Œ©	ˆF<ğ»Ş\"%\n”<‡9Ã\n\n)¨ûæ1Œ P„º¥’à)µ,`2ãhÊ:3. óº-\nn9fRƒÈà<B(È4·C(\rã¬¾VÌ)±|	²19¢Ã@Ø”nCÜ\nƒ“£AÌëXÓAP‰‹R±:	š\$á\roxJ2Î:4İ;O5\r9O7.€”\rÃxÔI¡ l¥h¿CBn¾:@PÖ2©Ênš¿\"Ğß.53{&\$Ó€ m«Ş+MQízĞ££Ôø\$Bhš\nb˜2Ãh\\-WHä.¿C…¬’\r49„hê¨„àÂ£Ã”¶:ÊM`ÜÖ]#òã|ßWà†7Ã2ç€¸F¬`‹MjPÈDj3X˜!NS 7¦ñ6=<¯=ıXc\r€Ë’¨ØâÊ•³`Ù. ÑŞ3ÍŠ ¤Ä)¬ä'Œ”CB±ÓÎØ¼©¤ô–\rã]îèÍ¥tÊ “)t¨¯ÈÌ\0è!Ë2‹N\r«¨ê©ÀNœVê¥]äÚ°ç¬kT\r¥ëÛÈ„l“FÍVº!ÕQm£vŞÂîKfèÅîÉ®ğåêã¶²åoÔaÁl\\+uÅqJÆJĞèéæ½Îfc-ŒóPŠö2jÉ¬ñ5½6M;Ó\0Ã˜#'»õ\n_Ã0z\r è8aĞ^şÈ\\¾xã\\…Œá|ÈŒ˜„4âxDQÃ˜à2·8®#I¡†^¥ÃVˆ9Ğ¸„>ZÏ)°-­·÷\n{œâ¨y³2zÃ¢­'gMA’d*CAB¨ùÿ‡(zÁrù!Äp2¼ç ô£Ö{iîTB÷Ã“áaÌ”óBŸèn}Kğ\$†ĞàLĞn*OÅ‹?D´nƒ!A(Í€À“•¹%iqE†÷÷]„A‚ëÕ{—µ:Iá-%äÅ3 ´ˆjEJXŒ¸GŞyUj€®xóC0t	Ze­µÎ(óÖŞÎˆcC¡¤ê‹¢(›i!/.ÜË²¶Z+Yz“	Æ¥ÊÃ„[8æX¢\"„„[A2¨;²ÃÍ\$# ­\0 £”2Eˆ‘Cf½G¢`å÷D,İ!æ`„ã0‚æpˆÁ·R3h6¥„Htrc\\R¼(Q?D&–ƒ zD0\r§fIÅ¡(Š03H+NquN³ ©DáƒY1)… ZAÆ%)À¢b½›ù¨'÷`s@Œ‚õz’BLJ	TN\"G9-²b]0Ÿ¼¤Rç…£°/O*#-p)3TæÕKÙ7 ˆº2%&È¡.Eä@‰“£Öl\\P x¯vn`èK‘~!Œ¨–ÁBÊ€iîQ»“„Ì€O\naRK/*;O,üª¦€‡3&J¨ı!(d·¬r‚Š˜g`†Š©,Wñ®L:“dõ\0S\n!0‚'R~½FáÉlÕ³û9’ÈoE…#@ rI27GDA—FZêŠ›hd—œbpCˆQëCçÈ³k8¦-/«¦¸:›e.E\r§³Êe‘Z¼p£%±J‰KÙä\\§lëYĞü<šj	CK° ÒÍB#5tntÒrØ\rq©è&\"0õL’2)d1{8ë9	ãšL¢Íòe*‚¨TÀ´…A¬Œ¼—41Q1B€\næ7Şœ_”E.S=ı-¬áÈ`B3¬›Ã£!¡µ¸¬€N!\n†\0Á‚ƒq\"±Eÿ®ó&|T‘ŒDè©I”š™`¥#i°:s\$ \$ìA6ïÁÑÖEZš]ùÇgÎàù‚jGLQ3•°FrşxOl«%xÕÂÅ“2q‰!Ê)¥ÅX¦KU6D²ˆ0Ê èeBè•ªÛµ8f_(kTÆaÛ˜Lçœ	ÈvA?\0QH.‚Yt¦0\"‡‹\$¡î‡ZŠè_+Åà¼¡¼Ã©”P E‡ï\nYÕ6¶ —-UÀ´DN¢ªËr€";break;case"sl":$f="%ÌÂ˜(œeMç#)´@n0›\rìUñ¤èi'CyĞÊk2‹ ÆQØÊÄFšŒ\"	1°Òk7œÎ‘˜Üv?5B§2ˆ‰5åfèA¼Å2’dB\0PÀb2£a¸àr\n)Ç„epÓ(0›#ğUpÂz7ÁP³IœÓ6A£C	ˆÊl‘a†CH(­H;_IÑƒ±Êdi1È‹&ó¨€Ğa“CÍõ³‘§l2™Ì§1p@u8F«GCA§9t1f\$E3AÊÃ}Ök¬B|<Ã6¦¡ë?•§&ÚÆ·_´7K08üÊ±·™ÁD“Ñ‹*ÅPßIFSÔ¼U8Bî·Ò©¸×i;òL§#”.}º˜Npƒ!¿7’™œô”Ìàùcº2\$BƒÚ9#hXÏ¿´2¨ƒ:V7ŒˆÌ(¦°@½èâƒ	¨ë¢T‘¥<ËŒ R~:¨sj° ¬ºKxÂ9,@Pš†\"‘È2ãhÊ:IDrğ<CÄì\rk˜Ò8<\0Ê;\"+ÖïÁ²PÓ&2pHÊGãš\$@ÃJTÀ ’ø¨×\rHƒ)32Hœ7ÃJàÊ2HC Â£H:3àA?\rK¥>ÏãMAÏó <³`RÒ°\\”¸bé»	Bú5§#’`—+Z/6Bd‹E\" Êà§.›ªõ¯£Ò45B@	¢ht)Š`T6…ÂÛØöµ’ìÊ«p¸èOlàÚ:¦A\0x0§aòGÃo=ƒòã|‘ZöÈ†7Ã2Ú:¡—%Í\r³¬94Ë«1zXA_IÓ9'wøğ\rĞEØ9µnâ 6¯£dˆ1lln¢ŒÃ2\\¢5r Ë»ÂxÉ3£˜*\rì˜Ú°,ş:Œc69ŒÃ¨Ø\"KvÈ™hÃ	6·´+ˆ\rÃª<aL\nÊÌé]¨8cå\n ‘\nŒ{ÌÎ×õ¨è„ğ·½pXÇ…##×k%mhÊ3¡Ğ:ƒ€æáxï»…Í¾ˆõ…ÈXÎÂ{êˆ\"÷`^Ü6èŞW:±W¥iÍš ŠPA&0Hß¼+Hì´Í3~H\$BkäJÜP¨Ê<JØ]´1ÈfÙ·n–é»oÖÀ9o£–ÿÀõøF7pöÈ’6Ä„7œmù<£;•)hÿ=yZ‰è@°¤Ş¥oŸ\$…5Ô,ŒH#xÎ7¥¨4!ÇÂ¹#¸Ò6fë²¶zÚÈrHHT0†gPAƒ2lÑ›3‡Üm_Ñ¤3¯Ğ‚„{B\\ˆ°ÄhC\rñõ4Hdƒd ¿P©á…p‹†„-Ó£ärá (\0PNÁI#	¸;órÉë\rÅûµÃ<WŒ¹™Në4ş¯S8ZI™\"Aİ;’\"KS9D2‡A™?3ÖB\r2Ş ‡ı™ˆ'pphÎªºÄ*Í(c…Ì@3¶õB\r!a…j”Ëºg„äp†ÂFva@‰ŠrEˆDZnUÔ‚„Y®‘X’bPäÂ'fLúÃÓr„L.<2œ9\$ì|È¢ˆ]¹§8	8Oì‘’Lal§á4†ä*i#	!ÔÍ“0Ì{Hs^on¦<œÆDœŒ'üÍ4¹\0K‰‚Í†h=° Â˜Tvaiï£±.Á¡Jrq!ˆbDHÁá“ÒéB‚ rÑ<2^ìV-ó@D¼bE´0¢î_f•„`©\rK\nA'ğ™‘j#4Hr\$Ï2´ó+cÕ2¡Ì°ÍäğéBÍhP£JpİK“ËrAØÀScVy99.IA'j_&ÀHS¨B¡>Rè†áM&He*¤Ô³…*!“¨µH‹‚êªC*¨…Õ¨§tò\"\nD\r€¬5ÎlKÙiZ³”ß¹\n®H‚3û!Mj¿ãjB F á†æÆ_pg/0öX¦êÉ\\<{«ÁVÆê°R*…\"áŒ4Ù;*„E3³&È’e–,UŒ![Ifâµ{!d4ÚR§gK©wKá5\nÌK)·\$ÀF¥ğ¤]ß²fi4/îyÌ®ªÀ„O£¸dEtu\0·İC:B*w®UuT†úú¡ğ¼¦Üè•„ˆX@PZ6ç	„2î\rpzfÅÑ=(+^b\n‹¿ösk6p-‘qæaû§pÈ‘bUR£;PŒÂJ¸³ÕgİS&j.@hdöåÊ—ìb\nÅVIÁÀ";break;case"sr":$f="%ÌÂ˜) ¡h.ÚŠi µ4¶Š	 ¾ŠÃÚ¨|EzĞ\\4SÖŠ\r¢h/ãP¥ğºŠHÖPöŠn‰¯šv„Î0™GÖšÖ h¡ä\r\nâ)ŒE¨ÑÈ„Š:%9¥Í¥>/©Íé‘ÙM}ŒH×á`(`1ÆƒQ°Üp9ƒWhtuÀ‚O`¿J\rœ•¢€±®ğeş;±¯ ÑŒF\rgK¡B`ÉÒŞıX42¸]nG<^PdeCRµŒÇ×¼íûFœÏt ¢É¼ê 4NÆQ¸Ş 8'cI°Êg2œÄN9Ôàd08‡CA§¤t0˜¹Õ¸D1%İCo-'Ñ3õDo¶8eŸAº¾á¶í”ÒZ½ˆ£ÎA½)ä¿@{b0*;pš&Ğ\0¦á\r#pÎƒ4í‘\rY¡¨Éã] Ès(¤>ÍXª7\rn0î7(ä9\rã’\\\";/Â9¸ƒ Şè¸£xè‚:Ã„k!Øæ;Æ£\"¶N\"ëã\\ˆ£‘:C¤*’ü‘Áí	zˆ§E¢<ŠE-à¦êÂ¶½-Ğ½¨©ª\"•#JÒ+d‹´¯*{Ğ^@éë£5è1DKùÚ0j²F9Aš²ƒhÒuPÚ¬XDªû*“±*LĞü¢Ìèü5”ø¥¾\nMC+T•M*¾Mrƒ&ÉÔD±£• OÓÉÍKšõ>“ŠÇ¾	|¢ø0(Í`A(Èˆ´oR*ÛVâck\\ÛEqªJ‰ØHü\0¡pHŞAŠ·b?tëĞ²öFÁ¥ˆ‹.‰ÀDš?¯U1eÔ¤5H#fØĞÃ Ğ´mƒ*T	h	@t&‰¡Ğ¦)C\$œ6¡p¶<æÈºÓb÷>5,³\n¼ª[.Ú:rx0«ğä2ƒ¨å:df0!à^0‡Év‡¢ˆcxÜ3\r#>”2êZ @¬®Æ9ÆîóÂçlákÛ[‰²mû Ê<;Cpæ4ë[Ey,\0PØ:Mã|:>Ü3Ãd*2¼‰£81<‰S÷P¨7¸ãnš<„®ô:Œc¢9ŒÃ¨Ø\rƒxÏ\nac¦9tÎ0ìÛ5Â6Â£«´aJ¶QÔ‰Sa©²‰iÌ¾	p¨àÅÍ·è¨Î#'x7F]Ç¾#\$dhn3¡Ğ:ƒ€æáxïù…ÃµÇÆÑ¨ÎŒ£p^›ˆtoøè\0v^³aj¤„:PÕ!°0J}-–D®›ˆá\nÈ”¬õ–I!(\"äÈ›¢Z‚j;;AÈä\$¤˜–Ûw¥£¤çÈ_0e}©ö>çàüŸ£ö{hÈ?§øÿ›»yomh‚&ŠChp9Áµş‡HÛb¡Ü\rëlê<Î iIÉÏ=ÀÜ{!‰i(š’taI16„ÍU¼±˜ˆƒ\"\$òB%HÅ{Î\r0†8Ö\0w9®¬1@àŒ˜rŠ‹l0†hV‘+§u.­Öºôa\"áÓd0Å@@á¬U\r!„67á g	NgQ¬Ç­ L\$])‰€‰'7”c”²^)\0%‘+Æ…`‚\0PVJc—2ÉE‚T—‰sY\rÏrC=c¦qÎIË9§<2­´Œƒ¡Ò;É!ÊÇZç)[&3©c`„fI<'È:A#(Ât¡ÀsI.™²£¹CppwĞ´9¤´›\"Nèc\ry®¾°A#eÄa… 9¥=|ö&¨0!…0¤’£ÊÄE|d2¡#UjBáÁÅá%^êPÔÄA.Ê´#§¬DÁ+£BB’ÜOhe+èL4JFVÓœÕJDR:!F\r@ô º\n»~	\$<¸pÈøga±pî&C©ÑHa™×°ıŞä, èÀ1ºÔy(§ZI:ìÛ›¢VÕ<Å	áL*Kéfµˆİ+RQ¨ÀL¨ûQˆiH‘Öe‘µsVìu†¤kz6%(DÔ‚Š¥\$è^neÑbiEwâCaTJ©°Íœ—ÓFÑÖu¯ÙÄQvº˜Q	€®6Ã™0T™\r5m†˜¢‘Û-s®µ¨94l{,3™µ\\“Áb§‰DÂ’ğ¦ø+Ì¨?ÆªõŞïxˆ[d¼•6Ë-b\\¸TRĞ½×íU™r0j‘¥\\«Vû¦‚ªYãÔ\$ÀÊ¿‹P]‚ğ\n×A˜(á<dfË„\r€­4Xt˜Ó…§26©‹ŞUuT©Ğ\nÓ/4‡F0U\nƒ†à÷ë:¿ënÓŞôa”©AÂøÂ®Å«ªñFÇÓ%äLš´É½äÊ9'ÂynY#q„\$¥8½ßÆiáŸÌä¬’Âˆ¶C0y2e•.8â®Æƒ—µ¸Ù”»å‚sê&½dù”Rw˜ñn~Åå3D¢ŠQ1U©K\rSBhjé##\"Ğ®Ë!-!JÒÇ¤×_fPŒe.!FâÌ¬!L¦±=íkU³•ˆĞ´Ã\\Xk½s–\0S§:CNRó5‹âË\$LZ}%nk!1; Ô´Ø/ªBÎ,ä´*ˆ#51ƒI¦B‡ÛÖd\n\r£–CÄÊê ¥‹ğ";break;case"sv":$f="%ÌÂ˜(ˆe:ì5)È@i7¢	È 6EL†Ôàp&Ã)¸\\\n\$0ÖÆs™Ò8t‘›!‡CtrZo9I\rb’%9¤äi–C7áñ,œX\nFC1 Ôl7AL4\$8Èu‚OMfSüt7›ASƒI a6‰&ã<¼Âb2›\$‡)9HÊd¶Ù7#q˜ßuÂ]D(­’ND°0è†(àr4¨¶ë\$†U0!1ã„n%Œ(Æ‰ì:]x½Idå3†O´Û\ræ3D†pt9ÏtQNÊÿÆ·Şö!†Å§²İ¾×r#†-ÿ+/5‚ˆ&ã´ôÜdÍ~hIšóĞİÌ':4¶Td5gb(Ä«è7'\"N+<Ãc7\"#Ì‹¨Ãì£¦E#Î¼¾ƒ’j(\n‹\$Cr’Å¯ã\nL	Ã¨Ú6¬ˆ3C7Mà@˜=˜è9<Ë«°!\"\rhé8C²Èğˆã*Ò„3	#cè<JüÀì#<²C&š£p&?É,-°ìR \n Û\$¨J 6L#s+( Âğ„¨¸Ä<¢@LêNè’\n50cpÊ5A b„¹ISÂ•GÌbõŠmûC(ÏBCœÜº+d(è…§ÏDR\r” Ü:¥@t&‰¡Ğ¦)CÍl<…±8Z‹U=RÔ¾ R€\r£ªZƒ\n€8Ã ëA( äÆ!à^0‡É=“eˆc{\n¶Ùã-­lC\nR!r¶c¤jŠAöò½¬%#†8!—(Aw³¶`½'£<£‰ƒJnì\r‘š°5­ĞÌ3@Ôf²R3ü±ØŒÏØˆbè\r¸æ6#ÖÆ©seıOÆÁc<[N	lÀíĞÛ\"øíV:ÀN/–c%.7bcÙE’Msk*ÉåC3?—fşešh»ƒ§‰ğAU££¦LºÀNÈÃ‘em†¯Á2¬&‡#&l²e[4\r§Ã®ÎRëB„Ù!\0ĞãÁèD44C€æáxïÃ…È®Ö¾'8^’…ã%¼Ğ6ğ^Ü•Æ\\vË”2cŸ+2Hrd[\ré¶À¹¶\\ğ:N\$£°ê2tïü„oL›ûÔuAuoc.û¿ğ<ÃüNÔˆ1Üo7qãÂ\$¤ô|½–\$£‚I)œå®^Ê4P´\"úVy»¡Lú8Õ!2hå3ĞH‹fÒ7û\n	ĞtVó:Ha-\"aØÜ¯AJIÆ¢TÈÕ €ÖZQCbuO¨Æ§Œi×ºhLŒ‹´VNeV!NHØæ¶Ê™¤-Á˜Ó’ræ”HJûB+øÄ‘ÄjH˜P	@Ã%úÓƒ™i ‹¨[B”\n\n\0)j¦¸˜ªBèÛÃ	'<l}Š²„^LA—3&l4˜#UMû¾a'ì‰ÃáJD™Áé-Ì¶ÂXNeaI…p´ƒ;Ä:‡ÈA	Eé1ğÂÈ{¿wP0„6ÒFXÈK#AÔ\"\"HA²DŒ˜H\0†ÂF‡¡¼±’`@ÃXihfùù‡T\"³Hzÿvd¨–æ®‰ ŒW_‘´¥PBXKue¡¬Ì?„©á315‚Ø5.ƒÒÌÛ\$d ’…¡Åò24¥ÕM\$Ú\\Ya ‚E’À}‘Š­é„º\"6ˆÂ€O\naQ]ŸÂ`¤C'&‘\0æÈáÁ	_:aÌR€®ÃIÆ\rdÁF“!7#LPÁ™äC‚˜Q	€´‘À@fˆàF\nAœçº¥Cğ\$3Yı‡%\"ˆÂ*iÍŞšèşN|7ä”§\"véZ©ç1‡\0Ù§5‡N'¸a6´ñazWMİğb@Æhö™ôcz¨ÉÌÎÓŠ•êk,©æ4“„4fXk@Ò/s†•d#ú}•n|¡¥á\0,¢æä4‚\0ª\$Ğ8¢„á3Æ”÷T)i£é(ÁSÊ¤bÌlüwÁ¦ÁšsBÉ8KnQ~e%UR]\$KEr0Œ\\ÊEøŒ“üv2PRç³{Rr#‚\rÒvµ:ÙZ%ò[¡p„¯,™BÎÀS\r\$l:\"ZJÉ8Ğ¥‚šQl@d°õA…bàzZl& (\"‡€áHÜ»öä…5°%uu5óí¯Y›GbJØ„³¨½&\0";break;case"ta":$f="%ÌÂ˜)À®J¸è¸:ª†Â‘:º‡ƒ¬¢ğuŒ>8â@#\"°ñ\0 êp6Ì&ALQ\\š…! êøò¹_ FK£hÌâµƒ¯ã3XÒ½.ƒB!PÅt9_¦Ğ`ê™\$RT¡êmq?5MN%ÕurÎ¹@W DS™\n‘„Ââ4ûª;¢Ô(´pP°0Œ†cA¨Øn8ÒU©…Ò_\\›ÈdjåõÂÄ?¤Ú&Jèí¦GF’™M§¡äSI²XrJëÎ¢_Ç'ìõÅJuCÇ^íêêÊ½p… i4ä=¼šïxSúâÃ¶»î/Q*AdŞu'c(€ÜoF“±¤Øe3™Nb§‚Nd0;§CA§Öt0˜¼û¼lî,WêKúÉ¨NCR,HŒ\0µkŠí7êS§*R¸Ş¢jÂ¶MY`³¸,ù#esÿ·ª„ÕÂ‰r•Ê¢±µñ\rBî‚¢ãÁĞÔàB›¶4Ã;…2¡)(³|ƒ–Š\n’D¡¬‚–à@\0Pª7\rnøî7(ä9\rã’\">/ÈÂ9»£ Şõ;Ãxè‚\$ã„Ë9Xæ;Ì£#w¤I´@´¥Ìk6šGô\"I îuW(ƒR0,d‰­ğù\rÃ˜Ò7Éj*+­]¦!1‚ã%Ğn,L‡·kŠ™\n.©uHY¦«3Vå7drÚ±Äª¹\\)êKz«0\\W+Œê ÎÕÒq—1ezwµv”æ«–’J)ŠÓ®dB¦æÊH=ªÍ¶\n‚ÑÑÒZÌ«ÊÑkF¼¤¢8Ê7£-ÂÓ8l‚¸ª2ˆ=u@Ş)uï¢L³WbDqô#ÇpªÊ¬´mç*ÔØ>7…]˜P*Íƒ•È­µpí´UÌj ÆÂ-mÕJ*4I+–¬q[¹Xœæî>ssPM^a8qµ“ßU¶=	¦°¶[)£\$]ˆ•×h¬ëj4jØÆÖ'y/PïA j„àØÑ+`å•Õñ\\L¦µN8šF•£·–å²ªª4•ÓHpÔ\r¤ºÄ…}®fĞ5®šæ*b™ğ‰İiÂ9Í\\åB@	¢ht)Š`PÈ2ãhÚ‹cÏl<‹¶2¹³eü¤ucêwsƒÍr\\å‹L£¨ç9‡ƒ\nØXê9L«1Œ#ÈxŒ!ò‘æùâ@3\r#?¦2û~êÖõÈŸ\\Îû?/?ÖL³İø»´ÏëLŒ´ØÊ§Tú7mY@®Ôj¾]òÅ\r‹„c°^‹ôÁ˜6\$@ÊnØz…q¾,‚·ÓÜeFeÍ±Õò‰V€\n\n¼ğ×¬A\0uS¡Ô1†3ÔÃ0u\r€€”†tˆÁaìPÀ0†pÂû_k`\r©:Ÿ PÁL„«8§x£Z	'ˆÌŸÂUq	Ö´U„ñiÀ X¨g	H\n‡i.°Ìı^RDà€ †H–“AjODÄiÙz!˜‚ Ğ p`è‚ğï#Áq+éˆ&PÎßø/MÏÜ:@^ô›>1Éô½ç\"fÅ»\"‹…*-¨µPÔccŠ¤_°âµšê9- ¹e¤…~M[º\"ZŒá®/¨ºqÖ‘H	©¬ù#Â“àrkOô8—¢Ÿ¤\0aA–BHi\"¤d’J&i-&t˜ĞPI÷Mç`!¸:JWæÀO okG´BàÖwCJxLPº<OCù	eI«FKLƒ™µSÃ:-%@ª¶\$ \\ü5è%H\"U€T&\n¯)ñ¨4ĞÂäê ÜóC°ÄwC‚báÉ€µ Â¦jt†°ŞÃ¸zûiaô=””‚×òt0†ÀçœR”x`¡ş©ÀçDÔb1!êˆW‚ˆm€PP	@—Pç1Ğz•cÕI,2H\ne\\«Æäê\0§Ä£Å(G°ğ#Èy@ekIØ9GØzÎús©¤¤;Ø#øº%’ç\$2ÙQ¡\\¶UU×3¦Q©\"b ®m4ó\rí>”\0007›3Ãš{O´¬ú†0Ñ?_,‡¾¡ĞÆ^T®ÁL)b\\lC}•T0—ÂRòPâÒ¼EËÕJK¤T’rIÔ}±¸9VYsBªµ»À–b»Š×)5Uêlhádiô]@RÁG•â.·Ò)gŞ®åÛ½pxĞû´,Jå½ô‚]xV5Qêã]u¦HªÍ&«Baaˆ¶†EuòŠÖAÑf‡Z/(\n	\$<p@KZ±\$ÿÏ³êzŞˆq§©9†dÈc¤vœ¶õ02R›*ö™ç¤İ¢z.Bª‹,pT–  Â˜T%Ô?¸ÃV^p{…A¦Ï/£¦0gZF&Šôvd8‚ÉsÍf\r~g1«İWØ˜Êå\$±ì7>GÌ¥*ÆF½Ê¸ØägÁJïÓ«‹­ú`\$ä¤•‚	´Ÿ( \naD&Èü,ÚÁR²=f´Mwµ8÷ã@åÚ¤QÊºŒÀyjÑnÖjÁ7¹«ßÕ.Ò›SÖšòû,«ö¶Eø–öQˆØğf¿ÁÛË£le¨(	'È6×ˆåğ%›ÙÛ+Ñ½¤R£ØWéRì]n«âÖŠ[·½¤3éb¯ûZİ[UªnM±¤½Ş8oyëİêrX98)\rp†ÀW‘ƒHc\roÑê‚\0íSqİ|Ÿ³è4†ha@J@F°õå';xûB¨TÀ´?h÷Œ.èßYy†üWPeo·¡¬­µªl-\\Â‘l¨Lló»v†æP;ãtóJÖLni­Öwœ¤£Œ´yîÙ:t(J¢:.»ß×Ù²#kšìÀÌŠ`4…ˆüxXO¯“V¢gÕq_Egö‚oãÅ\$è»3Îómmpñk*’©á±F]à  )PÙ Të+7¬] Q=í˜š\"&ë;³e•;°Ğ·‘!ˆ,[«úJ%Î0xÖ®*K,©ÒÆÌX7’‘hà	SZ\r©•6¦Ÿğc“bï;±\\ºlA0K=á(^‰ŠĞ¼o¡Iİå{\$›,6ª0ê;å‡bBÔxó\n~X2Ò‹bÛ¾çÁ”Ç†V#â©ÃŠõ}?`ò\$^Ië\"JëdîóOâiHÄÈ—\\ÎØúîúqânîÑÎÖ—æuüæ¸Íf(í.GÌ,íÏ¬•o6êà";break;case"th":$f="%ÌÂáOZAS0U”/Z‚œ”\$CDAUPÈ´qp£‚¥ ªØ*Æ\n›‰  ª¸*–\n”‰ÅW	ùlM1—ÄÑ\"è’âT¸…®!«‰„R4\\K—3uÄmp¹‚¡ãPUÄåq\\-c8UR\n%bh9\\êÇEY—*uq2[ÈÄS™\ny8\\E×1›ÌBñH¥#'‚\0PÀb2£a¸às=™UW	8š»{³®#+œµ&Õ\\K#ğ[Šá[=ƒæ-¶¸šO5Õ,§¶%Ê&İ¶\\&¤°TÔJ}Õ'·[®A«Cİó\\¶Öğ‚ßk—%Ä'T¡ßL¯WÈ½g+!‚è'òMbã‹CãĞù ¢É¼ê 4NÆQ¸Ş 8'cI°Ê3Œ£˜@:>ã¨à2#£è:\rL:#ü»·-Ú€‡ ¥³˜·EÂMªğË˜ï³ÅÁa9­³~Ÿ¥NsL©é¬^\\.-R\\Î\"¶ÓC²‚¬CEÃšÎ©MÃRé:³¸‚½()E¸Ï<œ·äØ)¾CHÜ3§©sr”ñR†7Ë!p´ÅËb†LB¨Ü5¾Ã¸Ü£ä7Ià‰Â#æúƒ|úã @9ÀÃ„ñCğæ;Ï\$(Î¸ì“(¶—34ĞÜ#mSAºJs„¯±œØª,»pòA\0b‚)±İ>Öªm«/Š:¬\$ÓJËR’‹˜ç\n;ªÓ~À&ËuUÉÈ* Ì9lô\\SÂ,?#ÆNƒÃD’ôN\\ºM¼ÙGRš®\\ÌìÆº6Ê\nH#Ê\nœò÷jß&4‘İè‚ÅµÌ{8éú†™Rõ!*¥µ¾éL1	pNYË52´-SRâ‹hÅ.zz´Æ—ÒŒÙñU5ŠŞ)ëÑCêv!T(´ZÜ(ju¾8ñ<+/ «â`Í ¥œ ôV‰òÕšâ-Vráçn,¼ò(©”­|5r|„\$›B¯`PJ2 ü:‡©`Pó\0O°¡xHíÁ‹ µ(-É‡2RÊÕ^º+­²Ù/hJ\$,Şçº¡’‰î¡\\uH ³¯Eí/4¯!Ùİ\n\nƒeB@	¢ht)ŠmE¹‡XÄ@_¢çüÊ‹mz².ò÷ÌfÎæwCº¨):ô6£+ |9£ ê9Nc£;#ÈxŒ!òyäyBŞ7ÃHÏçŒ¾¿³aÕ…=AĞ‹ıôO İ÷>‹ AøşÃ(ñ\rÃ˜Ò÷Ö*#ÍYÊ¤À r=‡¸˜ıÃ0f\r‰h2œ£¤\"Êã‘\\èÍ¬ˆÂzyÓ‰5jP‚³¤:oB o>áµé@_èua\0‡0ÌC` \r¼3¥ ær…Á„3†Ôúšø \r©h:  PÁJ„	A5vÓ\rÔoë5µ•˜àVéŸ'Pø¦ôŸ‹ÅKAœÉÃruˆ\0ÈAÈ>03ĞD tÌğ^ä@.1¾\n'”ğÁxe\rÀ½@¿0èÿä˜\"ÒUÆ·Ìö’¼5“\nÀÑÖ~y\nV*«E\"a	Â–#iŞš¶lÚ[;‹)šR²#½‰‘ÇW¦àõ„Ôü‚ƒ‘øQÊ@96ôKÌRQä0Ç°ËcürCÈ™¨.‘òFI¿§øÿø/O(\$†Ğàƒl’’}ôOÛ‰A„5Ÿ@Ò£¬,!¸:-RÔ¾àÓ	T…“«ãV&A\0S”O~1†ƒèC—{à€;ŸØr pN± 9OÀC4ÈPğÊ8m!Ô<}Tu :,¡ÃñiO ÒCd/l‚D:§Kâ³ƒJˆ„c²×\\¿©mÔ¶¨©éã* €(€ At*À¬:ÕjPÎëD‰­)µSCËÁE'`)ïèãFcZ>çäıŸÓş[ŠAÑ å¡ª;ö\nKSÈïÍÚGd‰ÅciÏ\\dN³ùMPæ£a£éNh2àáfU.™€; ĞÆ\"Sâ\0‚ScèÃÅ‚«Ú`¯“T¾ÚÚ¥• €!…0¤›\r’5VQàÛ.º:°ªg–Ç#€R¥åP]\0ÎÛÔ¦šP¡|p¥Y«*[\nq’gõhò”…H—Š)L<…ÉVm.Ë:FuÉÊö©,”ÂH©§^íœÇÖ‚I002Gk¡ä”ùA¨	æê€T0fNá¶6ÈÈã2m\"spí?Ók£P ÷YVTwtÊ”´hèÁÀò‚Pèb¿,BıÔÒ€¬‰Rå:´5‚BØp·:àµ^²İ+‰jÅÅíôRdáJr½/…²«e¬Ê¹±'‡´÷Û„æ¡Ü‹¶ÑñQ¢á}çòj„`©WŞ“`\r3¹E¾œ3†ğ€r>iæ5V†Õ.bPKÑe\"F&Õúa*V·¤ØÁš\$¬ÑØÑû5IS¡Èú°Ñ-^\r\$”v^´jÓX„@¹¶\r=2éÇÔfuÇ´R‚äõYÕ)I’û‰C`+Äa¤1†¼‘Qmñ|\$Œq‰\"~Es\nÕú%<U\rm_PU\nƒ‡å0j['‘%YCA¬Ës:RÔ†é­USÎ|ÈˆÂµVÃ¤æEÎÈÇ#(›PgÀiÁäÖ”F•URèMÎ\rä[ÌáN¢(\"`›ã:ÇQZebˆ¹/*BÙ´caâû5~ls§²WF“pí„¥êÍ¥ÊĞŠ®|À˜óPmO\n>\0®o\"ãY=4Hİš%ÔvÒ%‰/Ğ¦€î±‘J×µrÑÜÒ„ÿQ›\0OJÃ…ƒ¸Y“Ü`ºÑ=(;©~4væ‹›¬³LÅóêòÖç‰ÈâÉHS÷=HŠ¶r»ó_Ê`";break;case"tr":$f="%ÌÂ˜(ˆo9L\";\rln2NF“a”Úi<›ÎBàS`z4›„h”PË\"2B!B¼òu:`ŒE‰ºhrš§2r	…›L§cÀAb'â‘Á\0(`1ÆƒQ°Üp9bò(¹ÎBi=ÁRÖ*|4š¤&`(¨a1\râÉ®|Ã^¤ñZÉ®øK0f‡K¡¾ì\n!L—”¾x7Ì¦È­Ö 4°Ôò¡”èk¯°¸|æ\"titò3-ñz7eL§lDìa6ˆ3Úœ®I7›F¸Óº¿AE=é”ÉŒF¹qH7P–uÊMÀ¢©¸Ön7äQ#”j|aÅ˜Œ'=©¼Êsx0‡3©ÀáÂ=g3¼hÈ'a\0ê=;C¢h6)Âj2;I`Ò‰¸Á\0ÖìA	²jŸ%H\\:\$á„¢&ã˜Á0@ä·A#HĞÖ Úí:£ĞÎå#Í\0Ø4B\n’ã(Ş¡ˆ›S\n;I Æœ‹ÀäŠÈB#^½¶cHÇ:îÌ-#– P¡ğDy++“¸ãCĞ›ËÂÌÉ	0,Œ‰c:3„ä<µ\nw3D‘8HÁ i@†1Ë†\rÉN1Aìèäˆ¹iºØ0B`Ò‹µòÊÊ¹c+4,´»åŠaĞˆ\"Cš\n3…Ã\\-5ˆò.B²J‚SÅ<Şø\r£¨æÂƒ\nvLğê9\$Plá!à^0‡ÈåƒaˆnÌ4Œö8ËgZ	ÓàÎ'iğÒ9±l7CuËoD2àÜ¯8#š9KWìš\$\r’aê&6Œ‰¢Êši¤,=DC¨Ü:¨·ùš\rx2Í€0Á\0Ì0PEÚ˜C«r0³Qz“¢Ï{…>\nX…Ó¬â\"8ƒHÖ…n†Cƒ[†9dãt¢ãa€PŸdS’Ë¦ƒÎ=œ¶.Ö^#\"¶‰BR\" š)8RhÑQLä8²Œ£X×%7HŠ&ÑX!\0ÑbŒÁèD4ƒ à9‡Ax^;ï•n¬¢Ar43…é8^”İC Òà…á|õk¥ŠÊº#„_5ÅâÊÈ2å££i\rÈç%eJ<º2¡`@6/ Íç¹ú0ryfª]AB3X®2EÑ—–*½Ó\r@\\0dŒœË±~X³Ó9¶íã.ã¹î»¾ó½ï£ÿ¡#|\n7p·ŠOz|‡\0¨IOQ‡óÚÌ­Ûô>’ˆß*KÏ8·hØ‹ŞP±eäl‹6EQBÈIK£s.£`g\$ÄM§ÓÔÒĞSN!a½Ğ‚H)Ùs1nı´fŒÓe\"¥•Å2*dƒ\\-#Uäô©=ìôŠ´\"D@P9õÅ\$ÂBDI('`¥·(¥DĞñC(¦¤ ØÕÊ\ne±Š@äRP¬7>&Å¢fBÜ€ŸB®\\…–8I!q#0ÂäW \r°9A&HàT\rHÖ®8<AÑ’3ˆ:H9\n1úUGõG‚\0î¢C+\"áºÃ[#Ml[WÁ”GQND£À )… Q8!Õã„b4¯YãevDdì‘Â<H	p\$ÇŒ‘1¶:BÔ›¿M¢ÅçÁæ‰Z˜ 	µ×’\$H”FB(&  ÜGI˜%(5V®<H1ä=µ>Ò0{!,&K<±·0ÍÏÔ7›ìIŒ†\"ğKÁ—\n<)…CXDÊóª˜Aäã±ÂÙ>œ¡G!hÀ ’èCŸ3+ÈD:‡•²H’ê	8Q–¢V¤Mß F\n‘\n^QÖ=?…å\0=F…0¢1@™´Èä›H £Mùôaå%kN!‹8tş;š8iL:B@ÄHah¼2&NœúŸ2Ã¢ï95Q\0'oUÍÑŸ˜uy™AãWYê‹ü­uT!(Ù±\"ªağ´Ë=6H’z5¡\r †ÀW\rËôËŸdü•…P¨h8BA¼2 ‡œÂcş€ÒÖTÙZ*<P©-2hFbñ³õFĞĞØci-¦EÄ¹Ç¤l•N/)A D+Q¹eFËì2\$óbr‚ e)*Ş¼ÂÄ_[	(¸ÆÊ/Æ¤\nÂóĞBoÍ`Â™˜ÓcÓ\n‹Ó2øh=:(±°ÔqxtRÍO§jà,S¥¨­õNÛuFÃxp!Ix\"1kI9mz'#ÑØã„lË’&³7’‘a\0ßUŒ&¾/¼2wõsƒ";break;case"uk":$f="%ÌÂ˜) h-ZÆ‚ù ¶h.Ú†‚Ê h-Ú¬m ½h £ÑÄ†& h¡#Ë˜ˆºœ.š(œ.<»h£#ñv‚ÒĞ_´Ps94R\\ÊøÒñ¢–h %¨ä²pƒ	NmŒ¹ ¤•ÄcØL¢¡4PÒ’á\0(`1ÆƒQ°Üp9ƒ\$¤ñÕü&;d…HÃø5õ}QŸÄ\$¥öÑCÆäË©üZ‘„B¡‹	DŠ8±ˆÄÚ(iÍyA~ŸGt(êÂ‹y¢g£²Yã1~ÍÒš(ùëBd–Š×¯K‹–m®JI–±Š\r.(²§èV­¼V1>œ#ãë\$:-ÀÇ÷r%C’—ÎÇ´)/–½ÕĞtép­^Ö\rğ„â>”[73‡'ÎòÑ6ªSP5dZ¤{îh>/Ñ ú¤êz0è)28Ë?ˆÊvï(P|\"ùÀo¼¦­KBÚ\"i{* Äô Ä5Ï²¿:ã¹‰úĞ²…‚¼H£ÈÓ8Ş£‹\"JB¸®Z€è–‰£(F‰)µÊZœ’Y(‘ˆÂ\$×&’Y¦¬£ç6,«X\\¹NÛzÀ#¼‡æ‰ÑDŒZ²9«Ëª±)é›Äµ+Å;DšLh1(É3Ïë É(1@İ·¬£lhQñÉ –MHªŸ>Kò X Äšü‡!™¨Ğ°q Q&«ëˆß1ód3WÁH³\\Cº%•-£‰’E5 ÄÕsEÊUë\$C Äû%-\")ÊQÔNáZHáx·pÓùC:pÊ G6ğ‘:£Õ²f£\"0Ğ*©xŞi\\5{ŞP…õW¸4ß Ì¡pHáA¢Ç‘\ratƒ2úr·¥ªP×6kZ×š“AVÄ°cwGV1B)Š©q¬[K2-RhaÑ Ræù¶8P Éñh&Åà\\-ÖŠ.åQ[ÅX2´Œ3r°@*Ğ| Eõ*Óê)£ã|—jš´nLsÖ=_(»Å?¥\nÂ´á&¨c(ÁJSõ\"íe=»<J…_0¿èÌõ>/Ë\$¸o…ôş¯c—tËƒ å•;iKCA—¼ƒò¥¢Ï–“måî¬’J6=òÕR	ã\0ÅOa£&PÎj~XÂıš(ar1Èğ¸¬ÒIÈÓ»Q+J…N×ÇtËEt8\\š2vu)åé	õ¼rv…\"İ‹EÚ&²ÜTD/v¡wÆ‡jxTüãxî‡’ÈùhÊ³yyé«ØNÅÃÓz¤x²=‚L÷Ø³{©5ØwÆJ+Áw/©\0>Ç~“ß‚o~o7?w>_kü}OAÿ¹×1[A<z	Á=Äëa\"3DL¯“xL‹Q6Éœhˆ’xš’™±J§&DÂC m\r!¸2‡\$ÎÖ ª\n3oÊä´ÔÃ \rÈ2†`zƒ@tÀ9ƒ ^Ã¼iÁ†\$Ä¸šƒxrà¼2†à^xn!Ğ4Ç^š¹0\n‡¦ÜØØÙù\\Ç˜ã¢H‰m(dFD÷â˜”WÂ+Ó¢K‹‚'(^Uvn\nì~¯°ƒ+EJS\0½:êôwå)Ï’Xp§e¨RÒpbÄZ‹‘z0F(É£Dj‘*&(á£¤v¡à:GPçc°\"lÆœ…6ƒ¢^ÊòõW;´ÿ!óçN¯²XC SŞ0Ñ	m@ç—,´G«©“	eæ•P)½Ou-¸’Ÿ\rUŒÿADù'=C/Ûaµ(‡i'–uªv’¬*	íãÏ&úÊÁÖPÒ˜å¹RşŠ)6VâÙ9³¢¨^G:ğºÃCoÌã…O)ì’§Õ¬4\0{ğ¼(€ iÓ‡§´0‚‚´\ngA<((é)êLPÄsy¢q=:P(„‚‹é€+Â}(+‚qV_Ã&¢ˆ+U<xú/té.}«\0u¤i Mdı×Ò¼f`Á„„åÀÓ4’…ŸM +Â	ÖWS©	}f)m5+ùÎˆ»‡Üš”˜t‰hRvÄ–H¡ñ¢#«ù¨“ê%)ğ@Â˜RÇ¦B¸—ÚB 5Z²‰Âª÷d	D>9hĞŒÃS†Mä\nkjF[&½-’ã×#ıj“£“\r^Wf²°Àø¡næ\\b×fIÉ¸F˜©ÀKªŞ8ò+ätéM\nŞ®Ï;˜ÑYä/Öy#5ƒiâDÌ‰·œ˜¥8¨YM§‚XKïP{§€Î¨§ş¦­s·\\\n<^\0 Â˜Tc\r5ñ¾ÓªÉ	½¸i+²0gÉåè³\$æö7™tËI²®*4Î¥¥[‰;{¡îhŠ ”i‚J€—nŠÜ†â!9^-‚€Œ’!×BôpÁIsJ]‚\0¦Ba(I;`¨M982y´exÇèï{y;.CèQ¡ï]ª.…¼ôáÙè9,úD³¥&ÁÚB_âfŞßˆw2\r\$>—V’CÒÁï¡÷ö»4*‹€BDÖi¢›#ÜI_5ÉCG©©4Î1ÑZtîéıX³	.nX6ºÍKÜ6ºOÑgê“p]ºìÓ‰)ç)â K]»ïB¾Ú,® An)P¨h8%Ï9£Äv.´;}ÍqB»W-.¿\rÖæW\nßHî¢m›`>Û!¯Or)‚}u6Â3Ö.8èæÆ:±÷Öƒ¦ö|ˆ?ò-ŸÉ«,u§³DiDÙsµM˜had’C&ã'TY.xF”Ğ\nBH©ç^pÕÅ{¤œ!û`t}Ÿõ4qp÷dé½P‹8 †8Ğq_ìcw£Uñâ6YUóÄœÓUÒ¶¥ôed(pcFÁÉƒ})Z‘Dùpˆ’p]UÄ —ƒüÜ´ßoa¼”×ní{ı`´%aÄ²ÉÏÊ—)±+#Ÿ/ İƒ&¶×ÄÈ0¨b\\NÃXZDl¸±í\\\"V·Çdi’—î×©m¼©A§óX¿¯€";break;case"uz":$f="%ÌÂ˜(Œa<›\rÆ‘äêk6LB¼Nl6˜L†‘p(ša5œÍ1“`€äu<Ì'A”èi6Ì&áš%4MFØ`”æBÁá\"ÉØÔu2Kc'8è€0Œ†cA¨Øn8‚‰'3A¼Üc4MÆsIè@k7Ï#‘ø**'®Œ'3`(•;M‘”6,q•&ƒ‘¤å¸’ğÆ™}Ä£+7áÌ7ÓÍş:B:ˆ\rW‹Ô.3²b\r­€ë4‘Œ† êq×ß/Â|\0(¦a8è¶Û‚ò :`ğ¹*æ{Vv´ËN’ü-Ço¹¹è÷æ³)æÅd‘gx¼i£wĞ7MçX('°bî%I„ŞyÕÄawu¤Ã:›DŒ°Ò5£¨ûğñÄ0Kš82cz†(²ö‰­€ì¼À£\n2ø#ŠĞØ—¼C˜X³Œ«:\$Œ›VšL[<Ÿ&¯{â™ºê\nn¢*2ŠMÄ4¾7csXß¯#ˆè%ct€\$nÛü5Läñ P2­)s\n<Œ/sà½&c¨ìô¸«\$Â£Ãªr98rôf7LS Ü´ P¡®¬SšïƒzF4+;Ôï-2ƒ(ÛÈá*“# G\"‘<€œL«h¨\\tøb\n#J7=IÈÚŒ³Q”ºÛSâ!* 7ÀP‚’J)›t®L3l)‡Bhš\nb˜2uVcÍ¤<‹²D7Ã#“<àÉNˆƒ\n|)iì1;&4«ƒHxŒ!ôIXÀøæE÷¸ÒôµaÃqcxôù÷}âÆò,ô°«üí„ƒ+ˆF¤MHÅ8jÊ1¨)\"ÃËùlPøäÛ,¡\0Ş3\"#ÈÜÕµ(è¦2C¶hVƒN:¸‰JCX´ã‚‰1#2mËƒ£RÒcJâùÒ^;tÅh\"-‡]4‹Y3,Q¨ßº„6èš3q@%z^¸ù~\"¤êYÒ4™êÁ>±uišêÇ\0ìº>Ñ¡KÈë¬¨è‚2'ƒvhf¦¹ªŒÕv	,yKJ×&•ˆĞŒ‘ÂÖC(Ì„CC–8aĞ^ıh\\q9 \\ÈŒá|JŒŠòV4«ÁxD?ƒÌ¶Öc¯ó‹w^–Bˆ¢z3æC(æ‘Kš™İÌ©’7¦\0ß]Ã·çğØ¨Aƒ”ë5i²#\0ªãOÉåâİ.Óâ7¸êÃ©ş3Î|Â:'Héƒ£¨uN±×;Äì£¶\rÎØ<DJHè\"\\hh½&T»^{ÏEé¶…Ğ„bLH`Ñ1³ÆL	’,BOä†Eèá‰!0Çì˜#…®¶aÑòheå³4‚V”{j¬»pA	‰¬{å„Â‘6GBZ%&L`Ö)¤ªaBBĞ°™¿b€H\n‘‹¢„ÀÆ˜p('À¤Ö†RÁŒ*8GE%E2:Ci/2¬\r™³ \n4+x“’’VE¡0#0ÄŸPèEƒ8'\$f—È°w!ƒt}(9~–ò¸«T	HŒ1’TÈ™oxÅ…¡†Ó¶¤ªØ“h†0¦‚4&+±ø…2rDóY8\$4:Ê¦<‰A*%„ºP“D6îVé}`,)v¼Ò]Á\0ICäïµï7\"£\$È¾ÊÖêúƒ±pîÄ95R*£<²)j=\"7ş'q*,\$ØÏPàÇ›?%s,(ğ¦!ğl?+`¾?D!|;PqH¢èœÄÉê÷-¸3Î™›L&TêØ——“²C\"‹,Ö0¢	©7k €#HÖdWLH!Ä@‰Oã<Ù£6­Ğ‘‡	º	„4r¥™²KbÄGB*‰Qa¸–0¹Ò\"¸\n«*)F÷*|«\rc«aÑŠÊ\nÀ‡T¢ˆ¬•q•põ;a0ŠêN>U¥lˆµw2uæ·‘ÕJ\\ã\n®ÕáAšCLMt0à¬Š— A‘¸U\nƒ‚ÎÃ!¢”°Ív¯2@Â\nJé’åö¦Ô÷ğËÈå||6¬ÙZĞäK-}a.á¼ ó€¯ˆ‘BDdk`Ô\n\rtqüÜ Nu‹]	¦ï‘(dÀQÁ0†İŠ¡bM0¸öŞÆ¿²iv­G(99\$å,¸K\"ÁÁõ#DÉeC7Ad‡Ÿ\$¨yM½K¡¼<bÈŒÃ&‰—™µ¿jL€r¶V¨È¤·Q0nA,6ãtI\rN¶åh6â\$níé|_²rŒQC'2U5ÉÅéRa,­¡Í«Æ.Â€";break;case"vi":$f="%ÌÂ˜(–ha­\rÆqĞĞá] á®ÒŒÓ]¡Îc\rTnA˜jÓ¢hc,\"	³b5HÅØ‰q† 	Nd)	R!/5Â!PÃ¤A&n‰®”&™°0Œ†cA¨Øn8‚ˆQE\r ÆÃYˆ\$±EyŒt9D0°QŠ(£¤íVh<&b°-Ñ[¹ºno”â\nÓ(©U`Ô+½~Âda¬®æH‚¾8iŸDåµ\\¤PnĞÌp€âu<Ä4ƒk{¸C3‡™	2Rum–£´Ş˜]/ãtUÚ–[­]á7;qöqwñN(¦a;m…ƒ{\rB\n'îÙ»’í_ÖÁˆ2œ[aTÜk7Îôƒ)Èäo9HH†¡„Ä0c+Ô7Œ£›67ˆ ê8Ä8@˜îü‰†Šê@à‡¢¨» \\®ãj LÁ+@ŞÆ»Él7)vO„IvL®ã˜Â:‡IÈæ§èÚfa”kÂÃjcĞ]’/ÄP!\0ÎÌdè!ª K P› k¼<ËM\0ÎÃ\rêà@™Äh4 A³N!c3’(7\$ÈXĞb,(„4£ÊBŠ]£ƒ\r>¼‰J NÃÆA1‰¨¡[¨(¡RÜ„ˆA¯°åòƒ,™ÒôÍÅÑ\"OC¢òxÂ70ÌCŒ‹Ğò:¡@æLpÑ(`PH…¡ g`†´Xé\rn~Å/e,1¢Làa”MÃ]èØğêPTêV‹ÃŠè\$&ó¤á»c+4J<ü®K\"@	¢ht)Š`P¶<ßƒÈº£hZ2€P±u=L«.ÌIÔº:pHx0§Ağä2ƒ¨ä¤Ua\0Âû#ÈxŒ!òC‰â¢N3\r#>42äy,t;QÓô4ÆÃÙaÏÀ@2Ïöw™çØpÊ<Vƒpæ4ÄñØıÜÃœR4CbĞ#{5ÀCxÌ3\rĞÊËeš±—e=Zî”#£>¥.&j‚(¸è›¢êÊ¾4Ã«¼ÍİS46E`@„rjôğŠR/3U€A\r˜eÔ72£\nCJËˆvÙ8ÎX×Ùö í!‚È6ìC—1é£HÈú„Ÿ‹ŒÁèD4ƒ à9‡Ax^;ùpÃ×ö!sğ3…ú\0^2Dïæ˜7á}êh#§Y˜äÀP¡vPˆé@é;)ú[È0á~:pÜD›PS\r•4ñª^ÉGRå&´ßiÔA+„;’jã¾x	â<gŞSÌ\rÇÕç' ôš;Iihì±SzJø¡\$¤Ùó¾ÎDRr,Eª§0Ğ…‘c“C„X½?Â`Ù U¨0†7¼‰Á\0w\r!°6¤«©A´2«Â• rAAŒ1Ã€Ìb(l\ré<¤D\"IĞ6‰…‰‹»pÜ÷ƒliÅÔ¡¤(eQr0FHÑ1•¶øWÅ2N\"è[  'YFh‡‹±.CQ’A\$¡½›%4Oáó¬!²08 ÒvYØg‰®M fpĞLi‹AŞ&“ÖğÑo5ÕÒT'É¨sBUš'àÑ+Ãpp¨=¡0ä¬Cºì„nÀ3¼7@-‘.,’  Î‘h&¡)… ŒİKñH	5:*28¼Òk3Hˆ]\n°êéR	qª™­t†Hj¡(Š¸\0PçvPÂìQ ”·Ü9 ……¢}‰Òîq	Šp&².1RpÏº!Dh\$1N\$ºE'0)\$!\$‡–´z´ †á¹Xé>ÅÍ:A!˜û'\\ì œR!Í\0±E¤ 2“Gé…62Ra¡#à¼(ğ¦ëp‚ìMÀUÈâaIoYéöK	q\r\rì[’Ğé<¡Xº²aŠÅÌ\n	]î9Q¦ŞWcs‹…	şB_PŠB.á*Hœà&ñÎ‘Œc\nDë2ÔøŒÎp>¡;ÎlH%Éİ;&ê€–QÎªâtH\\’+å!övC	ÄªF	ÈpR”€†Z\"-Y¯ ¿Â–şZ”'\"G Â#Â2Fí4KÏµ¶CQt,LjURE *…@ŒAÅœH6fvSÔdL=]¶:6Py\nDƒÃ±L.Æ¤s•?È©Ò2–ŒêÇd(‡VğÂ„E_\\ª	¾–êÓ?4â.íM¶°Öà]ˆ³6MÍ£a@Ä°“Íy:”\n¬ÙÅ4‹`cJÉ!,…Cº(\nAnFr¢7ÒŞÃP12I*«½ƒ!=ƒ%jÄÛ­\\ŞR\"éI¬e²¯UÚ§è™B+Œl[~H0I\"ëâ»ÌMfq3WÆa";break;case"zh":$f="%ÌÂ:\$\nr.®„öŠr/d²È»[8Ğ S™8€r©NT*Ğ®\\9ÓHH¤Z1!S¹VøJè@%9£QÉl]m	F¹U©‡*qQ;CˆÈf4†ãÌu¨s¨UÎUt —w¯à§:¥t\nr£“îU:.:²PÇ‘.…\r7d^%äŒu’’)c©xšU`æF«©j»šárs'Pn”ÊAÌ›ZE…úfªº]£Eúv„˜„itîUÊÙÎ»SëÕ®{Íîû¤ÓPõ‹g5ÿ	EÂPıNå1	VÚ\n¢èW«]\n„!z¿s¥Ôâ©ÎŸRºR‰‚¿†ÄV×I:™(¯s#.UzÎ @Ò:w'_²T\$‰ùpV¸LùÌD•')bJ¬\$ÒpÅ¢©ñÊ[–MZŒó–\n.Á”¨ñ>så±ÒK–‹AZKœåaL„–HAtF3„ÙÊDË!zHµäâĞC”é*r“eñÊ^”K#´s¹ÎX—g)<·6‹Òør“.Ûÿ\$ç) F­«î@¬„Ìš^’®+â@œó‡2³G)v]ÏC£ A\rRxLëA SA b£¤8s–’*.]œÄ\"h^‘§9zW#¤s\0]îyAÈ)ÊEìttIÌE•+!¨ÀP\$Bhš\nb˜-5èò.…ÃhÚƒ TUUdâÃÎiÀ@6£˜èƒ\npC(è:Cp@0ÛÃä9#ÈxŒ!ğ\\Z¶¸†7Ã0Ò3Ûƒ-Ït¦ã˜@4ÛÉÅÖs”ÓCµ|„A--ïş	ƒapDJ©™.ĞC`è9*ÊÁL]œåÑ~rD3N(\$QC*JÓQ³Í3~R'Ai•‹‹Îé	4°Æyn›ÎÑ™t’KY G\$:Wâ¼HTdşZrålYODş»Ğ‚2\r·àÊ9gÙĞ@gA2H¦²FØ]•–¨@4[#0z\r è8aĞ^ü\\0ìä\rãÎŒ£p^2^è4ŞxD1±X_,\$AĞE–)iÒP–§I:Q,\$Mî)‰4è4Ğ¦ql¹ö’F³ZœÉÖ—l¼üBe—fNéŞåº»¶ñ½o›÷Áp›İ±ñWÇ£ÀéÆ|§ZïÜÁ}^K'1fJ¤ğI\\AœÅpr\$)ÊFØ‰~Bôri ÂNÓ®v¸ø#+E æb5S!QECOj-pÿq6.ĞŒ%Bª\nÓÒî‘ûG@âœºÃcÄâªaÈ,·—S<@\$\nÑø€¡Î“‡Rï\n	%\$âàÎ	áÌ#…*3œD¾“\$9ÅX¯¢<Q˜³œDD=&,«—±&``Ùô>Çàä\$\n.ñfÂ€^6S;Åy£™>Ax:8´Db¸tŠ!1KR@XÂˆ€@Â˜RÀ€‹ŠH™	ˆÙûvé´G‰PI‹¨å­4l!^ \$D“ˆÂ‰Ç0®«-¤ˆòv~Ç(¢ÊŒP/–\")„æÂpÆ Zc¡p‰\"â9¯½&Çä°€\$ÌøsíRÈ…h@‡Fé]9H\n<)…F\nœŠØ¤DÂW³æ¨#É‘Yg¥ƒ6wí,¥£\"J©qÊ\$Hp»‘q\0C¢.xD¯â#@ CÈˆ &	8E…0¢	é/5³2VN•c±b(QœÁ2)¹‚Æ(»¼.fD°°¤4‹#z`)á4ˆMŠä]Ó¬Œ®šÅ1/’±°,ÅˆÉ„/DxCbá°İÉ¤~!Ô€Ÿ|rˆî/ÄÜ%4‚¸÷” K…°åoö\n ª0-	E/”Šs	^\r¦19,…V*N€¥b•n®¬q2PTáhšC @‰CH\\D\n}J&Øë5Ò°mKàébú#ŠZø%Íyª¢ñˆˆ¡@:ìs3êu§9ihrXî‘Ó\$R<H9\"\0¹ñ'.‘Õo\"0´!Er@¤((Ñ.‹Æ¨Yë‘‚‚†2¨¥(­*˜b•ešš¹fZMIà";break;case"zh-tw":$f="%ÌÂ:\$\ns¡.ešUÈ¸E9PK72©(æP¢h)Ê…@º:i	‹Æaè§Je åR)Ü«{º	Nd(ÜvQDCÑ®UjaÊœTOABÀPÀb2£a¸àr\nr/TuéÊ®M9Rèçzñ?T×Èò9>åS¢ÁNe’IÌœDºhw2Y2èPÒc…º¡Ğ¼WÜÒË*‰=sºİï7»íıBŒ¥9J‹¥Úñ\"X¹Qê÷2±æM­/«J2å@\"ïWËör¡TDÄ{u¼‡©œë•ãtŒsápøÎî‹ÁÕãSĞô\\=\0çV¡«ôïp­\"RÕ )ĞªOH…êıÎ”T\\ÓŠ§:}JéF+üêJVÏ*r—EZ„s!Z¥y®éVê½¯yPê¤A.–ÈyZë6YÌIÁ)\ns	ÎZ‰ÈæÌ¢ÊÊ[¹Ê2Ì’¥ÂˆK®d¹J»“ç12A\$±&¤ºY+;ZY+\$j[GAnæ%ò²J½sàt)ÒP“Ç)<¹9,3r“/‰Ê\\gA2³Á0YD¶äÉv”«™`\\…É:Îä,òè±ÇIA?“epŒ\0Ä<ƒ(P9…+™0æ0!pHÓÁªæH‰šäreÙÌBòiÎ^ÑG1I@x–¥ë<E¡Åé9[%Ä>C¡y|£¾\"@	¢ht)Š`P¶<ÚƒÈº\r£h\\2–„IïòıEa\0Ú:c @)Ğ|9£ ê9\rÁ\0ÃzŒ#ä0!à^0‡Ápv]ÂŞ7ÃHÏyŒ·öMê`G9L@ÂXÌDÇ)*Oã)ĞA’ØÔ@Äq,NB)P©.ÛC`è9.lÙÒM”NI4rD2”r…Òî¡Í(DìråÖŒ]¿\"`XœÄ©.Ò¡q©Ò@‘É4²‘‡DœÑ°©t’\n1|F\$9t%32D%äVA£é,ÉOa:¬ËE@‚2\r¸Ê9kšód@g1\nW&ÚH¶Ø\r€Ì„C@è:˜t…ã¿D<9Ãxä3…ã(ÜŒ˜8Â:\r88^Ç1H4¥òÊD^ Kç<¡C+)‡ÊP¦2cŸkzÅå–®GGœ,´‘­]<gåÄïA¯¯'¼Ÿ*2òüÏ7ÎóıGÒğ#wÔõ}o^2ˆÜô°\"]Î b%^cÂä†	QĞ+„™_q)í>ˆQÊ#³Îzêô¼(\0¢ly2+E\"¥eR‹²Ûqíñ	q6„È\$Ã˜C	>&”M­œr‰ñn`Áƒ!\$-“¢\$H‰‘A3Â%T´®0´\$¨¤(€ Èâk)Šß“§”øJ 4´Q«!J…E€ç00ÓDQ@R¢[Qn	Ğ+DI™3f((¶œPb2HpØrÒ9…\0¼k†´×š1Ğ ÅèæRäÌG‚¨Kğé§áÊ&ã¼J!Qê-‚\0†ÂFĞ7†·\\O\\3Ü{Âd^ÒB`G(–Çô[%æ°GÉ	#és\nájÔEÃi&°ìN`L‹\\¸AçHrˆ¡@Š™h¦C˜O	Ã4„ÅÀ¦3¦J!‰æşı\\u—¢\0 ñÌ,DÚc¤K‰Ä‚\"G4(y¤NŠ\"”xS\n€qñH*¦¹=ÂàM“8üeó\$KXÇMÙ¾È¢Ù\"¥|°Í“9Í¯UÜ@	§®‚ P%dHYÍtÄ\"Â˜Q	„ àÎÖ€Ğ„ãDqğ6Øõ”<6ÏTtB\$*xÄÉü0oTÔ£¡”DÃªhÁB	ê±R§ƒQ€Õõh¸ˆ1‚ôX‘>/ÌÈŒŠ‚ôG„6f…r:ÇPs	ò^lM„óJ&\\rñ\\Ê,ƒ–(b‚„O€U\nƒ„Êƒj0‚â½<6\neãÄ«!­]o®R”hÁ–>6Ã‰Ar­ÄÉCÂ¨†®'¨˜›R³ğNbS)ËK0ÔåˆØ‰Ä€äÂÖXƒú/Jxª­j†k Ò·ùMfÎuAs\"\0É\\‰È¯ëH#ÈÂÒ]‘Ğ)£¤xü´†•fÓÁ)5\0\n±Ì©1æµ,Â\$M·kEÊ_L)Œ";break;}$Dg=array();foreach(explode("\n",lzw_decompress($f))as$X)$Dg[]=(strpos($X,"\t")?explode("\t",$X):$X);return$Dg;}abstract
class
SqlDb{static$instance;var$extension;var$flavor='';var$server_info;var$affected_rows=0;var$info='';var$errno=0;var$error='';protected$multi;abstract
function
attach($M,$V,$D);abstract
function
quote($Q);abstract
function
select_db($tb);abstract
function
query($F,$Mg=false);function
multi_query($F){return$this->multi=$this->query($F);}function
store_result(){return$this->multi;}function
next_result(){return
false;}}if(extension_loaded('pdo')){abstract
class
PdoDb
extends
SqlDb{protected$pdo;function
dsn($Jb,$V,$D,array$B=array()){$B[\PDO::ATTR_ERRMODE]=\PDO::ERRMODE_SILENT;$B[\PDO::ATTR_STATEMENT_CLASS]=array('Adminer\PdoResult');try{$this->pdo=new
\PDO($Jb,$V,$D,$B);}catch(\Exception$ac){return$ac->getMessage();}$this->server_info=@$this->pdo->getAttribute(\PDO::ATTR_SERVER_VERSION);return'';}function
quote($Q){return$this->pdo->quote($Q);}function
query($F,$Mg=false){$G=$this->pdo->query($F);$this->error="";if(!$G){list(,$this->errno,$this->error)=$this->pdo->errorInfo();if(!$this->error)$this->error=lang(21);return
false;}$this->store_result($G);return$G;}function
store_result($G=null){if(!$G){$G=$this->multi;if(!$G)return
false;}if($G->columnCount()){$G->num_rows=$G->rowCount();return$G;}$this->affected_rows=$G->rowCount();return
true;}function
next_result(){$G=$this->multi;if(!is_object($G))return
false;$G->_offset=0;return@$G->nextRowset();}}class
PdoResult
extends
\PDOStatement{var$_offset=0,$num_rows;function
fetch_assoc(){return$this->fetch_array(\PDO::FETCH_ASSOC);}function
fetch_row(){return$this->fetch_array(\PDO::FETCH_NUM);}private
function
fetch_array($ee){$H=$this->fetch($ee);return($H?array_map(array($this,'unresource'),$H):$H);}private
function
unresource($X){return(is_resource($X)?stream_get_contents($X):$X);}function
fetch_field(){$I=(object)$this->getColumnMeta($this->_offset++);$U=$I->pdo_type;$I->type=($U==\PDO::PARAM_INT?0:15);$I->charsetnr=($U==\PDO::PARAM_LOB||(isset($I->flags)&&in_array("blob",(array)$I->flags))?63:0);return$I;}function
seek($re){for($r=0;$r<$re;$r++)$this->fetch();}}}function
add_driver($s,$_){SqlDriver::$drivers[$s]=$_;}function
get_driver($s){return
SqlDriver::$drivers[$s];}abstract
class
SqlDriver{static$instance;static$drivers=array();static$extensions=array();static$jush;protected$conn;protected$types=array();var$insertFunctions=array();var$editFunctions=array();var$unsigned=array();var$operators=array();var$functions=array();var$grouping=array();var$onActions="RESTRICT|NO ACTION|CASCADE|SET NULL|SET DEFAULT";var$partitionBy=array();var$inout="IN|OUT|INOUT";var$enumLength="'(?:''|[^'\\\\]|\\\\.)*'";var$generated=array();static
function
connect($M,$V,$D){$g=new
Db;return($g->attach($M,$V,$D)?:$g);}function
__construct(Db$g){$this->conn=$g;}function
types(){return
call_user_func_array('array_merge',array_values($this->types));}function
structuredTypes(){return
array_map('array_keys',$this->types);}function
enumLength(array$l){}function
unconvertFunction(array$l){}function
select($R,array$K,array$Z,array$Gc,array$Ce=array(),$x=1,$C=0,$hf=false){$td=(count($Gc)<count($K));$F=adminer()->selectQueryBuild($K,$Z,$Gc,$Ce,$x,$C);if(!$F)$F="SELECT".limit(($_GET["page"]!="last"&&$x&&$Gc&&$td&&JUSH=="sql"?"SQL_CALC_FOUND_ROWS ":"").implode(", ",$K)."\nFROM ".table($R),($Z?"\nWHERE ".implode(" AND ",$Z):"").($Gc&&$td?"\nGROUP BY ".implode(", ",$Gc):"").($Ce?"\nORDER BY ".implode(", ",$Ce):""),$x,($C?$x*$C:0),"\n");$bg=microtime(true);$H=$this->conn->query($F);if($hf)echo
adminer()->selectQuery($F,$bg,!$H);return$H;}function
delete($R,$nf,$x=0){$F="FROM ".table($R);return
queries("DELETE".($x?limit1($R,$F,$nf):" $F$nf"));}function
update($R,array$N,$nf,$x=0,$L="\n"){$bh=array();foreach($N
as$w=>$X)$bh[]="$w = $X";$F=table($R)." SET$L".implode(",$L",$bh);return
queries("UPDATE".($x?limit1($R,$F,$nf,$L):" $F$nf"));}function
insert($R,array$N){return
queries("INSERT INTO ".table($R).($N?" (".implode(", ",array_keys($N)).")\nVALUES (".implode(", ",$N).")":" DEFAULT VALUES").$this->insertReturning($R));}function
insertReturning($R){return"";}function
insertUpdate($R,array$J,array$E){return
false;}function
begin(){return
queries("BEGIN");}function
commit(){return
queries("COMMIT");}function
rollback(){return
queries("ROLLBACK");}function
slowQuery($F,$tg){}function
convertSearch($t,array$X,array$l){return$t;}function
convertOperator($ze){return$ze;}function
value($X,array$l){return(method_exists($this->conn,'value')?$this->conn->value($X,$l):$X);}function
quoteBinary($Bf){return
q($Bf);}function
warnings(){}function
tableHelp($_,$wd=false){}function
inheritsFrom($R){return
array();}function
inheritedTables($R){return
array();}function
partitionsInfo($R){return
array();}function
hasCStyleEscapes(){return
false;}function
engines(){return
array();}function
supportsIndex(array$S){return!is_view($S);}function
indexAlgorithms(array$ig){return
array();}function
checkConstraints($R){return
get_key_vals("SELECT c.CONSTRAINT_NAME, CHECK_CLAUSE
FROM INFORMATION_SCHEMA.CHECK_CONSTRAINTS c
JOIN INFORMATION_SCHEMA.TABLE_CONSTRAINTS t ON c.CONSTRAINT_SCHEMA = t.CONSTRAINT_SCHEMA AND c.CONSTRAINT_NAME = t.CONSTRAINT_NAME
WHERE c.CONSTRAINT_SCHEMA = ".q($_GET["ns"]!=""?$_GET["ns"]:DB)."
AND t.TABLE_NAME = ".q($R)."
AND CHECK_CLAUSE NOT LIKE '% IS NOT NULL'",$this->conn);}function
allFields(){$H=array();if(DB!=""){foreach(get_rows("SELECT TABLE_NAME AS tab, COLUMN_NAME AS field, IS_NULLABLE AS nullable, DATA_TYPE AS type, CHARACTER_MAXIMUM_LENGTH AS length".(JUSH=='sql'?", COLUMN_KEY = 'PRI' AS `primary`":"")."
FROM INFORMATION_SCHEMA.COLUMNS
WHERE TABLE_SCHEMA = ".q($_GET["ns"]!=""?$_GET["ns"]:DB)."
ORDER BY TABLE_NAME, ORDINAL_POSITION",$this->conn)as$I){$I["null"]=($I["nullable"]=="YES");$H[$I["tab"]][]=$I;}}return$H;}}add_driver("sqlite","SQLite");if(isset($_GET["sqlite"])){define('Adminer\DRIVER',"sqlite");if(class_exists("SQLite3")&&$_GET["ext"]!="pdo"){abstract
class
SqliteDb
extends
SqlDb{var$extension="SQLite3";private$link;function
attach($n,$V,$D){$this->link=new
\SQLite3($n);$dh=$this->link->version();$this->server_info=$dh["versionString"];return'';}function
query($F,$Mg=false){$G=@$this->link->query($F);$this->error="";if(!$G){$this->errno=$this->link->lastErrorCode();$this->error=$this->link->lastErrorMsg();return
false;}elseif($G->numColumns())return
new
Result($G);$this->affected_rows=$this->link->changes();return
true;}function
quote($Q){return(is_utf8($Q)?"'".$this->link->escapeString($Q)."'":"x'".first(unpack('H*',$Q))."'");}}class
Result{var$num_rows;private$result,$offset=0;function
__construct($G){$this->result=$G;}function
fetch_assoc(){return$this->result->fetchArray(SQLITE3_ASSOC);}function
fetch_row(){return$this->result->fetchArray(SQLITE3_NUM);}function
fetch_field(){$d=$this->offset++;$U=$this->result->columnType($d);return(object)array("name"=>$this->result->columnName($d),"type"=>($U==SQLITE3_TEXT?15:0),"charsetnr"=>($U==SQLITE3_BLOB?63:0),);}function
__destruct(){$this->result->finalize();}}}elseif(extension_loaded("pdo_sqlite")){abstract
class
SqliteDb
extends
PdoDb{var$extension="PDO_SQLite";function
attach($n,$V,$D){$this->dsn(DRIVER.":$n","","");$this->query("PRAGMA foreign_keys = 1");$this->query("PRAGMA busy_timeout = 500");return'';}}}if(class_exists('Adminer\SqliteDb')){class
Db
extends
SqliteDb{function
attach($n,$V,$D){parent::attach($n,$V,$D);$this->query("PRAGMA foreign_keys = 1");$this->query("PRAGMA busy_timeout = 500");return'';}function
select_db($n){if(is_readable($n)&&$this->query("ATTACH ".$this->quote(preg_match("~(^[/\\\\]|:)~",$n)?$n:dirname($_SERVER["SCRIPT_FILENAME"])."/$n")." AS a"))return!self::attach($n,'','');return
false;}}}class
Driver
extends
SqlDriver{static$extensions=array("SQLite3","PDO_SQLite");static$jush="sqlite";protected$types=array(array("integer"=>0,"real"=>0,"numeric"=>0,"text"=>0,"blob"=>0));var$insertFunctions=array();var$editFunctions=array("integer|real|numeric"=>"+/-","text"=>"||",);var$operators=array("=","<",">","<=",">=","!=","LIKE","LIKE %%","IN","IS NULL","NOT LIKE","NOT IN","IS NOT NULL","SQL");var$functions=array("hex","length","lower","round","unixepoch","upper");var$grouping=array("avg","count","count distinct","group_concat","max","min","sum");static
function
connect($M,$V,$D){if($D!="")return
lang(22);return
parent::connect(":memory:","","");}function
__construct(Db$g){parent::__construct($g);if(min_version(3.31,0,$g))$this->generated=array("STORED","VIRTUAL");}function
structuredTypes(){return
array_keys($this->types[0]);}function
insertUpdate($R,array$J,array$E){$bh=array();foreach($J
as$N)$bh[]="(".implode(", ",$N).")";return
queries("REPLACE INTO ".table($R)." (".implode(", ",array_keys(reset($J))).") VALUES\n".implode(",\n",$bh));}function
tableHelp($_,$wd=false){if($_=="sqlite_sequence")return"fileformat2.html#seqtab";if($_=="sqlite_master")return"fileformat2.html#$_";}function
checkConstraints($R){preg_match_all('~ CHECK *(\( *(((?>[^()]*[^() ])|(?1))*) *\))~',get_val("SELECT sql FROM sqlite_master WHERE type = 'table' AND name = ".q($R),0,$this->conn),$Td);return
array_combine($Td[2],$Td[2]);}function
allFields(){$H=array();foreach(tables_list()as$R=>$U){foreach(fields($R)as$l)$H[$R][]=$l;}return$H;}}function
idf_escape($t){return'"'.str_replace('"','""',$t).'"';}function
table($t){return
idf_escape($t);}function
get_databases($uc){return
array();}function
limit($F,$Z,$x,$re=0,$L=" "){return" $F$Z".($x?$L."LIMIT $x".($re?" OFFSET $re":""):"");}function
limit1($R,$F,$Z,$L="\n"){return(preg_match('~^INTO~',$F)||get_val("SELECT sqlite_compileoption_used('ENABLE_UPDATE_DELETE_LIMIT')")?limit($F,$Z,1,0,$L):" $F WHERE rowid = (SELECT rowid FROM ".table($R).$Z.$L."LIMIT 1)");}function
db_collation($i,$Wa){return
get_val("PRAGMA encoding");}function
logged_user(){return
get_current_user();}function
tables_list(){return
get_key_vals("SELECT name, type FROM sqlite_master WHERE type IN ('table', 'view') ORDER BY (name = 'sqlite_sequence'), name");}function
count_tables($ub){return
array();}function
table_status($_=""){$H=array();foreach(get_rows("SELECT name AS Name, type AS Engine, 'rowid' AS Oid, '' AS Auto_increment FROM sqlite_master WHERE type IN ('table', 'view') ".($_!=""?"AND name = ".q($_):"ORDER BY name"))as$I){$I["Rows"]=get_val("SELECT COUNT(*) FROM ".idf_escape($I["Name"]));$H[$I["Name"]]=$I;}foreach(get_rows("SELECT * FROM sqlite_sequence".($_!=""?" WHERE name = ".q($_):""),null,"")as$I)$H[$I["name"]]["Auto_increment"]=$I["seq"];return$H;}function
is_view($S){return$S["Engine"]=="view";}function
fk_support($S){return!get_val("SELECT sqlite_compileoption_used('OMIT_FOREIGN_KEY')");}function
fields($R){$H=array();$E="";foreach(get_rows("PRAGMA table_".(min_version(3.31)?"x":"")."info(".table($R).")")as$I){$_=$I["name"];$U=strtolower($I["type"]);$j=$I["dflt_value"];$H[$_]=array("field"=>$_,"type"=>(preg_match('~int~i',$U)?"integer":(preg_match('~char|clob|text~i',$U)?"text":(preg_match('~blob~i',$U)?"blob":(preg_match('~real|floa|doub~i',$U)?"real":"numeric")))),"full_type"=>$U,"default"=>(preg_match("~^'(.*)'$~",$j,$z)?str_replace("''","'",$z[1]):($j=="NULL"?null:$j)),"null"=>!$I["notnull"],"privileges"=>array("select"=>1,"insert"=>1,"update"=>1,"where"=>1,"order"=>1),"primary"=>$I["pk"],);if($I["pk"]){if($E!="")$H[$E]["auto_increment"]=false;elseif(preg_match('~^integer$~i',$U))$H[$_]["auto_increment"]=true;$E=$_;}}$Yf=get_val("SELECT sql FROM sqlite_master WHERE type = 'table' AND name = ".q($R));$t='(("[^"]*+")+|[a-z0-9_]+)';preg_match_all('~'.$t.'\s+text\s+COLLATE\s+(\'[^\']+\'|\S+)~i',$Yf,$Td,PREG_SET_ORDER);foreach($Td
as$z){$_=str_replace('""','"',preg_replace('~^"|"$~','',$z[1]));if($H[$_])$H[$_]["collation"]=trim($z[3],"'");}preg_match_all('~'.$t.'\s.*GENERATED ALWAYS AS \((.+)\) (STORED|VIRTUAL)~i',$Yf,$Td,PREG_SET_ORDER);foreach($Td
as$z){$_=str_replace('""','"',preg_replace('~^"|"$~','',$z[1]));$H[$_]["default"]=$z[3];$H[$_]["generated"]=strtoupper($z[4]);}return$H;}function
indexes($R,$h=null){$h=connection($h);$H=array();$Yf=get_val("SELECT sql FROM sqlite_master WHERE type = 'table' AND name = ".q($R),0,$h);if(preg_match('~\bPRIMARY\s+KEY\s*\((([^)"]+|"[^"]*"|`[^`]*`)++)~i',$Yf,$z)){$H[""]=array("type"=>"PRIMARY","columns"=>array(),"lengths"=>array(),"descs"=>array());preg_match_all('~((("[^"]*+")+|(?:`[^`]*+`)+)|(\S+))(\s+(ASC|DESC))?(,\s*|$)~i',$z[1],$Td,PREG_SET_ORDER);foreach($Td
as$z){$H[""]["columns"][]=idf_unescape($z[2]).$z[4];$H[""]["descs"][]=(preg_match('~DESC~i',$z[5])?'1':null);}}if(!$H){foreach(fields($R)as$_=>$l){if($l["primary"])$H[""]=array("type"=>"PRIMARY","columns"=>array($_),"lengths"=>array(),"descs"=>array(null));}}$ag=get_key_vals("SELECT name, sql FROM sqlite_master WHERE type = 'index' AND tbl_name = ".q($R),$h);foreach(get_rows("PRAGMA index_list(".table($R).")",$h)as$I){$_=$I["name"];$u=array("type"=>($I["unique"]?"UNIQUE":"INDEX"));$u["lengths"]=array();$u["descs"]=array();foreach(get_rows("PRAGMA index_info(".idf_escape($_).")",$h)as$Af){$u["columns"][]=$Af["name"];$u["descs"][]=null;}if(preg_match('~^CREATE( UNIQUE)? INDEX '.preg_quote(idf_escape($_).' ON '.idf_escape($R),'~').' \((.*)\)$~i',$ag[$_],$tf)){preg_match_all('/("[^"]*+")+( DESC)?/',$tf[2],$Td);foreach($Td[2]as$w=>$X){if($X)$u["descs"][$w]='1';}}if(!$H[""]||$u["type"]!="UNIQUE"||$u["columns"]!=$H[""]["columns"]||$u["descs"]!=$H[""]["descs"]||!preg_match("~^sqlite_~",$_))$H[$_]=$u;}return$H;}function
foreign_keys($R){$H=array();foreach(get_rows("PRAGMA foreign_key_list(".table($R).")")as$I){$o=&$H[$I["id"]];if(!$o)$o=$I;$o["source"][]=$I["from"];$o["target"][]=$I["to"];}return$H;}function
view($_){return
array("select"=>preg_replace('~^(?:[^`"[]+|`[^`]*`|"[^"]*")* AS\s+~iU','',get_val("SELECT sql FROM sqlite_master WHERE type = 'view' AND name = ".q($_))));}function
collations(){return(isset($_GET["create"])?get_vals("PRAGMA collation_list",1):array());}function
information_schema($i){return
false;}function
error(){return
h(connection()->error);}function
check_sqlite_name($_){$fc="db|sdb|sqlite";if(!preg_match("~^[^\\0]*\\.($fc)\$~",$_)){connection()->error=lang(23,str_replace("|",", ",$fc));return
false;}return
true;}function
create_database($i,$c){if(file_exists($i)){connection()->error=lang(24);return
false;}if(!check_sqlite_name($i))return
false;try{$y=new
Db();$y->attach($i,'','');}catch(\Exception$ac){connection()->error=$ac->getMessage();return
false;}$y->query('PRAGMA encoding = "UTF-8"');$y->query('CREATE TABLE adminer (i)');$y->query('DROP TABLE adminer');return
true;}function
drop_databases($ub){connection()->attach(":memory:",'','');foreach($ub
as$i){if(!@unlink($i)){connection()->error=lang(24);return
false;}}return
true;}function
rename_database($_,$c){if(!check_sqlite_name($_))return
false;connection()->attach(":memory:",'','');connection()->error=lang(24);return@rename(DB,$_);}function
auto_increment(){return" PRIMARY KEY AUTOINCREMENT";}function
alter_table($R,$_,$m,$wc,$ab,$Sb,$c,$ta,$Se){$Xg=($R==""||$wc);foreach($m
as$l){if($l[0]!=""||!$l[1]||$l[2]){$Xg=true;break;}}$b=array();$Ie=array();foreach($m
as$l){if($l[1]){$b[]=($Xg?$l[1]:"ADD ".implode($l[1]));if($l[0]!="")$Ie[$l[0]]=$l[1][0];}}if(!$Xg){foreach($b
as$X){if(!queries("ALTER TABLE ".table($R)." $X"))return
false;}if($R!=$_&&!queries("ALTER TABLE ".table($R)." RENAME TO ".table($_)))return
false;}elseif(!recreate_table($R,$_,$b,$Ie,$wc,$ta))return
false;if($ta){queries("BEGIN");queries("UPDATE sqlite_sequence SET seq = $ta WHERE name = ".q($_));if(!connection()->affected_rows)queries("INSERT INTO sqlite_sequence (name, seq) VALUES (".q($_).", $ta)");queries("COMMIT");}return
true;}function
recreate_table($R,$_,array$m,array$Ie,array$wc,$ta="",$v=array(),$Hb="",$ea=""){if($R!=""){if(!$m){foreach(fields($R)as$w=>$l){if($v)$l["auto_increment"]=0;$m[]=process_field($l,$l);$Ie[$w]=idf_escape($w);}}$gf=false;foreach($m
as$l){if($l[6])$gf=true;}$Ib=array();foreach($v
as$w=>$X){if($X[2]=="DROP"){$Ib[$X[1]]=true;unset($v[$w]);}}foreach(indexes($R)as$zd=>$u){$e=array();foreach($u["columns"]as$w=>$d){if(!$Ie[$d])continue
2;$e[]=$Ie[$d].($u["descs"][$w]?" DESC":"");}if(!$Ib[$zd]){if($u["type"]!="PRIMARY"||!$gf)$v[]=array($u["type"],$zd,$e);}}foreach($v
as$w=>$X){if($X[0]=="PRIMARY"){unset($v[$w]);$wc[]="  PRIMARY KEY (".implode(", ",$X[2]).")";}}foreach(foreign_keys($R)as$zd=>$o){foreach($o["source"]as$w=>$d){if(!$Ie[$d])continue
2;$o["source"][$w]=idf_unescape($Ie[$d]);}if(!isset($wc[" $zd"]))$wc[]=" ".format_foreign_key($o);}queries("BEGIN");}$Ka=array();foreach($m
as$l){if(preg_match('~GENERATED~',$l[3]))unset($Ie[array_search($l[0],$Ie)]);$Ka[]="  ".implode($l);}$Ka=array_merge($Ka,array_filter($wc));foreach(driver()->checkConstraints($R)as$Ma){if($Ma!=$Hb)$Ka[]="  CHECK ($Ma)";}if($ea)$Ka[]="  CHECK ($ea)";$ng=($R==$_?"adminer_$_":$_);if(!queries("CREATE TABLE ".table($ng)." (\n".implode(",\n",$Ka)."\n)"))return
false;if($R!=""){if($Ie&&!queries("INSERT INTO ".table($ng)." (".implode(", ",$Ie).") SELECT ".implode(", ",array_map('Adminer\idf_escape',array_keys($Ie)))." FROM ".table($R)))return
false;$Jg=array();foreach(triggers($R)as$Hg=>$ug){$Gg=trigger($Hg,$R);$Jg[]="CREATE TRIGGER ".idf_escape($Hg)." ".implode(" ",$ug)." ON ".table($_)."\n$Gg[Statement]";}$ta=$ta?"":get_val("SELECT seq FROM sqlite_sequence WHERE name = ".q($R));if(!queries("DROP TABLE ".table($R))||($R==$_&&!queries("ALTER TABLE ".table($ng)." RENAME TO ".table($_)))||!alter_indexes($_,$v))return
false;if($ta)queries("UPDATE sqlite_sequence SET seq = $ta WHERE name = ".q($_));foreach($Jg
as$Gg){if(!queries($Gg))return
false;}queries("COMMIT");}return
true;}function
index_sql($R,$U,$_,$e){return"CREATE $U ".($U!="INDEX"?"INDEX ":"").idf_escape($_!=""?$_:uniqid($R."_"))." ON ".table($R)." $e";}function
alter_indexes($R,$b){foreach($b
as$E){if($E[0]=="PRIMARY")return
recreate_table($R,$R,array(),array(),array(),"",$b);}foreach(array_reverse($b)as$X){if(!queries($X[2]=="DROP"?"DROP INDEX ".idf_escape($X[1]):index_sql($R,$X[0],$X[1],"(".implode(", ",$X[2]).")")))return
false;}return
true;}function
truncate_tables($T){return
apply_queries("DELETE FROM",$T);}function
drop_views($fh){return
apply_queries("DROP VIEW",$fh);}function
drop_tables($T){return
apply_queries("DROP TABLE",$T);}function
move_tables($T,$fh,$mg){return
false;}function
trigger($_,$R){if($_=="")return
array("Statement"=>"BEGIN\n\t;\nEND");$t='(?:[^`"\s]+|`[^`]*`|"[^"]*")+';$Ig=trigger_options();preg_match("~^CREATE\\s+TRIGGER\\s*$t\\s*(".implode("|",$Ig["Timing"]).")\\s+([a-z]+)(?:\\s+OF\\s+($t))?\\s+ON\\s*$t\\s*(?:FOR\\s+EACH\\s+ROW\\s)?(.*)~is",get_val("SELECT sql FROM sqlite_master WHERE type = 'trigger' AND name = ".q($_)),$z);$qe=$z[3];return
array("Timing"=>strtoupper($z[1]),"Event"=>strtoupper($z[2]).($qe?" OF":""),"Of"=>idf_unescape($qe),"Trigger"=>$_,"Statement"=>$z[4],);}function
triggers($R){$H=array();$Ig=trigger_options();foreach(get_rows("SELECT * FROM sqlite_master WHERE type = 'trigger' AND tbl_name = ".q($R))as$I){preg_match('~^CREATE\s+TRIGGER\s*(?:[^`"\s]+|`[^`]*`|"[^"]*")+\s*('.implode("|",$Ig["Timing"]).')\s*(.*?)\s+ON\b~i',$I["sql"],$z);$H[$I["name"]]=array($z[1],$z[2]);}return$H;}function
trigger_options(){return
array("Timing"=>array("BEFORE","AFTER","INSTEAD OF"),"Event"=>array("INSERT","UPDATE","UPDATE OF","DELETE"),"Type"=>array("FOR EACH ROW"),);}function
begin(){return
queries("BEGIN");}function
last_id($G){return
get_val("SELECT LAST_INSERT_ROWID()");}function
explain($g,$F){return$g->query("EXPLAIN QUERY PLAN $F");}function
found_rows($S,$Z){}function
types(){return
array();}function
create_sql($R,$ta,$dg){$H=get_val("SELECT sql FROM sqlite_master WHERE type IN ('table', 'view') AND name = ".q($R));foreach(indexes($R)as$_=>$u){if($_=='')continue;$H
.=";\n\n".index_sql($R,$u['type'],$_,"(".implode(", ",array_map('Adminer\idf_escape',$u['columns'])).")");}return$H;}function
truncate_sql($R){return"DELETE FROM ".table($R);}function
use_sql($tb){}function
trigger_sql($R){return
implode(get_vals("SELECT sql || ';;\n' FROM sqlite_master WHERE type = 'trigger' AND tbl_name = ".q($R)));}function
show_variables(){$H=array();foreach(get_rows("PRAGMA pragma_list")as$I){$_=$I["name"];if($_!="pragma_list"&&$_!="compile_options"){$H[$_]=array($_,'');foreach(get_rows("PRAGMA $_")as$I)$H[$_][1].=implode(", ",$I)."\n";}}return$H;}function
show_status(){$H=array();foreach(get_vals("PRAGMA compile_options")as$Ae)$H[]=explode("=",$Ae,2)+array('','');return$H;}function
convert_field($l){}function
unconvert_field($l,$H){return$H;}function
support($jc){return
preg_match('~^(check|columns|database|drop_col|dump|indexes|descidx|move_col|sql|status|table|trigger|variables|view|view_trigger)$~',$jc);}}add_driver("pgsql","PostgreSQL");if(isset($_GET["pgsql"])){define('Adminer\DRIVER',"pgsql");if(extension_loaded("pgsql")&&$_GET["ext"]!="pdo"){class
PgsqlDb
extends
SqlDb{var$extension="PgSQL";var$timeout=0;private$link,$string,$database=true;function
_error($Xb,$k){if(ini_bool("html_errors"))$k=html_entity_decode(strip_tags($k));$k=preg_replace('~^[^:]*: ~','',$k);$this->error=$k;}function
attach($M,$V,$D){$i=adminer()->database();set_error_handler(array($this,'_error'));$this->string="host='".str_replace(":","' port='",addcslashes($M,"'\\"))."' user='".addcslashes($V,"'\\")."' password='".addcslashes($D,"'\\")."'";$O=adminer()->connectSsl();if(isset($O["mode"]))$this->string
.=" sslmode='".$O["mode"]."'";$this->link=@pg_connect("$this->string dbname='".($i!=""?addcslashes($i,"'\\"):"postgres")."'",PGSQL_CONNECT_FORCE_NEW);if(!$this->link&&$i!=""){$this->database=false;$this->link=@pg_connect("$this->string dbname='postgres'",PGSQL_CONNECT_FORCE_NEW);}restore_error_handler();if($this->link)pg_set_client_encoding($this->link,"UTF8");return($this->link?'':$this->error);}function
quote($Q){return(function_exists('pg_escape_literal')?pg_escape_literal($this->link,$Q):"'".pg_escape_string($this->link,$Q)."'");}function
value($X,array$l){return($l["type"]=="bytea"&&$X!==null?pg_unescape_bytea($X):$X);}function
select_db($tb){if($tb==adminer()->database())return$this->database;$H=@pg_connect("$this->string dbname='".addcslashes($tb,"'\\")."'",PGSQL_CONNECT_FORCE_NEW);if($H)$this->link=$H;return$H;}function
close(){$this->link=@pg_connect("$this->string dbname='postgres'");}function
query($F,$Mg=false){$G=@pg_query($this->link,$F);$this->error="";if(!$G){$this->error=pg_last_error($this->link);$H=false;}elseif(!pg_num_fields($G)){$this->affected_rows=pg_affected_rows($G);$H=true;}else$H=new
Result($G);if($this->timeout){$this->timeout=0;$this->query("RESET statement_timeout");}return$H;}function
warnings(){return
h(pg_last_notice($this->link));}function
copyFrom($R,array$J){$this->error='';set_error_handler(function($Xb,$k){$this->error=(ini_bool('html_errors')?html_entity_decode($k):$k);return
true;});$H=pg_copy_from($this->link,$R,$J);restore_error_handler();return$H;}}class
Result{var$num_rows;private$result,$offset=0;function
__construct($G){$this->result=$G;$this->num_rows=pg_num_rows($G);}function
fetch_assoc(){return
pg_fetch_assoc($this->result);}function
fetch_row(){return
pg_fetch_row($this->result);}function
fetch_field(){$d=$this->offset++;$H=new
\stdClass;$H->orgtable=pg_field_table($this->result,$d);$H->name=pg_field_name($this->result,$d);$U=pg_field_type($this->result,$d);$H->type=(preg_match(number_type(),$U)?0:15);$H->charsetnr=($U=="bytea"?63:0);return$H;}function
__destruct(){pg_free_result($this->result);}}}elseif(extension_loaded("pdo_pgsql")){class
PgsqlDb
extends
PdoDb{var$extension="PDO_PgSQL";var$timeout=0;function
attach($M,$V,$D){$i=adminer()->database();$Jb="pgsql:host='".str_replace(":","' port='",addcslashes($M,"'\\"))."' client_encoding=utf8 dbname='".($i!=""?addcslashes($i,"'\\"):"postgres")."'";$O=adminer()->connectSsl();if(isset($O["mode"]))$Jb
.=" sslmode='".$O["mode"]."'";return$this->dsn($Jb,$V,$D);}function
select_db($tb){return(adminer()->database()==$tb);}function
query($F,$Mg=false){$H=parent::query($F,$Mg);if($this->timeout){$this->timeout=0;parent::query("RESET statement_timeout");}return$H;}function
warnings(){}function
copyFrom($R,array$J){$H=$this->pdo->pgsqlCopyFromArray($R,$J);$this->error=idx($this->pdo->errorInfo(),2)?:'';return$H;}function
close(){}}}if(class_exists('Adminer\PgsqlDb')){class
Db
extends
PgsqlDb{function
multi_query($F){if(preg_match('~\bCOPY\s+(.+?)\s+FROM\s+stdin;\n?(.*)\n\\\\\.$~is',str_replace("\r\n","\n",$F),$z)){$J=explode("\n",$z[2]);$this->affected_rows=count($J);return$this->copyFrom($z[1],$J);}return
parent::multi_query($F);}}}class
Driver
extends
SqlDriver{static$extensions=array("PgSQL","PDO_PgSQL");static$jush="pgsql";var$operators=array("=","<",">","<=",">=","!=","~","!~","LIKE","LIKE %%","ILIKE","ILIKE %%","IN","IS NULL","NOT LIKE","NOT ILIKE","NOT IN","IS NOT NULL");var$functions=array("char_length","lower","round","to_hex","to_timestamp","upper");var$grouping=array("avg","count","count distinct","max","min","sum");var$nsOid="(SELECT oid FROM pg_namespace WHERE nspname = current_schema())";static
function
connect($M,$V,$D){$g=parent::connect($M,$V,$D);if(is_string($g))return$g;$dh=get_val("SELECT version()",0,$g);$g->flavor=(preg_match('~CockroachDB~',$dh)?'cockroach':'');$g->server_info=preg_replace('~^\D*([\d.]+[-\w]*).*~','\1',$dh);if(min_version(9,0,$g))$g->query("SET application_name = 'Adminer'");if($g->flavor=='cockroach')add_driver(DRIVER,"CockroachDB");return$g;}function
__construct(Db$g){parent::__construct($g);$this->types=array(lang(25)=>array("smallint"=>5,"integer"=>10,"bigint"=>19,"boolean"=>1,"numeric"=>0,"real"=>7,"double precision"=>16,"money"=>20),lang(26)=>array("date"=>13,"time"=>17,"timestamp"=>20,"timestamptz"=>21,"interval"=>0),lang(27)=>array("character"=>0,"character varying"=>0,"text"=>0,"tsquery"=>0,"tsvector"=>0,"uuid"=>0,"xml"=>0),lang(28)=>array("bit"=>0,"bit varying"=>0,"bytea"=>0),lang(29)=>array("cidr"=>43,"inet"=>43,"macaddr"=>17,"macaddr8"=>23,"txid_snapshot"=>0),lang(30)=>array("box"=>0,"circle"=>0,"line"=>0,"lseg"=>0,"path"=>0,"point"=>0,"polygon"=>0),);if(min_version(9.2,0,$g)){$this->types[lang(27)]["json"]=4294967295;if(min_version(9.4,0,$g))$this->types[lang(27)]["jsonb"]=4294967295;}$this->insertFunctions=array("char"=>"md5","date|time"=>"now",);$this->editFunctions=array(number_type()=>"+/-","date|time"=>"+ interval/- interval","char|text"=>"||",);if(min_version(12,0,$g))$this->generated=array("STORED");$this->partitionBy=array("RANGE","LIST");if(!$g->flavor)$this->partitionBy[]="HASH";}function
enumLength(array$l){$Tb=$this->types[lang(31)][$l["type"]];return($Tb?type_values($Tb):"");}function
setUserTypes($Lg){$this->types[lang(31)]=array_flip($Lg);}function
insertReturning($R){$ta=array_filter(fields($R),function($l){return$l['auto_increment'];});return(count($ta)==1?" RETURNING ".idf_escape(key($ta)):"");}function
insertUpdate($R,array$J,array$E){foreach($J
as$N){$Ug=array();$Z=array();foreach($N
as$w=>$X){$Ug[]="$w = $X";if(isset($E[idf_unescape($w)]))$Z[]="$w = $X";}if(!(($Z&&queries("UPDATE ".table($R)." SET ".implode(", ",$Ug)." WHERE ".implode(" AND ",$Z))&&connection()->affected_rows)||queries("INSERT INTO ".table($R)." (".implode(", ",array_keys($N)).") VALUES (".implode(", ",$N).")")))return
false;}return
true;}function
slowQuery($F,$tg){$this->conn->query("SET statement_timeout = ".(1000*$tg));$this->conn->timeout=1000*$tg;return$F;}function
convertSearch($t,array$X,array$l){$pg="char|text";if(strpos($X["op"],"LIKE")===false)$pg
.="|date|time(stamp)?|boolean|uuid|inet|cidr|macaddr|".number_type();return(preg_match("~$pg~",$l["type"])?$t:"CAST($t AS text)");}function
quoteBinary($Bf){return"'\\x".bin2hex($Bf)."'";}function
warnings(){return$this->conn->warnings();}function
tableHelp($_,$wd=false){$Ld=array("information_schema"=>"infoschema","pg_catalog"=>($wd?"view":"catalog"),);$y=$Ld[$_GET["ns"]];if($y)return"$y-".str_replace("_","-",$_).".html";}function
inheritsFrom($R){return
get_vals("SELECT relname FROM pg_class JOIN pg_inherits ON inhparent = oid WHERE inhrelid = ".$this->tableOid($R)." ORDER BY 1");}function
inheritedTables($R){return
get_vals("SELECT relname FROM pg_inherits JOIN pg_class ON inhrelid = oid WHERE inhparent = ".$this->tableOid($R)." ORDER BY 1");}function
partitionsInfo($R){$I=connection()->query("SELECT * FROM pg_partitioned_table WHERE partrelid = ".driver()->tableOid($R))->fetch_assoc();if($I){$ra=get_vals("SELECT attname FROM pg_attribute WHERE attrelid = $I[partrelid] AND attnum IN (".str_replace(" ",", ",$I["partattrs"]).")");$Ha=array('h'=>'HASH','l'=>'LIST','r'=>'RANGE');return
array("partition_by"=>$Ha[$I["partstrat"]],"partition"=>implode(", ",array_map('Adminer\idf_escape',$ra)),);}return
array();}function
tableOid($R){return"(SELECT oid FROM pg_class WHERE relnamespace = $this->nsOid AND relname = ".q($R)." AND relkind IN ('r', 'm', 'v', 'f', 'p'))";}function
indexAlgorithms(array$ig){static$H=array();if(!$H)$H=get_vals("SELECT amname FROM pg_am".(min_version(9.6)?" WHERE amtype = 'i'":"")." ORDER BY amname = 'btree' DESC, amname");return$H;}function
supportsIndex(array$S){return$S["Engine"]!="view";}function
hasCStyleEscapes(){static$Ja;if($Ja===null)$Ja=(get_val("SHOW standard_conforming_strings",0,$this->conn)=="off");return$Ja;}}function
idf_escape($t){return'"'.str_replace('"','""',$t).'"';}function
table($t){return
idf_escape($t);}function
get_databases($uc){return
get_vals("SELECT datname FROM pg_database
WHERE datallowconn = TRUE AND has_database_privilege(datname, 'CONNECT')
ORDER BY datname");}function
limit($F,$Z,$x,$re=0,$L=" "){return" $F$Z".($x?$L."LIMIT $x".($re?" OFFSET $re":""):"");}function
limit1($R,$F,$Z,$L="\n"){return(preg_match('~^INTO~',$F)?limit($F,$Z,1,0,$L):" $F".(is_view(table_status1($R))?$Z:$L."WHERE ctid = (SELECT ctid FROM ".table($R).$Z.$L."LIMIT 1)"));}function
db_collation($i,$Wa){return
get_val("SELECT datcollate FROM pg_database WHERE datname = ".q($i));}function
logged_user(){return
get_val("SELECT user");}function
tables_list(){$F="SELECT table_name, table_type FROM information_schema.tables WHERE table_schema = current_schema()";if(support("materializedview"))$F
.="
UNION ALL
SELECT matviewname, 'MATERIALIZED VIEW'
FROM pg_matviews
WHERE schemaname = current_schema()";$F
.="
ORDER BY 1";return
get_key_vals($F);}function
count_tables($ub){$H=array();foreach($ub
as$i){if(connection()->select_db($i))$H[$i]=count(tables_list());}return$H;}function
table_status($_=""){static$Pc;if($Pc===null)$Pc=get_val("SELECT 'pg_table_size'::regproc");$H=array();foreach(get_rows("SELECT
	relname AS \"Name\",
	CASE relkind WHEN 'v' THEN 'view' WHEN 'm' THEN 'materialized view' ELSE 'table' END AS \"Engine\"".($Pc?",
	pg_table_size(oid) AS \"Data_length\",
	pg_indexes_size(oid) AS \"Index_length\"":"").",
	obj_description(oid, 'pg_class') AS \"Comment\",
	".(min_version(12)?"''":"CASE WHEN relhasoids THEN 'oid' ELSE '' END")." AS \"Oid\",
	reltuples as \"Rows\",
	inhparent AS inherited,
	current_schema() AS nspname
FROM pg_class
LEFT JOIN pg_inherits ON inhrelid = oid
WHERE relkind IN ('r', 'm', 'v', 'f', 'p')
AND relnamespace = ".driver()->nsOid."
".($_!=""?"AND relname = ".q($_):"ORDER BY relname"))as$I)$H[$I["Name"]]=$I;return$H;}function
is_view($S){return
in_array($S["Engine"],array("view","materialized view"));}function
fk_support($S){return
true;}function
fields($R){$H=array();$ka=array('timestamp without time zone'=>'timestamp','timestamp with time zone'=>'timestamptz',);foreach(get_rows("SELECT
	a.attname AS field,
	format_type(a.atttypid, a.atttypmod) AS full_type,
	pg_get_expr(d.adbin, d.adrelid) AS default,
	a.attnotnull::int,
	col_description(a.attrelid, a.attnum) AS comment".(min_version(10)?",
	a.attidentity".(min_version(12)?",
	a.attgenerated":""):"")."
FROM pg_attribute a
LEFT JOIN pg_attrdef d ON a.attrelid = d.adrelid AND a.attnum = d.adnum
WHERE a.attrelid = ".driver()->tableOid($R)."
AND NOT a.attisdropped
AND a.attnum > 0
ORDER BY a.attnum")as$I){preg_match('~([^([]+)(\((.*)\))?([a-z ]+)?((\[[0-9]*])*)$~',$I["full_type"],$z);list(,$U,$Id,$I["length"],$fa,$na)=$z;$I["length"].=$na;$Na=$U.$fa;if(isset($ka[$Na])){$I["type"]=$ka[$Na];$I["full_type"]=$I["type"].$Id.$na;}else{$I["type"]=$U;$I["full_type"]=$I["type"].$Id.$fa.$na;}if(in_array($I['attidentity'],array('a','d')))$I['default']='GENERATED '.($I['attidentity']=='d'?'BY DEFAULT':'ALWAYS').' AS IDENTITY';$I["generated"]=($I["attgenerated"]=="s"?"STORED":"");$I["null"]=!$I["attnotnull"];$I["auto_increment"]=$I['attidentity']||preg_match('~^nextval\(~i',$I["default"])||preg_match('~^unique_rowid\(~',$I["default"]);$I["privileges"]=array("insert"=>1,"select"=>1,"update"=>1,"where"=>1,"order"=>1);if(preg_match('~(.+)::[^,)]+(.*)~',$I["default"],$z))$I["default"]=($z[1]=="NULL"?null:idf_unescape($z[1]).$z[2]);$H[$I["field"]]=$I;}return$H;}function
indexes($R,$h=null){$h=connection($h);$H=array();$lg=driver()->tableOid($R);$e=get_key_vals("SELECT attnum, attname FROM pg_attribute WHERE attrelid = $lg AND attnum > 0",$h);foreach(get_rows("SELECT relname, indisunique::int, indisprimary::int, indkey, indoption, (indpred IS NOT NULL)::int as indispartial, pg_am.amname as algorithm, pg_get_expr(pg_index.indpred, pg_index.indrelid, true) AS partial
FROM pg_index
JOIN pg_class ON indexrelid = oid
JOIN pg_am ON pg_am.oid = pg_class.relam
WHERE indrelid = $lg
ORDER BY indisprimary DESC, indisunique DESC",$h)as$I){$uf=$I["relname"];$H[$uf]["type"]=($I["indispartial"]?"INDEX":($I["indisprimary"]?"PRIMARY":($I["indisunique"]?"UNIQUE":"INDEX")));$H[$uf]["columns"]=array();$H[$uf]["descs"]=array();$H[$uf]["algorithm"]=$I["algorithm"];$H[$uf]["partial"]=$I["partial"];if($I["indkey"]){foreach(explode(" ",$I["indkey"])as$hd)$H[$uf]["columns"][]=$e[$hd];foreach(explode(" ",$I["indoption"])as$id)$H[$uf]["descs"][]=(intval($id)&1?'1':null);}$H[$uf]["lengths"]=array();}return$H;}function
foreign_keys($R){$H=array();foreach(get_rows("SELECT conname, condeferrable::int AS deferrable, pg_get_constraintdef(oid) AS definition
FROM pg_constraint
WHERE conrelid = ".driver()->tableOid($R)."
AND contype = 'f'::char
ORDER BY conkey, conname")as$I){if(preg_match('~FOREIGN KEY\s*\((.+)\)\s*REFERENCES (.+)\((.+)\)(.*)$~iA',$I['definition'],$z)){$I['source']=array_map('Adminer\idf_unescape',array_map('trim',explode(',',$z[1])));if(preg_match('~^(("([^"]|"")+"|[^"]+)\.)?"?("([^"]|"")+"|[^"]+)$~',$z[2],$Rd)){$I['ns']=idf_unescape($Rd[2]);$I['table']=idf_unescape($Rd[4]);}$I['target']=array_map('Adminer\idf_unescape',array_map('trim',explode(',',$z[3])));$I['on_delete']=(preg_match("~ON DELETE (".driver()->onActions.")~",$z[4],$Rd)?$Rd[1]:'NO ACTION');$I['on_update']=(preg_match("~ON UPDATE (".driver()->onActions.")~",$z[4],$Rd)?$Rd[1]:'NO ACTION');$H[$I['conname']]=$I;}}return$H;}function
view($_){return
array("select"=>trim(get_val("SELECT pg_get_viewdef(".driver()->tableOid($_).")")));}function
collations(){return
array();}function
information_schema($i){return
get_schema()=="information_schema";}function
error(){$H=h(connection()->error);if(preg_match('~^(.*\n)?([^\n]*)\n( *)\^(\n.*)?$~s',$H,$z))$H=$z[1].preg_replace('~((?:[^&]|&[^;]*;){'.strlen($z[3]).'})(.*)~','\1<b>\2</b>',$z[2]).$z[4];return
nl_br($H);}function
create_database($i,$c){return
queries("CREATE DATABASE ".idf_escape($i).($c?" ENCODING ".idf_escape($c):""));}function
drop_databases($ub){connection()->close();return
apply_queries("DROP DATABASE",$ub,'Adminer\idf_escape');}function
rename_database($_,$c){connection()->close();return
queries("ALTER DATABASE ".idf_escape(DB)." RENAME TO ".idf_escape($_));}function
auto_increment(){return"";}function
alter_table($R,$_,$m,$wc,$ab,$Sb,$c,$ta,$Se){$b=array();$mf=array();if($R!=""&&$R!=$_)$mf[]="ALTER TABLE ".table($R)." RENAME TO ".table($_);$Kf="";foreach($m
as$l){$d=idf_escape($l[0]);$X=$l[1];if(!$X)$b[]="DROP $d";else{$ah=$X[5];unset($X[5]);if($l[0]==""){if(isset($X[6]))$X[1]=($X[1]==" bigint"?" big":($X[1]==" smallint"?" small":" "))."serial";$b[]=($R!=""?"ADD ":"  ").implode($X);if(isset($X[6]))$b[]=($R!=""?"ADD":" ")." PRIMARY KEY ($X[0])";}else{if($d!=$X[0])$mf[]="ALTER TABLE ".table($_)." RENAME $d TO $X[0]";$b[]="ALTER $d TYPE$X[1]";$Lf=$R."_".idf_unescape($X[0])."_seq";$b[]="ALTER $d ".($X[3]?"SET".preg_replace('~GENERATED ALWAYS(.*) STORED~','EXPRESSION\1',$X[3]):(isset($X[6])?"SET DEFAULT nextval(".q($Lf).")":"DROP DEFAULT"));if(isset($X[6]))$Kf="CREATE SEQUENCE IF NOT EXISTS ".idf_escape($Lf)." OWNED BY ".idf_escape($R).".$X[0]";$b[]="ALTER $d ".($X[2]==" NULL"?"DROP NOT":"SET").$X[2];}if($l[0]!=""||$ah!="")$mf[]="COMMENT ON COLUMN ".table($_).".$X[0] IS ".($ah!=""?substr($ah,9):"''");}}$b=array_merge($b,$wc);if($R==""){$P="";if($Se){$Sa=(connection()->flavor=='cockroach');$P=" PARTITION BY $Se[partition_by]($Se[partition])";if($Se["partition_by"]=='HASH'){$Te=+$Se["partitions"];for($r=0;$r<$Te;$r++)$mf[]="CREATE TABLE ".idf_escape($_."_$r")." PARTITION OF ".idf_escape($_)." FOR VALUES WITH (MODULUS $Te, REMAINDER $r)";}else{$ff="MINVALUE";foreach($Se["partition_names"]as$r=>$X){$Y=$Se["partition_values"][$r];$Qe=" VALUES ".($Se["partition_by"]=='LIST'?"IN ($Y)":"FROM ($ff) TO ($Y)");if($Sa)$P
.=($r?",":" (")."\n  PARTITION ".(preg_match('~^DEFAULT$~i',$X)?$X:idf_escape($X))."$Qe";else$mf[]="CREATE TABLE ".idf_escape($_."_$X")." PARTITION OF ".idf_escape($_)." FOR$Qe";$ff=$Y;}$P
.=($Sa?"\n)":"");}}array_unshift($mf,"CREATE TABLE ".table($_)." (\n".implode(",\n",$b)."\n)$P");}elseif($b)array_unshift($mf,"ALTER TABLE ".table($R)."\n".implode(",\n",$b));if($Kf)array_unshift($mf,$Kf);if($ab!==null)$mf[]="COMMENT ON TABLE ".table($_)." IS ".q($ab);foreach($mf
as$F){if(!queries($F))return
false;}return
true;}function
alter_indexes($R,$b){$lb=array();$Gb=array();$mf=array();foreach($b
as$X){if($X[0]!="INDEX")$lb[]=($X[2]=="DROP"?"\nDROP CONSTRAINT ".idf_escape($X[1]):"\nADD".($X[1]!=""?" CONSTRAINT ".idf_escape($X[1]):"")." $X[0] ".($X[0]=="PRIMARY"?"KEY ":"")."(".implode(", ",$X[2]).")");elseif($X[2]=="DROP")$Gb[]=idf_escape($X[1]);else$mf[]="CREATE INDEX ".idf_escape($X[1]!=""?$X[1]:uniqid($R."_"))." ON ".table($R).($X[3]?" USING $X[3]":"")." (".implode(", ",$X[2]).")".($X[4]?" WHERE $X[4]":"");}if($lb)array_unshift($mf,"ALTER TABLE ".table($R).implode(",",$lb));if($Gb)array_unshift($mf,"DROP INDEX ".implode(", ",$Gb));foreach($mf
as$F){if(!queries($F))return
false;}return
true;}function
truncate_tables($T){return
queries("TRUNCATE ".implode(", ",array_map('Adminer\table',$T)));}function
drop_views($fh){return
drop_tables($fh);}function
drop_tables($T){foreach($T
as$R){$P=table_status1($R);if(!queries("DROP ".strtoupper($P["Engine"])." ".table($R)))return
false;}return
true;}function
move_tables($T,$fh,$mg){foreach(array_merge($T,$fh)as$R){$P=table_status1($R);if(!queries("ALTER ".strtoupper($P["Engine"])." ".table($R)." SET SCHEMA ".idf_escape($mg)))return
false;}return
true;}function
trigger($_,$R){if($_=="")return
array("Statement"=>"EXECUTE PROCEDURE ()");$e=array();$Z="WHERE trigger_schema = current_schema() AND event_object_table = ".q($R)." AND trigger_name = ".q($_);foreach(get_rows("SELECT * FROM information_schema.triggered_update_columns $Z")as$I)$e[]=$I["event_object_column"];$H=array();foreach(get_rows('SELECT trigger_name AS "Trigger", action_timing AS "Timing", event_manipulation AS "Event", \'FOR EACH \' || action_orientation AS "Type", action_statement AS "Statement"
FROM information_schema.triggers'."
$Z
ORDER BY event_manipulation DESC")as$I){if($e&&$I["Event"]=="UPDATE")$I["Event"].=" OF";$I["Of"]=implode(", ",$e);if($H)$I["Event"].=" OR $H[Event]";$H=$I;}return$H;}function
triggers($R){$H=array();foreach(get_rows("SELECT * FROM information_schema.triggers WHERE trigger_schema = current_schema() AND event_object_table = ".q($R))as$I){$Gg=trigger($I["trigger_name"],$R);$H[$Gg["Trigger"]]=array($Gg["Timing"],$Gg["Event"]);}return$H;}function
trigger_options(){return
array("Timing"=>array("BEFORE","AFTER"),"Event"=>array("INSERT","UPDATE","UPDATE OF","DELETE","INSERT OR UPDATE","INSERT OR UPDATE OF","DELETE OR INSERT","DELETE OR UPDATE","DELETE OR UPDATE OF","DELETE OR INSERT OR UPDATE","DELETE OR INSERT OR UPDATE OF"),"Type"=>array("FOR EACH ROW","FOR EACH STATEMENT"),);}function
routine($_,$U){$J=get_rows('SELECT routine_definition AS definition, LOWER(external_language) AS language, *
FROM information_schema.routines
WHERE routine_schema = current_schema() AND specific_name = '.q($_));$H=idx($J,0,array());$H["returns"]=array("type"=>$H["type_udt_name"]);$H["fields"]=get_rows('SELECT parameter_name AS field, data_type AS type, character_maximum_length AS length, parameter_mode AS inout
FROM information_schema.parameters
WHERE specific_schema = current_schema() AND specific_name = '.q($_).'
ORDER BY ordinal_position');return$H;}function
routines(){return
get_rows('SELECT specific_name AS "SPECIFIC_NAME", routine_type AS "ROUTINE_TYPE", routine_name AS "ROUTINE_NAME", type_udt_name AS "DTD_IDENTIFIER"
FROM information_schema.routines
WHERE routine_schema = current_schema()
ORDER BY SPECIFIC_NAME');}function
routine_languages(){return
get_vals("SELECT LOWER(lanname) FROM pg_catalog.pg_language");}function
routine_id($_,$I){$H=array();foreach($I["fields"]as$l){$Id=$l["length"];$H[]=$l["type"].($Id?"($Id)":"");}return
idf_escape($_)."(".implode(", ",$H).")";}function
last_id($G){$I=(is_object($G)?$G->fetch_row():array());return($I?$I[0]:0);}function
explain($g,$F){return$g->query("EXPLAIN $F");}function
found_rows($S,$Z){if(preg_match("~ rows=([0-9]+)~",get_val("EXPLAIN SELECT * FROM ".idf_escape($S["Name"]).($Z?" WHERE ".implode(" AND ",$Z):"")),$tf))return$tf[1];}function
types(){return
get_key_vals("SELECT oid, typname
FROM pg_type
WHERE typnamespace = ".driver()->nsOid."
AND typtype IN ('b','d','e')
AND typelem = 0");}function
type_values($s){$Vb=get_vals("SELECT enumlabel FROM pg_enum WHERE enumtypid = $s ORDER BY enumsortorder");return($Vb?"'".implode("', '",array_map('addslashes',$Vb))."'":"");}function
schemas(){return
get_vals("SELECT nspname FROM pg_namespace ORDER BY nspname");}function
get_schema(){return
get_val("SELECT current_schema()");}function
set_schema($Cf,$h=null){if(!$h)$h=connection();$H=$h->query("SET search_path TO ".idf_escape($Cf));driver()->setUserTypes(types());return$H;}function
foreign_keys_sql($R){$H="";$P=table_status1($R);$sc=foreign_keys($R);ksort($sc);foreach($sc
as$rc=>$qc)$H
.="ALTER TABLE ONLY ".idf_escape($P['nspname']).".".idf_escape($P['Name'])." ADD CONSTRAINT ".idf_escape($rc)." $qc[definition] ".($qc['deferrable']?'DEFERRABLE':'NOT DEFERRABLE').";\n";return($H?"$H\n":$H);}function
create_sql($R,$ta,$dg){$zf=array();$Mf=array();$P=table_status1($R);if(is_view($P)){$eh=view($R);return
rtrim("CREATE VIEW ".idf_escape($R)." AS $eh[select]",";");}$m=fields($R);if(count($P)<2||empty($m))return
false;$H="CREATE TABLE ".idf_escape($P['nspname']).".".idf_escape($P['Name'])." (\n    ";foreach($m
as$l){$Pe=idf_escape($l['field']).' '.$l['full_type'].default_value($l).($l['null']?"":" NOT NULL");$zf[]=$Pe;if(preg_match('~nextval\(\'([^\']+)\'\)~',$l['default'],$Td)){$Lf=$Td[1];$Xf=first(get_rows((min_version(10)?"SELECT *, cache_size AS cache_value FROM pg_sequences WHERE schemaname = current_schema() AND sequencename = ".q(idf_unescape($Lf)):"SELECT * FROM $Lf"),null,"-- "));$Mf[]=($dg=="DROP+CREATE"?"DROP SEQUENCE IF EXISTS $Lf;\n":"")."CREATE SEQUENCE $Lf INCREMENT $Xf[increment_by] MINVALUE $Xf[min_value] MAXVALUE $Xf[max_value]".($ta&&$Xf['last_value']?" START ".($Xf["last_value"]+1):"")." CACHE $Xf[cache_value];";}}if(!empty($Mf))$H=implode("\n\n",$Mf)."\n\n$H";$E="";foreach(indexes($R)as$fd=>$u){if($u['type']=='PRIMARY'){$E=$fd;$zf[]="CONSTRAINT ".idf_escape($fd)." PRIMARY KEY (".implode(', ',array_map('Adminer\idf_escape',$u['columns'])).")";}}foreach(driver()->checkConstraints($R)as$eb=>$gb)$zf[]="CONSTRAINT ".idf_escape($eb)." CHECK $gb";$H
.=implode(",\n    ",$zf)."\n)";$Qe=driver()->partitionsInfo($P['Name']);if($Qe)$H
.="\nPARTITION BY $Qe[partition_by]($Qe[partition])";$H
.="\nWITH (oids = ".($P['Oid']?'true':'false').");";if($P['Comment'])$H
.="\n\nCOMMENT ON TABLE ".idf_escape($P['nspname']).".".idf_escape($P['Name'])." IS ".q($P['Comment']).";";foreach($m
as$kc=>$l){if($l['comment'])$H
.="\n\nCOMMENT ON COLUMN ".idf_escape($P['nspname']).".".idf_escape($P['Name']).".".idf_escape($kc)." IS ".q($l['comment']).";";}foreach(get_rows("SELECT indexdef FROM pg_catalog.pg_indexes WHERE schemaname = current_schema() AND tablename = ".q($R).($E?" AND indexname != ".q($E):""),null,"-- ")as$I)$H
.="\n\n$I[indexdef];";return
rtrim($H,';');}function
truncate_sql($R){return"TRUNCATE ".table($R);}function
trigger_sql($R){$P=table_status1($R);$H="";foreach(triggers($R)as$Fg=>$Eg){$Gg=trigger($Fg,$P['Name']);$H
.="\nCREATE TRIGGER ".idf_escape($Gg['Trigger'])." $Gg[Timing] $Gg[Event] ON ".idf_escape($P["nspname"]).".".idf_escape($P['Name'])." $Gg[Type] $Gg[Statement];;\n";}return$H;}function
use_sql($tb){return"\connect ".idf_escape($tb);}function
show_variables(){return
get_rows("SHOW ALL");}function
process_list(){return
get_rows("SELECT * FROM pg_stat_activity ORDER BY ".(min_version(9.2)?"pid":"procpid"));}function
convert_field($l){}function
unconvert_field($l,$H){return$H;}function
support($jc){return
preg_match('~^(check|columns|comment|database|drop_col|dump|descidx|indexes|kill|partial_indexes|routine|scheme|sequence|sql|table|trigger|type|variables|view'.(min_version(9.3)?'|materializedview':'').(min_version(11)?'|procedure':'').(connection()->flavor=='cockroach'?'':'|processlist').')$~',$jc);}function
kill_process($X){return
queries("SELECT pg_terminate_backend(".number($X).")");}function
connection_id(){return"SELECT pg_backend_pid()";}function
max_connections(){return
get_val("SHOW max_connections");}}add_driver("oracle","Oracle (beta)");if(isset($_GET["oracle"])){define('Adminer\DRIVER',"oracle");if(extension_loaded("oci8")&&$_GET["ext"]!="pdo"){class
Db
extends
SqlDb{var$extension="oci8";var$_current_db;private$link;function
_error($Xb,$k){if(ini_bool("html_errors"))$k=html_entity_decode(strip_tags($k));$k=preg_replace('~^[^:]*: ~','',$k);$this->error=$k;}function
attach($M,$V,$D){$this->link=@oci_new_connect($V,$D,$M,"AL32UTF8");if($this->link){$this->server_info=oci_server_version($this->link);return'';}$k=oci_error();return$k["message"];}function
quote($Q){return"'".str_replace("'","''",$Q)."'";}function
select_db($tb){$this->_current_db=$tb;return
true;}function
query($F,$Mg=false){$G=oci_parse($this->link,$F);$this->error="";if(!$G){$k=oci_error($this->link);$this->errno=$k["code"];$this->error=$k["message"];return
false;}set_error_handler(array($this,'_error'));$H=@oci_execute($G);restore_error_handler();if($H){if(oci_num_fields($G))return
new
Result($G);$this->affected_rows=oci_num_rows($G);oci_free_statement($G);}return$H;}}class
Result{var$num_rows;private$result,$offset=1;function
__construct($G){$this->result=$G;}private
function
convert($I){foreach((array)$I
as$w=>$X){if(is_a($X,'OCILob')||is_a($X,'OCI-Lob'))$I[$w]=$X->load();}return$I;}function
fetch_assoc(){return$this->convert(oci_fetch_assoc($this->result));}function
fetch_row(){return$this->convert(oci_fetch_row($this->result));}function
fetch_field(){$d=$this->offset++;$H=new
\stdClass;$H->name=oci_field_name($this->result,$d);$H->type=oci_field_type($this->result,$d);$H->charsetnr=(preg_match("~raw|blob|bfile~",$H->type)?63:0);return$H;}function
__destruct(){oci_free_statement($this->result);}}}elseif(extension_loaded("pdo_oci")){class
Db
extends
PdoDb{var$extension="PDO_OCI";var$_current_db;function
attach($M,$V,$D){return$this->dsn("oci:dbname=//$M;charset=AL32UTF8",$V,$D);}function
select_db($tb){$this->_current_db=$tb;return
true;}}}class
Driver
extends
SqlDriver{static$extensions=array("OCI8","PDO_OCI");static$jush="oracle";var$insertFunctions=array("date"=>"current_date","timestamp"=>"current_timestamp",);var$editFunctions=array("number|float|double"=>"+/-","date|timestamp"=>"+ interval/- interval","char|clob"=>"||",);var$operators=array("=","<",">","<=",">=","!=","LIKE","LIKE %%","IN","IS NULL","NOT LIKE","NOT IN","IS NOT NULL","SQL");var$functions=array("length","lower","round","upper");var$grouping=array("avg","count","count distinct","max","min","sum");function
__construct(Db$g){parent::__construct($g);$this->types=array(lang(25)=>array("number"=>38,"binary_float"=>12,"binary_double"=>21),lang(26)=>array("date"=>10,"timestamp"=>29,"interval year"=>12,"interval day"=>28),lang(27)=>array("char"=>2000,"varchar2"=>4000,"nchar"=>2000,"nvarchar2"=>4000,"clob"=>4294967295,"nclob"=>4294967295),lang(28)=>array("raw"=>2000,"long raw"=>2147483648,"blob"=>4294967295,"bfile"=>4294967296),);}function
begin(){return
true;}function
insertUpdate($R,array$J,array$E){foreach($J
as$N){$Ug=array();$Z=array();foreach($N
as$w=>$X){$Ug[]="$w = $X";if(isset($E[idf_unescape($w)]))$Z[]="$w = $X";}if(!(($Z&&queries("UPDATE ".table($R)." SET ".implode(", ",$Ug)." WHERE ".implode(" AND ",$Z))&&connection()->affected_rows)||queries("INSERT INTO ".table($R)." (".implode(", ",array_keys($N)).") VALUES (".implode(", ",$N).")")))return
false;}return
true;}function
hasCStyleEscapes(){return
true;}}function
idf_escape($t){return'"'.str_replace('"','""',$t).'"';}function
table($t){return
idf_escape($t);}function
get_databases($uc){return
get_vals("SELECT DISTINCT tablespace_name FROM (
SELECT tablespace_name FROM user_tablespaces
UNION SELECT tablespace_name FROM all_tables WHERE tablespace_name IS NOT NULL
)
ORDER BY 1");}function
limit($F,$Z,$x,$re=0,$L=" "){return($re?" * FROM (SELECT t.*, rownum AS rnum FROM (SELECT $F$Z) t WHERE rownum <= ".($x+$re).") WHERE rnum > $re":($x?" * FROM (SELECT $F$Z) WHERE rownum <= ".($x+$re):" $F$Z"));}function
limit1($R,$F,$Z,$L="\n"){return" $F$Z";}function
db_collation($i,$Wa){return
get_val("SELECT value FROM nls_database_parameters WHERE parameter = 'NLS_CHARACTERSET'");}function
logged_user(){return
get_val("SELECT USER FROM DUAL");}function
get_current_db(){$i=connection()->_current_db?:DB;unset(connection()->_current_db);return$i;}function
where_owner($ef,$Ke="owner"){if(!$_GET["ns"])return'';return"$ef$Ke = sys_context('USERENV', 'CURRENT_SCHEMA')";}function
views_table($e){$Ke=where_owner('');return"(SELECT $e FROM all_views WHERE ".($Ke?:"rownum < 0").")";}function
tables_list(){$eh=views_table("view_name");$Ke=where_owner(" AND ");return
get_key_vals("SELECT table_name, 'table' FROM all_tables WHERE tablespace_name = ".q(DB)."$Ke
UNION SELECT view_name, 'view' FROM $eh
ORDER BY 1");}function
count_tables($ub){$H=array();foreach($ub
as$i)$H[$i]=get_val("SELECT COUNT(*) FROM all_tables WHERE tablespace_name = ".q($i));return$H;}function
table_status($_=""){$H=array();$Ef=q($_);$i=get_current_db();$eh=views_table("view_name");$Ke=where_owner(" AND ");foreach(get_rows('SELECT table_name "Name", \'table\' "Engine", avg_row_len * num_rows "Data_length", num_rows "Rows" FROM all_tables WHERE tablespace_name = '.q($i).$Ke.($_!=""?" AND table_name = $Ef":"")."
UNION SELECT view_name, 'view', 0, 0 FROM $eh".($_!=""?" WHERE view_name = $Ef":"")."
ORDER BY 1")as$I)$H[$I["Name"]]=$I;return$H;}function
is_view($S){return$S["Engine"]=="view";}function
fk_support($S){return
true;}function
fields($R){$H=array();$Ke=where_owner(" AND ");foreach(get_rows("SELECT * FROM all_tab_columns WHERE table_name = ".q($R)."$Ke ORDER BY column_id")as$I){$U=$I["DATA_TYPE"];$Id="$I[DATA_PRECISION],$I[DATA_SCALE]";if($Id==",")$Id=$I["CHAR_COL_DECL_LENGTH"];$H[$I["COLUMN_NAME"]]=array("field"=>$I["COLUMN_NAME"],"full_type"=>$U.($Id?"($Id)":""),"type"=>strtolower($U),"length"=>$Id,"default"=>$I["DATA_DEFAULT"],"null"=>($I["NULLABLE"]=="Y"),"privileges"=>array("insert"=>1,"select"=>1,"update"=>1,"where"=>1,"order"=>1),);}return$H;}function
indexes($R,$h=null){$H=array();$Ke=where_owner(" AND ","aic.table_owner");foreach(get_rows("SELECT aic.*, ac.constraint_type, atc.data_default
FROM all_ind_columns aic
LEFT JOIN all_constraints ac ON aic.index_name = ac.constraint_name AND aic.table_name = ac.table_name AND aic.index_owner = ac.owner
LEFT JOIN all_tab_cols atc ON aic.column_name = atc.column_name AND aic.table_name = atc.table_name AND aic.index_owner = atc.owner
WHERE aic.table_name = ".q($R)."$Ke
ORDER BY ac.constraint_type, aic.column_position",$h)as$I){$fd=$I["INDEX_NAME"];$Ya=$I["DATA_DEFAULT"];$Ya=($Ya?trim($Ya,'"'):$I["COLUMN_NAME"]);$H[$fd]["type"]=($I["CONSTRAINT_TYPE"]=="P"?"PRIMARY":($I["CONSTRAINT_TYPE"]=="U"?"UNIQUE":"INDEX"));$H[$fd]["columns"][]=$Ya;$H[$fd]["lengths"][]=($I["CHAR_LENGTH"]&&$I["CHAR_LENGTH"]!=$I["COLUMN_LENGTH"]?$I["CHAR_LENGTH"]:null);$H[$fd]["descs"][]=($I["DESCEND"]&&$I["DESCEND"]=="DESC"?'1':null);}return$H;}function
view($_){$eh=views_table("view_name, text");$J=get_rows('SELECT text "select" FROM '.$eh.' WHERE view_name = '.q($_));return
reset($J);}function
collations(){return
array();}function
information_schema($i){return
get_schema()=="INFORMATION_SCHEMA";}function
error(){return
h(connection()->error);}function
explain($g,$F){$g->query("EXPLAIN PLAN FOR $F");return$g->query("SELECT * FROM plan_table");}function
found_rows($S,$Z){}function
auto_increment(){return"";}function
alter_table($R,$_,$m,$wc,$ab,$Sb,$c,$ta,$Se){$b=$Gb=array();$Ge=($R?fields($R):array());foreach($m
as$l){$X=$l[1];if($X&&$l[0]!=""&&idf_escape($l[0])!=$X[0])queries("ALTER TABLE ".table($R)." RENAME COLUMN ".idf_escape($l[0])." TO $X[0]");$Fe=$Ge[$l[0]];if($X&&$Fe){$te=process_field($Fe,$Fe);if($X[2]==$te[2])$X[2]="";}if($X)$b[]=($R!=""?($l[0]!=""?"MODIFY (":"ADD ("):"  ").implode($X).($R!=""?")":"");else$Gb[]=idf_escape($l[0]);}if($R=="")return
queries("CREATE TABLE ".table($_)." (\n".implode(",\n",$b)."\n)");return(!$b||queries("ALTER TABLE ".table($R)."\n".implode("\n",$b)))&&(!$Gb||queries("ALTER TABLE ".table($R)." DROP (".implode(", ",$Gb).")"))&&($R==$_||queries("ALTER TABLE ".table($R)." RENAME TO ".table($_)));}function
alter_indexes($R,$b){$Gb=array();$mf=array();foreach($b
as$X){if($X[0]!="INDEX"){$X[2]=preg_replace('~ DESC$~','',$X[2]);$lb=($X[2]=="DROP"?"\nDROP CONSTRAINT ".idf_escape($X[1]):"\nADD".($X[1]!=""?" CONSTRAINT ".idf_escape($X[1]):"")." $X[0] ".($X[0]=="PRIMARY"?"KEY ":"")."(".implode(", ",$X[2]).")");array_unshift($mf,"ALTER TABLE ".table($R).$lb);}elseif($X[2]=="DROP")$Gb[]=idf_escape($X[1]);else$mf[]="CREATE INDEX ".idf_escape($X[1]!=""?$X[1]:uniqid($R."_"))." ON ".table($R)." (".implode(", ",$X[2]).")";}if($Gb)array_unshift($mf,"DROP INDEX ".implode(", ",$Gb));foreach($mf
as$F){if(!queries($F))return
false;}return
true;}function
foreign_keys($R){$H=array();$F="SELECT c_list.CONSTRAINT_NAME as NAME,
c_src.COLUMN_NAME as SRC_COLUMN,
c_dest.OWNER as DEST_DB,
c_dest.TABLE_NAME as DEST_TABLE,
c_dest.COLUMN_NAME as DEST_COLUMN,
c_list.DELETE_RULE as ON_DELETE
FROM ALL_CONSTRAINTS c_list, ALL_CONS_COLUMNS c_src, ALL_CONS_COLUMNS c_dest
WHERE c_list.CONSTRAINT_NAME = c_src.CONSTRAINT_NAME
AND c_list.R_CONSTRAINT_NAME = c_dest.CONSTRAINT_NAME
AND c_list.CONSTRAINT_TYPE = 'R'
AND c_src.TABLE_NAME = ".q($R);foreach(get_rows($F)as$I)$H[$I['NAME']]=array("db"=>$I['DEST_DB'],"table"=>$I['DEST_TABLE'],"source"=>array($I['SRC_COLUMN']),"target"=>array($I['DEST_COLUMN']),"on_delete"=>$I['ON_DELETE'],"on_update"=>null,);return$H;}function
truncate_tables($T){return
apply_queries("TRUNCATE TABLE",$T);}function
drop_views($fh){return
apply_queries("DROP VIEW",$fh);}function
drop_tables($T){return
apply_queries("DROP TABLE",$T);}function
last_id($G){return
0;}function
schemas(){$H=get_vals("SELECT DISTINCT owner FROM dba_segments WHERE owner IN (SELECT username FROM dba_users WHERE default_tablespace NOT IN ('SYSTEM','SYSAUX')) ORDER BY 1");return($H?:get_vals("SELECT DISTINCT owner FROM all_tables WHERE tablespace_name = ".q(DB)." ORDER BY 1"));}function
get_schema(){return
get_val("SELECT sys_context('USERENV', 'SESSION_USER') FROM dual");}function
set_schema($Df,$h=null){if(!$h)$h=connection();return$h->query("ALTER SESSION SET CURRENT_SCHEMA = ".idf_escape($Df));}function
show_variables(){return
get_rows('SELECT name, display_value FROM v$parameter');}function
show_status(){$H=array();$J=get_rows('SELECT * FROM v$instance');foreach(reset($J)as$w=>$X)$H[]=array($w,$X);return$H;}function
process_list(){return
get_rows('SELECT
	sess.process AS "process",
	sess.username AS "user",
	sess.schemaname AS "schema",
	sess.status AS "status",
	sess.wait_class AS "wait_class",
	sess.seconds_in_wait AS "seconds_in_wait",
	sql.sql_text AS "sql_text",
	sess.machine AS "machine",
	sess.port AS "port"
FROM v$session sess LEFT OUTER JOIN v$sql sql
ON sql.sql_id = sess.sql_id
WHERE sess.type = \'USER\'
ORDER BY PROCESS
');}function
convert_field($l){}function
unconvert_field($l,$H){return$H;}function
support($jc){return
preg_match('~^(columns|database|drop_col|indexes|descidx|processlist|scheme|sql|status|table|variables|view)$~',$jc);}}add_driver("mssql","MS SQL");if(isset($_GET["mssql"])){define('Adminer\DRIVER',"mssql");if(extension_loaded("sqlsrv")&&$_GET["ext"]!="pdo"){class
Db
extends
SqlDb{var$extension="sqlsrv";private$link,$result;private
function
get_error(){$this->error="";foreach(sqlsrv_errors()as$k){$this->errno=$k["code"];$this->error
.="$k[message]\n";}$this->error=rtrim($this->error);}function
attach($M,$V,$D){$fb=array("UID"=>$V,"PWD"=>$D,"CharacterSet"=>"UTF-8");$O=adminer()->connectSsl();if(isset($O["Encrypt"]))$fb["Encrypt"]=$O["Encrypt"];if(isset($O["TrustServerCertificate"]))$fb["TrustServerCertificate"]=$O["TrustServerCertificate"];$i=adminer()->database();if($i!="")$fb["Database"]=$i;$this->link=@sqlsrv_connect(preg_replace('~:~',',',$M),$fb);if($this->link){$jd=sqlsrv_server_info($this->link);$this->server_info=$jd['SQLServerVersion'];}else$this->get_error();return($this->link?'':$this->error);}function
quote($Q){$Ng=strlen($Q)!=strlen(utf8_decode($Q));return($Ng?"N":"")."'".str_replace("'","''",$Q)."'";}function
select_db($tb){return$this->query(use_sql($tb));}function
query($F,$Mg=false){$G=sqlsrv_query($this->link,$F);$this->error="";if(!$G){$this->get_error();return
false;}return$this->store_result($G);}function
multi_query($F){$this->result=sqlsrv_query($this->link,$F);$this->error="";if(!$this->result){$this->get_error();return
false;}return
true;}function
store_result($G=null){if(!$G)$G=$this->result;if(!$G)return
false;if(sqlsrv_field_metadata($G))return
new
Result($G);$this->affected_rows=sqlsrv_rows_affected($G);return
true;}function
next_result(){return$this->result?!!sqlsrv_next_result($this->result):false;}}class
Result{var$num_rows;private$result,$offset=0,$fields;function
__construct($G){$this->result=$G;}private
function
convert($I){foreach((array)$I
as$w=>$X){if(is_a($X,'DateTime'))$I[$w]=$X->format("Y-m-d H:i:s");}return$I;}function
fetch_assoc(){return$this->convert(sqlsrv_fetch_array($this->result,SQLSRV_FETCH_ASSOC));}function
fetch_row(){return$this->convert(sqlsrv_fetch_array($this->result,SQLSRV_FETCH_NUMERIC));}function
fetch_field(){if(!$this->fields)$this->fields=sqlsrv_field_metadata($this->result);$l=$this->fields[$this->offset++];$H=new
\stdClass;$H->name=$l["Name"];$H->type=($l["Type"]==1?254:15);$H->charsetnr=0;return$H;}function
seek($re){for($r=0;$r<$re;$r++)sqlsrv_fetch($this->result);}function
__destruct(){sqlsrv_free_stmt($this->result);}}function
last_id($G){return
get_val("SELECT SCOPE_IDENTITY()");}function
explain($g,$F){$g->query("SET SHOWPLAN_ALL ON");$H=$g->query($F);$g->query("SET SHOWPLAN_ALL OFF");return$H;}}else{abstract
class
MssqlDb
extends
PdoDb{function
select_db($tb){return$this->query(use_sql($tb));}function
lastInsertId(){return$this->pdo->lastInsertId();}}function
last_id($G){return
connection()->lastInsertId();}function
explain($g,$F){}if(extension_loaded("pdo_sqlsrv")){class
Db
extends
MssqlDb{var$extension="PDO_SQLSRV";function
attach($M,$V,$D){return$this->dsn("sqlsrv:Server=".str_replace(":",",",$M),$V,$D);}}}elseif(extension_loaded("pdo_dblib")){class
Db
extends
MssqlDb{var$extension="PDO_DBLIB";function
attach($M,$V,$D){return$this->dsn("dblib:charset=utf8;host=".str_replace(":",";unix_socket=",preg_replace('~:(\d)~',';port=\1',$M)),$V,$D);}}}}class
Driver
extends
SqlDriver{static$extensions=array("SQLSRV","PDO_SQLSRV","PDO_DBLIB");static$jush="mssql";var$insertFunctions=array("date|time"=>"getdate");var$editFunctions=array("int|decimal|real|float|money|datetime"=>"+/-","char|text"=>"+",);var$operators=array("=","<",">","<=",">=","!=","LIKE","LIKE %%","IN","IS NULL","NOT LIKE","NOT IN","IS NOT NULL");var$functions=array("len","lower","round","upper");var$grouping=array("avg","count","count distinct","max","min","sum");var$generated=array("PERSISTED","VIRTUAL");var$onActions="NO ACTION|CASCADE|SET NULL|SET DEFAULT";static
function
connect($M,$V,$D){if($M=="")$M="localhost:1433";return
parent::connect($M,$V,$D);}function
__construct(Db$g){parent::__construct($g);$this->types=array(lang(25)=>array("tinyint"=>3,"smallint"=>5,"int"=>10,"bigint"=>20,"bit"=>1,"decimal"=>0,"real"=>12,"float"=>53,"smallmoney"=>10,"money"=>20),lang(26)=>array("date"=>10,"smalldatetime"=>19,"datetime"=>19,"datetime2"=>19,"time"=>8,"datetimeoffset"=>10),lang(27)=>array("char"=>8000,"varchar"=>8000,"text"=>2147483647,"nchar"=>4000,"nvarchar"=>4000,"ntext"=>1073741823),lang(28)=>array("binary"=>8000,"varbinary"=>8000,"image"=>2147483647),);}function
insertUpdate($R,array$J,array$E){$m=fields($R);$Ug=array();$Z=array();$N=reset($J);$e="c".implode(", c",range(1,count($N)));$Ia=0;$nd=array();foreach($N
as$w=>$X){$Ia++;$_=idf_unescape($w);if(!$m[$_]["auto_increment"])$nd[$w]="c$Ia";if(isset($E[$_]))$Z[]="$w = c$Ia";else$Ug[]="$w = c$Ia";}$bh=array();foreach($J
as$N)$bh[]="(".implode(", ",$N).")";if($Z){$bd=queries("SET IDENTITY_INSERT ".table($R)." ON");$H=queries("MERGE ".table($R)." USING (VALUES\n\t".implode(",\n\t",$bh)."\n) AS source ($e) ON ".implode(" AND ",$Z).($Ug?"\nWHEN MATCHED THEN UPDATE SET ".implode(", ",$Ug):"")."\nWHEN NOT MATCHED THEN INSERT (".implode(", ",array_keys($bd?$N:$nd)).") VALUES (".($bd?$e:implode(", ",$nd)).");");if($bd)queries("SET IDENTITY_INSERT ".table($R)." OFF");}else$H=queries("INSERT INTO ".table($R)." (".implode(", ",array_keys($N)).") VALUES\n".implode(",\n",$bh));return$H;}function
begin(){return
queries("BEGIN TRANSACTION");}function
tableHelp($_,$wd=false){$Ld=array("sys"=>"catalog-views/sys-","INFORMATION_SCHEMA"=>"information-schema-views/",);$y=$Ld[get_schema()];if($y)return"relational-databases/system-$y".preg_replace('~_~','-',strtolower($_))."-transact-sql";}}function
idf_escape($t){return"[".str_replace("]","]]",$t)."]";}function
table($t){return($_GET["ns"]!=""?idf_escape($_GET["ns"]).".":"").idf_escape($t);}function
get_databases($uc){return
get_vals("SELECT name FROM sys.databases WHERE name NOT IN ('master', 'tempdb', 'model', 'msdb')");}function
limit($F,$Z,$x,$re=0,$L=" "){return($x?" TOP (".($x+$re).")":"")." $F$Z";}function
limit1($R,$F,$Z,$L="\n"){return
limit($F,$Z,1,0,$L);}function
db_collation($i,$Wa){return
get_val("SELECT collation_name FROM sys.databases WHERE name = ".q($i));}function
logged_user(){return
get_val("SELECT SUSER_NAME()");}function
tables_list(){return
get_key_vals("SELECT name, type_desc FROM sys.all_objects WHERE schema_id = SCHEMA_ID(".q(get_schema()).") AND type IN ('S', 'U', 'V') ORDER BY name");}function
count_tables($ub){$H=array();foreach($ub
as$i){connection()->select_db($i);$H[$i]=get_val("SELECT COUNT(*) FROM INFORMATION_SCHEMA.TABLES");}return$H;}function
table_status($_=""){$H=array();foreach(get_rows("SELECT ao.name AS Name, ao.type_desc AS Engine, (SELECT value FROM fn_listextendedproperty(default, 'SCHEMA', schema_name(schema_id), 'TABLE', ao.name, null, null)) AS Comment
FROM sys.all_objects AS ao
WHERE schema_id = SCHEMA_ID(".q(get_schema()).") AND type IN ('S', 'U', 'V') ".($_!=""?"AND name = ".q($_):"ORDER BY name"))as$I)$H[$I["Name"]]=$I;return$H;}function
is_view($S){return$S["Engine"]=="VIEW";}function
fk_support($S){return
true;}function
fields($R){$bb=get_key_vals("SELECT objname, cast(value as varchar(max)) FROM fn_listextendedproperty('MS_DESCRIPTION', 'schema', ".q(get_schema()).", 'table', ".q($R).", 'column', NULL)");$H=array();$jg=get_val("SELECT object_id FROM sys.all_objects WHERE schema_id = SCHEMA_ID(".q(get_schema()).") AND type IN ('S', 'U', 'V') AND name = ".q($R));foreach(get_rows("SELECT c.max_length, c.precision, c.scale, c.name, c.is_nullable, c.is_identity, c.collation_name, t.name type, d.definition [default], d.name default_constraint, i.is_primary_key
FROM sys.all_columns c
JOIN sys.types t ON c.user_type_id = t.user_type_id
LEFT JOIN sys.default_constraints d ON c.default_object_id = d.object_id
LEFT JOIN sys.index_columns ic ON c.object_id = ic.object_id AND c.column_id = ic.column_id
LEFT JOIN sys.indexes i ON ic.object_id = i.object_id AND ic.index_id = i.index_id
WHERE c.object_id = ".q($jg))as$I){$U=$I["type"];$Id=(preg_match("~char|binary~",$U)?intval($I["max_length"])/($U[0]=='n'?2:1):($U=="decimal"?"$I[precision],$I[scale]":""));$H[$I["name"]]=array("field"=>$I["name"],"full_type"=>$U.($Id?"($Id)":""),"type"=>$U,"length"=>$Id,"default"=>(preg_match("~^\('(.*)'\)$~",$I["default"],$z)?str_replace("''","'",$z[1]):$I["default"]),"default_constraint"=>$I["default_constraint"],"null"=>$I["is_nullable"],"auto_increment"=>$I["is_identity"],"collation"=>$I["collation_name"],"privileges"=>array("insert"=>1,"select"=>1,"update"=>1,"where"=>1,"order"=>1),"primary"=>$I["is_primary_key"],"comment"=>$bb[$I["name"]],);}foreach(get_rows("SELECT * FROM sys.computed_columns WHERE object_id = ".q($jg))as$I){$H[$I["name"]]["generated"]=($I["is_persisted"]?"PERSISTED":"VIRTUAL");$H[$I["name"]]["default"]=$I["definition"];}return$H;}function
indexes($R,$h=null){$H=array();foreach(get_rows("SELECT i.name, key_ordinal, is_unique, is_primary_key, c.name AS column_name, is_descending_key
FROM sys.indexes i
INNER JOIN sys.index_columns ic ON i.object_id = ic.object_id AND i.index_id = ic.index_id
INNER JOIN sys.columns c ON ic.object_id = c.object_id AND ic.column_id = c.column_id
WHERE OBJECT_NAME(i.object_id) = ".q($R),$h)as$I){$_=$I["name"];$H[$_]["type"]=($I["is_primary_key"]?"PRIMARY":($I["is_unique"]?"UNIQUE":"INDEX"));$H[$_]["lengths"]=array();$H[$_]["columns"][$I["key_ordinal"]]=$I["column_name"];$H[$_]["descs"][$I["key_ordinal"]]=($I["is_descending_key"]?'1':null);}return$H;}function
view($_){return
array("select"=>preg_replace('~^(?:[^[]|\[[^]]*])*\s+AS\s+~isU','',get_val("SELECT VIEW_DEFINITION FROM INFORMATION_SCHEMA.VIEWS WHERE TABLE_SCHEMA = SCHEMA_NAME() AND TABLE_NAME = ".q($_))));}function
collations(){$H=array();foreach(get_vals("SELECT name FROM fn_helpcollations()")as$c)$H[preg_replace('~_.*~','',$c)][]=$c;return$H;}function
information_schema($i){return
get_schema()=="INFORMATION_SCHEMA";}function
error(){return
nl_br(h(preg_replace('~^(\[[^]]*])+~m','',connection()->error)));}function
create_database($i,$c){return
queries("CREATE DATABASE ".idf_escape($i).(preg_match('~^[a-z0-9_]+$~i',$c)?" COLLATE $c":""));}function
drop_databases($ub){return
queries("DROP DATABASE ".implode(", ",array_map('Adminer\idf_escape',$ub)));}function
rename_database($_,$c){if(preg_match('~^[a-z0-9_]+$~i',$c))queries("ALTER DATABASE ".idf_escape(DB)." COLLATE $c");queries("ALTER DATABASE ".idf_escape(DB)." MODIFY NAME = ".idf_escape($_));return
true;}function
auto_increment(){return" IDENTITY".($_POST["Auto_increment"]!=""?"(".number($_POST["Auto_increment"]).",1)":"")." PRIMARY KEY";}function
alter_table($R,$_,$m,$wc,$ab,$Sb,$c,$ta,$Se){$b=array();$bb=array();$Ge=fields($R);foreach($m
as$l){$d=idf_escape($l[0]);$X=$l[1];if(!$X)$b["DROP"][]=" COLUMN $d";else{$X[1]=preg_replace("~( COLLATE )'(\\w+)'~",'\1\2',$X[1]);$bb[$l[0]]=$X[5];unset($X[5]);if(preg_match('~ AS ~',$X[3]))unset($X[1],$X[2]);if($l[0]=="")$b["ADD"][]="\n  ".implode("",$X).($R==""?substr($wc[$X[0]],16+strlen($X[0])):"");else{$j=$X[3];unset($X[3]);unset($X[6]);if($d!=$X[0])queries("EXEC sp_rename ".q(table($R).".$d").", ".q(idf_unescape($X[0])).", 'COLUMN'");$b["ALTER COLUMN ".implode("",$X)][]="";$Fe=$Ge[$l[0]];if(default_value($Fe)!=$j){if($Fe["default"]!==null)$b["DROP"][]=" ".idf_escape($Fe["default_constraint"]);if($j)$b["ADD"][]="\n $j FOR $d";}}}}if($R=="")return
queries("CREATE TABLE ".table($_)." (".implode(",",(array)$b["ADD"])."\n)");if($R!=$_)queries("EXEC sp_rename ".q(table($R)).", ".q($_));if($wc)$b[""]=$wc;foreach($b
as$w=>$X){if(!queries("ALTER TABLE ".table($_)." $w".implode(",",$X)))return
false;}foreach($bb
as$w=>$X){$ab=substr($X,9);queries("EXEC sp_dropextendedproperty @name = N'MS_Description', @level0type = N'Schema', @level0name = ".q(get_schema()).", @level1type = N'Table', @level1name = ".q($_).", @level2type = N'Column', @level2name = ".q($w));queries("EXEC sp_addextendedproperty
@name = N'MS_Description',
@value = $ab,
@level0type = N'Schema',
@level0name = ".q(get_schema()).",
@level1type = N'Table',
@level1name = ".q($_).",
@level2type = N'Column',
@level2name = ".q($w));}return
true;}function
alter_indexes($R,$b){$u=array();$Gb=array();foreach($b
as$X){if($X[2]=="DROP"){if($X[0]=="PRIMARY")$Gb[]=idf_escape($X[1]);else$u[]=idf_escape($X[1])." ON ".table($R);}elseif(!queries(($X[0]!="PRIMARY"?"CREATE $X[0] ".($X[0]!="INDEX"?"INDEX ":"").idf_escape($X[1]!=""?$X[1]:uniqid($R."_"))." ON ".table($R):"ALTER TABLE ".table($R)." ADD PRIMARY KEY")." (".implode(", ",$X[2]).")"))return
false;}return(!$u||queries("DROP INDEX ".implode(", ",$u)))&&(!$Gb||queries("ALTER TABLE ".table($R)." DROP ".implode(", ",$Gb)));}function
found_rows($S,$Z){}function
foreign_keys($R){$H=array();$ve=array("CASCADE","NO ACTION","SET NULL","SET DEFAULT");foreach(get_rows("EXEC sp_fkeys @fktable_name = ".q($R).", @fktable_owner = ".q(get_schema()))as$I){$o=&$H[$I["FK_NAME"]];$o["db"]=$I["PKTABLE_QUALIFIER"];$o["ns"]=$I["PKTABLE_OWNER"];$o["table"]=$I["PKTABLE_NAME"];$o["on_update"]=$ve[$I["UPDATE_RULE"]];$o["on_delete"]=$ve[$I["DELETE_RULE"]];$o["source"][]=$I["FKCOLUMN_NAME"];$o["target"][]=$I["PKCOLUMN_NAME"];}return$H;}function
truncate_tables($T){return
apply_queries("TRUNCATE TABLE",$T);}function
drop_views($fh){return
queries("DROP VIEW ".implode(", ",array_map('Adminer\table',$fh)));}function
drop_tables($T){return
queries("DROP TABLE ".implode(", ",array_map('Adminer\table',$T)));}function
move_tables($T,$fh,$mg){return
apply_queries("ALTER SCHEMA ".idf_escape($mg)." TRANSFER",array_merge($T,$fh));}function
trigger($_,$R){if($_=="")return
array();$J=get_rows("SELECT s.name [Trigger],
CASE WHEN OBJECTPROPERTY(s.id, 'ExecIsInsertTrigger') = 1 THEN 'INSERT' WHEN OBJECTPROPERTY(s.id, 'ExecIsUpdateTrigger') = 1 THEN 'UPDATE' WHEN OBJECTPROPERTY(s.id, 'ExecIsDeleteTrigger') = 1 THEN 'DELETE' END [Event],
CASE WHEN OBJECTPROPERTY(s.id, 'ExecIsInsteadOfTrigger') = 1 THEN 'INSTEAD OF' ELSE 'AFTER' END [Timing],
c.text
FROM sysobjects s
JOIN syscomments c ON s.id = c.id
WHERE s.xtype = 'TR' AND s.name = ".q($_));$H=reset($J);if($H)$H["Statement"]=preg_replace('~^.+\s+AS\s+~isU','',$H["text"]);return$H;}function
triggers($R){$H=array();foreach(get_rows("SELECT sys1.name,
CASE WHEN OBJECTPROPERTY(sys1.id, 'ExecIsInsertTrigger') = 1 THEN 'INSERT' WHEN OBJECTPROPERTY(sys1.id, 'ExecIsUpdateTrigger') = 1 THEN 'UPDATE' WHEN OBJECTPROPERTY(sys1.id, 'ExecIsDeleteTrigger') = 1 THEN 'DELETE' END [Event],
CASE WHEN OBJECTPROPERTY(sys1.id, 'ExecIsInsteadOfTrigger') = 1 THEN 'INSTEAD OF' ELSE 'AFTER' END [Timing]
FROM sysobjects sys1
JOIN sysobjects sys2 ON sys1.parent_obj = sys2.id
WHERE sys1.xtype = 'TR' AND sys2.name = ".q($R))as$I)$H[$I["name"]]=array($I["Timing"],$I["Event"]);return$H;}function
trigger_options(){return
array("Timing"=>array("AFTER","INSTEAD OF"),"Event"=>array("INSERT","UPDATE","DELETE"),"Type"=>array("AS"),);}function
schemas(){return
get_vals("SELECT name FROM sys.schemas");}function
get_schema(){if($_GET["ns"]!="")return$_GET["ns"];return
get_val("SELECT SCHEMA_NAME()");}function
set_schema($Cf){$_GET["ns"]=$Cf;return
true;}function
create_sql($R,$ta,$dg){if(is_view(table_status1($R))){$eh=view($R);return"CREATE VIEW ".table($R)." AS $eh[select]";}$m=array();$E=false;foreach(fields($R)as$_=>$l){$X=process_field($l,$l);if($X[6])$E=true;$m[]=implode("",$X);}foreach(indexes($R)as$_=>$u){if(!$E||$u["type"]!="PRIMARY"){$e=array();foreach($u["columns"]as$w=>$X)$e[]=idf_escape($X).($u["descs"][$w]?" DESC":"");$_=idf_escape($_);$m[]=($u["type"]=="INDEX"?"INDEX $_":"CONSTRAINT $_ ".($u["type"]=="UNIQUE"?"UNIQUE":"PRIMARY KEY"))." (".implode(", ",$e).")";}}foreach(driver()->checkConstraints($R)as$_=>$Ma)$m[]="CONSTRAINT ".idf_escape($_)." CHECK ($Ma)";return"CREATE TABLE ".table($R)." (\n\t".implode(",\n\t",$m)."\n)";}function
foreign_keys_sql($R){$m=array();foreach(foreign_keys($R)as$wc)$m[]=ltrim(format_foreign_key($wc));return($m?"ALTER TABLE ".table($R)." ADD\n\t".implode(",\n\t",$m).";\n\n":"");}function
truncate_sql($R){return"TRUNCATE TABLE ".table($R);}function
use_sql($tb){return"USE ".idf_escape($tb);}function
trigger_sql($R){$H="";foreach(triggers($R)as$_=>$Gg)$H
.=create_trigger(" ON ".table($R),trigger($_,$R)).";";return$H;}function
convert_field($l){}function
unconvert_field($l,$H){return$H;}function
support($jc){return
preg_match('~^(check|comment|columns|database|drop_col|dump|indexes|descidx|scheme|sql|table|trigger|view|view_trigger)$~',$jc);}}class
Adminer{static$instance;var$error='';private$values=array();function
name(){return"<a href='https://www.adminer.org/editor/'".target_blank()." id='h1'><img src='".h(preg_replace("~\\?.*~","",ME)."?file=logo.png&version=5.3.0")."' width='24' height='24' alt='' id='logo'>".lang(32)."</a>";}function
credentials(){return
array(SERVER,$_GET["username"],get_password());}function
connectSsl(){}function
permanentLogin($lb=false){return
password_file($lb);}function
bruteForceKey(){return$_SERVER["REMOTE_ADDR"];}function
serverName($M){}function
database(){if(connection()){$ub=adminer()->databases(false);return(!$ub?get_val("SELECT SUBSTRING_INDEX(CURRENT_USER, '@', 1)"):$ub[(information_schema($ub[0])?1:0)]);}}function
operators(){return
array("<=",">=");}function
schemas(){return
schemas();}function
databases($uc=true){return
get_databases($uc);}function
pluginsLinks(){}function
queryTimeout(){return
5;}function
headers(){}function
csp($ob){return$ob;}function
head($rb=null){return
true;}function
bodyClass(){echo" editor";}function
css(){$H=array();foreach(array("","-dark")as$ee){$n="adminer$ee.css";if(file_exists($n)){$mc=file_get_contents($n);$H["$n?v=".crc32($mc)]=($ee?"dark":(preg_match('~prefers-color-scheme:\s*dark~',$mc)?'':'light'));}}return$H;}function
loginForm(){echo"<table class='layout'>\n",adminer()->loginFormField('username','<tr><th>'.lang(33).'<td>',input_hidden("auth[driver]","server").'<input name="auth[username]" autofocus value="'.h($_GET["username"]).'" autocomplete="username" autocapitalize="off">'),adminer()->loginFormField('password','<tr><th>'.lang(34).'<td>','<input type="password" name="auth[password]" autocomplete="current-password">'),"</table>\n","<p><input type='submit' value='".lang(35)."'>\n",checkbox("auth[permanent]",1,$_COOKIE["adminer_permanent"],lang(36))."\n";}function
loginFormField($_,$Sc,$Y){return$Sc.$Y."\n";}function
login($Nd,$D){return
true;}function
tableName($ig){return
h(isset($ig["Engine"])?($ig["Comment"]!=""?$ig["Comment"]:$ig["Name"]):"");}function
fieldName($l,$Ce=0){return
h(preg_replace('~\s+\[.*\]$~','',($l["comment"]!=""?$l["comment"]:$l["field"])));}function
selectLinks($ig,$N=""){$a=$ig["Name"];if($N!==null)echo'<p class="tabs"><a href="'.h(ME.'edit='.urlencode($a).$N).'">'.lang(37)."</a>\n";}function
foreignKeys($R){return
foreign_keys($R);}function
backwardKeys($R,$hg){$H=array();foreach(get_rows("SELECT TABLE_NAME, CONSTRAINT_NAME, COLUMN_NAME, REFERENCED_COLUMN_NAME
FROM information_schema.KEY_COLUMN_USAGE
WHERE TABLE_SCHEMA = ".q(adminer()->database())."
AND REFERENCED_TABLE_SCHEMA = ".q(adminer()->database())."
AND REFERENCED_TABLE_NAME = ".q($R)."
ORDER BY ORDINAL_POSITION",null,"")as$I)$H[$I["TABLE_NAME"]]["keys"][$I["CONSTRAINT_NAME"]][$I["COLUMN_NAME"]]=$I["REFERENCED_COLUMN_NAME"];foreach($H
as$w=>$X){$_=adminer()->tableName(table_status1($w,true));if($_!=""){$Ef=preg_quote($hg);$L="(:|\\s*-)?\\s+";$H[$w]["name"]=(preg_match("(^$Ef$L(.+)|^(.+?)$L$Ef\$)iu",$_,$z)?$z[2].$z[3]:$_);}else
unset($H[$w]);}return$H;}function
backwardKeysPrint($ya,$I){foreach($ya
as$R=>$xa){foreach($xa["keys"]as$Xa){$y=ME.'select='.urlencode($R);$r=0;foreach($Xa
as$d=>$X)$y
.=where_link($r++,$d,$I[$X]);echo"<a href='".h($y)."'>".h($xa["name"])."</a>";$y=ME.'edit='.urlencode($R);foreach($Xa
as$d=>$X)$y
.="&set".urlencode("[".bracket_escape($d)."]")."=".urlencode($I[$X]);echo"<a href='".h($y)."' title='".lang(37)."'>+</a> ";}}}function
selectQuery($F,$bg,$hc=false){return"<!--\n".str_replace("--","--><!-- ",$F)."\n(".format_time($bg).")\n-->\n";}function
rowDescription($R){foreach(fields($R)as$l){if(preg_match("~varchar|character varying~",$l["type"]))return
idf_escape($l["field"]);}return"";}function
rowDescriptions($J,$yc){$H=$J;foreach($J[0]as$w=>$X){if(list($R,$s,$_)=$this->_foreignColumn($yc,$w)){$cd=array();foreach($J
as$I)$cd[$I[$w]]=q($I[$w]);$_b=$this->values[$R];if(!$_b)$_b=get_key_vals("SELECT $s, $_ FROM ".table($R)." WHERE $s IN (".implode(", ",$cd).")");foreach($J
as$ie=>$I){if(isset($I[$w]))$H[$ie][$w]=(string)$_b[$I[$w]];}}}return$H;}function
selectLink($X,$l){}function
selectVal($X,$y,$l,$He){$H=$X;$y=h($y);if(preg_match('~blob|bytea~',$l["type"])&&!is_utf8($X)){$H=lang(38,strlen($He));if(preg_match("~^(GIF|\xFF\xD8\xFF|\x89PNG\x0D\x0A\x1A\x0A)~",$He))$H="<img src='$y' alt='$H'>";}if(like_bool($l)&&$H!="")$H=(preg_match('~^(1|t|true|y|yes|on)$~i',$X)?lang(39):lang(40));if($y)$H="<a href='$y'".(is_url($y)?target_blank():"").">$H</a>";if(preg_match('~date~',$l["type"]))$H="<div class='datetime'>$H</div>";return$H;}function
editVal($X,$l){if(preg_match('~date|timestamp~',$l["type"])&&$X!==null)return
preg_replace('~^(\d{2}(\d+))-(0?(\d+))-(0?(\d+))~',lang(41),$X);return$X;}function
config(){return
array();}function
selectColumnsPrint($K,$e){}function
selectSearchPrint($Z,$e,$v){$Z=(array)$_GET["where"];echo'<fieldset id="fieldset-search"><legend>'.lang(42)."</legend><div>\n";$_d=array();foreach($Z
as$w=>$X)$_d[$X["col"]]=$w;$r=0;$m=fields($_GET["select"]);foreach($e
as$_=>$zb){$l=$m[$_];if(preg_match("~enum~",$l["type"])||like_bool($l)){$w=$_d[$_];$r--;echo"<div>".h($zb).":".input_hidden("where[$r][col]",$_);$X=idx($Z[$w],"val");echo(like_bool($l)?"<select name='where[$r][val]'>".optionlist(array(""=>"",lang(40),lang(39)),$X,true)."</select>":enum_input("checkbox"," name='where[$r][val][]'",$l,(array)$X,($l["null"]?0:null))),"</div>\n";unset($e[$_]);}elseif(is_array($B=$this->foreignKeyOptions($_GET["select"],$_))){if($m[$_]["null"])$B[0]='('.lang(7).')';$w=$_d[$_];$r--;echo"<div>".h($zb).input_hidden("where[$r][col]",$_).input_hidden("where[$r][op]","=").": <select name='where[$r][val]'>".optionlist($B,idx($Z[$w],"val"),true)."</select></div>\n";unset($e[$_]);}}$r=0;foreach($Z
as$X){if(($X["col"]==""||$e[$X["col"]])&&"$X[col]$X[val]"!=""){echo"<div><select name='where[$r][col]'><option value=''>(".lang(43).")".optionlist($e,$X["col"],true)."</select>",html_select("where[$r][op]",array(-1=>"")+adminer()->operators(),$X["op"]),"<input type='search' name='where[$r][val]' value='".h($X["val"])."'>".script("mixin(qsl('input'), {onkeydown: selectSearchKeydown, onsearch: selectSearchSearch});","")."</div>\n";$r++;}}echo"<div><select name='where[$r][col]'><option value=''>(".lang(43).")".optionlist($e,null,true)."</select>",script("qsl('select').onchange = selectAddRow;",""),html_select("where[$r][op]",array(-1=>"")+adminer()->operators()),"<input type='search' name='where[$r][val]'></div>",script("mixin(qsl('input'), {onchange: function () { this.parentNode.firstChild.onchange(); }, onsearch: selectSearchSearch});"),"</div></fieldset>\n";}function
selectOrderPrint($Ce,$e,$v){$Ee=array();foreach($v
as$w=>$u){$Ce=array();foreach($u["columns"]as$X)$Ce[]=$e[$X];if(count(array_filter($Ce,'strlen'))>1&&$w!="PRIMARY")$Ee[$w]=implode(", ",$Ce);}if($Ee)echo'<fieldset><legend>'.lang(44)."</legend><div>","<select name='index_order'>".optionlist(array(""=>"")+$Ee,(idx($_GET["order"],0)!=""?"":$_GET["index_order"]),true)."</select>","</div></fieldset>\n";if($_GET["order"])echo"<div style='display: none;'>".hidden_fields(array("order"=>array(1=>reset($_GET["order"])),"desc"=>($_GET["desc"]?array(1=>1):array()),))."</div>\n";}function
selectLimitPrint($x){echo"<fieldset><legend>".lang(45)."</legend><div>",html_select("limit",array("",50,100),$x),"</div></fieldset>\n";}function
selectLengthPrint($qg){}function
selectActionPrint($v){echo"<fieldset><legend>".lang(46)."</legend><div>","<input type='submit' value='".lang(47)."'>","</div></fieldset>\n";}function
selectCommandPrint(){return
true;}function
selectImportPrint(){return
true;}function
selectEmailPrint($Pb,$e){}function
selectColumnsProcess($e,$v){return
array(array(),array());}function
selectSearchProcess($m,$v){$H=array();foreach((array)$_GET["where"]as$w=>$Z){$Va=$Z["col"];$ye=$Z["op"];$X=$Z["val"];if(($w>=0&&$Va!="")||$X!=""){$cb=array();foreach(($Va!=""?array($Va=>$m[$Va]):$m)as$_=>$l){if($Va!=""||is_numeric($X)||!preg_match(number_type(),$l["type"])){$_=idf_escape($_);if($Va!=""&&$l["type"]=="enum")$cb[]=(in_array(0,$X)?"$_ IS NULL OR ":"")."$_ IN (".implode(", ",array_map('Adminer\q',$X)).")";else{$rg=preg_match('~char|text|enum|set~',$l["type"]);$Y=adminer()->processInput($l,(!$ye&&$rg&&preg_match('~^[^%]+$~',$X)?"%$X%":$X));$cb[]=driver()->convertSearch($_,$Z,$l).($Y=="NULL"?" IS".($ye==">="?" NOT":"")." $Y":(in_array($ye,adminer()->operators())||$ye=="="?" $ye $Y":($rg?" LIKE $Y":" IN (".($Y[0]=="'"?str_replace(",","', '",$Y):$Y).")")));if($w<0&&$X=="0")$cb[]="$_ IS NULL";}}}$H[]=($cb?"(".implode(" OR ",$cb).")":"1 = 0");}}return$H;}function
selectOrderProcess($m,$v){$gd=$_GET["index_order"];if($gd!="")unset($_GET["order"][1]);if($_GET["order"])return
array(idf_escape(reset($_GET["order"])).($_GET["desc"]?" DESC":""));foreach(($gd!=""?array($v[$gd]):$v)as$u){if($gd!=""||$u["type"]=="INDEX"){$Mc=array_filter($u["descs"]);$zb=false;foreach($u["columns"]as$X){if(preg_match('~date|timestamp~',$m[$X]["type"])){$zb=true;break;}}$H=array();foreach($u["columns"]as$w=>$X)$H[]=idf_escape($X).(($Mc?$u["descs"][$w]:$zb)?" DESC":"");return$H;}}return
array();}function
selectLimitProcess(){return(isset($_GET["limit"])?intval($_GET["limit"]):50);}function
selectLengthProcess(){return"100";}function
selectEmailProcess($Z,$yc){return
false;}function
selectQueryBuild($K,$Z,$Gc,$Ce,$x,$C){return"";}function
messageQuery($F,$sg,$hc=false){return" <span class='time'>".@date("H:i:s")."</span><!--\n".str_replace("--","--><!-- ",$F)."\n".($sg?"($sg)\n":"")."-->";}function
editRowPrint($R,$m,$I,$Ug){}function
editFunctions($l){$H=array();if($l["null"]&&preg_match('~blob~',$l["type"]))$H["NULL"]=lang(7);$H[""]=($l["null"]||$l["auto_increment"]||like_bool($l)?"":"*");if(preg_match('~date|time~',$l["type"]))$H["now"]=lang(48);if(preg_match('~_(md5|sha1)$~i',$l["field"],$z))$H[]=strtolower($z[1]);return$H;}function
editInput($R,$l,$ra,$Y){if($l["type"]=="enum")return(isset($_GET["select"])?"<label><input type='radio'$ra value='-1' checked><i>".lang(8)."</i></label> ":"").enum_input("radio",$ra,$l,($Y||isset($_GET["select"])?$Y:""),($l["null"]?"":null));$B=$this->foreignKeyOptions($R,$l["field"],$Y);if($B!==null)return(is_array($B)?"<select$ra>".optionlist($B,$Y,true)."</select>":"<input value='".h($Y)."'$ra class='hidden'>"."<input value='".h($B)."' class='jsonly'>"."<div></div>".script("qsl('input').oninput = partial(whisper, '".ME."script=complete&source=".urlencode($R)."&field=".urlencode($l["field"])."&value='); qsl('div').onclick = whisperClick;",""));if(like_bool($l))return'<input type="checkbox" value="1"'.(preg_match('~^(1|t|true|y|yes|on)$~i',$Y)?' checked':'')."$ra>";$Uc="";if(preg_match('~time~',$l["type"]))$Uc=lang(49);if(preg_match('~date|timestamp~',$l["type"]))$Uc=lang(50).($Uc?" [$Uc]":"");if($Uc)return"<input value='".h($Y)."'$ra> ($Uc)";if(preg_match('~_(md5|sha1)$~i',$l["field"]))return"<input type='password' value='".h($Y)."'$ra>";return'';}function
editHint($R,$l,$Y){return(preg_match('~\s+(\[.*\])$~',($l["comment"]!=""?$l["comment"]:$l["field"]),$z)?h(" $z[1]"):'');}function
processInput($l,$Y,$q=""){if($q=="now")return"$q()";$H=$Y;if(preg_match('~date|timestamp~',$l["type"])&&preg_match('(^'.str_replace('\$1','(?P<p1>\d*)',preg_replace('~(\\\\\\$([2-6]))~','(?P<p\2>\d{1,2})',preg_quote(lang(41)))).'(.*))',$Y,$z))$H=($z["p1"]!=""?$z["p1"]:($z["p2"]!=""?($z["p2"]<70?20:19).$z["p2"]:gmdate("Y")))."-$z[p3]$z[p4]-$z[p5]$z[p6]".end($z);$H=q($H);if($Y==""&&like_bool($l))$H="'0'";elseif($Y==""&&($l["null"]||!preg_match('~char|text~',$l["type"])))$H="NULL";elseif(preg_match('~^(md5|sha1)$~',$q))$H="$q($H)";return
unconvert_field($l,$H);}function
dumpOutput(){return
array();}function
dumpFormat(){return
array('csv'=>'CSV,','csv;'=>'CSV;','tsv'=>'TSV');}function
dumpDatabase($i){}function
dumpTable($R,$dg,$wd=0){echo"\xef\xbb\xbf";}function
dumpData($R,$dg,$F){$G=connection()->query($F,1);if($G){while($I=$G->fetch_assoc()){if($dg=="table"){dump_csv(array_keys($I));$dg="INSERT";}dump_csv($I);}}}function
dumpFilename($ad){return
friendly_url($ad);}function
dumpHeaders($ad,$ge=false){$dc="csv";header("Content-Type: text/csv; charset=utf-8");return$dc;}function
dumpFooter(){}function
importServerPath(){}function
homepage(){return
true;}function
navigation($de){echo"<h1>".adminer()->name()." <span class='version'>".VERSION;$le=$_COOKIE["adminer_version"];echo" <a href='https://www.adminer.org/editor/#download'".target_blank()." id='version'>".(version_compare(VERSION,$le)<0?h($le):"")."</a>","</span></h1>\n";switch_lang();if($de=="auth"){$pc=true;foreach((array)$_SESSION["pwds"]as$ch=>$Of){foreach($Of[""]as$V=>$D){if($D!==null){if($pc){echo"<ul id='logins'>",script("mixin(qs('#logins'), {onmouseover: menuOver, onmouseout: menuOut});");$pc=false;}echo"<li><a href='".h(auth_url($ch,"",$V))."'>".($V!=""?h($V):"<i>".lang(7)."</i>")."</a>\n";}}}}else{adminer()->databasesPrint($de);if($de!="db"&&$de!="ns"){$S=table_status('',true);if(!$S)echo"<p class='message'>".lang(9)."\n";else
adminer()->tablesPrint($S);}}}function
syntaxHighlighting($T){}function
databasesPrint($de){}function
tablesPrint($T){echo"<ul id='tables'>",script("mixin(qs('#tables'), {onmouseover: menuOver, onmouseout: menuOut});");foreach($T
as$I){echo'<li>';$_=adminer()->tableName($I);if($_!="")echo"<a href='".h(ME).'select='.urlencode($I["Name"])."'".bold($_GET["select"]==$I["Name"]||$_GET["edit"]==$I["Name"],"select")." title='".lang(51)."'>$_</a>\n";}echo"</ul>\n";}function
_foreignColumn($yc,$d){foreach((array)$yc[$d]as$xc){if(count($xc["source"])==1){$_=adminer()->rowDescription($xc["table"]);if($_!=""){$s=idf_escape($xc["target"][0]);return
array($xc["table"],$s,$_);}}}}private
function
foreignKeyOptions($R,$d,$Y=null){if(list($mg,$s,$_)=$this->_foreignColumn(column_foreign_keys($R),$d)){$H=&$this->values[$mg];if($H===null){$S=table_status1($mg);$H=($S["Rows"]>1000?"":array(""=>"")+get_key_vals("SELECT $s, $_ FROM ".table($mg)." ORDER BY 2"));}if(!$H&&$Y!==null)return
get_val("SELECT $_ FROM ".table($mg)." WHERE $s = ".q($Y));return$H;}}}class
Plugins{private
static$append=array('dumpFormat'=>true,'dumpOutput'=>true,'editRowPrint'=>true,'editFunctions'=>true,'config'=>true);var$plugins;var$error='';private$hooks=array();function
__construct($Ze){if($Ze===null){$Ze=array();$Aa="adminer-plugins";if(is_dir($Aa)){foreach(glob("$Aa/*.php")as$n)$ed=include_once"./$n";}$Tc=" href='https://www.adminer.org/plugins/#use'".target_blank();if(file_exists("$Aa.php")){$ed=include_once"./$Aa.php";if(is_array($ed)){foreach($ed
as$Ye)$Ze[get_class($Ye)]=$Ye;}else$this->error
.=lang(52,"<b>$Aa.php</b>",$Tc)."<br>";}foreach(get_declared_classes()as$Ra){if(!$Ze[$Ra]&&preg_match('~^Adminer\w~i',$Ra)){$sf=new
\ReflectionClass($Ra);$hb=$sf->getConstructor();if($hb&&$hb->getNumberOfRequiredParameters())$this->error
.=lang(53,$Tc,"<b>$Ra</b>","<b>$Aa.php</b>")."<br>";else$Ze[$Ra]=new$Ra;}}}$this->plugins=$Ze;$ga=new
Adminer;$Ze[]=$ga;$sf=new
\ReflectionObject($ga);foreach($sf->getMethods()as$ce){foreach($Ze
as$Ye){$_=$ce->getName();if(method_exists($Ye,$_))$this->hooks[$_][]=$Ye;}}}function
__call($_,array$Oe){$ma=array();foreach($Oe
as$w=>$X)$ma[]=&$Oe[$w];$H=null;foreach($this->hooks[$_]as$Ye){$Y=call_user_func_array(array($Ye,$_),$ma);if($Y!==null){if(!self::$append[$_])return$Y;$H=$Y+(array)$H;}}return$H;}}abstract
class
Plugin{protected$translations=array();function
description(){return$this->lang('');}function
screenshot(){return"";}protected
function
lang($t,$A=null){$ma=func_get_args();$ma[0]=idx($this->translations[LANG],$t)?:$t;return
call_user_func_array('Adminer\lang_format',$ma);}}Adminer::$instance=(function_exists('adminer_object')?adminer_object():(is_dir("adminer-plugins")||file_exists("adminer-plugins.php")?new
Plugins(null):new
Adminer));SqlDriver::$drivers=array("server"=>"MySQL / MariaDB")+SqlDriver::$drivers;if(!defined('Adminer\DRIVER')){define('Adminer\DRIVER',"server");if(extension_loaded("mysqli")&&$_GET["ext"]!="pdo"){class
Db
extends
\MySQLi{static$instance;var$extension="MySQLi",$flavor='';function
__construct(){parent::init();}function
attach($M,$V,$D){mysqli_report(MYSQLI_REPORT_OFF);list($Wc,$af)=explode(":",$M,2);$O=adminer()->connectSsl();if($O)$this->ssl_set($O['key'],$O['cert'],$O['ca'],'','');$H=@$this->real_connect(($M!=""?$Wc:ini_get("mysqli.default_host")),($M.$V!=""?$V:ini_get("mysqli.default_user")),($M.$V.$D!=""?$D:ini_get("mysqli.default_pw")),null,(is_numeric($af)?intval($af):ini_get("mysqli.default_port")),(is_numeric($af)?null:$af),($O?($O['verify']!==false?2048:64):0));$this->options(MYSQLI_OPT_LOCAL_INFILE,false);return($H?'':$this->error);}function
set_charset($La){if(parent::set_charset($La))return
true;parent::set_charset('utf8');return$this->query("SET NAMES $La");}function
next_result(){return
self::more_results()&&parent::next_result();}function
quote($Q){return"'".$this->escape_string($Q)."'";}}}elseif(extension_loaded("mysql")&&!((ini_bool("sql.safe_mode")||ini_bool("mysql.allow_local_infile"))&&extension_loaded("pdo_mysql"))){class
Db
extends
SqlDb{private$link;function
attach($M,$V,$D){if(ini_bool("mysql.allow_local_infile"))return
lang(54,"'mysql.allow_local_infile'","MySQLi","PDO_MySQL");$this->link=@mysql_connect(($M!=""?$M:ini_get("mysql.default_host")),("$M$V"!=""?$V:ini_get("mysql.default_user")),("$M$V$D"!=""?$D:ini_get("mysql.default_password")),true,131072);if(!$this->link)return
mysql_error();$this->server_info=mysql_get_server_info($this->link);return'';}function
set_charset($La){if(function_exists('mysql_set_charset')){if(mysql_set_charset($La,$this->link))return
true;mysql_set_charset('utf8',$this->link);}return$this->query("SET NAMES $La");}function
quote($Q){return"'".mysql_real_escape_string($Q,$this->link)."'";}function
select_db($tb){return
mysql_select_db($tb,$this->link);}function
query($F,$Mg=false){$G=@($Mg?mysql_unbuffered_query($F,$this->link):mysql_query($F,$this->link));$this->error="";if(!$G){$this->errno=mysql_errno($this->link);$this->error=mysql_error($this->link);return
false;}if($G===true){$this->affected_rows=mysql_affected_rows($this->link);$this->info=mysql_info($this->link);return
true;}return
new
Result($G);}}class
Result{var$num_rows;private$result;private$offset=0;function
__construct($G){$this->result=$G;$this->num_rows=mysql_num_rows($G);}function
fetch_assoc(){return
mysql_fetch_assoc($this->result);}function
fetch_row(){return
mysql_fetch_row($this->result);}function
fetch_field(){$H=mysql_fetch_field($this->result,$this->offset++);$H->orgtable=$H->table;$H->charsetnr=($H->blob?63:0);return$H;}function
__destruct(){mysql_free_result($this->result);}}}elseif(extension_loaded("pdo_mysql")){class
Db
extends
PdoDb{var$extension="PDO_MySQL";function
attach($M,$V,$D){$B=array(\PDO::MYSQL_ATTR_LOCAL_INFILE=>false);$O=adminer()->connectSsl();if($O){if($O['key'])$B[\PDO::MYSQL_ATTR_SSL_KEY]=$O['key'];if($O['cert'])$B[\PDO::MYSQL_ATTR_SSL_CERT]=$O['cert'];if($O['ca'])$B[\PDO::MYSQL_ATTR_SSL_CA]=$O['ca'];if(isset($O['verify']))$B[\PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT]=$O['verify'];}return$this->dsn("mysql:charset=utf8;host=".str_replace(":",";unix_socket=",preg_replace('~:(\d)~',';port=\1',$M)),$V,$D,$B);}function
set_charset($La){return$this->query("SET NAMES $La");}function
select_db($tb){return$this->query("USE ".idf_escape($tb));}function
query($F,$Mg=false){$this->pdo->setAttribute(\PDO::MYSQL_ATTR_USE_BUFFERED_QUERY,!$Mg);return
parent::query($F,$Mg);}}}class
Driver
extends
SqlDriver{static$extensions=array("MySQLi","MySQL","PDO_MySQL");static$jush="sql";var$unsigned=array("unsigned","zerofill","unsigned zerofill");var$operators=array("=","<",">","<=",">=","!=","LIKE","LIKE %%","REGEXP","IN","FIND_IN_SET","IS NULL","NOT LIKE","NOT REGEXP","NOT IN","IS NOT NULL","SQL");var$functions=array("char_length","date","from_unixtime","lower","round","floor","ceil","sec_to_time","time_to_sec","upper");var$grouping=array("avg","count","count distinct","group_concat","max","min","sum");static
function
connect($M,$V,$D){$g=parent::connect($M,$V,$D);if(is_string($g)){if(function_exists('iconv')&&!is_utf8($g)&&strlen($Bf=iconv("windows-1250","utf-8",$g))>strlen($g))$g=$Bf;return$g;}$g->set_charset(charset($g));$g->query("SET sql_quote_show_create = 1, autocommit = 1");$g->flavor=(preg_match('~MariaDB~',$g->server_info)?'maria':'mysql');add_driver(DRIVER,($g->flavor=='maria'?"MariaDB":"MySQL"));return$g;}function
__construct(Db$g){parent::__construct($g);$this->types=array(lang(25)=>array("tinyint"=>3,"smallint"=>5,"mediumint"=>8,"int"=>10,"bigint"=>20,"decimal"=>66,"float"=>12,"double"=>21),lang(26)=>array("date"=>10,"datetime"=>19,"timestamp"=>19,"time"=>10,"year"=>4),lang(27)=>array("char"=>255,"varchar"=>65535,"tinytext"=>255,"text"=>65535,"mediumtext"=>16777215,"longtext"=>4294967295),lang(55)=>array("enum"=>65535,"set"=>64),lang(28)=>array("bit"=>20,"binary"=>255,"varbinary"=>65535,"tinyblob"=>255,"blob"=>65535,"mediumblob"=>16777215,"longblob"=>4294967295),lang(30)=>array("geometry"=>0,"point"=>0,"linestring"=>0,"polygon"=>0,"multipoint"=>0,"multilinestring"=>0,"multipolygon"=>0,"geometrycollection"=>0),);$this->insertFunctions=array("char"=>"md5/sha1/password/encrypt/uuid","binary"=>"md5/sha1","date|time"=>"now",);$this->editFunctions=array(number_type()=>"+/-","date"=>"+ interval/- interval","time"=>"addtime/subtime","char|text"=>"concat",);if(min_version('5.7.8',10.2,$g))$this->types[lang(27)]["json"]=4294967295;if(min_version('',10.7,$g)){$this->types[lang(27)]["uuid"]=128;$this->insertFunctions['uuid']='uuid';}if(min_version(9,'',$g)){$this->types[lang(25)]["vector"]=16383;$this->insertFunctions['vector']='string_to_vector';}if(min_version(5.1,'',$g))$this->partitionBy=array("HASH","LINEAR HASH","KEY","LINEAR KEY","RANGE","LIST");if(min_version(5.7,10.2,$g))$this->generated=array("STORED","VIRTUAL");}function
unconvertFunction(array$l){return(preg_match("~binary~",$l["type"])?"<code class='jush-sql'>UNHEX</code>":($l["type"]=="bit"?doc_link(array('sql'=>'bit-value-literals.html'),"<code>b''</code>"):(preg_match("~geometry|point|linestring|polygon~",$l["type"])?"<code class='jush-sql'>GeomFromText</code>":"")));}function
insert($R,array$N){return($N?parent::insert($R,$N):queries("INSERT INTO ".table($R)." ()\nVALUES ()"));}function
insertUpdate($R,array$J,array$E){$e=array_keys(reset($J));$ef="INSERT INTO ".table($R)." (".implode(", ",$e).") VALUES\n";$bh=array();foreach($e
as$w)$bh[$w]="$w = VALUES($w)";$fg="\nON DUPLICATE KEY UPDATE ".implode(", ",$bh);$bh=array();$Id=0;foreach($J
as$N){$Y="(".implode(", ",$N).")";if($bh&&(strlen($ef)+$Id+strlen($Y)+strlen($fg)>1e6)){if(!queries($ef.implode(",\n",$bh).$fg))return
false;$bh=array();$Id=0;}$bh[]=$Y;$Id+=strlen($Y)+2;}return
queries($ef.implode(",\n",$bh).$fg);}function
slowQuery($F,$tg){if(min_version('5.7.8','10.1.2')){if($this->conn->flavor=='maria')return"SET STATEMENT max_statement_time=$tg FOR $F";elseif(preg_match('~^(SELECT\b)(.+)~is',$F,$z))return"$z[1] /*+ MAX_EXECUTION_TIME(".($tg*1000).") */ $z[2]";}}function
convertSearch($t,array$X,array$l){return(preg_match('~char|text|enum|set~',$l["type"])&&!preg_match("~^utf8~",$l["collation"])&&preg_match('~[\x80-\xFF]~',$X['val'])?"CONVERT($t USING ".charset($this->conn).")":$t);}function
warnings(){$G=$this->conn->query("SHOW WARNINGS");if($G&&$G->num_rows){ob_start();print_select_result($G);return
ob_get_clean();}}function
tableHelp($_,$wd=false){$Pd=($this->conn->flavor=='maria');if(information_schema(DB))return
strtolower("information-schema-".($Pd?"$_-table/":str_replace("_","-",$_)."-table.html"));if(DB=="mysql")return($Pd?"mysql$_-table/":"system-schema.html");}function
partitionsInfo($R){$Bc="FROM information_schema.PARTITIONS WHERE TABLE_SCHEMA = ".q(DB)." AND TABLE_NAME = ".q($R);$G=connection()->query("SELECT PARTITION_METHOD, PARTITION_EXPRESSION, PARTITION_ORDINAL_POSITION $Bc ORDER BY PARTITION_ORDINAL_POSITION DESC LIMIT 1");$H=array();list($H["partition_by"],$H["partition"],$H["partitions"])=$G->fetch_row();$Te=get_key_vals("SELECT PARTITION_NAME, PARTITION_DESCRIPTION $Bc AND PARTITION_NAME != '' ORDER BY PARTITION_ORDINAL_POSITION");$H["partition_names"]=array_keys($Te);$H["partition_values"]=array_values($Te);return$H;}function
hasCStyleEscapes(){static$Ja;if($Ja===null){$Zf=get_val("SHOW VARIABLES LIKE 'sql_mode'",1,$this->conn);$Ja=(strpos($Zf,'NO_BACKSLASH_ESCAPES')===false);}return$Ja;}function
engines(){$H=array();foreach(get_rows("SHOW ENGINES")as$I){if(preg_match("~YES|DEFAULT~",$I["Support"]))$H[]=$I["Engine"];}return$H;}function
indexAlgorithms(array$ig){return(preg_match('~^(MEMORY|NDB)$~',$ig["Engine"])?array("HASH","BTREE"):array());}}function
idf_escape($t){return"`".str_replace("`","``",$t)."`";}function
table($t){return
idf_escape($t);}function
get_databases($uc){$H=get_session("dbs");if($H===null){$F="SELECT SCHEMA_NAME FROM information_schema.SCHEMATA ORDER BY SCHEMA_NAME";$H=($uc?slow_query($F):get_vals($F));restart_session();set_session("dbs",$H);stop_session();}return$H;}function
limit($F,$Z,$x,$re=0,$L=" "){return" $F$Z".($x?$L."LIMIT $x".($re?" OFFSET $re":""):"");}function
limit1($R,$F,$Z,$L="\n"){return
limit($F,$Z,1,0,$L);}function
db_collation($i,array$Wa){$H=null;$lb=get_val("SHOW CREATE DATABASE ".idf_escape($i),1);if(preg_match('~ COLLATE ([^ ]+)~',$lb,$z))$H=$z[1];elseif(preg_match('~ CHARACTER SET ([^ ]+)~',$lb,$z))$H=$Wa[$z[1]][-1];return$H;}function
logged_user(){return
get_val("SELECT USER()");}function
tables_list(){return
get_key_vals("SELECT TABLE_NAME, TABLE_TYPE FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() ORDER BY TABLE_NAME");}function
count_tables(array$ub){$H=array();foreach($ub
as$i)$H[$i]=count(get_vals("SHOW TABLES IN ".idf_escape($i)));return$H;}function
table_status($_="",$ic=false){$H=array();foreach(get_rows($ic?"SELECT TABLE_NAME AS Name, ENGINE AS Engine, TABLE_COMMENT AS Comment FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() ".($_!=""?"AND TABLE_NAME = ".q($_):"ORDER BY Name"):"SHOW TABLE STATUS".($_!=""?" LIKE ".q(addcslashes($_,"%_\\")):""))as$I){if($I["Engine"]=="InnoDB")$I["Comment"]=preg_replace('~(?:(.+); )?InnoDB free: .*~','\1',$I["Comment"]);if(!isset($I["Engine"]))$I["Comment"]="";if($_!="")$I["Name"]=$_;$H[$I["Name"]]=$I;}return$H;}function
is_view(array$S){return$S["Engine"]===null;}function
fk_support(array$S){return
preg_match('~InnoDB|IBMDB2I'.(min_version(5.6)?'|NDB':'').'~i',$S["Engine"]);}function
fields($R){$Pd=(connection()->flavor=='maria');$H=array();foreach(get_rows("SELECT * FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = ".q($R)." ORDER BY ORDINAL_POSITION")as$I){$l=$I["COLUMN_NAME"];$U=$I["COLUMN_TYPE"];$Fc=$I["GENERATION_EXPRESSION"];$gc=$I["EXTRA"];preg_match('~^(VIRTUAL|PERSISTENT|STORED)~',$gc,$Ec);preg_match('~^([^( ]+)(?:\((.+)\))?( unsigned)?( zerofill)?$~',$U,$Sd);$j=$I["COLUMN_DEFAULT"];if($j!=""){$vd=preg_match('~text|json~',$Sd[1]);if(!$Pd&&$vd)$j=preg_replace("~^(_\w+)?('.*')$~",'\2',stripslashes($j));if($Pd||$vd){$j=($j=="NULL"?null:preg_replace_callback("~^'(.*)'$~",function($z){return
stripslashes(str_replace("''","'",$z[1]));},$j));}if(!$Pd&&preg_match('~binary~',$Sd[1])&&preg_match('~^0x(\w*)$~',$j,$z))$j=pack("H*",$z[1]);}$H[$l]=array("field"=>$l,"full_type"=>$U,"type"=>$Sd[1],"length"=>$Sd[2],"unsigned"=>ltrim($Sd[3].$Sd[4]),"default"=>($Ec?($Pd?$Fc:stripslashes($Fc)):$j),"null"=>($I["IS_NULLABLE"]=="YES"),"auto_increment"=>($gc=="auto_increment"),"on_update"=>(preg_match('~\bon update (\w+)~i',$gc,$z)?$z[1]:""),"collation"=>$I["COLLATION_NAME"],"privileges"=>array_flip(explode(",","$I[PRIVILEGES],where,order")),"comment"=>$I["COLUMN_COMMENT"],"primary"=>($I["COLUMN_KEY"]=="PRI"),"generated"=>($Ec[1]=="PERSISTENT"?"STORED":$Ec[1]),);}return$H;}function
indexes($R,$h=null){$H=array();foreach(get_rows("SHOW INDEX FROM ".table($R),$h)as$I){$_=$I["Key_name"];$H[$_]["type"]=($_=="PRIMARY"?"PRIMARY":($I["Index_type"]=="FULLTEXT"?"FULLTEXT":($I["Non_unique"]?($I["Index_type"]=="SPATIAL"?"SPATIAL":"INDEX"):"UNIQUE")));$H[$_]["columns"][]=$I["Column_name"];$H[$_]["lengths"][]=($I["Index_type"]=="SPATIAL"?null:$I["Sub_part"]);$H[$_]["descs"][]=null;$H[$_]["algorithm"]=$I["Index_type"];}return$H;}function
foreign_keys($R){static$Ve='(?:`(?:[^`]|``)+`|"(?:[^"]|"")+")';$H=array();$mb=get_val("SHOW CREATE TABLE ".table($R),1);if($mb){preg_match_all("~CONSTRAINT ($Ve) FOREIGN KEY ?\\(((?:$Ve,? ?)+)\\) REFERENCES ($Ve)(?:\\.($Ve))? \\(((?:$Ve,? ?)+)\\)(?: ON DELETE (".driver()->onActions."))?(?: ON UPDATE (".driver()->onActions."))?~",$mb,$Td,PREG_SET_ORDER);foreach($Td
as$z){preg_match_all("~$Ve~",$z[2],$Vf);preg_match_all("~$Ve~",$z[5],$mg);$H[idf_unescape($z[1])]=array("db"=>idf_unescape($z[4]!=""?$z[3]:$z[4]),"table"=>idf_unescape($z[4]!=""?$z[4]:$z[3]),"source"=>array_map('Adminer\idf_unescape',$Vf[0]),"target"=>array_map('Adminer\idf_unescape',$mg[0]),"on_delete"=>($z[6]?:"RESTRICT"),"on_update"=>($z[7]?:"RESTRICT"),);}}return$H;}function
view($_){return
array("select"=>preg_replace('~^(?:[^`]|`[^`]*`)*\s+AS\s+~isU','',get_val("SHOW CREATE VIEW ".table($_),1)));}function
collations(){$H=array();foreach(get_rows("SHOW COLLATION")as$I){if($I["Default"])$H[$I["Charset"]][-1]=$I["Collation"];else$H[$I["Charset"]][]=$I["Collation"];}ksort($H);foreach($H
as$w=>$X)sort($H[$w]);return$H;}function
information_schema($i){return($i=="information_schema")||(min_version(5.5)&&$i=="performance_schema");}function
error(){return
h(preg_replace('~^You have an error.*syntax to use~U',"Syntax error",connection()->error));}function
create_database($i,$c){return
queries("CREATE DATABASE ".idf_escape($i).($c?" COLLATE ".q($c):""));}function
drop_databases(array$ub){$H=apply_queries("DROP DATABASE",$ub,'Adminer\idf_escape');restart_session();set_session("dbs",null);return$H;}function
rename_database($_,$c){$H=false;if(create_database($_,$c)){$T=array();$fh=array();foreach(tables_list()as$R=>$U){if($U=='VIEW')$fh[]=$R;else$T[]=$R;}$H=(!$T&&!$fh)||move_tables($T,$fh,$_);drop_databases($H?array(DB):array());}return$H;}function
auto_increment(){$ua=" PRIMARY KEY";if($_GET["create"]!=""&&$_POST["auto_increment_col"]){foreach(indexes($_GET["create"])as$u){if(in_array($_POST["fields"][$_POST["auto_increment_col"]]["orig"],$u["columns"],true)){$ua="";break;}if($u["type"]=="PRIMARY")$ua=" UNIQUE";}}return" AUTO_INCREMENT$ua";}function
alter_table($R,$_,array$m,array$wc,$ab,$Sb,$c,$ta,$Se){$b=array();foreach($m
as$l){if($l[1]){$j=$l[1][3];if(preg_match('~ GENERATED~',$j)){$l[1][3]=(connection()->flavor=='maria'?"":$l[1][2]);$l[1][2]=$j;}$b[]=($R!=""?($l[0]!=""?"CHANGE ".idf_escape($l[0]):"ADD"):" ")." ".implode($l[1]).($R!=""?$l[2]:"");}else$b[]="DROP ".idf_escape($l[0]);}$b=array_merge($b,$wc);$P=($ab!==null?" COMMENT=".q($ab):"").($Sb?" ENGINE=".q($Sb):"").($c?" COLLATE ".q($c):"").($ta!=""?" AUTO_INCREMENT=$ta":"");if($Se){$Te=array();if($Se["partition_by"]=='RANGE'||$Se["partition_by"]=='LIST'){foreach($Se["partition_names"]as$w=>$X){$Y=$Se["partition_values"][$w];$Te[]="\n  PARTITION ".idf_escape($X)." VALUES ".($Se["partition_by"]=='RANGE'?"LESS THAN":"IN").($Y!=""?" ($Y)":" MAXVALUE");}}$P
.="\nPARTITION BY $Se[partition_by]($Se[partition])";if($Te)$P
.=" (".implode(",",$Te)."\n)";elseif($Se["partitions"])$P
.=" PARTITIONS ".(+$Se["partitions"]);}elseif($Se===null)$P
.="\nREMOVE PARTITIONING";if($R=="")return
queries("CREATE TABLE ".table($_)." (\n".implode(",\n",$b)."\n)$P");if($R!=$_)$b[]="RENAME TO ".table($_);if($P)$b[]=ltrim($P);return($b?queries("ALTER TABLE ".table($R)."\n".implode(",\n",$b)):true);}function
alter_indexes($R,$b){$Ka=array();foreach($b
as$X)$Ka[]=($X[2]=="DROP"?"\nDROP INDEX ".idf_escape($X[1]):"\nADD $X[0] ".($X[0]=="PRIMARY"?"KEY ":"").($X[1]!=""?idf_escape($X[1])." ":"")."(".implode(", ",$X[2]).")");return
queries("ALTER TABLE ".table($R).implode(",",$Ka));}function
truncate_tables(array$T){return
apply_queries("TRUNCATE TABLE",$T);}function
drop_views(array$fh){return
queries("DROP VIEW ".implode(", ",array_map('Adminer\table',$fh)));}function
drop_tables(array$T){return
queries("DROP TABLE ".implode(", ",array_map('Adminer\table',$T)));}function
move_tables(array$T,array$fh,$mg){$vf=array();foreach($T
as$R)$vf[]=table($R)." TO ".idf_escape($mg).".".table($R);if(!$vf||queries("RENAME TABLE ".implode(", ",$vf))){$xb=array();foreach($fh
as$R)$xb[table($R)]=view($R);connection()->select_db($mg);$i=idf_escape(DB);foreach($xb
as$_=>$eh){if(!queries("CREATE VIEW $_ AS ".str_replace(" $i."," ",$eh["select"]))||!queries("DROP VIEW $i.$_"))return
false;}return
true;}return
false;}function
copy_tables(array$T,array$fh,$mg){queries("SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO'");foreach($T
as$R){$_=($mg==DB?table("copy_$R"):idf_escape($mg).".".table($R));if(($_POST["overwrite"]&&!queries("\nDROP TABLE IF EXISTS $_"))||!queries("CREATE TABLE $_ LIKE ".table($R))||!queries("INSERT INTO $_ SELECT * FROM ".table($R)))return
false;foreach(get_rows("SHOW TRIGGERS LIKE ".q(addcslashes($R,"%_\\")))as$I){$Gg=$I["Trigger"];if(!queries("CREATE TRIGGER ".($mg==DB?idf_escape("copy_$Gg"):idf_escape($mg).".".idf_escape($Gg))." $I[Timing] $I[Event] ON $_ FOR EACH ROW\n$I[Statement];"))return
false;}}foreach($fh
as$R){$_=($mg==DB?table("copy_$R"):idf_escape($mg).".".table($R));$eh=view($R);if(($_POST["overwrite"]&&!queries("DROP VIEW IF EXISTS $_"))||!queries("CREATE VIEW $_ AS $eh[select]"))return
false;}return
true;}function
trigger($_,$R){if($_=="")return
array();$J=get_rows("SHOW TRIGGERS WHERE `Trigger` = ".q($_));return
reset($J);}function
triggers($R){$H=array();foreach(get_rows("SHOW TRIGGERS LIKE ".q(addcslashes($R,"%_\\")))as$I)$H[$I["Trigger"]]=array($I["Timing"],$I["Event"]);return$H;}function
trigger_options(){return
array("Timing"=>array("BEFORE","AFTER"),"Event"=>array("INSERT","UPDATE","DELETE"),"Type"=>array("FOR EACH ROW"),);}function
routine($_,$U){$ka=array("bool","boolean","integer","double precision","real","dec","numeric","fixed","national char","national varchar");$Wf="(?:\\s|/\\*[\s\S]*?\\*/|(?:#|-- )[^\n]*\n?|--\r?\n)";$Tb=driver()->enumLength;$Kg="((".implode("|",array_merge(array_keys(driver()->types()),$ka)).")\\b(?:\\s*\\(((?:[^'\")]|$Tb)++)\\))?"."\\s*(zerofill\\s*)?(unsigned(?:\\s+zerofill)?)?)(?:\\s*(?:CHARSET|CHARACTER\\s+SET)\\s*['\"]?([^'\"\\s,]+)['\"]?)?";$Ve="$Wf*(".($U=="FUNCTION"?"":driver()->inout).")?\\s*(?:`((?:[^`]|``)*)`\\s*|\\b(\\S+)\\s+)$Kg";$lb=get_val("SHOW CREATE $U ".idf_escape($_),2);preg_match("~\\(((?:$Ve\\s*,?)*)\\)\\s*".($U=="FUNCTION"?"RETURNS\\s+$Kg\\s+":"")."(.*)~is",$lb,$z);$m=array();preg_match_all("~$Ve\\s*,?~is",$z[1],$Td,PREG_SET_ORDER);foreach($Td
as$Ne)$m[]=array("field"=>str_replace("``","`",$Ne[2]).$Ne[3],"type"=>strtolower($Ne[5]),"length"=>preg_replace_callback("~$Tb~s",'Adminer\normalize_enum',$Ne[6]),"unsigned"=>strtolower(preg_replace('~\s+~',' ',trim("$Ne[8] $Ne[7]"))),"null"=>true,"full_type"=>$Ne[4],"inout"=>strtoupper($Ne[1]),"collation"=>strtolower($Ne[9]),);return
array("fields"=>$m,"comment"=>get_val("SELECT ROUTINE_COMMENT FROM information_schema.ROUTINES WHERE ROUTINE_SCHEMA = DATABASE() AND ROUTINE_NAME = ".q($_)),)+($U!="FUNCTION"?array("definition"=>$z[11]):array("returns"=>array("type"=>$z[12],"length"=>$z[13],"unsigned"=>$z[15],"collation"=>$z[16]),"definition"=>$z[17],"language"=>"SQL",));}function
routines(){return
get_rows("SELECT ROUTINE_NAME AS SPECIFIC_NAME, ROUTINE_NAME, ROUTINE_TYPE, DTD_IDENTIFIER FROM information_schema.ROUTINES WHERE ROUTINE_SCHEMA = DATABASE()");}function
routine_languages(){return
array();}function
routine_id($_,array$I){return
idf_escape($_);}function
last_id($G){return
get_val("SELECT LAST_INSERT_ID()");}function
explain(Db$g,$F){return$g->query("EXPLAIN ".(min_version(5.1)&&!min_version(5.7)?"PARTITIONS ":"").$F);}function
found_rows(array$S,array$Z){return($Z||$S["Engine"]!="InnoDB"?null:$S["Rows"]);}function
create_sql($R,$ta,$dg){$H=get_val("SHOW CREATE TABLE ".table($R),1);if(!$ta)$H=preg_replace('~ AUTO_INCREMENT=\d+~','',$H);return$H;}function
truncate_sql($R){return"TRUNCATE ".table($R);}function
use_sql($tb){return"USE ".idf_escape($tb);}function
trigger_sql($R){$H="";foreach(get_rows("SHOW TRIGGERS LIKE ".q(addcslashes($R,"%_\\")),null,"-- ")as$I)$H
.="\nCREATE TRIGGER ".idf_escape($I["Trigger"])." $I[Timing] $I[Event] ON ".table($I["Table"])." FOR EACH ROW\n$I[Statement];;\n";return$H;}function
show_variables(){return
get_rows("SHOW VARIABLES");}function
show_status(){return
get_rows("SHOW STATUS");}function
process_list(){return
get_rows("SHOW FULL PROCESSLIST");}function
convert_field(array$l){if(preg_match("~binary~",$l["type"]))return"HEX(".idf_escape($l["field"]).")";if($l["type"]=="bit")return"BIN(".idf_escape($l["field"])." + 0)";if(preg_match("~geometry|point|linestring|polygon~",$l["type"]))return(min_version(8)?"ST_":"")."AsWKT(".idf_escape($l["field"]).")";}function
unconvert_field(array$l,$H){if(preg_match("~binary~",$l["type"]))$H="UNHEX($H)";if($l["type"]=="bit")$H="CONVERT(b$H, UNSIGNED)";if(preg_match("~geometry|point|linestring|polygon~",$l["type"])){$ef=(min_version(8)?"ST_":"");$H=$ef."GeomFromText($H, $ef"."SRID($l[field]))";}return$H;}function
support($jc){return
preg_match('~^(comment|columns|copy|database|drop_col|dump|indexes|kill|privileges|move_col|procedure|processlist|routine|sql|status|table|trigger|variables|view'.(min_version(5.1)?'|event':'').(min_version(8)?'|descidx':'').(min_version('8.0.16','10.2.1')?'|check':'').')$~',$jc);}function
kill_process($X){return
queries("KILL ".number($X));}function
connection_id(){return"SELECT CONNECTION_ID()";}function
max_connections(){return
get_val("SELECT @@max_connections");}function
types(){return
array();}function
type_values($s){return"";}function
schemas(){return
array();}function
get_schema(){return"";}function
set_schema($Cf,$h=null){return
true;}}define('Adminer\JUSH',Driver::$jush);define('Adminer\SERVER',$_GET[DRIVER]);define('Adminer\DB',$_GET["db"]);define('Adminer\ME',preg_replace('~\?.*~','',relative_uri()).'?'.(sid()?SID.'&':'').(SERVER!==null?DRIVER."=".urlencode(SERVER).'&':'').($_GET["ext"]?"ext=".urlencode($_GET["ext"]).'&':'').(isset($_GET["username"])?"username=".urlencode($_GET["username"]).'&':'').(DB!=""?'db='.urlencode(DB).'&'.(isset($_GET["ns"])?"ns=".urlencode($_GET["ns"])."&":""):''));function
page_header($vg,$k="",$Ga=array(),$wg=""){page_headers();if(is_ajax()&&$k){page_messages($k);exit;}if(!ob_get_level())ob_start('ob_gzhandler',4096);$xg=$vg.($wg!=""?": $wg":"");$yg=strip_tags($xg.(SERVER!=""&&SERVER!="localhost"?h(" - ".SERVER):"")." - ".adminer()->name());echo'<!DOCTYPE html>
<html lang="',LANG,'" dir="',lang(56),'">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="robots" content="noindex">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>',$yg,'</title>
<link rel="stylesheet" href="',h(preg_replace("~\\?.*~","",ME)."?file=default.css&version=5.3.0"),'">
';$pb=adminer()->css();if(is_int(key($pb)))$pb=array_fill_keys($pb,'light');$Oc=in_array('light',$pb)||in_array('',$pb);$Lc=in_array('dark',$pb)||in_array('',$pb);$rb=($Oc?($Lc?null:false):($Lc?:null));$Zd=" media='(prefers-color-scheme: dark)'";if($rb!==false)echo"<link rel='stylesheet'".($rb?"":$Zd)." href='".h(preg_replace("~\\?.*~","",ME)."?file=dark.css&version=5.3.0")."'>\n";echo"<meta name='color-scheme' content='".($rb===null?"light dark":($rb?"dark":"light"))."'>\n",script_src(preg_replace("~\\?.*~","",ME)."?file=functions.js&version=5.3.0");if(adminer()->head($rb))echo"<link rel='icon' href='data:image/gif;base64,R0lGODlhEAAQAJEAAAQCBPz+/PwCBAROZCH5BAEAAAAALAAAAAAQABAAAAI2hI+pGO1rmghihiUdvUBnZ3XBQA7f05mOak1RWXrNq5nQWHMKvuoJ37BhVEEfYxQzHjWQ5qIAADs='>\n","<link rel='apple-touch-icon' href='".h(preg_replace("~\\?.*~","",ME)."?file=logo.png&version=5.3.0")."'>\n";foreach($pb
as$Wg=>$ee){$ra=($ee=='dark'&&!$rb?$Zd:($ee=='light'&&$Lc?" media='(prefers-color-scheme: light)'":""));echo"<link rel='stylesheet'$ra href='".h($Wg)."'>\n";}echo"\n<body class='".lang(56)." nojs";adminer()->bodyClass();echo"'>\n";$n=get_temp_dir()."/adminer.version";if(!$_COOKIE["adminer_version"]&&function_exists('openssl_verify')&&file_exists($n)&&filemtime($n)+86400>time()){$dh=unserialize(file_get_contents($n));$kf="-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAwqWOVuF5uw7/+Z70djoK
RlHIZFZPO0uYRezq90+7Amk+FDNd7KkL5eDve+vHRJBLAszF/7XKXe11xwliIsFs
DFWQlsABVZB3oisKCBEuI71J4kPH8dKGEWR9jDHFw3cWmoH3PmqImX6FISWbG3B8
h7FIx3jEaw5ckVPVTeo5JRm/1DZzJxjyDenXvBQ/6o9DgZKeNDgxwKzH+sw9/YCO
jHnq1cFpOIISzARlrHMa/43YfeNRAm/tsBXjSxembBPo7aQZLAWHmaj5+K19H10B
nCpz9Y++cipkVEiKRGih4ZEvjoFysEOdRLj6WiD/uUNky4xGeA6LaJqh5XpkFkcQ
fQIDAQAB
-----END PUBLIC KEY-----
";if(openssl_verify($dh["version"],base64_decode($dh["signature"]),$kf)==1)$_COOKIE["adminer_version"]=$dh["version"];}echo
script("mixin(document.body, {onkeydown: bodyKeydown, onclick: bodyClick".(isset($_COOKIE["adminer_version"])?"":", onload: partial(verifyVersion, '".VERSION."', '".js_escape(ME)."', '".get_token()."')")."});
document.body.classList.replace('nojs', 'js');
const offlineMessage = '".js_escape(lang(57))."';
const thousandsSeparator = '".js_escape(lang(4))."';"),"<div id='help' class='jush-".JUSH." jsonly hidden'></div>\n",script("mixin(qs('#help'), {onmouseover: () => { helpOpen = 1; }, onmouseout: helpMouseout});"),"<div id='content'>\n","<span id='menuopen' class='jsonly'>".icon("move","","menu","")."</span>".script("qs('#menuopen').onclick = event => { qs('#foot').classList.toggle('foot'); event.stopPropagation(); }");if($Ga!==null){$y=substr(preg_replace('~\b(username|db|ns)=[^&]*&~','',ME),0,-1);echo'<p id="breadcrumb"><a href="'.h($y?:".").'">'.get_driver(DRIVER).'</a> Â» ';$y=substr(preg_replace('~\b(db|ns)=[^&]*&~','',ME),0,-1);$M=adminer()->serverName(SERVER);$M=($M!=""?$M:lang(58));if($Ga===false)echo"$M\n";else{echo"<a href='".h($y)."' accesskey='1' title='Alt+Shift+1'>$M</a> Â» ";if($_GET["ns"]!=""||(DB!=""&&is_array($Ga)))echo'<a href="'.h($y."&db=".urlencode(DB).(support("scheme")?"&ns=":"")).'">'.h(DB).'</a> Â» ';if(is_array($Ga)){if($_GET["ns"]!="")echo'<a href="'.h(substr(ME,0,-1)).'">'.h($_GET["ns"]).'</a> Â» ';foreach($Ga
as$w=>$X){$zb=(is_array($X)?$X[1]:h($X));if($zb!="")echo"<a href='".h(ME."$w=").urlencode(is_array($X)?$X[0]:$X)."'>$zb</a> Â» ";}}echo"$vg\n";}}echo"<h2>$xg</h2>\n","<div id='ajaxstatus' class='jsonly hidden'></div>\n";restart_session();page_messages($k);$ub=&get_session("dbs");if(DB!=""&&$ub&&!in_array(DB,$ub,true))$ub=null;stop_session();define('Adminer\PAGE_HEADER',1);}function
page_headers(){header("Content-Type: text/html; charset=utf-8");header("Cache-Control: no-cache");header("X-Frame-Options: deny");header("X-XSS-Protection: 0");header("X-Content-Type-Options: nosniff");header("Referrer-Policy: origin-when-cross-origin");foreach(adminer()->csp(csp())as$ob){$Qc=array();foreach($ob
as$w=>$X)$Qc[]="$w $X";header("Content-Security-Policy: ".implode("; ",$Qc));}adminer()->headers();}function
csp(){return
array(array("script-src"=>"'self' 'unsafe-inline' 'nonce-".get_nonce()."' 'strict-dynamic'","connect-src"=>"'self'","frame-src"=>"https://www.adminer.org","object-src"=>"'none'","base-uri"=>"'none'","form-action"=>"'self'",),);}function
get_nonce(){static$ne;if(!$ne)$ne=base64_encode(rand_string());return$ne;}function
page_messages($k){$Vg=preg_replace('~^[^?]*~','',$_SERVER["REQUEST_URI"]);$be=idx($_SESSION["messages"],$Vg);if($be){echo"<div class='message'>".implode("</div>\n<div class='message'>",$be)."</div>".script("messagesPrint();");unset($_SESSION["messages"][$Vg]);}if($k)echo"<div class='error'>$k</div>\n";if(adminer()->error)echo"<div class='error'>".adminer()->error."</div>\n";}function
page_footer($de=""){echo"</div>\n\n<div id='foot' class='foot'>\n<div id='menu'>\n";adminer()->navigation($de);echo"</div>\n";if($de!="auth")echo'<form action="" method="post">
<p class="logout">
<span>',h($_GET["username"])."\n",'</span>
<input type="submit" name="logout" value="',lang(59),'" id="logout">
',input_token(),'</form>
';echo"</div>\n\n",script("setupSubmitHighlight(document);");}function
int32($ie){while($ie>=2147483648)$ie-=4294967296;while($ie<=-2147483649)$ie+=4294967296;return(int)$ie;}function
long2str(array$W,$hh){$Bf='';foreach($W
as$X)$Bf
.=pack('V',$X);if($hh)return
substr($Bf,0,end($W));return$Bf;}function
str2long($Bf,$hh){$W=array_values(unpack('V*',str_pad($Bf,4*ceil(strlen($Bf)/4),"\0")));if($hh)$W[]=strlen($Bf);return$W;}function
xxtea_mx($mh,$lh,$gg,$yd){return
int32((($mh>>5&0x7FFFFFF)^$lh<<2)+(($lh>>3&0x1FFFFFFF)^$mh<<4))^int32(($gg^$lh)+($yd^$mh));}function
encrypt_string($cg,$w){if($cg=="")return"";$w=array_values(unpack("V*",pack("H*",md5($w))));$W=str2long($cg,true);$ie=count($W)-1;$mh=$W[$ie];$lh=$W[0];$lf=floor(6+52/($ie+1));$gg=0;while($lf-->0){$gg=int32($gg+0x9E3779B9);$Kb=$gg>>2&3;for($Le=0;$Le<$ie;$Le++){$lh=$W[$Le+1];$he=xxtea_mx($mh,$lh,$gg,$w[$Le&3^$Kb]);$mh=int32($W[$Le]+$he);$W[$Le]=$mh;}$lh=$W[0];$he=xxtea_mx($mh,$lh,$gg,$w[$Le&3^$Kb]);$mh=int32($W[$ie]+$he);$W[$ie]=$mh;}return
long2str($W,false);}function
decrypt_string($cg,$w){if($cg=="")return"";if(!$w)return
false;$w=array_values(unpack("V*",pack("H*",md5($w))));$W=str2long($cg,false);$ie=count($W)-1;$mh=$W[$ie];$lh=$W[0];$lf=floor(6+52/($ie+1));$gg=int32($lf*0x9E3779B9);while($gg){$Kb=$gg>>2&3;for($Le=$ie;$Le>0;$Le--){$mh=$W[$Le-1];$he=xxtea_mx($mh,$lh,$gg,$w[$Le&3^$Kb]);$lh=int32($W[$Le]-$he);$W[$Le]=$lh;}$mh=$W[$ie];$he=xxtea_mx($mh,$lh,$gg,$w[$Le&3^$Kb]);$lh=int32($W[0]-$he);$W[0]=$lh;$gg=int32($gg-0x9E3779B9);}return
long2str($W,true);}$Xe=array();if($_COOKIE["adminer_permanent"]){foreach(explode(" ",$_COOKIE["adminer_permanent"])as$X){list($w)=explode(":",$X);$Xe[$w]=$X;}}function
add_invalid_login(){$_a=get_temp_dir()."/adminer.invalid";foreach(glob("$_a*")?:array($_a)as$n){$p=file_open_lock($n);if($p)break;}if(!$p)$p=file_open_lock("$_a-".rand_string());if(!$p)return;$rd=unserialize(stream_get_contents($p));$sg=time();if($rd){foreach($rd
as$sd=>$X){if($X[0]<$sg)unset($rd[$sd]);}}$qd=&$rd[adminer()->bruteForceKey()];if(!$qd)$qd=array($sg+30*60,0);$qd[1]++;file_write_unlock($p,serialize($rd));}function
check_invalid_login(array&$Xe){$rd=array();foreach(glob(get_temp_dir()."/adminer.invalid*")as$n){$p=file_open_lock($n);if($p){$rd=unserialize(stream_get_contents($p));file_unlock($p);break;}}$qd=idx($rd,adminer()->bruteForceKey(),array());$me=($qd[1]>29?$qd[0]-time():0);if($me>0)auth_error(lang(60,ceil($me/60)),$Xe);}$sa=$_POST["auth"];if($sa){session_regenerate_id();$ch=$sa["driver"];$M=$sa["server"];$V=$sa["username"];$D=(string)$sa["password"];$i=$sa["db"];set_password($ch,$M,$V,$D);$_SESSION["db"][$ch][$M][$V][$i]=true;if($sa["permanent"]){$w=implode("-",array_map('base64_encode',array($ch,$M,$V,$i)));$if=adminer()->permanentLogin(true);$Xe[$w]="$w:".base64_encode($if?encrypt_string($D,$if):"");cookie("adminer_permanent",implode(" ",$Xe));}if(count($_POST)==1||DRIVER!=$ch||SERVER!=$M||$_GET["username"]!==$V||DB!=$i)redirect(auth_url($ch,$M,$V,$i));}elseif($_POST["logout"]&&(!$_SESSION["token"]||verify_token())){foreach(array("pwds","db","dbs","queries")as$w)set_session($w,null);unset_permanent($Xe);redirect(substr(preg_replace('~\b(username|db|ns)=[^&]*&~','',ME),0,-1),lang(61).' '.lang(62));}elseif($Xe&&!$_SESSION["pwds"]){session_regenerate_id();$if=adminer()->permanentLogin();foreach($Xe
as$w=>$X){list(,$Qa)=explode(":",$X);list($ch,$M,$V,$i)=array_map('base64_decode',explode("-",$w));set_password($ch,$M,$V,decrypt_string(base64_decode($Qa),$if));$_SESSION["db"][$ch][$M][$V][$i]=true;}}function
unset_permanent(array&$Xe){foreach($Xe
as$w=>$X){list($ch,$M,$V,$i)=array_map('base64_decode',explode("-",$w));if($ch==DRIVER&&$M==SERVER&&$V==$_GET["username"]&&$i==DB)unset($Xe[$w]);}cookie("adminer_permanent",implode(" ",$Xe));}function
auth_error($k,array&$Xe){$Pf=session_name();if(isset($_GET["username"])){header("HTTP/1.1 403 Forbidden");if(($_COOKIE[$Pf]||$_GET[$Pf])&&!$_SESSION["token"])$k=lang(63);else{restart_session();add_invalid_login();$D=get_password();if($D!==null){if($D===false)$k
.=($k?'<br>':'').lang(64,target_blank(),'<code>permanentLogin()</code>');set_password(DRIVER,SERVER,$_GET["username"],null);}unset_permanent($Xe);}}if(!$_COOKIE[$Pf]&&$_GET[$Pf]&&ini_bool("session.use_only_cookies"))$k=lang(65);$Oe=session_get_cookie_params();cookie("adminer_key",($_COOKIE["adminer_key"]?:rand_string()),$Oe["lifetime"]);if(!$_SESSION["token"])$_SESSION["token"]=rand(1,1e6);page_header(lang(35),$k,null);echo"<form action='' method='post'>\n","<div>";if(hidden_fields($_POST,array("auth")))echo"<p class='message'>".lang(66)."\n";echo"</div>\n";adminer()->loginForm();echo"</form>\n";page_footer("auth");exit;}if(isset($_GET["username"])&&!class_exists('Adminer\Db')){unset($_SESSION["pwds"][DRIVER]);unset_permanent($Xe);page_header(lang(67),lang(68,implode(", ",Driver::$extensions)),false);page_footer("auth");exit;}$g='';if(isset($_GET["username"])&&is_string(get_password())){list($Wc,$af)=explode(":",SERVER,2);if(preg_match('~^\s*([-+]?\d+)~',$af,$z)&&($z[1]<1024||$z[1]>65535))auth_error(lang(69),$Xe);check_invalid_login($Xe);$nb=adminer()->credentials();$g=Driver::connect($nb[0],$nb[1],$nb[2]);if(is_object($g)){Db::$instance=$g;Driver::$instance=new
Driver($g);if($g->flavor)save_settings(array("vendor-".DRIVER."-".SERVER=>get_driver(DRIVER)));}}$Nd=null;if(!is_object($g)||($Nd=adminer()->login($_GET["username"],get_password()))!==true){$k=(is_string($g)?nl_br(h($g)):(is_string($Nd)?$Nd:lang(70))).(preg_match('~^ | $~',get_password())?'<br>'.lang(71):'');auth_error($k,$Xe);}if($_POST["logout"]&&$_SESSION["token"]&&!verify_token()){page_header(lang(59),lang(72));page_footer("db");exit;}if(!$_SESSION["token"])$_SESSION["token"]=rand(1,1e6);stop_session(true);if($sa&&$_POST["token"])$_POST["token"]=get_token();$k='';if($_POST){if(!verify_token()){$kd="max_input_vars";$Xd=ini_get($kd);if(extension_loaded("suhosin")){foreach(array("suhosin.request.max_vars","suhosin.post.max_vars")as$w){$X=ini_get($w);if($X&&(!$Xd||$X<$Xd)){$kd=$w;$Xd=$X;}}}$k=(!$_POST["token"]&&$Xd?lang(73,"'$kd'"):lang(72).' '.lang(74));}}elseif($_SERVER["REQUEST_METHOD"]=="POST"){$k=lang(75,"'post_max_size'");if(isset($_GET["sql"]))$k
.=' '.lang(76);}function
doc_link(array$Ue,$og=""){return"";}function
email_header($Qc){return"=?UTF-8?B?".base64_encode($Qc)."?=";}function
send_mail($Ob,$eg,$ae,$Bc="",array$nc=array()){$Wb=PHP_EOL;$ae=str_replace("\n",$Wb,wordwrap(str_replace("\r","","$ae\n")));$Fa=uniqid("boundary");$qa="";foreach((array)$nc["error"]as$w=>$X){if(!$X)$qa
.="--$Fa$Wb"."Content-Type: ".str_replace("\n","",$nc["type"][$w]).$Wb."Content-Disposition: attachment; filename=\"".preg_replace('~["\n]~','',$nc["name"][$w])."\"$Wb"."Content-Transfer-Encoding: base64$Wb$Wb".chunk_split(base64_encode(file_get_contents($nc["tmp_name"][$w])),76,$Wb).$Wb;}$Ba="";$Rc="Content-Type: text/plain; charset=utf-8$Wb"."Content-Transfer-Encoding: 8bit";if($qa){$qa
.="--$Fa--$Wb";$Ba="--$Fa$Wb$Rc$Wb$Wb";$Rc="Content-Type: multipart/mixed; boundary=\"$Fa\"";}$Rc
.=$Wb."MIME-Version: 1.0$Wb"."X-Mailer: Adminer Editor".($Bc?$Wb."From: ".str_replace("\n","",$Bc):"");return
mail($Ob,email_header($eg),$Ba.$ae.$qa,$Rc);}function
like_bool(array$l){return
preg_match("~bool|(tinyint|bit)\\(1\\)~",$l["full_type"]);}connection()->select_db(adminer()->database());add_driver(DRIVER,lang(35));if(isset($_GET["select"])&&($_POST["edit"]||$_POST["clone"])&&!$_POST["save"])$_GET["edit"]=$_GET["select"];if(isset($_GET["download"])){$a=$_GET["download"];$m=fields($a);header("Content-Type: application/octet-stream");header("Content-Disposition: attachment; filename=".friendly_url("$a-".implode("_",$_GET["where"])).".".friendly_url($_GET["field"]));$K=array(idf_escape($_GET["field"]));$G=driver()->select($a,$K,array(where($_GET,$m)),$K);$I=($G?$G->fetch_row():array());echo
driver()->value($I[0],$m[$_GET["field"]]);exit;}elseif(isset($_GET["edit"])){$a=$_GET["edit"];$m=fields($a);$Z=(isset($_GET["select"])?($_POST["check"]&&count($_POST["check"])==1?where_check($_POST["check"][0],$m):""):where($_GET,$m));$Ug=(isset($_GET["select"])?$_POST["edit"]:$Z);foreach($m
as$_=>$l){if(!isset($l["privileges"][$Ug?"update":"insert"])||adminer()->fieldName($l)==""||$l["generated"])unset($m[$_]);}if($_POST&&!$k&&!isset($_GET["select"])){$Md=$_POST["referer"];if($_POST["insert"])$Md=($Ug?null:$_SERVER["REQUEST_URI"]);elseif(!preg_match('~^.+&select=.+$~',$Md))$Md=ME."select=".urlencode($a);$v=indexes($a);$Pg=unique_array($_GET["where"],$v);$of="\nWHERE $Z";if(isset($_POST["delete"]))queries_redirect($Md,lang(77),driver()->delete($a,$of,$Pg?0:1));else{$N=array();foreach($m
as$_=>$l){$X=process_input($l);if($X!==false&&$X!==null)$N[idf_escape($_)]=$X;}if($Ug){if(!$N)redirect($Md);queries_redirect($Md,lang(78),driver()->update($a,$N,$of,$Pg?0:1));if(is_ajax()){page_headers();page_messages($k);exit;}}else{$G=driver()->insert($a,$N);$Gd=($G?last_id($G):0);queries_redirect($Md,lang(79,($Gd?" $Gd":"")),$G);}}}$I=null;if($_POST["save"])$I=(array)$_POST["fields"];elseif($Z){$K=array();foreach($m
as$_=>$l){if(isset($l["privileges"]["select"])){$oa=($_POST["clone"]&&$l["auto_increment"]?"''":convert_field($l));$K[]=($oa?"$oa AS ":"").idf_escape($_);}}$I=array();if(!support("table"))$K=array("*");if($K){$G=driver()->select($a,$K,array($Z),$K,array(),(isset($_GET["select"])?2:1));if(!$G)$k=error();else{$I=$G->fetch_assoc();if(!$I)$I=false;}if(isset($_GET["select"])&&(!$I||$G->fetch_assoc()))$I=null;}}if(!support("table")&&!$m){if(!$Z){$G=driver()->select($a,array("*"),array(),array("*"));$I=($G?$G->fetch_assoc():false);if(!$I)$I=array(driver()->primary=>"");}if($I){foreach($I
as$w=>$X){if(!$Z)$I[$w]=null;$m[$w]=array("field"=>$w,"null"=>($w!=driver()->primary),"auto_increment"=>($w==driver()->primary));}}}edit_form($a,$m,$I,$Ug,$k);}elseif(isset($_GET["select"])){$a=$_GET["select"];$S=table_status1($a);$v=indexes($a);$m=fields($a);$zc=column_foreign_keys($a);$se=$S["Oid"];$ha=get_settings("adminer_import");$_f=array();$e=array();$Ff=array();$De=array();$qg="";foreach($m
as$w=>$l){$_=adminer()->fieldName($l);$je=html_entity_decode(strip_tags($_),ENT_QUOTES);if(isset($l["privileges"]["select"])&&$_!=""){$e[$w]=$je;if(is_shortable($l))$qg=adminer()->selectLengthProcess();}if(isset($l["privileges"]["where"])&&$_!="")$Ff[$w]=$je;if(isset($l["privileges"]["order"])&&$_!="")$De[$w]=$je;$_f+=$l["privileges"];}list($K,$Gc)=adminer()->selectColumnsProcess($e,$v);$K=array_unique($K);$Gc=array_unique($Gc);$td=count($Gc)<count($K);$Z=adminer()->selectSearchProcess($m,$v);$Ce=adminer()->selectOrderProcess($m,$v);$x=adminer()->selectLimitProcess();if($_GET["val"]&&is_ajax()){header("Content-Type: text/plain; charset=utf-8");foreach($_GET["val"]as$Qg=>$I){$oa=convert_field($m[key($I)]);$K=array($oa?:idf_escape(key($I)));$Z[]=where_check($Qg,$m);$H=driver()->select($a,$K,$Z,$K);if($H)echo
first($H->fetch_row());}exit;}$E=$Sg=array();foreach($v
as$u){if($u["type"]=="PRIMARY"){$E=array_flip($u["columns"]);$Sg=($K?$E:array());foreach($Sg
as$w=>$X){if(in_array(idf_escape($w),$K))unset($Sg[$w]);}break;}}if($se&&!$E){$E=$Sg=array($se=>0);$v[]=array("type"=>"PRIMARY","columns"=>array($se));}if($_POST&&!$k){$jh=$Z;if(!$_POST["all"]&&is_array($_POST["check"])){$Pa=array();foreach($_POST["check"]as$Ma)$Pa[]=where_check($Ma,$m);$jh[]="((".implode(") OR (",$Pa)."))";}$jh=($jh?"\nWHERE ".implode(" AND ",$jh):"");if($_POST["export"]){save_settings(array("output"=>$_POST["output"],"format"=>$_POST["format"]),"adminer_import");dump_headers($a);adminer()->dumpTable($a,"");$Bc=($K?implode(", ",$K):"*").convert_fields($e,$m,$K)."\nFROM ".table($a);$Ic=($Gc&&$td?"\nGROUP BY ".implode(", ",$Gc):"").($Ce?"\nORDER BY ".implode(", ",$Ce):"");$F="SELECT $Bc$jh$Ic";if(is_array($_POST["check"])&&!$E){$Og=array();foreach($_POST["check"]as$X)$Og[]="(SELECT".limit($Bc,"\nWHERE ".($Z?implode(" AND ",$Z)." AND ":"").where_check($X,$m).$Ic,1).")";$F=implode(" UNION ALL ",$Og);}adminer()->dumpData($a,"table",$F);adminer()->dumpFooter();exit;}if(!adminer()->selectEmailProcess($Z,$zc)){if($_POST["save"]||$_POST["delete"]){$G=true;$ia=0;$N=array();if(!$_POST["delete"]){foreach($_POST["fields"]as$_=>$X){$X=process_input($m[$_]);if($X!==null&&($_POST["clone"]||$X!==false))$N[idf_escape($_)]=($X!==false?$X:idf_escape($_));}}if($_POST["delete"]||$N){$F=($_POST["clone"]?"INTO ".table($a)." (".implode(", ",array_keys($N)).")\nSELECT ".implode(", ",$N)."\nFROM ".table($a):"");if($_POST["all"]||($E&&is_array($_POST["check"]))||$td){$G=($_POST["delete"]?driver()->delete($a,$jh):($_POST["clone"]?queries("INSERT $F$jh".driver()->insertReturning($a)):driver()->update($a,$N,$jh)));$ia=connection()->affected_rows;if(is_object($G))$ia+=$G->num_rows;}else{foreach((array)$_POST["check"]as$X){$ih="\nWHERE ".($Z?implode(" AND ",$Z)." AND ":"").where_check($X,$m);$G=($_POST["delete"]?driver()->delete($a,$ih,1):($_POST["clone"]?queries("INSERT".limit1($a,$F,$ih)):driver()->update($a,$N,$ih,1)));if(!$G)break;$ia+=connection()->affected_rows;}}}$ae=lang(80,$ia);if($_POST["clone"]&&$G&&$ia==1){$Gd=last_id($G);if($Gd)$ae=lang(79," $Gd");}queries_redirect(remove_from_uri($_POST["all"]&&$_POST["delete"]?"page":""),$ae,$G);if(!$_POST["delete"]){$cf=(array)$_POST["fields"];edit_form($a,array_intersect_key($m,$cf),$cf,!$_POST["clone"],$k);page_footer();exit;}}elseif(!$_POST["import"]){if(!$_POST["val"])$k=lang(81);else{$G=true;$ia=0;foreach($_POST["val"]as$Qg=>$I){$N=array();foreach($I
as$w=>$X){$w=bracket_escape($w,true);$N[idf_escape($w)]=(preg_match('~char|text~',$m[$w]["type"])||$X!=""?adminer()->processInput($m[$w],$X):"NULL");}$G=driver()->update($a,$N," WHERE ".($Z?implode(" AND ",$Z)." AND ":"").where_check($Qg,$m),($td||$E?0:1)," ");if(!$G)break;$ia+=connection()->affected_rows;}queries_redirect(remove_from_uri(),lang(80,$ia),$G);}}elseif(!is_string($mc=get_file("csv_file",true)))$k=upload_error($mc);elseif(!preg_match('~~u',$mc))$k=lang(82);else{save_settings(array("output"=>$ha["output"],"format"=>$_POST["separator"]),"adminer_import");$G=true;$Xa=array_keys($m);preg_match_all('~(?>"[^"]*"|[^"\r\n]+)+~',$mc,$Td);$ia=count($Td[0]);driver()->begin();$L=($_POST["separator"]=="csv"?",":($_POST["separator"]=="tsv"?"\t":";"));$J=array();foreach($Td[0]as$w=>$X){preg_match_all("~((?>\"[^\"]*\")+|[^$L]*)$L~",$X.$L,$Ud);if(!$w&&!array_diff($Ud[1],$Xa)){$Xa=$Ud[1];$ia--;}else{$N=array();foreach($Ud[1]as$r=>$Va)$N[idf_escape($Xa[$r])]=($Va==""&&$m[$Xa[$r]]["null"]?"NULL":q(preg_match('~^".*"$~s',$Va)?str_replace('""','"',substr($Va,1,-1)):$Va));$J[]=$N;}}$G=(!$J||driver()->insertUpdate($a,$J,$E));if($G)driver()->commit();queries_redirect(remove_from_uri("page"),lang(83,$ia),$G);driver()->rollback();}}}$kg=adminer()->tableName($S);if(is_ajax()){page_headers();ob_start();}else
page_header(lang(47).": $kg",$k);$N=null;if(isset($_f["insert"])||!support("table")){$Oe=array();foreach((array)$_GET["where"]as$X){if(isset($zc[$X["col"]])&&count($zc[$X["col"]])==1&&($X["op"]=="="||(!$X["op"]&&(is_array($X["val"])||!preg_match('~[_%]~',$X["val"])))))$Oe["set"."[".bracket_escape($X["col"])."]"]=$X["val"];}$N=$Oe?"&".http_build_query($Oe):"";}adminer()->selectLinks($S,$N);if(!$e&&support("table"))echo"<p class='error'>".lang(84).($m?".":": ".error())."\n";else{echo"<form action='' id='form'>\n","<div style='display: none;'>";hidden_fields_get();echo(DB!=""?input_hidden("db",DB).(isset($_GET["ns"])?input_hidden("ns",$_GET["ns"]):""):""),input_hidden("select",$a),"</div>\n";adminer()->selectColumnsPrint($K,$e);adminer()->selectSearchPrint($Z,$Ff,$v);adminer()->selectOrderPrint($Ce,$De,$v);adminer()->selectLimitPrint($x);adminer()->selectLengthPrint($qg);adminer()->selectActionPrint($v);echo"</form>\n";$C=$_GET["page"];$Ac=null;if($C=="last"){$Ac=get_val(count_rows($a,$Z,$td,$Gc));$C=floor(max(0,intval($Ac)-1)/$x);}$Gf=$K;$Hc=$Gc;if(!$Gf){$Gf[]="*";$jb=convert_fields($e,$m,$K);if($jb)$Gf[]=substr($jb,2);}foreach($K
as$w=>$X){$l=$m[idf_unescape($X)];if($l&&($oa=convert_field($l)))$Gf[$w]="$oa AS $X";}if(!$td&&$Sg){foreach($Sg
as$w=>$X){$Gf[]=idf_escape($w);if($Hc)$Hc[]=idf_escape($w);}}$G=driver()->select($a,$Gf,$Z,$Hc,$Ce,$x,$C,true);if(!$G)echo"<p class='error'>".error()."\n";else{if(JUSH=="mssql"&&$C)$G->seek($x*$C);$Qb=array();echo"<form action='' method='post' enctype='multipart/form-data'>\n";$J=array();while($I=$G->fetch_assoc()){if($C&&JUSH=="oracle")unset($I["RNUM"]);$J[]=$I;}if($_GET["page"]!="last"&&$x&&$Gc&&$td&&JUSH=="sql")$Ac=get_val(" SELECT FOUND_ROWS()");if(!$J)echo"<p class='message'>".lang(12)."\n";else{$za=adminer()->backwardKeys($a,$kg);echo"<div class='scrollable'>","<table id='table' class='nowrap checkable odds'>",script("mixin(qs('#table'), {onclick: tableClick, ondblclick: partialArg(tableClick, true), onkeydown: editingKeydown});"),"<thead><tr>".(!$Gc&&$K?"":"<td><input type='checkbox' id='all-page' class='jsonly'>".script("qs('#all-page').onclick = partial(formCheck, /check/);","")." <a href='".h($_GET["modify"]?remove_from_uri("modify"):$_SERVER["REQUEST_URI"]."&modify=1")."'>".lang(85)."</a>");$ke=array();$Dc=array();reset($K);$qf=1;foreach($J[0]as$w=>$X){if(!isset($Sg[$w])){$X=idx($_GET["columns"],key($K))?:array();$l=$m[$K?($X?$X["col"]:current($K)):$w];$_=($l?adminer()->fieldName($l,$qf):($X["fun"]?"*":h($w)));if($_!=""){$qf++;$ke[$w]=$_;$d=idf_escape($w);$Xc=remove_from_uri('(order|desc)[^=]*|page').'&order%5B0%5D='.urlencode($w);$zb="&desc%5B0%5D=1";echo"<th id='th[".h(bracket_escape($w))."]'>".script("mixin(qsl('th'), {onmouseover: partial(columnMouse), onmouseout: partial(columnMouse, ' hidden')});","");$Cc=apply_sql_function($X["fun"],$_);$Uf=isset($l["privileges"]["order"])||$Cc;echo($Uf?"<a href='".h($Xc.($Ce[0]==$d||$Ce[0]==$w||(!$Ce&&$td&&$Gc[0]==$d)?$zb:''))."'>$Cc</a>":$Cc),"<span class='column hidden'>";if($Uf)echo"<a href='".h($Xc.$zb)."' title='".lang(86)."' class='text'> â†“</a>";if(!$X["fun"]&&isset($l["privileges"]["where"]))echo'<a href="#fieldset-search" title="'.lang(42).'" class="text jsonly"> =</a>',script("qsl('a').onclick = partial(selectSearch, '".js_escape($w)."');");echo"</span>";}$Dc[$w]=$X["fun"];next($K);}}$Jd=array();if($_GET["modify"]){foreach($J
as$I){foreach($I
as$w=>$X)$Jd[$w]=max($Jd[$w],min(40,strlen(utf8_decode($X))));}}echo($za?"<th>".lang(87):"")."</thead>\n";if(is_ajax())ob_end_clean();foreach(adminer()->rowDescriptions($J,$zc)as$ie=>$I){$Pg=unique_array($J[$ie],$v);if(!$Pg){$Pg=array();reset($K);foreach($J[$ie]as$w=>$X){if(!preg_match('~^(COUNT|AVG|GROUP_CONCAT|MAX|MIN|SUM)\(~',current($K)))$Pg[$w]=$X;next($K);}}$Qg="";foreach($Pg
as$w=>$X){$l=(array)$m[$w];if((JUSH=="sql"||JUSH=="pgsql")&&preg_match('~char|text|enum|set~',$l["type"])&&strlen($X)>64){$w=(strpos($w,'(')?$w:idf_escape($w));$w="MD5(".(JUSH!='sql'||preg_match("~^utf8~",$l["collation"])?$w:"CONVERT($w USING ".charset(connection()).")").")";$X=md5($X);}$Qg
.="&".($X!==null?urlencode("where[".bracket_escape($w)."]")."=".urlencode($X===false?"f":$X):"null%5B%5D=".urlencode($w));}echo"<tr>".(!$Gc&&$K?"":"<td>".checkbox("check[]",substr($Qg,1),in_array(substr($Qg,1),(array)$_POST["check"])).($td||information_schema(DB)?"":" <a href='".h(ME."edit=".urlencode($a).$Qg)."' class='edit'>".lang(88)."</a>"));reset($K);foreach($I
as$w=>$X){if(isset($ke[$w])){$d=current($K);$l=(array)$m[$w];$X=driver()->value($X,$l);if($X!=""&&(!isset($Qb[$w])||$Qb[$w]!=""))$Qb[$w]=(is_mail($X)?$ke[$w]:"");$y="";if(preg_match('~blob|bytea|raw|file~',$l["type"])&&$X!="")$y=ME.'download='.urlencode($a).'&field='.urlencode($w).$Qg;if(!$y&&$X!==null){foreach((array)$zc[$w]as$o){if(count($zc[$w])==1||end($o["source"])==$w){$y="";foreach($o["source"]as$r=>$Vf)$y
.=where_link($r,$o["target"][$r],$J[$ie][$Vf]);$y=($o["db"]!=""?preg_replace('~([?&]db=)[^&]+~','\1'.urlencode($o["db"]),ME):ME).'select='.urlencode($o["table"]).$y;if($o["ns"])$y=preg_replace('~([?&]ns=)[^&]+~','\1'.urlencode($o["ns"]),$y);if(count($o["source"])==1)break;}}}if($d=="COUNT(*)"){$y=ME."select=".urlencode($a);$r=0;foreach((array)$_GET["where"]as$W){if(!array_key_exists($W["col"],$Pg))$y
.=where_link($r++,$W["col"],$W["val"],$W["op"]);}foreach($Pg
as$yd=>$W)$y
.=where_link($r++,$yd,$W);}$Yc=select_value($X,$y,$l,$qg);$s=h("val[$Qg][".bracket_escape($w)."]");$df=idx(idx($_POST["val"],$Qg),bracket_escape($w));$Mb=!is_array($I[$w])&&is_utf8($Yc)&&$J[$ie][$w]==$I[$w]&&!$Dc[$w]&&!$l["generated"];$U=(preg_match('~^(AVG|MIN|MAX)\((.+)\)~',$d,$z)?$m[idf_unescape($z[2])]["type"]:$l["type"]);$og=preg_match('~text|json|lob~',$U);$ud=preg_match(number_type(),$U)||preg_match('~^(CHAR_LENGTH|ROUND|FLOOR|CEIL|TIME_TO_SEC|COUNT|SUM)\(~',$d);echo"<td id='$s'".($ud&&($X===null||is_numeric(strip_tags($Yc))||$U=="money")?" class='number'":"");if(($_GET["modify"]&&$Mb&&$X!==null)||$df!==null){$Kc=h($df!==null?$df:$I[$w]);echo">".($og?"<textarea name='$s' cols='30' rows='".(substr_count($I[$w],"\n")+1)."'>$Kc</textarea>":"<input name='$s' value='$Kc' size='$Jd[$w]'>");}else{$Od=strpos($Yc,"<i>â€¦</i>");echo" data-text='".($Od?2:($og?1:0))."'".($Mb?"":" data-warning='".h(lang(89))."'").">$Yc";}}next($K);}if($za)echo"<td>";adminer()->backwardKeysPrint($za,$J[$ie]);echo"</tr>\n";}if(is_ajax())exit;echo"</table>\n","</div>\n";}if(!is_ajax()){if($J||$C){$bc=true;if($_GET["page"]!="last"){if(!$x||(count($J)<$x&&($J||!$C)))$Ac=($C?$C*$x:0)+count($J);elseif(JUSH!="sql"||!$td){$Ac=($td?false:found_rows($S,$Z));if(intval($Ac)<max(1e4,2*($C+1)*$x))$Ac=first(slow_query(count_rows($a,$Z,$td,$Gc)));else$bc=false;}}$Me=($x&&($Ac===false||$Ac>$x||$C));if($Me)echo(($Ac===false?count($J)+1:$Ac-$C*$x)>$x?'<p><a href="'.h(remove_from_uri("page")."&page=".($C+1)).'" class="loadmore">'.lang(90).'</a>'.script("qsl('a').onclick = partial(selectLoadMore, $x, '".lang(91)."â€¦');",""):''),"\n";echo"<div class='footer'><div>\n";if($Me){$Vd=($Ac===false?$C+(count($J)>=$x?2:1):floor(($Ac-1)/$x));echo"<fieldset>";if(JUSH!="simpledb"){echo"<legend><a href='".h(remove_from_uri("page"))."'>".lang(92)."</a></legend>",script("qsl('a').onclick = function () { pageClick(this.href, +prompt('".lang(92)."', '".($C+1)."')); return false; };"),pagination(0,$C).($C>5?" â€¦":"");for($r=max(1,$C-4);$r<min($Vd,$C+5);$r++)echo
pagination($r,$C);if($Vd>0)echo($C+5<$Vd?" â€¦":""),($bc&&$Ac!==false?pagination($Vd,$C):" <a href='".h(remove_from_uri("page")."&page=last")."' title='~$Vd'>".lang(93)."</a>");}else
echo"<legend>".lang(92)."</legend>",pagination(0,$C).($C>1?" â€¦":""),($C?pagination($C,$C):""),($Vd>$C?pagination($C+1,$C).($Vd>$C+1?" â€¦":""):"");echo"</fieldset>\n";}echo"<fieldset>","<legend>".lang(94)."</legend>";$Db=($bc?"":"~ ").$Ac;$xe="const checked = formChecked(this, /check/); selectCount('selected', this.checked ? '$Db' : checked); selectCount('selected2', this.checked || !checked ? '$Db' : checked);";echo
checkbox("all",1,0,($Ac!==false?($bc?"":"~ ").lang(95,$Ac):""),$xe)."\n","</fieldset>\n";if(adminer()->selectCommandPrint())echo'<fieldset',($_GET["modify"]?'':' class="jsonly"'),'><legend>',lang(85),'</legend><div>
<input type="submit" value="',lang(14),'"',($_GET["modify"]?'':' title="'.lang(81).'"'),'>
</div></fieldset>
<fieldset><legend>',lang(96),' <span id="selected"></span></legend><div>
<input type="submit" name="edit" value="',lang(10),'">
<input type="submit" name="clone" value="',lang(97),'">
<input type="submit" name="delete" value="',lang(18),'">',confirm(),'</div></fieldset>
';$_c=adminer()->dumpFormat();foreach((array)$_GET["columns"]as$d){if($d["fun"]){unset($_c['sql']);break;}}if($_c){print_fieldset("export",lang(98)." <span id='selected2'></span>");$Je=adminer()->dumpOutput();echo($Je?html_select("output",$Je,$ha["output"])." ":""),html_select("format",$_c,$ha["format"])," <input type='submit' name='export' value='".lang(98)."'>\n","</div></fieldset>\n";}adminer()->selectEmailPrint(array_filter($Qb,'strlen'),$e);echo"</div></div>\n";}if(adminer()->selectImportPrint())echo"<p>","<a href='#import'>".lang(99)."</a>",script("qsl('a').onclick = partial(toggle, 'import');",""),"<span id='import'".($_POST["import"]?"":" class='hidden'").">: ","<input type='file' name='csv_file'> ",html_select("separator",array("csv"=>"CSV,","csv;"=>"CSV;","tsv"=>"TSV"),$ha["format"])," <input type='submit' name='import' value='".lang(99)."'>","</span>";echo
input_token(),"</form>\n",(!$Gc&&$K?"":script("tableCheck();"));}}}if(is_ajax()){ob_end_clean();exit;}}elseif(isset($_GET["script"])){if($_GET["script"]=="kill")connection()->query("KILL ".number($_POST["kill"]));elseif(list($R,$s,$_)=adminer()->_foreignColumn(column_foreign_keys($_GET["source"]),$_GET["field"])){$x=11;$G=connection()->query("SELECT $s, $_ FROM ".table($R)." WHERE ".(preg_match('~^[0-9]+$~',$_GET["value"])?"$s = $_GET[value] OR ":"")."$_ LIKE ".q("$_GET[value]%")." ORDER BY 2 LIMIT $x");for($r=1;($I=$G->fetch_row())&&$r<$x;$r++)echo"<a href='".h(ME."edit=".urlencode($R)."&where".urlencode("[".bracket_escape(idf_unescape($s))."]")."=".urlencode($I[0]))."'>".h($I[1])."</a><br>\n";if($I)echo"...\n";}exit;}else{page_header(lang(58),"",false);if(adminer()->homepage()){echo"<form action='' method='post'>\n","<p>".lang(100).": <input type='search' name='query' value='".h($_POST["query"])."'> <input type='submit' value='".lang(42)."'>\n";if($_POST["query"]!="")search_tables();echo"<div class='scrollable'>\n","<table class='nowrap checkable odds'>\n",script("mixin(qsl('table'), {onclick: tableClick, ondblclick: partialArg(tableClick, true)});"),'<thead><tr class="wrap">','<td><input id="check-all" type="checkbox" class="jsonly">'.script("qs('#check-all').onclick = partial(formCheck, /^tables\[/);",""),'<th>'.lang(101),'<td>'.lang(102),"</thead>\n";foreach(table_status()as$R=>$I){$_=adminer()->tableName($I);if($_!=""){echo'<tr><td>'.checkbox("tables[]",$R,in_array($R,(array)$_POST["tables"],true)),"<th><a href='".h(ME).'select='.urlencode($R)."'>$_</a>";$X=format_number($I["Rows"]);echo"<td align='right'><a href='".h(ME."edit=").urlencode($R)."'>".($I["Engine"]=="InnoDB"&&$X?"~ $X":$X)."</a>";}}echo"</table>\n","</div>\n","</form>\n",script("tableCheck();");adminer()->pluginsLinks();}}page_footer();