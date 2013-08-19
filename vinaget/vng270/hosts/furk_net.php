<?php

class dl_furk_net extends Download {
	
    public function CheckAcc($cookie){
        $data = $this->lib->curl("https://www.furk.net/users/account", $cookie, "");
        if(stristr($data, '<dt>Account type:</dt>') && stristr($data, '<dd>premium</dd>')) return array(true, "accpremium");
        elseif(stristr($data, '<dt>Account type:</dt>') && stristr($data, '<dd>free</dd>')) return array(true, "accfree");
		else return array(false, "accinvalid");
    } 
    
    public function Login($user, $pass){
		$data = $this->lib->curl("https://www.furk.net/api/login/login", "", "login={$user}&pwd={$pass}");
		$cookie = $this->lib->GetCookies($data);
		return $cookie;
    }
	
    public function Leech($url) {
		$data = $this->lib->curl($url, $this->lib->cookie, "");
		if(!preg_match('@http:\/\/(\w+)?\.gcdn\.bi[^"\'><\r\n\t]+@i', $this->lib->cut_str($data, 'class="dl_link button-large', 'onClick'), $giay))
		$this->error("notfound", true, false, 2);
		else
		return trim($giay[0]);
		return false;
    }
	
}

/*
* Open Source Project
* Vinaget by ..::[H]::..
* Version: 2.7.0
* furk.net Download Plugin by giaythuytinh176 [12.8.2013]
* Downloader Class By [FZ]
*/
?>