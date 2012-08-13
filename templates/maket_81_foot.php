<?php
global $nc_l, $nc_translate; // перевод
echo "
          <div class='blocks'>
            <div class='block about-block'>
              <div class='pict'>
                <img src='{$template_settings[photo][path]}' alt='' />
              </div>
              <h2>$template_settings[name]</h2>
              <blockquote>
                $template_settings[text_1]
              </blockquote>
              <p>$template_settings[text_2]</p>
            </div><!-- .block -->
";

if($AUTH_USER_ID && $current_user['ForumName']) {
echo "
			<div class='block auth-block loged'>
			  <div class='block-body'>
				{$nc_translate[109][$nc_l]}, <a href='/profile/profile_{$current_user['User_ID']}.html' title=''>{$current_user['ForumName']} </a></div><!-- .block-body -->
			  <div class='block-footer'>
				<a href='$SUB_FOLDER/netcat/modules/auth/?logoff=1&amp;REQUESTED_FROM=$REQUEST_URI&amp;REQUESTED_BY=$REQUEST_METHOD'>{$nc_translate[48][$nc_l]}</a>              </div><!-- .block-footer -->
			</div>
			<div class='sales'>
";
echo s_list_class(110, 191, 'nc_ctpl=209');
/*
if($nc_l == 'en') {
	echo s_list_class(110, 191, 'nc_ctpl=209');
} else {
	echo s_list_class(297, 325, 'nc_ctpl=209');
}
*/
echo "
			</div>
            <div class='clear'></div>
";
} else {
echo "
            <div class='block auth-block'>
              <div class='block-body'>

				<div class='block partnership-block'>
					<h2><a href='/profile/registration/' title=''>{$nc_translate[46][$nc_l]}</a></h2>
				</div><!-- .block -->

				<div class='login-divider'></div>

                <div class='frm login-frm'>
                  <form action='/netcat/modules/auth/' method='post'>
					<input type='hidden' name='AuthPhase' value='1' />
					<input type='hidden' name='REQUESTED_FROM' value='/profile/activity/' />
					<input type='hidden' name='REQUESTED_BY' value='$REQUEST_METHOD' />
					<input type='hidden' name='catalogue' value='$catalogue' />
					<input type='hidden' name='sub' value='$sub' />
					<input type='hidden' name='cc' value='$cc' />
                    <strong class='title'>{$nc_translate[49][$nc_l]}</strong>
                    <fieldset>
                      <div class='frm-row'>
                        <label for='get-login'>{$nc_translate[50][$nc_l]}</label>
                        <input ". (($nc_valid == 1) ? "class='required'" : "") ." type='text' name='AUTH_USER' id='get-login' />
                      </div><!-- .frm-row -->
                      <div class='frm-row'>
                        <label for='get-pswd'>{$nc_translate[51][$nc_l]}</label>
                        <input ". (($nc_valid == 2 || $nc_valid == 1) ? "class='required'" : "") ." type='password' name='AUTH_PW' id='get-pswd' />
                      </div><!-- .frm-row -->
                    </fieldset>
                    <div class='clear'></div>
                    <div class='frm-act'>
                      <input type='image' src='/images/texasonshore/img/btns/". ($nc_l == "en" ? "login.png" : "login_rus.png") ."' alt='{$nc_translate[50][$nc_l]}' />
                      <span class='check'><label><input type='checkbox' name='loginsave' /> {$nc_translate[52][$nc_l]}</label></span>
                    </div><!-- .frm-act -->
                  </form>
                </div><!-- .frm -->
              </div><!-- .block-body -->
              <div class='block-footer'>
               <!-- <a href='/profile/registration/' title=''>{$nc_translate[53][$nc_l]}</a>
                <span class='sep'>/</span>-->
                <a href='/netcat/modules/auth/password_recovery.php' title=''>{$nc_translate[54][$nc_l]}</a>
              </div><!-- .block-footer -->

            </div><!-- .block -->
			<div class='sales'>
";
if($nc_l == 'en') {
	echo s_list_class(110, 191, 'nc_ctpl=209');
} else {
	echo s_list_class(297, 325, 'nc_ctpl=209');
}
echo "
			</div>
            <div class='clear'></div>

";
}
echo "
            <div class='clear'></div>
          </div><!-- .blocks -->
          <div class='blocks'>


          </div><!-- .blocks -->
        </div><!-- #content -->
        <div id='footer'>
          <div class='contacts'>
            <div class='phone'><strong>{$current_catalogue['phone']}</strong></div>
            <div class='email'><a href='mailto:{$current_catalogue['Email']}'>{$current_catalogue['Email']}</a></div>
          </div><!-- .contacts -->
          <div id='copy'>&copy; 2012 <a href='http://www.texasonshore.se/' target='_blank'>{$nc_translate[58][$nc_l]}</a></div>
        </div><!-- #footer -->
      </div><!-- #layout -->
    </div><!-- #wrapper -->
  </div><!-- #page -->
". jsInit() ."
</body>
</html>
";

?>