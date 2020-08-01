<?php

global $quote_tweet_static_options, $quote_tweet_static_help;

unset($quote_tweet_static_options['serialized']);

if ( isset($_POST['submit']) ) {
	/* copy and overwrite $post for checkboxes */
	$form = $_POST;

	foreach ($quote_tweet_static_options as $type=>$arrs) {
		foreach($arrs as $k=>$v) {
			if(!empty($form[$k])) {
				update_option($k, $form[$k]);
			}
		}
	}
	//flush_rewrite_rules();
?>
<div class="updated">
   <p>Options Updated!</p>
</div>
<?php
} elseif (isset($_POST['reset'])) {
	foreach ($quote_tweet_static_options as $type=>$arrs) {
		foreach ($arrs as $k=>$v) {
			update_option($k, $v);
		}
	}
?>
<div class="updated">
   <p>Options have been reset to default values!</p>
</div>
<?php
}

$title = $plugin_data['Name'];
$description = $plugin_data['Description'];
$version = $plugin_data['Version'];
?>

<div class="wrap">
	<h1><?php echo $title; ?> <small>version: <?php echo $version; ?></small></h1>
	<p><?php echo $description; ?></p>
	<div class="wrap">
	<form method="post">
		<div class="container">
				<h2><?php _e('Settings', 'quote-tweet'); ?></h2>
				<hr>
		</div>
	<?php
	function option_label ($opt = 'twitter_name') {
	    $opt = explode('_', $opt);
	    
	    // remove 'quote'
	    array_shift($opt); 
	    // remove 'tweet'
	    array_shift($opt); 

	    foreach($opt as &$v) {
	        $v = ucfirst($v);
	    }
	    echo implode(' ', $opt);
	}

	foreach ($quote_tweet_static_options as $type=>$arrs) {
		foreach ($arrs as $k=>$v) {
	?>
	<div class="container">
		<label>
			<span class="label"><?php option_label($k); ?></span>
			<span class="input-group">
			<?php
			if ($type === 'text') {
			?>
				<input class="regular-text" name="<?php echo $k; ?>" type="text" id="<?php echo $k; ?>" value="<?php echo get_option($k, $v); ?>" />
			<?php
			} elseif ($type === 'checks') {
			?>
				<input class="checkbox" name="<?php echo $k; ?>" type="checkbox" id="<?php echo $k; ?>"<?php if (get_option($k, $v)) echo ' checked="checked"' ?> />
			<?php
			}
			?>
			</span>
		</label>
		<?php 
		if (array_key_exists($k, $quote_tweet_static_help)) {
		?>
		<div class="helptext">
		<p class="description"><?php echo $quote_tweet_static_help[$k]; ?></p>
		</div>
		<?php
		}
		?>
	</div>
	<?php
		}
	}
	?>

	<div class="container">
		<input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes">
		<input type="submit" name="reset" id="reset" class="button button-secondary" value="Reset to Defaults">
	</div>

	</form>
	</div>
</div>
