<?php

defined('BASEPATH') || exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        if (!$this->session->userdata('isLoggedIn')) {
            redirect('login');
        } else {          
            $result['Count_city'] = $this->Dashboard_model->count_City();
            $result['Count_category'] = $this->Dashboard_model->count_Category();
            $result['Count_radio_station'] = $this->Dashboard_model->count_Radio_Station();
            $result['Count_slider'] = $this->Dashboard_model->count_Slider();
            $result['full'] = $this->Dashboard_model->get_full_logo();
            $result['half'] = $this->Dashboard_model->get_half_logo();
            $this->load->view('dashboard', $result);
        }
    }

    public function city() {
        if (!$this->session->userdata('isLoggedIn')) {
            redirect('login');
        } else {
            if ($this->input->post('btnadd')) {
                $this->Dashboard_model->add_city();
                $this->session->set_flashdata('success', 'City inserted successfully..');
                redirect('city', 'refresh');
            }
            if ($this->input->post('btnupdate')) {
                $this->Dashboard_model->update_city();
                $this->session->set_flashdata('success', 'City Update successfully..');
                redirect('city', 'refresh');
            }
            $result['full'] = $this->Dashboard_model->get_full_logo();
            $result['half'] = $this->Dashboard_model->get_half_logo();
            $result['cate'] = $this->Dashboard_model->get_category();
            $this->load->view('city', $result);
        }
    }
    
    public function delete_city() {
       if (!$this->session->userdata('isLoggedIn')) {
            redirect('login');
        } else {
            $id = $this->input->post('id');
            //Delete data from database
            $this->Dashboard_model->delete_city($id);
            echo "City deleted successfully..";
        } 
    }

    public function get_station_category() {
        $cate = $this->input->post('category_id');
        $data = $this->db->select('id,name')->where("cat_id", $cate)->get("radio_station")->result();
        $options = '<option value="0">Select Radio Station</option>';
        foreach ($data as $option) {
            $options .= "<option value=" . $option->id . ">" . $option->name . "</option>";
        }
        echo $options;
    }
    
    public function get_category_by_city() {
        $city = $this->input->post('city_id');
        $data = $this->db->select('id,category_name')->where("city_id", $city)->get("category")->result();
        $options = '<option value="0">Select Category</option>';
        foreach ($data as $option) {
            $options .= "<option value=" . $option->id . ">" . $option->category_name . "</option>";
        }
        echo $options;
    }

    public function slider() {
        if (!$this->session->userdata('isLoggedIn')) {
            redirect('login');
        } else {
            if ($this->input->post('btnadd')) {
                $cat = $this->input->post('cat_id');
                $radio_station = $this->input->post('radio_sation');
                if ($cat == 0) {
                    $this->session->set_flashdata('error', 'Please select Category..');
                    redirect('slider', 'refresh');
                } else if ($radio_station == 0) {
                    $this->session->set_flashdata('error', 'Please select Radio Station..');
                    redirect('slider', 'refresh');
                } else {
                    $data = $this->Dashboard_model->add_slider();
                    if ($data == FALSE) {
                        $this->session->set_flashdata('error', 'Only png, jpg and jpeg image allow..');
                        redirect('slider', 'refresh');
                    } else {
                        $this->session->set_flashdata('success', 'Slider inserted successfully..');
                        redirect('slider', 'refresh');
                    }
                }
            }
            if ($this->input->post('btnupdate')) {
                $cat = $this->input->post('update_cat_id');
                $radio_station = $this->input->post('update_radio_sation');
                if ($cat == 0) {
                    $this->session->set_flashdata('error', 'Please select Category..');
                    redirect('slider', 'refresh');
                } else if ($radio_station == 0) {
                    $this->session->set_flashdata('error', 'Please select Radio Station..');
                    redirect('slider', 'refresh');
                } else {
                    $data1 = $this->Dashboard_model->update_slider();
                if ($data1 == FALSE) {
                    $this->session->set_flashdata('error', 'Only png, jpg and jpeg image allow..');
                    redirect('slider', 'refresh');
                } else {
                    $this->session->set_flashdata('success', 'Slider Update successfully..');
                    redirect('slider', 'refresh');
                }
                }
                
            }
            $result['full'] = $this->Dashboard_model->get_full_logo();
            $result['half'] = $this->Dashboard_model->get_half_logo();
            $result['cate'] = $this->Dashboard_model->get_category();
            $result['city'] = $this->Dashboard_model->get_city();
            $this->load->view('slider', $result);
        }
    }

    public function delete_slider() {
        if (!$this->session->userdata('isLoggedIn')) {
            redirect('login');
        } else {
            $id = $this->input->post('id');
            $image_url = $this->input->post('image_url');
            //Delete data from database
            $this->Dashboard_model->delete_slider($id, $image_url);
            echo "Slider deleted successfully..";
        }
    }

    public function category() {
        if (!$this->session->userdata('isLoggedIn')) {
            redirect('login');
        } else {
            if ($this->input->post('btnadd')) {
                $data = $this->Dashboard_model->add_category();
                if ($data == FALSE) {
                    $this->session->set_flashdata('error', 'Only png, jpg and jpeg image allow..');
                    redirect('category', 'refresh');
                } else {
                    $this->session->set_flashdata('success', 'Category inserted successfully..');
                    redirect('category', 'refresh');
                }
            }
            if ($this->input->post('btnupdate')) {
                $data1 = $this->Dashboard_model->update_category();
                if ($data1 == FALSE) {
                    $this->session->set_flashdata('error', 'Only png, jpg and jpeg image allow..');
                    redirect('category', 'refresh');
                } else {
                    $this->session->set_flashdata('success', 'Category Update successfully..');
                    redirect('category', 'refresh');
                }
            }
            $result['full'] = $this->Dashboard_model->get_full_logo();
            $result['half'] = $this->Dashboard_model->get_half_logo();
            $result['city'] = $this->Dashboard_model->get_city();
            $this->load->view('category', $result);
        }
    }

    public function delete_category() {
        if (!$this->session->userdata('isLoggedIn')) {
            redirect('login');
        } else {
            $id = $this->input->post('id');
            $image_url = $this->input->post('image_url');
            //Delete data from database
            $this->Dashboard_model->delete_category($id, $image_url);
            echo "Category deleted successfully..";
        }
    }

    public function radio_station() {
        if (!$this->session->userdata('isLoggedIn')) {
            redirect('login');
        } else {
            if ($this->input->post('btnadd')) {
                $cat = $this->input->post('cat_id');
                if ($cat == 0) {
                      $this->session->set_flashdata('error', 'Please select Category..');
                      redirect('radio_station', 'refresh');
                  
                } else {
                    $data = $this->Dashboard_model->add_radio_station();
                    if ($data == FALSE) {
                        $this->session->set_flashdata('error', 'Only png, jpg and jpeg image allow..');
                        redirect('radio_station', 'refresh');
                    } else {
                        $this->session->set_flashdata('success', 'Radio Station inserted successfully..');
                        redirect('radio_station', 'refresh');
                    }
                }
            }
            if ($this->input->post('btnupdate')) {
                  $cat = $this->input->post('update_cat_id');
                if ($cat == 0) {
                   $this->session->set_flashdata('error', 'Please select Category..');
                        redirect('radio_station', 'refresh');
                } else {
                $data1 = $this->Dashboard_model->update_radio_station();
                if ($data1 == FALSE) {
                    $this->session->set_flashdata('error', 'Only png, jpg and jpeg image allow..');
                    redirect('radio_station', 'refresh');
                } else {
                    $this->session->set_flashdata('success', 'Radio Station Update successfully..');
                    redirect('radio_station', 'refresh');
                }
            }
            }
            $result['full'] = $this->Dashboard_model->get_full_logo();
            $result['half'] = $this->Dashboard_model->get_half_logo();
            $result['cate'] = $this->Dashboard_model->get_category();
            $result['city'] = $this->Dashboard_model->get_city();
            $this->load->view('radio_station', $result);
        }
    }

    public function delete_radio_station() {
        if (!$this->session->userdata('isLoggedIn')) {
            redirect('login');
        } else {
            $id = $this->input->post('id');
            $image_url = $this->input->post('image_url');

            //Delete data from database
            $this->Dashboard_model->delete_radio_station($id, $image_url);
            echo "Radio Station deleted successfully..";
        }
    }

    public function radio_station_report() {
        if (!$this->session->userdata('isLoggedIn')) {
            redirect('login');
        } else {
            $result['full'] = $this->Dashboard_model->get_full_logo();
            $result['half'] = $this->Dashboard_model->get_half_logo();
            $this->load->view('radio_station_report', $result);
        }
    }

    public function delete_report() {
        if (!$this->session->userdata('isLoggedIn')) {
            redirect('login');
        } else {
            $id = $this->input->post('id');
            //Delete data from database
            $this->Dashboard_model->delete_report($id);
            echo "Report deleted successfully..";
        }
    }

    public function send_notifications() {
        if (!$this->session->userdata('isLoggedIn')) {
            redirect('login');
        } else {
            if ($this->input->post('btnadd')) {
                $this->Dashboard_model->add_notifications();
                $this->session->set_flashdata('success', 'Notification Sent Successfully..');
                redirect('send_notifications', 'refresh');
            }
            $result['full'] = $this->Dashboard_model->get_full_logo();
            $result['half'] = $this->Dashboard_model->get_half_logo();
            $result['cate'] = $this->Dashboard_model->get_category();
            $this->load->view('send_notifications', $result);
        }
    }

    public function delete_notification() {
        if (!$this->session->userdata('isLoggedIn')) {
            redirect('login');
        } else {
            $id = $this->input->post('id');
            $image_url = $this->input->post('image_url');

            //Delete data from database
            $this->Dashboard_model->delete_notification($id, $image_url);
            echo "Notification deleted successfully..";
        }
    }

    public function notification_settings() {
        if (!$this->session->userdata('isLoggedIn')) {
            redirect('login');
        } else {
            if ($this->input->post('btnadd')) {
                $this->Dashboard_model->notification_settings();
                $this->session->set_flashdata('success', 'FCM key Update successfully..');
                redirect('notification_settings', 'refresh');
            }
            $result['full'] = $this->Dashboard_model->get_full_logo();
            $result['half'] = $this->Dashboard_model->get_half_logo();
            $result['setting'] = $this->Dashboard_model->get_fcm_key();
            $this->load->view('notification_settings', $result);
        }
    }
    
    public function system_configurations() {
         if (!$this->session->userdata('isLoggedIn')) {
            redirect('login');
        } else {
            if ($this->input->post('btnadd')) {
                $this->Dashboard_model->system_settings();
                $this->session->set_flashdata('success', 'Settings Saved!');
                redirect('system_configurations', 'refresh');
            }
            $result['full'] = $this->Dashboard_model->get_full_logo();
            $result['half'] = $this->Dashboard_model->get_half_logo();
            $result['setting'] = $this->Dashboard_model->get_city_mode();
            $this->load->view('system_configuration', $result);
        }
    }

    public function about_us() {
        if (!$this->session->userdata('isLoggedIn')) {
            redirect('login');
        } else {
            if ($this->input->post('btnadd')) {
                $this->Dashboard_model->update_about_us();
                $this->session->set_flashdata('success', 'About Us Update successfully..');
                redirect('about_us', 'refresh');
            }
            $result['full'] = $this->Dashboard_model->get_full_logo();
            $result['half'] = $this->Dashboard_model->get_half_logo();
            $result['setting'] = $this->Dashboard_model->get_about_us();
            $this->load->view('about_us', $result);
        }
    }

    public function privacy_policy() {
        if (!$this->session->userdata('isLoggedIn')) {
            redirect('login');
        } else {
            if ($this->input->post('btnadd')) {
                $this->Dashboard_model->update_privacy_policy();
                $this->session->set_flashdata('success', 'Privacy Policy Update successfully..');
                redirect('privacy_policy', 'refresh');
            }
            $result['full'] = $this->Dashboard_model->get_full_logo();
            $result['half'] = $this->Dashboard_model->get_half_logo();
            $result['setting'] = $this->Dashboard_model->get_privacy_policy();
            $this->load->view('privacy_policy', $result);
        }
    }

    public function terms_conditions() {
        if (!$this->session->userdata('isLoggedIn')) {
            redirect('login');
        } else {
            if ($this->input->post('btnadd')) {
                $this->Dashboard_model->update_terms_conditions();
                $this->session->set_flashdata('success', 'Terms Condition Update successfully..');
                redirect('terms_conditions', 'refresh');
            }
            $result['full'] = $this->Dashboard_model->get_full_logo();
            $result['half'] = $this->Dashboard_model->get_half_logo();
            $result['setting'] = $this->Dashboard_model->get_terms_conditions();
            $this->load->view('terms_conditions', $result);
        }
    }

    public function play_store_about_us() {
        $result['setting'] = $this->Dashboard_model->get_about_us();
        $this->load->view('play_store_about_us', $result);
    }

    public function play_store_privacy_policy() {
        $result['setting'] = $this->Dashboard_model->get_privacy_policy();
        $this->load->view('play_store_privacy_policy', $result);
    }

    public function play_store_terms_conditions() {
        $result['setting'] = $this->Dashboard_model->get_terms_conditions();
        $this->load->view('play_store_terms_conditions', $result);
    }

    public function profile() {
        if (!$this->session->userdata('isLoggedIn')) {
            redirect('login');
        } else {
            if ($this->input->post('btnchange')) {
                $data = $this->Dashboard_model->update_profile();
                if ($data == 0) {
//                    print_r($data);
                    $this->session->set_flashdata('error', 'Only png, jpg and jpeg image allow..');
                    redirect('profile', 'refresh');
                } else {
                    $this->session->set_flashdata('success', 'Profile inserted successfully..');
                    redirect('profile', 'refresh');
                }
            }
            $result['full'] = $this->Dashboard_model->get_full_logo();
            $result['half'] = $this->Dashboard_model->get_half_logo();
            $this->load->view('profile', $result);
        }
    }

    public function checkOldPass() {
        $oldpass = $this->input->post('oldpass');

        //fetch old password from database
        $aname = $this->session->userdata('adminname');
        $row = $this->db->where('username', $aname)->get('admin')->row();
        $pass = $this->encryption->decrypt($row->password);
        if ($pass == $oldpass) {
            echo json_encode("True");
        } else {
            echo json_encode("False");
        }
    }

    public function resetpassword() {
        if (!$this->session->userdata('isLoggedIn')) {
            redirect('login');
        } else {
            if ($this->input->post('btnchange')) {
                $newpass = $this->input->post('newpassword');
                $confirmpass = $this->input->post('confirmpassword');
                if ($newpass == $confirmpass) {

                    //fetch old password from database
                    $aname = $this->session->userdata('adminname');
                    $row = $this->db->where('username', $aname)->get('admin')->row();

                    $adminId = $row->a_id;
                    $adminpass = $this->encryption->encrypt($newpass);
                    //change password
                    $this->Dashboard_model->change_password($adminId, $adminpass);
                    $this->session->set_flashdata('success', 'Password Change Successfully..');
                    redirect('resetpassword', 'refresh');
                } else {
                    $this->session->set_flashdata('error', 'New and Confirm Password not Match..');
                    redirect('resetpassword', 'refresh');
                }
            }
            $result['full'] = $this->Dashboard_model->get_full_logo();
            $result['half'] = $this->Dashboard_model->get_half_logo();
            $this->load->view('changePassword', $result);
        }
    }

    public function logout() {
        $this->session->unset_userdata('isLoggedIn');
        $this->session->sess_destroy();
        redirect("Login");
    }

}
