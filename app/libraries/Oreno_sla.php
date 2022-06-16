<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Oreno_sla
 *
 * @author user
 */
class Oreno_sla {

    //put your code here

    public $variable = '';

    public function get($ticket_id = null) {
        if ($ticket_id != null) {
            $CI = & get_instance();
            $CI->load->model(array('Tbl_helpdesk_activities', 'Tbl_helpdesk_tickets'));
            //get all ticket activities
            $ticket_activities = $CI->Tbl_helpdesk_activities->find('all', array(
                'conditions' => array('a.ticket_id' => $ticket_id, 'b.status_id' => 5),
                'joins' => array(
                    array(
                        'table' => 'tbl_helpdesk_ticket_transactions b',
                        'conditions' => 'b.id = a.ticket_id',
                        'type' => 'left'
                    )
                )
                    )
            );
            // debug($ticket_activities);
            if (isset($ticket_activities) && !empty($ticket_activities) && $ticket_activities != null) {
                $total_activities = count($ticket_activities);
                $arr_all = array();
                foreach ($ticket_activities AS $key => $value) {
                    //response time
                    $rspn_time_start = $value['response_time_start'];
                    $rspn_time_end   = $value['response_time_stop'];
                    $response_time   = fn_date_diff_ticket($rspn_time_start, $rspn_time_end, 'all');
                    $response_time_minute = fn_date_diff_ticket($rspn_time_start, $rspn_time_end);
                    $arr_response_time = array(
                        'response_start'    => idn_date($rspn_time_start),
                        'response_start_1'    => $rspn_time_start,
                        'response_end'      => idn_date($rspn_time_end),
                        'response_end_1'      => $rspn_time_end,
                        'sub_response_time' => date_diff_sla($rspn_time_start,$rspn_time_end),
                        'response_time'     => $response_time
                    );
                    // debug($arr_response_time);
                   $arr_transfer_time = array();
                    if (isset($value['transfer_time_start']) && !empty($value['transfer_time_start'])) {
                        if (fn_date_diff_ticket($value['transfer_time_start'], $value['transfer_time_stop']) > 0) {
                            $transfer_time_start = $value['transfer_time_start'];
                            $transfer_time_end   = $value['transfer_time_stop'];
                            $transfer_time       = fn_date_diff_ticket($transfer_time_start, $transfer_time_end, 'all');
                            $arr_transfer_time  = array(
                                'transfer_start' => idn_date($transfer_time_start),
                                'transfer_end'   => idn_date($transfer_time_end),
                                'transfer_time'  => $transfer_time
                            );
                        }
                    }

                    $solving_time_start = $value['solving_time_start'];
                    $solving_time_end   = $value['solving_time_stop'];
                    $solving_time       = fn_date_diff_ticket($solving_time_start, $solving_time_end, 'all');
                    $arr_solving_time = array(
                        'solving_start'     => idn_date($solving_time_start),
                         'solving_start_1'   => $solving_time_start,
                        'solving_end'       => idn_date($solving_time_end),
                        'solving_end_1'     => $solving_time_end,
                        'sub_solving_time'  => date_diff_sla($solving_time_start,$solving_time_end),
                        'solving_time'      => $solving_time
                    );
                    $arr_all[] = array(
                        'response'  => $arr_response_time,
                        'transfer'  => $arr_transfer_time,
                        'solving'   => $arr_solving_time
                    );
                    return $arr_all;
                }
            } else {
                return null;
            }
            //$ticket = $this->Tbl_helpdesk_tickets->find('first', array('conditions' => array('id' => $ticket_id)));
        }
    }

}
