<?php

class Oreno_ticket {

    public function insert($post, $sess) {
        $CI = & get_instance();
        $ticket = $CI->Tbl_helpdesk_tickets->find('first', array('conditions' => array('code' => $post['code'])));
        $ticket_id = $ticket['id'];
        $issued_by = 0;
        if(isset($post['issued_by']) && !empty($post['issued_by'])){
            $issued_by = $post['issued_by'];
        }
        $created_by = array();
        if(isset($sess['created_by']) && !empty($sess['created_by'])){
            $created_by = array("created_by" => $sess['created_by']);
        }
        $arr_insert = array(
            'code' => $post['code'],
            'content' => $post['issue'],
            'description' => '-',
            'is_active' => 1,
            'issued_by' => $issued_by
        );
        $arr_insert = array_merge($arr_insert, $created_by);
        if(isset($post['parent_ticket_id']) && !empty($post['parent_ticket_id'])){
            $arr_insert = array_merge($arr_insert, array('parent_ticket_id' => $post['parent_ticket_id']));
        }
        $CI->Tbl_helpdesk_tickets->update($arr_insert, $ticket_id);
        if ($ticket_id) {
            $CI->load->model(array('Tbl_helpdesk_ticket_transactions', 'Tbl_helpdesk_ticket_rules', 'Tbl_helpdesk_ticket_chats','Tbl_helpdesk_ticket_logs', 'Tbl_helpdesk_activities'));
            $priority = 1;
            $impact = $post['problem_impact'];
            if ($post['problem_impact'] == 0) {
                $impact = 1;
            }
            if ($post['problem_impact'] == 2) {
                $priority = 2;
            }
            $rule_id = $CI->Tbl_helpdesk_ticket_rules->find('first', array('conditions' => array('id' => (int) $priority)));
            $arr_trans = array(
                'ticket_id' => (int) $ticket_id,
                'category_id' => (int) $post['category'],
                'job_id' => (int) $post['job'],
                'status_id' => 1,
                'branch_id' => ( (int) $sess['office_id'] != 0) ? (int) $sess['office_id'] : '155',
                'problem_impact_id' => $impact,
                'priority_id' => $priority,
                'rule_id' => $rule_id['id'],
                'is_active' => 1,
                'created_by' => base64_decode($sess['user_id']),
                'create_date' => date_now()
            );
            $CI->Tbl_helpdesk_ticket_transactions->insert($arr_trans);
            $arr_activity = array(
                'ticket_id' => (int) $ticket_id,
                'response_time_start' => date('Y-m-d H:i:s'), 
                'response_time_stop' => '0000-00-00 00:00:00',
                'transfer_time_start' => '0000-00-00 00:00:00',
                'transfer_time_stop' => '0000-00-00 00:00:00',
                'solving_time_start' => '0000-00-00 00:00:00',
                'solving_time_stop' => '0000-00-00 00:00:00',
                'is_open' => 0,
                'is_active' => 1,
                'created_by' => base64_decode($sess['user_id']),
                'create_date' => date_now()
            );
            $CI->Tbl_helpdesk_activities->insert($arr_activity);
            $message  = 'Tiket berhasil dibuat';
            $rr = array(
                'messages' => $message,
                'ticket_id' => (int) $ticket_id,
                'ticket_code' => $post['code'],
                'is_open' => 0,
                'is_show' => 0,
                'is_vendor' => 0,
                'is_active' => 1,
                'reply_to' => 0,
                'created_by' => 0,
                'create_date' => date_now()
            );
            $CI->Tbl_helpdesk_ticket_chats->insert($rr);
            $arr_ins = array(
                'ticket_id' => (int) $ticket_id,
                'action' => $message,
                'is_active' => 1,
                'created_by' => 0,
                'create_date' => date_now()
            );
            $CI->Tbl_helpdesk_ticket_logs->insert($arr_ins);
            return true;
        } else {
            return false;
        }
    }

}
