<?php
if (tieneSesion()) {
	$_SESSION['usuario'] = new Usuario($_SESSION['id']);
}