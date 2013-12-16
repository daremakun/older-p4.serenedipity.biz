<h2>Sign Up</h2>

<section class="content">
        <h2>Sign Up</h2>

        <form method='POST' enctype="multipart/form-data" action='/users/p_signup'> <!-- Naming convention = /controller/post or method -->

                <input type='file' name='avatar' value='file'><br />

                <input type='text' name='first_name' placeholder='First Name'><br />
                <input type='text' name='last_name' placeholder='Last Name'><br />
                <input type='text' name='email' placeholder="Email Address"><br /> <!-- Query database to be sure email doesn't already exist -->
                <input type='password' name='password' placeholder='Password'><br />

                <div class='button'><input type='Submit' value='Sign Up!'></div>

        </form>
</section>