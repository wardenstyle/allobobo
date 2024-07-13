<?php

function require_ab_db() {
	global $ab_db;

	require_once( 'Database.php' );

	if ( isset( $ab_db ) ) {
		return;
	}

	$ab_db = new Database();
}
// A mettre dans init mais pas nécessaire car la partie est déjà initiée
require_ab_db();
