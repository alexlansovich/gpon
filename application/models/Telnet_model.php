<?php
class Telnet_model extends CI_Model
{
    public function __construct()
    {
        // ОТКЛЮЧЕННЫЙ модуль работы с биллингом
        // Для своего биллинга используй как пример
        //$this->load->model('billing_model');
        // load library phptelnet
        $this->load->library('PHPTelnet');
    }

    // register ONT by POST data
    public function register($billing_id)
    {
        //input variables
        $log=array();
        $gpon_id = $this->input->post('gpon_id');
        $dev_id = $this->input->post('dev_id');
        $port_id = $this->input->post('port_id');
        $ont = $this->input->post('ont');
        $desc = $this->input->post('desc');
        $desc = trim($desc);
        $gpon = '0/'.$gpon_id;
        $ifName = 'GPON '.$gpon.'/'.$port_id;
        $vlans = $this->device_model->get_device_interface_sql_by_id_ifname($dev_id, $ifName);
        $device = $this->device_model->get_device_by_id($dev_id);

        if ($device['type'] == 1) {
            //driver IPOE standart
            $result = $this->phptelnet->Connect(long2ip($device['ip']), $device['login'], $device['password']);
            $this->phptelnet->DoCommand("ena\n", $result);
            $this->phptelnet->DoCommand("config\n", $result);
            $this->phptelnet->DoCommand("interface gpon $gpon\n", $result);
            sleep(1);// надо дать время для завершения команды!!!
            $this->phptelnet->DoCommand("ont add $port_id sn-auth $ont omci ont-lineprofile-id 1 ont-srvprofile-id 1 desc $desc", $result);
            $log[]=$result;
            sleep(1);// надо дать время для завершения команды!!!
            $this->phptelnet->DoCommand("\n", $result);
            $log[]=$result;
            preg_match("/success: (\d*)/s", $result, $t1);
            //todo почему нам это надо
            error_reporting(E_ALL & ~E_NOTICE);
            $success = $t1[1];
            if ($success == 1) {
                preg_match("/ONTID :(\d*)/s", $result, $t2);
                $ont_id = $t2[1];

                $cvlan = $vlans['cvlan_start'] + $ont_id;
                $svlan = $vlans['svlan'];
                $service = $vlans['service_start'] + $ont_id;
                // ОТКЛЮЧЕННЫЙ модуль работы с биллингом
                // Для своего биллинга используй как пример
                // устанавливаем в биллинге новые привязки
                // $billing_vlans_result = $this->billing_model->billing_set_vlans($device['server_id'], $desc, $svlan, $cvlan);
                // $this->billing_model->billing_comment_add($device['city_id'], $desc, $desc.' - HUAWEI - '.$gpon.'/'.$port_id.':'.$ont_id.' s/n:'.$ont, $billing_id);
                $this->phptelnet->DoCommand("ont modify $port_id $ont_id ont-lineprofile-id $cvlan\r\n", $result);
                sleep(1);// надо дать время для завершения команды!!!
                $log[]=$result;
                $this->phptelnet->DoCommand("ont port native-vlan $port_id $ont_id eth 1 vlan $cvlan priority 0\n", $result);
                sleep(1);
                $log[]=$result;
                $this->phptelnet->DoCommand("quit\n", $result);
                sleep(1);// надо дать время для завершения команды!!!
                $this->phptelnet->DoCommand("service-port $service vlan $svlan gpon 0/$gpon_id/$port_id ont $ont_id gemport 1 multi-service user-vlan $cvlan tag-transform translate-and-add inner-vlan $cvlan inner-priority 0\r\n", $result);
                sleep(1);// надо дать время для завершения команды!!!
                $log[]=$result;
            } else {
                $this->phptelnet->DoCommand("quit\n", $result);
                sleep(1);
                $result_array['log']=$log;
                return $result_array;
            }
            $this->phptelnet->DoCommand("quit\n", $result);
            sleep(1);
            $this->phptelnet->DoCommand("quit\n", $result);
            sleep(1);// надо дать время для завершения команды!!!
            $this->phptelnet->Disconnect();
            $result_array['ont_id']=$ont_id;
            // ОТКЛЮЧЕННЫЙ модуль работы с биллингом
            // Для своего биллинга используй как пример
            //$result_array['billing_vlans_result']=$billing_vlans_result;
            $result_array['billing_vlans_result']='OK'.$billing_id;
            $result_array['log']=$log;
            return $result_array;
        }
        else
        {
            //driver DHCP SHPOLA
            $result = $this->phptelnet->Connect(long2ip($device['ip']), $device['login'], $device['password']);
            $this->phptelnet->DoCommand("ena\n", $result);
            //sleep (1);
            $this->phptelnet->DoCommand("config\n", $result);
            //sleep (1);
            $this->phptelnet->DoCommand("interface gpon $gpon\n", $result);
            sleep(1);// надо дать время для завершения команды!!!
            $this->phptelnet->DoCommand("ont add $port_id sn-auth $ont omci ont-lineprofile-id 1109 ont-srvprofile-id 1109 desc $desc", $result);
            sleep(1);// надо дать время для завершения команды!!!
            $log[]=$result;
            $this->phptelnet->DoCommand("\n", $result);
            $log[]=$result;
            preg_match("/success: (\d*)/s", $result, $t1);
            //todo почему нам это надо
            error_reporting(E_ALL & ~E_NOTICE);
            $success = $t1[1];
            if ($success == 1) {
                preg_match("/ONTID :(\d*)/s", $result, $t2);
                $ont_id = $t2[1];
                // ОТКЛЮЧЕННЫЙ модуль работы с биллингом
                // Для своего биллинга используй как пример
                // добавить комментарий в биллинг
                // $this->billing_model->billing_comment_add($device['city_id'], $desc, $desc.' - HUAWEI - '.$gpon.'/'.$port_id.':'.$ont_id.' s/n:'.$ont, $billing_id);
                // здесь общий влан
                $cvlan = 1109;
                $service = $vlans['service_start'] + $ont_id;
                sleep(1);// надо дать время для завершения команды!!!
                $this->phptelnet->DoCommand("ont port native-vlan $port_id $ont_id eth 1 vlan $cvlan priority 0\n", $result);
                sleep(1);
                $log[]=$result;
                $this->phptelnet->DoCommand("quit\n", $result);
                sleep(1);// надо дать время для завершения команды!!!
                $this->phptelnet->DoCommand("service-port $service vlan $cvlan gpon 0/$gpon_id/$port_id ont $ont_id gemport 1 multi-service user-vlan $cvlan tag-transform translate\r\n", $result);
                sleep(1);// надо дать время для завершения команды!!!
                $log[]=$result;
            } else {
                $this->phptelnet->DoCommand("quit\n", $result);
                sleep(1);
                $result_array['log']=$log;
                return $result_array;
            }
            $this->phptelnet->DoCommand("quit\n", $result);
            sleep(1);
            $this->phptelnet->DoCommand("quit\n", $result);
            sleep(1);// надо дать время для завершения команды!!!
            $this->phptelnet->Disconnect();

            $result_array['ont_id']=$ont_id;
            $result_array['billing_vlans_result']='OK';
            $result_array['log']=$log;
            return $result_array;
        }
    }

    // unregister ONT by ONT DB ID
    public function unregister($id)
    {
        //input variables
        $log=array();
        $ont = $this->ont_model->get_ont_by_id($id);
        $device = $this->device_model->get_device_by_id($ont['id_device']);
        $ont_id = $ont['ont_index'];
        $vlans = $this->device_model->get_device_interface_sql_by_id_ifname($ont['id_device'], $ont['port_alias']);
        $service = $vlans['service_start'] + $ont_id;
        $if_name = explode("/", $ont['port_alias']);
        $gpon = $if_name['1'];
        $port = $if_name['2'];

        $result = $this->phptelnet->Connect(long2ip($device['ip']), $device['login'], $device['password']);
        $this->phptelnet->DoCommand("ena\n", $result);
        //sleep (1);
        $this->phptelnet->DoCommand("config\n", $result);
        //sleep (1);
        $this->phptelnet->DoCommand("undo service-port $service\n", $result);
        $log[]=$result;
        sleep(1);// надо дать время для завершения команды!!!
        $this->phptelnet->DoCommand("interface gpon 0/$gpon\n", $result);
        sleep(1);// надо дать время для завершения команды!!!
        $this->phptelnet->DoCommand("ont delete $port $ont_id", $result);
        $log[]=$result;
        preg_match("/success: (\d*)/s", $result, $t1);
        //todo почему нам это надо
        error_reporting(E_ALL & ~E_NOTICE);
        $success = $t1[1];
        if ($success == 1) {
            $this->phptelnet->DoCommand("quit\n", $result);
            sleep(1);
            $log[]=$result;
            $result_array['ont_id']=1;
            $result_array['log']=$log;
            return $result_array;
        } else {
            $this->phptelnet->DoCommand("quit\n", $result);
            sleep(1);
            $result_array['ont_id']=null;
            $result_array['log']=$log;
            return $result_array;
        }
        $this->phptelnet->DoCommand("quit\n", $result);
        sleep(1);
        $this->phptelnet->DoCommand("quit\n", $result);
        sleep(1);// надо дать время для завершения команды!!!
        $this->phptelnet->Disconnect();
        //todo remove ont from DB
        $result_array['ont_id']=$ont;
        $result_array['log']=$log;
        return $result_array;
    }

}