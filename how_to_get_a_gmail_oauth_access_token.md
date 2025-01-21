# Document Version 

$Id: how_to_get_a_gmail_oauth_access_token.md,v 1.1 2022/10/09 19:28:16 mlemos Exp $

# Why You May need to Get a Gmail API OAuth Access Token

You can send and receive messages using Gmail account by accessing Gmail SMTP, POP3 or IMAP servers.

If are paying customer of Google Gsuite you only need to use a user name and password to access those servers.

If you are not a paying customer of Google Gsuite, you need to use the OAuth protocol to pass an access token when your applications access those servers on behalf of your user that has a free Gmail account.

# What You Need to Do to Obtain a Gmail API OAuth Access Token

You need to use a OAuth client script to access the Gmail API OAuth servers using a Web interface so your user authorizes the OAuth client script to retrieve the OAuth access token.

Once you have that OAuth access token you can pass it to your SMTP, POP3 or IMAP servers, so Gmail authorizes to delivery of the email messages you want to send or the reception of the email messages that you want to receive.

# How You Can Obtain the Gmail API Access Token

1. You need to create an application in the **Google Developer Console**: https://console.cloud.google.com/apis/dashboard
2. You need to create a new application project if you do not have one already. If you do not have a project, click on the **Select a project** button that appears at the top of the Google Developer Console main page. Then click on the **New project** button. Then fill the project details and click in the **Create details**.
3. If the OAuth consent screen is not configure, click on the **OAuth consent screen** menu button on the left. Select **External** option and then use the **CREATE** button. Enter **Gmail OAuth client** in the **App name** field. Enter your Google account email address in the **User support email** field. Enter the same email address in the **Email addresses** field in the **Developer contact information** section. Click in the **SAVE AND CONTINUE** button. In the **Scopes** tab enter in the **Manually add scopes** field https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/userinfo.profile https://mail.google.com/ and then click in the **UPDATE** button below. Click in the **SAVE AND CONTINUE** button. In the **Test users** tab click in the **SAVE AND CONTINUE** button.
3. Click in the **Credentials** menu button on the left.
4. Click on the **CREATE CREDENTIALS** button and then select the **OAuth client ID**. Select **Web application** in the application type field. Click in the **CREATE** button. Copy the text value from the **Your Client ID** field to the line of the get_gmail_oauth_access_token.php script that assigns the $client->client_id class variable . Copy the text value from the **Your Client Secret** field to the line of the get_gmail_oauth_access_token.php script that assigns the $client->client_secret class variable . In the **Authorized redirect URIs** enter the URL of the get_gmail_oauth_access_token.php script.
5. Click in the **ACTIVATE** button that appears at the top right corner of the screen. Enter the details of your company or organization or personal project according to your case.

Note that you may still need to verify the application to let Google pass all authorization screens without warnings.

Also note that the access token retrieved using the get_gmail_oauth_access_token.php script will expire after 1 hour. So you need to refresh it with the OAuth client class variant that uses files to store the OAuth access token and the refresh token before you use the OAuth access token after the expiry time.