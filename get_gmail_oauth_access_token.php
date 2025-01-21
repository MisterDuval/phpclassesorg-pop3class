<?php
/*
 * get_gmail_oauth_access_token.php
 *
 * @(#) $Id: get_gmail_oauth_access_token.php,v 1.1 2022/10/09 19:28:16 mlemos Exp $
 *
 */

	/*
	 *  Get the http.php file from http://www.phpclasses.org/httpclient
	 */
	require('http.php');

	/*
	 *  Get the oauth_client.php and file_oauth_client.php file from http://www.phpclasses.org/oauth-api
	 */
	require('oauth_client.php');
	require('file_oauth_client.php');

	$client = new file_oauth_client_class;
	$client->server = 'Google';
	
	$client->file = array(
		'name'=>'Gmail-oauth-token.json'
	
	);

	// set the offline access only if you need to call an API
	// when the user is not present and the token may expire
	$client->offline = true;

	$client->debug = false;
	$client->debug_http = false;
	$client->redirect_uri = 'https://'.$_SERVER['HTTP_HOST'].
		dirname(strtok($_SERVER['REQUEST_URI'],'?')).'/get_gmail_oauth_access_token.php';

	$client->client_id = ''; $application_line = __LINE__;
	$client->client_secret = '';

	if(strlen($client->client_id) == 0
	|| strlen($client->client_secret) == 0)
		die('Please go to Google APIs console page '.
			'https://console.cloud.google.com/apis/dashboard'.
			'to create a new OAuth API client.');

	/* API permissions
	 */
	$client->scope = 'https://www.googleapis.com/auth/userinfo.email '.
		'https://www.googleapis.com/auth/userinfo.profile https://mail.google.com/';
	if(($success = $client->Initialize()))
	{
		if(($success = $client->Process()))
		{
			if(strlen($client->authorization_error))
			{
				$client->error = $client->authorization_error;
				$success = false;
			}
			elseif(strlen($client->access_token))
			{
				$success = $client->CallAPI(
					'https://www.googleapis.com/oauth2/v1/userinfo',
					'GET', array(), array('FailOnAccessError'=>true), $user);
			}
		}
		$success = $client->Finalize($success);
	}
	if($client->exit)
		exit;
	if($success)
	{
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Google OAuth client results</title>
</head>
<body>
<?php
		echo '<h1>', HtmlSpecialChars($user->name),
			' you have logged in successfully with Google!</h1>';
		echo '<pre>', HtmlSpecialChars(print_r($user, 1)), '</pre>';
		echo '<pre>Access token: ', HtmlSpecialChars($client->access_token), '</pre>';
		echo '<pre>Access token expiry date: ', $client->access_token_expiry, '</pre>';
		$client->ResetAccessToken();
?>
</body>
</html>
<?php
	}
	else
	{
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>OAuth client error</title>
</head>
<body>
<h1>OAuth client error</h1>
<pre>Error: <?php echo HtmlSpecialChars($client->error); ?></pre>
</body>
</html>
<?php
	}

?>