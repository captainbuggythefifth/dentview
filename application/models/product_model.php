<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
	class product_model extends CI_Model
	{
		private $table;

		function __construct()
		{
		    parent::__construct();
		    $this->table='products';
		}
		
		function get_flags(){
		$this->db->order_by('id', 'desc');
		$result = $this->db->get('flags');
			return $result->result_array();
		}
		
		function get_all()
		{

                     $this->db->where('quantity >',0);
                     $this->db->where('status = ','active');
                     $result = $this->db->get($this->table);
                     if( $result->num_rows > 0 )
                     {
                           return $result->result_array();
                     }
                     else
                     {
                           return false;
                        
                    }
                
                }
		
		function get_featured()
		{

		     $this->db->where('quantity >',0);
		     $this->db->where('status = ','active');
			 $this->db->limit('5');
			 $result = $this->db->get($this->table);
			 if( $result->num_rows > 0 )
			 {
			       return $result->result_array();
			 }
			 else
			 {
			       return false;
             }
		}
		
		function get_latest()
		{
			 $this->db->where('quantity >',0);
		     $this->db->where('status = ','active');
			 $this->db->order_by('id', 'desc');
			 $result = $this->db->get($this->table);
			 if( $result->num_rows > 0 )
			 {
			       return $result->result_array();
			 }
			 else
			 {
			       return false;
             }
		}
		function get_one($id)
		{
		 	 $this->db->where('id',$id);
			 $result = $this->db->get($this->table);
             return $result->row_array();
		}
		function get_one_active($id)
		{
		 	 $this->db->where('id',$id);
			 $this->db->where('status','active');
			 $result = $this->db->get($this->table);
             return $result->row_array();
		}

		function update($field)
		{
		    //print_r($field);
		    $this->db->where('id',$field['id']);
			$result = $this->db->update($this->table,$field);
			return $result;
		}

		function search_product_name($name)
		{
		   //$this->db->where('name like %',$name);
		   //$sql = "SELECT * FROM ".$this->table." WHERE name LIKE '".$name."%'";
		   //$result = $this->db->get($this->table);
		   $this->db->like('name',$name);
		   $this->db->where('status','active');
		   //$result = $this->db->query($sql);
		   $result = $this->db->get($this->table);
		   return $result->result_array();
		}
		
		function record_count()
		{
			return $this->db->count_all($this->table);
		}
		
		public function fetch_products($limit, $start) 
		{

        	$this->db->limit($limit, $start);
        	$query = $this->db->get($this->table);
        	if ($query->num_rows() > 0)
			{
            	foreach ($query->result() as $row) 
				{
                $data[] = $row;
            	}
            return $data;
        	}
        	return false;
 		}
		
		function get_all_categories()
		{
			//$sql = "Select category as categories from ".$this->table;
			//$result = $this->db->query($sql);
			$this->db->where('quantity >',0);
                        $this->db->where('status = ','active');
			$this->db->select('category');
			$this->db->distinct('category');
			$result = $this->db->get($this->table);
			 if( $result->num_rows > 0 )
			 {
			       return $result->result_array();
			 }
			 else
			 {
			       return false;
			 }
		}
		
		function sort_by_category($sort_by)
		{
			 $this->db->where('quantity >',0);
		     $this->db->where('status = ','active');
			 $this->db->where('category', $sort_by);
			 $result = $this->db->get($this->table);
			 if( $result->num_rows > 0 )
			 {
			       return $result->result_array();
			 }
			 else
			 {
			       return false;
             }
		}
		
		function get_price_lowest()
		{
			
			$this->db->where('quantity >',0);
		    $this->db->where('status = ','active');
			$this->db->select_min('price');
			//$this->db->select_max('price');
			$result = $this->db->get($this->table);
			 if( $result->num_rows > 0 )
			 {
			       return $result->row_array();
			 }
			 else
			 {
			       return false;
             }	 
		}
		
		function get_price_highest()
		{
			
			$this->db->where('quantity >',0);
		    $this->db->where('status = ','active');
			//$this->db->select_min('price');
			$this->db->select_max('price');
			$result = $this->db->get($this->table);
			 if( $result->num_rows > 0 )
			 {
			       return $result->row_array();
			 }
			 else
			 {
			       return false;
             }	 
		}
		
		function get_all_platforms()
		{
			$this->db->where('quantity >',0);
		    $this->db->where('status = ','active');
			$this->db->select('platform');
			$this->db->distinct('platform');
			$result = $this->db->get($this->table);
			 if( $result->num_rows > 0 )
			 {
			       return $result->result_array();
			 }
			 else
			 {
			       return false;
			 }
		}
		
		function sort_by_platform($sort_by)
		{
			 $this->db->where('quantity >',0);
		     $this->db->where('status = ','active');
			 $this->db->where('platform', $sort_by);
			 $result = $this->db->get($this->table);
			 if( $result->num_rows > 0 )
			 {
			       return $result->result_array();
			 }
			 else
			 {
			       return false;
             }
		}
		
	}
?>