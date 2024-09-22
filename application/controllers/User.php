<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('User_model');
    }
		public function index()
	{
		$this->load->view('login');
	}
		public function register()
	{
        // die('end');
		$this->load->view('registration');
	}
		public function signup(){
            $return_array = ['status'=> false, 'message' => ''];

            $name = $this->input->post('name');
            $email = $this->input->post('email');
            $password = $this->input->post('password');
            $password_confirmation = $this->input->post('password_confirmation');

            // print_r($_POST);
            $email_exist = $this->User_model->email_exist_check($email);
            // print_r($email_exist);
            if (!$email_exist) {
                if ($password == $password_confirmation) {
                    $hashpassword = password_hash($password, PASSWORD_DEFAULT);
                    $user_data = [
                        'name' => $name,
                        'email' => $email,
                        'password' => $hashpassword
                    ];
                    if($user_data){
                       $user_created =  $this->User_model->create_user($user_data);
                       if($user_created){
                            $return_array['status'] = true;
                            $return_array['message'] = 'User Registered Successfully';
                            $this->session->set_userdata('user_data',$user_data);
                            $return_array['redirect_url'] = base_url('User/dashboard');
                       }else{
                            $return_array['message'] = 'Failed try again';
                       }
                    }
                }else{
                    $return_array['message'] = 'Password mis match';
                }
            }else{
                $return_array['message'] = 'Email Already exist';
            }

            echo json_encode($return_array);
	}

    public function dashboard(){
        $this->load->view('dashboard');
    }
    public function session(){
        print_r($_SESSION);die('hello');
        // $this->load->view('dashboard');
    }
    public function logout(){
        // print_r($_SESSION);die('hello');
        $this->session->sess_destroy('user_data');
        redirect('/');
    }

    public function login(){
        $return_array = ['status'=> false, 'message'=>''];

        $email = $this->input->post('email');
        $password = $this->input->post('password');

        $user_exist = $this->User_model->get_user_by_email($email);
        // echo"<pre>";print_r($user_exist);die("end of code");echo"</pre>";
        if($user_exist)
        {
        // echo"<pre>";print_r($user_exist['password']);die("end of code");echo"</pre>";

            $hash_password = $user_exist['password'];
            if(password_verify($password,$hash_password)){
                $return_array['status'] = true;
                $return_array['message'] = 'Login Successfull';
                $this->session->set_userdata('user_data' , $user_exist);
                $return_array['redirect_url'] = base_url('User/dashboard');
            }else{
                $return_array['message'] = 'Wrong Credentials';
            }
        }else{
            $return_array['message'] = 'Email does  not exist';
        }
        echo json_encode($return_array);
    }

    public function user_table(){
        $this->load->view('responsive_table');
    }

    public function get_user_data(){
        
        // echo"<pre>";print_r($users_data);die("end of code");echo"</pre>";
        $columns = ['id','name','email','status','action'];
        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
        $totaldata = $this->User_model->count_all_user();
        $totalFiltered = $totaldata;

        if (empty($this->input->post('search')['value'])) {
            $users_data = $this->User_model->get_user_data($limit,$start,$order,$dir);

        }else{
            $search = $this->input->post('search')['value'];
            $users_data = $this->User_model->search_user_data($limit,$start,$order,$dir,$search);
            $totalFiltered = $this->User_model->count_search_user_data($search);
        }

        $data = [];
        if (!empty($users_data))
        {
            foreach($users_data as $user)
            {
                $nestedData['id'] = $user->id;
                $nestedData['name'] = $user->name;
                $nestedData['email'] = $user->email;
                $nestedData['status'] = $user->status;
                $nestedData['action'] = '<button Onclick="get_user_data('.$user->id.')" class="btn btn-sm btn-primary">view</button>';
                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw" => intval($this->input->post('draw')),
            "recordsTotal" => intval($totaldata),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );
        echo json_encode($json_data);
    }
}
