<?php
/**
 * @file views-view-fields.tpl.php
 * Default simple view template to all the fields as a row.
 *
 * - $view: The view in use.
 * - $fields: an array of $field objects. Each one contains:
 *   - $field->content: The output of the field.
 *   - $field->raw: The raw data for the field, if it exists. This is NOT output safe.
 *   - $field->class: The safe class id to use.
 *   - $field->handler: The Views field handler object controlling this field. Do not use
 *     var_export to dump this object, as it can't handle the recursion.
 *   - $field->inline: Whether or not the field should be inline.
 *   - $field->inline_html: either div or span based on the above flag.
 *   - $field->separator: an optional separator that may appear before a field.
 * - $row: The raw result object from the query, with all data it fetched.
 *
 * @ingroup views_templates
 */
?>
<table border="0" cellpadding="0" cellspacing="0" width="580" style="background: #000000; text-align: center;">
  <tr>
    <td>
      <?php print $fields['field_contest_image_fid']->content; ?>
    </td>
  </tr>
  <tr>
    <td style="font-size:24px; text-transform: uppercase; font-weight: bold; padding-top:10px; padding-bottom:7px;"><a href="<?php print $fields['path']->content; ?>" style="color: #ffffff; text-decoration: none; font-family: Helvetica, Arial, sans-serif;"><?php print $fields['title']->content; ?></a></td>
  </tr>
  <tr>
    <td style="padding-bottom:7px; font-size:15px; color: #ffffff; font-family: Helvetica, Arial, sans-serif;"><?php print $fields['field_contest_subtitle_value']->content; ?></td>
  </tr>
  <tr>
    <td style="padding-bottom:10px; font-size:15px; font-style: italic; font-family: Helvetica, Arial, sans-serif;"><?php print $fields['view_node']->content; ?></td>
  </tr>
</table>