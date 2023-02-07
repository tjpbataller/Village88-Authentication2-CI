<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Authentication extends CI_Model
{
    public function show_data()
    {

    }

    public function create($post)
    {
        //Generate salt
        $salt = bin2hex(openssl_random_pseudo_bytes(22));
        //Encrypt password
        $password = $post['password'];
        $encrypted_password = md5($password);
        $real_password = $encrypted_password.$salt;
        //generate query
        $query = "INSERT INTO users(first_name, last_name, contact, password, created_at, salt) VALUES (?,?,?,?,?,?)";
        //arrange data into array accordingly
        $data = array();
        $data['first_name'] = $post['first_name'];
        $data['last_name'] = $post['last_name'];
        $data['contact'] = $post['contact'];
        $data['password'] = $real_password;
        $data['created_at'] = date('Y-d-m H:i:s');
        $data['salt'] = $salt;
        if($this->db->query($query, $data))
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
        
    }

    public function login($contact, $password)
    {
        //query to get salt of user
        $query = "SELECT salt FROM users WHERE contact = ?";
        if($result = $this->db->query($query, $contact)->row_array())
        {
            //construct query to get user
            $salt = $result['salt'];
            $query = "SELECT * FROM users WHERE contact = ? AND password = ?";
            $enc_password = md5($password);
            $salted_pass =  $enc_password.$salt;
            $values = array($contact, $salted_pass);
            if($this->db->query($query, $values)->row_array())
            {
                return TRUE;
            }   
            else
            {
                return "Account does not exist.";
            }
        }
        else
        {
            return "Account does not exist.";
        }

    }   
}

?>