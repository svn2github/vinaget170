<?php

class dl_pandamemo_com extends Download {
    
    public function CheckAcc($cookie){
        $data = $this->lib->curl("http://www.pandamemo.com/?op=my_account", "lang=english;{$cookie}", "");
        if(stristr($data, 'Premium account expire:')) return array(true, "Until ".$this->lib->cut_str($data, 'Premium account expire:</TD><TD><b>','</b>'));
        else if(stristr($data, 'New password') && !stristr($data, 'Premium account expire')) return array(false, "accfree");
		else return array(false, "accinvalid");
    }
    
    public function Login($user, $pass){
        $data = $this->lib->curl("http://www.pandamemo.com/", "lang=english", "login={$user}&password={$pass}&op=login&redirect=http://www.pandamemo.com/");
        $cookie = "lang=english;{$this->lib->GetCookies($data)}";
		return $cookie;
    }
	
    public function Leech($url) {
		list($url, $pass) = $this->linkpassword($url);
		$data = $this->lib->curl($url, $this->lib->cookie, "");
		if($pass) {
			$post = $this->parseForm($this->lib->cut_str($data, '<Form name="F1"', '</Form>'));
			$post["password"] = $pass;
			$data = $this->lib->curl($url, $this->lib->cookie, $post);
			if(stristr($data,'Wrong password'))  $this->error("wrongpass", true, false, 2);
			elseif(!preg_match('@https?:\/\/(\w+\.)?pandamemo\.com(:\d+)?\/dl\/[^"\'><\r\n\t]+@i', $data, $giay))
			$this->error("notfound", true, false, 2); 	
			else	
			return trim($giay[0]);
		}
		elseif(stristr($data,'type="password" name="password')) 	$this->error("reportpass", true, false);
		elseif(stristr($data,'The file was deleted by its owner')) $this->error("dead", true, false, 2);
		elseif(!preg_match('@https?:\/\/(\w+\.)?pandamemo\.com(:\d+)?\/dl\/[^"\'><\r\n\t]+@i', $data, $dl)) {
			$post = $this->parseForm($this->lib->cut_str($data, '<Form name="F1"', '</Form>'));
			$data = $this->lib->curl($url, $this->lib->cookie, $post);
			if(!preg_match('@https?:\/\/(\w+\.)?pandamemo\.com(:\d+)?\/dl\/[^"\'><\r\n\t]+@i', $data, $giay))
			$this->error("notfound", true, false, 2);	
			else 	
			return trim($giay[0]);
		}
		else
        return trim($dl[0]);
		return false;
    }
	
}

/*
* Open Source Project
* Vinaget by ..::[H]::..
* Version: 2.7.0
* pandamemo Download Plugin by giaythuytinh176 [14.8.2013]
* Downloader Class By [FZ]
*/
?>