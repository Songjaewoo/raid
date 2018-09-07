<?php

class init_define extends CI_Controller {
	function __construct() {
		parent::__construct();
		
		$this->load->helper('security');
		$this->load->helper('alert_helper');
		$this->load->helper('url');
	}
	
	public function init() {
		
// 		echo '<pre>' . print_r($this->session->all_userdata(), true) . '</pre>';

		$isLogin = $this->session->userdata('isLogin');
		if ($isLogin) {
			define('LOGIN_ID', $this->session->userdata('id'));
			define('LOGIN_MEMBER_ID', $this->session->userdata('memberId'));
			define('LOGIN_NICKNAME', $this->session->userdata('nickname'));
			define('LOGIN_GROUP_NAME', $this->session->userdata('groupName'));
			define('LOGIN_LEVEL', $this->session->userdata('level'));
		} else {
			if ($this->uri->segment(1) != "auth") {
				alert("로그인이 필요합니다.", "/auth/login");
			}
		}
		
		define('LOGIN_IP', $this->input->ip_address());
		define('CURRENT_URL', $this->security->xss_clean($this->currentFullUrl()));
	}
	
	private function currentFullUrl() {
		$url = $this->config->site_url($this->uri->uri_string());
		return $_SERVER['QUERY_STRING'] ? $url.'?'.$_SERVER['QUERY_STRING'] : $url;
	}
}