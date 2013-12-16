<?php if(isset($error)): ?>
<?php
        switch($error) {
            case 1:
                echo "<div class='error'>";
                echo "Login failed. Please double check your email and password";
                echo "</div>";
                break;
            case 2:
                echo "<div class ='welcome'>";
                echo "Thank you for joining ".APP_NAME."!";
                echo "<br>";
                echo "Please login below";
                echo "</div>";
                break;
            default:
                break;
        }
    ?>

<?php endif; ?>

<h2>Log In</h2>
	<form method='POST' action='/users/p_login'>

	Email<br>
		<input type='text' name='email' placeholder="e-mail">
		<br>

	Password<br>
		<input type='password' name='password' placeholder="password">
			<br>

				<input type='submit' value='Log in'>

	</form>