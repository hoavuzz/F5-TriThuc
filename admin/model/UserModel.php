<?php
class UserModel
{
    private PDO $conn;

    public function __construct(PDO $conn)
    {
        $this->conn = $conn;
    }

    public function getAllUsers()
    {
        $sql = "SELECT user_id, email, phone, username, status, role FROM users";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getUserById($id)
    {
        $sql = "SELECT * FROM users WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateUser($data)
    {
        $sql = "UPDATE users 
            SET email = :email, 
                phone = :phone, 
                username = :username, 
                role = :role, 
                status = :status,
                teacher_file = :teacher_file
            WHERE user_id = :user_id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($data);
    }


    public function deleteUserById($id)
    {
        $sql = "DELETE FROM users WHERE user_id = :user_id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute(['user_id' => $id]);
    }
}
