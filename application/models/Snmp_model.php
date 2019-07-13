<?php
class Snmp_model extends CI_Model
{

    // get interfaces from SNMP by in data
    public function get_device_interfaces_snmp($id)
    {
        // упросить функцию, удалив просмотр всех данных - оставив только метод get_snmp_oid_walk
        snmp_set_quick_print(1);
        $device = $this->device_model->get_device_by_id($id);
        //get array of interfaces types
        $if_type = $this->device_model->get_if_types();
        $if_array = array();
        foreach ($if_type as $key => $value)
        {
            $if_array[$value['name']]=snmp2_walk(long2ip($device['ip']), $device['snmp_read'], $value['oid'], 100000, 5);
        }
        $keys=array_keys($if_array);
        foreach($if_array[$keys[0]] as $k=>$v){  // only iterate first "row"
            $result[]=array_combine($keys,array_column($if_array,$k));  // store each "column" as an associative "row"
        }
        return $result;
    }

    // get interfaces from SNMP by in data
    // однотипный OID - относится только к интерфейсам
    public function get_snmp_oid_walk($id,$oid)
    {
        snmp_set_quick_print(1);
        $device = $this->device_model->get_device_by_id($id);
        //get array of mib request
        $result_walk=snmp2_real_walk(long2ip($device['ip']), $device['snmp_read'], $oid, 1000000, 5);
        //convert oid as index
        $result = $this->snmp_model->parse_snmp_oid_walk($result_walk);
        return $result;
    }

    // convert snmpwalk OID table
    public function parse_snmp_oid_walk($data)
    {
        $result = array();
        //присваиваем индекс массива - значение индекса интерфейса
        foreach ($data as $key => $value) {
            $oid_array = explode(".", $key);
            $t = count($oid_array);
            $if_index = $oid_array[$t-1];
            $result[$if_index] = $value;
        }
        return $result;
    }

    // get table SMMP unregistered ONTs by in data
    public function get_snmp_unregistered($id)
    {
        //todo почему нам это надо
        //todo соединить с функцией get_snmp_indexed_oid
        error_reporting(E_ERROR | E_PARSE);
        snmp_set_quick_print(1);
        $device = $this->device_model->get_device_by_id($id);
        $oid = '1.3.6.1.4.1.2011.6.128.1.1.2.48.1.2';
        if ($snmp_return = snmp2_real_walk(long2ip($device['ip']), $device['snmp_read'], $oid, 100000, 5)) {
            $result = $this->snmp_model->parse_unregistered_table($snmp_return);
            return $result;
        } else {
            return 0;
        }
    }

    // convert unregistered OID table
    // конвертируем в последовательный массив список незарегистрированных ONT
    public function parse_unregistered_table($data)
    {
        //todo почему нам это надо
        error_reporting(E_ALL & ~E_NOTICE);
        $count=0;
        foreach ($data as $key => $value) {
            $oid_array = explode(".", $key);
            $t = count($oid_array);
            $if_index = $oid_array[$t-2];
            $result[$count]['if_index'] = $if_index;
            $value = str_replace(' ','',$value);
            // бывает получаем "BDCMb/\"`"
            // надо убрать " с начала и с конца
            // и убрать \ в средине
            $value = trim($value, " \"");
            $value = trim($value, '"');
            $value = stripslashes($value);
            if (strlen($value) <> 16 ) $value = strtoupper(bin2hex($value));
            $result[$count]['mac'] = $value;
            $count=$count+1;
        }
        return $result;
    }

    // get indexed OID table by in data
    public function get_snmp_indexed_oid($id, $oid)
    {
        //todo почему нам это надо
        error_reporting(E_ERROR | E_PARSE);
        snmp_set_quick_print(1);
        $device = $this->device_model->get_device_by_id($id);
        if ($snmp_return = snmp2_real_walk(long2ip($device['ip']), $device['snmp_read'], $oid, 1000000, 50)) {
            $result = $this->snmp_model->parse_indexed_table($snmp_return);
            return $result;
        } else {
            return 0;
        }
    }

    // convert indexed OID table
    // конвертируем в последовательный массив список результата snmp
    public function parse_indexed_table($data)
    {
        //парсим получненые значения и присваиваем индексы и значения
        //todo почему нам это надо
        error_reporting(E_ALL & ~E_NOTICE);
        $count=0;
        foreach ($data as $key => $value) {
            $oid_array = explode(".", $key);
            $t = count($oid_array);
            $if_index = $oid_array[$t-2];
            $ont_index = $oid_array[$t-1];
            $result[$count]['if_index'] = $if_index;
            $result[$count]['ont_index'] = $ont_index;
            $value = str_replace(' ','',$value);
            $result[$count]['value'] = trim($value, " \"");
            $count=$count+1;
        }
        return $result;
    }

    // get OID table by in data
    public function get_snmp_oid($id, $oid)
    {
        //todo почему нам это надо
        error_reporting(E_ERROR | E_PARSE);
        snmp_set_quick_print(1);
        $device = $this->device_model->get_device_by_id($id);
        if ($snmp_return = snmp2_get(long2ip($device['ip']), $device['snmp_read'], $oid, 100000, 5)) {
            $snmp_return = trim($snmp_return, " \"");
            return $snmp_return;
        } else {
            return 0;
        }
    }
}