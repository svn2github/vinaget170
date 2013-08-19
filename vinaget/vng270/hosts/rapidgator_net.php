<?php

class dl_rapidgator_net extends Download {

	public function CheckAcc($cookie){
		$data = $this->lib->curl("http://rapidgator.net/profile/index", "lang=en;{$cookie}", "");
		if(stristr($data, '<a href="/article/premium">Free</a>')) return array(false, "accfree");
		elseif(stristr($data, 'Premium till')) return array(true, "Until ".$this->lib->cut_str($data, 'Premium till','<span'));
		else return array(false, "accinvalid");
	}
	
	public function Login($user, $pass){
		$data = $this->lib->curl("https://rapidgator.net/auth/login", "lang=en", "LoginForm[email]={$user}&LoginForm[password]={$pass}&LoginForm[rememberMe]=1");
		$cookie = "lang=en;".$this->lib->GetCookies($data);
		return $cookie;
	}
	
    public function Leech($url) {
		$data = $this->lib->curl($url,"lang=en;".$this->lib->cookie,"");
		if(stristr($data, "You have reached daily quota")) $this->error("LimitAcc");
		elseif(stristr($data,'File not found</div>'))  $this->error("dead", true, false, 2);
		elseif(!preg_match('@https?:\/\/[a-z]+(\d+)\.rapidgator\.net\/\/\?r=download\/[^"\'><\r\n\t]+@i', $data, $giay))
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
* Rapidgator Download Plugin 
* Downloader Class By [FZ]
* Add check account by giaythuytinh176 19.7.2013
*/
?>