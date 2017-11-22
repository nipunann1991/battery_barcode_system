<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/* Author: Jorge Torres
 * Description: Login model class
 */
class CommonQueryModel extends CI_Model{

    function __construct(){

        parent::__construct();
    }


    public function selectAllData($table){

        $select_query = "SELECT * FROM `$table`" ;
        $query = $this->db->query($select_query); 

        if (!$query) {

        	$output = array(
				'status' => 500 , 
				'data' => 'Query Error',
			);

			return $output;

		}else{
  
			$output = array(
				'status' => 200 , 
				'data' => $query->result(),
			);
			return $output;
		}

       
    }


    public function selectAllDataDT($table){

        $select_query = "SELECT * FROM `$table`" ;
        $query = $this->db->query($select_query); 

        if (!$query) {

        	$output = array(
				'status' => 500 , 
				'data' => 'Query Error',
			);

			return $output;

		}else{
  
			$output = $query->result();
			return $output;
		}

       
    }



    function count_filtered($data)
    {
        $select_query = "select ".$data['columns']." FROM ".$data['table']." WHERE ".$data['data']."" ;
        $query = $this->db->query($select_query); 
        return $query->num_rows();
    }

    public function count_all($table)
    {
        $this->db->from($table);
        return $this->db->count_all_results();
    }


    public function selectCustomData($search_data){

        $select_query = "SELECT ".$search_data['columns']." FROM ".$search_data['table']." WHERE ".$search_data['data']."  " ;
        $query = $this->db->query($select_query); 

        if (!$query) {

        	$output = array(
				'status' => 500 , 
				'data' => 'Query Error',
			);

			return $output;

		}else{

			$output = array(
				'status' => 200 , 
				'data' => $query->result(),
			);
			return $output;
		}

       
    }



    public function selectCustomDataDT($search_data){

        $select_query = "SELECT ".$search_data['columns']." FROM ".$search_data['table']." WHERE ".$search_data['data']."  " ;
        $query = $this->db->query($select_query); 



        if (!$query) {

        	$output = array(
				'status' => 500 , 
				'data' => 'Query Error',
			);

			return $output;

		}else{

			$output = $query->result();
			return $output;
		}

       
    }


    

    public function getAutoIncrementID($table){

        $select_query = "SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_NAME = '".$table."';" ;
 
        $query = $this->db->query($select_query); 

        if (!$query) {

        	$output = array(
				'status' => 500 , 
				'data' => 'Query Error',
			);

			return $output;

		}else{

			$output = array(
				'status' => 200 , 
				'data' => $query->result(),
			);
			return $output;
		}

       
    }

    public function selectLastIndex($search_index){

        $select_query = "SELECT `".$search_index['search_index']."` FROM `".$search_index['table']."` ORDER BY `".$search_index['search_index']."` DESC LIMIT 1 " ;
 
        $query = $this->db->query($select_query); 

        if (!$query) {

        	$output = array(
				'status' => 500 , 
				'data' => 'Query Error',
			);

			return $output;

		}else{

			$output = array(
				'status' => 200 , 
				'data' => $query->result(),
			);
			return $output;
		}

       
    }


    public function getTotalRows($search_index){
 
        $select_query = "SELECT COUNT(*) as count FROM `".$search_index['table']."` " ;
 
        $query = $this->db->query($select_query); 

        if (!$query) {

        	$output = array(
				'status' => 500 , 
				'data' => 'Query Error',
			);

			return $output;

		}else{

			$output = array(
				'status' => 200 , 
				'data' => $query->result(),
			);
			return $output;
		}

       
    }



    public function getTotalRowsOnly($search_index){
 
        $select_query = "SELECT COUNT(*) as count FROM `".$search_index['table']."` ".$search_index['condition'] ;
 
        $query = $this->db->query($select_query); 

        if (!$query) {

			return 'error';

		}else{
 			 
			return $query->result()[0]->count;
		}

       
    }




    public function insertData($insert_vals){ 

        $select_query =  "INSERT INTO ".$insert_vals['table']." (".$insert_vals['columns'].") VALUES (".$insert_vals['values'].")" ;
        $query = $this->db->query($select_query); 
        $insert_id = $this->db->insert_id();

        if (!$query) {

			$output = array(
				'status' => 500 , 
				'data' => 'Query Error',
			);

			return $output;

		}else{ 

			$output = array(
				'status' => 200 , 
				'data' => (object) array('status_message' => 'Success', 'inserted_id' => $insert_id )  
			);

			return $output; 
		} 
    }
    
    public function deleteData($delete_val){

    	$select_query =  "DELETE FROM ".$delete_val['table']." WHERE ".$delete_val['data']."" ;
        $query = $this->db->query($select_query); 

        if (!$query) {

			$output = array(
				'status' => 500 , 
				'data' => 'Query Error',
			);

			return $output;

		}else{ 

			$output = array(
				'status' => 200 , 
				'data' => 'Success',
			);

			return $output; 
		}
     
    }

    public function updateData($update_val){
 
    	$select_query =  "UPDATE ".$update_val['table']." SET ".$update_val['values']." WHERE ".$update_val['data']."" ;
        $query = $this->db->query($select_query); 

        if (!$query) {

			$output = array(
				'status' => 500 , 
				'data' => 'Query Error',
			);

			return $output;

		}else{ 

			$output = array(
				'status' => 200 , 
				'data' => 'Success',
			);

			return $output; 
		}
     
    }
 

}

