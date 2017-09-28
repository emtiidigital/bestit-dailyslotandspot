<?php
if(!defined('WP_LOAD_IMPORTERS')) 
	define('WP_LOAD_IMPORTERS', true);

require_once ABSPATH . 'wp-admin/includes/import.php';
$importer_error = false;
$import_filepath = $file;


if(!class_exists('WP_Importer'))
{
	$class_wp_importer = ABSPATH . 'wp-admin/includes/class-wp-importer.php';
	if(file_exists($class_wp_importer))
		require_once($class_wp_importer);
	else
		$importer_error = true;
}

if(!class_exists('WP_Import')) 
{
	$class_wp_import = plugin_dir_path(__FILE__) . 'wordpress-importer.php';
	if(file_exists($class_wp_import))
		require_once($class_wp_import);
	else
		$importer_error = true;
}

if($importer_error !== false)
	echo "Auto import feature couldn't be loaded. Please make import manually <a href='/wp-admin/import.php'>here</a>. You can find import dummy files in 'dummy content files' directory inside zip archive downloaded from ThemeForest.";
else
{
	if(!is_file($import_filepath))
		echo "The XML file is not available";
	else
	{
		$wp_import = new WP_Import();
		$wp_import->fetch_attachments = $fetch_attachments;
		set_time_limit(0);
		$wp_import->import($import_filepath);
	}
}




