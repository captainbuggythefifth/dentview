<?php
if(isset($_GET['search']))
{
	echo $_GET['search'];
	$this->product_search_cap_letter();
}

if( !defined('BASEPATH') ) exit ('No direct script access allowed');

	class product extends CI_Controller
	{

		public function __construct()
		{
			parent::__construct();

			$this->load->model('product_model','productModel');
			$this->load->model('logger_model','loggerModel');
			$this->load->model('customer_model','customerModel');
			$this->load->model('purchase_number_model','purchaseNumberModel');
			$this->load->helper('string');
			$this->load->helper('date');
		}
		
		function product_setter($pos,$result)
		{ 
		
			$page = array();
			$final_page = array();
			$page_contents=1;
			$i=1;
			$page_number = 1;
			foreach($result as $row)
			{
				if($i%6 != 0)
				{
					$temp = array('products' => $row);
					$page[$page_number][$page_contents] = $temp;
					$page_contents++;
				}
				else
				{
					$temp = array('products' => $row);
					$page[$page_number][$page_contents] = $temp;
					$page_contents++;
					$page_number++;
					$page_contents=1;
				}
				$i++;
			}
			
			$j = 1;
			foreach($page as $row)
			{
				if($j == $pos)
				{
					$final_page = $page[$j];
					break;
				}
				$j++;
			}
			//print_r($final_page);
			return $final_page;
		}
		
		function latest_product_counter()
		{
			$page = 1;
			$result = $this->productModel->get_latest();
			$ctr = 1;
			foreach($result as $row)
			{
				if($ctr%6 == 0)
					$page++;
				$ctr++;
			}
			return $page;
		}
		function index()
		{
			/*
			$ip = $this->input->ip_address();
						$date = date("Y-m-d-h-m-s");
						$customer = array('ip_address' => $ip, 'customer_id' => $customer['id'], 'email_address' => $customer['email_add'], 'date_logged' => $date);
						print_r($customer);
						$result = $this->loggerModel->insert($customer);
						
						*/
		/*	if(isset($this->input->ip_address()))
			{
				$ip = $this->input->ip_address();
				$result = $this-loggerModel->get_logged($ip);
				if($result)
				{
					redirect(base_url().'customer-cart-view');
				}
			}
			*/
			
			$platform = $this->platform();
			$title = "LiPayGaGaw Home";
			
			$data['page'] = $this->latest_product_counter();
			$data['link'] = "latest-product-page-";
			$result = $this->productModel->get_latest();
			$result = $this->product_setter(1,$result);
			$data['products'] = $result;
			//print_r($data);
			$best_sellers = $this->get_best_sellers();
			$featured_products = $this->productModel->get_featured();
			$all_categories = $this->productModel->get_all_categories();
			$flags= $this->productModel->get_flags();
			$best_and_featured_and_all_categories = array('flags' => $flags, 'best_sellers' => $best_sellers,'featured_products' => $featured_products, 'all_categories' => $all_categories, 'title' => $title, 'platform' => $platform);
			$this->load->view('finalHeader', $best_and_featured_and_all_categories);
			$this->load->view('products_view',$data);
			$this->load->view('finalFooter'); 
			
      	}
		function latest_product_page($pos)
		{
			$page = 1;
			$result = $this->productModel->get_latest();
			$ctr = 1;
			foreach($result as $row)
			{
				if($ctr%6 == 0)
					$page++;
				$ctr++;
			}
				
			if($pos == 1 || $pos > $page || $pos < 1) 
				redirect(base_url());
			else
			{
				$platform = $this->platform();
				$title = "LiPayGaGaw Home";
			
				$data['link'] = "latest-product-page-";
				$data['page'] = $page;
				$result = $this->product_setter($pos,$result);
				$data['products'] = $result;
				$flags= $this->productModel->get_flags();
				$best_sellers = $this->get_best_sellers();
				$featured_products = $this->productModel->get_featured();
				$all_categories = $this->productModel->get_all_categories();
				$best_and_featured_and_all_categories = array('flags'=>$flags, 'best_sellers' => $best_sellers,'featured_products' => $featured_products, 'all_categories' => $all_categories, 'title' => $title, 'platform' => $platform);
				$this->load->view('finalHeader', $best_and_featured_and_all_categories);
				$this->load->view('products_view',$data);
				$this->load->view('finalFooter'); 
			
			}
		}
      	function product_view($id)
      	{
      		$result = $this->productModel->get_one($id);
      		if($result)
      		{
      		 $data['products']=$result;
      		 $this->load->view('product_view',$data);
      		}
      	}
		
		function product_search_cap_letter($str)
		{
			//$product_name = $this->input->post();
			//if($product_name == "al")
			//echo "alalah!";
			//echo $product_name;
			//session_start();
			//if(isset($_SESSION['search']))
			//$product_name = $_SESSION['search'];
			$result = $this->productModel->search_product_name($str);
			foreach($result as $row)
			{
				echo $row['name'];
			}
		}
		
      	function product_search()
      	{
			$platform = $this->platform();
      		$product_name = $this->input->post();
			//echo $product_name['search'];
      		$result = $this->productModel->search_product_name($product_name['search']);
      		if($result)
      		{
      			$result = array('productInfo' => $result);
      		}
      		else
      			$result = array('productInfo' => false);
	
			$title = "Product Search";
      		$best_sellers = $this->purchaseNumberModel->get_best_sellers();
			$featured_products = $this->productModel->get_featured();
			$all_categories = $this->productModel->get_all_categories();
			$flags= $this->productModel->get_flags();
			$best_and_featured_and_all_categories = array('flags' => $flags, 'best_sellers' => $best_sellers,'featured_products' => $featured_products, 'all_categories' => $all_categories, 'title' => $title ,'platform' => $platform);
			$this->load->view('finalHeader', $best_and_featured_and_all_categories);
      		$this->load->view('product_search_view',$result);
      		$this->load->view('finalFooter');
      	}
		
		
		
		function get_best_sellers()
		{
			$result = $this->purchaseNumberModel->get_best_sellers();
			return $result;
		}
		
		function get_all_categories()
		{
			$result = $this->productModel->get_all_categories();
			return $result;
		}

		function sort_products_by_category($pos)
		{
			$categories = $this->get_all_categories();
			$i = 0;
			$sort_by = "";
			foreach($categories as $row)
			{
				if($i == $pos)
				{
					$sort_by = $row['category'];
					break;
				}
				else
					$i++;
			}
			
			if($sort_by!=null)
			{
				$platform = $this->platform();
				$title = $sort_by." Category";
				$result = $this->productModel->sort_by_category($sort_by);
				$result = $this->product_setter(1,$result);
				$data['products'] = $result;
				//$data['link'] = "sort-products-by-category-".$pos."-page-";
				
				$best_sellers = $this->purchaseNumberModel->get_best_sellers();
				$featured_products = $this->productModel->get_featured();
				$all_categories = $this->productModel->get_all_categories();
				$flags= $this->productModel->get_flags();
				$best_and_featured_and_all_categories = array('flags' => $flags, 'best_sellers' => $best_sellers,'featured_products' => $featured_products, 'all_categories' => $all_categories, 'title' => $title, 
																						'platform' => $platform);
				$this->load->view('finalHeader', $best_and_featured_and_all_categories);
				
				$this->load->view('products_view',$data);
				$this->load->view('finalFooter');
			}
			else
				redirect(base_url());
		}
		
		function price_range()
		{
			$lowest = $this->productModel->get_price_lowest();
			$highest = $this->productModel->get_price_highest();
			$result = array('lowest' => $lowest,'highest' => $highest);
			print_r($result);
			
			$price_range = array();
			
			$divided = $result['highest']['price'] / 10;
			for($i = 0; $i < 10; $i++)
			{
				if($i == 0)
					$last_digit = $divided;
				else
					$last_digit = $last_digit + $divided;
				$price_range[$i] = $last_digit;
			}
			return $price_range;
		}
		
		function sort_products_by_platform($pos)
		{
			$platforms = $this->productModel->get_all_platforms();
			//return $result;
			$i = 0;
			$sort_by = "";
			foreach($platforms as $row)
			{
				if($i == $pos)
				{
					$sort_by = $row['platform'];
					break;
				}
				else
					$i++;
			}
			
			if($sort_by!=null)
			{
				$platform = $this->platform();
				$title = $sort_by." Platform";
				$result = $this->productModel->sort_by_platform($sort_by);
				$result = $this->product_setter(1,$result);
				$data['products'] = $result;
				//$data['link'] = "sort-by-platform-page-";
				$best_sellers = $this->purchaseNumberModel->get_best_sellers();
				$featured_products = $this->productModel->get_featured();
				$all_categories = $this->productModel->get_all_categories();
				$flags= $this->productModel->get_flags();
				$best_and_featured_and_all_categories = array('flags' => $flags, 'best_sellers' => $best_sellers,'featured_products' => $featured_products, 'all_categories' => $all_categories, 'title' => $title, 
																					'platform' => $platform);
				$this->load->view('finalHeader', $best_and_featured_and_all_categories);
				
				$this->load->view('products_view',$data);
				$this->load->view('finalFooter');
			}
			else
				redirect(base_url());
		}
		
		function platform()
		{
			$result = $this->productModel->get_all_platforms();
			return $result;
		}
	}
?>