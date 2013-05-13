<?php
// $Id: node-news.tpl.php 7510 2010-06-15 19:09:36Z sheena $
  $changedLang = FALSE;
  $prevLang = NULL;
  if(isset($language) && is_string($language) && $GLOBALS['language']->language!=$language){
      $languages = language_list('enabled');
      $languages = $languages[1];
      if(!empty($languages[$language])){
          $prevLang = $GLOBALS['language']; 
          $GLOBALS['language'] = $languages[$language];
          $changedLang = TRUE;
      }
  }  

  global $base_url;
  $fields = content_types($node->type);
  if (!empty($fields) && !empty($fields['fields'])) {?>
    <!-- Fields of <?php print $node->type ?>:
    <?php foreach ($fields['fields'] as $field) {
      print $field['field_name'];?>

    <?php }?>
        -->
<?php }?>
<div id="node-<?php print $node->nid; ?>" class="node <?php print $node_classes; ?>" style="width:580px;">
  <div class="inner">

    <?php if ($page == 0): ?>
    <div class="title"><a href="<?php print $node_url ?>" title="<?php print $title ?>"><?php print $title ?></a></div>
    <?php endif; ?>

    <?php if ($node_top && !$teaser): ?>
    <div id="node-top" class="node-top row nested">
      <div id="node-top-inner" class="node-top-inner inner">
        <?php print $node_top; ?>
      </div><!-- /node-top-inner -->
    </div><!-- /node-top -->
    <?php endif; ?>

    <div class="content clearfix">

      <?php print $node->content['body']['#value'] ?>

      <?php if($general_newsletter): ?>
        <!-- Contests block -->
        <?php if($field_simplenews_last_contests[0]['value']==1): ?>
          <table border="0" cellpadding="0" cellspacing="0" width="580" class="simplenews-last-contests-block block" style="font-family: Helvetica, Arial, sans-serif; font-size: 16px;">
            <tr><td height="45px" style="line-height:45px;">&nbsp;</td></tr>
            <tr><td><img src="<?php print $base_url . '/'. path_to_theme();?>/images/nws-separator.png" /></td></tr>
            <tr>
              <td align="center" style="border-bottom: 1px solid #000000; font-weight: bold; text-transform: uppercase; font-size: 21px; color: #000000;">
                <div style="line-height:20px; height: 20px;">&nbsp;</div>
                <?php print t('Upcoming Contests'); ?>
                <div style="line-height:20px; height: 20px;">&nbsp;</div>
              </td>
            </tr>
            <tr><td height="20px" style="line-height:20px;">&nbsp;</td></tr>
            <tr>
              <td>
                <div class="content">
                  <?php print views_embed_view('arquideas_newsletter_contest_bl', 'default'); ?>
                </div>
              </td>
            </tr>
          </table>
        <?php endif; ?>
        <!-- End Contests block -->

        <!-- News block -->
        <?php if($field_simplenews_news[0]['value']==1): ?>
          <table border="0" cellpadding="0" cellspacing="0" width="580" class="simplenews-news-block block" style="font-family: Helvetica, Arial, sans-serif; font-size: 16px;">
            <tr><td height="45px" style="line-height:45px;">&nbsp;</td></tr>
            <tr><td><img src="<?php print $base_url . '/'. path_to_theme();?>/images/nws-separator.png" /></td></tr>
            <tr>
              <td align="center" style="border-bottom: 1px solid #000000; font-weight: bold; text-transform: uppercase; font-size: 21px; color: #000000;">
                <div style="line-height:20px; height: 20px;">&nbsp;</div>
                <?php print t('News'); ?>
                <div style="line-height:20px; height: 20px;">&nbsp;</div>
              </td>
            </tr>
            <tr><td height="20px" style="line-height:20px;">&nbsp;</td></tr>
            <tr>
              <td>
                <div class="content">
                  <?php print views_embed_view('arquideas_newsletter_news_block', 'default'); ?>
                </div>
              </td>
            </tr>
          </table>
        <?php endif; ?>
        <!-- End News block -->

        <!-- KM block -->
        <?php if($field_simplenews_group_content[0]['value']==1): ?>
          <table border="0" cellpadding="0" cellspacing="0" width="580" class="simplenews-km-block block" style="font-family: Helvetica, Arial, sans-serif; font-size: 16px;">
            <tr><td height="45px" style="line-height:45px;">&nbsp;</td></tr>
            <tr><td><img src="<?php print $base_url . '/'. path_to_theme();?>/images/nws-separator.png" /></td></tr>
            <tr>
              <td align="center" style="border-bottom: 1px solid #000000; font-weight: bold; text-transform: uppercase; font-size: 21px; color: #000000;">
                <div style="line-height:20px; height: 20px;">&nbsp;</div>
                <?php print t('Arquideas Community'); ?>
                <div style="line-height:20px; height: 20px;">&nbsp;</div>
              </td>
            </tr>
            <tr><td height="20px" style="line-height:20px;">&nbsp;</td></tr>
            <tr>
              <td>
                <div class="content">
                  <?php print views_embed_view('arquideas_newsletter_km_block', 'default'); ?>
                  <div style="line-height:30px; height: 30px;">&nbsp;</div>
                  <table border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td width="155">&nbsp;</td>
                      <td width="280" height="40" align="center" style="width: 280px; height: 40px; background: #FF3F3F;">
                          <?php print l(t('Discover Arquideas Community'),'arquideas_network',array(
                              'attributes' => array(
                                  'title' => t('Discover Arquideas Community'),
                                  'style' => 'font-family: Helvetica, Arial, sans-serif; font-weight: bold; font-style: italic; color: #FFFFFF; text-decoration: none; text-shadow: 1px 1px 0 #000000;',
                                  'target' => '_blank',
                              ),
                              )); 
                          ?>
                      </td>
                      <td width="155">&nbsp;</td>
                    </tr>
                  </table>
                </div>
              </td>
            </tr>
          </table>
        <?php endif; ?>
        <!-- End KM block -->

        <?php endif; ?>
        
          <!-- Partners & Co block -->
          <table border="0" cellpadding="0" cellspacing="0" width="580" class="simplenews-partners-block block" style="font-family: Helvetica, Arial, sans-serif; font-size: 16px;">
            <tr><td height="45px" style="line-height:45px;">&nbsp;</td></tr>
            <tr><td><img src="<?php print $base_url . '/'. path_to_theme();?>/images/nws-separator.png" /></td></tr>
            <tr>
              <td align="center" style="border-bottom: 1px solid #000000; font-weight: bold; text-transform: uppercase; font-size: 21px; color: #000000;">
                <div style="line-height:20px; height: 20px;">&nbsp;</div>
                <?php print t('PARTNERS & Co'); ?>
                <div style="line-height:20px; height: 20px;">&nbsp;</div>
              </td>
            </tr>
            <tr><td height="20px" style="line-height:20px;">&nbsp;</td></tr>
            <tr>
              <td>
                <div class="content">
                  <?php print views_embed_view('arquideas_newsletter_partners_nl', 'default', $node->nid); ?>
                </div>
              </td>
            </tr>
          </table>
          <!-- End Partners & Co block -->
        
      </div>
    </div><!-- /inner -->

  <?php if ($node_bottom && !$teaser): ?>
  <div id="node-bottom" class="node-bottom row nested">
    <div id="node-bottom-inner" class="node-bottom-inner inner">
      <?php print $node_bottom; ?>
    </div><!-- /node-bottom-inner -->
  </div><!-- /node-bottom -->
  <?php endif; ?>
</div><!-- /node-<?php print $node->nid; ?> -->
<?php if($changedLang){
   $GLOBALS['language'] = $prevLang; 
}
?>