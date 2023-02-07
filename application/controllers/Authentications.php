<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Authentications extends CI_Controller
{
    public function index()
    {
        if($this->session->userdata("status") === TRUE)
        {
            redirect('profile');
        }
        else
        {
            $this->load->view('authentications/index');
        }
    }
    public function register()
    {
        $this->load->library("form_validation");
        $this->form_validation->set_rules("first_name","First name","required|max_length[48]|alpha");
        $this->form_validation->set_rules("last_name","Last name","required|max_length[48]|alpha");
        $this->form_validation->set_rules("contact","Contact number","required|numeric|max_length[11]|min_length[11]|is_unique[users.contact]");
        $this->form_validation->set_rules("password","Password","required|alpha_numeric");
        $this->form_validation->set_rules("passwordconf","Confirm Password","required|matches[password]");
        if($this->form_validation->run() === FALSE)
        {
            $errors = array();
            $errors["type"] = "register";
            $errors["first_name_error"] = form_error("first_name");
            $errors["last_name_error"] = form_error("last_name");
            $errors["contact_error"] = form_error("contact");
            $errors["password_error"] = form_error("password");
            $errors["passwordconf_error"] = form_error("passwordconf");
            $this->session->set_flashdata("errors", $errors);
            redirect('/');
        }
        else
        {
            //load model authentication
            $this->load->model('Authentication');
            //call create function and inject input post;
            $data = $this->input->post(NULL, TRUE);
            if($this->Authentication->create($data))
            {
                $this->session->set_userdata('status', TRUE);
                redirect('/profile'); 
            }
            else
            {
                echo "Failed";
            }
        }
        // var_dump($input);
        // $input = $this->input->post(NULL, TRUE);
        
    }
    public function login()
    {
        $contact = $this->input->post('contact');
        $password = $this->input->post('password');
        $this->load->library("form_validation");
        $this->form_validation->set_rules("contact","Contact Number","required|numeric");
        $this->form_validation->set_rules("password","Password","required");
        if($this->form_validation->run() === FALSE)
        {
            $errors = array();
            $errors["type"] = "login";
            $errors["contact"] = form_error("contact");
            $errors["password"] = form_error("password");
            $this->session->set_flashdata("errors", $errors);
            var_dump($errors);
            redirect('/');
        }
        else
        {
            $this->load->model("Authentication");
            $login = $this->Authentication->login($contact, $password);
            if($login === TRUE)
            {
                $this->session->set_userdata('status', TRUE);
                redirect('profile');
            }
            else
            {
                $errors = array();
                $errors["type"] = "login";
                $errors['login'] = $login;
                $this->session->set_flashdata('errors',$errors);
                redirect('/');
            }

        }
    }
    public function profile()
    {
        if($this->session->userdata('status') === TRUE)
        {
            $this->load->view('authentications/profile');
        }
        else
        {
            redirect('/');
        }
    }
    public function logout()
    {
        $this->session->set_userdata('status', FALSE);
        redirect('/');
    }
}
?>