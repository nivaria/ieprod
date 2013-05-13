<?php
// $Id: node-project.tpl.php 7510
  $fields = content_types($node->type);
  if (!empty($fields) && !empty($fields['fields'])) {?>
    <!-- Fields of <?php print $node->type ?>:
    <?php foreach ($fields['fields'] as $field) {
      print $field['field_name'];?>

    <?php }?>
        -->
<?php }?>
<div id="node-<?php print $node->nid; ?>" class="node display-project <?php print $node_classes; ?>">
  <div class="inner">
    <?php /*print $picture*/ ?>

    <?php if ($page == 0): ?>
    <h2 class="title"><a href="<?php print $node_url ?>" title="<?php print $title ?>"><?php print $title ?></a></h2>
    <?php endif; ?>


    <!-- ADDTHIS widget -->
    <?php
        $block = module_invoke('arquideas_generic', 'block', 'view', '13');
        print $block['content'];
    ?>
    <!-- END ADDTHIS widget -->
    <div class="clearfix">&nbsp;</div>

    <?php if(!$is_edit && $page == 1): ?>
    <?php print l(t('Go Back'),'',array(
        'attributes' => array(
            'title' => t('Go Back'),
            'onclick' => 'history.go(-1);return false;',
            'class' => 'go-back',
        ),
        'fragment' => ' ',
        'external' => TRUE,
    )); ?>
    <?php if ($links): ?>
        <div class="links top">
        <?php print $links; ?>
        </div>
    <?php endif; ?>
    <div class="project-info-public">
        <div class="col01">
            <!-- Project TITLE-->
            <h2 class="title">
            <?php print $title; ?>
            </h2>
            <!-- End Project TITLE-->
	    <!-- FiveStar Widget -->
            <?php
            if (user_access('rate content') && fivestar_validate_target('node', $node->nid)) {
                print fivestar_widget_form($node);
            }
            ?>
            <!-- END FiveStar Widget -->
            <!-- Project SUBTITLE -->
            <h3 class="subtitle">
                <?php print $field_subtitle_project_rendered; ?>
                <!-- Taxonomy terms -->
                <?php if ($terms): ?>
                    <div class="terms">
                    <?php print $terms; ?>
                    </div>
                <?php endif;?>
                <!-- End Taxonomy terms -->
            </h3>
            <!-- End Project SUBTITLE -->
            
            <!-- User Picture -->
            <div class="userpicture">
            <?php
                $account = user_load($node->uid);
                $userpicture = '';
                $username = !empty($account->realname)?$account->realname:$account->name;
                if(!empty($account->picture)){
                    $userpicture = theme_imagecache('user_picture_meta', $account->picture, $username);
                } else {
                    $picture = variable_get('user_picture_default', '');
                    if(!empty($picture)){
                       $userpicture = theme_imagecache('user_picture_meta', $picture, $username);
                    }
                }
            ?>
            <?php if(!empty($userpicture)): ?>
                <?php print l($userpicture,'user/'.$account->uid,array(
                    'attributes' => array(
                        'title' => $username,
                    ),
                    'html' => TRUE,
                )); ?>
            <?php endif; ?>    
            </div>
            <!-- End User Picture -->
            
            <!-- Project Type -->
            <div class="project-type">
                <span class="label">
                    <?php print t('Project type').': '; ?>
                </span>
                <span class="value">
                    <?php print $field_project_type_project_rendered ?>
                </span>
            </div>
            <!-- End Project Type -->

          

            <!-- Description of Project -->
            <div class="project-body">
                <?php print $field_body_project_rendered ?>
            </div>
            <!-- END Description of Project -->

            <!-- DOWNLOAD files -->
            <?php print $field_documents_project_rendered ?>
            <!-- End DOWNLOAD files -->

        </div>
        <div class="col02">
            <!-- Inscription IMAGES -->
            <?php $preset = variable_get('nivaria_contests_base_jpgpreset', 'Featured');
            print get_project_images($node, TRUE, FALSE, $preset); ?>
            <!-- End Inscription IMAGES -->
        </div>
        <div class="clearfix">&nbsp;</div>
    </div>
    <?php endif; ?>


    <?php if ($node_top && !$teaser): ?>
    <div id="node-top" class="node-top row nested">
      <div id="node-top-inner" class="node-top-inner inner">
        <?php print $node_top; ?>
      </div><!-- /node-top-inner -->
    </div><!-- /node-top -->
    <?php endif; ?>

    <?php if (FALSE && $submitted): ?>
    <div class="meta">
      <span class="submitted"><?php print $submitted ?></span>
    </div>
    <?php endif; ?>

    <!-- Edit link -->
    <?php if(isset($node->content['nivaria_edit_content_link']) && !empty($node->content['nivaria_edit_content_link']['#value'])): ?>
    <div class="node-edit-link">
        <?php print $node->content['nivaria_edit_content_link']['#value']; ?>
    </div>
    <?php endif; ?>
    <!-- End Edit link -->

    <!-- Translate link -->
    <?php if(isset($node->content['nivaria_translate_content_link']) && !empty($node->content['nivaria_translate_content_link']['#value'])): ?>
    <div class="node-translate-link">
        <?php print $node->content['nivaria_translate_content_link']['#value']; ?>
    </div>
    <?php endif; ?>
    <!-- End Translate link -->

      </div><!-- /inner -->

  <?php if ($node_bottom && !$teaser): ?>
  <div id="node-bottom" class="node-bottom row nested">
    <div id="node-bottom-inner" class="node-bottom-inner inner">
      <?php print $node_bottom; ?>
    </div><!-- /node-bottom-inner -->
  </div><!-- /node-bottom -->
  <?php endif; ?>
</div><!-- /node-<?php print $node->nid; ?> -->
<?