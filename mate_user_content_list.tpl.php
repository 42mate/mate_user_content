<?php
drupal_add_css(drupal_get_path('module', 'mate_user_content') . '/css/styles.css');
drupal_add_js('https://www.gstatic.com/charts/loader.js');
?>
<script type="text/javascript">
	// Load the Visualization API and the corechart package.
	google.charts.load('current', {'packages':['corechart']});

	// Set a callback to run when the Google Visualization API is loaded.
	google.charts.setOnLoadCallback(drawChart);

	// Callback that creates and populates a data table,
	// instantiates the pie chart, passes in the data and
	// draws it.
	function drawChart() {

		// Create the data table.
		var data = new google.visualization.DataTable();
		data.addColumn('string', 'User');
		data.addColumn('number', 'Posts');
		data.addRows([
    <?php foreach ($users as $u): ?>
			['<?php echo $u->name ?>', <?php echo $u->nodes ?>],
		<?php endforeach ?> 
		]);

		// Set chart options
		var options = {
      'title': '<?php echo t('Post per user') ?>',
			'is3D': true,
			'width': 400,
			'height': 300
    };

		// Instantiate and draw our chart, passing in some options.
		var chart = new google.visualization.PieChart(document.getElementById('google-chart'));
		chart.draw(data, options);
	}
</script>
<div class="content">
  <h1>
    <?php echo t('Content by user between :from AND :until', array(
      ':from' => date('d-m-Y', $from),
      ':until' => date('d-m-Y', $until),
      )
    ); ?>
  </h1>
  <?php
  $form = drupal_get_form('mate_user_content_from_until_form');
  echo drupal_render($form);
  ?>
  <div id="google-chart"></div> 
  <table class="sticky-enabled table-select-processed tableheader-processed sticky-table">
    <thead>
    <th><?php echo t('User'); ?></th>
    <th><?php echo t('Publications'); ?></th>
    <th><?php echo t('Nodes'); ?></th>
    </thead>
    <tbody>
    <?php $total = 0; ?>
    <?php foreach ($users as $u): ?>
      <tr>
        <td>
            <?php echo l(t(empty($u->name) ? 'unknown' : $u->name),
            'admin/user/' . $u->uid . '/content',
            array(
              'attributes' => array('title' => $u->name),
              'query' => array(
                'from' => array('date' => date('Y-m-d', $from)),
                'until' => array('date' => date('Y-m-d', $until)),
              )
            )
          );?>
        </td>
        <td><?php echo $u->nodes; ?></td>
        <td><?php echo $u->content; ?></td>
      </tr>
      <?php $total += $u->nodes; ?>
    <?php endforeach; ?>
    </tbody>
    <tfoot>
    <tr>
      <th><strong></strong></th>
      <th><strong>Total</strong></th>
      <th><strong><?php echo $total; ?></strong></th>
    </tr>
    </tfoot>
  </table>
</div>
