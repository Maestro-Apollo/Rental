<?php
session_start();

include('class/database.php');
class signInUp extends database
{
    protected $link;

    public function signInFunction()
    {

        $agent_name = addslashes(trim($_POST['agent_name']));
        $password = addslashes(trim($_POST['passwordLogIn']));

        $sql = "select * from user_tbl where username = '$agent_name' ";
        $res = mysqli_query($this->link, $sql);
        if (mysqli_num_rows($res) > 0) {
            return '<div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Agent name is taken!</strong>
          </div>';
        } else {
            $pass = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO `user_tbl` (`user_id`, `username`, `password`, `created_at`) VALUES (NULL, '$agent_name', '$pass', CURRENT_TIMESTAMP)";
            $res = mysqli_query($this->link, $sql);
            if ($res) {
                return '<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Successfully Created!</strong>
              </div>';
            }
        }
    }
    # code...

}
$obj = new signInUp;
echo $obj->signInFunction();