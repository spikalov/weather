<?php
$placement = $_REQUEST['PLACEMENT'];
$placementOptions = isset($_REQUEST['PLACEMENT_OPTIONS']) ? json_decode($_REQUEST['PLACEMENT_OPTIONS'], true) : array();

if (!is_array($placementOptions)) {
	$placementOptions = array();
}

if ($placement === 'DEFAULT') {
	$placementOptions['MODE'] = 'edit';
}
?>
<!DOCTYPE html>
<html>

<head>
	<script src="//api.bitrix24.com/api/v1/dev/"></script>
</head>

<body style="margin: 0; padding: 0; background-color: <?= $placementOptions['MODE'] === 'edit' ? '#fff' : '#f9fafb' ?>;">
	<div class="workarea">
		<?
		if ($placement === 'DEFAULT') :
		?>
			<ul>
				<li><a href="javascript:void(0)" onclick="field.add()">userfieldtype.add</a></li>
			</ul>
			<pre id="debug" style="border: solid 1px #aaa; padding: 10px; background-color: #eee">&nbsp;</pre>
			<script>
				var filed = {
					call: function(method, param) {
						BX24.callMethod(method, param, filed.debug);
					},

					debug: function(result) {
						var s = '';

						s += '<b>' + result.query.method + '</b>\n';
						s += JSON.stringify(result.query.data, null, '  ') + '\n\n';

						if (result.error()) {
							s += '<span style="color: red">Error! ' + result.error().getStatus() + ': ' + result.error().toString() + '</span>\n';
						} else {
							s += '<span>' + JSON.stringify(result.data(), null, '  ') + '</span>\n';
						}

						document.getElementById('debug').innerHTML = s;
					},

					add: function() {
						filed.call('userfieldtype.add', {
							USER_TYPE_ID: 'weather',
							HANDLER: 'https://sell-us.pro/clients/test/weather/',
							TITLE: 'weather',
							DESCRIPTION: 'weather'
						});
					}
				}
			</script>
		<?
		elseif ($placement === 'USERFIELD_TYPE') :
			require_once __DIR__ . '/index.php';
		endif;
		?>
	</div>
	<script>
		BX24.ready(function() {
			BX24.init(function() {
				BX24.resizeWindow(document.body.clientWidth,
					document.getElementsByClassName("workarea")[0].clientHeight);
			})
		});
	</script>

</body>

</html>