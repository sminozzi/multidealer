<?php 
/**
 * @author Bill Minozzi
 * @copyright 2017
 */
namespace multidealer\WP\Settings;
// http://autosellerplugin.com/wp-admin/tools.php?page=md_settings1
// $mypage = new Page('Settings', array('type' => 'submenu2', 'parent_slug' =>'admin.php?page=multi_dealer_plugin'));
// $mypage = new Page('md_settings', array('type' => 'submenu', 'parent_slug' =>'tools.php'));
  $mypage = new Page('md_settings', array('type' => 'submenu2', 'parent_slug' =>'multi_dealer_plugin'));
 // $mypage = new Page('md_settings', array('type' => 'menu'));
$msg = 'This is a scction 1 ... ';
$settings = array();
//$settings['Mutidealer Settings']['Mutidealer Settings'] = array('info' => $msg );
$fields = array();
$fields[] = array(
	'type' 	=> 'select',
	'name' 	=> 'MultiDealercurrency',
	'label' => __('Currency', 'multidealer'),
	'select_options' => array(
		array('value'=>'Dollar', 'label' => 'Dollar'),
		array('value'=>'Euro', 'label' => 'Euro'),
		array('value'=>'AUD', 'label' => 'Australian Dollar'),
		array('value'=>'Pound', 'label' => 'Pound'),
		array('value'=>'Real', 'label' => 'Brazil Real'),
		array('value'=>'Yen', 'label' => 'Yen'),
		array('value'=>'Universal', 'label' => 'Universal')     
		)			
	);
    $fields[] = array(
	'type' 	=> 'select',
	'name' 	=> 'MultiDealer_measure',
	'label' => __('Miles - Km','multidealer'),
	'select_options' => array(
		array('value'=>'Miles', 'label' => __('Miles', 'multidealer')),
		array('value'=>'Kms', 'label' => __('Kms', 'multidealer')),
		array('value'=>'Hours', 'label' => __('Hours', 'multidealer'))
		)			
	);
    $fields[] = array(
	'type' 	=> 'select',
	'name' 	=> 'MultiDealer_liter',
	'label' => __('Liters - Gallons','multidealer'),
	'select_options' => array(
		array('value'=>'Liters', 'label' => __('Liters', 'multidealer')),
		array('value'=>'Gallons', 'label' => __('Gallons', 'multidealer')),
		)			
	);
 /*   
    $fields[] = array(
	'type' 	=> 'select',
	'name' 	=> 'MultiDealer_lenght',
	'label' => __('Feet - Meters','multidealer'),
	'select_options' => array(
		array('value'=>'Feet', 'label' => __('Feet', 'multidealer')),
		array('value'=>'Meters', 'label' => __('Meters', 'multidealer') ),
		)			
	);
 */
	$fields[] =	array(
            	'type' 	=> 'select',
				'name' => 'MultiDealer_quantity',
				'label' => __('How many products would you like to display per page?', 'multidealer'),
				'select_options' => array (
                		array('value'=>'3', 'label' => '3'),
	                	array('value'=>'6', 'label' => '6'),
                		array('value'=>'9', 'label' => '9'),
	                	array('value'=>'12', 'label' => '12'),
                		array('value'=>'15', 'label' => '15'),
	                	array('value'=>'18', 'label' => '18'),
	         	)
 	); 
/*
$fields[] = array(
	'type' 	=> 'radio',
	'name' 	=> 'sidebar_search_page_result',
	'label' => __('Use dedicated Search Results Page').'?',
	'radio_options' => array(
		array('value'=>'yes', 'label' => 'Yes'),
		array('value'=>'no', 'label' => 'No'),
		)			
	);
*/
$fields[] = array(
	'type' 	=> 'radio',
	'name' 	=> 'sidebar_search_page_result',
	'label' => __('Remove Sidebar from Search Result Page').'?',
	'radio_options' => array(
		array('value'=>'yes', 'label' => 'Yes'),
		array('value'=>'no', 'label' => 'No'),
		)			
	);
 $fields[] = array(
	'type' 	=> 'radio',
	'name' 	=> 'MultiDealer_overwrite_gallery',
	'label' => __('Replace the Wordpress Gallery with Flexslider Gallery','multidealer').'?',
	'radio_options' => array(
		array('value'=>'yes', 'label' => 'Yes'),
		array('value'=>'no', 'label' => 'No'),
		)			
	);   
$fields[] = array(
	'type' 	=> 'text',
	'name' 	=> 'MultiDealer_recipientEmail',
	'label' => __('Fill out your contact email to receive email from your Contact Form at bottom of the individual Product page.' ,'multidealer')
    ); 
   $fields[] = array(
	'type' 	=> 'text',
	'name' 	=> 'MultiDealer_googlemapsapi',
	'label' => __('Optional. Fill out your Google API to use with yours maps (google maps)' ,'multidealer')
    );   
 /*
 $fields[] = array(
	'type' 	=> 'radio',
	'name' 	=> 'MultiDealer_template_gallery',
	'label' => __('In Show Room Page, use Gallery or List View Template','multidealer').'?',
	'radio_options' => array(
		array('value'=>'yes', 'label' => 'Gallery'),
		array('value'=>'no', 'label' => 'List View'),
		)			
	);  
 */
// $msg = 'Hi ';
$settings['Mutidealer Settings']['Settings']['fields'] = $fields;
new OptionPageBuilderTabbed($mypage, $settings);