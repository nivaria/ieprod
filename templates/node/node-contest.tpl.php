<?php
// $Id: node.tpl.php 7510 2010-06-15 19:09:36Z sheena $
?>

<div id="node-<?php print $node->nid; ?>" class="node <?php print $node_classes; ?>">
  <div class="inner">
    <div id="contest-banner">
      <!-- IMAGE -->
      <?php if(isset($field_detail_image_contest[0]['filepath']) && !$is_edit){
              $preset = variable_get('nivaria_contests_base_preset_contest_closed', 'Featured');
              print theme_imagecache($preset, $field_detail_image_contest[0]['filepath'], $title);
          }
      ?>
      <!-- END IMAGE -->

      <div class="contest-titles">
        <!-- TITLE -->
        <?php if ($page == 0): ?>
        <h2 class="title"><a href="<?php print $node_url ?>" title="<?php print $title ?>"><?php print $title ?></a></h2>
        <?php endif; ?>
        <?php if ($page == 1): ?>
        <h1 class="title"><?php print $title; ?></h1>
        <?php endif; ?>
        <!-- END TITLE -->

        <!-- TAG LINE -->
        <?php if(isset($field_contest_tagline[0]['value']) && !$is_edit): ?>
        <div class="contest-tagline">
            <?php print $field_contest_tagline[0]['value']; ?>
        </div>
        <?php endif; ?>
        <!-- END TAG LINE -->
      </div>

      <div class="content-stats">
        <!-- NUMBER OF TEAMS -->
        <?php if(!$is_edit): ?>
        <div class="number-teams">
            <div class="label">
                <?php print t('Number of teams participated'); ?>
            </div>
            <div class="count">
                <?php print getTeamsCount($node); ?>
            </div>
        </div>
        <?php endif; ?>
        <!-- END NUMBER OF TEAMS -->
        <!-- TWITTER HASH TAG -->
        <?php if(isset($field_contest_twitter_hashtag[0]['value']) && !$is_edit): ?>
        <div class="contest-twitter-hashtag">
            <?php if(_twitterfield_is_hashtag($field_contest_twitter_hashtag[0]['value'])){
                $url_part = 'search?q=' . rawurlencode($field_contest_twitter_hashtag[0]['value']);
                print l($field_contest_twitter_hashtag[0]['value'], 'http://twitter.com/' . $url_part, array('attributes' => array('class' => 'twitterfield_twitter_link')));
            } else {
                print $field_contest_twitter_hashtag[0]['value'];
            }
            ?>
        </div>
        <?php endif; ?>
        <!-- END TWITTER HASH TAG -->
      </div>

      <div class="contest-state-wrapper">
        <!-- CONTEST STATE -->
        <?php if(isset($field_contest_state[0]['value']) && !$is_edit): ?>
        <div class="contest-state">
            <?php print getContestStateName(intval($field_contest_state[0]['value'])); ?>
        </div>
        <?php endif; ?>
        <!-- END CONTEST STATE -->

        <!-- Public Votation Link -->
        <?php if(!$is_edit): ?>
            <?php global $user;
            if($node->field_contest_state[0]['value']==ContestState::PUBLIC_CONTEST && $user->uid!=0){
                print l('<span>'.t('Vote your favorite').'</span>','contest/'.$node->nid.'/publicvotation',array(
                    'attributes' => array(
                        'title' => t('Vote your favorite'),
                        'class' => 'public-votation-link',
                    ),
                    'html' => TRUE,
                ));
            } ?>
        <?php endif; ?>
        <!-- End Public Votation Link -->
      </div>

      <div class="clearfix">&nbsp;</div>

      <!-- Edit Button -->
      <?php if(!$is_edit): ?>
          <?php if(node_access('update', $node)){
              print l('<span>'.t('Edit').'</span>','node/'.$node->nid.'/edit',array(
                  'attributes' => array(
                      'title' => t('Edit'),
                      'class' => 'edit-content-link',
                      'style' => 'top: 16px; right: 16px;',
                  ),
                  'html' => TRUE,
              ));
          } ?>
      <?php endif; ?>
      <!-- End Edit Button -->
      <div class="social-corner">
        <!-- FOLLOWERS NUMBER -->
        <?php if(!$is_edit) print showNumContestFollowers($node); ?>
        <!-- END FOLLOWERS NUMBER -->

        
        <!-- FOLLOW OR LEAVE BUTTON -->
        <?php if(!$is_edit) print showContestSuscribeLink($node); ?>
        <!-- END FOLLOW OR LEAVE BUTTON -->
      </div>
    </div>

    <?php if ($node_top && !$teaser): ?>
    <div id="node-top" class="node-top row nested">
      <div id="node-top-inner" class="node-top-inner inner">
        <?php print $node_top; ?>
      </div><!-- /node-top-inner -->
    </div><!-- /node-top -->
    <?php endif; ?>

    <?php if ($submitted): ?>
    <div class="meta">
      <span class="submitted"><?php print $submitted ?></span>
    </div>
    <?php endif; ?>

    <?php if ($terms): ?>
    <div class="terms">
      <?php print $terms; ?>
    </div>
    <?php endif;?>

    <div class="content clearfix<?php print ($node_right && !$teaser?' node-right':''); ?>">
        <div class="node-content-main">
            <?php
                /* QUICK TABS */
                if(!$is_edit && isset($contest_quicktab)){
                    print $contest_quicktab;
                }
                /* END QUICK TABS */
                $content = str_replace($body, '', $content);
                print $content;
            ?>
        </div>
        <?php if ($node_right && !$teaser): ?>
        <div class="node-right">
            <div class="node-right-inner inner">
              <!-- SHARE SOCIAL BLOCK -->
              <?php
                  $block = module_invoke('arquideas_generic', 'block', 'view', '13');
                  print '<div id="block-arquideas_generic-13">'.$block['content'].'</div>';
              ?>
              <!-- END SHARE SOCIAL BLOCK -->
              <?php print $node_right; ?>
            </div><!-- /node-right-inner -->
        </div><!-- /node-right -->
        <?php endif; ?>
    </div>

    <!-- Translate link -->
    <?php if(isset($node->content['nivaria_translate_content_link']) && !empty($node->content['nivaria_translate_content_link']['#value'])): ?>
    <div class="node-translate-link">
        <?php print $node->content['nivaria_translate_content_link']['#value']; ?>
    </div>
    <?php endif; ?>
    <!-- End Translate link -->

    <!-- Mark Highlighted in Newsletter -->
    <?php if(user_access(PERM_ADMIN_CONTESTS)) : ?>
    <div class="link-highlight-arquideas-newsletter">
        <?php print flag_create_link('newsletter', $node->nid); ?>
    </div>
    <?php endif; ?>
    <!-- End Mark Highlighted in Newsletter -->


    <?php if ($links): ?>
    <div class="links">
      <?php print $links; ?>
    </div>
    <?php endif; ?>



  </div><!-- /inner -->

  <?php if ($node_bottom && !$teaser): ?>
  <div id="node-bottom" class="node-bottom row nested">
    <div id="node-bottom-inner" class="node-bottom-inner inner">
      <?php print $node_bottom; ?>
    </div><!-- /node-bottom-inner -->
  </div><!-- /node-bottom -->
  <?php endif; ?>
</div><!-- /node-<?php print $node->nid; ?> -->
