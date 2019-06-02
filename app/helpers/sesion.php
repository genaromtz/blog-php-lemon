<?php
session_start();

function tieneSesion() {
	if (isset($_SESSION['id'])) {
		return true;
	} else {
		return false;
	}
}