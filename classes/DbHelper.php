<?php
class DbHelper{

    private $db_connect;

    public function __construct() {
		$host_name='localhost';
		$user_name='root';
		$password='';
		$db_name='reservation';
		$this->db_connect=  mysqli_connect($host_name,$user_name,$password,$db_name);
		if(!$this->db_connect){
		  die('connection failed'.  mysqli_error($this->db_connect)); 
		}   
    }

    public function admin_login_check( $email, $password ){
        $password=  md5($password);
        $sql="SELECT * FROM admin WHERE email='$email' AND password='$password'";
        if(mysqli_query($this->db_connect, $sql)){
        	$query_result=  mysqli_query($this->db_connect, $sql);
        	$admin_info= mysqli_fetch_assoc($query_result);
	        if($admin_info){   
	            $_SESSION['is_login'] = true;        
	            $_SESSION['admin']=$admin_info;
	            header('Location:dashboard.php');
	        }  else {
	            $message="your email address or password is incorrect";
	            return $message;
	        }   
	    }else {
	        die('Query problem :- '.mysqli_error($this->db_connect));
	    }
	}	

    public function user_login_check( $email, $password ){
        $password=  md5($password);
        $sql="SELECT * FROM user WHERE email='$email' AND password='$password'";
        if(mysqli_query($this->db_connect, $sql)){
        	$query_result=  mysqli_query($this->db_connect, $sql);
        	$user_info= mysqli_fetch_assoc($query_result);
	        if($user_info){   
	            $_SESSION['is_user_login'] = true;        
	            $_SESSION['user']=$user_info;
	            header('Location:bus_schedule.php');
	        }  else {
	            $message="your email address or password is incorrect";
	            return $message;
	        }   
	    }else {
	        die('Query problem :- '.mysqli_error($this->db_connect));
	    }
	}	

	public function getAll( $table_name ) {

		$query_str = " SELECT * FROM ".$table_name;
		$sql_query = mysqli_query( $this->db_connect, $query_str );
		return $sql_query;

	}

	public function isUnique( $table_name, $field_name, $field_value, $id_value = 0 ) {

		$id_value_str = '';
		if( $id_value > 0 ) {
			$id_value_str .=" AND id_".$table_name."!='".$id_value."'";
		}

		$query_str = " SELECT * FROM ".$table_name." WHERE ".$field_name." = '".$field_value."'".$id_value_str;

		$sql_result = mysqli_query( $this->db_connect, $query_str );
		if( mysqli_num_rows($sql_result) <=0 ) {
			return true;
		}
		return false;
	}

	public function getByIdField( $table_name, $id_field, $id_field_value ) {
		$query_str = ' SELECT * FROM '.$table_name.' WHERE '.$id_field.' = '.'"'.$id_field_value.'"';
		$sql_query = mysqli_query( $this->db_connect, $query_str );
		$row = mysqli_fetch_assoc($sql_query);
		return $row;

	}

	public function deleteByIdField( $table_name, $id_field, $id_field_value ) {
		$query_str = " DELETE FROM ".$table_name." WHERE ".$id_field." = ".$id_field_value;
		$sql_query = mysqli_query( $this->db_connect, $query_str );
		if( $sql_query ){
			return true;
		}
		return false;
	}
	public function save( $table_name, $data_array ) {

		$columns = implode(", ",array_keys( $data_array ));
		foreach( $data_array as $index=>$value) {
			$data_array[$index] = "'".$value."'";
		}
		$values = implode(", ", $data_array);
		$query_str = "INSERT INTO ".$table_name." ( ".$columns." ) VALUES ( ".$values." )";
		$sql_query = mysqli_query( $this->db_connect, $query_str );
		if( $sql_query ) {
			return $this->db_connect->insert_id;;
		}
		return false;
	}

	public function updateByIdField( $table_name, $data_array, $id_field, $id_field_value  ) {
		$columns = implode(", ",array_keys( $data_array ));

		$values = implode(", ", $data_array);
		$query_str = "UPDATE ".$table_name." SET ";
		$is_first_one = true;
		foreach( $data_array as $index=>$value) {
			if( $is_first_one ) {
				$is_first_one = false;
				$query_str .= $index." = '".$value."'";
			}else{
				$query_str .= ", ".$index." = '".$value."'";
			}
		}
		$query_str .= " WHERE ".$id_field." = ".$id_field_value;
		$sql_query = mysqli_query( $this->db_connect, $query_str );
		if( $sql_query ) {
			return true;
		}
		return false;		
	}
	public function delete( $table_name, $column_name, $column_value ) {
		$query_str = "DELETE FROM ".$table_name." WHERE ".$column_name." = ".$column_value;
		$sql_query = mysqli_query( $this->db_connect, $query_str );
		if( $sql_query ) {
			return true;
		}
		return false;
	}

	public function selectBox( $table_name, $show_column_name, $value_column_name ) {
		$query_str = "SELECT ".$show_column_name.", ".$value_column_name." FROM ".$table_name;
		$sql_query = mysqli_query( $this->db_connect, $query_str );
		$options = '';
		if( $sql_query ) {
			while( $row = mysqli_fetch_assoc( $sql_query ) ) {
				$options .= '<option value="'.$row[$value_column_name].'">'.$row[$show_column_name].'</option>';
			}
			return $options;
		}
		return '';
	}

	public function rawQuery( $query_str ){
		$sql_query = mysqli_query( $this->db_connect, $query_str );
		return $sql_query;
	}

	public function getSeatBookedByUserInaSchedule( $id_bus_schedule, $id_user ) {
		$query_str = " SELECT SUM(number_of_seat) as total_seat FROM bus_seat_booked WHERE ref_id_bus_schedule = $id_bus_schedule AND ref_id_user = $id_user";

		$results = mysqli_query( $this->db_connect, $query_str);
		if( $results ){
			$row = mysqli_fetch_array($results);
			return $row['total_seat']; 
		}
		return 0;
	}

	public function getSeatBookedByPhoneInaSchedule( $id_bus_schedule, $phone ) {
		$query_str = " SELECT SUM(number_of_seat) as total_seat FROM bus_seat_booked WHERE ref_id_bus_schedule = $id_bus_schedule AND phone = $phone";

		$results = mysqli_query( $this->db_connect, $query_str);
		if( $results ){
			$row = mysqli_fetch_array($results);
			return $row['total_seat']; 
		}
		return 0;
	}	

	public function getAllBusScheduleBYFilter( $starting_datetime, $ending_datetime, $ref_id_road, $bus_type ) {

		//$query_str = 'SELECT bs.*, b.* FROM bus_schedule as bs LEFT JOIN bus as b ON bs.ref_id_bus = b.id_bus WHERE bs.ref_id_road=$ref_id_road AND bs.starting_datetime>=".$starting_datetime." AND bs.starting_datetime<=".$ending_datetime." ';

		$ref_id_road_str = '';
		if( $ref_id_road > 0 ){
			$ref_id_road_str = " AND bs.ref_id_road=".$ref_id_road;
		}
		
		$bus_type_str = '';
		if( $bus_type>0 && $bus_type<=2 ) {
			$bus_type_str = " AND b.bus_type=".$bus_type;
		}

		$query_str = 'SELECT bs.*, b.* FROM bus_schedule as bs LEFT JOIN bus as b ON bs.ref_id_bus = b.id_bus WHERE  bs.starting_datetime>="'.$starting_datetime.'" AND bs.starting_datetime<="'.$ending_datetime.'" '.$ref_id_road_str.' '.$bus_type_str.'  ';

		$results = mysqli_query( $this->db_connect, $query_str );
		if( !$results ){
			return mysqli_error( $this->db_connect );
		}
		return $results;

	}

	public function getBookedSeatByBusSchedule( $id_bus_schedule ) {
	    $seat_num_arr = array();
	    $query_str = "SELECT * FROM bus_seat_booked WHERE ref_id_bus_schedule = $id_bus_schedule";
	    $results = mysqli_query( $this->db_connect, $query_str );
	    if($results){
	        
	        while($seat = mysqli_fetch_array($results)){
	            $seat_numbers = array();
	            $seat_numbers = explode("#",$seat['seat_numbers']);
	            foreach ($seat_numbers as $number) {
	                $seat_num_arr[] = $number;
	            }
	        }
	        $already_booked_seat = '';
	        $is_first_seat = true;
	        foreach( $seat_num_arr as $arr_value){
	            if($is_first_seat){
	                $already_booked_seat .= "'".$arr_value."'";
	                $is_first_seat = false;
	            }else{
	                $already_booked_seat .= ", '".$arr_value."'";
	            }
	            
	        }
	    }	
	    return $already_booked_seat;	
	}

	public function getEmptySeatByBusScheduleId( $id_bus_schedule ) {
		$query_str = " SELECT SUM(number_of_seat) as total_seat FROM bus_seat_booked WHERE ref_id_bus_schedule = $id_bus_schedule";

		$results = mysqli_query( $this->db_connect, $query_str);
		if( $results ){
			$row = mysqli_fetch_array($results);
			return 40-$row['total_seat']; 
		}
		return 40;
	}

	public function getSmsCandidate() {
		$query_str = "SELECT bs.*,bsb.* FROM bus_schedule as bs LEFT JOIN bus_seat_booked as bsb ON bs.id_bus_schedule=bsb.ref_id_bus_schedule  WHERE bs.starting_datetime >= NOW() AND bsb.is_notified_by_sms = 0 Order BY bs.starting_datetime";
		$results = mysqli_query( $this->db_connect, $query_str );
		if( !$results ) {
			return mysqli_error( $this->db_connect );
		}
		return $results;
	}

	public function getUserBookedSeatBYFilter( $ref_id_user, $starting_datetime, $ending_datetime, $ref_id_road, $bus_type ) {

		$ref_id_road_str = '';
		if( $ref_id_road > 0 ){
			$ref_id_road_str = " AND bs.ref_id_road=".$ref_id_road;
		}
		
		$bus_type_str = '';
		if( $bus_type>0 && $bus_type<=2 ) {
			$bus_type_str = " AND b.bus_type=".$bus_type;
		}

		$query_str = 'SELECT bsb.*, bs.*, b.* FROM bus_seat_booked as bsb LEFT JOIN bus_schedule as bs ON bsb.ref_id_bus_schedule = bs.id_bus_schedule LEFT JOIN bus as b ON bs.ref_id_bus = b.id_bus WHERE  bsb.ref_id_user = '.$ref_id_user.' AND bs.starting_datetime>="'.$starting_datetime.'" AND bs.starting_datetime<="'.$ending_datetime.'" '.$ref_id_road_str.' '.$bus_type_str.'  ';

		$results = mysqli_query( $this->db_connect, $query_str );
		if( !$results ){
			return mysqli_error( $this->db_connect );
		}
		return $results;

	}

	public function getCounterBookedSeatBYFilter( $ref_id_counter, $starting_datetime, $ending_datetime, $ref_id_road, $bus_type ) {

		$ref_id_road_str = '';
		if( $ref_id_road > 0 ){
			$ref_id_road_str = " AND bs.ref_id_road=".$ref_id_road;
		}
		
		$bus_type_str = '';
		if( $bus_type>0 && $bus_type<=2 ) {
			$bus_type_str = " AND b.bus_type=".$bus_type;
		}

		$ref_id_counter_str = '';
		if( $ref_id_counter > 0 ) {
			$ref_id_counter_str = " AND bsb.ref_id_counter=".$ref_id_counter;
		}

		$query_str = 'SELECT bsb.*, bs.*, b.* FROM bus_seat_booked as bsb LEFT JOIN bus_schedule as bs ON bsb.ref_id_bus_schedule = bs.id_bus_schedule LEFT JOIN bus as b ON bs.ref_id_bus = b.id_bus WHERE  bs.starting_datetime>="'.$starting_datetime.'" AND bs.starting_datetime<="'.$ending_datetime.'" '.$ref_id_road_str.' '.$bus_type_str.'  '.$ref_id_counter_str;

		$results = mysqli_query( $this->db_connect, $query_str );
		if( !$results ){
			return mysqli_error( $this->db_connect );
		}
		return $results;

	}	

	public function getCounterRoad( $id_counter ){
		$query_str = 'SELECT r.*, rc.* FROM road_counter as rc LEFT JOIN road as r ON 
		r.id_road=rc.ref_id_road WHERE rc.ref_id_counter='.$id_counter;
		$results = mysqli_query( $this->db_connect, $query_str );
		if( !$results ){
			return mysqli_error( $this->db_connect );
		}
		return $results;
	}


	public function getAllUnPaidBooked() {
		$datetime_now = date('Y-m-d H:i:s');
		$datetime = date("Y-m-d H:i:s", strtotime("-10 minutes", strtotime($datetime_now) ));
		$query_str = "SELECT bsb.*, bs.* FROM bus_seat_booked as bsb LEFT JOIN bus_schedule as bs ON bsb.ref_id_bus_schedule=bs.id_bus_schedule WHERE bsb.ref_id_payment=0 AND bsb.created_at<='".$datetime."'";
		$results = mysqli_query( $this->db_connect, $query_str );
		if( !$results ){
			return mysqli_error( $this->db_connect );
		}
		return $results;		

	}

	public function deleteAllUnPaidBooked() {
		$datetime_now = date('Y-m-d H:i:s');
		$datetime = date("Y-m-d H:i:s", strtotime("-10 minutes", strtotime($datetime_now) ));
		$query_str = "DELETE FROM bus_seat_booked  WHERE ref_id_payment=0 AND created_at<='".$datetime."'";
		$is_delete = mysqli_query( $this->db_connect, $query_str );
		if( $is_delete ){
			return true;
		}
		return false;		

	}	

}