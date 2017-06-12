<?php

namespace App\Helpers;

use App\Ticket;
use App\TicketReply;
use GuzzleHttp\Client;

class ServiceDeskApi
{
    protected $key = '';

    protected $client;

    function __construct()
    {
        $this->key = config('services.sdp.key');
        $this->client = new Client(['base_uri' => config('services.sdp.base_url')]);
    }

    function getRequests()
    {
        $response = $this->send('/sdpapi/request', 'GET_REQUESTS', [
            'from' => 0,
            'limit' => 200,
            'filterby' => 'All_Pending_User'
        ]);

        $requests = [];

        foreach ($response->response->operation->Details->record as $record) {
            $request = [];
            foreach ($record as $value) {
                $key = (string)$value->name;
                $request[$key] = ((string)$value->value);
            }
            $requests[] = $request;
        }

        return $requests;
    }

    function getRequest($id)
    {
        $response = $this->send("/sdpapi/request/{$id}", 'GET_REQUEST');

        $request = [];
        foreach ($response->response->operation->Details->parameter as $param) {
            $key = (string)$param->name;
            $request[$key] = ((string)$param->value);
        }
        return $request;
    }

    function addReply(TicketReply $reply)
    {
        $this->send('/sdpapi/request/' . $reply->ticket->sdp_id, 'REPLY_REQUEST', [
            ['parameter' => ['name' => 'to', 'value' => $reply->ticket->requester->email]],
            ['parameter' => ['name' => 'subject', 'value' => 'Re: ' . $reply->ticket->subject]],
            ['parameter' => ['name' => 'description', 'value' => 'Re: ' . $reply->content]],
        ]);
    }

    function getConversations()
    {

    }

    function getConversation()
    {

    }

    function addResolution()
    {
    }

    function getResolution()
    {

    }

    protected function send($url, $operation, $data = '')
    {
        $params = [
            'TECHNICIAN_KEY' => $this->key,
            'OPERATION_NAME' => $operation
        ];

        if ($data) {
            if (is_string($data)) {
                $params['INPUT_DATA'] = $data;
            } else {
                $params['INPUT_DATA'] = $this->buildData($data);
            }
        }

        $response = $this->client->post($url, [
            'form_params' => $params
        ])->getBody()->getContents();

        return simplexml_load_string($response);
    }

    protected function buildData($data)
    {
        $operation = [
            'Operation' => ['Details' => $data]
        ];

        return $this->buildXML($operation);
    }

    protected function buildXML($data)
    {
        $string = '';

        foreach ($data as $key => $value) {
            if (!is_numeric($key)) {
                $string .= "<{$key}>";
            }

            if (is_array($value)) {
                $string .= $this->buildXML($value);
            } else {
                $string .= htmlspecialchars($value);
            }

            if (!is_numeric($key)) {
                $string .= "</{$key}>";
            }
        }

        return $string;
    }
}