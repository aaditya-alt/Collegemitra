<?php 

require_once 'config.php';

class Admin extends Database{

    //Admin Login
    public function admin_login($username, $password){
        $sql = "SELECT username,password FROM admin WHERE username=:username AND password=:password";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['username'=>$username, 'password'=>$password]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row;
    }

    public function currentUser($username){
        $sql = "SELECT * FROM admin WHERE username=:username";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['username'=>$username]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row;
    }

    //FETCH ALL registered users 
    public function fetchAllUsers($counselling){
        $sql = "SELECT * FROM $counselling";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    //To fetch user's detail by id
    public function fetchUserDetailsByID($id,$counselling){
        $sql = "SELECT * FROM $counselling WHERE id=:id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id'=>$id]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    //Add Update to the database
    public function add_new_update($uid, $counselling, $title, $update, $pdf){
        $sql = "INSERT INTO updates (uid, title, `update`, pdf, counselling) VALUES (:uid, :title, :update, :pdf, :counselling)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['uid'=>$uid, 'title'=>$title, 'update'=>$update, 'pdf'=>$pdf, 'counselling'=>$counselling]);

        return true;
    }

    //fetch all updates of mentor
    public function get_updates($uid){
        $sql = "SELECT * FROM updates WHERE uid=:uid";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['uid'=>$uid]);

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    //fetch current update from database
    public function edit_update($id){
        $sql = "SELECT * FROM updates WHERE id=:id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id'=>$id]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result;
    }

    //Update mentor's update 
    public function update($id, $title, $update, $pdf){
        $sql = "UPDATE updates SET title=:title, `update`=:update, pdf=:pdf, updated_at =NOW() WHERE id=:id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['title'=>$title, 'update'=>$update, 'pdf'=>$pdf, 'id'=>$id]);

        return true;

    }

    //Delete update from database
    public function delete_update($id){
        $sql = "DELETE FROM updates WHERE id=:id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id'=>$id]);
        return true;
    }

    //Add user in the database via admin
    public function add_user($name,$counselling,$phone,$rank){
        $sql = "INSERT INTO $counselling (name,phone,counselling,rank) VALUES (:name, :phone,:counselling,:rank)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['name'=>$name, 'phone'=>$phone, 'counselling'=>$counselling, 'rank'=>$rank]);
        return true;
    }

    //display all call requests to mentor
    public function display_calls($counselling){
        $sql = "SELECT * FROM calling WHERE counselling=:counselling AND called!=1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['counselling'=>$counselling]);

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    //Delete call data from the admin panel 
    public function call_done($id){
        $sql = "UPDATE calling SET called=1 WHERE id=:id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id'=>$id]);
        return true;
    }

    //Send notification to user that admin called them
    public function call_notification($uid, $message){
        $sql = "INSERT INTO notification (uid, type, message) VALUES (:uid, 'user', :message)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['uid'=>$uid, 'message'=>$message]);
        return true;
    }

    //fetch all feedback of users 
    public function fetchFeedback($counselling){
        $sql = "SELECT feedback.id, feedback.subject, feedback.feedback, feedback.created_at, feedback.uid, users.name, users.email FROM feedback  INNER JOIN users ON feedback.uid=users.id WHERE replied!=1 AND feedback.counselling=:counselling ORDER BY feedback.id DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['counselling'=>$counselling]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    //Reply to user
    public function replyFeedback($uid, $message){
        $sql = "INSERT INTO notification (uid, type, message) VALUES (:uid, 'user', :message)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['uid'=>$uid, 'message'=>$message]);

        return true;
    }

    //Set feedback as replid 
    public function feedbackReplied($fid){
        $sql = "UPDATE feedback SET replied = 1 WHERE id=:fid";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['fid'=>$fid]);
        return true;
    }

    //fetch notification
    public function fetchNotification($counselling){
        $sql = "SELECT notification.id, notification.message, notification.created_at, users.name, users.email FROM notification INNER JOIN users ON notification.uid=users.id WHERE type='admin' AND notification.counselling=:counselling ORDER BY notification.id DESC LIMIT 5";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['counselling'=>$counselling]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    //remove notification
    public function removeNotification($id){
        $sql = "DELETE FROM notification WHERE id=:id AND type='admin' ";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id'=>$id]);
        return true;
    }

    //Fetch all users from db
    public function exportAllUsers($counselling){
        $sql = "SELECT * FROM users WHERE counselling=:counselling";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['counselling'=>$counselling]);

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    //Fetch all choice filling requests
    public function fetchAllChoiceFilling($counselling){
        $sql = "SELECT * FROM choice_filling WHERE counselling=:counselling AND sent=!1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['counselling'=>$counselling]);

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    //Send choice filling to the database
    public function sendChoiceFilling($uid, $cid, $message, $pdf, $time){
        $sql = "UPDATE choice_filling SET message = :message, pdf = :pdf, sent_at = :sent_at, sent=1 WHERE uid = :uid AND id = :cid";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['message'=>$message, 'pdf'=>$pdf, 'sent_at'=>$time, 'cid'=>$cid, 'uid'=>$uid]);
        
       return true;
    }

    

}

?>