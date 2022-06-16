<?php

class MY_Model extends CI_Model {

    public function query($querys = null, $status = 'select', $profile = 'default') {
        $data = array();
        if ($status == "select") {
            if ($profile == "default") {
                $query = $this->db->query($querys);
                foreach ($query->result_array() as $row) {
                    $data[] = $row;
                }
            } else {
                $sql_old = $this->load->database($profile, TRUE);
                $query = $sql_old->query($querys);
                foreach ($query->result_array() as $row) {
                    $data[] = $row;
                }
            }
            return $data;
        } else {
            if ($profile == "default") {
                $query = $this->db->query($querys);
            } else {
                $sql_old = $this->load->database($profile, TRUE);
                $query = $sql_old->query($querys);
            }
            return $query;
        }
    }

    public function firstdata($primary_key = null, $options = array(), $profile = 'default') {
        return $this->find('first', $options, $profile);
    }

    public function lastdata($primary_key = null, $options = array(), $profile = 'default') {
        return $this->find('last', $options, $profile);
    }

    public function find($type = null, $options = array(), $profile = 'default') {
        if (isset($options['table_name']) && !empty($options['table_name'])) {
            $table_name = $options['table_name'] . " a";
        } else {
            $table_name = strtolower(get_class($this)) . " a";
        }
        if (isset($type) && !empty($type)) {
            if ($profile == "default") {
                $custom_query = $this->db;
            } else {
                $sql_cust = $this->load->database($profile, TRUE);
                $custom_query = $sql_cust;
            }
            if (isset($options['fields']) && !empty($options['fields'])) {
                $fields = $options['fields'];
            } else {
                $fields = '*';
            }
            $custom_query->select($fields);
            $custom_query->from($table_name);
            //set the conditions
            //conditions start here
            if (isset($options['conditions']) && !empty($options['conditions'])) {
                $cond_new = array_keys($options['conditions']);
                for ($j = 0; $j < count($cond_new); $j++) {
                    $where_value = $cond_new[$j];
                    $custom_query->where($cond_new[$j], $options['conditions'][$where_value]);
                }
            }

            //conditions end here
            //or is another condition for using where and or like in plain mysql query
            //e.g in mysql query : select table_name.id, table_name.name from table_name WHERE id = 1 OR table_name.category_id = 2
            //when you want using this feature, it's mandatory option conditions is must present, if system cannot found options condition your option 'or' wouldn't functionally or disable by default
            //conditions with or start here

            if (isset($options['or']) && !empty($options['or'])) {
                $cond_new = array_keys($options['or']);
                for ($j = 0; $j < count($cond_new); $j++) {
                    $where_value = $cond_new[$j];
                    $custom_query->or_where($cond_new[$j], $options['or'][$where_value]);
                }
            }

            //conditions with or end here
            //condition_in is similarly like WHERE username IN ('Frank', 'Todd', 'James')
            //conditions with in start here

            if (isset($options['condition_in']) && !empty($options['condition_in'])) {
                $cond_new = array_keys($options['condition_in']);
                for ($j = 0; $j < count($cond_new); $j++) {
                    $where_value = $cond_new[$j];
                    $custom_query->where_in($cond_new[$j], $options['condition_in'][$where_value]);
                }
            }

            //conditions with in end here
            //OR username IN ('Frank', 'Todd', 'James')
            //conditions with or-in start here

            if (isset($options['or_in']) && !empty($options['or_in'])) {
                $cond_new = array_keys($options['or_in']);
                for ($j = 0; $j < count($cond_new); $j++) {
                    $where_value = $cond_new[$j];
                    $custom_query->or_where_in($cond_new[$j], $options['or_in'][$where_value]);
                }
            }

            //conditions with or-in end here
            if (isset($options['condition_not_in']) && !empty($options['condition_not_in'])) {
                $cond_new = array_keys($options['condition_not_in']);
                for ($j = 0; $j < count($cond_new); $j++) {
                    $where_value = $cond_new[$j];
                    $custom_query->where_not_in($cond_new[$j], $options['condition_not_in'][$where_value]);
                }
            }

            if (isset($options['condition_or_not_in']) && !empty($options['condition_or_not_in'])) {
                $cond_new = array_keys($options['condition_or_not_in']);
                for ($j = 0; $j < count($cond_new); $j++) {
                    $where_value = $cond_new[$j];
                    $custom_query->or_where_not_in($cond_new[$j], $options['condition_or_not_in'][$where_value]);
                }
            }

            if (isset($options['like']) && !empty($options['like'])) {
                //attribut options = before, after, both, none
                if (is_array($options['like'])) {
                    $custom_query->like($options['like']);
                } else {
                    $search_field = $options['like'][0];
                    $search_var = $options['like'][1];
                    $search_attr = '';
                    if (isset($options['like'][2]) && !empty($options['like'][2])) {
                        $search_attr = $options['like'][2];
                    }
                    if ($search_attr != '') {
                        $custom_query->like($search_field, $search_var, $search_attr);
                    } else {
                        $custom_query->like($search_field, $search_var);
                    }
                }
            }

            if (isset($options['or_like']) && !empty($options['or_like'])) {
                //attribut options = before, after, both, none
                if (is_array($options['or_like'])) {
                    $custom_query->or_like($options['or_like']);
                } else {
                    $search_field = $options['or_like'][0];
                    $search_var = $options['or_like'][1];
                    $search_attr = '';
                    if (isset($options['or_like'][2]) && !empty($options['or_like'][2])) {
                        $search_attr = $options['or_like'][2];
                    }
                    if ($search_attr != '') {
                        $custom_query->or_like($search_field, $search_var, $search_attr);
                    } else {
                        $custom_query->or_like($search_field, $search_var);
                    }
                }
            }

            if (isset($options['not_like']) && !empty($options['not_like'])) {
                //attribut options = before, after, both, none
                $search_field = $options['not_like'][0];
                $search_var = $options['not_like'][1];
                $search_attr = '';
                if (isset($options['not_like'][2]) && !empty($options['not_like'][2])) {
                    $search_attr = $options['not_like'][2];
                }
                if ($search_attr != '') {
                    $custom_query->not_like($search_field, $search_var, $search_attr);
                } else {
                    $custom_query->not_like($search_field, $search_var);
                }
            }

            if (isset($options['or_not_like']) && !empty($options['or_not_like'])) {
                //attribut options = before, after, both, none
                $search_field = $options['or_not_like'][0];
                $search_var = $options['or_not_like'][1];
                $search_attr = '';
                if (isset($options['or_not_like'][2]) && !empty($options['or_not_like'][2])) {
                    $search_attr = $options['or_not_like'][2];
                }
                if ($search_attr != '') {
                    $custom_query->or_not_like($search_field, $search_var, $search_attr);
                } else {
                    $custom_query->or_not_like($search_field, $search_var);
                }
            }

            if (isset($options['joins']) && !empty($options['joins'])) {
                if (isset($join['type']) && !empty($join['type'])) {
                    $join_type = $join['type'];
                } else {
                    $join_type = 'left';
                }
                foreach ($options['joins'] as $join) {
                    $custom_query->join($join['table'], $join['conditions'], $join_type);
                }
            }

            if (isset($options['limit']) && !empty($options['limit'])) {
                if (count($options['limit']) == 1) {
                    $custom_query->limit($options['limit']);
                } else {
                    $custom_query->limit($options['limit']['perpage'], $options['limit']['offset']);
                }
            }

            //order list data
            if (isset($type) && !empty($type) && $type == "list" && empty($options['order'])) {
                $custom_query->order_by('a.id', 'DESC');
            } elseif (isset($type) && !empty($type) && $type == "last" && empty($options['order'])) {
                $order_key = 'id';
                $order_type = 'DESC';
                $custom_query->order_by($order_key, $order_type);
            } else {
                if (isset($options['order']) && !empty($options['order'])) {
                    if (isset($options['order']['type']) && !empty($options['order']['type'])) {
                        $order_key = $options['order']['key'];
                        $order_type = $options['order']['type'];
                    } else {
                        if ($type == 'first') {
                            $order_key = 'id';
                            $order_type = 'ASC';
                        } elseif ($type == 'last') {
                            $order_key = 'id';
                            $order_type = 'DESC';
                        }
                    }
                    $custom_query->order_by($order_key, $order_type);
                }
            }

            //group options list data
            if (isset($options['group']) && !empty($options['group'])) {
                foreach ($options['group'] as $rowGroup) {
                    $custom_query->group_by($rowGroup);
                }
            }

            $query = $custom_query->get();
            if ($type == "all") {
                //find all : show all list data : required field of table is id(int), name(varchar), create_date(datetime)
                foreach ($query->result_array() as $row) {
                    $data[] = $row;
                }
                return isset($data) ? $data : null;
            } elseif ($type == "first") {
                //find first : show first data by id : required field of table is id(int), name(varchar), create_date(datetime)
                foreach ($query->result_array() as $row) {
                    $data[] = $row;
                }
                return isset($data[0]) ? $data[0] : null;
            } elseif ($type == "last") {
                //find last : show last data by id : required field of table is id(int), name(varchar), create_date(datetime)
                foreach ($query->result_array() as $row) {
                    $data[] = $row;
                }
                return isset($data[0]) ? $data[0] : null;
            } elseif ($type == "count") {
                return count($query->result_array());
            } elseif ($type == "list") {
                //find all : show all list data only id and name : required field of table is id(int), name(varchar), create_date(datetime)
                if ($query->num_rows() > 0) {
                    foreach ($query->result_array() as $row) {
                        $keys_ = array_keys($row);
                        $data[] = array(
                            $keys_[0] => $row['id'],
                            $keys_[1] => $row['name']
                        );
                    }
                    return $data;
                } else {
                    return null;
                }
            } else {
                return false;
            }
        }
    }

    public function get_name($id = null, $profile = 'default') {
        $res = $this->find('first', array('conditions' => array('id' => $id)), $profile);
        if (isset($res) && !empty($res)) {
            if ($res['name']) {
                return $res['name'];
            } else {
                return $res['id'];
            }
        } else {
            return null;
        }
    }

    public function get_code($id = null, $profile = 'default') {
        $res = $this->find('first', array('conditions' => array('id' => $id)), $profile);
        if (isset($res) && !empty($res)) {
            if ($res['code']) {
                return $res['code'];
            } else {
                return $res['id'];
            }
        } else {
            return null;
        }
    }

    public function get_id($name = null, $profile = 'default') {
        $res = $this->find('first', array('conditions' => array('name' => $name)), $profile);
        if (isset($res) && !empty($res)) {
            return $res['id'];
        } else {
            return null;
        }
    }

    public function get_data($id = null, $profile = 'default') {
        $res = $this->find('first', array('conditions' => array('id' => $id)), $profile);
        if (isset($res) && !empty($res)) {
            return array('id' => $res['id'], 'value' => $res['name']);
        } else {
            return null;
        }
    }

    public function insert($data = null, $profile = 'default') {
        if ($profile == "default") {
            $custom_query = $this->db;
        } else {
            $sql_cust = $this->load->database($profile, TRUE);
            $custom_query = $sql_cust;
        }
        return $this->db->insert($this->tableName, $data);
    }

    public function insert_batch($data = null, $profile = 'default') {
        if ($profile == "default") {
            $custom_query = $this->db;
        } else {
            $sql_cust = $this->load->database($profile, TRUE);
            $custom_query = $sql_cust;
        }
        return $this->db->insert_batch($this->tableName, $data);
    }

    public function insert_return_id($data = null, $profile = 'default') {
        if ($profile == "default") {
            $custom_query = $this->db;
        } else {
            $sql_cust = $this->load->database($profile, TRUE);
            $custom_query = $sql_cust;
        }
        $this->db->insert($this->tableName, $data);
        return $this->db->insert_id();
    }

    public function update($data = null, $id = null, $profile = 'default') {
        if ($profile == "default") {
            $custom_query = $this->db;
        } else {
            $sql_cust = $this->load->database($profile, TRUE);
            $custom_query = $sql_cust;
        }
        $this->db->where('id', $id);
        return $this->db->update($this->tableName, $data);
    }

    public function update_batch($data = null, $by = null, $profile = 'default') {
        if ($profile == "default") {
            $custom_query = $this->db;
        } else {
            $sql_cust = $this->load->database($profile, TRUE);
            $custom_query = $sql_cust;
        }
        return $this->db->update_batch($this->tableName, $data, $by);
    }

    public function update_by($data = null, $id = null, $by = null, $profile = 'default') {
        if ($profile == "default") {
            $custom_query = $this->db;
        } else {
            $sql_cust = $this->load->database($profile, TRUE);
            $custom_query = $sql_cust;
        }
        $this->db->where($by, $id);
        return $this->db->update($this->tableName, $data);
    }

    public function remove($id = null, $profile = 'default') {
        if ($profile == "default") {
            $custom_query = $this->db;
        } else {
            $sql_cust = $this->load->database($profile, TRUE);
            $custom_query = $sql_cust;
        }
        $data = array(
            'is_active' => 0
        );
        $this->db->where('id', $id);
        return $this->db->update($this->tableName, $data);
    }

    public function remove_by($id = null, $by = null, $profile = 'default') {
        if ($profile == "default") {
            $custom_query = $this->db;
        } else {
            $sql_cust = $this->load->database($profile, TRUE);
            $custom_query = $sql_cust;
        }
        $data = array(
            'is_active' => 0
        );
        $this->db->where($by, $id);
        return $this->db->update($this->tableName, $data);
    }

    public function delete($id = null, $profile = 'default') {
        if ($profile == "default") {
            $custom_query = $this->db;
        } else {
            $sql_cust = $this->load->database($profile, TRUE);
            $custom_query = $sql_cust;
        }
        return $this->db->delete($this->tableName, array('id' => $id));
    }

    public function delete_by($id = null, $by = null, $profile = 'default') {
        if ($profile == "default") {
            $custom_query = $this->db;
        } else {
            $sql_cust = $this->load->database($profile, TRUE);
            $custom_query = $sql_cust;
        }
        return $this->db->delete($this->tableName, array($by => $id));
    }

    public function debug_query($profile = 'default') {
        if ($profile == "default") {
            $custom_query = $this->db;
        } else {
            $sql_cust = $this->load->database($profile, TRUE);
            $custom_query = $sql_cust;
        }
        $this->db->last_query();
    }

}
