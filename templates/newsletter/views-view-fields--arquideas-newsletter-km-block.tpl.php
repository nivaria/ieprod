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
<table border="0" cellpadding="0" cellspacing="0" style="font-family: Helvetica, Arial, sans-serif;">
  <tr>
    <td valign="top" style="width: 50px;">
      <?php print $fields['picture']->content; ?>
    </td>
    <td valign="top" style="font-family: Helvetica, Arial, sans-serif;">
      <div style="font-size:18px; font-family: Helvetica, Arial, sans-serif;"><a href="<?php print $fields['path']->content; ?>" style="font-family: Helvetica, Arial, sans-serif; color: #000000; text-decoration: none;"><?php print $fields['title']->content; ?></a></div>
      <div style="font-family: Helvetica, Arial, sans-serif; font-size:16px; margin-top: 6px;"><?php print $fields['name']->content; ?></div>
      <div style="font-family: Helvetica, Arial, sans-serif; color: #999999; font-size:14px;"><?php print $fields['created']->content; ?></div>
      <div style="line-height:6px; height: 6px;">&nbsp;</div>
      <div style="font-family: Helvetica, Arial, sans-serif; font-size:16px;"><?php print $fields['teaser']->content; ?></div>
    </td>
  </tr>
</table>