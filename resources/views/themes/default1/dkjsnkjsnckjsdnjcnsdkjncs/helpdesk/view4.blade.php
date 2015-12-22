<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en-US"><head>
			<meta name="viewport" content="width=device-width">
			<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
			<title>WooCommerce › Setup Wizard</title>
			<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery-migrate.js"></script>

<link rel="stylesheet" href="css/load-styles.css" type="text/css" media="all">
<link rel="stylesheet" id="open-sans-css" href="css/css.css" type="text/css" media="all">
<link rel="stylesheet" id="woocommerce_admin_styles-css" href="css/admin.css" type="text/css" media="all">
<link rel="stylesheet" id="wc-setup-css" href="css/wc-setup.css" type="text/css" media="all">
<link rel="stylesheet" id="woocommerce-activation-css" href="css/activation.css" type="text/css" media="all">
			</head>
		<body class="wc-setup wp-core-ui">
			<h1 id="wc-logo"><a href="http://woothemes.com/woocommerce"><img src="images/App-Store.app" alt="Faveo"></a></h1>
				<ol class="wc-setup-steps">
							<li class="done">Page Setup</li>
							<li class="done">Store Locale</li>
							<li class="done">Shipping &amp; Tax</li>
							<li class="active">Payments</li>
							<li class="">Ready!</li>
					</ol>
		<div class="wc-setup-content">		<h1>Payments</h1>
		<form method="post">
			<p>WooCommerce can accept both online and offline payments. <a href="http://jamboreebliss.com/wp/wp-admin/admin.php?page=wc-addons&amp;view=payment-gateways" target="_blank">Additional payment methods</a> can be installed later and managed from the <a href="http://jamboreebliss.com/wp/wp-admin/admin.php?page=wc-settings&amp;tab=checkout" target="_blank">checkout settings</a> screen.</p>
			<table class="form-table">
				<tbody><tr class="section_title">
					<td colspan="2">
						<h2>PayPal Standard</h2>
						<p>To accept payments via PayPal on your store, simply enter your PayPal email address below.</p>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="woocommerce_paypal_email">PayPal Email Address:</label></th>
					<td>
						<input id="woocommerce_paypal_email" name="woocommerce_paypal_email" class="input-text" type="email">
					</td>
				</tr>
				<tr class="section_title">
					<td colspan="2">
						<h2>Offline Payments</h2>
						<p>Offline gateways require manual processing, but can be useful in certain circumstances or for testing payments.</p>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="woocommerce_enable_cheque">Cheque Payments</label></th>
					<td>
						<label><input id="woocommerce_enable_cheque" name="woocommerce_enable_cheque" class="input-checkbox" value="yes" type="checkbox"> Enable payment via Cheques</label>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="woocommerce_enable_cod">Cash on Delivery</label></th>
					<td>
						<label><input id="woocommerce_enable_cod" name="woocommerce_enable_cod" class="input-checkbox" value="yes" type="checkbox"> Enable cash on delivery</label>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="woocommerce_enable_bacs">Bank Transfer (BACS)</label></th>
					<td>
						<label><input id="woocommerce_enable_bacs" name="woocommerce_enable_bacs" class="input-checkbox" value="yes" type="checkbox"> Enable BACS payments</label>
					</td>
				</tr>
			</tbody></table>
            <p>Once created, these pages can be managed from your admin dashboard on the <a href="http://jamboreebliss.com/wp/wp-admin/edit.php?post_type=page" target="_blank">Pages screen</a>. You can control which pages are shown on your website via <a href="http://jamboreebliss.com/wp/wp-admin/nav-menus.php" target="_blank">Appearance &gt; Menus</a>.</p>

            <p class="wc-setup-actions step">
                <a href="step5.html" class="button-primary button button-large button-next">Continue</a>
                <a href="#" class="button button-large button-next">Skip this step</a>
            </p>
		</form>
		</div>						
		
		</body></html>