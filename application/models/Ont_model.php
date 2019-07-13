<?php
class Ont_model extends CI_Model
{

    //get one ont by id from DB
    public function get_ont_by_id($id)
    {
        $this->db->from('ont');
        $this->db->where('id', $id);
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->row_array();
    }

    //get ont oids from DB
    public function get_ont_oid()
    {
        $this->db->from('oid__ont');
        $this->db->where('active', 1);
        $this->db->order_by('order_by', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    // get device data by snmp by device ID from table Device
    public function get_ont_snmp_info($id)
    {
        $ont = $this->ont_model->get_ont_by_id($id);
        $oids = $this->ont_model->get_ont_oid();
        foreach ($oids as $key => $item) {
            $ont_info[$key]['value'] = $this->snmp_model->get_snmp_oid($ont['id_device'], $item['oid'].'.'.$ont['port_index'].'.'.$ont['ont_index'].$item['port']);
            $ont_info[$key]['divide'] = $item['divide'];
            $ont_info[$key]['minus'] = $item['minus'];
            $ont_info[$key]['name'] = $item['name'];
            $ont_info[$key]['oid_id'] = $item['id'];
        }
        return $ont_info;
    }

    // get device data by snmp by port
    public function get_ont_snmp_info_port($device_id, $iface_id, $ont_id)
    {
        $oids = $this->ont_model->get_ont_oid();
        foreach ($oids as $key => $item) {
            $ont_info[$key]['value'] = $this->snmp_model->get_snmp_oid($device_id, $item['oid'].'.'.$iface_id.'.'.$ont_id.$item['port']);
            $ont_info[$key]['divide'] = $item['divide'];
            $ont_info[$key]['minus'] = $item['minus'];
            $ont_info[$key]['name'] = $item['name'];
            $ont_info[$key]['oid_id'] = $item['id'];
        }
        return $ont_info;
    }

}