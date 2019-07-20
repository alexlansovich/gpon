<?php
class Device_model extends CI_Model
{

    public function __construct()
    {
        $this->load->database();
        $this->load->model('snmp_model');
        $this->load->model('telnet_model');
        $this->load->model('ont_model');
    }

    //get list devices - name, pass etc from DB
    public function get_devices()
    {
        $this->db->from('device');
        $this->db->order_by('name', 'ASC');
        $this->db->join('device__types', 'device__types.id_type = device.device_type');
        $query = $this->db->get();
        return $query->result_array();
    }

    //get one device by id - name, pass etc from DB
    public function get_device_by_id($id)
    {
        $this->db->from('device');
        $this->db->where('id', $id);
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->row_array();
    }

    // get device data by snmp by device ID from table Device
    public function get_device_interfaces($id)
    {
        $interfaces = $this->device_model->get_device_interfaces_sql($id);
        // get OLT $ifOperStatus
        $oid = '1.3.6.1.2.1.2.2.1.8';
        $ifOperStatus = $this->snmp_model->get_snmp_oid_walk($id, $oid);
        // get OLT ifAlias
        $oid = '1.3.6.1.2.1.31.1.1.1.18';
        $ifAlias = $this->snmp_model->get_snmp_oid_walk($id, $oid);
        // get OLT ifSignal
        $oid = '1.3.6.1.4.1.2011.6.128.1.1.2.23.1.4';
        $ifSignal = $this->snmp_model->get_snmp_oid_walk($id, $oid);
        // set $ifOperStatus, ifAlias, ifSignal to interface array by SNMP results
        foreach ($interfaces as $key => $item) {
            if ($ifOperStatus[$item['if_real_index']]) {
                $interfaces[$key]['ifOperStatus'] = $ifOperStatus[$item['if_real_index']];
            } else {
                $interfaces[$key]['ifOperStatus'] = 0;
            }
            if ($ifOperStatus[$item['if_real_index']]) {
                $interfaces[$key]['ifAlias'] = $ifAlias[$item['if_real_index']];
            } else {
                $interfaces[$key]['ifAlias'] = 0;
            }
            if ($ifOperStatus[$item['if_real_index']]) {
                $interfaces[$key]['ifSignal'] = $ifSignal[$item['if_real_index']]/100;
            } else {
                $interfaces[$key]['ifSignal'] = 0;
            }
        }
        return $interfaces;
    }

    // get device data by snmp by device ID from table Device
    public function get_device_registered($id, $port)
    {
        if(empty($port))
        {
            $ont_port = '';
        }
        else
        {
            $ont_port = '.'.$port;
        }
        $if_aliases = $this->device_model->get_device_interfaces_alias_sql($id);
        // get ONT Registered
        $oid = '1.3.6.1.4.1.2011.6.128.1.1.2.43.1.3'.$ont_port;
        $registered = $this->snmp_model->get_snmp_indexed_oid($id, $oid);
        // get ONT descs
        $oid = '1.3.6.1.4.1.2011.6.128.1.1.2.43.1.9'.$ont_port;
        $ont_desc = $this->snmp_model->get_snmp_indexed_oid($id, $oid);
        if(!empty($port))
        {
            // get ONT online
            $oid = '1.3.6.1.4.1.2011.6.128.1.1.2.62.1.21'.$ont_port;
            $ont_status = $this->snmp_model->get_snmp_indexed_oid($id, $oid);
            // get ONT signal
            $oid = '1.3.6.1.4.1.2011.6.128.1.1.2.51.1.4'.$ont_port;
            $ont_signal = $this->snmp_model->get_snmp_indexed_oid($id, $oid);
        }

        // set Desc  by SNMP results
        foreach ($registered as $key => $item) {
             $registered[$key]['desc'] = $ont_desc[$key]['value'];
             $registered[$key]['signal'] = $ont_signal[$key]['value']/100;
             $registered[$key]['status'] = $ont_status[$key]['value'];
             $registered[$key]['if_alias'] = $if_aliases[$item['if_index']];
        }
        return $registered;
    }

    //get interfaces of device by ID device from DB
    public function get_device_interfaces_sql($id)
    {
        $this->db->from('interfaces');
        $this->db->where('id_device', $id);
        $this->db->where('active', 1);
        $query = $this->db->get();
        return $query->result_array();
    }

    //get one interface of device by ID interface from DB
    public function get_device_interface_sql_by_id($id)
    {
        $this->db->from('interfaces');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }

    //get one interface of device by ID interface AND ifName from DB
    public function get_device_interface_sql_by_id_ifname($id_dev, $port)
    {
        $this->db->from('interfaces');
        $this->db->where('id_device', $id_dev);
        $this->db->where('ifName', $port);
        $query = $this->db->get();
        return $query->row_array();
    }

    //get one interface of device by ID interface AND ifName from DB
    public function get_device_interface_sql_by_id_ifindex($id_dev, $if_real_index)
    {
        $this->db->from('interfaces');
        $this->db->where('id_device', $id_dev);
        $this->db->where('if_real_index', $if_real_index);
        $query = $this->db->get();
        return $query->row_array();
    }

    //convert interfaces of device by ID device from DB to if_real_index AS index
    public function get_device_interfaces_alias_sql($id)
    {
        $this->db->select('if_real_index, ifName');
        $this->db->from('interfaces');
        $this->db->where('id_device', $id);
        $query = $this->db->get();
        $temp = $query->result_array();
        //присваиваем индекс массива - значение индекса интерфейса
        $result = array();
        foreach ($temp as $item) {
            $result[$item['if_real_index']] = $item['ifName'];
        }
        return $result;
    }

    // edit interface data in DB by POST
    public function edit_interface($id)
    {
        $data = array(
            'svlan' => $this->input->post('svlan'),
        );
        $this->db->where('id', $id);
        $this->db->update('interfaces', $data);
        return 1;
    }

    // inintial interfaces of device
    public function initial_device($id)
    {
        // get template
        $interfaces_tpl = $this->device_model->get_device_interfaces_tpl();
        // get snmp interfaces
        $interfaces = $this->snmp_model->get_device_interfaces_snmp($id);
        // перебор установленных плат
        foreach ($interfaces_tpl as $item) {
            // $key  поиск наличия такой записи в таблице опроса устройства
            $key = array_search($item['if_index'], array_column($interfaces, 'ifIndex'));
            if ($key)
            {
                $data = array(
                    'id_device' => $id,
                    'if_index' => $item['if_index'],
                    'if_real_index' => $item['if_real_index'],
                    'ifName	' => $item['ifName'],
                    'svlan' => null,
                    'cvlan_start' => $item['cvlan_start'],
                    'service_start' => $item['service_start'],
                    'active' => 1,
                );
            }
            else
            {
                $data = array(
                    'id_device' => $id,
                    'if_index' => $item['if_index'],
                    'if_real_index' => $item['if_real_index'],
                    'ifName	' => $item['ifName'],
                    'svlan' => null,
                    'cvlan_start' => $item['cvlan_start'],
                    'service_start' => $item['service_start'],
                    'active' => 0,
                );
            }
            // add to DB
            $this->db->insert('interfaces', $data);
        }

        return 1;
    }

    //get interfaces type and MIB from DB
    public function get_if_types()
    {
        $this->db->from('oid__iftype');
        $this->db->where('active', 1);
        $this->db->order_by('id', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    //get all TPL TABLE of interfaces from DB
    public function get_device_interfaces_tpl()
    {
        $this->db->from('interfaces__tpl');
        $query = $this->db->get();
        return $query->result_array();
    }

    // get all registered ONT and replace data to DB by ID device
    //todo переделать на проверку новых /старых ont
    public function sync_ont($id, $data)
    {
        //очищаем всех клиентов этого устройства
        $this->db->where('id_device', $id);
        $this->db->delete('ont');
        // start
        foreach ($data as $key => $item) {
            //иногда необходимо конвертировать серийник
            if (strlen($item['value']) < 16)  $item['value'] = strtoupper(bin2hex($item['value']));
            $ont_info = array(
                'id_device' => $id,
                'port_index' => $item['if_index'],
                'port_alias' => $item['if_alias'],
                'ont_index' => $item['ont_index'],
                'ont_mac' => $item['value'],
                'ont_desc' => $item['desc'],
            );
            $this->device_model->insert_ont($ont_info);
        }
        return 1;
    }

    public function insert_ont($ont_info)
    {
        $this->db->insert('ont', $ont_info);
        return 1;
    }

    // search ONT by POST (ont desc or ott mac)
    public function search_ont($search)
    {
        $this->db->select('*, ont.id as ont_id');
        $this->db->from('ont');
        $this->db->join('device', 'device.id = ont.id_device');
        $this->db->like('ont_mac', $search);
        $this->db->or_like('ont_desc', $search);
        $query = $this->db->get();
        return $query->result_array();
    }

    // add device to DB
    public function add_device()
    {
        $data = array(
            'name' => $this->input->post('name'),
            'ip' => ip2long($this->input->post('ip')),
            'snmp_read' => $this->input->post('snmp_read'),
            'snmp_write' => $this->input->post('snmp_write'),
            'login' => $this->input->post('login'),
            'password' => $this->input->post('password'),
            'type' => $this->input->post('type'),
            'device_type' => $this->input->post('device_type'),
        );
        $this->db->insert('device', $data);
        return 1;
    }

    // delete device from DB
    public function delete_device($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('device');
        return 1;
    }

    // edit device data in DB by POST
    public function edit_device($id)
    {
        $data = array(
            'name' => $this->input->post('name'),
            'ip' => ip2long($this->input->post('ip')),
            'snmp_read' => $this->input->post('snmp_read'),
            'snmp_write' => $this->input->post('snmp_write'),
            'login' => $this->input->post('login'),
            'password' => $this->input->post('password'),
        );
        $this->db->where('id', $id);
        $this->db->update('device', $data);
        return 1;
    }
}
