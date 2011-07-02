<?php if(!isset($isAjax) || $isAjax == false) { ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8"/>
	<link rel="stylesheet" type="text/css" href="<?php echo $baseUrl; ?>css/framework.css"/>
	<link rel="stylesheet" href="<?php echo $baseUrl; ?>style.css"/>
	<link rel="stylesheet" type="text/css" href="<?php echo $baseUrl; ?>css/formbuilder.css"/>	
	<link rel="stylesheet" type="text/css" href="<?php echo $baseUrl; ?>css/style.css"/>
	<script type="text/javascript">var baseUrl = "<?php echo $baseUrl; ?>";</script>
	<script type="text/javascript" language="javascript" src="<?php echo $baseUrl; ?>scripts/jquery1.4.2.min.js"></script>
	<script type="text/javascript" language="javascript" src="<?php echo $baseUrl; ?>scripts/main.js"></script>
	
	<?php include_once($viewDir . 'framework/javascript.php'); ?>
	<?php include_once($viewDir . 'framework/stylesheet.php'); ?>
	<title>PPI framework | Open Source PHP Framework</title>
	
</head>

<body>
		<header>
			<div id="nav-wrapper">
				<nav>
					<ul>
						<li>Welcome, <?php echo $bIsLoggedIn ? $authInfo['first_name'] . ' ' . $authInfo['last_name'] : 'guest'; ?></li>
						<?php if(!$isLoggedIn) { ?>
						<li><a href="<?php echo $baseUrl; ?>user/register">Register</a></li>
						<?php } ?>						
						<li><a href="<?php echo $baseUrl . ($bIsLoggedIn ? 'user/logout' : 'user/login'); ?>"><?php echo $bIsLoggedIn ? 'Logout' : 'Login'; ?></a></li>
						<li><a href="<?php echo $baseUrl; ?>about">About</a></li>
						<li><form id="searchForm" action="<?php echo $baseUrl; ?>search/" method="get"><input id="searchTerm" type="text" placeholder="Search.." /></form></li>
					</ul>
				</nav>
				<div class="clear"></div>
			</div>
		</header>
	
		<div id="wrapper" style="padding: 0 25px 25px 25px;">
		
			<nav id="subnav">
				<ul>
					<li><a href="<?php echo $baseUrl; ?>question">Questions</a></li>
					<li><a href="<?php echo $baseUrl; ?>question/tags">Tags</a></li>
					<li><a href="<?php echo $baseUrl; ?>users">Users</a></li>
					<li><a href="<?php echo $baseUrl; ?>question/unanswered">Unanswered</a></li>
					<li><a href="<?php echo $baseUrl; ?>question/ask">Ask a Question</a></li>
				</ul>
			</nav>	
			<div class="clear"></div>			
		
			<div class="generic_box" style="margin-top: 25px; padding: 25px;">
				<?php include $viewDir . "framework/flashmessage.php" ?>
				<?php include_once($viewDir . $actionFile); ?>
			</div>
		</div>
		
		<footer>
			<a href="/about">about</a> |
			<a href="/faq">faq</a> |
			<a href="mailto:contact@ppiframework.com">contact us</a> |
			<a href="http://feedback.stackoverflow.com">feedback always welcome</a>
		</footer>		
		
	</body>
</html> 
<?php } else { ?>
			<?php include_once($viewDir . $actionFile); ?>
<?php } ?>