<?php include_once 'helpers/helper.php'; ?>

<?php subview('header.php'); ?>

<style>

body {
    background: #fff;  /* fallback for old browsers */
background: -webkit-linear-gradient(to right, #27bee4, #fff);  /* Chrome 10-25, Safari 5.1-6 */
background: linear-gradient(to right, #27bee4, #fff); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */


}

</style>
<?php
if(isset($_GET['error'])) {
    if($_GET['error'] === 'invalidemail') {
        echo '<script>alert("Invalid email")</script>';
    } else if($_GET['error'] === 'pwdnotmatch') {
        echo '<script>alert("Passwords do not match")</script>';
    } else if($_GET['error'] === 'sqlerror') {
        echo"<script>alert('Database error')</script>";
    } else if($_GET['error'] === 'usernameexists') {
        echo"<script>alert('Username already exists')</script>";
    } else if($_GET['error'] === 'emailexists') {
        echo"<script>alert('Email already exists')</script>";
    }
}
?>
<link rel="stylesheet" href="assets/css/login_user.css">
<main>
<div class="container-fluid mt-0 register">
<div class="row">
    <!-- <div class="col-md-3 register-left">
        
        <h3>Welcome</h3>
    </div> -->
    <div class="container">
            <img class="logo" src="assets/images/logoOkan.png">
            <!-- <h1>Pesawat Terbang<br>Garuda Indonesia</h1> -->
            <div class="form">
                <form method="POST" action="includes/admin/register.inc.php">
                <label></label><br>
                <input style="font-size: 15px;" type="text" class="userpass" name="username" placeholder="Masukan username"><br>
                <label></label><br>
                <input style="font-size: 15px;" type="text" class="userpass" name="email_id" placeholder="Masukan Email"><br>
                <label></label><br>
                <input style="font-size: 15px;" type="password" class="userpass" name="password" placeholder="Masukan password"><br> 
                <label></label><br>
                <input style="font-size: 15px;" type="password" class="userpass" name="password_repeat" placeholder="Konfirmasi password"><br> 
                <input type="submit" class="button" name="signup_submit" value="Daftar">
                <input type="button" class="button" value="Kembali" onclick="history.back(-1)">
            </form>
            </div>
        </div>     
    </div>
</div>
</main>

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