<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Itemlist_model extends CI_Model {
	
	function __construct() {
		parent::__construct ();
	}
	
	function getList($sort = 1) {
	    if ($sort == 1) {
	        $orderby = "sort DESC";
	    } else if ($sort == 2) {
	        $orderby = "sort ASC";
	    } else {
	        $orderby = "sort DESC";
	    }
	    
		$sql = "
			SELECT
				id,
				name,
				price,
				level,
                (CASE 
            		WHEN level = 1 THEN '기타'
            		WHEN level = 2 THEN '희귀'
                    WHEN level = 3 THEN '영웅'
                    WHEN level = 4 THEN '전설'
                END) AS levelName,
                (CASE 
            		WHEN level = 1 THEN '#000000'
            		WHEN level = 2 THEN '#1783b1'
                    WHEN level = 3 THEN '#e60000'
                    WHEN level = 4 THEN '#c841d9'
                END) AS levelColor
			FROM
				itemList
            ORDER BY
                $orderby
		";
	
		$resultQuery = $this->db->query($sql)->result_array();
		
		return $resultQuery;
	}
}