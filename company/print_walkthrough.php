<?php
include '../connection.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $building = $_POST['buliding'];
    $date = date("Y-m-d", strtotime($_POST['date']));
    if ($_POST['is_owner'] == 'true') {
        $company_id = $_POST['company_id'];
        $get_data = mysqli_query($con, "select * from Risk_Assessment where building='$building' and date(date_created)='$date' and company_id='$company_id'");
    } else {
        $get_data = mysqli_query($con, "select * from Risk_Assessment where building='$building' and date(date_created)='$date'");
    }
    if (mysqli_num_rows($get_data) > 0) {
        $data = mysqli_fetch_array($get_data);
        $employee_id = $data['employee_id'];
        $get_employee_data = mysqli_query($con, "select * from Employee where employee_id='$employee_id'");
        $employee_data = array();
        if (mysqli_num_rows($get_employee_data) > 0) {
            $employee_data = mysqli_fetch_array($get_employee_data);
            if ($employee_data['employee_firstname'] == '') {
                $employee_data['employee_firstname'] = 'Name';
            }
            if ($employee_data['employee_lastname'] == '') {
                $employee_data['employee_lastname'] = 'Surname';
            }
        } else {
            $employee_data['employee_firstname'] = 'Name';
            $employee_data['employee_lastname'] = 'Surname';
        }

        $q1 = json_decode($data['q1'], true);
        $q2 = json_decode($data['q2'], true);
        $q3 = json_decode($data['q3'], true);
        $q4 = json_decode($data['q4'], true);
        $q5 = json_decode($data['q5'], true);
        $q6 = json_decode($data['q6'], true);
        $q7 = json_decode($data['q7'], true);
        $q8 = json_decode($data['q8'], true);
        $q9 = json_decode($data['q9'], true);
        $q10 = json_decode($data['q10'], true);
        $string = '<html>
                    <head>
                        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
                        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
                        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
                        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
                    
                        <style>
                        #invoice{
                            padding: 30px;
                        }

                        .invoice {
                            position: relative;background-color: #FFF;min-height: 680px;	
                        }

                        
                        .invoice main {
                            padding-bottom: 50px
                        }

                        
                        .invoice table {
                            width: 100%;
                            border-spacing: 0;
                            margin-bottom: 20px
                        }

                        .table_header{
                            padding:15px !important;
                            background: #87ceeb;
                        }
                        
                        .table_header > td{
                            border:1px solid black !important;
                        }
                        
                        .invoice table th {
                            white-space: nowrap;
                            font-weight: 400;
                            font-size: 16px
                        }

                        .invoice table td h3 {
                            margin: 0;
                            font-weight: 400;
                            color: #000;
                            font-size: 28px;
                        }
                        .invoice > table > td > h3 > p{
                        } 
                        .table_data {
                            background: none !important;
                            border: 1px solid grey !important;
                        }
                        
                        .square {
                          height: 40px;
                          width: 40px;
                          background-color: white;
                          border:1px solid black;
                        }
                        img {
                            width: 42px;
                            margin-left: 10px;
                            margin-top: -7px;
                        }
                        
                    </style>

                    </head>
                    <body>
                        <div id="invoice">
                            <div class="invoice overflow-auto">
                                <div style="min-width: 600px">
                                    <main>
                                        <table class="table table-bordered">
                                            <thead>
                                              <tr class="table_header" style="border 1px solid black">
                                                <td colspan="4" style="background:#87CEEB !important"><center>COVID-19 Walk-through risk assessment</center></td>
                                              </tr>
                                            </thead>
                                            <thead>
                                              <tr style="background:white">
                                                <td class="table_data" colspan="2" style="border:1px solid black;">Site Sector</td> 
                                                <td class="table_data" colspan="2" style="border:1px solid black;">Date</td>
                                              </tr>
                                            </thead>
                                            <thead>
                                              <tr style="background:white">
                                                <td style="border:1px solid black;">Department</td>
                                                <td style="border:1px solid black;">Risk Assessor</td>
                                                <td style="border:1px solid black;color:#D3D3D3;border:1px solid black;">' . $employee_data['employee_firstname'] . ' ' . $employee_data['employee_lastname'] . '</td>
                                                <td style="border:1px solid black;color:#D3D3D3;">Signature</td>
                                              </tr>
                                            </thead>
                                            <thead>
                                              <tr style="background:white">
                                                <td style="border:1px solid black;">Work Area/s</td>
                                                <td style="border:1px solid black;">Employer Representative</td>
                                                <td style="border:1px solid black;color:#D3D3D3">' . $employee_data['employee_firstname'] . ' ' . $employee_data['employee_lastname'] . '</td>
                                                <td style="border:1px solid black;color:#D3D3D3">Signature</td>
                                              </tr>
                                            </thead>
                                            <thead>
                                              <tr style="background:white">
                                                <td style="border:1px solid black;">Occupation in Area</td>
                                                <td style="border:1px solid black;">Health & Safety Representative</td>
                                                <td style="border:1px solid black;color:#D3D3D3">' . $employee_data['employee_firstname'] . ' ' . $employee_data['employee_lastname'] . '</td>
                                                <td style="border:1px solid black;color:#D3D3D3">Signature</td>
                                              </tr>
                                            </thead>
                                        </table>
                                        <br />
                                        <br />
                                        <table class="table table-bordered">
                                            <thead>
                                               <tr class="table_header" style="border 1px solid black">
                                                <td colspan="5" style="border:1px solid black;background:#87CEEB !important"><center>COVID-19 Walk-through risk assessment summary of non-compliance</center></td>
                                              </tr>
                                            </thead>
                                            <thead>
                                              <tr>
                                                <th style="border:1px solid black;background:#87CEEB !important">Requirement</th>
                                                <th style="border:1px solid black;background:#87CEEB !important">Finding</th>
                                                <th style="border:1px solid black;background:#87CEEB !important">Recommendation</th>
                                                <th style="border:1px solid black;background:#87CEEB !important">Responsible person</th>
                                                <th style="border:1px solid black;background:#87CEEB !important">Due date</th>
                                              </tr>
                                            </thead>
                                            <thead>
                                              <tr>
                                                <td style="border:1px solid black;color:#D3D3D3">e.g.</td>
                                                <td  style="border:1px solid black;"></td>
                                                <td  style="border:1px solid black;"></td>
                                                <td  style="border:1px solid black;"></td>
                                                <td  style="border:1px solid black;"></td>
                                              </tr>
                                              
                                            </thead>
                                            <thead>
                                              <tr>
                                                <td style="border:1px solid black;color:#D3D3D3">e.g.</td>
                                                <td  style="border:1px solid black;"></td>
                                                <td  style="border:1px solid black;"></td>
                                                <td  style="border:1px solid black;"></td>
                                                <td  style="border:1px solid black;"></td>
                                              </tr>
                                              
                                            </thead>
                                            <thead>
                                              <tr>
                                                <td style="border:1px solid black;color:#D3D3D3">e.g.</td>
                                                <td  style="border:1px solid black;"></td>
                                                <td  style="border:1px solid black;"></td>
                                                <td  style="border:1px solid black;"></td>
                                                <td  style="border:1px solid black;"></td>
                                              </tr>
                                              
                                            </thead>
                                        </table>
                                        
                                        <br />
                                        <br />
                                        <table class="table table-bordered">
                                            <thead>
                                                 <tr class="table_header" style="border 1px solid black">
                                                    <th style="border:1px solid black;background:#87CEEB !important">No</th>
                                                    <th style="border:1px solid black;background:#87CEEB !important">Requirement</th>
                                                    <th style="border:1px solid black;background:#87CEEB !important" colspan="3"><center>Status</center></th>
                                                    <th style="border:1px solid black;background:#87CEEB !important">Comments</th>
                                                </tr>
                                            </thead>
                                            <thead>
                                                <tr>
                                                    <td style="border:1px solid black;"><b>1</b></td>
                                                    <td class="text-left" style="border:1px solid black;">
                                                        <b style="color:black">Basic education & awareness campaigns</b>
                                                    </td>
                                                    <td style="border:1px solid black;">Yes</td>
                                                    <td style="border:1px solid black;">No</td>
                                                    <td style="border:1px solid black;">NA</td>
                                                    <td style="border:1px solid black;"></td>
                                                </tr>
                                            </thead>
                                            <thead>
                                                <tr>
                                                    <td style="border:1px solid black;">1.1</td>
                                                    <td class="text-left" style="border:1px solid black;">
                                                        <span style="color:black">Staff COVID-19 education/communication programme</span>
                                                    </td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q1[0]) && $q1[0]['answer'] == 'YES') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q1[0]) && $q1[0]['answer'] == 'NO') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q1[0]) && $q1[0]['answer'] == '') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q1[0])) {
            $string .= $q1[0]['comment'];
        }
        $string .= '</td>
                                                </tr>
                                            </thead>
                                            <thead>
                                                <tr>
                                                    <td  style="border:1px solid black;">1.2</td>
                                                    <td class="text-left" style="border:1px solid black;">
                                                        <span style="color:black">Contractor staff COVID-19 education/communication programme</span>
                                                    </td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q1[1]) && $q1[1]['answer'] == 'YES') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q1[1]) && $q1[1]['answer'] == 'NO') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q1[1]) && $q1[1]['answer'] == '') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q1[1])) {
            $string .= $q1[1]['comment'];
        }
        $string .= '</td>
                                                </tr>
                                            </thead>
                                            <thead>
                                                <tr>
                                                    <td  style="border:1px solid black;">1.3</td>
                                                    <td class="text-left" style="border:1px solid black;">
                                                        <span style="color:black">PPE donning and doffing training programme</span>
                                                    </td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q1[2]) && $q1[2]['answer'] == 'YES') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q1[2]) && $q1[2]['answer'] == 'NO') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q1[2]) && $q1[2]['answer'] == '') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q1[2])) {
            $string .= $q1[2]['comment'];
        }
        $string .= '</td>
                                                </tr>
                                            </thead>
                                            <thead>
                                                <tr>
                                                    <td  style="border:1px solid black;">1.4</td>
                                                    <td class="text-left" style="border:1px solid black;">
                                                        <span style="color:black">Health status self-monitoring and reporting /or questionnaire for employees</span>
                                                    </td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q1[3]) && $q1[3]['answer'] == 'YES') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q1[3]) && $q1[3]['answer'] == 'NO') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q1[3]) && $q1[3]['answer'] == '') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q1[3])) {
            $string .= $q1[3]['comment'];
        }
        $string .= '</td>
                                                </tr>
                                            </thead>
                                            <thead>
                                                <tr>
                                                    <td  style="border:1px solid black;"><b>2</b></td>
                                                    <td class="text-left" style="border:1px solid black;">
                                                        <b style="color:black">Hygiene / cleaning measures</b>
                                                    </td>
                                                    <td  style="border:1px solid black;"></td>
                                                    <td  style="border:1px solid black;"></td>
                                                    <td  style="border:1px solid black;"></td>
                                                    <td  style="border:1px solid black;"></td>
                                                </tr>
                                            </thead>
                                            <thead>
                                                <tr>
                                                    <td  style="border:1px solid black;">2.1</td>
                                                    <td class="text-left" style="border:1px solid black;">
                                                        <span style="color:black">Work surfaces are decontaminated with appropriate disinfectants at appropriate intervals</span>
                                                    </td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q2[0]) && $q2[0]['answer'] == 'YES') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q2[0]) && $q2[0]['answer'] == 'NO') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q2[0]) && $q2[0]['answer'] == '') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q2[0])) {
            $string .= $q2[0]['comment'];
        }
        $string .= '</td>
                                                </tr>
                                            </thead>
                                            <thead>
                                                <tr>
                                                    <td  style="border:1px solid black;">2.2</td>
                                                    <td class="text-left" style="border:1px solid black;">
                                                        <span style="color:black">Equipment are decontaminated before and after use</span>
                                                    </td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q2[1]) && $q2[1]['answer'] == 'YES') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q2[1]) && $q2[1]['answer'] == 'NO') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q2[1]) && $q2[1]['answer'] == '') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q2[1])) {
            $string .= $q2[1]['comment'];
        }
        $string .= '</td>
                                                </tr>
                                            </thead>
                                            <thead>
                                                <tr>
                                                    <td  style="border:1px solid black;">2.3</td>
                                                    <td class="text-left" style="border:1px solid black;">
                                                        <span style="color:black">Hand washing basin is present (located near room exit)</span>
                                                    </td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q2[2]) && $q2[2]['answer'] == 'YES') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q2[2]) && $q2[2]['answer'] == 'NO') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q2[2]) && $q2[2]['answer'] == '') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q2[2])) {
            $string .= $q2[2]['comment'];
        }
        $string .= '</td>
                                                </tr>
                                            </thead>
                                            <thead>
                                                <tr>
                                                    <td  style="border:1px solid black;">2.4</td>
                                                    <td class="text-left" style="border:1px solid black;">
                                                        <span style="color:black">Soap and paper towel or once off use material towel available at handwashing basin</span>
                                                    </td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q2[3]) && $q2[3]['answer'] == 'YES') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q2[3]) && $q2[3]['answer'] == 'NO') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q2[3]) && $q2[3]['answer'] == '') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q2[3])) {
            $string .= $q2[3]['comment'];
        }
        $string .= '</td>
                                                </tr>
                                            </thead>
                                            <thead>
                                                <tr>
                                                    <td  style="border:1px solid black;">2.5</td>
                                                    <td class="text-left" style="border:1px solid black;">
                                                        <span style="color:black">Hand washing procedure is done, on entering the workplace, after removing PPE, and before leaving the workplace) and at various other times during the course of the day e.g. use of ablutions, etc</span>
                                                    </td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q2[4]) && $q2[4]['answer'] == 'YES') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q2[4]) && $q2[4]['answer'] == 'NO') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q2[4]) && $q2[4]['answer'] == '') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q2[4])) {
            $string .= $q2[4]['comment'];
        }
        $string .= '</td>
                                                </tr>
                                            </thead>
                                            <thead>
                                                <tr>
                                                    <td  style="border:1px solid black;">2.6</td>
                                                    <td class="text-left" style="border:1px solid black;">
                                                        <span style="color:black">There is a procedure for surface decontamination and spills</span>
                                                    </td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q2[5]) && $q2[5]['answer'] == 'YES') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q2[5]) && $q2[5]['answer'] == 'NO') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q2[5]) && $q2[5]['answer'] == '') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q2[5])) {
            $string .= $q2[5]['comment'];
        }
        $string .= '</td>
                                                </tr>
                                            </thead>
                                            <thead>
                                                <tr>
                                                    <td  style="border:1px solid black;">2.7</td>
                                                    <td class="text-left" style="border:1px solid black;">
                                                        <span style="color:black">Spill kits are provided and maintained (only where required)</span>
                                                    </td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q2[6]) && $q2[6]['answer'] == 'YES') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q2[6]) && $q2[6]['answer'] == 'NO') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q2[6]) && $q2[6]['answer'] == '') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q2[6])) {
            $string .= $q2[6]['comment'];
        }
        $string .= '</td>
                                                </tr>
                                            </thead>
                                            <thead>
                                                <tr>
                                                    <td  style="border:1px solid black;">2.8</td>
                                                    <td class="text-left" style="border:1px solid black;">
                                                        <span style="color:black">Additional sanitation facilities (e.g. hand sanitizers, etc.) at door entrances and at or close to workstations</span>
                                                    </td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q2[7]) && $q2[7]['answer'] == 'YES') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q2[7]) && $q2[7]['answer'] == 'NO') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q2[7]) && $q2[7]['answer'] == '') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q2[7])) {
            $string .= $q2[7]['comment'];
        }
        $string .= '</td>
                                                </tr>
                                            </thead>
                                            <thead>
                                                <tr>
                                                    <td  style="border:1px solid black;"><b>3</b></td>
                                                    <td class="text-left" style="border:1px solid black;">
                                                        <b style="color:black">Reduce physical contact (social distancing)</b>
                                                    </td>
                                                    <td  style="border:1px solid black;"></td>
                                                    <td  style="border:1px solid black;"></td>
                                                    <td  style="border:1px solid black;"></td>
                                                    <td  style="border:1px solid black;"></td>
                                                </tr>
                                            </thead>
                                            <thead>
                                                <tr>
                                                    <td  style="border:1px solid black;">3.1</td>
                                                    <td class="text-left" style="border:1px solid black;">
                                                        <span style="color:black">Facility access and visitation is limited or restricted</span>
                                                    </td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q3[0]) && $q3[0]['answer'] == 'YES') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q3[0]) && $q3[0]['answer'] == 'NO') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q3[0]) && $q3[0]['answer'] == '') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q3[0])) {
            $string .= $q3[0]['comment'];
        }
        $string .= '</td>
                                                </tr>
                                            </thead>
                                            <thead>
                                                <tr>
                                                    <td  style="border:1px solid black;">3.2</td>
                                                    <td class="text-left" style="border:1px solid black;">
                                                        <span style="color:black">Limit crowds or gatherings (e.g. large groups >10 or groups in restricted spaces)</span>
                                                    </td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q3[1]) && $q3[1]['answer'] == 'YES') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q3[1]) && $q3[1]['answer'] == 'NO') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q3[1]) && $q3[1]['answer'] == '') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q3[1])) {
            $string .= $q3[1]['comment'];
        }
        $string .= '</td>
                                                </tr>
                                            </thead>
                                            <thead>
                                                <tr>
                                                    <td  style="border:1px solid black;">3.3</td>
                                                    <td class="text-left" style="border:1px solid black;">
                                                        <span style="color:black">Discourage physical contact of employees (e.g. handshakes, hugs)</span>
                                                    </td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q3[2]) && $q3[2]['answer'] == 'YES') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q3[2]) && $q3[2]['answer'] == 'NO') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q3[2]) && $q3[2]['answer'] == '') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q3[2])) {
            $string .= $q3[2]['comment'];
        }
        $string .= '</td>
                                                </tr>
                                            </thead>
                                            <thead>
                                                <tr>
                                                    <td  style="border:1px solid black;">3.4</td>
                                                    <td class="text-left" style="border:1px solid black;">
                                                        <span style="color:black">Closure of communal areas (e.g. gyms)</span>
                                                    </td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q3[3]) && $q3[3]['answer'] == 'YES') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q3[3]) && $q3[3]['answer'] == 'NO') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q3[3]) && $q3[3]['answer'] == '') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q3[3])) {
            $string .= $q3[3]['comment'];
        }
        $string .= '</td>
                                                </tr>
                                            </thead>
                                            <thead>
                                                <tr>
                                                    <td  style="border:1px solid black;">3.5</td>
                                                    <td class="text-left" style="border:1px solid black;">
                                                        <span style="color:black">Scatter diners to sit 1.5 metre distance from each other while dining and sitting face-to-face is not allowed. Separate utensils and frequently disinfect</span>
                                                    </td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q3[4]) && $q3[4]['answer'] == 'YES') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q3[4]) && $q3[4]['answer'] == 'NO') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q3[4]) && $q3[4]['answer'] == '') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q3[4])) {
            $string .= $q3[4]['comment'];
        }
        $string .= '</td>
                                                </tr>
                                            </thead>
                                            <thead>
                                                <tr>
                                                    <td  style="border:1px solid black;">3.6</td>
                                                    <td class="text-left" style="border:1px solid black;">
                                                        <span style="color:black">Eliminate frequent contact of communal surfaces where possible (e.g. leave doors open only where possible)</span>
                                                    </td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q3[5]) && $q3[5]['answer'] == 'YES') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q3[5]) && $q3[5]['answer'] == 'NO') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q3[5]) && $q3[5]['answer'] == '') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q3[5])) {
            $string .= $q3[5]['comment'];
        }
        $string .= '</td>
                                                </tr>
                                            </thead>
                                            <thead>
                                                <tr>
                                                    <td  style="border:1px solid black;">3.7</td>
                                                    <td class="text-left" style="border:1px solid black;">
                                                        <span style="color:black">Stagger tea and lunch breaks to limit employee groupings</span>
                                                    </td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q3[6]) && $q3[6]['answer'] == 'YES') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q3[6]) && $q3[6]['answer'] == 'NO') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q3[6]) && $q3[6]['answer'] == '') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q3[6])) {
            $string .= $q3[6]['comment'];
        }
        $string .= '</td>
                                                </tr>
                                            </thead>
                                            <thead>
                                                <tr>
                                                    <td  style="border:1px solid black;">3.8</td>
                                                    <td class="text-left" style="border:1px solid black;">
                                                        <span style="color:black">Working places rearranged to ensure maximum distance between employees</span>
                                                    </td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q3[7]) && $q3[7]['answer'] == 'YES') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q3[7]) && $q3[7]['answer'] == 'NO') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q3[7]) && $q3[7]['answer'] == '') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q3[7])) {
            $string .= $q3[7]['comment'];
        }
        $string .= '</td>
                                                </tr>
                                            </thead>
                                            <thead>
                                                <tr>
                                                    <td  style="border:1px solid black;">3.9</td>
                                                    <td class="text-left" style="border:1px solid black;">
                                                        <span style="color:black">No clustering at or in elevators. Elevators not to carry more people than is considered safe under the current COVID-19 conditions. Be aware of contact points in elevators</span>
                                                    </td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q3[8]) && $q3[8]['answer'] == 'YES') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q3[8]) && $q3[8]['answer'] == 'NO') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q3[8]) && $q3[8]['answer'] == '') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q3[8])) {
            $string .= $q3[8]['comment'];
        }
        $string .= '</td>
                                                </tr>
                                            </thead>
                                            <thead>
                                                <tr>
                                                    <td  style="border:1px solid black;">3.10</td>
                                                    <td class="text-left" style="border:1px solid black;">
                                                        <span style="color:black">Employees, contractors and visitors entering the facility/workplace are screened for COVID-19 symptoms</span>
                                                    </td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q3[9]) && $q3[9]['answer'] == 'YES') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q3[9]) && $q3[9]['answer'] == 'NO') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q3[9]) && $q3[9]['answer'] == '') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q3[9])) {
            $string .= $q3[9]['comment'];
        }
        $string .= '</td>
                                                </tr>
                                            </thead>
                                            <thead>
                                                <tr>
                                                    <td  style="border:1px solid black;">3.11</td>
                                                    <td class="text-left" style="border:1px solid black;">
                                                        <span style="color:black">Employees, contractors and visitors entering the facility who screen positive for COVID-19 symptoms are immediately provided with `patient` masks</span>
                                                    </td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q3[10]) && $q3[10]['answer'] == 'YES') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q3[10]) && $q3[10]['answer'] == 'NO') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q3[10]) && $q3[10]['answer'] == '') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q3[10])) {
            $string .= $q3[10]['comment'];
        }
        $string .= '</td>
                                                </tr>
                                            </thead>
                                            <thead>
                                                <tr>
                                                    <td  style="border:1px solid black;">3.12</td>
                                                    <td class="text-left" style="border:1px solid black;">
                                                        <span style="color:black">Persons under investigation (PUIs) are chaperoned to the next point at the workplace and preferably, a cordoned-off walkway (or at least marked walkway) is present directing the PUI to the next point at the workplace</span>
                                                    </td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q3[11]) && $q3[11]['answer'] == 'YES') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q3[11]) && $q3[11]['answer'] == 'NO') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q3[11]) && $q3[11]['answer'] == '') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q3[11])) {
            $string .= $q3[11]['comment'];
        }
        $string .= '</td>
                                                </tr>
                                            </thead>
                                            <thead>
                                                <tr>
                                                    <td  style="border:1px solid black;">3.13</td>
                                                    <td class="text-left" style="border:1px solid black;">
                                                        <span style="color:black">An isolation zone is provided for PUIs and the isolation zone allows for 1.5 metre spacing, presence of barriers, etc.</span>
                                                    </td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q3[12]) && $q3[12]['answer'] == 'YES') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q3[12]) && $q3[12]['answer'] == 'NO') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q3[12]) && $q3[12]['answer'] == '') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q3[12])) {
            $string .= $q3[12]['comment'];
        }
        $string .= '</td>
                                                </tr>
                                            </thead>
                                            <thead>
                                                <tr>
                                                    <td  style="border:1px solid black;"><b>4</b></td>
                                                    <td class="text-left" style="border:1px solid black;">
                                                        <b style="color:black">Engineering control measures</b>
                                                    </td>
                                                    <td  style="border:1px solid black;"></td>
                                                    <td  style="border:1px solid black;"></td>
                                                    <td  style="border:1px solid black;"></td>
                                                    <td  style="border:1px solid black;"></td>
                                                </tr>
                                            </thead>
                                            <thead>
                                                <tr>
                                                    <td  style="border:1px solid black;">4.1</td>
                                                    <td class="text-left" style="border:1px solid black;">
                                                        <span style="color:black">Mechanical ventilation is in working order (inward flow, not recirculated to other areas of building, HEPA filtered when reconditioned and recirculated in any workplace, exhausted air discharged through HEPA filters). Environments that require positive pressure may only be allowed where possible and where required without the contamination of other environments</span>
                                                    </td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q4[0]) && $q4[0]['answer'] == 'YES') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q4[0]) && $q4[0]['answer'] == 'NO') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q4[0]) && $q4[0]['answer'] == '') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q4[0])) {
            $string .= $q4[0]['comment'];
        }
        $string .= '</td>
                                                </tr>
                                            </thead>
                                            <thead>
                                                <tr>
                                                    <td  style="border:1px solid black;">4.2</td>
                                                    <td class="text-left" style="border:1px solid black;">
                                                        <span style="color:black">Biosafety Cabinets are used for specified procedures. (Only where required)</span>
                                                    </td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q4[1]) && $q4[1]['answer'] == 'YES') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q4[1]) && $q4[1]['answer'] == 'NO') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q4[1]) && $q4[1]['answer'] == '') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q4[1])) {
            $string .= $q4[1]['comment'];
        }
        $string .= '</td>
                                                </tr>
                                            </thead>
                                            <thead>
                                                <tr>
                                                    <td  style="border:1px solid black;">4.3</td>
                                                    <td class="text-left" style="border:1px solid black;">
                                                        <span style="color:black">Biosafety Cabinets (Class I to III) are present and in good working order (incl. serviced and validated in last 6/12 months. (Only where required)</span>
                                                    </td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q4[2]) && $q4[2]['answer'] == 'YES') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q4[2]) && $q4[2]['answer'] == 'NO') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q4[2]) && $q4[2]['answer'] == '') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q4[2])) {
            $string .= $q4[2]['comment'];
        }
        $string .= '</td>
                                                </tr>
                                            </thead>
                                            <thead>
                                                <tr>
                                                    <td  style="border:1px solid black;">4.4</td>
                                                    <td class="text-left" style="border:1px solid black;">
                                                        <span style="color:black">Sufficient air changes and indoor air quality of an acceptable standard is permissible and acceptable and the responsibility of employer to maintain</span>
                                                    </td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q4[3]) && $q4[3]['answer'] == 'YES') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q4[3]) && $q4[3]['answer'] == 'NO') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q4[3]) && $q4[3]['answer'] == '') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q4[3])) {
            $string .= $q4[3]['comment'];
        }
        $string .= '</td>
                                                </tr>
                                            </thead>
                                            <thead>
                                                <tr>
                                                    <td  style="border:1px solid black;">4.5</td>
                                                    <td class="text-left" style="border:1px solid black;">
                                                        <span style="color:black">Physical barriers / screens as a barrier between personnel and visitors</span>
                                                    </td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q4[4]) && $q4[4]['answer'] == 'YES') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q4[4]) && $q4[4]['answer'] == 'NO') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q4[4]) && $q4[4]['answer'] == '') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q4[4])) {
            $string .= $q4[4]['comment'];
        }
        $string .= '</td>
                                                </tr>
                                            </thead>
                                            <thead>
                                                <tr>
                                                    <td  style="border:1px solid black;">4.6</td>
                                                    <td class="text-left" style="border:1px solid black;">
                                                        <span style="color:black">If air-conditioning must be used, disable re-circulation of internal air. Weekly clean/disinfect/replace key components and filters And when required, disinfect the internal side of ducting using acceptable engineering methods</span>
                                                    </td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q4[5]) && $q4[5]['answer'] == 'YES') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q4[5]) && $q4[5]['answer'] == 'NO') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q4[5]) && $q4[5]['answer'] == '') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q4[5])) {
            $string .= $q4[5]['comment'];
        }
        $string .= '</td>
                                                </tr>
                                            </thead>
                                            <thead>
                                                <tr>
                                                    <td  style="border:1px solid black;"><b>5</b></td>
                                                    <td class="text-left" style="border:1px solid black;">
                                                        <b style="color:black">Administrative controls</b>
                                                    </td>
                                                    <td  style="border:1px solid black;"></td>
                                                    <td  style="border:1px solid black;"></td>
                                                    <td  style="border:1px solid black;"></td>
                                                    <td  style="border:1px solid black;"></td>
                                                </tr>
                                            </thead>
                                            <thead>
                                                <tr>
                                                    <td  style="border:1px solid black;">5.1</td>
                                                    <td class="text-left" style="border:1px solid black;">
                                                        <span style="color:black">Reliable and sustainable source for procurement of key components, including PPE</span>
                                                    </td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q5[0]) && $q5[0]['answer'] == 'YES') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q5[0]) && $q5[0]['answer'] == 'NO') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q5[0]) && $q5[0]['answer'] == '') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q5[0])) {
            $string .= $q5[0]['comment'];
        }
        $string .= '</td>
                                                </tr>
                                            </thead>
                                            <thead>
                                                <tr>
                                                    <td  style="border:1px solid black;">5.2</td>
                                                    <td class="text-left" style="border:1px solid black;">
                                                        <span style="color:black">Adequate supplies of PPE, sanitary materials and cleaning products Procedures are in place for personnel to self-check and/or supervisors and colleagues to verify that all relevant PPE is used by personnel during all shifts (e.g. checklists, briefing sessions etc.)</span>
                                                    </td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q5[1]) && $q5[1]['answer'] == 'YES') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q5[1]) && $q5[1]['answer'] == 'NO') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q5[1]) && $q5[1]['answer'] == '') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q5[1])) {
            $string .= $q5[1]['comment'];
        }
        $string .= '</td>
                                                </tr>
                                            </thead>
                                            <thead>
                                                <tr>
                                                    <td  style="border:1px solid black;">5.3</td>
                                                    <td class="text-left" style="border:1px solid black;">
                                                        <span style="color:black">Emergency communication plans are current and in place</span>
                                                    </td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q5[2]) && $q5[2]['answer'] == 'YES') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q5[2]) && $q5[2]['answer'] == 'NO') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q5[2]) && $q5[2]['answer'] == '') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q5[2])) {
            $string .= $q5[2]['comment'];
        }
        $string .= '</td>
                                                </tr>
                                            </thead>
                                            <thead>
                                                <tr>
                                                    <td  style="border:1px solid black;">5.4</td>
                                                    <td class="text-left" style="border:1px solid black;">
                                                        <span style="color:black">Access to psychological support services</span>
                                                    </td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q5[3]) && $q5[3]['answer'] == 'YES') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q5[3]) && $q5[3]['answer'] == 'NO') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q5[3]) && $q5[3]['answer'] == '') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q5[3])) {
            $string .= $q5[3]['comment'];
        }
        $string .= '</td>
                                                </tr>
                                            </thead>
                                            <thead>
                                                <tr>
                                                    <td  style="border:1px solid black;">5.5</td>
                                                    <td class="text-left" style="border:1px solid black;">
                                                        <span style="color:black">Fatigue management plan and controls are in place</span>
                                                    </td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q5[4]) && $q5[4]['answer'] == 'YES') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q5[4]) && $q5[4]['answer'] == 'NO') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q5[4]) && $q5[4]['answer'] == '') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q5[4])) {
            $string .= $q5[4]['comment'];
        }
        $string .= '</td>
                                                </tr>
                                            </thead>
                                            <thead>
                                                <tr>
                                                    <td  style="border:1px solid black;">5.6</td>
                                                    <td class="text-left" style="border:1px solid black;">
                                                        <span style="color:black">Is the COVID-19 Infection, Prevention and Control Guidelines for South Africa available, and explained to employees</span>
                                                    </td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q5[5]) && $q5[5]['answer'] == 'YES') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q5[5]) && $q5[5]['answer'] == 'NO') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q5[5]) && $q5[5]['answer'] == '') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q5[5])) {
            $string .= $q5[5]['comment'];
        }
        $string .= '</td>
                                                </tr>
                                            </thead>
                                            <thead>
                                                <tr>
                                                    <td  style="border:1px solid black;"><b>6</b></td>
                                                    <td class="text-left" style="border:1px solid black;">
                                                        <b style="color:black">Personal Protective Equipment</b>
                                                    </td>
                                                    <td  style="border:1px solid black;"></td>
                                                    <td  style="border:1px solid black;"></td>
                                                    <td  style="border:1px solid black;"></td>
                                                    <td  style="border:1px solid black;"></td>
                                                </tr>
                                            </thead>
                                            <thead>
                                                <tr>
                                                    <td  style="border:1px solid black;">6.1</td>
                                                    <td class="text-left" style="border:1px solid black;">
                                                        <span style="color:black">PPE is selected based on a documented risk assessment, and should meet the minimum recommendations without using excessive PPE for the setting/task</span>
                                                    </td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q6[0]) && $q6[0]['answer'] == 'YES') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q6[0]) && $q6[0]['answer'] == 'NO') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q6[0]) && $q6[0]['answer'] == '') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q6[0])) {
            $string .= $q6[0]['comment'];
        }
        $string .= '</td>
                                                </tr>
                                            </thead>
                                            <thead>
                                                <tr>
                                                    <td  style="border:1px solid black;">6.2</td>
                                                    <td class="text-left" style="border:1px solid black;">
                                                        <span style="color:black">PPE must be available in the appropriate sizes for every employee or person/contractor visiting the workplace</span>
                                                    </td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q6[1]) && $q6[1]['answer'] == 'YES') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q6[1]) && $q6[1]['answer'] == 'NO') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q6[1]) && $q6[1]['answer'] == '') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q6[1])) {
            $string .= $q6[1]['comment'];
        }
        $string .= '</td>
                                                </tr>
                                            </thead>
                                            <thead>
                                                <tr>
                                                    <td  style="border:1px solid black;">6.3</td>
                                                    <td class="text-left" style="border:1px solid black;">
                                                        <span style="color:black">Disposable gloves</span>
                                                    </td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q6[2]) && $q6[2]['answer'] == 'YES') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q6[2]) && $q6[2]['answer'] == 'NO') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q6[2]) && $q6[2]['answer'] == '') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q6[2])) {
            $string .= $q6[2]['comment'];
        }
        $string .= '</td>
                                                </tr>
                                            </thead>
                                            <thead>
                                                <tr>
                                                    <td  style="border:1px solid black;">6.4</td>
                                                    <td class="text-left" style="border:1px solid black;">
                                                        <span style="color:black">Disposable plastic apron (only where required)</span>
                                                    </td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q6[3]) && $q6[3]['answer'] == 'YES') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q6[3]) && $q6[3]['answer'] == 'NO') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q6[3]) && $q6[3]['answer'] == '') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q6[3])) {
            $string .= $q6[3]['comment'];
        }
        $string .= '</td>
                                                </tr>
                                            </thead>
                                            <thead>
                                                <tr>
                                                    <td  style="border:1px solid black;">6.5</td>
                                                    <td class="text-left" style="border:1px solid black;">
                                                        <span style="color:black">Closed shoes, non-slip soles and shoe covers (only where required)</span>
                                                    </td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q6[4]) && $q6[4]['answer'] == 'YES') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q6[4]) && $q6[4]['answer'] == 'NO') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q6[4]) && $q6[4]['answer'] == '') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q6[4])) {
            $string .= $q6[4]['comment'];
        }
        $string .= '</td>
                                                </tr>
                                            </thead>
                                            <thead>
                                                <tr>
                                                    <td  style="border:1px solid black;">6.6</td>
                                                    <td class="text-left" style="border:1px solid black;">
                                                        <span style="color:black">Eye protection (goggles/face shield or visors)</span>
                                                    </td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q6[5]) && $q6[5]['answer'] == 'YES') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q6[5]) && $q6[5]['answer'] == 'NO') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q6[5]) && $q6[5]['answer'] == '') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q6[5])) {
            $string .= $q6[5]['comment'];
        }
        $string .= '</td>
                                                </tr>
                                            </thead>
                                            <thead>
                                                <tr>
                                                    <td  style="border:1px solid black;">6.7</td>
                                                    <td class="text-left" style="border:1px solid black;">
                                                        <span style="color:black">Respiratory protection (an acceptable material face masks that offers very efficient protection / FFP2/N95 or better respirators - FFP2 and N95 generally left to the health care and similar types of work environments that may require that level of protection - i.e. for high risk situations e.g. aerosol-generating procedures and surgical masks for infectious persons) Extreme care should be taken when choosing a mask or respirator to use insofar as it relates to the working environment</span>
                                                    </td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q6[6]) && $q6[6]['answer'] == 'YES') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q6[6]) && $q6[6]['answer'] == 'NO') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q6[6]) && $q6[6]['answer'] == '') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q6[6])) {
            $string .= $q6[6]['comment'];
        }
        $string .= '</td>
                                                </tr>
                                            </thead>
                                            <thead>
                                                <tr>
                                                    <td  style="border:1px solid black;">6.8</td>
                                                    <td class="text-left" style="border:1px solid black;">
                                                        <span style="color:black">Each employee has been supplied with a minimum of two cloth masks. Only to be used in identified and clearly marked environments</span>
                                                    </td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q6[7]) && $q6[7]['answer'] == 'YES') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q6[7]) && $q6[7]['answer'] == 'NO') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q6[7]) && $q6[7]['answer'] == '') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q6[7])) {
            $string .= $q6[7]['comment'];
        }
        $string .= '</td>
                                                </tr>
                                            </thead>
                                            <thead>
                                                <tr>
                                                    <td  style="border:1px solid black;">6.9</td>
                                                    <td class="text-left" style="border:1px solid black;">
                                                        <span style="color:black">PPE is consistently and properly worn when required</span>
                                                    </td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q6[8]) && $q6[8]['answer'] == 'YES') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q6[8]) && $q6[8]['answer'] == 'NO') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q6[8]) && $q6[8]['answer'] == '') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q6[8])) {
            $string .= $q6[8]['comment'];
        }
        $string .= '</td>
                                                </tr>
                                            </thead>
                                            <thead>
                                                <tr>
                                                    <td  style="border:1px solid black;">6.10</td>
                                                    <td class="text-left" style="border:1px solid black;">
                                                        <span style="color:black">PPE is regular inspected, maintained and replaced, as necessary</span>
                                                    </td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q6[9]) && $q6[9]['answer'] == 'YES') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q6[9]) && $q6[9]['answer'] == 'NO') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q6[9]) && $q6[9]['answer'] == '') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q6[9])) {
            $string .= $q6[9]['comment'];
        }
        $string .= '</td>
                                                </tr>
                                            </thead>
                                            <thead>
                                                <tr>
                                                    <td  style="border:1px solid black;">6.11</td>
                                                    <td class="text-left" style="border:1px solid black;">
                                                        <span style="color:black">PPE is properly disposed of, as applicable, to avoid contamination of self, others, or the environment</span>
                                                    </td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q6[10]) && $q6[10]['answer'] == 'YES') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q6[10]) && $q6[10]['answer'] == 'NO') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q6[10]) && $q6[10]['answer'] == '') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q6[10])) {
            $string .= $q6[10]['comment'];
        }
        $string .= '</td>
                                                </tr>
                                            </thead>
                                            <thead>
                                                <tr>
                                                    <td  style="border:1px solid black;">6.12</td>
                                                    <td class="text-left" style="border:1px solid black;">
                                                        <span style="color:black">PPE is properly removed, cleaned, and stored or disposed of, as applicable, to avoid contamination of self, others, or the environment</span>
                                                    </td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q6[11]) && $q6[11]['answer'] == 'YES') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q6[11]) && $q6[11]['answer'] == 'NO') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q6[11]) && $q6[11]['answer'] == '') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q6[11])) {
            $string .= $q6[11]['comment'];
        }
        $string .= '</td>
                                                </tr>
                                            </thead>
                                            <thead>
                                                <tr>
                                                    <td  style="border:1px solid black;">6.13</td>
                                                    <td class="text-left" style="border:1px solid black;">
                                                        <span style="color:black">Documented respiratory fitment programme that includes fit testing, training, and medical assessments</span>
                                                    </td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q6[12]) && $q6[12]['answer'] == 'YES') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q6[12]) && $q6[12]['answer'] == 'NO') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q6[12]) && $q6[12]['answer'] == '') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q6[12])) {
            $string .= $q6[12]['comment'];
        }
        $string .= '</td>
                                                </tr>
                                            </thead>
                                            <thead>
                                                <tr>
                                                    <td  style="border:1px solid black;">6.14</td>
                                                    <td class="text-left" style="border:1px solid black;">
                                                        <span style="color:black">Facial hair (clean shaving) policy for areas where respirators are mandatory</span>
                                                    </td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q6[13]) && $q6[13]['answer'] == 'YES') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q6[13]) && $q6[13]['answer'] == 'NO') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q6[13]) && $q6[13]['answer'] == '') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q6[13])) {
            $string .= $q6[13]['comment'];
        }
        $string .= '</td>
                                                </tr>
                                            </thead>
                                            <thead>
                                                <tr>
                                                    <td  style="border:1px solid black;">6.15</td>
                                                    <td class="text-left" style="border:1px solid black;">
                                                        <span style="color:black">PPE provided free of charge to employees</span>
                                                    </td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q6[14]) && $q6[14]['answer'] == 'YES') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q6[14]) && $q6[14]['answer'] == 'NO') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q6[14]) && $q6[14]['answer'] == '') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q6[14])) {
            $string .= $q6[14]['comment'];
        }
        $string .= '</td>
                                                </tr>
                                            </thead>
                                            <thead>
                                                <tr>
                                                    <td  style="border:1px solid black;"><b>7</b></td>
                                                    <td class="text-left" style="border:1px solid black;">
                                                        <b style="color:black">Safe work practices</b>
                                                    </td>
                                                    <td  style="border:1px solid black;"></td>
                                                    <td  style="border:1px solid black;"></td>
                                                    <td  style="border:1px solid black;"></td>
                                                    <td  style="border:1px solid black;"></td>
                                                </tr>
                                            </thead>
                                            <thead>
                                                <tr>
                                                    <td  style="border:1px solid black;">7.1</td>
                                                    <td class="text-left" style="border:1px solid black;">
                                                        <span style="color:black">Biosafety laboratory practices (BSL 3) are available and adopted. (only where required)</span>
                                                    </td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q7[0]) && $q7[0]['answer'] == 'YES') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q7[0]) && $q7[0]['answer'] == 'NO') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q7[0]) && $q7[0]['answer'] == '') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q7[0])) {
            $string .= $q7[0]['comment'];
        }
        $string .= '</td>
                                                </tr>
                                            </thead>
                                            <thead>
                                                <tr>
                                                    <td  style="border:1px solid black;">7.2</td>
                                                    <td class="text-left" style="border:1px solid black;">
                                                        <span style="color:black">Eating, drinking, application of cosmetics and smoking in testing facility / workplace (whichever is applicable) is prohibited</span>
                                                    </td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q7[1]) && $q7[1]['answer'] == 'YES') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q7[1]) && $q7[1]['answer'] == 'NO') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q7[1]) && $q7[1]['answer'] == '') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q7[1])) {
            $string .= $q7[1]['comment'];
        }
        $string .= '</td>
                                                </tr>
                                            </thead>
                                            <thead>
                                                <tr>
                                                    <td  style="border:1px solid black;">7.3</td>
                                                    <td class="text-left" style="border:1px solid black;">
                                                        <span style="color:black">No storage of food or drink or personal items (coats, bags) in work area</span>
                                                    </td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q7[2]) && $q7[2]['answer'] == 'YES') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q7[2]) && $q7[2]['answer'] == 'NO') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q7[2]) && $q7[2]['answer'] == '') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q7[2])) {
            $string .= $q7[2]['comment'];
        }
        $string .= '</td>
                                                </tr>
                                            </thead>
                                            <thead>
                                                <tr>
                                                    <td  style="border:1px solid black;">7.4</td>
                                                    <td class="text-left" style="border:1px solid black;">
                                                        <span style="color:black">Materials (pens, pencils, gum, etc.) is not placed in the mouth while in the laboratory or clinical setting</span>
                                                    </td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q7[3]) && $q7[3]['answer'] == 'YES') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q7[3]) && $q7[3]['answer'] == 'NO') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q7[3]) && $q7[3]['answer'] == '') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q7[3])) {
            $string .= $q7[3]['comment'];
        }
        $string .= '</td>
                                                </tr>
                                            </thead>
                                            <thead>
                                                <tr>
                                                    <td  style="border:1px solid black;">7.5</td>
                                                    <td class="text-left" style="border:1px solid black;">
                                                        <span style="color:black">Cuts/broken skin is covered before entering the laboratory</span>
                                                    </td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q7[4]) && $q7[4]['answer'] == 'YES') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q7[4]) && $q7[4]['answer'] == 'NO') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q7[4]) && $q7[4]['answer'] == '') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q7[4])) {
            $string .= $q7[4]['comment'];
        }
        $string .= '</td>
                                                </tr>
                                            </thead>
                                            <thead>
                                                <tr>
                                                    <td  style="border:1px solid black;">7.6</td>
                                                    <td class="text-left" style="border:1px solid black;">
                                                        <span style="color:black">Jewelry is covered (must not affect integrity of gloves) or removed before entering any workplace where it is required</span>
                                                    </td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q7[5]) && $q7[5]['answer'] == 'YES') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q7[5]) && $q7[5]['answer'] == 'NO') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q7[5]) && $q7[5]['answer'] == '') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q7[5])) {
            $string .= $q7[5]['comment'];
        }
        $string .= '</td>
                                                </tr>
                                            </thead>
                                            <thead>
                                                <tr>
                                                    <td  style="border:1px solid black;">7.7</td>
                                                    <td class="text-left" style="border:1px solid black;">
                                                        <span style="color:black">Mobile electronic devices kept in areas where they cannot be contaminated, if not decontaminated frequently</span>
                                                    </td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q7[6]) && $q7[6]['answer'] == 'YES') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q7[6]) && $q7[6]['answer'] == 'NO') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q7[6]) && $q7[6]['answer'] == '') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q7[6])) {
            $string .= $q7[6]['comment'];
        }
        $string .= '</td>
                                                </tr>
                                            </thead>
                                            <thead>
                                                <tr>
                                                    <td  style="border:1px solid black;">7.8</td>
                                                    <td class="text-left" style="border:1px solid black;">
                                                        <span style="color:black">Mobile electronic devices are decontaminated frequently</span>
                                                    </td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q7[7]) && $q7[7]['answer'] == 'YES') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q7[7]) && $q7[7]['answer'] == 'NO') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q7[7]) && $q7[7]['answer'] == '') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q7[7])) {
            $string .= $q7[7]['comment'];
        }
        $string .= '</td>
                                                </tr>
                                            </thead>
                                            <thead>
                                                <tr>
                                                    <td  style="border:1px solid black;">7.9</td>
                                                    <td class="text-left" style="border:1px solid black;">
                                                        <span style="color:black">Laboratory doors are kept closed (and biohazardous signage is displayed) - where required</span>
                                                    </td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q7[8]) && $q7[8]['answer'] == 'YES') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q7[8]) && $q7[8]['answer'] == 'NO') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q7[8]) && $q7[8]['answer'] == '') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q7[8])) {
            $string .= $q7[8]['comment'];
        }
        $string .= '</td>
                                                </tr>
                                            </thead>
                                            <thead>
                                                <tr>
                                                    <td  style="border:1px solid black;">7.10</td>
                                                    <td class="text-left" style="border:1px solid black;">
                                                        <span style="color:black">Workplaces and working areas rearranged to ensure maximum distance between employees</span>
                                                    </td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q7[9]) && $q7[9]['answer'] == 'YES') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q7[9]) && $q7[9]['answer'] == 'NO') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q7[9]) && $q7[9]['answer'] == '') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q7[9])) {
            $string .= $q7[9]['comment'];
        }
        $string .= '</td>
                                                </tr>
                                            </thead>
                                            <thead>
                                                <tr>
                                                    <td  style="border:1px solid black;"><b>8</b></td>
                                                    <td class="text-left" style="border:1px solid black;">
                                                        <b style="color:black">Waste management</b>
                                                    </td>
                                                    <td  style="border:1px solid black;"></td>
                                                    <td  style="border:1px solid black;"></td>
                                                    <td  style="border:1px solid black;"></td>
                                                    <td  style="border:1px solid black;"></td>
                                                </tr>
                                            </thead>
                                            <thead>
                                                <tr>
                                                    <td  style="border:1px solid black;">8.1</td>
                                                    <td class="text-left" style="border:1px solid black;">
                                                        <span style="color:black">Waste management policy and contract with service provider</span>
                                                    </td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q8[0]) && $q8[0]['answer'] == 'YES') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q8[0]) && $q8[0]['answer'] == 'NO') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q8[0]) && $q8[0]['answer'] == '') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q8[0])) {
            $string .= $q8[0]['comment'];
        }
        $string .= '</td>
                                                </tr>
                                            </thead>
                                            <thead>
                                                <tr>
                                                    <td  style="border:1px solid black;">8.2</td>
                                                    <td class="text-left" style="border:1px solid black;">
                                                        <span style="color:black">Waste management contractor complies with occupational health and safety requirements for their employees</span>
                                                    </td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q8[1]) && $q8[1]['answer'] == 'YES') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q8[1]) && $q8[1]['answer'] == 'NO') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q8[1]) && $q8[1]['answer'] == '') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q8[1])) {
            $string .= $q8[1]['comment'];
        }
        $string .= '</td>
                                                </tr>
                                            </thead>
                                            <thead>
                                                <tr>
                                                    <td  style="border:1px solid black;">8.3</td>
                                                    <td class="text-left" style="border:1px solid black;">
                                                        <span style="color:black">Records of waste removal, destruction, and treatment available</span>
                                                    </td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q8[2]) && $q8[2]['answer'] == 'YES') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q8[2]) && $q8[2]['answer'] == 'NO') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q8[2]) && $q8[2]['answer'] == '') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q8[2])) {
            $string .= $q8[2]['comment'];
        }
        $string .= '</td>
                                                </tr>
                                            </thead>
                                            <thead>
                                                <tr>
                                                    <td  style="border:1px solid black;">8.4</td>
                                                    <td class="text-left" style="border:1px solid black;">
                                                        <span style="color:black">COVID-19 related waste that may contain hazardous material brought to the attention of the waste company</span>
                                                    </td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q8[3]) && $q8[3]['answer'] == 'YES') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q8[3]) && $q8[3]['answer'] == 'NO') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q8[3]) && $q8[3]['answer'] == '') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q8[3])) {
            $string .= $q8[3]['comment'];
        }
        $string .= '</td>
                                                </tr>
                                            </thead>
                                            <thead>
                                                <tr>
                                                    <td  style="border:1px solid black;"><b>9</b></td>
                                                    <td class="text-left" style="border:1px solid black;">
                                                        <b style="color:black">Safety equipment (but not limited to)</b>
                                                    </td>
                                                    <td  style="border:1px solid black;"></td>
                                                    <td  style="border:1px solid black;"></td>
                                                    <td  style="border:1px solid black;"></td>
                                                    <td  style="border:1px solid black;"></td>
                                                </tr>
                                            </thead>
                                            <thead>
                                                <tr>
                                                    <td  style="border:1px solid black;">9.1</td>
                                                    <td class="text-left" style="border:1px solid black;">
                                                        <span style="color:black">First aid kits are available</span>
                                                    </td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q9[0]) && $q9[0]['answer'] == 'YES') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q9[0]) && $q9[0]['answer'] == 'NO') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q9[0]) && $q9[0]['answer'] == '') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q9[0])) {
            $string .= $q9[0]['comment'];
        }
        $string .= '</td>
                                                </tr>
                                            </thead>
                                            <thead>
                                                <tr>
                                                    <td  style="border:1px solid black;">9.2</td>
                                                    <td class="text-left" style="border:1px solid black;">
                                                        <span style="color:black">Eye wash bottles or fountains available and in working order</span>
                                                    </td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q9[1]) && $q9[1]['answer'] == 'YES') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q9[1]) && $q9[1]['answer'] == 'NO') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q9[1]) && $q9[1]['answer'] == '') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q9[1])) {
            $string .= $q9[1]['comment'];
        }
        $string .= '</td>
                                                </tr>
                                            </thead>
                                            <thead>
                                                <tr>
                                                    <td  style="border:1px solid black;"><b>10</b></td>
                                                    <td class="text-left" style="border:1px solid black;">
                                                        <b style="color:black">Emergency response</b>
                                                    </td>
                                                    <td  style="border:1px solid black;"></td>
                                                    <td  style="border:1px solid black;"></td>
                                                    <td  style="border:1px solid black;"></td>
                                                    <td  style="border:1px solid black;"></td>
                                                </tr>
                                            </thead>
                                            <thead>
                                                <tr>
                                                    <td  style="border:1px solid black;">10.1</td>
                                                    <td class="text-left" style="border:1px solid black;">
                                                        <span style="color:black">Response plan in case someone becomes ill with symptoms of COVID-19 in the workplace is in place and staff are aware of it</span>
                                                    </td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q10[0]) && $q10[0]['answer'] == 'YES') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q10[0]) && $q10[0]['answer'] == 'NO') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q10[0]) && $q10[0]['answer'] == '') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q10[0])) {
            $string .= $q10[0]['comment'];
        }
        $string .= '</td>
                                                </tr>
                                            </thead>
                                            <thead>
                                                <tr>
                                                    <td  style="border:1px solid black;">10.2</td>
                                                    <td class="text-left" style="border:1px solid black;">
                                                        <span style="color:black">Suspected COVID-19 case isolation areas and protocols in place and staff are aware of it</span>
                                                    </td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q10[1]) && $q10[1]['answer'] == 'YES') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q10[1]) && $q10[1]['answer'] == 'NO') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q10[1]) && $q10[1]['answer'] == '') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q10[1])) {
            $string .= $q10[1]['comment'];
        }
        $string .= '</td>
                                                </tr>
                                            </thead>
                                            <thead>
                                                <tr>
                                                    <td  style="border:1px solid black;">10.3</td>
                                                    <td class="text-left" style="border:1px solid black;">
                                                        <span style="color:black">System to track and trace potential interactions in place (contact tracing)</span>
                                                    </td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q10[2]) && $q10[2]['answer'] == 'YES') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q10[2]) && $q10[2]['answer'] == 'NO') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q10[2]) && $q10[2]['answer'] == '') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q10[2])) {
            $string .= $q10[2]['comment'];
        }
        $string .= '</td>
                                                </tr>
                                            </thead>
                                            <thead>
                                                <tr>
                                                    <td  style="border:1px solid black;">10.4</td>
                                                    <td class="text-left" style="border:1px solid black;">
                                                        <span style="color:black">Self-isolation or quarantine protocols available and current and staff are aware of it</span>
                                                    </td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q10[3]) && $q10[3]['answer'] == 'YES') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q10[3]) && $q10[3]['answer'] == 'NO') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q10[3]) && $q10[3]['answer'] == '') {
            $string .= '<span style="color:green;text-align:center">&#10004;</span>';
        }
        $string .= '</td>
                                                    <td  style="border:1px solid black;">';
        if (!empty($q10[3])) {
            $string .= $q10[3]['comment'];
        }
        $string .= '</td>
                                                </tr>
                                            </thead>
                                        </table>
                                        <p>
                                            (Document prepared by the Risk Assessment Group within the Occupational Health and Safety Workstream of the National Department of Health - Covid-19 Response)
                                        </p>
                                        <br><br>
                                        <table>
                                            <tr>
                                                <td>_____________________________________________________</td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;__________________________________</td>
                                            </tr>
                                            <tr>
                                                <td>Name and Signature of CEO / Designated person</td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Date</td>
                                            </tr>
                                        </table>
                                    </main>
                                </div>
                                <!--DO NOT DELETE THIS div. IT is responsible for showing footer always at the bottom-->
                                <div></div>
                            </div>
                        </div>
                    </body>
                </html>';
        $custom_date = date("d-M-Y", strtotime($_POST['date']));
        header("Content-type: application/doc");
        header("Content-Disposition: attachment; filename=Walkthrough Report(" . $custom_date . ").doc");
        header("Pragma: no-cache");
        header("Expires: 0");
        echo $string;
        exit;
    } else {
        $temp = array();
        $temp['error'] = 1;
        $temp['message'] = "No data found";
        echo json_encode($temp);
    }
} else {
    $temp = array();
    $temp['error'] = 1;
    $temp['message'] = "Invalid request type";
    echo json_encode($temp);
}
