<?php

/**
 * @file search-result.tpl.php
 * Default theme implementation for displaying a single search result.
 *
 * This template renders a single search result and is collected into
 * search-results.tpl.php. This and the parent template are
 * dependent to one another sharing the markup for definition lists.
 *
 * Available variables:
 * - $url: URL of the result.
 * - $title: Title of the result.
 * - $snippet: A small preview of the result. Does not apply to user searches.
 * - $info: String of all the meta information ready for print. Does not apply
 *   to user searches.
 * - $info_split: Contains same data as $info, split into a keyed array.
 * - $type: The type of search, e.g., "node" or "user".
 *
 * Default keys within $info_split:
 * - $info_split['type']: Node type.
 * - $info_split['user']: Author of the node linked to users profile. Depends
 *   on permission.
 * - $info_split['date']: Last update of the node. Short formatted.
 * - $info_split['comment']: Number of comments output as "% comments", %
 *   being the count. Depends on comment.module.
 * - $info_split['upload']: Number of attachments output as "% attachments", %
 *   being the count. Depends on upload.module.
 *
 * Since $info_split is keyed, a direct print of the item is possible.
 * This array does not apply to user searches so it is recommended to check
 * for their existance before printing. The default keys of 'type', 'user' and
 * 'date' always exist for node searches. Modules may provide other data.
 *
 *   <?php if (isset($info_split['comment'])) : ?>
 *     <span class="info-comment">
 *       <?php print $info_split['comment']; ?>
 *     </span>
 *   <?php endif; ?>
 *
 * To check for all available data within $info_split, use the code below.
 *
 *   <?php print '<pre>'. check_plain(print_r($info_split, 1)) .'</pre>'; ?>
 *
 * @see template_preprocess_search_result()
 */
?>
<li>
  <!-- Project Inscription custom result template -->
  <?php if(isset($result['node']->nid)): ?>
    <div class="project-wrapper">
        <div class="views-field-field-images-project-fid">
            <div class="field-content">
               <?php print nodetype_apachesolr_get_node_image($result['node']->nid); ?> 
            </div>
        </div>
        <div class="project-info">
            <div class="views-field-title">
                <?php print l($title,'node/'.$result['node']->nid,array(
                'attributes' => array(
                   'title' => '',
                   'class' => 'node-'.$result['node']->nid,
                 ),
                )); ?>
            </div>
            <div class="views-field-field-project-type-project-value">
                <?php $prj = node_load($result['node']->nid);
                      if(!empty($prj->field_project_type_project[0]['value'])){
                          $term = taxonomy_get_term($prj->field_project_type_project[0]['value']);
                          if(!empty($term)){
                              print $term->name;
                          }
                      }
                ?>
            </div>
        </div>
        <div class="project-social">
            <span class="views-field-rating-value">
                <?php print nodetype_apachesolr_get_votes_count($result['node']->nid); ?>
            </span>
            <span class="views-field-comment-count">
                <?php print comment_num_all($result['node']->nid); ?>
            </span>
        </div>
        <?php $account = user_load($result['node']->uid); ?>
        <div class="project-owner">
            <span class="views-field-field-image-acp-fid">
                <?php if($account): ?>
                      <?php $picture = $account->picture;
                            if(empty($picture)){
                                $picture = variable_get('user_picture_default', '');
                            }
                      ?>
                      <?php print theme_imagecache('user_picture_meta', $picture, $account->name); ?>
                <?php endif; ?>
            </span>
            <span class="views-field-name">
                <label class="views-label-name"><?php print t('by'); ?></label>
                <?php
                    print l($account->realname,'user/'.$result['node']->uid,array(
                     'attributes' => array(
                        'title' => $account->realname,
                        'class' => 'user-'.$result['node']->uid,
                      ),
                    )); ?>    
            </span>
        </div>
    </div>
  <?php else: ?>
    <h2 class="title">
    <a href="#" title=""><?php print $title; ?></a>
    </h2>
  <?php endif; ?>
</li>
