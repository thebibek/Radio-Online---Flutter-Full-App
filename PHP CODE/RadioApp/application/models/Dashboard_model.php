<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model {

    public function count_City() {
        return $this->db->count_all("city");
    }

    public function count_Category() {
        return $this->db->count_all("category");
    }

    public function count_Radio_Station() {
        return $this->db->count_all("radio_station");
    }

    public function count_Slider() {
        return $this->db->count_all("slider");
    }

    public function get_full_logo() {
        $query = $this->db->get_where('settings', array('type' => 'logo_full'));
        return $query->row_array();
    }

    public function get_half_logo() {
        $query = $this->db->get_where('settings', array('type' => 'logo_half'));
        return $query->row_array();
    }

    public function get_city() {
        return $this->db->order_by("id", "desc")->get('city')->result();
    }

    public function get_category() {
        return $this->db->order_by("id", "desc")->get('category')->result();
    }

    public function add_city() {
        $frm_data = array(
            'city_name' => $this->input->post('name'),
        );
        $this->db->insert('city', $frm_data);
    }

    public function update_city() {
        $id = $this->input->post('city_id');
        $frm_data = array(
            'city_name' => $this->input->post('update_name'),
        );
        $this->db->where('id', $id);
        $this->db->update('city', $frm_data);
    }

    public function delete_city($id) {
        $this->db->where('id', $id)->delete('city');
    }

    public function add_notifications() {
        $title = $this->input->post('title');
        $message = $this->input->post('message');
        $category_id = ($this->input->post('cat_id') != 0) ? $this->input->post('cat_id') : "";
        $radio_station_id = ($this->input->post('radio_sation') != 0) ? $this->input->post('radio_sation') : "";
        $newMsg = array();

        if ($_FILES['image']['name'] == '') {
            $frm_data = array(
                'category_id' => $category_id,
                'radio_station_id' => $radio_station_id,
                'title' => $title,
                'message' => $message
            );
            $this->db->insert('notifications', $frm_data);
            $fcmMsg = array(
                'click_action' => 'FLUTTER_NOTIFICATION_CLICK',
                'category' => $category_id,
                'radio_station_id' => $radio_station_id,
                'title' => $title,
                'message' => $message,
                'image' => null
            );
        } else {
            // create folder 
            if (!is_dir('images/notifications')) {
                mkdir('./images/notifications', 0777, TRUE);
            }
            $image = time();
            $config['upload_path'] = './images/notifications/';
            $config['allowed_types'] = 'jpg|png|jpeg|JPG|PNG|JPEG';
            $config['file_name'] = $image;

            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if (!$this->upload->do_upload('image')) {
                return FALSE;
            } else {
                $data = $this->upload->data();
                $img = $data['file_name'];
                //Setting values for tabel columns
                $frm_data = array(
                    'category_id' => $category_id,
                    'radio_station_id' => $radio_station_id,
                    'title' => $title,
                    'message' => $message,
                    'image' => $img
                );
                $this->db->insert('notifications', $frm_data);
                $fcmMsg = array(
                    'click_action' => 'FLUTTER_NOTIFICATION_CLICK',
                    'category' => $category_id,
                    'radio_station_id' => $radio_station_id,
                    'title' => $title,
                    'message' => $message,
                    'image' => base_url() . 'images/notifications/' . $img
                );
            }
        }
//      $newMsg['data'] = $fcmMsg;
        //notification 
        $data = $this->db->select('fcm_key')->where("id", 1)->get("tbl_fcm_key")->row_array();
        define('API_ACCESS_KEY', $data['fcm_key']);

        $devicetoken1 = array();
        $devicetoken = $this->db->select("token")->get("tbl_token")->result_array();
        foreach ($devicetoken as $value) {
            $devicetoken1[] = $value['token'];
        }
//      print_r($devicetoken1);

        $registrationIDs_chunks = array_chunk($devicetoken1, 1000);
        // print_r($registrationIDs_chunks);
        $success = $failure = 0;

        foreach ($registrationIDs_chunks as $registrationIDs) {
            $fcmFields = array(
                'registration_ids' => $registrationIDs, // expects an array of ids
                'priority' => 'high',
                'notification' => $fcmMsg,
                'data' => $fcmMsg
            );
            //print_r(json_encode($fcmFields));
            $headers = array(
                'Authorization: key=' . API_ACCESS_KEY,
                'Content-Type: application/json'
            );

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmFields));
            $result = curl_exec($ch);

            if ($result === FALSE) {
                die('Curl failed: ' . curl_error($ch));
            }
            //Now close the connection
            curl_close($ch);
        }
        return $result;
    }

    public function delete_report($id) {
        $this->db->where('id', $id);
        $this->db->delete('radio_station_report');
    }

    public function delete_notification($id, $image_url) {
        //Delete image from folder 
        if ($image_url) {
            unlink($image_url);
        }
        $this->db->where('id', $id);
        $this->db->delete('notifications');
    }

    public function get_fcm_key() {
        $query = $this->db->get_where('tbl_fcm_key', array('id' => 1));
        return $query->row_array();
    }

    public function notification_settings() {
        $fcm_key = $this->input->post('message');

        $count = $this->db->count_all('tbl_fcm_key');
        if ($count <= 0) {
            $this->db->query("INSERT INTO tbl_fcm_key(fcm_key) VALUES ('$fcm_key')");
        } else {
            $this->db->query("UPDATE tbl_fcm_key SET fcm_key='$fcm_key' WHERE id=1");
        }
    }

    public function update_profile() {
        $full_url = $this->input->post('full_url');
        $half_url = $this->input->post('half_url');
        // create folder 
        if (!is_dir('images/profile')) {
            mkdir('./images/profile', 0777, TRUE);
        }
        if ($_FILES['full_file']['name'] != '' && $_FILES['half_file']['name'] != '') {
            //Full logo upload
            $config = array();
            $config['upload_path'] = './images/profile/';
            $config['allowed_types'] = 'jpg|png|jpeg|JPG|PNG|JPEG';
            $config['file_name'] = time();
            $this->load->library('upload', $config, 'fullupload'); // Create custom object for cover upload
            $this->fullupload->initialize($config);

            // half logo upload
            $config1 = array();
            $config1['upload_path'] = './images/profile/';
            $config1['allowed_types'] = 'jpg|png|jpeg|JPG|PNG|JPEG';
            $config1['file_name'] = time();
            $this->load->library('upload', $config1, 'halfupload');  // Create custom object for catalog upload
            $this->halfupload->initialize($config1);

            // Check uploads success
            if ($this->fullupload->do_upload('full_file') && $this->halfupload->do_upload('half_file')) {

                // Data of your full logo file
                $full_data = $this->fullupload->data();
                $full_file = $full_data['file_name'];

                if (file_exists($full_url)) {
                    unlink($full_url);
                }

                // Data of your half logo file
                $half_data = $this->halfupload->data();
                $half_file = $half_data['file_name'];


                if (file_exists($half_url)) {
                    unlink($half_url);
                }
                $this->db->query("update settings set message='$half_file' where id=5");
                $this->db->query("update settings set message='$full_file' where id=4");
                return 1;
            } else {
                $data = array(
                    'half' => $this->halfupload->display_errors(),
                    'full' => $this->halfupload->display_errors()
                );
                if ($data) {
                    return 0;
                }
            }
        }
        if ($_FILES['full_file']['name'] != '' && $_FILES['half_file']['name'] == '') {
            $config['upload_path'] = './images/profile/';
            $config['allowed_types'] = 'jpg|png|jpeg|JPG|PNG|JPEG';
            $config['file_name'] = time();
            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if (!$this->upload->do_upload('full_file')) {
                $data1 = $this->upload->display_errors();
                if ($data1) {
                    return 0;
                }
            } else {
                if (file_exists($full_url)) {
                    unlink($full_url);
                }

                $data = $this->upload->data();
                $img = $data['file_name'];
                $this->db->query("update settings set message='$img' where id=4");
                return 1;
            }
        }

        if ($_FILES['half_file']['name'] != '' && $_FILES['full_file']['name'] == '') {
            $config['upload_path'] = './images/profile/';
            $config['allowed_types'] = 'jpg|png|jpeg|JPG|PNG|JPEG';
            $config['file_name'] = time();
            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if (!$this->upload->do_upload('half_file')) {
                $data1 = $this->upload->display_errors();
                if ($data1) {
                    return 0;
                }
            } else {
                if (file_exists($half_url)) {
                    unlink($half_url);
                }
                $data = $this->upload->data();
                $img = $data['file_name'];
                $this->db->query("update settings set message='$img' where id=5");
                return 1;
            }
        }
    }

    public function add_slider() {
        // create folder 
        if (!is_dir('images/slider')) {
            mkdir('./images/slider', 0777, TRUE);
        }

        $image = time();
        $config['upload_path'] = './images/slider/';
        $config['allowed_types'] = 'jpg|png|jpeg|JPG|PNG|JPEG';
        $config['file_name'] = $image;

        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if (!$this->upload->do_upload('file')) {
            return FALSE;
        } else {
            $data = $this->upload->data();
            $img = $data['file_name'];

            //Setting values for tabel columns
            if (is_city_mode_enabled() == 1) {
                $frm_data = array(
                    'city_id' => $this->input->post('city_id'),
                    'category_id' => $this->input->post('cat_id'),
                    'radio_station_id' => $this->input->post('radio_sation'),
                    'title' => $this->input->post('title'),
                    'image' => $img
                );
            } else {
                $frm_data = array(
                    'category_id' => $this->input->post('cat_id'),
                    'radio_station_id' => $this->input->post('radio_sation'),
                    'title' => $this->input->post('title'),
                    'image' => $img
                );
            }
            if ($this->db->insert('slider', $frm_data)) {
                return TRUE;
            } else {
                return FALSE;
            }
        }
    }

    public function update_slider() {
        $id = $this->input->post('slider_id');

        if ($_FILES['update_file']['name'] == '') {
            if (is_city_mode_enabled() == 1) {
                $frm_data = array(
                    'city_id' => $this->input->post('update_city_id'),
                    'category_id' => $this->input->post('update_cat_id'),
                    'radio_station_id' => $this->input->post('update_radio_sation'),
                    'title' => $this->input->post('update_title')
                );
            } else {
                $frm_data = array(
                    'category_id' => $this->input->post('update_cat_id'),
                    'radio_station_id' => $this->input->post('update_radio_sation'),
                    'title' => $this->input->post('update_title')
                );
            }
            $this->db->where('id', $id);
            $this->db->update('slider', $frm_data);

            return TRUE;
        } else {
            // create folder 
            if (!is_dir('images/slider')) {
                mkdir('./images/slider', 0777, TRUE);
            }

            $image = time();
            $config['upload_path'] = './images/slider/';
            $config['allowed_types'] = 'jpg|png|jpeg|JPG|PNG|JPEG';
            $config['file_name'] = $image;

            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if (!$this->upload->do_upload('update_file')) {
                return FALSE;
            } else {
                //Delete file from project folder
                $image_url = $this->input->post('image_url');
                unlink($image_url);

                $data = $this->upload->data();
                $img = $data['file_name'];

                if (is_city_mode_enabled() == 1) {
                    $frm_data = array(
                        'city_id' => $this->input->post('update_city_id'),
                        'category_id' => $this->input->post('update_cat_id'),
                        'radio_station_id' => $this->input->post('update_radio_sation'),
                        'title' => $this->input->post('update_title'),
                        'image' => $img
                    );
                } else {
                    $frm_data = array(
                        'category_id' => $this->input->post('update_cat_id'),
                        'radio_station_id' => $this->input->post('update_radio_sation'),
                        'title' => $this->input->post('update_title'),
                        'image' => $img
                    );
                }

                $this->db->where('id', $id);               

                if ($this->db->update('slider', $frm_data)) {
                    return TRUE;
                } else {
                    return FALSE;
                }
            }
        }
    }

    public function delete_slider($id, $image_url) {
        //Delete image from folder 
        unlink($image_url);
        $this->db->where('id', $id)->delete('slider');
    }

    public function add_category() {
        // create folder 
        if (!is_dir('images/category')) {
            mkdir('./images/category', 0777, TRUE);
        }

        $image = time();
        $config['upload_path'] = './images/category/';
        $config['allowed_types'] = 'jpg|png|jpeg|JPG|PNG|JPEG';
        $config['file_name'] = $image;

        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if (!$this->upload->do_upload('file')) {
            return FALSE;
        } else {
            $data = $this->upload->data();
            $img = $data['file_name'];

            //Setting values for tabel columns
            if (is_city_mode_enabled() == 1) {
                $frm_data = array(
                    'city_id' => $this->input->post('city_id'),
                    'category_name' => $this->input->post('name'),
                    'image' => $img
                );
            } else {
                $frm_data = array(
                    'category_name' => $this->input->post('name'),
                    'image' => $img
                );
            }

            if ($this->db->insert('category', $frm_data)) {
                return TRUE;
            } else {
                return FALSE;
            }
        }
    }

    public function update_category() {
        $id = $this->input->post('category_id');

        if ($_FILES['update_file']['name'] == '') {
            if (is_city_mode_enabled() == 1) {
                $frm_data = array(
                    'city_id' => $this->input->post('update_city_id'),
                    'category_name' => $this->input->post('update_name')
                );
            } else {
                $frm_data = array(
                    'category_name' => $this->input->post('update_name')
                );
            }
            $this->db->where('id', $id);
            $this->db->update('category', $frm_data);
            return TRUE;
        } else {
            // create folder 
            if (!is_dir('images/category')) {
                mkdir('./images/category', 0777, TRUE);
            }

            $image = time();
            $config['upload_path'] = './images/category/';
            $config['allowed_types'] = 'jpg|png|jpeg|JPG|PNG|JPEG';
            $config['file_name'] = $image;

            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if (!$this->upload->do_upload('update_file')) {
                return FALSE;
            } else {
                //Delete file from project folder
                $image_url = $this->input->post('image_url');
                unlink($image_url);

                $data = $this->upload->data();
                $img = $data['file_name'];

                if (is_city_mode_enabled() == 1) {
                    $frm_data = array(
                        'city_id' => $this->input->post('update_city_id'),
                        'category_name' => $this->input->post('update_name'),
                        'image' => $img
                    );
                } else {
                    $frm_data = array(
                        'category_name' => $this->input->post('update_name'),
                        'image' => $img
                    );
                }
                $this->db->where('id', $id);
                if ($this->db->update('category', $frm_data)) {
                    return TRUE;
                } else {
                    return FALSE;
                }
            }
        }
    }

    public function delete_category($id, $image_url) {
        //Delete Image Gallery from project folder
        $slider = $this->db->where('category_id', $id)->get('slider')->result();
        if ($slider) {
            foreach ($slider as $row) {
                unlink('images/slider/' . $row->image);
            }
            $this->db->where('category_id', $id)->delete('slider');
        }


        $result = $this->db->where('cat_id', $id)->get('radio_station')->result();
        foreach ($result as $value) {
            unlink('images/radio_station/' . $value->image);
        }
        $this->db->where('cat_id', $id)->delete('radio_station');

        //Delete image from folder 
        unlink($image_url);
        $this->db->where('id', $id)->delete('category');
    }

    public function add_radio_station() {
        // create folder 
        if (!is_dir('images/radio_station')) {
            mkdir('./images/radio_station', 0777, TRUE);
        }

        $image = time();
        $config['upload_path'] = './images/radio_station/';
        $config['allowed_types'] = 'jpg|png|jpeg|JPG|PNG|JPEG';
        $config['file_name'] = $image;

        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if (!$this->upload->do_upload('file')) {
            return FALSE;
        } else {
            $data = $this->upload->data();
            $img = $data['file_name'];

            if (is_city_mode_enabled() == 1) {
                $frm_data = array(
                    'city_id' => $this->input->post('city_id'),
                    'cat_id' => $this->input->post('cat_id'),
                    'name' => $this->input->post('radio_name'),
                    'radio_url' => $this->input->post('radio_url'),
                    'image' => $img,
                    'description' => $this->input->post('description')
                );
            } else {
                $frm_data = array(
                    'cat_id' => $this->input->post('cat_id'),
                    'name' => $this->input->post('radio_name'),
                    'radio_url' => $this->input->post('radio_url'),
                    'image' => $img,
                    'description' => $this->input->post('description')
                );
            }

            if ($this->db->insert('radio_station', $frm_data)) {
                return TRUE;
            } else {
                return FALSE;
            }
        }
    }

    public function update_radio_station() {
        $id = $this->input->post('radio_station_id');

        if ($_FILES['update_file']['name'] == '') {
            if (is_city_mode_enabled() == 1) {
                $frm_data = array(
                    'city_id' => $this->input->post('update_city_id'),
                    'cat_id' => $this->input->post('update_cat_id'),
                    'name' => $this->input->post('update_name'),
                    'radio_url' => $this->input->post('update_radio_url'),
                    'description' => $this->input->post('update_description')
                );
            } else {
                $frm_data = array(
                    'cat_id' => $this->input->post('update_cat_id'),
                    'name' => $this->input->post('update_name'),
                    'radio_url' => $this->input->post('update_radio_url'),
                    'description' => $this->input->post('update_description')
                );
            }
            $this->db->where('id', $id);
            $this->db->update('radio_station', $frm_data);
            return TRUE;
        } else {
            // create folder 
            if (!is_dir('images/radio_station')) {
                mkdir('./images/radio_station', 0777, TRUE);
            }
//            $image = $this->input->post('update_file');
            $image = time();
            $config['upload_path'] = './images/radio_station/';
            $config['allowed_types'] = 'jpg|png|jpeg|JPG|PNG|JPEG';
            $config['file_name'] = $image;

            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if (!$this->upload->do_upload('update_file')) {
                return FALSE;
            } else {
                //Delete file from project folder
                $image_url = $this->input->post('image_url');
                unlink($image_url);

                $data = $this->upload->data();
                $img = $data['file_name'];

                if (is_city_mode_enabled() == 1) {
                    $frm_data = array(
                        'city_id' => $this->input->post('update_city_id'),
                        'cat_id' => $this->input->post('update_cat_id'),
                        'name' => $this->input->post('update_name'),
                        'radio_url' => $this->input->post('update_radio_url'),
                        'image' => $img,
                        'description' => $this->input->post('update_description')
                    );
                } else {
                    $frm_data = array(
                        'cat_id' => $this->input->post('update_cat_id'),
                        'name' => $this->input->post('update_name'),
                        'radio_url' => $this->input->post('update_radio_url'),
                        'image' => $img,
                        'description' => $this->input->post('update_description')
                    );
                }

                $this->db->where('id', $id);

                if ($this->db->update('radio_station', $frm_data)) {
                    return TRUE;
                } else {
                    return FALSE;
                }
            }
        }
    }

    public function delete_radio_station($id, $image_url) {
        //Delete image from folder 
        $slider = $this->db->where('radio_station_id', $id)->get('slider')->result();
        foreach ($slider as $row) {
            unlink('images/slider/' . $row->image);
        }
        $this->db->where('radio_station_id', $id)->delete('slider');

        unlink($image_url);
        $this->db->where('id', $id)->delete('radio_station');
    }

    public function get_city_mode() {
        return $this->db->where('type', 'city_mode')->get('settings')->result();
    }

    public function system_settings() {
        $message = $this->input->post('city_mode');
        $this->db->query("update settings set message='$message' WHERE id=6");
    }

    public function get_about_us() {
        return $this->db->where('type', 'about_us')->get('settings')->result();
    }

    public function update_about_us() {
        $message = $this->input->post('message');
        $this->db->query("update settings set message=" . $this->db->escape($message) . " WHERE id=3");
    }

    public function get_privacy_policy() {
        return $this->db->where('type', 'privacy_policy')->get('settings')->result();
    }

    public function update_privacy_policy() {
        $message = $this->input->post('message');
        $this->db->query("update settings set message=" . $this->db->escape($message) . " WHERE id=1");
    }

    public function get_terms_conditions() {
        return $this->db->where('type', 'terms_conditions')->get('settings')->result();
    }

    public function update_terms_conditions() {
        $message = $this->input->post('message');
        $this->db->query("update settings set message=" . $this->db->escape($message) . " WHERE id=2");
    }

    public function change_password($aid, $apass) {
        $data = [
            'password' => $apass,
        ];
        $this->db->where('a_id', $aid);
        if ($this->db->update('admin', $data)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}
