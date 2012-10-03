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

$mobileConfig = array(
    'headerFooterTheme' => 'a',
    'formTheme'         => 'a',
    'errorTheme'        => 'b',
);

$translate = array(
    'login_title'       => 'Please login',
    'login_username'    => 'Username',
    'login_password'    => 'Password',
    'login_btn'         => 'Login',
);


/**
 * This file is the "Mobile Kimai interface".
 *
 * @author Kevin Papst <kpapst@gmx.net>
 */
?><!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Kimai Mobile: Easy mobile Time-Tracking v0.2</title>
    <link rel="stylesheet" href="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.css" />
    <script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
    <script src="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.js"></script>
    <link rel="stylesheet"  href="kimai/kimai.mobile-1.0.css" />
    <script src="kimai/kimai.class.js"></script>
	<script src="kimai/kimai.mobile-1.0.js"></script>
    <script src="json/json2.js"></script>
    <script src="json/jquery.zend.jsonrpc.js"></script>
</head>
<body>

<div data-role="page" id="loginpage">
    <div data-theme="<?php echo $mobileConfig['headerFooterTheme']; ?>" data-role="header" data-position="fixed">
        <h5>
            Kimai Time Tracking
        </h5>
    </div>
    <div id="loginForm" data-role="content">
        <h2>
            Please login
        </h2>
        <div data-role="fieldcontain">
            <fieldset data-role="controlgroup">
                <label for="username">
                    <?php echo $translate['login_username']; ?>
                </label>
                <input name="username" id="username" placeholder="" value="" type="text" />
            </fieldset>
        </div>
        <div data-role="fieldcontain">
            <fieldset data-role="controlgroup">
                <label for="password">
                    <?php echo $translate['login_password']; ?>
                </label>
                <input name="password" id="password" placeholder="" value="" type="password" />
            </fieldset>
        </div>
        <button id="btnLogin" disabled="disabled" data-inline="true" data-icon="alert"><?php echo $translate['login_btn']; ?></button>
    </div>
    <div data-theme="<?php echo $mobileConfig['headerFooterTheme']; ?>" data-role="footer" data-position="fixed">
        <h3>
            <a class="backHome" href="http://www.kimai.org/" target="_blank">&copy; Copyright - Kimai Team</a>
        </h3>
    </div>
</div>

<div data-role="page" id="recorderPage">
    <div data-theme="<?php echo $mobileConfig['headerFooterTheme']; ?>" data-role="header" data-position="fixed">
        <h5>
            Kimai Time Tracking
        </h5>
    </div>
    <div data-role="content">
        <h2 id="duration">
            Please select the task you want to start
        </h2>
        <div data-role="fieldcontain">
            <fieldset data-role="controlgroup">
                <label for="projects" class="select">Choose project:</label>
                <select name="projects" id="projects">

                </select>
            </fieldset>
        </div>
        <div data-role="fieldcontain">
            <fieldset data-role="controlgroup">
                <label for="tasks" class="select">Choose task:</label>
                <select name="tasks" id="tasks">

                </select>
            </fieldset>
        </div>
        <select id="recorder" name="recorder" data-role="slider" data-theme="c">
            <option value="on">Stop</option>
            <option value="off">Start</option>
        </select>
    </div>
    <div data-theme="<?php echo $mobileConfig['headerFooterTheme']; ?>" data-role="footer" data-position="fixed">
        <h3>
            <a class="backHome" href="http://www.kimai.org/" target="_blank">&copy; Copyright - Kimai Team</a>
        </h3>
    </div>
</div>

<div data-role="page" id="dialogPage">
    <div data-theme="<?php echo $mobileConfig['errorTheme']; ?>" data-role="header" id="dialogTitle">
        <h1>Error</h1>
    </div>
    <div data-role="content" id="dialogMessage">

    </div>
</div>

</body>
</html>