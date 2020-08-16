<?php
include 'connection.php';

function mysqli_field_name($result, $field_offset)
{
	$properties = mysqli_fetch_field_direct($result, $field_offset);
	return is_object($properties) ? $properties->name : null;
}

function turn_result_to_file($result)
{
	$number_of_fields = mysqli_num_fields($result);
	$headers = array();
	for ($i = 0; $i < $number_of_fields; $i++) {
		$headers[] = mysqli_field_name($result, $i);
	}
	$fp = fopen('php://output', 'w');
	if ($fp && $result) {
		header('Content-Type: text/csv');
		header('Content-Disposition: attachment; filename="export.csv"');
		header('Pragma: no-cache');
		header('Expires: 0');
		fputcsv($fp, $headers);
		while ($row = $result->fetch_array(MYSQLI_NUM)) {
			fputcsv($fp, array_values($row));
		}
		die;
	}
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$table_name = $_POST['table_name'];
	$date_from = $_POST['start'];
	$date_to = $_POST['end'];
	$isOwner = $_POST['is_owner'];
	$company_id = $_POST['company_id'];
	$stmt = "";
	if ($table_name == 'declaration') {
		if ($isOwner == 'true') {
			$stmt = mysqli_query($con, "SELECT d.*,e.employee_firstname,e.employee_number,e.employee_telephone,e.employee_id_number,e.employee_lastname,c.company_name,o.owner_firstname FROM `Declaration` d inner join Employee e on d.employee_id=e.employee_id inner join Company c on d.company_id=c.company_id left outer join Owner o on d.owner_id=o.owner_id where date(d.date_created)>='$date_from' and date(d.date_created)<='$date_to' and d.company_id='$company_id'");
		} else {
			$stmt = mysqli_query($con, "SELECT d.*,e.employee_firstname,e.employee_number,e.employee_telephone,e.employee_id_number,e.employee_lastname,c.company_name,o.owner_firstname FROM `Declaration` d inner join Employee e on d.employee_id=e.employee_id inner join Company c on d.company_id=c.company_id left outer join Owner o on d.owner_id=o.owner_id where date(d.date_created)>='$date_from' and date(d.date_created)<='$date_to'");
		}
	} else if ($table_name == 'visitor') {
		if ($isOwner == 'true') {
			$stmt = mysqli_query($con, "SELECT v.*,l.description,c.company_name FROM `visitor` v inner join Company c on v.compId=c.company_id left outer join location l on v.locationId=l.locationId where date(v.dateCreated)>='$date_from' and date(v.dateCreated)<='$date_to' and v.compId='$company_id'");
		} else {
			$stmt = mysqli_query($con, "SELECT v.*,l.description,c.company_name FROM `visitor` v inner join Company c on v.compId=c.company_id left outer join location l on v.locationId=l.locationId where date(v.dateCreated)>='$date_from' and date(v.dateCreated)<='$date_to'");
		}
	} else if ($table_name == 'daily_check') {
		if ($isOwner == 'true') {
			$stmt = mysqli_query($con, "SELECT d.*,e.employee_firstname,e.employee_number,e.employee_telephone,e.employee_id_number,e.employee_lastname,c.company_name,o.owner_firstname FROM `Daily_check` d inner join Employee e on d.employee_id=e.employee_id inner join Company c on d.company_id=c.company_id left outer join Owner o on d.owner_id=o.owner_id where date(d.date_created)>='$date_from' and date(d.date_created)<='$date_to' and d.company_id='$company_id'");
		} else {
			$stmt = mysqli_query($con, "SELECT d.*,e.employee_firstname,e.employee_number,e.employee_telephone,e.employee_id_number,e.employee_lastname,c.company_name,o.owner_firstname FROM `Daily_check` d inner join Employee e on d.employee_id=e.employee_id inner join Company c on d.company_id=c.company_id left outer join Owner o on d.owner_id=o.owner_id where date(d.date_created)>='$date_from' and date(d.date_created)<='$date_to'");
		}
	} else if ($table_name == 'risk_report') {
		if ($isOwner == 'true') {
			$stmt = mysqli_query($con, "SELECT r.*,c.company_name,o.owner_firstname FROM `Risk_Report` r  inner join Company c on r.company_id=c.company_id left outer join Owner o on r.owner_id=o.owner_id where date(r.date_created)>='$date_from' and date(r.date_created)<='$date_to' r.company_id='$company_id'");
		} else {
			$stmt = mysqli_query($con, "SELECT r.*,c.company_name,o.owner_firstname FROM `Risk_Report` r  inner join Company c on r.company_id=c.company_id left outer join Owner o on r.owner_id=o.owner_id where date(r.date_created)>='$date_from' and date(r.date_created)<='$date_to'");
		}
	} else if ($table_name == 'risk_assessment') {
		if ($isOwner == 'true') {
			$stmt = mysqli_query($con, "SELECT ra.*,c.company_name FROM `Risk_Assessment` ra inner join Company c on ra.company_id=c.company_id where date(ra.date_created)>='$date_from' and date(ra.date_created)<='$date_to' and ra.company_id='$company_id'");
		} else {
			$stmt = mysqli_query($con, "SELECT ra.*,c.company_name FROM `Risk_Assessment` ra inner join Company c on ra.company_id=c.company_id where date(ra.date_created)>='$date_from' and date(ra.date_created)<='$date_to'");
		}
	} else if ($table_name == 'employee') {
		if ($isOwner == 'true') {
			$stmt = mysqli_query($con, "SELECT e.*,c.company_name FROM `Employee` e inner join Company c on e.company_id=c.company_id where date(e.date_created)>='$date_from' and date(e.date_created)<='$date_to' and e.company_id='$company_id'");
		} else {
			$stmt = mysqli_query($con, "SELECT e.*,c.company_name FROM `Employee` e inner join Company c on e.company_id=c.company_id where date(e.date_created)>='$date_from' and date(e.date_created)<='$date_to'");
		}
	} else if ($table_name == 'owner') {
		if ($isOwner == 'true') {
			$stmt = mysqli_query($con, "SELECT o.*,c.company_name FROM `Owner` o inner join Company c on o.company_id=c.company_id where date(o.date_created)>='$date_from' and date(o.date_created)<='$date_to' and o.company_id='$company_id'");
		} else {
			$stmt = mysqli_query($con, "SELECT o.*,c.company_name FROM `Owner` o inner join Company c on o.company_id=c.company_id where date(o.date_created)>='$date_from' and date(o.date_created)<='$date_to'");
		}
	} else if ($table_name == 'meetings') {
		if ($isOwner == 'true') {
			$stmt = mysqli_query($con, "SELECT m.*,c.company_name,e.employee_firstname,o.owner_firstname FROM `Meeting` m inner join Company c on m.company_id=c.company_id left outer join Employee e on m.employee_id=e.employee_id left outer join Owner o on m.owner_id=o.owner_id where date(m.date_created)>='$date_from' and date(m.date_created)<='$date_to' and m.company_id='$company_id'");
		} else {
			$stmt = mysqli_query($con, "SELECT m.*,c.company_name,e.employee_firstname,o.owner_firstname FROM `Meeting` m inner join Company c on m.company_id=c.company_id left outer join Employee e on m.employee_id=e.employee_id left outer join Owner o on m.owner_id=o.owner_id where date(m.date_created)>='$date_from' and date(m.date_created)<='$date_to'");
		}
	}
	turn_result_to_file($stmt);
}
