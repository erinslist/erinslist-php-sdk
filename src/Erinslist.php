<?php

namespace Erinslist;

use \Curl\Curl;
use \Common\Util;

class Erinslist {

    const API_URL = 'https://www.erinslist.us/api';

    private $_curl;

    public function __construct($key, $secret) {
        $this->_curl = new Curl();
        $this->_curl->setBasicAuthentication($key, $secret);
        $this->_curl->setHeader('Content-Type', 'application/json');
    }

    private static function _format_address_data($address) {
        $data = [];

        if (is_string($address)) {
            $data['address'] = $address;
        } else {
            $position = is_array($address) ? new Position($address[0], $address[1]) : $address;
            if (!$position instanceof Position) {
                throw new Exception('Data is not a valid position');
                return false;
            }

            $data['lat'] = $position->lat;
            $data['lng'] = $position->lng;
        }

        return $data;
    }

    /**
     * Evaluate an address
     *
     * @param mixed $address
     *
     * @return object
     */
    public function evaluate($address) {
        $data = self::_format_address_data($address);
        if (!$data) return false;

        $result = new \stdClass;
        $response = $this->_curl->post(self::API_URL.'/evaluate', $data);
        if ($this->_curl->error) {
            $result->status = 'ERR '.$this->_curl->errorCode;
            throw new ProtocolException($response, $this->_curl);
        } else {
            $result->status = 'OK';
            $result->message = $response->evaluation;
            $result->radius = $response->radius;
            $result->incidents = [];
            foreach ($response->incidents as $incident_info) {
                $result->incidents[] = new Incident($incident_info);
            }
        }

        return $result;
    }

    /**
     * Get list of incidents
     *
     * @param mixed $address
     * Based address to search from
     *
     * @return array
     */
    public function get_incidents($address, $radius = 1000) {
        $incidents = [];
        $data = self::_format_address_data($address);
        if (!$data) return false;

        $data['radius'] = $radius;

        $response = $this->_curl->get(self::API_URL.'/incidents', $data);
        if ($this->_curl->error) {
            throw new ProtocolException($response, $this->_curl);
        } else {
            foreach ($response as $incident_info) {
                $incidents[] = new Incident($incident_info);
            }
        }

        return $incidents;
    }

    /**
     * Report an incident
     *
     * @param Reporter $reporter
     * THe person reporting the incident
     *
     * @param mixed $address
     * Reported address. Can be a formatted address or a coordinate array
     *
     * @return Incident
     */
    public function report_incident(Reporter $reporter, $address, $notes = '') {
        if (!$address) {
            throw new Exception('data must be provided');
            return false;
        }

        $data = self::_format_address_data($address);
        if (!$data) return false;

        $data = array_merge($data, [
            'notes' => $notes,
            'reporter' => $reporter->name,
            'reporter_email' => $reporter->email
        ]);

        $response = $this->_curl->post(self::API_URL.'/incidents', $data);
        if ($this->_curl->error) {
            throw new ProtocolException($response, $this->_curl);
            return false;
        } else {
            return new Incident($response);
        }
    }
}