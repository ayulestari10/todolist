<?php

	if(LEGACY == "PREPROD02"){
		//GLOBAL VIEW
		defined('APP_NAME')      				OR define('APP_NAME', 'Online Geofencing Attendance Application Backend');
		defined('TITLE_APP')      				OR define('TITLE_APP', 'Online Geofencing Attendance Application PT Semen Baturaja (Persero) Tbk');
		defined('LANGUAGE_APP')      			OR define('LANGUAGE_APP', 'english');
		defined('API_BASE_URL')      			OR define('API_BASE_URL', 'http://app.semenbaturaja.co.id:14800/');
		defined('API_IMG_BASE_URL')     		OR define('API_IMG_BASE_URL', API_BASE_URL.'oaa_api_dev/uploads/images/');
		defined('API_BASE_URL_ALT')      		OR define('API_BASE_URL_ALT', 'http://appz.semenbaturaja.co.id:14800/');
		defined('API_IMG_BASE_URL_ALT')     	OR define('API_IMG_BASE_URL_ALT', API_BASE_URL_ALT.'oaa_api_dev/uploads/images/');
		defined('API_BASE_URL_ALT_LOCAL')      	OR define('API_BASE_URL_ALT_LOCAL', 'http://10.10.2.57/');
		defined('API_IMG_BASE_URL_ALT_LOCAL')   OR define('API_IMG_BASE_URL_ALT_LOCAL', API_BASE_URL_ALT_LOCAL.'oaa_api_dev/uploads/images/');
	}
	else {
		//GLOBAL VIEW
		defined('APP_NAME')      				OR define('APP_NAME', 'Online Geofencing Attendance Application Backend');
		defined('TITLE_APP')      				OR define('TITLE_APP', 'Online Geofencing Attendance Application PT Semen Baturaja (Persero) Tbk');
		defined('LANGUAGE_APP')      			OR define('LANGUAGE_APP', 'english');
		defined('API_BASE_URL')      			OR define('API_BASE_URL', 'http://app.semenbaturaja.co.id:100/');
		defined('API_IMG_BASE_URL')     		OR define('API_IMG_BASE_URL', API_BASE_URL.'olga_api/uploads/images/');
		defined('API_BASE_URL_ALT')      		OR define('API_BASE_URL_ALT', 'http://appz.semenbaturaja.co.id:100/');
		defined('API_IMG_BASE_URL_ALT')     	OR define('API_IMG_BASE_URL_ALT', API_BASE_URL_ALT.'olga_api/uploads/images/');
		defined('API_BASE_URL_ALT_LOCAL')      	OR define('API_BASE_URL_ALT_LOCAL', 'http://10.10.2.57:100/');
		defined('API_IMG_BASE_URL_ALT_LOCAL')   OR define('API_IMG_BASE_URL_ALT_LOCAL', API_BASE_URL_ALT_LOCAL.'olga_api/uploads/images/');
	}
?>