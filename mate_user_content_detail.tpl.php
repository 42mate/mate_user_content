<div class="content">
  <h1><?php
     echo t('Content published by :user between :from AND :until', array(
      ':user' => $username,
      ':from' => date('d-m-Y', strtotime($from['date'])),
      ':until' => date('d-m-Y', strtotime($until['date'])),
    ));
  ?></h1>
  <?php
    $form = drupal_get_form('mate_user_content_from_until_form');
    echo drupal_render($form);
  ?>
  <table class="sticky-enabled table-select-processed tableheader-processed sticky-table">
    <thead>
    <th><?php echo t('Title'); ?></th>
    <th><?php echo t('Created'); ?></th>
    <th><?php echo t('Modified'); ?></th>
    <th><?php echo t('Status'); ?></th>
    </thead>
    <tbody>
    <?php foreach ($nodes as $n): ?>
      <tr>
        <td><?php echo l(t($n->title), "node/$n->nid", array('attributes' => array('title' => $n->title, 'target' => '_blank'))); ?></td>
        <td><?php echo date('d-m-Y', $n->created); ?></td>
        <td><?php echo date('d-m-Y', $n->changed); ?></td>
        <td><?php echo t(($n->status) ? 'Published' : 'Not Published'); ?></td>
      </tr>
    <?php endforeach; ?>
    </tbody>
    <tfoot>
    <tr>
      <th colspan="4" style="text-align: center">
        <?php
          echo (($GLOBALS['pager_page_array'][0] + 1) <= 1
              ? '1'
              : ($GLOBALS['pager_page_array'][0] + 1) * $GLOBALS['pager_limits'][0] - $GLOBALS['pager_limits'][0] + 1)
            . ' - '
            . (count($nodes) < $GLOBALS['pager_limits'][0]
              ? ($GLOBALS['pager_page_array'][0] + 1) * $GLOBALS['pager_limits'][0] - $GLOBALS['pager_limits'][0] + count($nodes)
              : (($GLOBALS['pager_page_array'][0] + 1) <= 1
                ? $GLOBALS['pager_limits'][0]
                : ($GLOBALS['pager_page_array'][0] + 1) * $GLOBALS['pager_limits'][0]))
            . ' '
            . t('of') . ' ' . $GLOBALS['pager_total_items'][0];
        ?>
      </th>
    </tr>
    </tfoot>
  </table>

  <?php
    echo theme('pager', array(
      'quantity' => count($nodes),
      'parameters' => array(
        'from' => $from,
        'until' => $until,
      ),
    ));
  ?>
</div>
