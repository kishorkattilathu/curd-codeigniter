<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    public function email_exist_check($email) {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('email', $email);
        return $this->db->get()->num_rows();
        
    }

    public function create_user($user_data) {
       return $this->db->insert('users', $user_data);
    }

    public function get_user_by_email($email){
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('email', $email);
        return $this->db->get()->row_array();
    }

    public function get_user_data($limit,$start,$order,$dir){
        $this->db->select('*');
        $this->db->from('users');
        $this->db->limit($limit, $start);
        $this->db->order_by($order, $dir);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }else
        {
            return null;
        }
    }

    public function count_all_user(){
        $this->db->select('*');
        $this->db->from('users');
        return $this->db->count_all_results();
    }

    public function search_user_data($limit,$start,$order,$dir,$search) {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->group_start();
        $this->db->or_like('email', $search);
        $this->db->or_like('name', $search);
        $this->db->or_like('id', $search);
        $this->db->group_end();
        $this->db->limit($limit,$start);
        $this->db->order_by($order,$dir);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }else
        {
            return null;
        }
    }

    public function count_search_user_data($search){
        $this->db->like('id',$search);
        $query = $this->db->get('users');
        return $query->num_rows();
    }
}
