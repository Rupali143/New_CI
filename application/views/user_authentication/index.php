<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login with LinkedIn in CodeIgniter by CodexWorld</title>

    <!-- Include stylesheet file -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.css"/>
</head>
<body>
<div class="container">
    <div class="in-box">
        <?php 
        if(!empty($error_msg)){ 
            echo '<p class="error">'.$error_msg.'</p>';     
        }
		
        if(!empty($userData)){ ?>
            <h2>LinkedIn Profile Details</h2>
            <div class="ac-data">
                <img src="<?php echo $userData['picture']; ?>"/>
                <p><b>LinkedIn ID:</b> <?php echo $userData['oauth_uid']; ?></p>
                <p><b>Name:</b> <?php echo $userData['first_name'].' '.$userData['last_name']; ?></p>
                <p><b>Email:</b> <?php echo $userData['email']; ?></p>
                <p><b>Logged in with:</b> LinkedIn</p>
                <p><b>Profile Link:</b> <a href="<?php echo $userData['link']; ?>" target="_blank">Click to visit LinkedIn page</a></p>
                <p><b>Logout from</b> <a href="<?php echo base_url().'user_authentication/logout'; ?>">LinkedIn</a></p>
            </div>
        <?php 
        }else{ 
            // Render LinkedIn login button 
            echo '<a href="'.$oauthURL.'"><img src="'.base_url().'assets/images/linkedin-sign-in-btn.png"></a>'; 
        } 
        ?>
    </div>
</div>
</body>
</html>