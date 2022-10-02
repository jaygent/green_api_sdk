<?php

namespace jaygent;

/**
 * Class Green_api
 * @package jaygent
 */
class Green_api
{
    protected  $token = '';
    protected  $url = 'https://api.green-api.com';
    protected $instance_id = '';

    /**
     * @param string $method
     * @return string
     */
    public function createUrl($method)
    {
        return "{$this->url}/waInstance{$this->instance_id}/{$method}/{$this->token}";
    }

    /**
     * Send Green_api query
     * @param string $method
     * @param null|array $args
     * @param string $qmethod
     * @return bool|string
     */
    public function query($method, $args = null, $qmethod = 'GET')
    {
        $url = $this->createUrl($method);
        $ch = curl_init($url);
        if($qmethod == "POST" && isset($args) && is_array($args)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($args, JSON_UNESCAPED_UNICODE));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_HEADER, false);
        } elseif($qmethod == "GET") {
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_HEADER, false);
        }
        $res = curl_exec($ch);
        curl_close($ch);
        return $res;
    }

    /**
     * SendMessage
     * @param string $chatId (@c.us-number phone,@g.us-group)
     * @param string $message
     * @param string|null $quotedMessageId
     */

    public function sendMessage($chatId,  $message, $quotedMessageId=null)
    {
        return json_decode($this->query('sendMessage', ['chatId' => $chatId, 'message' => $message],'POST'), 1);
    }


    public function logout():array
    {
        return json_decode($this->query('Logout'));
    }


    public function reboot()
    {
        return json_decode($this->query('Reboot'));
    }


    public function getQR()
    {
        return json_decode($this->query('Reboot'));
    }


    public function getStateInstance()
    {
        return json_decode($this->query('getStateInstance'));
    }

    /**
     * @param string $chat
     * @param mixed $file
     * @return mixed
     */

    public function sendFile( $chat, $file)
    {
        return json_decode($this->query('SendFileByUpload', ['chatId' => $chat,  'file' => $file], 'POST'), 1);
    }

    /**
     * @param string $chat
     * @param string $urlFile
     * @param string $filename
     * @return mixed
     */

    public function sendFileURL( $chat, $urlFile, $filename)
    {
        return json_decode($this->query('SendFileByUrl', ['chatId' => $chat, 'urlFile' => $urlFile, 'fileName' => $filename],'POST'), 1)['sent'];
    }

    /**
     * @param string $chat
     * @param int $count
     * @return mixed
     */

    public function getChatHistory($chat, $count=100)
    {
        return json_decode($this->query('GetChatHistory',['chatId' => $chat,'count'=>$count],'POST'));
    }

    /**
     * @param int $chat
     * @return mixed
     */
    public function checkWhatsapp($chat)
    {
        return json_decode($this->query('CheckWhatsapp',['phoneNumber' => $chat],'POST'));
    }
}