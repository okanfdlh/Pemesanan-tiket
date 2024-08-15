<?php
if(isset($_POST['signup_submit'])) {    
    require '../../helpers/init_conn_db.php';
    $username = $_POST['username'];
    $email_id = $_POST['email_id'];
    $password = $_POST['password'];
    $password_repeat = $_POST['password_repeat'];
    if(!filter_var($email_id,FILTER_VALIDATE_EMAIL)) {
        header('Location: ../../register_admin.php?error=invalidemail');
        exit();
    }
    else if($password !== $password_repeat) {
        header('Location: ../../register_admin.php?error=pwdnotmatch');
        exit();
    }
    else {
        $username_sql = 'SELECT admin_uname FROM Admin WHERE admin_uname=?';
        $email_sql = 'SELECT admin_email FROM Admin WHERE admin_email=?';
       $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt,$username_sql)) {
            header('Location: ../../register_admin.php?error=sqlerror');
            exit();            
        } else {
            mysqli_stmt_bind_param($stmt,'s',$username);            
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);            
            $username_check = mysqli_stmt_num_rows($stmt);
            if($username_check > 0) {
                header('Location: ../../register_admin.php?error=usernameexists');
                exit();                  
            } else {
                $stmt = mysqli_stmt_init($conn);
                if(!mysqli_stmt_prepare($stmt,$email_sql)) {
                    header('Location: ../../register_admin.php?error=sqlerror');
                    exit();            
                } else {
                    mysqli_stmt_bind_param($stmt,'s',$email_id);            
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_store_result($stmt);
                    $email_check = mysqli_stmt_num_rows($stmt);
                    if($email_check > 0) {
                        header('Location: ../../register_admin.php?error=emailexists');
                        exit();   
                    } else {
                        $sql = 'INSERT INTO admin (admin_uname,admin_email,admin_pwd) VALUES (?,?,?)';
                        $stmt = mysqli_stmt_init($conn);
                        if(!mysqli_stmt_prepare($stmt,$sql)) {
                            header('Location: ../../register_admin.php?error=sqlerror');
                            exit();            
                        } else {
                            $pwd_hash = password_hash($password, PASSWORD_DEFAULT);
                            mysqli_stmt_bind_param($stmt,'sss',$username,$email_id,$pwd_hash);            
                            mysqli_stmt_execute($stmt);  
                            
                            // LOGIN USer                            
                            $sql = 'SELECT * FROM admin WHERE admin_uname=? OR admin_email=?;';
                            $stmt = mysqli_stmt_init($conn);
                            if(!mysqli_stmt_prepare($stmt,$sql)) {
                                header('Location: ../../admin/index.php?error=sqlerror');
                                exit();            
                            } else {
                                mysqli_stmt_bind_param($stmt,'ss',$username,$username);            
                                mysqli_stmt_execute($stmt);
                                $result = mysqli_stmt_get_result($stmt);
                                if($row = mysqli_fetch_assoc($result)) {
                                    $pwd_check = password_verify($password,$row['admin_pwd']);
                                    if($pwd_check == false) {
                                        header('Location: ../../admin/index.php?error=wrongpwd');
                                        exit();    
                                    }
                                    else if($pwd_check == true) {
                                        session_start();
                                        $_SESSION['adminId'] = $row['adminId'];
                                        $_SESSION['adminUname'] = $row['adminUname'];                                       
                                        header('Location: ../../admin/index.php?login=success');
                                        exit();                  
                                    } else {
                                        header('Location: ../../admin/index.php?error=invalidcred');
                                        exit();                    
                                    }
                                }
                            }                                                    
                        }
                    }
                }               
            }            
        }
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
} else {
    header('Location: ../../register_admin.php');
    exit();  
}
