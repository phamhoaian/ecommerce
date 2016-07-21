<?php

/**
 * CSFRライブラリ
 *
 * ワンタイムチケットの発行など
 * m.haba
 *
 */



class Csrf_Simple
{

	
	public function __construct()
	{
		$this->CI =& get_instance();
		$this->CI->load->helper('cookie');
	}
	
	
	/**
	 * ワンタイムチケットの発行
	 */
	function set_ticket($ticket='',$make_html=FALSE)
	{
		if(! $ticket)
		{
			$ticket = md5(uniqid(mt_rand(), TRUE));

		}
			$timeout = time() + 600;
			set_cookie('ticket', $ticket,$timeout);
			set_cookie('ticket_time', $this->_get_time(),$timeout);
			
		
		
		if($make_html)
		{
			return '<input type="hidden" name="ticket" value="'.$ticket.'" />'."\n";
		}
		else
		{
			return $ticket;
		}
	}
	
	
	/**
	 * ワンタイムチケットの確認
	 */
	function chk_ticket($post_ticket='',$second='')
	{
		if(!$post_ticket)
		{
			$post_ticket = $this->CI->input->post('ticket');
			
			$post_ticket  = str_replace( "\0", "", $post_ticket );
			$post_ticket  = str_replace( '\0', "", $post_ticket );
		}
		
			
			$ticket =get_cookie('ticket');
			
			
			if (!$post_ticket || $post_ticket !== $ticket )
			{
				delete_cookie('ticket');
				delete_cookie('ticket_time');
				return FALSE;
			}
			else
			{
			
				if($second and is_int($second))
				{
					$ticket_time = get_cookie('ticket_time');
					
					$this->now = $this->_get_time();
					//$last_activity = $CI->session->userdata('last_activity');
					
					
					if (($ticket_time + $second) <= $this->now)
					{
						delete_cookie('ticket');
						delete_cookie('ticket_time');
						return FALSE;
					}
				}
				
				delete_cookie('ticket');
				delete_cookie('ticket_time');
				
				return TRUE;
			}
		
	
	
	}
	
	
	
	
	
	function _get_time()
	{

		$time = time();


		return $time;
	}
	
	
}

?>