<link rel="stylesheet" href="assets/css/login_user.css">
<?php include_once 'helpers/helper.php'; ?>

<?php subview('header.php'); ?>
<link rel="stylesheet" href="assets/css/login_user.css">
<?php
if(isset($_GET['pwd'])) {
    if($_GET['pwd']=='updated') {
        echo "<script>alert('Your password has been reset!!');</script>";
    }
}    
?>
<?php
if(isset($_GET['error'])) {
    if($_GET['error'] === 'invalidcred') {
        echo '<script>alert("Invalid Credentials")</script>';
    } else if($_GET['error'] === 'wrongpwd') {
        echo '<script>alert("Wrong Password")</script>';
    } else if($_GET['error'] === 'sqlerror') {
        echo"<script>alert('Database error')</script>";
    }
}
if(isset($_COOKIE['Uname']) && isset($_COOKIE['Upwd'])) {
  require 'helpers/init_conn_db.php';   
  $email_id = $_POST['user_id'];
  $password = $_POST['user_pass'];
  $sql = 'SELECT * FROM Users WHERE username=? OR email=?;';
  $stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt,$sql)) {
      header('Location: views/login.php?error=sqlerror');
      exit();            
  } else {
      mysqli_stmt_bind_param($stmt,'ss',$_COOKIE['Uname'],$_COOKIE['Uname']);            
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      if($row = mysqli_fetch_assoc($result)) {
          $pwd_check = password_verify($_COOKIE['Upwd'],$row['password']);
          if($pwd_check == false) {
              setcookie('Uname', '',time() - 3600);
              setcookie('Upwd', '',time() - 3600);              
              header('Location: views/login.php?error=wrongpwd');
              exit();    
          }
          else if($pwd_check == true) {
              session_start();
              $_SESSION['userId'] = $row['user_id'];
              $_SESSION['userUid'] = $row['username'];
              $_SESSION['userMail'] = $row['email'];                            
              header('Location: views/index.php?login=success');
              exit();                  
          } else {
              header('Location: views/login.php?error=invalidcred');
              exit();                    
          }
      }
      header('Location: views/login.php?error=invalidcred');
      exit();         
  }
  header('Location: views/login.php?error=invalidcred');
  exit();      
  mysqli_stmt_close($stmt);
  mysqli_close($conn);
}
?>
<style>
body {
  /* background:url('assets/images/bg2.jpg') no-repeat 0px 0px;
  background-size: cover;
  font-family: 'Open Sans', sans-serif;
  background-attachment: fixed;
    background-position: center; */
  background: #fff;  /* fallback for old browsers */
background: -webkit-linear-gradient(to right, #27bee4, #fff);  /* Chrome 10-25, Safari 5.1-6 */
background: linear-gradient(to right, #27bee4, #fff); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
}
</style> 
<main>
<div class="container">
            <img class="logo" src="assets/images/logoOkan.png">
            <!-- <h1>Pesawat Terbang<br>Garuda Indonesia</h1> -->
            <div class="form">
      
      <form method="POST" class=" text-center" 
        action="includes/login.inc.php">

        <label></label><br>
                <input type="text" class="userpass" name="user_id" placeholder="username/email"><br>
                <label></label><br>
                <input type="password" class="userpass" name="user_pass" placeholder="password"><br>
                <a class="lp" href="reset-pwd.php">lupa password?</a>
                <input type="submit" class="button" name="login_but" value="Login">
                </form>
                <form>
                    <P>belum punya akun?</P>
                    <a href="register.php">
                    <button type="button" class="button">
                    <div >
                    <i class="button"></i> Register
                    </div>
              </button>
            </a>   
      
      </form>
    </div>
    <div class="col-md-3"></div>
    </div>
</div>  

<?php subview('footer.php'); ?> 
<script>
$(document).ready(function(){
  $('.input-group input').focus(function(){
    me = $(this) ;
    $("label[for='"+me.attr('id')+"']").addClass("animate-label");
  }) ;
  $('.input-group input').blur(function(){
    me = $(this) ;
    if ( me.val() == ""){
      $("label[for='"+me.attr('id')+"']").removeClass("animate-label");
    }
  }) ;
  // $('#test-form').submit(function(e){
  //   e.preventDefault() ;
  //   alert("Thank you") ;
  // })
});
</script>
</main>

 <?php subview('footer.php'); ?> 
