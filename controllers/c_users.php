<?php
class users_controller extends base_controller {

    public function __construct() {
        parent::__construct();

    }

    public function index() {

    } # End of Method
        /*-------------------------------------------------------------------------------------------------
      Error Handling
        -------------------------------------------------------------------------------------------------*/
    public function signup($error = NULL) {

        # Setup view
        $this->template->content = View::instance('v_users_signup');
        $this->template->title = "Sign Up";

        # Pass data to the view
        $this->template->content->error = $error;

        # Render template
        echo $this->template;

    } # End of Method
        /*-------------------------------------------------------------------------------------------------
        Validate that the user has entered a valid login name
        -------------------------------------------------------------------------------------------------*/
    public function p_signup() {

        
        $at_sign = strpos($_POST['email'], '@');

        # Error code 1 indicates invalid login name
        if($at_sign === false) {
            Router::redirect('/users/signup/1');
        }

        ## if the email has already been created, then alert the person signing up
        $email = $_POST['email'];
        $q = "SELECT created FROM users WHERE email = '".$email."'";
        $emailexists = DB::instance(DB_NAME)->select_field($q);

        # Error code 2 indicates that user already exists
        if(isset($emailexists)){
            Router::redirect('/users/signup/2');
        }

        ## Ensure that the user has entered a first name

        # Error code 3 indicates that user needs a first name
        if(strlen($_POST['first_name'])<1){
            Router::redirect('/users/signup/3');
        }

        ## Ensure password is greater than 5 characters
        # Error code 4 indicates that password is too short
        if(strlen($_POST['password'])<6) {
            Router::redirect('/users/signup/4');
        }

        # Give user the default avatar and profile photo
        $_POST['avatar'] = "sample.jpg";
        $_POST['photo'] = "p_sample.jpg";


        # Store time stamp data from user
        $_POST['created'] = Time::now();
        $_POST['modified'] = Time::now();

        # Encrypt the password
        $_POST['password'] = sha1(PASSWORD_SALT.$_POST['password']);

        # Create an encrypted token via their email address and a random string
        $_POST['token'] = sha1(TOKEN_SALT.$_POST['email'].Utils::generate_random_string());

        # Insert this user into the database
        $user_id = DB::instance(DB_NAME)->insert('users', $_POST);

        # Redirect to the login page, and inform them that they have signed up
        # Currently using $error = 2 as the indication that they have signed up
        Router::redirect('/users/login/2');

    } # End of Method
        /*-------------------------------------------------------------------------------------------------
        Error Handling
        -------------------------------------------------------------------------------------------------*/
    public function login($error = NULL) {

        # Setup view
        $this->template->content = View::instance('v_users_login');
        $this->template->title = "Login";

        # Pass data to the view
        $this->template->content->error = $error;

        # Render template
        echo $this->template;

    } # End of Method
        /*-------------------------------------------------------------------------------------------------
        Login checkpoint
        -------------------------------------------------------------------------------------------------*/
    public function p_login() {

        # Sanitize the user entered data
        $_POST = DB::instance(DB_NAME)->sanitize($_POST);

        # Hash submitted password so we can compare it against one in the db
        $_POST['password'] = sha1(PASSWORD_SALT.$_POST['password']);

        # Search the db for this email and password
        # Retrieve the token if it's available

        $q = 'SELECT token
				FROM users
				WHERE email = "'.$_POST['email'].'"
				AND password = "'.$_POST['password'].'"';

        $token = DB::instance(DB_NAME)->select_field($q);

        # If we didn't find a matching token in the database, it means login failed
        if(!$token) {

            # Send them back to the login page
            # Error code 1 indicates that they have incorrect login credentials
            Router::redirect("/users/login/1");

        }
        # But if we did, login succeeded!
        else {

            # Store this token in a cookie using setcookie()
            setcookie("token", $token, strtotime('+1 year'), '/', false);

            # Send them to the main page
            Router::redirect('/users/profile');
        }
    } # End of Method
        /*-------------------------------------------------------------------------------------------------
        Logout
        -------------------------------------------------------------------------------------------------*/
    public function logout() {
        # Generate and save a new token for next login
        $new_token = sha1(TOKEN_SALT.$this->user->email.Utils::generate_random_string());

        # Create the data array we'll use with the update method
        # In this case, we're only updating one field, so our array only has one entry
        $data = Array("token" => $new_token);

        # Do the update
        DB::instance(DB_NAME)->update("users", $data, "WHERE token = '".$this->user->token."'");

        # Delete their token cookie by setting it to a date in the past - effectively logging them out
        setcookie("token", "", strtotime('-1 year'), '/');

        # Send them back to the main index.
        Router::redirect("/");

    } # End of Method
        /*-------------------------------------------------------------------------------------------------
      	Make sure user is logged in if they want to use anything in this controller
        -------------------------------------------------------------------------------------------------*/
    public function profile($error = NULL) {

        if(!$this->user) {
            Router::redirect('/users/login');
        }

        # Setup view
        $this->template->content = View::instance('v_users_profile');

        #Include user information
        $this->template->title = $this->user->first_name." ".$this->user->last_name;
        $this->template->error = $error;

        //Following block is specific to importing the user's own posts to profile page

            # Build the query (same query as posts/personal/)
            $q = "SELECT posts.*
					FROM posts
					WHERE user_id = ".$this->user->user_id.
                " ORDER BY modified DESC";

            # Run the query
            $posts = DB::instance(DB_NAME)->select_rows($q);

            # Pass data to the View
            $this->template->content->posts = $posts;

        // END IMPORT BLOCK

        # Render template
        echo $this->template;

    } # End of Method
        /*-------------------------------------------------------------------------------------------------
        If user specified a new image file, upload it
        -------------------------------------------------------------------------------------------------*/
    public function p_upload() {
        
        if ($_FILES['avatar']['error'] == 0)
        {
            //Process the upload of the avatar
            $avatar = Upload::upload($_FILES, "/uploads/avatars/", array("jpg", "jpeg", "gif", "png"), $this->user->user_id);

            if($avatar == 'Invalid file type.') {
                // return an error
                Router::redirect("/users/profile/error");
            }
            else {

                // Store the avatar link in users table
                $data = Array("avatar" => $avatar);
                DB::instance(DB_NAME)->update("users", $data, "WHERE user_id = ".$this->user->user_id);

                // Store the photo link in users table
                $data2 = Array("photo" => "p_".$avatar);
                DB::instance(DB_NAME)->update("users", $data2, "WHERE user_id = ".$this->user->user_id);

                // Resize photo for a user's profile page, and rename as p_avatar
                $imgObj = new Image($_SERVER["DOCUMENT_ROOT"] . '/uploads/avatars/' . $avatar);
                $imgObj->resize(200,200);
                $imgObj->save_image($_SERVER["DOCUMENT_ROOT"] . '/uploads/avatars/' . "p_".$avatar);

                //Resize avatar image for showing up in posts
                $imgOb = new Image($_SERVER["DOCUMENT_ROOT"] . '/uploads/avatars/' . $avatar);
                $imgOb->resize(80,80,"crop");
                $imgOb->save_image($_SERVER["DOCUMENT_ROOT"] . '/uploads/avatars/' . $avatar);
            }
        }
        else
        {
            // return an error
            Router::redirect("/users/profile/error");
        }

        // Redirect back to the profile page
        router::redirect('/users/profile');

    } # End of Method

} # end of the class
