<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to CodeIgniter</title>

	<style type="text/css">

	::selection{ background-color: #E13300; color: white; }
	::moz-selection{ background-color: #E13300; color: white; }
	::webkit-selection{ background-color: #E13300; color: white; }

	body {
		background-color: #fff;
		margin: 40px;
		font: 13px/20px normal Helvetica, Arial, sans-serif;
		color: #4F5155;
	}

	a {
		color: #003399;
		background-color: transparent;
		font-weight: normal;
	}

	h1 {
		color: #444;
		background-color: transparent;
		border-bottom: 1px solid #D0D0D0;
		font-size: 19px;
		font-weight: normal;
		margin: 0 0 14px 0;
		padding: 14px 15px 10px 15px;
	}

	code {
		font-family: Consolas, Monaco, Courier New, Courier, monospace;
		font-size: 12px;
		background-color: #f9f9f9;
		border: 1px solid #D0D0D0;
		color: #002166;
		display: block;
		margin: 14px 0 14px 0;
		padding: 12px 10px 12px 10px;
	}

	#body{
		margin: 0 15px 0 15px;
	}
	
	p.footer{
		text-align: right;
		font-size: 11px;
		border-top: 1px solid #D0D0D0;
		line-height: 32px;
		padding: 0 10px 0 10px;
		margin: 20px 0 0 0;
	}
	
	#container{
		margin: 10px;
		border: 1px solid #D0D0D0;
		-webkit-box-shadow: 0 0 8px #D0D0D0;
	}




	/* menu wrapper */
	.menu-wrapper {
		display: block;
	}

	/* all levels */
	.menu-wrapper ul {
		margin: 0;
		padding: 0;
		list-style: none;
	}

	.menu-wrapper li {
		float: left;
		position: relative;
		background-color: #f9f9f9;
		z-index: 99;
	}

	.menu-wrapper a {
		display: block;
		padding: 5px;
		border: 1px solid #D0D0D0;
		color: #002166;
	}

	/* level 1 */
	#menu {
		display: inline-block;
		zoom: 1;
		*display: inline;
	}

	#menu > li { }

	#menu > li > a { }

	/* level 2+ */
	#menu ul {
		position: absolute;
		left: 0;
		width: 200px;
		display: none;
	}

	#menu ul li {
		float: none;
	}

	/* level 3+ */
	#menu ul ul {
		top: 0;
		left: 200px;
	}

	#menu ul ul li { }

	/* display sub menu on rollover (immediate ul only) */
	#menu li:hover > ul {
		display: block;
	}

	/* highlight li on rollover */
	#menu li:hover {
		background-color: #D0D0D0;
	}

	/* current page */
	#menu .menu-item-current > a {
		background-color: #D0D0D0;
	}

	/* ancestor of current page */
	#menu .menu-item-parent > a,
	#menu .menu-item-ancestor > a {
		color: #E13300;
	}

	/* top level item has sub menu */
	#menu > li.item-has-children > a {
		border-bottom-color: #002166;
	}

	/* level 2+ has sub menu */
	#menu ul li.item-has-children > a {
		border-right-color: #002166;
	}
	</style>
</head>
<body>

<div id="container">
	<h1>Welcome to CodeIgniter!</h1>

	<?php echo $menu; ?>

	<div id="body">
		<p>The page you are looking at is being generated dynamically by CodeIgniter.</p>

		<p>If you would like to edit this page you'll find it located at:</p>
		<code>application/views/welcome_message.php</code>

		<p>The corresponding controller for this page is found at:</p>
		<code>application/controllers/welcome.php</code>

		<p>If you are exploring CodeIgniter for the very first time, you should start by reading the <a href="user_guide/">User Guide</a>.</p>
	</div>

	<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds. <?php echo  (ENVIRONMENT == 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?></p>
</div>

</body>
</html>