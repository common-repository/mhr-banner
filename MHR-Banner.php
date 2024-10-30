<?php
/*
Plugin Name: MHR-Banner [Show banner/advertisement on page footer]
Plugin URI: http://blog.mahadirlab.webuda.com/en/mhr-banner/
Description: This plug-in is for peoples who want to publish banner on page footer.
Version: 1.1.0
Author: Mahadir Ahmad
Author URI: http://mahadirlab.webuda.com
*/

/*
Copyright (C) 2011  Mahadir Ahmad

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

// function core
function mhr_banner_show($mhr_banner_source,$mhr_click_url,$mhr_backg_color,$mhr_banner_height,$mhr_banner_width,$mhr_background_height,$mhr_background_bottom)
{
$current_url = WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__));
?>
<script type="text/javascript">
/***********************************************
MHR-Banner
Mahadir Ahmad
http://mahadirlab.webuda.com
***********************************************/
var persistclose= 1 //set to 0 or 1. 1 means once the bar is manually closed, it will remain closed for browser session
var startX = 0 //set x offset of bar in pixels
var startY = 0 //set y offset of bar in pixels
var verticalpos="frombottom" //enter "fromtop" or "frombottom"
function iecompattest(){
return (document.compatMode && document.compatMode!="BackCompat")? document.documentElement : document.body
}
function get_cookie(Name) {
var search = Name + "="
var returnvalue = "";
if (document.cookie.length > 0) {
offset = document.cookie.indexOf(search)
if (offset != -1) {
offset += search.length
end = document.cookie.indexOf(";", offset);
if (end == -1) end = document.cookie.length;
returnvalue=unescape(document.cookie.substring(offset, end))
}
}
return returnvalue;
}
function openbar(){
document.cookie="remainclosed=0"
document.getElementById("toppopin").style.visibility="visible"
}
function closebar(){
if (persistclose)
document.cookie="remainclosed=1"
document.getElementById("toppopin").style.visibility="hidden"
}
function openbar(){
document.getElementById("toppopin").style.visibility="visible"
}
function staticbar(){
barheight=document.getElementById("toppopin").offsetHeight
var ns = (navigator.appName.indexOf("Netscape") != -1) || window.opera;
var d = document;
function ml(id){
var el=d.getElementById(id);
if (!persistclose || persistclose && get_cookie("remainclosed")=="")
el.style.visibility="visible"
if(d.layers)el.style=el;
el.sP=function(x,y){this.style.left=x+"px";this.style.top=y+"px";};
el.x = startX;
if (verticalpos=="fromtop")
el.y = startY;
else{
el.y = ns ? pageYOffset + innerHeight : iecompattest().scrollTop + iecompattest().clientHeight;
el.y -= startY;
}
return el;
}
window.stayTopLeft=function(){
if (verticalpos=="fromtop"){
var pY = ns ? pageYOffset : iecompattest().scrollTop;
ftlObj.y += (pY + startY - ftlObj.y)/8;
}
else{
var pY = ns ? pageYOffset + innerHeight - barheight: iecompattest().scrollTop + iecompattest().clientHeight - barheight;
ftlObj.y += (pY - startY - ftlObj.y)/8;
}
ftlObj.sP(ftlObj.x, ftlObj.y);
setTimeout("stayTopLeft()", 10);
}
ftlObj = ml("toppopin");
stayTopLeft();
}
if (window.addEventListener)
window.addEventListener("load", staticbar, false)
else if (window.attachEvent)
window.attachEvent("onload", staticbar)
else if (document.getElementById)
window.onload=staticbar
</script>


<style type="text/css">
#toppopin{
position:absolute;
background:<?php echo $mhr_backg_color; ?>;
width: 100%;
height: <?php echo $mhr_banner_height; ?>px;
bottom:<?php echo $mhr_background_bottom; ?>;
visibility: hidden;
z-index: 100;
}

.bannerimg {
background:url(<?php echo $mhr_banner_source ; ?>) bottom center no-repeat;
width:<?php echo $mhr_banner_width; ?>px;
margin:0 auto;
height:<?php echo $mhr_banner_height; ?>px;
position:relative;
}
.myclickbtn {
position:absolute;
right:0;
top:0;
width:<?php echo $mhr_banner_width; ?>px;
height:<?php echo $mhr_banner_height; ?>px;
cursor:pointer;
}
#closebtn {
position:absolute;
top:8px;
right:8px;
}
#closebtn a:hover {
text-decoration:none;
}
</style>

<div id="toppopin" style="visibility: visible; left: 0px; top: 917px;">
<div id="closebtn"><a href="" onClick="closebar(); return false"><img src="<?php echo $current_url ; ?>close.png" border="0" width="15" height="15" /></a>
</div>
<div class="bannerimg" width="100%">
<div class="myclickbtn" onclick="window.open('<?php echo $mhr_click_url ; ?>','_blank')"></div>
</div>
</div>

<?php
}

//###############################################################################################################################
// Setting core MHR-Banner
function mhr_banner_options_page()
{
$current_url = WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__));
?>
<div class="wrap">
	<h1>MHR-Banner <font size="2">ver 1.1.0</font></h1>
	| <a href="http://blog.mahadirlab.webuda.com/en/mhr-banner/" target="_blank" title="Visit homepage of wordpress plugin MHR-Banner">Visit Plugin page</a> | <a href="http://blog.mahadirlab.webuda.com/donation" target="_blank" title="Donate some amount to MHR-Banner plugin developer to help him to develope more such plugins">Donate</a> |
	<h3>- settings page -</h3>
<?php
	if($_POST['mhr_save']){
        update_option('mhr_banner_status',$_POST['mhr_banner_status']);
		update_option('mhr_banner_source',$_POST['mhr_banner_source']);
		update_option('mhr_click_url',$_POST['mhr_click_url']);
		update_option('mhr_backg_color',$_POST['mhr_backg_color']);
		update_option('mhr_banner_height',$_POST['mhr_banner_height']);
		update_option('mhr_banner_width',$_POST['mhr_banner_width']);
		update_option('mhr_background_height',$_POST['mhr_background_height']);
		update_option('mhr_background_bottom',$_POST['mhr_background_bottom']);

		echo '<div class="updated"><p>Settings saved</p></div>';
	}
	//assign default value
	$mhr_banner_status = get_option('mhr_banner_status');
	if (($mhr_banner_status!=1) && ($mhr_banner_status!=2))
    {
       $mhr_banner_status = 2;    //by default banner is disable
	   update_option('mhr_banner_status',2);
	}
	if (get_option('mhr_banner_source') == "")
	update_option('mhr_banner_source',$current_url . 'banner2.gif');
	if (get_option('mhr_click_url') == "")
	update_option('mhr_click_url','http://tiny.cc/free_host');
	if (get_option('mhr_backg_color') == "")
	update_option('mhr_backg_color','#FFFFFF');
	if (get_option('mhr_banner_height') == "")
	update_option('mhr_banner_height',90);
	if (get_option('mhr_banner_width') == "")
	update_option('mhr_banner_width',800);
	if (get_option('mhr_background_height') == "")
	update_option('mhr_background_height',90);
	if (get_option('mhr_background_bottom') == "")
	update_option('mhr_background_bottom',0);
	// close assign value
	
	?>
<form method="post" id="mhr_banner">
		<fieldset class="options">
		<table class="form-table" border="0">
			<tr valign="top">
				<th width="33%" scope="row">Banner Status:</th>
				<td>
				<input type="radio" name="mhr_banner_status" value="1" <?php if($mhr_banner_status == 1) echo('checked'); ?> />
				Enable MHR-Banner.<br />
				<input type="radio" name="mhr_banner_status" value="2" <?php if($mhr_banner_status == 2) echo('checked'); ?> />
				Disable MHR-Banner.<br />
                </td>
            </tr>
            <tr valign="top">
                <th width="33%" scope="row">Banner Source URL:</th>
                <td>
				<input name="mhr_banner_source" type="text" id="mhr_banner_source" value="<?php echo get_option('mhr_banner_source') ;?>" size="60"/>
				</td>
			</tr>
			<tr valign="top">
				<th width="33%" scope="row">Click URL:</th>
				<td>
				<input type="text" id="mhr_click_url" size="60" name="mhr_click_url" value="<?php echo get_option('mhr_click_url'); ?>" />
				</td>
			</tr>
			<tr valign="top">
				<th width="33%" scope="row">Banner Background Color:</th>
				<td>
				<script language="Javascript" src="<?php echo $current_url ?>ColorPicker2.js"></script>
                <script language="JavaScript">
                var cp = new ColorPicker('window'); // Popup window
                var cp2 = new ColorPicker(); // DIV style
                </script>
                <input name="mhr_backg_color" size="20" value="<?php echo get_option('mhr_backg_color'); ?>" type="text"> <a href="#" onclick="cp.select(document.forms[0].mhr_backg_color,'pick2'); return false;" name="pick2" id="pick2">Pick Color</a>
                <SCRIPT LANGUAGE="JavaScript">cp.writeDiv()</SCRIPT>
				</td>
			</tr>
			<tr valign="top">
				<th width="33%" scope="row">Options:</th>
				<td>
				Banner Height:&ensp;&ensp;&ensp;&ensp;&ensp;<input type="text" id="mhr_banner_height" size="5" name="mhr_banner_height" value="<?php echo get_option('mhr_banner_height'); ?>" /> px<br>
				Banner Width:&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;<input type="text" id="mhr_banner_width" size="5" name="mhr_banner_width" value="<?php echo get_option('mhr_banner_width'); ?>" /> px<br>
				Background Height: <input type="text" id="mhr_background_height" size="5" name="mhr_background_height" value="<?php echo get_option('mhr_background_height'); ?>" /> px<br>
				Backgound Bottom: <input type="text" id="mhr_background_bottom" size="5" name="mhr_background_bottom" value="<?php echo get_option('mhr_background_bottom'); ?>" /> px<br>
				</td>
			</tr>
		<tr>
        <th width="33%" scope="row">Save settings :</th>
        <td>
		<input type="submit" name="mhr_save" value="Save Settings" />
        </td>
        </tr>
		<tr>
        <th scope="row" style="text-align:right; vertical-align:top;">
        <td>
		<h3>What's next ?</h3>
		<p>The version of this plugin is ver 1.1.0, in this version you can only set your banner<br>
           by using image.In the next version this plugin will have ability to publish text banner,<br>
           forms, flash, and multiple banners with timing. Since this plugin is free, please support me<br>
           through donations or ideas to help me continue develope this plugin.</p>
		<h3>Problems, Questions, Suggestions ?</h3>
		<p>Send me email : <a href="mailto:mahadirz.93@gmail.com">mahadirz.93@gmail.com</a></p>
        </td>
        </tr>
		</table>
		<h3>Thank you</h3>
		Plug-in developed by <a href="http://blog.mahadirlab.webuda.com" target="_blank">Mahadir Ahmad</a>. <br />
		<small>Add me as friend on facebook <a href="http://facebook.com/mahadirz" target="_blank">mahadirz</a></small>
		<p>
		<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
        <input type="hidden" name="cmd" value="_s-xclick">
        <input type="hidden" name="hosted_button_id" value="YQUS4PXZ6UZHQ">
        <input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
        <img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
        </form></p>
		</fieldset>
	</form>
	</table>
	</div>
	<?php
}

//call to function
//you can show/hide banner in other place using javascript
//javascript: void openbar();
//javascript: void closebar();
function mhr_banner_set()
{
$mhr_status = get_option('mhr_banner_status');
if ( $mhr_status == 1)
  {
    $mhr_banner_source = get_option('mhr_banner_source');
    $mhr_click_url= get_option('mhr_click_url') ;
    $mhr_backg_color= get_option('mhr_backg_color') ;
    $mhr_banner_height=  get_option('mhr_banner_height') ;
    $mhr_banner_width=  get_option('mhr_banner_width') ;
    $mhr_background_height= get_option('mhr_background_height');
    $mhr_background_bottom= get_option('mhr_background_bottom');
    mhr_banner_show($mhr_banner_source,$mhr_click_url,$mhr_backg_color,$mhr_banner_height,$mhr_banner_width,$mhr_background_height,$mhr_background_bottom);
  }
}


function mhr_banner_adminmenu()
{
	if (function_exists('add_options_page')) {	
		add_options_page('MHR-Banner', 'MHR-Banner', 9, basename(__FILE__),'mhr_banner_options_page');
	}
}

//Commanding the Wordpress
add_action('wp_footer','mhr_banner_set');
add_action('admin_menu','mhr_banner_adminmenu',1);
?>
