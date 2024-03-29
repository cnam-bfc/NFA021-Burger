<?php

/*
 * Copyright (c) 2015-2020, RouteXL
 * All rights reserved.
 * 
 * Redistribution and use in source and binary forms, with or without modification, 
 * are permitted provided that the following conditions are met:
 * 
 * 1. Redistributions of source code must retain the above copyright notice, 
 * this list of conditions and the following disclaimer.
 * 
 * 2. Redistributions in binary form must reproduce the above copyright notice, 
 * this list of conditions and the following disclaimer in the documentation 
 * and/or other materials provided with the distribution.
 * 
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" 
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE 
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE 
 * DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR 
 * ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES 
 * (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; 
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON 
 * ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT 
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS 
 * SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 * 
*/

/**
 * RouteXL API Connector
 * @Version 1.0
 */
class RouteXLAPI
{
    private const BASE_URL = 'https://api.routexl.com/v2/';
    private const SKIP_SSL = true;

    private $username = '';
    private $password = '';

    private $result = array();
    private $result_http_code = 0;
    private $result_error = '';

    /**
     * Constructor
     * 
     * @param string username RouteXL username
     * @param string password RouteXL password
     */
    public function __construct($username, $password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * Get status of the API
     * 
     * @return bool Success 
     */
    public function status()
    {
        try {
            // Use libcurl to connect and communicate
            $ch = curl_init(); // Initialize a cURL session
            curl_setopt($ch, CURLOPT_URL, RouteXLAPI::BASE_URL . 'status'); // Set the URL
            curl_setopt($ch, CURLOPT_HEADER, 0); // No header in the output
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // Return the output as a string
            curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate'); // Compress
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC); // Basic authorization
            curl_setopt($ch, CURLOPT_USERPWD, $this->username . ':' . $this->password); // Your credentials

            // Do not use this!
            if (RouteXLAPI::SKIP_SSL) curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Unsafe!

            // Execute the given cURL session
            $output = curl_exec($ch); // Get the output
            $this->result_http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE); // Last received HTTP code
            $this->result_error = curl_error($ch); // Get the last error
            curl_close($ch); // Close the connection

            // Decode the output
            if (json_decode($output, true)) {
                $this->result = json_decode($output, true);
            } else {
                $this->result = $output;
            }
        } catch (Exception $e) {

            $this->result_error = $e->getMessage();
            return false;
        }

        if ($this->result_http_code != 200) return false;
        else return true;
    }

    /**
     * Optimize an itinerary with multiple destinations
     * 
     * @param array locations Locations to be routed
     * @return bool Success 
     */
    public function tour($locations)
    {
        try {
            // Use libcurl to connect and communicate
            $ch = curl_init(); // Initialize a cURL session
            curl_setopt($ch, CURLOPT_URL, RouteXLAPI::BASE_URL . 'tour'); // Set the URL
            curl_setopt($ch, CURLOPT_HEADER, 0); // No header in the output
            curl_setopt($ch, CURLOPT_POST, 1); // Do a regular HTTP POST
            curl_setopt($ch, CURLOPT_POSTFIELDS, 'locations=' . json_encode($locations)); // Add the locations
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // Return the output as a string
            curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate'); // Compress
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC); // Basic authorization
            curl_setopt($ch, CURLOPT_USERPWD, $this->username . ':' . $this->password); // Your credentials

            // Do not use this!
            if (RouteXLAPI::SKIP_SSL) curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Unsafe!

            // Execute the given cURL session
            $output = curl_exec($ch); // Get the output
            $this->result_http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE); // Last received HTTP code
            $this->result_error = curl_error($ch); // Get the last error
            curl_close($ch); // Close the connection

            // Decode the output
            if (json_decode($output)) {
                $this->result = json_decode($output);
            } else {
                $this->result = $output;
            }
        } catch (Exception $e) {

            $this->result_error = $e->getMessage();
            return false;
        }

        if ($this->result_http_code != 200) return false;
        else return true;
    }

    /**
     * Get the result of the last request
     * @return array Result
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * Get the last HTTP code
     * @return int HTTP code
     */
    public function getResultHttpCode()
    {
        return $this->result_http_code;
    }

    /**
     * Get the last error
     * @return string Error
     */
    public function getResultError()
    {
        return $this->result_error;
    }
}
