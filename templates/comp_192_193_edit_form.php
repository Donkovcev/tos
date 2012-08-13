<?php

echo "


".( $warnText ? "<div class='warnText'>$warnText</div>" : NULL )."
<form name='adminForm' id='adminForm' enctype='multipart/form-data' method='post' action='/netcat/message.php'>
<div id='nc_moderate_form'><div class='nc_clear'></div>
<input name='admin_mode' type='hidden' value='$admin_mode' />
<input name='catalogue' type='hidden' value='$catalogue' />
<input name='cc' type='hidden' value='$cc' />
<input name='sub' type='hidden' value='$sub' />
<input name='message' type='hidden' value='$message' />
<input name='posting' type='hidden' value='1' />
<input name='curPos' type='hidden' value='$curPos' />
<input name='f_Parent_Message_ID' type='hidden' value='$f_Parent_Message_ID' />
".( $admin_mode && !$systemTableID ? "<div id='nc_moderate_settings'>
	".($admin_mode ? "<div class='left'>
		".CONTROL_CONTENT_SUBDIVISION_FUNCS_MAINDATA_KEYWORD." <input name='f_Keyword' type='text' size='20' maxlength='255' value='".$f_Keyword."'>
	</div>
	<div class='left'>
		<img src='/netcat/admin/images/prior.gif' width='16' height='16' align='left' alt='Приоритет' title='Приоритет' />
		<input name='f_Priority' type='text' size='3' maxlength='3' value='".$f_Priority."' />
	</div>" : "")."
	".(CheckUserRights( $current_cc['Sub_Class_ID'], "moderate", $posting )? "
	<div class='left_checkbox'>
		<input id='chk' name='f_Checked' type='checkbox' value='1' ".($f_Checked ? "checked='checked'" : "")." /> <label for='chk'>".NETCAT_MODERATION_TURNON."</label>
	</div>"
	: "<input id='chk' name='f_Checked' type='hidden' value='".($f_Checked ? 1 : 0)."' />")."
	</div>
" : NULL )."".($admin_mode ? "<div id='nc_moderate_info'><table border='0' cellpadding='0' cellspacing='0' align='right'><tr><td>".CLASS_TAB_CUSTOM_ADD.":</td><td><div class='nc_moderate_info_date'>".$f_Created."</div></td><td><div class='nc_idtab_adduser nc_moderate_info_user'>".( $f_newAdminInterface_user_add ? $f_newAdminInterface_user_add : $f_AdminButtons_user_add )."</div>(".$f_IP.")</td></tr>".( $f_LastUserID ?"<tr valign='top'><td>".CLASS_TAB_CUSTOM_EDIT.":</td><td><div class='nc_moderate_info_date'>".$f_LastUpdated."</div></td><td><div class='nc_moderate_info_user nc_idtab_adduser'>".( $f_newAdminInterface_user_change ? $f_newAdminInterface_user_change : $f_AdminButtons_user_change )."</div>(".$f_LastIP.")</td></tr>": NULL )."</table></div>" : "")." <div class='nc_clear'></div>
 ".($admin_mode ? "<span class='seo'><a href='#' onclick='nc_toggle(\"nc_seo_block\"); return false;'>SEO</a></span>
<div id='nc_seo_block' style='display:none;'>
  <div class='item'>".NETCAT_MODERATION_SEO_TITLE.": </div><input type='text' name='f_ncTitle' size='100'  value='".$f_ncTitle."'><br/><div class='nc_clear'></div>
  <div class='item'>".NETCAT_MODERATION_SEO_KEYWORDS.": </div><input type='text' name='f_ncKeywords' size='100'  value='".$f_ncKeywords."'><br/><div class='nc_clear'></div>
  <div class='item'>".NETCAT_MODERATION_SEO_DESCRIPTION.": </div><input type='text' name='f_ncDescription' size='100'  value='".$f_ncDescription."'><br/><div class='nc_clear'></div>
</div>" :"")." </div>

".(!$f_Parent_Message_ID?"

".nc_bool_field("developed", "", $classID, 1)."<br />
".nc_string_field("name", "maxlength='255' size='50'", $classID, 1)."<br />
<br />
".nc_string_field("name_rus", "maxlength='255' size='50'", $classID, 1)."<br />
<br />
".nc_text_field("text", "", $classID, 1)."<br />
<br />
".nc_text_field("text_rus", "", $classID, 1)."<br />
<br />
".nc_text_field("facts", "", $classID, 1)."<br />
<br />
".nc_text_field("facts_rus", "", $classID, 1)."<br />
<br />
".nc_int_field("Price", "maxlength='12' size='12'", $classID, 1)."<br />
<br />
".nc_int_field("company_proposal", "maxlength='12' size='12'", $classID, 1)."<br />
<br />
".nc_int_field("Count", "maxlength='12' size='12'", $classID, 1)."<br />
<br />
".nc_string_field("operator", "maxlength='255' size='50'", $classID, 1)."<br />
<br />

":"

  ".($f_IsReports==1?"
    <input name='f_IsReports' type='hidden' value='1' />
    ".nc_file_field("Reports", "size='50'", $classID, 1)."  <br />
    <br />
    ".nc_text_field("ReportsText", "", $classID, 1)."<br />
    <br />
    ". nc_list_field("ReportsQuarter", "", $classID, 1) ."
  ":"
    ".nc_file_field("photo", "size='50'", $classID, 1)."
  ")."
  <br />
  <br />

")."

<br/>".NETCAT_MODERATION_INFO_REQFIELDS."<br/><br/>
".nc_submit_button(NETCAT_MODERATION_BUTTON_CHANGE)."
</form>


";

?>