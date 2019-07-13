<?php

class Device extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('device_model');
        $this->load->helper('url_helper');
        $this->load->library('form_validation');
        $this->load->library('ion_auth');

    }

    public function index()
    {
        if (!$this->ion_auth->logged_in())
        {
            // redirect them to the login page
            // не авторизирован
            redirect('auth/login', 'refresh');
        }
        else
        {
            $data['device'] = $this->device_model->get_devices();
            $data['header'] = 'Список устройств';
            $data['link'] = anchor('device/add/', 'Добавить', 'class="ui green button"');
            $this->load->view('templates/header', $data);
            $this->load->view('device/index', $data);
            $this->load->view('templates/footer');
        }
    }

    public function add()
    {
        // разрешаем доступ определенным группам
        $admins = 'admins';
        if (!$this->ion_auth->logged_in())
        {
            // redirect them to the login page
            // не авторизирован
            redirect('auth/login', 'refresh');
        }
        elseif (!$this->ion_auth->in_group($admins))
        {
            $this->load->view('templates/no_access');
        }
        else
        {
            //todo переделать на другой метод валидации
            //todo добавить добавление типа протокола
            $this->form_validation->set_rules('name', 'Название устройства', 'required', array('required' => 'не введено название'));
            $this->form_validation->set_rules('ip', 'IP', 'required', array('required' => 'не введено IP'));
            $this->form_validation->set_rules('snmp_read', 'SNMP read', 'required', array('required' => 'не введено SNMP read'));
            $this->form_validation->set_rules('snmp_write', 'SNMP write', 'required', array('required' => 'не введено SNMP write'));
            $this->form_validation->set_rules('login', 'login', 'required', array('required' => 'не введен login'));
            $this->form_validation->set_rules('password', 'password', 'required', array('required' => 'не введен password'));
            if ($this->form_validation->run() === FALSE) {
                $data['header'] ='Добавить устройство';
                $this->load->view('templates/header',$data);
                $this->load->view('device/add', $data);
                $this->load->view('templates/footer');
            } else {
                $this->device_model->add_device();
                redirect('device/index');
            }
        }

    }

    public function delete($id)
    {
        // разрешаем доступ определенным группам
        $admins = 'admins';
        if (!$this->ion_auth->logged_in())
        {
            // redirect them to the login page
            // не авторизирован
            redirect('auth/login', 'refresh');
        }
        elseif (!$this->ion_auth->in_group($admins))
        {
            $this->load->view('templates/no_access');
        }
        else
        {
            //todo дописать проверку зависимостей
            $this->device_model->delete_device($id);
            redirect('device/index');
        }

    }

    public function edit($id)
    {
        // разрешаем доступ определенным группам
        $admins = 'admins';
        if (!$this->ion_auth->logged_in())
        {
            // redirect them to the login page
            // не авторизирован
            redirect('auth/login', 'refresh');
        }
        elseif (!$this->ion_auth->in_group($admins))
        {
            $this->load->view('templates/no_access');
        }
        else
        {
            //todo переделать на другой метод валидации
            //todo добавить добавление типа протокола
            $this->form_validation->set_rules('name', 'Название устройства', 'required', array('required' => 'не введено название'));
            $this->form_validation->set_rules('ip', 'IP', 'required', array('required' => 'не введено IP'));
            $this->form_validation->set_rules('snmp_read', 'SNMP read', 'required', array('required' => 'не введено SNMP read'));
            $this->form_validation->set_rules('snmp_write', 'SNMP write', 'required', array('required' => 'не введено SNMP write'));
            $this->form_validation->set_rules('login', 'login', 'required', array('required' => 'не введен login'));
            $this->form_validation->set_rules('password', 'password', 'required', array('required' => 'не введен password'));
            if ($this->form_validation->run() === FALSE) {
                $data['device'] = $this->device_model->get_device_by_id($id);
                $data['header'] ='Редактировать устройство';
                $this->load->view('templates/header',$data);
                $this->load->view('device/edit', $data);
                $this->load->view('templates/footer');
            } else {
                $this->device_model->edit_device($id);
                redirect('device/index');
            }
        }

    }

    public function view($id)
    {
        if (!$this->ion_auth->logged_in())
        {
            // redirect them to the login page
            // не авторизирован
            redirect('auth/login', 'refresh');
        }
        else
        {
            if(!empty($id)) {
                $data['id_device'] = $id;
                $data['device'] = $this->device_model->get_device_by_id($id);
                // check if we have interfaces in DB
                if ($this->device_model->get_device_interfaces_sql($id)) {
                    $data['link'] = anchor('device/unregistered/' . $id, 'Показать unreg ONT', 'class="ui green button"');
                    $data['interfaces'] = $this->device_model->get_device_interfaces($id);
                } else {
                    $data['link'] = anchor('device/initial/' . $id, 'Создать интерфейсы', 'class="ui green button"');
                    $data['interfaces'] = null;
                }
                $data['header'] = 'Список портов';
                $this->load->view('templates/header', $data);
                $this->load->view('device/view', $data);
                $this->load->view('templates/footer');
            }
            else
            {
                $this->load->view('templates/no_data');
            }
        }
    }

    public function initial($id)
    {
        // разрешаем доступ определенным группам
        $admins = 'admins';
        if (!$this->ion_auth->logged_in())
        {
            // redirect them to the login page
            // не авторизирован
            redirect('auth/login', 'refresh');
        }
        elseif (!$this->ion_auth->in_group($admins))
        {
            $this->load->view('templates/no_access');
        }
        else
        {
            if(!empty($id)) {
                $this->device_model->initial_device($id);
                redirect('device/view/'.$id);
            }
            else
            {
                $this->load->view('templates/no_data');
            }
        }

    }

    public function edit_interface($id)
    {
        // разрешаем доступ определенным группам
        $admins = 'admins';
        if (!$this->ion_auth->logged_in())
        {
            // redirect them to the login page
            // не авторизирован
            redirect('auth/login', 'refresh');
        }
        elseif (!$this->ion_auth->in_group($admins))
        {
            $this->load->view('templates/no_access');
        }
        else
        {
            if(!empty($id)) {
                //todo переделать на другой метод валидации
                $this->form_validation->set_rules('svlan', 'SVLAN', 'required', array('required' => 'не введен SVLAN'));
                $data['interface'] = $this->device_model->get_device_interface_sql_by_id($id);
                $id_device = $data['interface']['id_device'];
                if ($this->form_validation->run() === FALSE) {
                    $device = $this->device_model->get_device_by_id($id_device);
                    $data['header'] = 'Редактировать порт - ' . $device['name'];
                    $this->load->view('templates/header', $data);
                    $this->load->view('device/edit_interface', $data);
                    $this->load->view('templates/footer');
                } else {
                    $this->device_model->edit_interface($id);
                    redirect('device/view/' . $id_device);
                }
            }
            else
            {
                $this->load->view('templates/no_data');
            }
        }
    }

    public function unregistered($id)
    {
        // разрешаем доступ определенным группам
        $admins = array('admins', 'manager');
        if (!$this->ion_auth->logged_in())
        {
            // redirect them to the login page
            // не авторизирован
            redirect('auth/login', 'refresh');
        }
        elseif (!$this->ion_auth->in_group($admins))
        {
            $this->load->view('templates/no_access');
        }
        else
        {
            if(!empty($id)) {
                //todo переделать по методу registered
                $data['device'] = $this->device_model->get_device_by_id($id);
                $data['unregistered'] = $this->snmp_model->get_snmp_unregistered($id);
                $data['if_aliases'] = $this->device_model->get_device_interfaces_alias_sql($id);
                if ($data['unregistered']) $data['header'] = 'Список незарегистрированных ONT - '.count($data['unregistered'])." шт";
                else $data['header'] = 'Список незарегистрированных ONT ';
                $data['link'] = anchor('device/unregistered/' . $id, 'Повторить', 'class="ui green button"');
                $this->load->view('templates/header', $data);
                $this->load->view('device/unregistered', $data);
                $this->load->view('templates/footer');
            }
            else
            {
                $this->load->view('templates/no_data');
            }
        }
    }

    public function registered($id)
    {
        // разрешаем доступ определенным группам
        $admins = array('admins', 'manager');
        if (!$this->ion_auth->logged_in())
        {
            // redirect them to the login page
            // не авторизирован
            redirect('auth/login', 'refresh');
        }
        elseif (!$this->ion_auth->in_group($admins))
        {
            $this->load->view('templates/no_access');
        }
        else
        {
            if(!empty($id)) {
                $data['device'] = $this->device_model->get_device_by_id($id);
                $data['registered'] = $this->device_model->get_device_registered($id, null);
                $this->device_model->sync_ont($id, $data['registered']);
                $data['header'] = 'Список зарегистрированных ONT';
                $this->load->view('templates/header', $data);
                $this->load->view('device/registered', $data);
                $this->load->view('templates/footer');
            }
            else
            {
                $this->load->view('templates/no_data');
            }
        }
    }

    public function view_interface($id)
    {
        if (!$this->ion_auth->logged_in())
        {
            // redirect them to the login page
            // не авторизирован
            redirect('auth/login', 'refresh');
        }
        else
        {
            if(!empty($id)) {
                $data['interface'] = $this->device_model->get_device_interface_sql_by_id($id);
                $id_device = $data['interface']['id_device'];
                $data['device'] = $this->device_model->get_device_by_id($id_device);
                $ont_port=$data['interface']['if_real_index'];
                $data['registered'] = $this->device_model->get_device_registered($id_device, $ont_port);
                $data['header'] = 'Список зарегистрированных ONT';
                $this->load->view('templates/header', $data);
                $this->load->view('device/view_interface', $data);
                $this->load->view('templates/footer');
            }
            else
            {
                $this->load->view('templates/no_data');
            }
        }
    }

    public function register()
    {
        // разрешаем доступ определенным группам
        $admins = array('admins', 'manager');
        if (!$this->ion_auth->logged_in())
        {
            // redirect them to the login page
            // не авторизирован
            redirect('auth/login', 'refresh');
        }
        elseif (!$this->ion_auth->in_group($admins))
        {
            $this->load->view('templates/no_access');
        }
        else
        {
            if (!$this->ion_auth->user()->row()->billing_id) $billing_id=0;
            else $billing_id=$this->ion_auth->user()->row()->billing_id;
            //todo добавить проверку что есть данные для регистрации
            $result = $this->telnet_model->register($billing_id);
            $id = $result['ont_id'];
            //if (is_null($result)) {
            if (is_null($id)) {
                $data['header'] = 'Операция неуспешна';
                $data['error'] = 'произошла какая то ошибка)';
                $data['log'] = $result['log'];
                $data['link'] = anchor('device/unregistered/' . $this->input->post('dev_id'), 'Показать unreg ONT', 'class="ui green button"');
                $this->load->view('templates/header', $data);
                $this->load->view('device/register', $data);
                $this->load->view('templates/footer');
            } else {
                $data['header'] = 'ONT успешно зарегистрирована';
                $data['gpon_id'] = $this->input->post('gpon_id');
                $data['dev_id'] = $this->input->post('dev_id');
                $data['port_id'] = $this->input->post('port_id');
                $data['ont'] = $this->input->post('ont');
                $data['desc'] = $this->input->post('desc');
                $data['ont_id'] = $result['ont_id'];
                //todo добавить добавление в базу данных
                /*
                $ont_info = array(
                    'id_device' => $this->input->post('dev_id'),
                    'port_index' => $this->input->post('gpon_id'),
                    'port_alias' => $item['if_alias'],
                    'ont_index' => $this->input->post('ont'),
                    'ont_mac' => $item['value'],
                    'ont_desc' => $this->input->post('desc'),
                );
                $this->db->insert('ont', $ont_info);
                */
                // отключенный модуль биллинга
                //$data['billing_vlans_result'] = $result['billing_vlans_result'];
                //$data['log'] = $result['log'];
                $data['link'] = anchor('device/unregistered/' . $this->input->post('dev_id'), 'Показать unreg ONT', 'class="ui green button"');
                $this->load->view('templates/header', $data);
                $this->load->view('device/register', $data);
                $this->load->view('templates/footer');
            }
        }
    }

    public function unregister($id)
    {
        // разрешаем доступ определенным группам
        $admins = array('admins', 'manager');
        if (!$this->ion_auth->logged_in())
        {
            // redirect them to the login page
            // не авторизирован
            redirect('auth/login', 'refresh');
        }
        elseif (!$this->ion_auth->in_group($admins))
        {
            $this->load->view('templates/no_access');
        }
        else
        {
            if(!empty($id)) {
                //todo дописать информацию о удалении ont
                $result = $this->telnet_model->unregister($id);
                $ont_id = $result['ont_id'];
                if (is_null($ont_id)) {
                    $data['header'] = 'Операция неуспешна';
                    $data['error'] = 'произошла какая то ошибка) удаляй вручную';
                    $data['log'] = $result['log'];
                    //$data['link'] = anchor('device/unreg/'.$this->input->post('dev_id'), 'Показать unreg ONT', 'class="ui green button"');
                    $this->load->view('templates/header', $data);
                    $this->load->view('device/unregister', $data);
                    $this->load->view('templates/footer');
                } else {
                    $data['header'] = 'ONT успешно удалена';
                    //$data['link'] = anchor('device/unreg/'.$this->input->post('dev_id'), 'Показать unreg ONT', 'class="ui green button"');
                    $this->load->view('templates/header', $data);
                    //$data['log'] = $result['log'];
                    $this->load->view('device/unregister', $data);
                    $this->load->view('templates/footer');
                }
            }
            else
            {
                $this->load->view('templates/no_data');
            }
        }
    }

    public function search()
    {
        if (!$this->ion_auth->logged_in())
        {
            // redirect them to the login page
            // не авторизирован
            redirect('auth/login', 'refresh');
        }
        else
        {
            if(!empty($this->input->post('search')))
            {
                $data['header'] = 'Результат поиска - ' . $this->input->post('search');
                $data['search'] = trim($this->input->post('search'));
                $data['ont'] = $this->device_model->search_ont($data['search']);
                $this->load->view('templates/header', $data);
                $this->load->view('device/search', $data);
                $this->load->view('templates/footer');
            }
            else
            {
                $data['header'] = 'Пустой поисковый запрос';
                $data['search'] = 'Поэтому';
                $data['ont'] = null;
                $this->load->view('templates/header', $data);
                $this->load->view('device/search', $data);
                $this->load->view('templates/footer');
            }
        }
    }

    public function view_ont($id)
    {
        if (!$this->ion_auth->logged_in())
        {
            // redirect them to the login page
            // не авторизирован
            redirect('auth/login', 'refresh');
        }
        else
        {
            if(!empty($id)) {
                // получить интерфейсы и сигналы
                $data['ont'] = $this->ont_model->get_ont_by_id($id);
                $device_id = $data['ont']['id_device'];
                $iface_id = $data['ont']['port_index'];
                $ont_id = $data['ont']['ont_index'];
                // get ONT LOGS ONLINE
                $oid = '1.3.6.1.4.1.2011.6.128.1.1.2.101.1.6.'.$iface_id.'.'.$ont_id;
                $data['log_up'] = $this->snmp_model->get_snmp_oid_walk($device_id, $oid);
                // get ONT LOGS OFFLINE
                $oid = '1.3.6.1.4.1.2011.6.128.1.1.2.101.1.7.'.$iface_id.'.'.$ont_id;
                $data['log_down'] = $this->snmp_model->get_snmp_oid_walk($device_id, $oid);
                // get ONT LOGS DownCause
                $oid = '1.3.6.1.4.1.2011.6.128.1.1.2.101.1.8.'.$iface_id.'.'.$ont_id;
                $data['log_couse'] = $this->snmp_model->get_snmp_oid_walk($device_id, $oid);

                $data['device'] = $this->device_model->get_device_by_id($device_id);
                $data['ont_data'] = $this->ont_model->get_ont_snmp_info($id);
                // get OLT ifSignal
                $oid = 'SNMPv2-SMI::enterprises.2011.6.128.1.1.2.23.1.4';
                $olt_signal = $oid . '.' . $data['ont']['port_index'];
                $data['olt_data'] = $this->snmp_model->get_snmp_oid($device_id, $olt_signal);
                $data['header'] = 'Информация об ONT - '.$data['ont']['ont_desc'];
                $this->load->view('templates/header', $data);
                $this->load->view('device/view_ont', $data);
                $this->load->view('templates/footer');
            }
            else
            {
                $this->load->view('templates/no_data');
            }
        }
    }

    public function view_ont_iface($device_id, $iface_id, $ont_id)
    {
        if (!$this->ion_auth->logged_in())
        {
            // redirect them to the login page
            // не авторизирован
            redirect('auth/login', 'refresh');
        }
        else
        {
            if(!empty($device_id)) {
                // получить интерфейсы и сигналы
                // get ONT LOGS ONLINE
                $oid = '1.3.6.1.4.1.2011.6.128.1.1.2.101.1.6.'.$iface_id.'.'.$ont_id;
                $data['log_up'] = $this->snmp_model->get_snmp_oid_walk($device_id, $oid);
                // get ONT LOGS OFFLINE
                $oid = '1.3.6.1.4.1.2011.6.128.1.1.2.101.1.7.'.$iface_id.'.'.$ont_id;
                $data['log_down'] = $this->snmp_model->get_snmp_oid_walk($device_id, $oid);
                // get ONT descs
                $oid = '1.3.6.1.4.1.2011.6.128.1.1.2.43.1.9.'.$iface_id.'.'.$ont_id;
                $data['ont']['ont_desc'] = $this->snmp_model->get_snmp_oid($device_id, $oid);
                // get ONT mac
                $oid = 'SNMPv2-SMI::enterprises.2011.6.128.1.1.2.43.1.3.'.$iface_id.'.'.$ont_id;
                $data['ont']['ont_mac'] = $this->snmp_model->get_snmp_oid($device_id, $oid);
                $data['ont']['ont_mac'] = str_replace(' ','',$data['ont']['ont_mac']);
                // get ONT LOGS DownCause
                $oid = '1.3.6.1.4.1.2011.6.128.1.1.2.101.1.8.'.$iface_id.'.'.$ont_id;
                $data['log_couse'] = $this->snmp_model->get_snmp_oid_walk($device_id, $oid);

                //IF-MIB::ifName. port_alias
                $data['ont']['port_alias'] = $this->device_model->get_device_interface_sql_by_id_ifindex($device_id, $iface_id)['ifName'];
                $data['ont']['port_index'] = $this->device_model->get_device_interface_sql_by_id_ifindex($device_id, $iface_id)['id'];

                $data['device'] = $this->device_model->get_device_by_id($device_id);
                // get ONT data by snmp
                $data['ont_data'] = $this->ont_model->get_ont_snmp_info_port($device_id, $iface_id, $ont_id);
                // get OLT ifSignal
                $oid = 'SNMPv2-SMI::enterprises.2011.6.128.1.1.2.23.1.4';
                $olt_signal = $oid . '.' . $iface_id;
                $data['olt_data'] = $this->snmp_model->get_snmp_oid($device_id, $olt_signal);
                $data['header'] = 'Информация об ONT - '.$data['ont']['ont_desc'];
                //$data['link'] = anchor('device/add/', 'Добавить', 'class="ui green button"');
                $this->load->view('templates/header', $data);
                $this->load->view('device/view_ont', $data);
                $this->load->view('templates/footer');
            }
            else
            {
                $this->load->view('templates/no_data');
            }
        }
    }
}