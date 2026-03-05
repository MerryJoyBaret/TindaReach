<?php
require_once __DIR__ . '/../../core/model.php';

class User extends Model {

    public function register($fullname, $email, $password) {
        $hashed = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $this->db->prepare(
            "INSERT INTO users (fullname,email,password) 
             VALUES (:fullname,:email,:password)"
        );

        return $stmt->execute([
            ':fullname' => $fullname,
            ':email' => $email,
            ':password' => $hashed
        ]);
    }

    public function findByEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email=:email");
        $stmt->execute([':email'=>$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findById($id){
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id=:id");
        $stmt->execute([':id'=>$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function saveToken($user_id,$token) {
        $stmt = $this->db->prepare(
            "INSERT INTO email_verifications (user_id,token)
             VALUES (:uid,:token)"
        );
        return $stmt->execute([
            ':uid'=>$user_id,
            ':token'=>$token
        ]);
    }

    public function verifyToken($token) {
        $stmt = $this->db->prepare(
            "SELECT * FROM email_verifications WHERE token=:token"
        );
        $stmt->execute([':token'=>$token]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if($data){
            $update = $this->db->prepare(
                "UPDATE users SET is_verified=1 WHERE id=:id"
            );
            $update->execute([':id'=>$data['user_id']]);
            return true;
        }
        return false;
    }

    public function saveOTP($user_id,$otp,$expires){
        $stmt = $this->db->prepare(
            "INSERT INTO otp_codes (user_id,otp_code,expires_at)
             VALUES (:uid,:otp,:expires)"
        );
        return $stmt->execute([
            ':uid'=>$user_id,
            ':otp'=>$otp,
            ':expires'=>$expires
        ]);
    }

    public function verifyOTP($user_id,$otp){
        // Find the matching OTP
        $stmt = $this->db->prepare(
            "SELECT * FROM otp_codes 
             WHERE user_id=:uid 
             AND otp_code=:otp"
        );
        
        $stmt->execute([
            ':uid'=>$user_id,
            ':otp'=>$otp
        ]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if($row){
            // Check expiry in PHP
            $current_time = time();
            $expiry_time = strtotime($row['expires_at']);
            $is_expired = $expiry_time < $current_time;
            
            if($is_expired){
                // Delete expired OTP
                $del = $this->db->prepare("DELETE FROM otp_codes WHERE id=:id");
                $del->execute([':id'=>$row['id']]);
                return false;
            }
            
            // Valid OTP - delete it and return true
            $del = $this->db->prepare("DELETE FROM otp_codes WHERE id=:id");
            $del->execute([':id'=>$row['id']]);
            return true;
        }
        
        return false;
    }

    public function verifyGoogleUser($user_id) {
        $update = $this->db->prepare(
            "UPDATE users SET is_verified=1 WHERE id=:id"
        );
        return $update->execute([':id'=>$user_id]);
    }
}