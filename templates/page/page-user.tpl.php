<?php
// $Id: page.tpl.php 6635 2010-03-01 00:39:49Z chris $
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="<?php print $language->language; ?>" xml:lang="<?php print $language->language; ?>">

<head>
  <title><?php print $head_title; ?></title>
  <?php print $head; ?>
  <?php print $styles; ?>
  <?php print $setting_styles; ?>
  <!--[if IE 8]>
  <?php print $ie8_styles; ?>
  <![endif]-->
  <!--[if IE 7]>
  <?php print $ie7_styles; ?>
  <![endif]-->
  <!--[if IE 6]>
  <?php print $ie6_styles; ?>
  <![endif]-->
  <?php print $local_styles; ?>
  <?php print $scripts; ?>
</head>
<?php
/*-----------------------
A�adido para el control 
de las clases en �rea de 
edici�n y de visualizaci�n
-------------------------*/
 $body_classes.=(strpos($body_id,'-account-edit')||strpos($body_id,'-account-projects')||strpos($body_id,'-account-inscriptions')||strpos($body_id,'-account-arquideasbook'))?' account-edit ':'';
 $cambios_ancho=array(
 	'edicion'=>array(
		'grid16-16 forms_user',
		'grid16-12 force_width'
	),
	'visualizacion'=>array(
		'grid16-16 force_width border',
		'grid16-12 force_width'
	),
	'visualizacion-2'=>array(
		'grid16-12 force_width border',
		'grid16-12 force_width'
	)
 );
 $area=(strpos($body_classes,'account-edit'))?'edicion':'visualizacion';
 $area=(strpos($body_classes,'entrada-ficha')&&($area=='visualizacion'))?'visualizacion-2':$area;
 $body_classes.=($area=='visualizacion-2')?'  ':'';
/*-------------------------
HASTA AQU� ----------------
M�s cambios en la fila 200,
 215 y 285 ----------------
-------------------------*/
?>
<body id="<?php print $body_id; ?>" class="<?php print $body_classes; ?> area-social">
  <div id="fb-root"></div>
  <script type="text/javascript">(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/<?php print $language->language=='es'?'es_ES':'en_US'?>/all.js#xfbml=1&appId=<?php print variable_get('arquideas_network_facebook_appId', '145135515632256'); ?>";
  fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));
  </script>  
  <div id="page" class="page">
    <div id="page-inner" class="page-inner">
      <div id="skip">
        <a href="#main-content-area"><?php print t('Skip to Main Content Area'); ?></a>
      </div>

     <?php if ($user_bar): ?>
      <!-- user-bar row: width = grid_width -->
      <div id="user-menu-wrapper" class="full-width">
        <div id="user-menu" class="max-width row inner clearfix">
					<?php print $user_bar; ?>
  			</div><!-- /user-menu-wrapper -->
      </div><!-- /user-menu -->
      <?php endif; ?>

      <!-- header-group row: width = grid_width -->
      <div id="header-large-wrapper" class="full-width">
        <div id="header-large-inner" class="max-width row inner clearfix">
    			<div id="header-top-region" class="clearfix">
            <?php print $header_top; ?>
    			</div><!-- /header-top-region -->

  				<?php if ($logo): ?>
          <div class="logo">
            <a href="<?php print check_url($front_page); ?>" title="<?php print t('Home'); ?>"><img src="<?php print $logo; ?>" alt="<?php print t('Home'); ?>" /></a>
          </div>
          <?php endif; ?>

          <?php if ($site_slogan): ?>
          <div class="slogan"><?php print $site_slogan; ?></div>
          <?php endif; ?>

          <?php if ($search_box): ?>
            <?php print drupal_get_form('search_block_form');  ?>
          <?php endif; ?>

    			<div id="header-region">
            <?php print $header; ?>
    			</div><!-- /header-region -->

        </div><!-- /header-large-inner -->
      </div><!-- /header-large-wrapper -->

      <div id="header-small-wrapper" class="full-width">
        <div id="header-small-inner" class="max-width row inner clearfix">
          <div id="header-region-top-following">
    				<?php if ($logo): ?>
            <div class="logo">
              <a href="<?php print check_url($front_page); ?>" title="<?php print t('Home'); ?>"><img src="<?php print $logo; ?>" alt="<?php print t('Home'); ?>" /></a>
            </div>
            <?php endif; ?>
            <?php if ($search_box): ?>
              <?php print drupal_get_form('search_block_form'); ?>
            <?php endif; ?>
  					<?php print $header_top_following; ?>
    			</div><!-- /header-region-top-following -->
        </div><!-- /header-small-inner -->
      </div><!-- /header-small-wrapper -->

      <div id="header-region-following" class="full-width">
        <div id="header-region-following-inner" class="max-width row inner clearfix">
					<?php print theme('grid_block', $primary_links_tree, 'primary-menu'); ?>
  			</div><!-- /header-region-following-inner -->
      </div><!-- /header-region-following -->

      <!-- preface-top row: width = grid_width -->
  		<?php print theme('grid_row', $preface_top, 'preface-top', 'full-width', $grid_width); ?>
  		<div id="preface-top-wrapper" class="preface-top-wrapper full-width">
      	<div id="preface-top" class="preface-top row <?php print $grid_width; ?> clearfix">
  		<?php if($show_breadcrumb){
                    print theme('grid_block', $breadcrumb, 'breadcrumbs'); 
                } ?>
        </div>
  		</div>

      <!-- main row: width = grid_width -->
      <div id="main-wrapper" class="main-wrapper full-width">
        <div id="main" class="main row <?php print $grid_width; ?>">
          <div id="main-inner" class="main-inner inner clearfix">
            <?php print theme('grid_row', $sidebar_first, 'sidebar-first', 'nested', $sidebar_first_width); ?>

            <!-- main group: width = grid_width - sidebar_first_width -->
			<!-- el header Lo quito de content-inner y lo subo aqui -->
			 <?php if ($title && !$is_front): ?>
                   <header class="header row nested grid16-12">
                       <div class="name-holder clearfix">
						<h1 class="title"><?php print $title; ?></h1>
						<div class="follow-box">
							<div class="follow-box-inner">
<?php if(isset($account)){
						   // Número de seguidores
                           //  I just need to find out how to correctly user_load the account that is being viewed
                           //  from arg or something like that.  What code should I put in these 2 lines?
                           $params = array("requestee_id" => $account->uid);
                           $count = user_relationships_load($params, array("count" => TRUE));
                           print l('<span class="followers-count">'.$count.'</span>','user/'.$account->uid.'/content',array(
                               'attributes' => array(
                                   'title' => t('Followers'),
                               ),
                               'html' => TRUE,
                               'query' => 'quicktabs_quicktabs_my_content=3',
                           ));
                           // Follow
                           // Provide relationship links/messages
                           if (user_access('maintain own relationships')) {
                               // For the Commons "Follower" relatinoship, hide controls to
                               // make another user unfollow the present user.
                               $actions = _user_relationships_ui_actions_between($user, $account);
                               foreach ($actions as $action) {
                                   print '<span class="ur_action">'.$action.'</span>';
                               }
                           }
                           
                       } ?>
					   		</div>
					   	 </div>
					   </div>
                       <!--TODO: make it with some include -->
                       <?php if(!$is_edit): ?>
                       
                      
                       <div class="userpoints">
                           <?php if (isset($account->badges)): ?>
                               <?php
                               foreach ($account->badges as $badge) {
                                   $badges[] = theme('user_badge', $badge, $account);
                               }

                               if (!empty($badges)) {
                                   print theme('user_badge_group', $badges);
                               }
                               ?>
                           <?php endif; ?>
                           <span class="user-points">
                               <?php print isset($account)?userpoints_get_current_points($account->uid).' '.t('points'):''; ?>
                           </span>
                           <div class="user-job"><?php print isset($account)?$account->profile_job:''; ?></div>
                       </div>
					   
                       <?php if(FALSE && isset($account) && user_has_role(ROL_CONTEST_JURY, $account)): ?>
                       <div class="jury-member">
                           <?php print t('Jury of Arquideas'); ?>
                       </div>
                       <?php endif; ?>
                       <?php
                           $block = module_invoke('arquideas_generic', 'block', 'view', '13');
                           print '<div id="block-arquideas_generic-13" class="block block-arquideas_generic"><div class="inner"><div class="content">';
                           print $block['content'];
                           print '</div></div></div>';
                       ?>
                       <?php endif; ?>
			<div class="clear"></div>
			<?php
                            print theme('grid_block', $tabs, 'content-tabs');
                        ?>
                   </header>
               <?php endif; ?>
			   <!-- Agregada esta definicion, la que viene del sistema est� mal -->
			 <?php 
			 /*-----------------------------
			 Cuando es edicion de datos, esta 
			 capa es 16-16 Cuando es 
			 VISUALIZACI�N de datos es 
			 grid16-12, porque lleva a la 
			 izquierda la columna de datos
			 ------------------------------*/
			 $main_group_width= $cambios_ancho[$area][0]; ?>
            <div id="main-group" class="main-group row nested <?php print $main_group_width; ?>">
              <div id="main-group-inner" class="main-group-inner inner">
                <?php print theme('grid_row', $preface_bottom, 'preface-bottom', 'nested'); ?>

                <div id="main-content" class="main-content row nested">
                  <div id="main-content-inner" class="main-content-inner inner">
                    <!-- content group: width = grid_width - (sidebar_first_width + sidebar_last_width) -->
					<?php 
					 /*-----------------------------
					 Cuando es edicion de datos, esta 
					 capa es 16-12. Cuando es 
					 VISUALIZACI�N de datos es tambi�n
					 grid16-12, porque lleva a la 
					 izquierda la columna de datos
					 ------------------------------*/
					$content_group_width=$cambios_ancho[$area][1];?>
                    <div id="content-group" class="content-group row nested <?php print $content_group_width; ?>">
                      <div id="content-group-inner" class="content-group-inner inner">


                        <?php if ($content_top || $help || $messages): ?>
                        <div id="content-top" class="content-top row nested">
                          <div id="content-top-inner" class="content-top-inner inner">
                            <?php print theme('grid_block', $help, 'content-help'); ?>
                            <?php print theme('grid_block', $messages, 'content-messages'); ?>
                            <?php print $content_top; ?>
                          </div><!-- /content-top-inner -->
                        </div><!-- /content-top -->
                        <?php endif; ?>

                        <?php if ($content_front_left || $content_front_right): ?>
                        <div id="content-front" class="content-front">
                          <div id="content-front-inner" class="content-front-inner inner">
                            <?php if ($content_front_left): ?>
                              <div id="content-front-left" class="content-front-left double-border-shadow-block">
                                <div class="content-inner clearfix">
                                <?php print $content_front_left; ?>
                                </div>
                              </div>
                            <?php endif; ?>
                            <?php if ($content_front_right): ?>
                              <div id="content-front-right" class="content-front-right single-border-shadow-block">
                                <div class="content-inner clearfix">
                                <?php print $content_front_right; ?>
                                </div>
                              </div>
                            <?php endif; ?>
                          </div>
                        </div>
                        <?php endif; ?>

                        <div id="content-region" class="content-region row nested">
                  			  <div id="content-region-inner" class="content-region-inner inner">
                            <a name="main-content-area" id="main-content-area"></a>

                                <div id="content-inner" class="content-inner block">
                                    <div id="content-inner-inner" class="content-inner-inner inner">
                                   <!-- El header lo movemos arriba, en el dise�o sale a la derecha de la imagen -->

                                       <?php
                                            $msg_valid = '';
                                            if($user->uid==$account->uid && $user->uid!=0){
                                                if(user_has_role('not-validated user',$account)){
                                                    $msg_valid = t('Welcome to arquideas!<br/>Your account has been created successfully, but you need validate it.<br/>Please check your e-mail and click validation link.<br/>If you do not validate your account, it will be deleted.'); 
                                                }
                                            }
                                       ?>

                                        <?php if ($content || $msg_valid): ?>
                                            <div id="content-content" class="content-content">
                                            <?php if($msg_valid): ?>
                                                <div class="info block">
                                                    <div class="inner clearfix">   
                                                        <div class="content">
                                                            <?php print $msg_valid; ?>
                                                        </div>    
                                                    </div>    
                                                </div>    
                                            <?php endif; ?>    
                                            <?php print $content; ?>
                                            <?php print $feed_icons; ?>
                                            </div><!-- /content-content -->
                                        <?php endif; ?>
                                    </div><!-- /content-inner-inner -->
                                </div><!-- /content-inner -->

							</div><!-- /content-region-inner -->
						</div><!-- /content-region -->

                        <?php print theme('grid_row', $content_bottom, 'content-bottom', 'nested'); ?>
                      </div><!-- /content-group-inner -->
                    </div><!-- /content-group -->
					
                    <?php 
						$sidebar_last_width=($area=='visualizacion')?'grid16-4':$sidebar_last_width;
					?>
                    <?php print theme('grid_row', $sidebar_last, 'sidebar-last', 'nested', $sidebar_last_width); ?>
                  </div><!-- /main-content-inner -->
                </div><!-- /main-content -->

                <?php print theme('grid_row', $postscript_top, 'postscript-top', 'nested'); ?>
              </div><!-- /main-group-inner -->
            </div><!-- /main-group -->
          </div><!-- /main-inner -->
        </div><!-- /main -->
      </div><!-- /main-wrapper -->

      <!-- postscript-bottom row: width = grid_width -->
      <?php print theme('grid_row', $postscript_bottom, 'postscript-bottom', 'full-width', $grid_width); ?>

      <!-- footer row -->
      <div id="footer-wrapper" class="footer-wrapper full-width">
        <div id="footer" class="footer max-width row inner clearfix">
          <div id="footer-inner" class="footer-inner inner clearfix">
            <?php print theme('grid_block', $primary_links_tree, 'primary-menu-footer'); ?>
            <?php print $footer; ?>
          </div><!-- /footer-inner -->
        </div><!-- /footer -->
      </div>

    </div><!-- /page-inner -->
  </div><!-- /page -->
  <?php print $closure; ?>
</body>
</html>
