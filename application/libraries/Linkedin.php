<?php defined('BASEPATH') OR exit('No direct script access allowed'); 
/* 
| ------------------------------------------------------------------- 
|  LinkedIn API Configuration 
| ------------------------------------------------------------------- 
| 
| To get an LinkedIn app details you have to create a LinkedIn app 
| at LinkedIn Developers panel (https://www.linkedin.com/developers/) 
| 
|  linkedin_api_key        string   Your LinkedIn App Client ID. 
|  linkedin_api_secret     string   Your LinkedIn App Client Secret. 
|  linkedin_redirect_url   string   URL to redirect back to after login. (do not include base URL) 
|  linkedin_scope          array    Your required API permissions. 
*/ 
$config['linkedin_api_key']       = '98sjdkeu47kazx'; 
$config['linkedin_api_secret']    = 'KA74jYAZlsiQks65'; 
$config['linkedin_redirect_url']  = 'user_authentication/'; 
$config['linkedin_scope']         = 'r_liteprofile r_emailaddress';