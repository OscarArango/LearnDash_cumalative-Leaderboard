<?php
	/**
	 * Plugin Name: CTL Custom LearnDash Leaderboard
	 * Plugin URI:  https://crosstrainerlearning.com
	 * Author:      oscar@crosstrainerlearning.com
	 * License:     GPL2
	 */

	if ( !defined( 'ABSPATH' ) ) exit;

	// register style on initialization
	add_action('init', 'register_script');
	function register_script() {
		wp_enqueue_script("jquery");
		wp_register_style( 'new_style', plugins_url('style.css', __FILE__), false, '1.0.0', 'all');
	}

	// use the registered style above
	add_action('wp_enqueue_scripts', 'enqueue_style');
	function enqueue_style(){
		wp_enqueue_style( 'new_style' );
	}

	// pull data from pro_quiz_toplist and show custom list with cumalative Leaderboard.
	function ctlTopUsers() {
		global $wpdb;
		$result = $wpdb->get_results ( "SELECT user_id, name, email, SUM(points) as points FROM servier_wp_pro_quiz_toplist GROUP BY user_id, name, email ORDER BY SUM(points) DESC" );
		
		echo "<table id='ctlTopLearnersStyle' style='width:100%'><tr><th>Name</th><th>Email</th><th>Score</th></tr>";

		foreach ( $result as $print )   {
			echo '<tr>';
			echo '<td>' . $print->name.'</td>';
			echo '<td>' . $print->email.'</td>';
			echo '<td>' . $print->points.'</td>';
			echo '</tr>';
		}
		echo "</table>";
	}
	add_shortcode('ctlTopLearners', 'ctlTopUsers');