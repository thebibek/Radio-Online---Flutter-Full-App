<?php

defined('BASEPATH') || exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require APPPATH . '/libraries/REST_Controller.php';

class Api extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        //ACCESS_KEY set in application/config/constants.php
    }

    public function get_city_post() {
        $access_key = $this->post('access_key');
        if (ACCESS_KEY != $access_key) {
            $response['error'] = "true";
            $response['message'] = "Invalid Access Key";
        } else {
            $data = $this->db->order_by("id", "DESC")->get("city")->result_array();
            if (count($data) > 0) {

                $response['error'] = "false";
                $response['data'] = $data;
            } else {
                $response['error'] = "true";
                $response['message'] = "No data found!";
            }
        }
        $this->response($response);
    }

    public function get_categories_by_city_post() {
        $access_key = $this->post('access_key');
        if (ACCESS_KEY != $access_key) {
            $response['error'] = "true";
            $response['message'] = "Invalid Access Key";
        } else {
            if ($this->post('city_id')) {
                $id = $this->post('city_id');
                $data = $this->db->where("city_id", $id)->order_by("id", "DESC")->get("category")->result_array();
                if (count($data) > 0) {
                    for ($i = 0; $i < count($data); $i++) {
                        $data[$i]['image'] = ($data[$i]['image']) ? base_url() . 'images/category/' . $data[$i]['image'] : '';
                    }
                    $response['error'] = "false";
                    $response['data'] = $data;
                } else {
                    $response['error'] = "true";
                    $response['message'] = "No data found!";
                }
            } else {
                $response['error'] = "true";
                $response['message'] = "Please fill all the data and submit!";
            }
        }
        $this->response($response);
    }

    public function get_categories_post() {
        $access_key = $this->post('access_key');
        if (ACCESS_KEY != $access_key) {
            $response['error'] = "true";
            $response['message'] = "Invalid Access Key";
        } else {
            $data = $this->db->order_by("id", "DESC")->get("category")->result_array();
            if (count($data) > 0) {
                for ($i = 0; $i < count($data); $i++) {
                    $data[$i]['image'] = ($data[$i]['image']) ? base_url() . 'images/category/' . $data[$i]['image'] : '';
                }
                $response['error'] = "false";
                $response['data'] = $data;
            } else {
                $response['error'] = "true";
                $response['message'] = "No data found!";
            }
        }
        $this->response($response);
    }

    public function get_radio_station_post() {
        $access_key = $this->post('access_key');
        if (ACCESS_KEY != $access_key) {
            $response['error'] = "true";
            $response['message'] = "Invalid Access Key";
        } else {
            $offset = ($this->post('offset')) ? $this->post('offset') : 0;
            $limit = ($this->post('limit')) ? $this->post('limit') : 10;

            $data = $this->db->order_by("id", "DESC")->limit($limit, $offset)->get("radio_station")->result_array();
            $data1 = $this->db->order_by("id", "DESC")->get("radio_station")->result_array();
            $count = count($data1);
            if (count($data) > 0) {
                for ($i = 0; $i < count($data); $i++) {
                    $data[$i]['image'] = ($data[$i]['image']) ? base_url() . 'images/radio_station/' . $data[$i]['image'] : '';
                }
                $response['error'] = "false";
                $response['total'] = "$count";
                $response['data'] = $data;
            } else {
                $response['error'] = "true";
                $response['total'] = "$count";
                $response['message'] = "No data found!";
            }
        }
        $this->response($response);
    }

    public function get_radio_station_by_category_post() {
        $access_key = $this->post('access_key');
        if (ACCESS_KEY != $access_key) {
            $response['error'] = "true";
            $response['message'] = "Invalid Access Key";
        } else {
            if ($this->post('category_id')) {
                $id = $this->post('category_id');
                $data = $this->db->where("cat_id", $id)->order_by("id", "DESC")->get("radio_station")->result_array();
                if (count($data) > 0) {
                    for ($i = 0; $i < count($data); $i++) {
                        $data[$i]['image'] = ($data[$i]['image']) ? base_url() . 'images/radio_station/' . $data[$i]['image'] : '';
                    }
                    $response['error'] = "false";
                    $response['data'] = $data;
                } else {
                    $response['error'] = "true";
                    $response['message'] = "No data found!";
                }
            } else {
                $response['error'] = "true";
                $response['message'] = "Please fill all the data and submit!";
            }
        }
        $this->response($response);
    }

    public function register_token_post() {
        $access_key = $this->post('access_key');
        if (ACCESS_KEY != $access_key) {
            $response['error'] = "true";
            $response['message'] = "Invalid Access Key";
        } else {
            if ($this->post('token')) {
                $token = $this->post('token');
                $sql = $this->db->where("token", $token)->get("tbl_token")->result();
                if (empty($sql)) {
                    $this->db->query("INSERT INTO tbl_token(token) VALUES ('$token')");
                    $response['error'] = "false";
                    $response['message'] = "Device registered successfully";
                } else {
                    $response['error'] = "true";
                    $response['message'] = "Device already registered";
                }
            } else {
                $response['error'] = "true";
                $response['message'] = "Please fill all the data and submit!";
            }
        }
        $this->response($response);
    }

    public function radio_station_report_post() {
        $access_key = $this->post('access_key');
        if (ACCESS_KEY != $access_key) {
            $response['error'] = "true";
            $response['message'] = "Invalid Access Key";
        } else {
            if ($this->post('radio_station_id') && $this->post('message')) {
                $data = array(
                    'radio_station_id' => $this->post('radio_station_id'),
                    'message' => $this->post('message'),
                    'date' => date("Y-m-d h:i:s") //$datetime->format('Y\-m\-d\ h:i:s'),
                );
                $this->db->insert('radio_station_report', $data);

                $response['error'] = "false";
                $response['message'] = "Report submitted successfully";
            } else {
                $response['error'] = "true";
                $response['message'] = "Please fill all the data and submit!";
            }
        }
        $this->response($response);
    }

    public function get_privacy_policy_post() {
        $access_key = $this->post('access_key');
        if (ACCESS_KEY != $access_key) {
            $response['error'] = "true";
            $response['message'] = "Invalid Access Key";
        } else {
            $data = $this->db->select("message")->where('type', 'privacy_policy')->get("settings")->result_array();
            if (count($data) > 0) {
                $response['error'] = "false";
                $response['data'] = $data[0]["message"];
            } else {
                $response['error'] = "true";
                $response['message'] = "No data found!";
            }
        }
        $this->response($response);
    }

    public function get_about_us_post() {
        $access_key = $this->post('access_key');
        if (ACCESS_KEY != $access_key) {
            $response['error'] = "true";
            $response['message'] = "Invalid Access Key";
        } else {
            $data = $this->db->select("message")->where('type', 'about_us')->get("settings")->result_array();
            if (count($data) > 0) {
                $response['error'] = "false";
                $response['data'] = $data[0]["message"];
            } else {
                $response['error'] = "true";
                $response['message'] = "No data found!";
            }
        }
        $this->response($response);
    }

    public function get_terms_conditions_post() {
        $access_key = $this->post('access_key');
        if (ACCESS_KEY != $access_key) {
            $response['error'] = "true";
            $response['message'] = "Invalid Access Key";
        } else {
            $data = $this->db->select("message")->where('type', 'terms_conditions')->get("settings")->result_array();
            if (count($data) > 0) {
                $response['error'] = "false";
                $response['data'] = $data[0]["message"];
            } else {
                $response['error'] = "true";
                $response['message'] = "No data found!";
            }
        }
        $this->response($response);
    }

    public function get_slider_post() {
        $access_key = $this->post('access_key');
        if (ACCESS_KEY != $access_key) {
            $response['error'] = "true";
            $response['message'] = "Invalid Access Key";
        } else {
            $this->db->select('s.id, s.category_id, s.radio_station_id, s.title AS name, s.image, c.category_name, r.radio_url, r.description');
            $this->db->from('slider s');
            $this->db->join('category c', 'c.id=s.category_id', 'left');
            $this->db->join('radio_station r', 'r.id=s.radio_station_id', 'left');
            $this->db->order_by('s.id', 'DESC');
            $query = $this->db->get();
            $data = $query->result_array();

            if (count($data) > 0) {
                for ($i = 0; $i < count($data); $i++) {
                    $data[$i]['image'] = ($data[$i]['image']) ? base_url() . 'images/slider/' . $data[$i]['image'] : '';
                }
                $response['error'] = "false";
                $response['data'] = $data;
            } else {
                $response['error'] = "true";
                $response['message'] = "No data found!";
            }
        }
        $this->response($response);
    }

    public function search_station_post() {
        $access_key = $this->post('access_key');
        if (ACCESS_KEY != $access_key) {
            $response['error'] = "true";
            $response['message'] = "Invalid Access Key";
        } else {
            $offset = 0;
            $limit = 10;
            $sort = 'id';
            $order = 'DESC';
            $where = '';

            if ($this->post('id'))
                $id = $this->post('id');

            if ($this->post('offset'))
                $offset = $this->post('offset');
            if ($this->post('limit'))
                $limit = $this->post('limit');

            if ($this->post('sort'))
                $sort = $this->post('sort');
            if ($this->post('order'))
                $order = $this->post('order');

            if ($this->post('keyword')) {
                $search = $this->post('keyword');
                $where = "where (`name` like '%" . $search . "%')";
            }

            $join = " JOIN category c ON c.id = r.cat_id ";

            $query1 = $this->db->query("SELECT r.*, c.category_name FROM radio_station r $join $where  ORDER BY  $sort  $order  LIMIT  $offset , $limit");
            $res1 = $query1->result();

            $rows = array();
            $tempRow = array();
            $count = 1;
            foreach ($res1 as $row) {
                $tempRow['id'] = $row->id;
                $tempRow['category_id'] = $row->cat_id;
                $tempRow['category_name'] = $row->category_name;
                $tempRow['name'] = $row->name;
                $tempRow['radio_url'] = $row->radio_url;
                $tempRow['image'] = base_url() . 'images/radio_station/' . $row->image;
                $tempRow['description'] = $row->description;
                $rows[] = $tempRow;
                $count++;
            }
            $response['error'] = "false";
            $response['data'] = $rows;
            $this->response($response);
        }
        $this->response($response);
    }
 
    public function get_city_mode_post() {
        $access_key = $this->post('access_key');
        if (ACCESS_KEY != $access_key) {
            $response['error'] = "true";
            $response['message'] = "Invalid Access Key";
        } else {
               $data = $this->db->select("message")->where('type', 'city_mode')->get("settings")->result_array();
            if (count($data) > 0) {
                 $response['error'] = "false";
                $response['data'] = $data[0]["message"];
            } else {
                $response['error'] = "true";
                $response['message'] = "No data found!";
            }
        }
        $this->response($response);
    }
}
