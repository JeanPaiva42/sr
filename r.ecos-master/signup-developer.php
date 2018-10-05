<?
require_once('inc.header.php');
?>



    <?
    require_once('inc.menu.php');
    ?>


            <?
            $conn = conectar();
            ?>


            <?
            if( isset($_GET['action']) && $_GET['action']=='new' ){
                
                $table = 'recos_tb_users';

                $email = $_POST['email'];
                $password = md5(_HASH.$_POST['password']);
                $password_2 = md5(_HASH.$_POST['password_2']);

                //verify if already exists this user
                $aux_verify = sql_select($conn,$table,NULL,' (txt_email_use = \''.$email.'\') ');

                if($password != $password_2){

                    echo '<p>Error! The password confirmation is different. Please try again.</p>';                    

                } else if( sql_num_rows($aux_verify) == 0 ){

                    $fields = '
                    txt_username_use,
                    txt_email_use,
                    txt_password_use
                    ';
                    $values = "
                    '".$email."',
                    '".$email."',
                    '".$password."'
                    ";

                    if( sql_insert( $conn, $table, $fields, $values) ){

                        $user = sql_select($conn,'recos_tb_users', NULL, " txt_username_use = '".$email."' AND txt_password_use = '".$password."' ");
                        $user = sql_fetch_array($user);

                        $retorno_login = 'USER LOGGED. REDIRECTING...<br /><br />';

                        $_SESSION['user_loged'] = true;
                        $_SESSION['user_cod'] = $user['pk_cod_user'];
                        $_SESSION['user_email'] = $email;

                        redireciona('painel.php');


                        echo '
                        <p>New user successfully added</p>
                        ';

                    } else {

                        echo '<p>Error! Please try again</p>';
                    }


                } else {

                    echo '<p>Error! This email is already in use. Try another one, or <a href="painel.php">click here to login</a>.</p>';

                }



            }
            ?>



    <!-- FORM SIGN UP -->

    <div class="mdl-grid miolo " >

                <div class="mdl-cell mdl-cell--12-col" style="text-align:center;">

                    

                        <h4><b>Sign up</b></h4>
                        <p>Fill the form bellow to sing up as a Developer of services in our Recommender Ecossystem</p>
                        

                    <form action="?action=new" method="POST">

                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                            <input class="mdl-textfield__input" type="text" id="email" name="email">
                            <label class="mdl-textfield__label" for="email">email</label>
                        </div>

                        <br />


                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                            <input class="mdl-textfield__input" type="password" id="password" name="password">
                            <label class="mdl-textfield__label" for="password">Password</label>
                        </div>

                        <br />


                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                            <input class="mdl-textfield__input" type="password" id="password_2" name="password_2">
                            <label class="mdl-textfield__label" for="password_2">Confirm password</label>
                        </div>

                        <br />


                        

                        <br /><br />

                        <!-- Accent-colored raised button with ripple -->
                        <input type="submit" value="Sign Up" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" />

                        <br /><Br />

                    </form>

                    

                </div>


                
                        
    </div>



    <?
    require_once('inc.menu_footer.php');
    ?>


<?
require_once('inc.footer.php');
?>
