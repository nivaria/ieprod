<?php
/**
 * @file views-view-unformatted.tpl.php
 * Default simple view template to display a list of rows.
 *
 * @ingroup views_templates
 */
?>
<table border="0" cellpadding="10" cellspacing="0">
  <tbody>
    <?php foreach ($rows as $id => $row): ?>
      <tr>
        <?php print $row; ?>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>