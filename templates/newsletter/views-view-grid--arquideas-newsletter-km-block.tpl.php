<?php
/**
 * @file views-view-grid.tpl.php
 * Default simple view template to display a rows in a grid.
 *
 * - $rows contains a nested array of rows. Each row contains an array of
 *   columns.
 * - $class contains the class of the table.
 * - $attributes contains other attributes for the table.
 * @ingroup views_templates
 */
?>
<table cellpadding="10" width="580">
  <tbody>
    <?php foreach ($rows as $row_number => $columns): ?>
      <tr>
        <?php foreach ($columns as $column_number => $item): ?>
          <td style="width:50%;" valign="top">
            <?php print $item; ?>
          </td>
        <?php endforeach; ?>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>