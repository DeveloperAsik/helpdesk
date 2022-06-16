<?php

class Request extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function get_ajax_text_plugin() {
        $this->load->model('Tbl_ajax_plugins');
        $res = $this->Tbl_ajax_plugins->find('all', array(
            'conditions' => array('is_active' => 1)
                )
        );
        $arr = '<div class="row"><div class="col-md-12"><center><label">This tools is only work for textarea</label></center><br/>';
        if ($res != null) {
            foreach ($res AS $key => $values) {
                $arr .= '<a href="javascript:;" title="' . strtolower($values['description']) . '" class="btn default dark-stripe plugin_ajax_text" data-name="' . strtolower($values['link']) . '"> ' . $values['name'] . ' </a>';
            }
        }
        $arr .= '</div></div>';
        echo $arr;
    }

    public function get_content($keyword = null) {
        if ($keyword != null) {
            $this->load->model('Tbl_ajax_plugins');
            $res = $this->Tbl_ajax_plugins->find('first', array(
                'conditions' => array('link' => $keyword)
                    )
            );
            echo $res['content'];
        } else {
            echo '-';
        }
    }

}
