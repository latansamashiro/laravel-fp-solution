<?php

namespace Latansamashiro\Fingerprint;

use TADPHP\TADFactory;

/**
 * Basic Calculator.
 *
 */
class FingerPrint
{
    protected $ip_address;
    protected $port;
    protected $comkey;

    public function __construct($ip_address, $comkey, $port)
    {
        $this->ip_address = $ip_address;
        $this->port = $port;
        $this->comkey = $comkey;

    }

    public function connect()
    {
        $is_alive = false;
        try {
            $tad = $this->get_fingerprint();
            $is_alive = $tad->is_alive();
            return $is_alive;
        } catch (\Exception $e) {
            return $is_alive;
        }
    }

    public function getData($date_from = '', $date_to = '') {
        $result = [];
        try {
            $tad = $this->get_fingerprint();
            $attendance = $tad->get_att_log();
            if ($date_from != '' && $date_to != '') {
                $attendance = $attendance->filter_by_date(
                    ['start' => $date_from, 'end' => $date_to]
                );
            }

            $buffer = $attendance->get_response(['format'=>'json']);
            $buffer = json_decode($buffer, true);

            // remove empty value
            $buffer = array_filter($buffer);
            // reindex array
            $buffer = array_values($buffer);

            foreach ($buffer[0] as $key => $value) {
                $datetime = date('Y-m-d H:i:s', strtotime($value['DateTime']));
                $data['pin'] = $value['PIN'];
                $data['status'] = $value['Status'];
                $data['verified'] = $value['Verified'];
                $data['datetime'] = date('Y-m-d H:i:s', strtotime($datetime));
                $data['date'] = date('Y-m-d', strtotime($datetime));
                $data['time'] = date('H:i:s', strtotime($datetime));
                array_push($result, $data);
            }
            return $result;
        } catch (\Exception $e) {
            return $result;
        }
    }

    private function get_fingerprint()
    {
        $tad = (new TADFactory(['ip'=> $this->ip_address, 'com_key' => $this->comkey, 'udp_port' => $this->port]))->get_instance();
        return $tad;
    }
}
