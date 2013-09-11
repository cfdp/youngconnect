<?php

/**
 * @file
 * This file is empty by default because the base theme chain (Alpha & Omega) provides
 * all the basic functionality. However, in case you wish to customize the output that Drupal
 * generates through Alpha & Omega this file is a good place to do so.
 * 
 * Alpha comes with a neat solution for keeping this file as clean as possible while the code
 * for your subtheme grows. Please read the README.txt in the /preprocess and /process subfolders
 * for more information on this topic.
 */
 
/**
 * hook_form_alter
 */
function young_connect_form_alter(&$form, $form_state, $form_id) { 
	/* Login */
	if($form_id=="user_login") {
		unset($form["name"]["#title"]);
		unset($form["name"]["#description"]);
		unset($form["pass"]["#title"]);
		unset($form["pass"]["#description"]);
		$form["name"]["#attributes"]['placeholder'] = "Brugernavn";
		$form["pass"]["#attributes"]['placeholder'] = "Adgangskode";
	}
	/* Calendar admin */
	if($form["#id"] == "views-exposed-form-calendar-page-4") {
		$form["combine"]["#attributes"]['placeholder'] = "Søg i kalenderen her";
	}
}

/**
 * hook_theme
 */
function young_connect_theme() {
	$items = array();
	// create custom user-login.tpl.php
	$items['user_login'] = array(
		'render element' => 'form',
		'path' => drupal_get_path('theme', 'young_connect') . '/templates',
		'template' => 'user-login',
		'preprocess functions' => array(
			'young_connect_preprocess_user_login'
		),
	);
	return $items;
}

/**
 * hook_menu_link
 */
function young_connect_menu_link(array $variables) {
		
  $element = $variables['element'];
  $sub_menu = '';

  if ($element['#below']) {
    $sub_menu = drupal_render($element['#below']);
  }
 
  $menu_class = "";
   
  switch($element["#title"]) {
  	case "Kalender":
		$menu_class = "menu-calendar";
		$element["#attributes"]["class"][] = $menu_class;
		$element["#localized_options"]["attributes"]["class"][] = $menu_class;
  	break;
  	case "Beskeder":
		$menu_class = "menu-messages";
		$element["#attributes"]["class"][] = $menu_class;
		$element["#localized_options"]["attributes"]["class"][] = $menu_class;
  	break;
  	case "Info / hjælp":
		$menu_class = "menu-help";
		$element["#attributes"]["class"][] = $menu_class;
  		$element["#localized_options"]["attributes"]["class"][] = $menu_class;
  	break;
  	case "Forum":
		$menu_class = "menu-help";
		$element["#attributes"]["class"][] = $menu_class;
  		$element["#localized_options"]["attributes"]["class"][] = $menu_class;
  	break;
  	case "Værktøjskasse":
		$menu_class = "menu-toolbox";
		$element["#attributes"]["class"][] = $menu_class;
  		$element["#localized_options"]["attributes"]["class"][] = $menu_class;
  	break;
  }
  $output = l($element['#title'], $element['#href'], $element['#localized_options']);
  return '<li' . drupal_attributes($element['#attributes']) . '><span>' . $output . $sub_menu . "</span></li>\n";
}

/**
 * hook_date_nav_title
 */
function young_connect_date_nav_title($params) {
  $granularity = $params['granularity'];
  $view = $params['view'];
  $date_info = $view->date_info;
  $link = !empty($params['link']) ? $params['link'] : FALSE;
  $format = !empty($params['format']) ? $params['format'] : NULL;
  switch ($granularity) {
    case 'year':
      $title = $date_info->year;
      $date_arg = $date_info->year;
      break;
    case 'month':
      $format = !empty($format) ? $format : (empty($date_info->mini) ? 'F Y' : 'F Y');
      $title = date_format_date($date_info->min_date, 'custom', $format);
      $date_arg = $date_info->year . '-' . date_pad($date_info->month);
      break;
    case 'day':
      $format = !empty($format) ? $format : (empty($date_info->mini) ? 'd' : 'l, F j');
      $title = "<span class='month'>".date_format_date($date_info->min_date, 'custom', "F Y")."</span>";
      $title .= "<span class='day'>".date_format_date($date_info->min_date, 'custom', $format)."</span>";
      $title .= "<span class='week-day'>".date_format_date($date_info->min_date, 'custom', "l")."</span>";
      $date_arg = $date_info->year . '-' . date_pad($date_info->month) . '-' . date_pad($date_info->day);
      break;
    case 'week':
      $format = !empty($format) ? $format : (empty($date_info->mini) ? 'W, Y' : 'F j');
      $title = t('Week @date', array('@date' => date_format_date($date_info->min_date, 'custom', $format)));
      $date_arg = $date_info->year . '-W' . date_pad($date_info->week);
      break;
  }
  if (!empty($date_info->mini) || $link) {
    // Month navigation titles are used as links in the mini view.
    $attributes = array('title' => t('View full page month'));
    $url = date_pager_url($view, $granularity, $date_arg, TRUE);
    return l($title, $url, array('attributes' => $attributes));
  }
  else {
    return $title;
  }
}

/**
 * hook_textarea
 */
function young_connect_textarea($variables) {
  $element = $variables['element'];
  $element['#attributes']['name'] = $element['#name'];
  $element['#attributes']['id'] = $element['#id'];
  $element['#attributes']['cols'] = $element['#cols'];
  $element['#attributes']['rows'] = 8;
  _form_set_class($element, array('form-textarea'));
 
  $wrapper_attributes = array(
    'class' => array('form-textarea-wrapper'),
  );
 
  // Add resizable behavior.
  if (!empty($element['#resizable'])) {
    $wrapper_attributes['class'][] = 'resizable';
  }
 
  $output = '<div' . drupal_attributes($wrapper_attributes) . '>';
  $output .= '<textarea' . drupal_attributes($element['#attributes']) . '>' . check_plain($element['#value']) . '</textarea>';
  $output .= '</div>';
  return $output;
}