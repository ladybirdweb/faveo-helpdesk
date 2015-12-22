<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en-US"><head>
			<meta name="viewport" content="width=device-width">
			<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
			<title>WooCommerce › Setup Wizard</title>
			<script type="text/javascript" src="js/jquery.js"></script>
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
							<li class="active">Shipping &amp; Tax</li>
							<li class="">Payments</li>
							<li class="">Ready!</li>
					</ol>
		<div class="wc-setup-content">		<h1>Shipping &amp; Tax Setup</h1>
		<form method="post">
			<p>If you will be charging sales tax, or shipping physical goods to 
customers, you can configure the basic options below. This is optional 
and can be changed later via <a href="http://jamboreebliss.com/wp/wp-admin/admin.php?page=wc-settings&amp;tab=tax" target="_blank">WooCommerce &gt; Settings &gt; Tax</a> and <a href="http://jamboreebliss.com/wp/wp-admin/admin.php?page=wc-settings&amp;tab=shipping" target="_blank">WooCommerce &gt; Settings &gt; Shipping</a>.</p>
			<table class="form-table">
				<tbody><tr class="section_title">
					<td colspan="2">
						<h2>Basic Shipping Setup</h2>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="woocommerce_calc_shipping">Will you be shipping products?</label></th>
					<td>
						<input id="woocommerce_calc_shipping" name="woocommerce_calc_shipping" class="input-checkbox" value="1" type="checkbox">
						<label for="woocommerce_calc_shipping">Yes, I will be shipping physical goods to customers</label>
					</td>
				</tr>
				<tr style="display: none;">
					<th scope="row"><label for="shipping_cost_domestic"><strong>Domestic</strong> shipping costs:</label></th>
					<td>
						A total of  <input id="shipping_cost_domestic" name="shipping_cost_domestic" size="5" type="text"> per order and/or  <input id="shipping_cost_domestic_item" name="shipping_cost_domestic_item" size="5" type="text"> per item					</td>
				</tr>
				<tr style="display: none;">
					<th scope="row"><label for="shipping_cost_international"><strong>International</strong> shipping costs:</label></th>
					<td>
						A total of  <input id="shipping_cost_international" name="shipping_cost_international" size="5" type="text"> per order and/or  <input id="shipping_cost_international_item" name="shipping_cost_international_item" size="5" type="text"> per item					</td>
				</tr>
				<tr class="section_title">
					<td colspan="2">
						<h2>Basic Tax Setup</h2>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="woocommerce_calc_taxes">Will you be charging sales tax?</label></th>
					<td>
						<input id="woocommerce_calc_taxes" name="woocommerce_calc_taxes" class="input-checkbox" value="1" type="checkbox">
						<label for="woocommerce_calc_taxes">Yes, I will be charging sales tax</label>
					</td>
				</tr>
				<tr style="display: none;">
					<th scope="row"><label for="woocommerce_prices_include_tax">How will you enter product prices?</label></th>
					<td>
						<label><input id="woocommerce_prices_include_tax" name="woocommerce_prices_include_tax" class="input-radio" value="yes" type="radio"> I will enter prices inclusive of tax</label><br>
						<label><input checked="checked" id="woocommerce_prices_include_tax" name="woocommerce_prices_include_tax" class="input-radio" value="no" type="radio"> I will enter prices exclusive of tax</label>
					</td>
				</tr>
							</tbody></table>
            <p>Once created, these pages can be managed from your admin dashboard on the <a href="http://jamboreebliss.com/wp/wp-admin/edit.php?post_type=page" target="_blank">Pages screen</a>. You can control which pages are shown on your website via <a href="http://jamboreebliss.com/wp/wp-admin/nav-menus.php" target="_blank">Appearance &gt; Menus</a>.</p>

            <p class="wc-setup-actions step">
                <a href="step4.html" class="button-primary button button-large button-next">Continue</a>
                <a href="#" class="button button-large button-next">Skip this step</a>
            </p>
		</form>
		</div>						
		
		</body></html>