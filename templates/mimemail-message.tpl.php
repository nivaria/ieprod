<?php
/**
 * @file
 * Default theme implementation to format an HTML mail.
 *
 * Copy this file in your default theme folder to create a custom themed mail.
 * Rename it to mimemail-message--[mailkey].tpl.php to override it for a
 * specific mail.
 *
 * Available variables:
 * - $subject: The message subject.
 * - $body: The message body in HTML format.
 * - $mailkey: The message identifier.
 * - $recipient: An email address or user object who is receiving the message.
 * - $css: Internal style sheets.
 *
 * @see template_preprocess_mimemail_message()
 */
global $base_url;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <title><?php print $subject ?></title>
  <style type="text/css">
  /* Client-specific Styles */
  #outlook a {padding: 0;}  /* Force Outlook to provide a "view in browser" button. */
  body {width: 100% !important;}
  .ReadMsgBody {width: 100%;}
  .ExternalClass {width: 100%;}  /* Force Hotmail to display emails at full width */
  body {  -webkit-text-size-adjust: none;}  /* Prevent Webkit platforms from changing default text sizes. */
  /* Reset Styles */
  body {margin: 0;padding: 0;}
  img {border: 0; height: auto; outline: none; vertical-align: baseline; }
  a, a:link, a:visited { color: #FF3F3F; text-decoration: none; }
  table td {border-collapse: collapse;}
  #partners img { display: block; border: 1px solid #cccccc; }
  #newsletter-footer a { color: #999999; }
  </style>
</head>
<body style="color: #666666; font-family: Helvetica, Arial, sans-serif; font-size: 16px;">
<center>
<table border="0" cellpadding="0" cellspacing="10" width="100%" id="wrapper" style="font-family: Helvetica, Arial, sans-serif; font-size: 16px;">
  <tr>
    <td align="center" valign="top">
      <table border="0" cellpadding="0" cellspacing="0" width="580" style="background-color: #FFFFFF; font-family: Helvetica, Arial, sans-serif; font-size: 16px;">
        <tr>
          <td align="center" valign="top">
            <table border="0" cellpadding="30" cellspacing="0" width="580" style="border-bottom: 1px solid #000000; font-family: Helvetica, Arial, sans-serif; font-size: 16px;">
              <tr>
                <td class="logo" align="center" valign="top">
                  <?php if ($logo): ?>
                    <div class="logo">
                     <a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" rel="home" id="logo"><img src="<?php print $logo; ?>" alt="<?php print t('Home',array(),!empty($recipient->language)?$recipient->language:NULL); ?>" /></a>
                    </div>
                    <div class="slogan" style="font-weight:bold; font-style:italic; color: #000000;">
                        <?php if(variable_get('arquideas_solution_mode', FALSE)): ?>
                            <?php print variable_get('site_slogan', $slogan); ?>
                        <?php else: ?>
                            <?php print $slogan; ?>
                        <?php endif; ?>
                    </div>
                  <?php endif; ?>
                </td>
              </tr>
            </table>
          </td>
        </tr>
        <tr>
          <td align="center" valign="top">
            <table border="0" cellpadding="0" cellspacing="0" width="580" id="content" style="font-family: Helvetica, Arial, sans-serif; font-size: 16px;">
              <?php $username = '';
                    $userlang = $GLOBALS['language']->language;
                    if(is_object($recipient)){
                      $username = !empty($recipient->realname)?$recipient->realname:$recipient->name;
                      $userlang = $recipient->language;
                    }
              ?>
              <?php if($username): ?>
              <tr>
                <td align="center" valign="top" style="color: #000000;padding:12px 0 0;"><?php print t('Hello, !user',array('!user'=> $username),$userlang); ?></td>
              </tr>
              <?php endif; ?>
              <tr <?php print empty($username)?"style=\"padding-top:12px;\"":""; ?>>
                <td align="left" valign="top" style="color: #666666; font-size: 16px;"><?php print (empty($username)?'<br/>':'').$body; ?></td>
              </tr>
            </table>
          </td>
        </tr>
        <tr>
          <td align="center" valign="top">
            <table border="0" cellpadding="0" cellspacing="0" width="580" style="font-family: Helvetica, Arial, sans-serif; font-size: 16px; background-color: #ffffff; color: #999999; font-weight: bold; font-size: 12px;">
              <tr>
                <td>
                  <div style="height:10px;">&nbsp;</div>
                </td>
              </tr>
              <tr>
                <?php if(variable_get('arquideas_solution_mode', FALSE)): ?>
                    <td width="193" align="left" valign="middle">
                        <a href="http://www.arquideas.net/node/24409" title="Arquideas Solution"><img src="<?php print $base_url . '/'. path_to_theme();?>/images/solution/arquideas-solution.png" alt="Arquideas Solution" /></a>
                    </td>
                    <td width="193" align="center" valign="middle">
                        <a href="http://www.arquideas.net" style="color: #999999;">Copyright Arquideas 2012</a>
                    </td>
                    <td width="193" align="right" valign="middle">
                        <img src="<?php print $base_url . '/'. path_to_theme();?>/images/solution/solution-by-arquideas-nivaria.png" alt="solution by Arquideas and Nivaria" usemap="#solutionmap" />
                        <map name="solutionmap">
                            <area shape="rect" coords="0,0,138,22" href="http://www.arquideas.net" alt="Arquideas">
                            <area shape="rect" coords="138,0,216,22" href="http://www.nivaria.com" alt="Nivaria">
                        </map>
                    </td>
                <?php else: ?>  
                    <td width="193" align="left" valign="middle">
                      <a href="<?php print $base_url; ?>/home" style="color: #999999;">Copyright Arquideas 2012</a>
                    </td>
                    <td width="193" align="center" valign="middle">
                      <a href="<?php print $base_url; ?>/home" style="color: #FF3F3F;">www.arquideas.net</a>
                    </td>
                    <td width="193" align="right" valign="middle">
                      <a href="http://www.nivaria.com" title="Nivaria"><img src="<?php print $base_url . '/'. path_to_theme();?>/images/nws_by_nivaria.png" alt="Nivaria" /></a>
                    </td>
                <?php endif; ?>
              </tr>
              <tr>
                <td>
                  <div style="height:60px;">&nbsp;</div>
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</center>
</body>
</html>