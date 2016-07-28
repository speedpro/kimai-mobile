<?php
/**
 * This file is part of
 * Kimai - Open Source Time Tracking // http://www.kimai.org
 * (c) 2006-2009 Kimai-Development-Team
 *
 * Kimai is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; Version 3, 29 June 2007
 *
 * Kimai is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Kimai; If not, see <http://www.gnu.org/licenses/>.
 */

// ATTENTION: You can change this setting, if you did not install mobile into the Kimai base directory
$basePath = '/../';

// ####################################################################################
// ##### MOBILE APP CODE BELOW - YOU LIKELY DO NOT WANT TO CHANGE CODE AFTER HERE #####
// ####################################################################################

// load translations
$translate = require_once(dirname(__FILE__) . '/language/en.php');

// some configurations for the mobile app
$mobileConfig = array(
	'headerFooterTheme' => 'a',
	'formTheme'         => 'a',
	'errorTheme'        => 'b'
);

/**
 * This file is the "Mobile Kimai interface".
 *
 * @author Kevin Papst
 */
?><!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Kimai</title>
	<link rel="stylesheet" href="//code.jquery.com/mobile/1.3.2/jquery.mobile-1.3.2.min.css" />
	<link rel="stylesheet" href="kimai/kimai.mobile.css" />
	<script src="//code.jquery.com/jquery-1.9.1.min.js"></script>
	<script src="//code.jquery.com/mobile/1.3.2/jquery.mobile-1.3.2.min.js"></script>
	<script src="kimai/kimai.class.js"></script>
	<script src="kimai/kimai.mobile.js"></script>
	<script src="json/json2.js"></script>
	<script src="json/jquery.zend.jsonrpc.js"></script>
	<script>
	$(document).delegate('#loginpage', 'pageinit', function(event, ui){
		<?php
		foreach($translate as $key => $value) {
			echo 'Kimai.addTranslation("'.$key.'", "'.$value.'");'. PHP_EOL;
		}
		?>

		// for debugging purpose
		Kimai.setLogger(KimaiLogger);

		<?php if (isset($basePath) && !empty($basePath)) { ?>
			// Use the manually configured location
			var apiUrl = '<?php echo $basePath; ?>/core/json.php';
		<?php } else { ?>
			// Use the default URL, based on the current location
			var obj = $.mobile.path.parseUrl(location.href);
			var apiUrl = obj.domain + obj.directory + '../core/json.php';
		<?php } ?>

		setApiUrl(apiUrl);

		// check if the Kimai API is reachable
		if (!Kimai.ping()) {
			$.mobile.changePage('#errorPage', {changeHash: false});
		}
	});
	</script>
	<link rel="shortcut icon" href="favicon.ico" />
</head>
<body>
<div data-role="page" id="loginpage">
	<div data-theme="<?php echo $mobileConfig['headerFooterTheme']; ?>" data-role="header" data-position="fixed">
		<h5>Kimai Time Tracking</h5>
	</div>
	<div id="loginForm" data-role="content">
		<h2><?php echo $translate['login_title']; ?></h2>
		<div data-role="fieldcontain">
			<fieldset data-role="controlgroup">
				<label for="username"><?php echo $translate['login_username']; ?></label>
				<input name="username" id="username" autocapitalize="off" autocorrect="off" placeholder="" value="" type="text" />
			</fieldset>
		</div>
		<div data-role="fieldcontain">
			<fieldset data-role="controlgroup">
				<label for="password"><?php echo $translate['login_password']; ?></label>
				<input name="password" id="password" placeholder="" value="" type="password" />
			</fieldset>
		</div>
		<button id="btnLogin" disabled="disabled" data-inline="true" data-icon="star"><?php echo $translate['login_btn']; ?></button>
	</div>
	<div data-theme="<?php echo $mobileConfig['headerFooterTheme']; ?>" data-role="footer" data-position="fixed">
		<h3><a class="backHome" href="http://www.kimai.org/" target="_blank">&copy; Copyright - Kimai Team</a></h3>
	</div>
</div>

<div data-role="page" id="recorderPage">
	<div data-theme="<?php echo $mobileConfig['headerFooterTheme']; ?>" data-role="header" data-position="fixed">
		<h5>Kimai Time Tracking</h5>
	</div>
	<div data-role="content">
		<h2 id="duration"><?php echo $translate['task_title']; ?></h2>
		<div data-role="fieldcontain">
			<fieldset data-role="controlgroup">
				<label for="projects" class="select"><?php echo $translate['choose_project']; ?></label>
				<select name="projects" id="projects"></select>
				<label for="tasks" class="select"><?php echo $translate['choose_task']; ?></label>
				<select name="tasks" id="tasks"></select>
			</fieldset>
		</div>
		<input data-inline="true" type="button" id="recorder" name="recorder" data-icon="check" data-theme="c" value="<?php echo $translate['start']; ?>" />
	</div>
	<div data-theme="<?php echo $mobileConfig['headerFooterTheme']; ?>" data-role="footer" data-position="fixed">
		<h3><a class="backHome" href="http://www.kimai.org/" target="_blank">&copy; Copyright - Kimai Team</a></h3>
	</div>
</div>

<div data-role="page" id="errorPage">
	<div data-theme="<?php echo $mobileConfig['headerFooterTheme']; ?>" data-role="header" data-position="fixed">
		<h5>ERROR - Kimai Time Tracking</h5>
	</div>
	<div data-role="content">
		<h2>Kimai not found</h2>
		<p>Your Kimai installation could not be found, please check the $basePath settings in index.php</p>
		<p>API location is configured to: <span id="jsonUrl"></span></p>
	</div>
	<div data-theme="<?php echo $mobileConfig['headerFooterTheme']; ?>" data-role="footer" data-position="fixed">
		<h3><a class="backHome" href="http://www.kimai.org/" target="_blank">&copy; Copyright - Kimai Team</a></h3>
	</div>
</div>

<div data-role="page" id="dialogPage">
	<div data-theme="<?php echo $mobileConfig['errorTheme']; ?>" data-role="header" id="dialogTitle">
		<h1><?php echo $translate['error']; ?></h1>
	</div>
	<div data-role="content" id="dialogMessage"></div>
</div>
</body>
</html>
