<?php

defined('BASEPATH') || exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require APPPATH . '/libraries/REST_Controller.php';

class Table extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
     public function city_get() {
        $offset = 0;
        $limit = 10;
        $sort = 'id';
        $order = 'DESC';
        $where = '';
        $table = $this->get('table');

        if ($this->post('id'))
            $id = $this->post('id');

        if ($this->get('offset'))
            $offset = $this->get('offset');
        if ($this->get('limit'))
            $limit = $this->get('limit');

        if ($this->get('sort'))
            $sort = $this->get('sort');
        if ($this->get('order'))
            $order = $this->get('order');

        if ($this->get('search')) {
            $search = $this->get('search');
            $where = "where (`id` like '%" . $search . "%' OR `city_name` like '%" . $search . "%')";
        }
        $query = $this->db->query("SELECT COUNT(*) as total FROM city $where");
        $res = $query->result();
        foreach ($res as $row1) {
            $total = $row1->total;
        }

        $query1 = $this->db->query("SELECT * FROM city  $where  ORDER BY  $sort  $order  LIMIT  $offset , $limit");
        $res1 = $query1->result();

        $bulkData = array();
        $bulkData['total'] = $total;
        $rows = array();
        $tempRow = array();
        $count = 1;
        foreach ($res1 as $row) {
           
            $operate = '<a class="btn btn-xs btn-primary edit-data" data-id=' . $row->id . ' data-toggle="modal" data-target="#editModal" title="Edit"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;';
            $operate .= '<a class="btn btn-xs btn-danger delete-data" data-id=' . $row->id . ' ><i class="fa fa-trash"></i></a>';

            $tempRow['id1'] = $count;
            $tempRow['id'] = $row->id;
            $tempRow['name'] = $row->city_name;
           
            $tempRow['operate'] = $operate;
            $rows[] = $tempRow;
            $count++;
        }

        $bulkData['rows'] = $rows;
        echo json_encode($bulkData, JSON_UNESCAPED_UNICODE);
    }

    public function category_get() {
        $offset = 0;
        $limit = 10;
        $sort = 'id';
        $order = 'DESC';
        $where = '';
        $table = $this->get('table');

        if ($this->post('id'))
            $id = $this->post('id');

        if ($this->get('offset'))
            $offset = $this->get('offset');
        if ($this->get('limit'))
            $limit = $this->get('limit');

        if ($this->get('sort'))
            $sort = $this->get('sort');
        if ($this->get('order'))
            $order = $this->get('order');

        if ($this->get('search')) {
            $search = $this->get('search');
            $where = "where (`id` like '%" . $search . "%' OR `cat_name` like '%" . $search . "%')";
        }
        
        $join = "LEFT JOIN city ON city.id = category.city_id ";
        
        $query = $this->db->query("SELECT COUNT(*) as total FROM category $join $where");
        $res = $query->result();
        foreach ($res as $row1) {
            $total = $row1->total;
        }

        $query1 = $this->db->query("SELECT category.*, city.city_name FROM category $join $where  ORDER BY  $sort  $order  LIMIT  $offset , $limit");
        $res1 = $query1->result();

        $bulkData = array();
        $bulkData['total'] = $total;
        $rows = array();
        $tempRow = array();
        $count = 1;
        foreach ($res1 as $row) {
            $image = (!empty($row->image)) ? 'images/category/' . $row->image : '';
            $operate = '<a class="btn btn-xs btn-primary edit-data" data-id=' . $row->id . ' data-image=' . $image . ' data-toggle="modal" data-target="#editModal" title="Edit"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;';
            $operate .= '<a class="btn btn-xs btn-danger delete-data" data-id=' . $row->id . ' data-image=' . $image . '><i class="fa fa-trash"></i></a>';

            $tempRow['id1'] = $count;
            $tempRow['city_id'] = $row->city_id;
            $tempRow['city_name'] = $row->city_name;
            $tempRow['id'] = $row->id;
            $tempRow['name'] = $row->category_name;
            $tempRow['image'] = '<a href=' . base_url() . 'images/category/' . $row->image . '  data-lightbox="Image"><img src=' . base_url() . 'images/category/' . $row->image . ' height=50, width=50 >';
            $tempRow['operate'] = $operate;
            $rows[] = $tempRow;
            $count++;
        }

        $bulkData['rows'] = $rows;
        echo json_encode($bulkData, JSON_UNESCAPED_UNICODE);
    }

    public function radio_station_get() {
        $offset = 0;
        $limit = 10;
        $sort = 'id';
        $order = 'DESC';
        $where = '';
        $table = $this->get('table');

        if ($this->post('id'))
            $id = $this->post('id');

        if ($this->get('offset'))
            $offset = $this->get('offset');
        if ($this->get('limit'))
            $limit = $this->get('limit');

        if ($this->get('sort'))
            $sort = $this->get('sort');
        if ($this->get('order'))
            $order = $this->get('order');

        if ($this->get('search')) {
            $search = $this->get('search');
            $where = "where (`id` like '%" . $search . "%' OR `category_name` like '%" . $search . "%')";
        }
        
        $join = "LEFT JOIN city ON city.id = r.city_id ";
        $join .= "LEFT JOIN category c ON c.id = r.cat_id ";

        $query = $this->db->query("SELECT COUNT(*) as total FROM radio_station r $join $where");
        $res = $query->result();
        foreach ($res as $row1) {
            $total = $row1->total;
        }

        $query1 = $this->db->query("SELECT r.*, c.category_name, city.city_name FROM radio_station r $join $where  ORDER BY  $sort  $order  LIMIT  $offset , $limit");
        $res1 = $query1->result();

        $bulkData = array();
        $bulkData['total'] = $total;
        $rows = array();
        $tempRow = array();
        $count = 1;
        foreach ($res1 as $row) {
            $image = (!empty($row->image)) ? 'images/radio_station/' . $row->image : '';
            $operate ='<a class="btn btn-xs btn-primary" href=' . $row->radio_url . ' target="_blank"><i class="fa fa-play-circle" aria-hidden="true"></i></a>&nbsp;';
            $operate .= '<a class="btn btn-xs btn-primary edit-data" data-id=' . $row->id . ' data-image=' . $image . ' data-toggle="modal" data-target="#editModal" title="Edit"><i class="fa fa-edit"></i></a>&nbsp;';
            $operate .= '<a class="btn btn-xs btn-danger delete-data" data-id=' . $row->id . ' data-image=' . $image . '><i class="fa fa-trash"></i></a>';

            $tempRow['id1'] = $count;
            $tempRow['id'] = $row->id;
            $tempRow['city_id'] = $row->city_id;
            $tempRow['city_name'] = $row->city_name;
            $tempRow['cat_id'] = $row->cat_id;
            $tempRow['category_name'] = $row->category_name;
            $tempRow['radio_name'] = $row->name;
            $tempRow['radio_url'] = $row->radio_url;
            $tempRow['image'] = '<a href=' . base_url() . 'images/radio_station/' . $row->image . ' data-lightbox="Image"><img src=' . base_url() . 'images/radio_station/' . $row->image . ' height=50, width=50 >';
             $tempRow['description'] = $row->description;
            $tempRow['operate'] = $operate;
            $rows[] = $tempRow;
            $count++;
        }

        $bulkData['rows'] = $rows;
        echo json_encode($bulkData, JSON_UNESCAPED_UNICODE);
    }

    public function notification_get() {
        $offset = 0;
        $limit = 10;
        $sort = 'id';
        $order = 'DESC';
        $where = '';
        $table = $this->get('table');

        if ($this->post('id'))
            $id = $this->post('id');

        if ($this->get('offset'))
            $offset = $this->get('offset');
        if ($this->get('limit'))
            $limit = $this->get('limit');

        if ($this->get('sort'))
            $sort = $this->get('sort');
        if ($this->get('order'))
            $order = $this->get('order');

        if ($this->get('search')) {
            $search = $this->get('search');
            $where = "where (`id` like '%" . $search . "%' OR `cat_id` like '%" . $search . "%')";
        }

        $join = "LEFT JOIN category c ON c.id = n.category_id ";
         $join .= "LEFT JOIN radio_station r ON r.id = n.radio_station_id ";

        $query = $this->db->query("SELECT COUNT(*) as total FROM notifications n $join $where");
        $res = $query->result();
        foreach ($res as $row1) {
            $total = $row1->total;
        }

        $query1 = $this->db->query("SELECT n.*, c.category_name, r.name FROM notifications n $join $where  ORDER BY  $sort  $order  LIMIT  $offset , $limit");
        $res1 = $query1->result();

        $bulkData = array();
        $bulkData['total'] = $total;
        $rows = array();
        $tempRow = array();
        $count = 1;
        foreach ($res1 as $row) {
            $image = (!empty($row->image)) ? 'images/notifications/' . $row->image : '';
            $operate = '<a class="btn btn-xs btn-danger delete-data" data-id=' . $row->id . ' data-image=' . $image . '><i class="fa fa-trash"></i></a>';

            $tempRow['id1'] = $count;
            $tempRow['id'] = $row->id;
            $tempRow['cate_id'] = $row->category_id;
            $tempRow['category'] = $row->category_name;
            $tempRow['radio_station'] = $row->name;
            $tempRow['title'] = $row->title;
            $tempRow['message'] = $row->message;
            $tempRow['date_sent']=$row->date_sent;
            $tempRow['image'] =  (!empty($row->image)) ? '<a href=' . base_url() . 'images/notifications/' . $row->image . ' data-lightbox="Image"><img src=' . base_url() . 'images/notifications/' . $row->image . ' height=50, width=50 >':'No Image';
            $tempRow['operate'] = $operate;
            $rows[] = $tempRow;
            $count++;
        }

        $bulkData['rows'] = $rows;
        echo json_encode($bulkData, JSON_UNESCAPED_UNICODE);
    }
    
    public function report_get() {
        $offset = 0;
        $limit = 10;
        $sort = 'id';
        $order = 'DESC';
        $where = '';
        $table = $this->get('table');

        if ($this->post('id'))
            $id = $this->post('id');

        if ($this->get('offset'))
            $offset = $this->get('offset');
        if ($this->get('limit'))
            $limit = $this->get('limit');

        if ($this->get('sort'))
            $sort = $this->get('sort');
        if ($this->get('order'))
            $order = $this->get('order');

        if ($this->get('search')) {
            $search = $this->get('search');
            $where = "where (`radio_station_report.id` like '%" . $search . "%' OR `radio_station_id` like '%" . $search . "%' OR `message` like '%" . $search . "%')";
        }
        
          $join = " JOIN radio_station c ON c.id = radio_station_report.radio_station_id ";
        
        $query = $this->db->query("SELECT COUNT(*) as total FROM radio_station_report $join $where");
        $res = $query->result();
        foreach ($res as $row1) {
            $total = $row1->total;
        }

        $query1 = $this->db->query("SELECT radio_station_report.*, c.name FROM radio_station_report  $join $where  ORDER BY  $sort  $order  LIMIT  $offset , $limit");
        $res1 = $query1->result();

        $bulkData = array();
        $bulkData['total'] = $total;
        $rows = array();
        $tempRow = array();
        $count = 1;
        foreach ($res1 as $row) {
            $operate = '<a class="btn btn-xs btn-danger delete-data" data-id=' . $row->id . '><i class="fa fa-trash"></i></a>';

            $tempRow['id1'] = $count;
            $tempRow['id'] = $row->id;
            $tempRow['name'] = $row->name;
            $tempRow['message'] = $row->message;
            $tempRow['operate'] = $operate;
            $rows[] = $tempRow;
            $count++;
        }

        $bulkData['rows'] = $rows;
        echo json_encode($bulkData, JSON_UNESCAPED_UNICODE);
    }
    
    public function slider_get() {
        $offset = 0;
        $limit = 10;
        $sort = 'id';
        $order = 'DESC';
        $where = '';
        $table = $this->get('table');

        if ($this->post('id'))
            $id = $this->post('id');

        if ($this->get('offset'))
            $offset = $this->get('offset');
        if ($this->get('limit'))
            $limit = $this->get('limit');

        if ($this->get('sort'))
            $sort = $this->get('sort');
        if ($this->get('order'))
            $order = $this->get('order');

        if ($this->get('search')) {
            $search = $this->get('search');
            $where = "where (`id` like '%" . $search . "%' OR `cat_id` like '%" . $search . "%')";
        }

         $join = "LEFT JOIN city ON city.id = s.city_id ";
        $join .= "LEFT JOIN category c ON c.id = s.category_id ";
         $join .= "LEFT JOIN radio_station r ON r.id = s.radio_station_id ";

        $query = $this->db->query("SELECT COUNT(*) as total FROM slider s $join $where");
        $res = $query->result();
        foreach ($res as $row1) {
            $total = $row1->total;
        }

        $query1 = $this->db->query("SELECT s.*, c.category_name, r.name, city.city_name FROM slider s $join $where  ORDER BY  $sort  $order  LIMIT  $offset , $limit");
        $res1 = $query1->result();

        $bulkData = array();
        $bulkData['total'] = $total;
        $rows = array();
        $tempRow = array();
        $count = 1;
        foreach ($res1 as $row) {
            $image = (!empty($row->image)) ? 'images/slider/' . $row->image : '';
            $operate = '<a class="btn btn-xs btn-primary edit-data" data-id=' . $row->id . ' data-image=' . $image . ' data-toggle="modal" data-target="#editModal" title="Edit"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;';
            $operate .= '<a class="btn btn-xs btn-danger delete-data" data-id=' . $row->id . ' data-image=' . $image . '><i class="fa fa-trash"></i></a>';

            $tempRow['id1'] = $count;
            $tempRow['id'] = $row->id;
            $tempRow['city_id'] = $row->city_id;
            $tempRow['city_name'] = $row->city_name;
            $tempRow['cate_id'] = $row->category_id;
            $tempRow['category_name'] = $row->category_name;
            $tempRow['radio_station_id'] = $row->radio_station_id;
            $tempRow['radio_station'] = $row->name;
            $tempRow['title'] = $row->title;
            $tempRow['image'] =  (!empty($row->image)) ? '<a href=' . base_url() . 'images/slider/' . $row->image . ' data-lightbox="Image"><img src=' . base_url() . 'images/slider/' . $row->image . ' height=50, width=50 >':'No Image';
            $tempRow['operate'] = $operate;
            $rows[] = $tempRow;
            $count++;
        }

        $bulkData['rows'] = $rows;
        echo json_encode($bulkData, JSON_UNESCAPED_UNICODE);
    }
}
