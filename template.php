<?php

/**
 * Breadcrumb themeing
 */
function ieprod_breadcrumb($breadcrumb) {
  if (!empty($breadcrumb)) {
    global $language;

    $html = '';
    $pattern = '/^contest\/\d+\/[a-z_]+$/';
    $match = preg_match($pattern, $_GET[q]);
    if($match==1){
        $arr = explode('/',$_GET[q]);

        $current = '';
        switch($arr[2]){
            case 'canceled':
                $current = t('Canceled');
                break;
            case 'finalists':
                $current = t('Finalists');
                break;
            case 'selectfinal':
                $current = t('Finalists selection');
                break;
            case 'inscripted':
                $current = t('Inscripted');
                break;
            case 'juryvotes':
                $current = t('Jury voting');
                break;
            case 'myvoting':
                $current = t('My voting');
                break;
            case 'payment_pending':
                $current = t('Payment pending');
                break;
            case 'preinscripted':
                $current = t('Pre-inscripted');
                break;
            case 'preselect':
                $current = t('Preselection');
                break;
            case 'publicvotationresults':
                $current = t('Results of public voting');
                break;
            case 'publicvotation':
                $current = t('Public voting');
                break;
            case 'submitted':
                $current = t('Submitted');
                break;
            case 'votingresults':
                $current = t('Voting results');
                break;
            case 'winners':
                $current = t('Winners');
                break;
            case 'selectwinners':
                $current = t('Winners selection');
                break;
            case 'all':
                $current = t('All inscriptions');
                break;
            default:
                break;
        }

        $links = array();
        $links[] = l(t('Home'), '<front>');
        $links[] = l(t('Contest'), 'node/'.$arr[1]);
        $links[] = $current;

        // Set custom breadcrumbs
        drupal_set_breadcrumb($links);

        // Get custom breadcrumbs
        $breadcrumb = drupal_get_breadcrumb();
    }

    $pattern = '/^inscription\/\d+$/';
    $match = preg_match($pattern, $_GET['q']);
    if($match==1){
        $arr = explode('/',$_GET[q]);

        $node = node_load($arr[1]);
        $cnode = node_load($node->field_contest[0]['nid']);
        if(!empty($node) && !empty($cnode)){

            $ctitle = $cnode->title;
            if(!empty($cnode->tnid) && $cnode->tnid!=0){
                $translations = translation_node_get_translations($cnode->tnid);
                if(!empty($translations[$language->language])){
                    $cnode_trans = node_load($translations[$language->language]->nid);
                    if(!empty($cnode_trans)){
                        $ctitle = $cnode_trans->title;
                    }
                }
            }

            $links = array();
            $links[] = l(t('Home'), '<front>');
            $links[] = l($ctitle, 'node/'.$cnode->nid);
            $links[] = $node->title;

            // Set custom breadcrumbs
            drupal_set_breadcrumb($links);

            // Get custom breadcrumbs
            $breadcrumb = drupal_get_breadcrumb();
        }
    }

    $pattern = '/^node\/\d+$/';
    $match = preg_match($pattern, $_GET['q']);
    if($match==1){
        $arr = explode('/',$_GET['q']);
        $node = node_load($arr[1]);
        if($node->type=='news'){
            $links = array();
            $links[] = l(t('Home'), '<front>');
            $links[] = l(t('News'), 'news');
            $links[] = $node->title;

            // Set custom breadcrumbs
            drupal_set_breadcrumb($links);

            // Get custom breadcrumbs
            $breadcrumb = drupal_get_breadcrumb();
        } elseif($node->type=='colaborator'){
            $links = array();
            $links[] = l(t('Home'), '<front>');
            $links[] = l(t('Partners&Co'), 'partners-and-co');
            $links[] = $node->title;

            // Set custom breadcrumbs
            drupal_set_breadcrumb($links);

            // Get custom breadcrumbs
            $breadcrumb = drupal_get_breadcrumb();
        }
        
        if(variable_get('arquideas_solution_mode', FALSE)){
           if($node->type==='group'){
               $result = db_query("SELECT nid FROM {content_type_contest} WHERE field_contest_related_group_nid = %d", $node->nid);
               $row = db_fetch_array($result);
               
               if(!empty($row['nid'])){
                   $links = array();
                   $links[] = l(t('Home'), '<front>');
                   $links[] = l(t('Competition'), 'node/'.$row['nid']);
                   $links[] = t('Discussions');
               
                  // Set custom breadcrumbs
                  drupal_set_breadcrumb($links);

                  // Get custom breadcrumbs
                  $breadcrumb = drupal_get_breadcrumb();
               }    
           } 
        }
    }

    if (count($breadcrumb) > 1) {
        $html .= '<div class="breadcrumb">'. implode(' &gt; ', $breadcrumb) .'</div>';
    }
    return $html;
  }
}

/**
 * Page preprocessing
 */
function ieprod_preprocess_page(&$vars)
{
  // Format the footer message
  // We do this here instead of in page.tpl.php because
  // we need a formatted message to pass along to the
  // same theme function as the $footer in order to have
  // them nested together
  if (isset($vars['footer_message']) && strlen($vars['footer_message'])) {
    $markup = '';
    $markup .= '<div id="footer-message" class="footer-message">';
    $markup .= '<div id="footer-message-inner" class="footer-message-inner inner">';
    $markup .= $vars['footer_message'];
    $markup .= '</div><!-- /footer-message-inner -->';
    $markup .= '</div><!-- /footer-message -->';
    $vars['footer_message'] = $markup;
  }
  $arr_types_og = og_get_types('group');
  if(isset($vars['node']) && in_array($vars['node']->type,$arr_types_og)){
      $vars['tabs'] = '';
      if($vars['body_id']==='pid-node-'.$vars['node']->nid.'-edit'){
          $vars['is_edit'] = TRUE;
      } else {
          $vars['is_edit'] = FALSE;
      }
  }

  //PREPROCESS INTRANET CONTEST's PAGES
  $match = preg_match('/^pid\-contest\-\d+\-/', $vars['body_id']);
  if($match==1){
      $vars['tabs'] = _contest_construct_administrative_tabs($vars['body_id']);
      $vars['content_top'] = _contest_show_short_info($vars['body_id']);
      $vars['page_classes'] = ' page-full-view';
  }

  $match = preg_match('/^pid\-user\-\d+\-edit$/', $vars['body_id']);
  if($match==1 && !user_access('administer site configuration')){
      $vars['tabs'] = '';
  }

  //Checks if we stay on user page
  $pattern = '/^user\/\d+\//';
  $res = preg_match($pattern, $_GET['q']);
  if($res==1){
     $arr = explode('/', $_GET['q']);
     $m_uid = is_numeric($arr[1])?intval($arr[1]):0;
     $vars['account'] = user_load(array('uid' => $m_uid));
  }
  $pattern = '/^user\/\d+$/';
  $res = preg_match($pattern, $_GET['q']);
  if($res==1){
     $arr = explode('/', $_GET['q']);
     $m_uid = is_numeric($arr[1])?intval($arr[1]):0;
     $vars['account'] = user_load(array('uid' => $m_uid));
  }
  $pattern = '/^user\/\d+\/edit/';
  $res = preg_match($pattern, $_GET['q']);
  if($res==1){
      $vars['is_edit'] = TRUE;
  } else {
      $vars['is_edit'] = FALSE;
  }

  if(isset($vars['account'])){
    $patterns = _arquideas_generic_get_user_pages_patterns($vars['account']->name);
    foreach($patterns as $pkey=>$pattern1){
        $match = preg_match($pattern1, $vars['body_id']);
        $match1 = preg_match('/^user\/\d+$/', $_GET['q']);
        if($match==1 || $match1==1){
            $vars['tabs'] = _arquideas_generic_construct_user_tabs($vars['body_id'],$vars['account']);
            break;
        }
    }
  }

  if (isset($vars['node'])) {
   // If the node type is "blog" the template suggestion will be "page-blog.tpl.php".
   $vars['template_files'][] = 'page-'. str_replace('_', '-', $vars['node']->type);
  }

  if(isset($vars['template_files'])){
      foreach($vars['template_files'] as $tpl){
          if(strpos($tpl,'page-user-')!==FALSE){
              $arr = explode('-', $tpl);
              if(count($arr)>2 && is_numeric($arr[2])){
                  $cuid = intval($arr[2]);
                  $cuser = user_load($cuid);
                  if(empty($cuser->profile_name) || empty($cuser->profile_last_name)){
                     profile_load_profile($cuser);
                  }
                  if(!empty($cuser->profile_name) && !empty($cuser->profile_last_name)){
                      $vars['title'] = $cuser->profile_name.' '.$cuser->profile_last_name;
                  }
                  break;
              }
          }
      }
  }

  //Contest Page Preprocess
  if(isset($vars['node']) && $vars['node']->type=='contest'){
      if(!$vars['is_edit']){
        $vars['title'] = '';
      }
      $vars['page_classes'] = ' page-group';
      $qt_name = 'quicktabs_contest_open';
      if(isset($vars['node']->field_contest_state)){
          if(intval($vars['node']->field_contest_state[0]['value'])===ContestState::OPEN){
              if(isset($vars['node']->field_registration_limit_date[0]['value2'])){
                jquery_countdown_add('.field-registration-limit-date #jquery-countdown', array(
                    'until' => $vars['node']->field_registration_limit_date[0]['value2'],
                    'format' => 'dHM',
                    'expiryText' => t('<span>Inscription finished</span>'),
                    'serverSync' => 'serverTime',
                ));
                jquery_countdown_add('.field-registration-limit-date #jquery-countdown-1', array(
                    'until' => $vars['node']->field_registration_limit_date[0]['value2'],
                    'format' => 'dHM',
                    'serverSync' => 'serverTime',
                ));
              }
              if(isset($vars['node']->field_early_registration[0]['value2'])){
                jquery_countdown_add('.field-early-registration #jquery-countdown', array(
                    'until' => $vars['node']->field_early_registration[0]['value2'],
                    'format' => 'dHM',
                    'serverSync' => 'serverTime',
                ));
              }
              if(isset($vars['node']->field_delivery_limit_date[0]['value'])){
                jquery_countdown_add('.field-delivery-limit-date #jquery-countdown', array(
                    'until' => $vars['node']->field_delivery_limit_date[0]['value'],
                    'format' => 'dHM',
                    'serverSync' => 'serverTime',
                ));
              }
          }
          if(intval($vars['node']->field_contest_state[0]['value'])===ContestState::FINISHED){
              $qt_name = 'quicktabs_contest_closed';
          }
      }
      $quicktabs = quicktabs_load($qt_name);
      $vars['contest_quicktab'] = theme('quicktabs', $quicktabs);
      $vars['template_files'][] = 'page';
  }

  //PREPROCESS INSCRIPTION PAGE
  $pattern = '/^user\/\d+\/account\/inscriptions\/\d+$/';
  $res = preg_match($pattern, $_GET['q']);
  if($res==1){
      /*$vars['template_files'][] = 'page';
      $vars['title'] = '';
      $vars['sidebar_first'] = '';*/
  }
  if(isset($vars['node']) && $vars['node']->type=='inscription'){
      $vars['title'] = '';
      $vars['sidebar_first'] = '';
  }

  //PREPROCESS PROJECT PAGE
  if(isset($vars['node']) && $vars['node']->type=='project'){
      $vars['title'] = '';
      $vars['sidebar_first'] = '';
  }

  // Reconstruct CSS and JS variables.
  $vars['css'] = drupal_add_css();
  $vars['styles'] = drupal_get_css();
  $vars['scripts'] = drupal_get_js();

  //PREPROCESS COLABORATOR PAGE
  if(isset($vars['node']) && $vars['node']->type=='colaborator'){
      if(!$vars['is_edit']){
        $vars['title'] = '';
      }
  }

  //ADDITIONAL PREPROCESS FOR USER PAGES
  // Set grid info & row widths
  $grid_name = substr(theme_get_setting('theme_grid'), 0, 7);
  $grid_type = substr(theme_get_setting('theme_grid'), 7);
  $grid_width = (int)substr($grid_name, 4, 2);

  if(preg_match('/^user\/\d+\/account\/edit$/', $_GET['q'])==1){
      $vars['main_group_width'] = $grid_name . $grid_width.' forms_user';
      $vars['content_group_width'] = $grid_name .'12 force_width';
  }
  if(preg_match('/^user\/\d+\/content$/', $_GET['q'])==1 ||
     preg_match('/^user\/\d+\/projects$/', $_GET['q'])==1 ||
     preg_match('/^user\/\d+\/account\/projects$/', $_GET['q'])==1 ||
     preg_match('/^user\/\d+\/account\/inscriptions$/', $_GET['q'])==1 ||
     preg_match('/^user\/\d+\/account\/arquideasbook$/', $_GET['q'])==1){
      $vars['main_group_width'] = $grid_name . $grid_width.' force_width border';
      $vars['content_group_width'] = $grid_name .'12 force_width';
  }
  if(preg_match('/^user\/\d+$/', $_GET['q'])==1){
      $vars['body_classes'] .= ' entrada-ficha';
      $vars['main_group_width'] = $grid_name . '12 force_width border';
      $vars['content_group_width'] = $grid_name .'12 force_width';
  }
  //ADDITIONAL PREPROCESS FOR NETWORK
  if(preg_match('/^arquideas_network$/', $_GET['q'])==1){
      $vars['body_classes'] .= ' area-comunidad comunidad';
  }
  if(preg_match('/^users$/', $_GET['q'])==1){
      $vars['body_classes'] .= '  area-comunidad usuarios';
  }
  
  $vars['show_breadcrumb'] = TRUE;
  //Hide breadcrumbs for some specified pages
  if($_GET['q']=='opened-contests'){
      $vars['show_breadcrumb'] = FALSE;
  }
  if($_GET['q']=='arquideas_network'){
      $vars['show_breadcrumb'] = FALSE;
  }
  if (preg_match('/^solr_nodetype\//',$_GET['q']) == 1) {
      $vars['show_breadcrumb'] = FALSE;
  }
  if (preg_match('/^solr_nodetype_multi\//',$_GET['q']) == 1) {
      $vars['show_breadcrumb'] = FALSE;
  }
  //Some additional variables for solution
  if(variable_get('arquideas_solution_mode', FALSE)){
    $m_code = '<div class="arquideas-solution-logo">'.theme_image(drupal_get_path('theme',$GLOBALS['theme']).'/images/solution/arquideas-solution.png',t('Arquideas Solution'),t('Arquideas Solution')).'</div>';
      
    $vars['header_top'] = $m_code . $vars['header_top'];
    $vars['header_top_following'] = $m_code . $vars['header_top_following'];

    $imageurl = drupal_get_path('theme',$GLOBALS['theme']).'/images/solution/managed-by-arquideas.png';
    $imagehtml = theme_image($imageurl,t('Managed by Arquideas'),t('Managed by Arquideas'));
    $loptions = array(
      'attributes' => array(
        'class' => 'managed-by-arquideas',
        'title' => t('Managed by Arquideas'),
        'target'=>'_blank',  
      ),
      'html' => TRUE,  
    );

    $m_managed = '<div class="arquideas-managed-logo">';
    $m_managed .= l($imagehtml,"http://www.arquideas.net",$loptions);
    $m_managed .= '</div>';
    
    $vars['footer'] = $m_managed . $vars['footer'];
  }
}

/**
 * Node preprocessing
 */
function ieprod_preprocess_node(&$vars) {
  global $user;  
    
  // Add node_right region content
  $vars['node_right'] = theme('blocks', 'node_right');

  //PREPROCESS CONTEST NODE
  if(isset($vars['type']) && $vars['type']=='contest'){
      $qt_name = 'quicktabs_contest_open';
      if(isset($vars['field_contest_state'])){
          if(intval($vars['field_contest_state'][0]['value'])===ContestState::OPEN){
              $vars['template_files'][] = 'node-contest-open';
          }
          if(intval($vars['field_contest_state'][0]['value'])>=ContestState::PRIZE){
              $qt_name = 'quicktabs_contest_closed';
          }
      }
      $quicktabs = quicktabs_load($qt_name);
      $vars['contest_quicktab'] = theme('quicktabs', $quicktabs);
      if(isset($vars['links'])){
          unset($vars['links']);
      }
  }

  $arr_types_og = og_get_types('group');
  if(isset($vars['node']) && in_array($vars['node']->type,$arr_types_og)){
      if($_GET['q']=='node/'.$vars['nid'].'/edit'){
          $vars['is_edit'] = TRUE;
      } else {
          $vars['is_edit'] = FALSE;
      }
  }

  //PREPROCESS INSCRIPTION NODE
  if(isset($vars['node']) && $vars['node']->type=='inscription'){
      $vars['picture'] = '';
      $cnid = $vars['node']->field_contest[0]['nid'];
      $cnode = node_load($cnid);
      $cnode_trans = NULL;
      if(!empty($cnode->tnid) && $cnode->tnid!=0){
          $translations = translation_node_get_translations($cnode->tnid);
          if(!empty($translations[$user->language])){
              $cnode_trans = node_load($translations[$user->language]->nid);
          }
      }

      if($cnode){
          $vars['contest'] = $cnode;
          if(!empty($cnode_trans)){
              $vars['contest_translation'] = $cnode_trans;
              $vars['contest_title'] = $cnode_trans->title;
              $vars['field_contest_image'] = $cnode_trans->field_contest_image;
          } else {
              $vars['contest_title'] = $cnode->title;
              $vars['field_contest_image'] = $cnode->field_contest_image;
          }
          $vars['inscription_mission'] = $vars['node']->content['og_mission']['#value'];
      }

      $pattern = '/^inscription\/\d+$/';
      $match = preg_match($pattern, $_GET['q']);
      if($match==1){
          $vars['template_files'][] = 'node-inscription-public';
      }

      $members = contest_notifications_get_group_members($vars['node']);
      $vars['num_members'] = count($members);

      if(count($members)>1){
          $vars['node_classes'] .= ' only-groups';
      }
  }


  //PREPROCESS WEBFORM NODE
  if(isset($vars['type']) && $vars['type']=='webform'){
      $vars['submitted'] = '';
      if(isset($vars['links'])){
          unset($vars['links']);
      }
  }

  //PREPROCESS GROUP NODE (KM)
  if(isset($vars['type']) && $vars['type']=='group'){
      if(isset($vars['links'])){
          unset($vars['links']);
      }
      $vars['group_attributes_rendered'] = '';
      $vars['back_to_contest'] = arquideas_generic_back_to_contest_link($vars['nid']);
  }

  //PREPROCESS PROJECT NODE
  if(isset($vars['node']) && $vars['node']->type=='project'){
      if($_GET['q']=='node/'.$vars['nid'].'/edit'){
          $vars['is_edit'] = TRUE;
      } else {
          $vars['is_edit'] = FALSE;
      }
  }

  //PREPROCESS NEWSLETTER ISSUE NODE
  if(isset($vars['node']) && $vars['node']->type=='simplenews'){
      if($_GET['q']=='node/'.$vars['nid'].'/edit'){
          $vars['is_edit'] = TRUE;
      } else {
          $vars['is_edit'] = FALSE;
      }

      $generaltid = variable_get('nivaria_contests_base_newslettertid', 0);

      $node = $vars['node'];

      $vars['general_newsletter'] = FALSE;
      if(isset($node->taxonomy[$generaltid]) && $node->taxonomy[$generaltid]->tid == $generaltid){
          $vars['general_newsletter'] = TRUE;
      }

  }
}


/**
 * Profile preprocessing
 */
function ieprod_preprocess_user_profile_item(&$vars) {
  // Separate userpoints value from the edit links
  if ($vars['title'] == 'Points') {
    $userpoints = explode(' - ', $vars['value']);
    $vars['value'] = '<span class="points">' . $userpoints[0] . '</span><span class="edit-links">' . $userpoints[1] . '</span>';
    unset($vars['title']);
  }
}

/**
 * Implementation of theme_shoutbox_post()
 */
function ieprod_shoutbox_post($shout, $links = array(), $alter_row_color=TRUE) {
  global $user;

  // Gather moderation links
  if ($links) {
    foreach ($links as $link) {
      $linkattributes = $link['linkattributes'];
      $link_html = '<img src="'. $link['img'] .'"  width="'. $link['img_width'] .'" height="'. $link['img_height'] .'" alt="'. $link['title'] .'" class="shoutbox-imglink"/>';
      $link_url = 'shout/'. $shout->shout_id .'/'. $link['action'];
      $img_links = l($link_html, $link_url, array('html' => TRUE, 'query' => array('destination' => drupal_get_path_alias($_GET['q'])))) . $img_links;
    }
  }

  // Generate user name with link
  $user_name = shoutbox_get_user_link($shout);

  // Generate title attribute
  $title = t('Posted !date at !time by !name', array('!date' => format_date($shout->created, 'custom', 'm/d/y'), '!time' => format_date($shout->created, 'custom', 'h:ia'), '!name' => $shout->nick));

  // Add to the shout classes
  $shout_classes = array();
  $shout_classes[] = 'shoutbox-msg';

  // Check for moderation
  if ($shout->moderate == 1) {
    $shout_classes[] = 'shoutbox-unpublished';
    $approval_message = '&nbsp;(' . t('This shout is waiting for approval by a moderator.') . ')';
  }

  // Check for specific user class
  $user_classes = array();
  $user_classes[] = 'shoutbox-user-name';
  if ($shout->uid == $user->uid) {
    $user_classes[] = 'shoutbox-current-user-name';
  }
  else if ($shout->uid == 0) {
    $user_classes[] = 'shoutbox-anonymous-user';
  }

  // Load user image and format
  $author_picture ='';
  $shout_author =  user_load($shout->uid);
  if (!$shout_author->picture && variable_get('user_picture_default', '')) {
    $shout_author->picture = variable_get('user_picture_default', '');
  }
  if ($shout_author->picture) {
    $author_picture = theme_imagecache('user_picture_meta', $shout_author->picture, $shout_author->name, $shout_author->name);
  }

  // Time format
  $format = variable_get('shoutbox_time_format', 'ago');
  switch ($format) {
    case 'ago';
      $submitted =  t('!interval ago', array('!interval' => format_interval(time() - $shout->created)));
      break;
    case 'small':
    case 'medium':
    case 'large':
      $submitted = format_date($shout->created, $format);
      break;
  }

  // Build the post
  $post = '';
  $post .= '<div class="' . implode(' ', $shout_classes) . '" title="' . $title . '">';
  $post .= '<div class="shoutbox-admin-links">' . $img_links . '</div>';
  $post .= '<div class="shoutbox-post-info">' . $author_picture;
  $post .= '<span class="shoutbox-user-name ' . implode(' ', $user_classes) . '">'. $user_name . '</span>';
  $post .= '<span class="shoutbox-msg-time">' . $submitted . '</span>';
  $post .= '</div>';
  $post .= '<div class="shout-message">' . $shout->shout . $approval_message . '</div>';
  $post .= '</div>' . "\n";

  return $post;
}

function ieprod_item_list($items = array(), $title = NULL, $type = 'ul', $attributes = NULL) {
  $output = '<div class="item-list">';
  if (isset($title)) {
    $output .= '<h3>'. $title .'</h3>';
  }

  if(isset($attributes['class']) && $attributes['class']=='pager'){
      $match = preg_match('/^contest\/\d+\//', $_GET['q']);
      if($match==1){
        $items_per_page_override = ($_GET['items-per-page'] > 0) ? $_GET['items-per-page'] : 15;
        $output .=  '<div class="items-per-page-selector"><strong>'.t('Show').'</strong> <select>';
        $output .=  '<option value="5"'.(($items_per_page_override == 5) ? ' selected="selected"' : '').'>5</option>';
        $output .=  '<option value="10"'.(($items_per_page_override == 10) ? ' selected="selected"' : '').'>10</option>';
        $output .=  '<option value="15"'.(($items_per_page_override == 15) ? ' selected="selected"' : '').'>15</option>';
        $output .=  '<option value="20"'.(($items_per_page_override == 20) ? ' selected="selected"' : '').'>20</option>';
        $output .=  '<option value="50"'.(($items_per_page_override == 50) ? ' selected="selected"' : '').'>50</option>';
        $output .=  '<option value="100"'.(($items_per_page_override == 100) ? ' selected="selected"' : '').'>100</option>';
        $output .=  '<option value="200"'.(($items_per_page_override == 200) ? ' selected="selected"' : '').'>200</option>';
        $output .=  '<option value="99999"'.(($items_per_page_override == 99999) ? ' selected="selected"' : '').'>'.t('All').'</option>';
        $output .=  '</select></div>';
      }
  }

  if (!empty($items)) {
    $output .= "<$type". drupal_attributes($attributes) .'>';
    $num_items = count($items);
    $c = $num_items;
    foreach ($items as $i => $item) {
    $c--;
      $attributes = array();
      $children = array();
      if (is_array($item)) {
        foreach ($item as $key => $value) {
          if ($key == 'data') {
            $data = $value;
          }
          elseif ($key == 'children') {
            $children = $value;
          }
          else {
            $attributes[$key] = $value;
          }
        }
      }
      else {
         $data = $item;
      }

      if (!is_numeric($i)) {
        if (count($children) > 0) {
          $data .= theme_item_list($children, NULL, $type, $attributes); // Render nested list
        }
        if ($c == $num_items - 1) {
          $attributes['class'] = empty($attributes['class']) ? 'first' : ($attributes['class'] .' first');
        }
        if ($c == 0) {
          $attributes['class'] = empty($attributes['class']) ? 'last' : ($attributes['class'] .' last');
        }

        $attributes['class'] .= ' ' . ($c % 2 ? 'even' : 'odd');
        $output .= '<li'. drupal_attributes($attributes) .'>'. $data ."</li>\n";
      }
      else {
        if (count($children) > 0) {
          $data .= theme_item_list($children, NULL, $type, $attributes); // Render nested list
        }
        if ($i == 0) {
          $attributes['class'] = empty($attributes['class']) ? 'first' : ($attributes['class'] .' first');
        }
        if ($i == $num_items - 1) {
          $attributes['class'] = empty($attributes['class']) ? 'last' : ($attributes['class'] .' last');
        }

        $attributes['class'] .= ' ' . ($i % 2 ? 'even' : 'odd');
        $output .= '<li'. drupal_attributes($attributes) .'>'. $data ."</li>\n";
      }
    }

    $output .= "<$type>";
  }
  $output .= '</div>';
  return $output;
}

function ieprod_preprocess_block($variables) {
  global $user;
  $variables['template_files'][] = 'block-'.$variables['block']->region.'-'.$variables['block']->module;
  $variables['template_files'][] = 'block-'.$variables['block']->region.'-'.$variables['block']->module.'-'.$variables['block']->delta;
  if(isset($variables['block'])){
      //Change the header login block
      if($variables['block']->module=='commons_core' && $variables['block']->delta=='header_login'){
          if(module_exists('ajax_register')){
            $variables['block']->content = t('!login Or !register', array(
                '!login' => l(t('Login'), 'ajax_register/login',array(
                    'attributes' => array(
                        'class' => 'thickbox',
                    ),
                )),
                '!register' => l(t('Register'), 'ajax_register/register',array(
                    'attributes' => array(
                        'class' => 'thickbox',
                    ),
                )),
            ));
          } else {
            $variables['block']->content = t('Already a member? !login', array('!login' => l(t('Login'), 'user')));
          }
      }
      //Superheader menu block
      if($variables['block']->module=='menu' && $variables['block']->delta=='menu-menu-superheader'){
          $variables['block']->subject = '';
          $arrElem = explode('</li>',$variables['block']->content);
          if(count($arrElem)>0){
              foreach($arrElem as $key => $elem){
                  if($user->uid==0){
                      $pattern1 = '/<a href="(\/[a-z]{2})?\/user"/';
                      $pattern2 = '/<a href="(\/[a-z]{2})?\/logout"/';
                      $match1 = preg_match($pattern1, $elem);
                      $match2 = preg_match($pattern2, $elem);
                      if($match1==1 || $match2==1){
                          unset($arrElem[$key]);
                      }
                  } else {
                      $pattern1 = '/<a href="(\/[a-z]{2})?\/ajax_register\/login"/';
                      $pattern2 = '/<a href="(\/[a-z]{2})?\/ajax_register\/register"/';
                      $match1 = preg_match($pattern1, $elem);
                      $match2 = preg_match($pattern2, $elem);
                      if($match1==1 || $match2==1){
                          unset($arrElem[$key]);
                      }
                  }
              }
          }
          $variables['block']->content = implode('</li>',$arrElem);
      }

      //Superheader left menu block
      if($variables['block']->module=='menu' && $variables['block']->delta=='menu-menu-superheader-left'){
          $variables['block']->subject = '';
      }

      //Site Follow block
      if($variables['block']->module=='follow' && $variables['block']->delta=='site'){
          $variables['block']->subject = '';
      }

      //Language switcher
      if($variables['block']->module=='locale' && $variables['block']->delta==0){
          $variables['block']->subject = '';
      }

      //Group Quick Tabs
      if($variables['block']->module=='quicktabs' && $variables['block']->delta=='arqnetwork_group_quicktabs'){
          $obj = menu_get_object('node',4);
          if(empty($obj)){
              $obj = menu_get_object('node',1);
          }
          if(!empty($obj) && og_is_group_type($obj->type)){
            if($obj->type=='inscription'){
                $variables['block']->subject = t('Team wall');
                $variables['block']->subtitle = t('What you share on this wall will only be visible for your team');
            } else { 
                $variables['block']->subject = t('Wall of %s',array('%s'=>$obj->title));
            }    
          }
      }
      //Powered by block
      if($variables['block']->module=='powered_by_nivaria' && $variables['block']->delta==0){
         if(variable_get('arquideas_solution_mode', FALSE)){
             $imageurl = variable_get('niv_project_by_img', NULL);
             $imagenew = drupal_get_path('theme',$GLOBALS['theme']).'/images/solution/solution-by-arquideas-nivaria.png';
             $variables['block']->content = str_replace($imageurl, $imagenew, $variables['block']->content);
             $variables['block']->content = preg_replace('/width="\d+"/', '', $variables['block']->content);
             $variables['block']->content = preg_replace('/height="\d+"/', '', $variables['block']->content);
         } 
      }
  }
}

function ieprod_search_theme_form($form) {
	$form['search_theme_form']['#value']= t('Project, study, contest...');
	$form['submit']['#type'] = 'image_button';
	$form['submit']['#src'] = drupal_get_path('theme', 'arquideasprod') . '/images/search_icon.png';
	$form['submit']['#attributes']['class'] = 'btn';
	return '<div id="search" class="container-inline">' . drupal_render($form) . '</div>';
}

function ieprod_preprocess_search_block_form(&$vars, $hook) {
  // Modify elements of the search form
  unset($vars['form']['search_block_form']['#title']);

  // Set a default value for the search box
  $vars['form']['search_block_form']['#value'] = t('Project, study, contest...');

  // Add a custom class to the search box
  // Set yourtheme.css > #search-block-form .form-text { color: #888888; }
  $vars['form']['search_block_form']['#attributes'] = array(
     'onblur' => "if (this.value == '') {this.value = '".$vars['form']['search_block_form']['#value']."';} this.style.color = '#888888';",
     'onfocus' => "if (this.value == '".$vars['form']['search_block_form']['#value']."') {this.value = '';} this.style.color = '#000000';" );

  // Modify elements of the submit button
  unset($vars['form']['submit']);

  // Change text on the submit button
  //$vars['form']['submit']['#value'] = t('Go!');

  // Change submit button into image button - NOTE: '#src' leading '/' automatically added
  $vars['form']['submit']['image_button'] = array('#type' => 'image_button', '#src' => drupal_get_path('theme', 'arquideasprod') . '/images/search_icon.png');

  // Rebuild the rendered version (search form only, rest remains unchanged)
  unset($vars['form']['search_block_form']['#printed']);
  $vars['search']['search_block_form'] = drupal_render($vars['form']['search_block_form']);

  // Rebuild the rendered version (submit button, rest remains unchanged)
  unset($vars['form']['submit']['#printed']);
  $vars['search']['submit'] = drupal_render($vars['form']['submit']);

  // Collect all form elements to print entire form
  $vars['search_form'] = implode($vars['search']);
}

function ieprod_commons_core_info_block() {
  $content = '';

  $content .= '<div id="acquia-footer-message">';

  $content .= '<a href="http://acquia.com/drupalcommons" title="' . t('Commons social business software') . '">';
  $content .= theme('image', 'profiles/drupal_commons/images/commons_droplet.png', t('Commons social business software'), t('Commons social business software'));
  $content .= '</a>';
  $content .= '<span>';
  $content .= t('A !dc Community, powered by', array('!dc' => l(t('Commons'), 'http://acquia.com/drupalcommons', array('attributes' => array('title' => t('A Commons social business software')))))) . '&nbsp;';
  $content .= l(t('Acquia'), 'http://acquia.com', array('attributes' => array('title' => t('Acquia'))));
  $content .= '</span>';
  $content .= '</div>';

  $content .= '<div id="fusion-footer-message">';
  $content .= t('Theme by') . '&nbsp;';
  $content .= '<a href="http://www.brightlemon.com" title="' . t('Drupal Themes by BrightLemon') . '">' . t('BrightLemon') . '</a>';
  $content .= ', ' . t('powered by') . '&nbsp;';
  $content .= '<a href="http://fusiondrupalthemes.com" title="' . t('Premium Drupal themes powered by Fusion') . '">' . t('Fusion') . '</a>.';
  $content .= '</div>';

  return $content;
}

//hide links and change page title
function ieprod_taxonomy_term_page($tids, $result) {
  $str_tids = arg(2);
  $terms = taxonomy_terms_parse_string($str_tids);
  $title_result = db_query(db_rewrite_sql('SELECT t.tid, t.name FROM {term_data} t WHERE t.tid IN ('. db_placeholders($terms['tids']) .')', 't', 'tid'), $terms['tids']);
  $title_tids = array(); // we rebuild the $tids-array so it only contains terms the user has access to.
  $names = array();
  while ($term = db_fetch_object($title_result)) {
    $title_tids[] = $term->tid;
    $names[] = $term->name;
  }
  $last_name = array_pop($names);
  if (count($names) == 0) {
    $title = t("Pages containing '@tag'", array('@tag' => $last_name));
  } elseif ($terms['operator'] == "or") {
      $title = t("Pages containing '@tags or @last_tag'", array('@tags' => implode(", ", $names), '@last_tag' => $last_name));
  } else {
      $title = t("Pages containing '@tags and @last_tag'", array('@tags' => implode(", ", $names), '@last_tag' => $last_name));
  }
  drupal_set_title($title);

  drupal_add_css(drupal_get_path('module', 'taxonomy') .'/taxonomy.css');

  $output = '';

  // Only display the description if we have a single term, to avoid clutter and confusion.
  if (count($tids) == 1) {
    $term = taxonomy_get_term($tids[0]);
    $description = $term->description;

    // Check that a description is set.
    if (!empty($description)) {
      $output .= '<div class="taxonomy-term-description">';
      $output .= filter_xss_admin($description);
      $output .= '</div>';
    }
  }

  $output .= commons_connect_taxonomy_render_nodes($result);

  return $output;
}

function ieprod_taxonomy_render_nodes($result) {
  $output = '';
  $has_rows = FALSE;
  while ($node = db_fetch_object($result)) {
    $output .= node_view(node_load($node->nid), TRUE, FALSE, FALSE);
    $has_rows = TRUE;
  }
  if ($has_rows) {
    $output .= theme('pager', NULL, variable_get('default_nodes_main', 10), 0);
  }
  else {
    $output .= '<p>'. t('There are currently no posts in this category.') .'</p>';
  }
  return $output;
}

// call scripts
drupal_add_js(path_to_theme() . '/scripts/clear_default_searchbox_text.js', 'theme'); // call on every page since search box is displayed everywhere


/**
 * Present a node submission form.
 *
 * @ingroup themeable
 */
function ieprod_node_form($form) {
  $output = "\n<div class=\"node-form\">\n";

  // Admin form fields and submit buttons must be rendered first, because
  // they need to go to the bottom of the form, and so should not be part of
  // the catch-all call to drupal_render().
  $admin = '';
  if (isset($form['author'])) {
    $admin .= "    <div class=\"authored\">\n";
    $admin .= drupal_render($form['author']);
    $admin .= "    </div>\n";
  }
  if (isset($form['options'])) {
    $admin .= "    <div class=\"options\">\n";
    $admin .= drupal_render($form['options']);
    $admin .= "    </div>\n";
  }
  $buttons = drupal_render($form['buttons']);

  // Everything else gets rendered here, and is displayed before the admin form
  // field and the submit buttons.
  if(isset($form['body_field'])){
      $form['body_field']['#weight'] = 0;
  }


  $form['group_relations']['#access'] = FALSE;

  if(!empty($form['group_relations'])){
      foreach($form['group_relations'] as $grelkey => $grelval){
          if(strpos($grelkey,'#')===FALSE){
              if($grelkey==='field_related_node'){
                  $grelval['#weight'] = -2.4;
              } else if($grelkey==='field_link'){
                  $grelval['#weight'] = -2.3;
              } else {
                  $grelval['#weight'] = -2.2;
              }
              $form[$grelkey] = $grelval;
          }
      }
  }

  //Getting personal data
  if(isset($form['group_personal_data'])){
      $form['group_personal_data']['#access'] = FALSE;
  }
  //Getting contact data
  if(isset($form['group_contact_data'])){
      $form['group_contact_data']['#access'] = FALSE;
  }
  //Getting professional data
  if(isset($form['group_profesional_data'])){
      $form['group_profesional_data']['#access'] = FALSE;
  }
  //Getting social networks data
  if(isset($form['group_network_profiles'])){
      $form['group_network_profiles']['#access'] = FALSE;
  }
  //Getting datos de proyecto
  if(isset($form['group_project_data'])){
      $form['group_project_data']['#access'] = FALSE;
      if(isset($form['vertical_tabs']['#attached']['js'][0]['data']['verticalTabs']['group_project_data'])){
          unset($form['vertical_tabs']['#attached']['js'][0]['data']['verticalTabs']['group_project_data']);
      }
  }
  //Getting tipo de proyecto
  if(isset($form['group_project_type'])){
      $form['group_project_type']['#access'] = FALSE;
      if(isset($form['vertical_tabs']['#attached']['js'][0]['data']['verticalTabs']['group_project_type'])){
          unset($form['vertical_tabs']['#attached']['js'][0]['data']['verticalTabs']['group_project_type']);
      }
  }
  //Getting additional data of proyecto
  if(isset($form['group_additional_data'])){
      $form['group_additional_data']['#access'] = FALSE;
      if(isset($form['vertical_tabs']['#attached']['js'][0]['data']['verticalTabs']['group_additional_data'])){
          unset($form['vertical_tabs']['#attached']['js'][0]['data']['verticalTabs']['group_additional_data']);
      }
  }
  if(isset($form['markup_title'])){
      $form['markup_title']['#access'] = FALSE;
  }
  if(isset($form['markup_contest_code'])){
      $form['markup_contest_code']['#access'] = FALSE;
  }
  if(isset($form['markup_visibility_fields'])){
      $form['markup_visibility_fields']['#access'] = FALSE;
  }

  $output .= "  <div class=\"standard\">\n";
  $output .= drupal_render($form);
  $output .= "  </div>\n";

  $output1 = '';
  if(isset($form['group_personal_data'])){
    $form['group_personal_data']['#access'] = TRUE;
    $output1 .= "  <div class=\"personal-data\">\n";
    $output1 .= drupal_render($form['group_personal_data']);
    $output1 .= "  </div>\n";
  }
  if(isset($form['group_contact_data'])){
    $form['group_contact_data']['#access'] = TRUE;
    $output1 .= "  <div class=\"contact-data\">\n";
    $output1 .= drupal_render($form['group_contact_data']);
    $output1 .= "  </div>\n";
  }
  if(isset($form['group_profesional_data'])){
    $form['group_profesional_data']['#access'] = TRUE;
    $output1 .= "  <div class=\"profesional-data\">\n";
    $output1 .= drupal_render($form['group_profesional_data']);
    $output1 .= "  </div>\n";
  }
  if(isset($form['group_network_profiles'])){
    $form['group_network_profiles']['#access'] = TRUE;
    $output1 .= "  <div class=\"socialnetworks-data\">\n";
    $output1 .= drupal_render($form['group_network_profiles']);
    $output1 .= "  </div>\n";
  }
  if(isset($form['markup_title'])){
    $form['markup_title']['#access'] = TRUE;
    $output1 .= drupal_render($form['markup_title']);
  }
  if(isset($form['markup_contest_code'])){
    $form['markup_contest_code']['#access'] = TRUE;
    $output1 .= drupal_render($form['markup_contest_code']);
  }
  if(isset($form['markup_visibility_fields'])){
    $form['markup_visibility_fields']['#access'] = TRUE;
    $output1 .= drupal_render($form['markup_visibility_fields']);
  }
  if(isset($form['group_project_data'])){
    $form['group_project_data']['#access'] = TRUE;
    $form['group_project_data']['#attributes']['class'] = 'group-data-project';
    $output1 .= "  <div class=\"data-project\">\n";
    $output1 .= drupal_render($form['group_project_data']);
    $output1 .= "  </div>\n";
  }
  if(isset($form['group_project_type'])){
    $form['group_project_type']['#access'] = TRUE;
    $form['group_project_type']['#attributes']['class'] = 'group-type-project';
    $output1 .= "  <div class=\"type-project\">\n";
    $output1 .= drupal_render($form['group_project_type']);
    $output1 .= "  </div>\n";
  }
  if(isset($form['group_additional_data'])){
    $form['group_additional_data']['#access'] = TRUE;
    $form['group_additional_data']['#attributes']['class'] = 'group-additional-data-project';
    $output1 .= "  <div class=\"additional-data-project\">\n";
    $output1 .= drupal_render($form['group_additional_data']);
    $output1 .= "  </div>\n";
  }

  $output = $output1.$output;

  if (!empty($admin)) {
    $output .= "  <div class=\"admin\">\n";
    $output .= $admin;
    $output .= "  </div>\n";
  }
  $output .= $buttons;
  $output .= "</div>\n";

  return $output;
}

function ieprod_preprocess_mimemail_message(&$variables) {
  global $base_url;
  $logo = theme_get_setting('logo');
  if (strpos($logo, 'http') === 0) {
    $variables['logo'] = $logo;
  } else {
    $variables['logo'] = $base_url . $logo;
  }
  
  $variables['slogan'] = t('The architecture and design ideas community');
  $variables['front_page'] = url();

}

function ieprod_username($user, $link = TRUE) {
  if ($object->uid && function_exists('profile_load_profile')) {
    profile_load_profile($user);
  }
  if (isset($user->profile_name)) {
    $name = $user->profile_name . ' ' . $user->profile_last_name;
  }
  else if (isset($user->name)) {
    $name = $user->name;
  }
  else {
    $name = variable_get('anonymous', 'Anonymous');
    $link = FALSE;
  }
  if ($link && user_access('access user profiles')) {
    return l($name, 'user/' . $user->uid, array('title' => t('View user profile.')));
  }
  else {
    return check_plain($name);
  }
}

/**
 * Format a query pager.
 *
 * Menu callbacks that display paged query results should call theme('pager') to
 * retrieve a pager control so that users can view other results.
 * Format a list of nearby pages with additional query results.
 *
 * @param $tags
 *   An array of labels for the controls in the pager.
 * @param $limit
 *   The number of query results to display per page.
 * @param $element
 *   An optional integer to distinguish between multiple pagers on one page.
 * @param $parameters
 *   An associative array of query string parameters to append to the pager links.
 * @param $quantity
 *   The number of pages in the list.
 * @return
 *   An HTML string that generates the query pager.
 *
 * @ingroup themeable
 */
function ieprod_pager($tags = array(), $limit = 10, $element = 0, $parameters = array(), $quantity = 9) {
  global $pager_page_array, $pager_total;

  // Calculate various markers within this pager piece:
  // Middle is used to "center" pages around the current page.
  $pager_middle = ceil($quantity / 2);
  // current is the page we are currently paged to
  $pager_current = $pager_page_array[$element] + 1;
  // first is the first page listed by this pager piece (re quantity)
  $pager_first = $pager_current - $pager_middle + 1;
  // last is the last page listed by this pager piece (re quantity)
  $pager_last = $pager_current + $quantity - $pager_middle;
  // max is the maximum page number
  $pager_max = $pager_total[$element];
  // End of marker calculations.

  // Prepare for generation loop.
  $i = $pager_first;
  if ($pager_last > $pager_max) {
    // Adjust "center" if at end of query.
    $i = $i + ($pager_max - $pager_last);
    $pager_last = $pager_max;
  }
  if ($i <= 0) {
    // Adjust "center" if at start of query.
    $pager_last = $pager_last + (1 - $i);
    $i = 1;
  }
  // End of generation loop preparation.

  $li_first = theme('pager_first', (isset($tags[0]) ? $tags[0] : t('« first')), $limit, $element, $parameters);
  $li_previous = theme('pager_previous', (isset($tags[1]) ? $tags[1] : '<<'), $limit, $element, 1, $parameters);
  $li_next = theme('pager_next', (isset($tags[3]) ? $tags[3] : '>>'), $limit, $element, 1, $parameters);
  $li_last = theme('pager_last', (isset($tags[4]) ? $tags[4] : t('last »')), $limit, $element, $parameters);

  if ($pager_total[$element] > 1) {
    if ($li_first) {
      $items[] = array(
        'class' => 'pager-first',
        'data' => $li_first,
      );
    }
    if ($li_previous) {
      $items[] = array(
        'class' => 'pager-previous',
        'data' => $li_previous,
      );
    }

    // When there is more than one page, create the pager list.
    if ($i != $pager_max) {
      if ($i > 1) {
        $items[] = array(
          'class' => 'pager-ellipsis',
          'data' => '…',
        );
      }
      $first = TRUE;
      // Now generate the actual pager piece.
      for (; $i <= $pager_last && $i <= $pager_max; $i++) {
        if ($i < $pager_current) {
          $items[] = array(
            'class' => 'pager-item pager-number',
            'data' => theme('pager_previous', $i, $limit, $element, ($pager_current - $i), $parameters),
          );
        }
        if ($i == $pager_current) {
          $items[] = array(
            'class' => 'pager-current pager-number',
            'data' => $i,
          );
        }
        if ($i > $pager_current) {
          $items[] = array(
            'class' => 'pager-item pager-number',
            'data' => theme('pager_next', $i, $limit, $element, ($i - $pager_current), $parameters),
          );
        }
        if ($first) {
          $items[sizeof($items) - 1]['class'] .= ' pager-number-first';
	  $first = FALSE;
        }
      }
      if ($i < $pager_max) {
        $items[] = array(
          'class' => 'pager-ellipsis',
          'data' => '…',
        );
      }
    }
    $items[sizeof($items) - 1]['class'] .= ' pager-number-last';
    // End generation.
    if ($li_next) {
      $items[] = array(
        'class' => 'pager-next',
        'data' => $li_next,
      );
    }
    if ($li_last) {
      $items[] = array(
        'class' => 'pager-last',
        'data' => $li_last,
      );
    }
    return theme('item_list', $items, NULL, 'ul', array('class' => 'pager'));
  }
}

function ieprod_commons_profile_image_action_links_block($picture, $links, $account) {
  $content = '';
  $pops = array();

  if(count($links)>0){
      $pops['budges_gll'] = array_pop($links);
      if(count($links)>0){
          $pops['points_gll'] = array_pop($links);
      }
  }

  $links['drafts'] = array(
      'href' => 'mycontent/drafts',
      'title' => t('My drafts'),
  );

  if(isset($pops['points_gll'])){
      $links['points_gll'] = $pops['points_gll'];
  }
  if(isset($pops['budges_gll'])){
      $links['budges_gll'] = $pops['budges_gll'];
  }

  // Add the picture
  $content .= $picture;

  // Add the links
  $content .= theme('links', $links);

  return $content;
}

/**
 * theme function to provide a more link
 * @param $vid - vocab id for which more link is wanted
 * @ingroup themable
 */
function ieprod_tagadelic_more($vid) {
  return "";
}

function ieprod_jcalendar_view($node) {
  $output = node_view($node, TRUE);
  $output .= '<div id="nodelink">'. l(t('more', array(), $node->language), calendar_get_node_link($node), array(
        'attributes' => array(
            'title' => t('more', array(), $node->language),
        ),
      )) .'</div>';
  return $output;
}

/**
 *  Theme from/to date combination on form.
 */
function ieprod_date_combo($element) {
  $field = content_fields($element['#field_name'], $element['#type_name']);
  if (!$field['todate']) {
    return $element['#children'];
  }

  // Group from/to items together in fieldset.
  $fieldset = array(
    '#title' => check_plain($element['#title']) .' '. ($element['#delta'] > 0 ? intval($element['#delta'] + 1) : ''),
    '#value' => $element['#children'],
    '#collapsible' => FALSE,
    '#collapsed' => FALSE,
    '#description' => $element['#fieldset_description'],
    '#attributes' => array(),
  );
  return theme('fieldset', $fieldset);
}

/**
 * Preprocess function so ContentProfile is shown and linked as user
 * @param type $vars 
 */
function ieprod_preprocess_search_result(&$vars) {
    if ($vars['result']['node']->type == 'arquideas_content_profile') {
        $vars['info'] = t('User');
        $vars['url'] = url('user/' . $vars['result']['node']->uid);
    }
}
/**
 * Comment preprocessing
 */
function ieprod_preprocess_comment(&$vars) {
  // Picture
  if (theme_get_setting('toggle_comment_user_picture')) {
    $account = user_load(array('uid' => $vars['comment']->uid));
    $m_picture = isset($account->picture)?$account->picture:NULL;
    if (!$m_picture && (variable_get('user_picture_default', '') != '')) {
      $m_picture = variable_get('user_picture_default', '');
    }
    
    if ($m_picture) { 
      $picture = theme_imagecache('image_40_40', $m_picture, $vars['comment']->name, $vars['comment']->name);
      if (user_access('access user profiles')) {
        $vars['comment']->picture = l($picture, "user/{$vars['comment']->uid}", array('html' => TRUE));
      }
      else {
        $vars['comment']->picture = $picture; 
      }
    }
  }
}

/**
 * Ubercart preprocessing
 */
function ieprod_preprocess_uc_order(&$vars) {
  $order = $vars['order'];
  $inscription = node_load($order->data['inscription_nid']);
  $vars['code'] = $inscription->field_inscription_code[0]['value'];
}


//Register some texts
t('Press enter or click !plus between tags.', array('!plus' => '\'+\''));
t('What\'s on your mind?');
t('Write something...');
t('Group inscription');
t('Hi');




