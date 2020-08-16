<?php
include '../../connection.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $employee_number = $_POST['employee_number'];
    if ($_POST['is_owner'] == 'true') {
        $company_id = $_POST['company_id'];
        $get_employee_id = mysqli_query($con, "select * from Employee where employee_id_number='$employee_number' and company_id='$company_id'");
    } else {
        $get_employee_id = mysqli_query($con, "select * from Employee where employee_id_number='$employee_number'");
    }
    if (mysqli_num_rows($get_employee_id) > 0) {
        $employee_data = mysqli_fetch_array($get_employee_id);
        $employee_id = $employee_data['employee_id'];
        $date_created = date("d-M-Y", strtotime($employee_data['date_created']));
        $get_declaration = mysqli_query($con, "select * from Declaration where employee_id='$employee_id'");
        if (mysqli_num_rows($get_declaration) > 0) {
            $result = mysqli_fetch_array($get_declaration);
            $string = '<html>	
                <head>
                    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
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
                            font-size: 28px !important;
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
                    <div class="invoice">
                        <div class="overflow-auto">
                            <div style="min-width: 600px">
                                <main>
                                    <table class="table table-bordered" style="border-collapse: collapse;">
                                            <tr></tr>
                                            <tr class="table_header">
                                                <td colspan="3"  style="border 1px solid black;border-top:none"><center>Employee training and awareness</center></td>
                                            </tr>
                                            <tr  style="border 1px solid black;border-top:none">
                                                <td class="table_data" style="width:66%; border:1px solid black;">
                                                    <h3><p style="color:black !important">1. I have received training on COVID-19 and the virus
                                                    causing it, how the virus is spread, the symptoms of the
                                                    disease and how I can protect myself against infection</p></h3>
                                                </td>
                                                <td class="table_data" style="border:1px solid black;text-align:center">';
            if ($result['q1'] == 'YES') {
                $string .= '<div class=""><span style="color:green;border:1px solid grey;font-size:25px;text-align:center">YES</span></div>';
            }
            $string .= '</td>
                                                <td class="table_data" style="border:1px solid black;text-align:center">';
            if ($result['q1'] == 'NO') {
                $string .= '<div class=""><span style="color:red;border:1px solid grey;font-size:25px;text-align:center">NO</span></div>';
            }
            $string .= '</td>
                                            </tr>
                                            <tr  style="border 1px solid black">
                                                <td class="table_data" style="width:66%; border:1px solid black;">
                                                    <h3><p style="color:black !important">2. I am trained and familiar with the COVID-19 protocols in my workplace</p></h3>
                                                </td>
                                                <td class="table_data" style="border:1px solid black;text-align:center">';
            if ($result['q2'] == 'YES') {
                $string .= '<div class=""><span style="color:green;border:1px solid grey;font-size:25px;text-align:center">YES</span></div>';
            }
            $string .= '</td>
                                                <td class="table_data" style="border:1px solid black;text-align:center">';
            if ($result['q2'] == 'NO') {
                $string .= '<div class=""><span style="color:red;border:1px solid grey;font-size:25px;text-align:center">NO</span></div>';
            }
            $string .= '</td>
                                            </tr>
                                            <tr  style="border 1px solid black">
                                                <td class="table_data" style="width:66%; border:1px solid black;">
                                                    <h3><p style="color:black !important">3. know the protocol of self-isolate at my home or at a quarantine site should I become ill with symptoms of COVID-19.</p></h3>
                                                </td>
                                                <td class="table_data" style="border:1px solid black;text-align:center">';
            if ($result['q3'] == 'YES') {
                $string .= '<div class=""><span style="color:green;border:1px solid grey;font-size:25px;text-align:center">YES</span></div>';
            }
            $string .= '</td>
                                                <td class="table_data" style="border:1px solid black;text-align:center">';
            if ($result['q3'] == 'NO') {
                $string .= '<div class=""><span style="color:red;border:1px solid grey;font-size:25px;text-align:center">NO</span></div>';
            }
            $string .= '</td>
                                            </tr>
                                            <tr  style="border 1px solid black">
                                                <td class="table_data" style="width:66%; border:1px solid black;">
                                                    <h3><p style="color:black !important">4. I know the protocol to report should I become ill with symptoms of COVID-19.</p></h3>
                                                </td>
                                                <td class="table_data" style="border:1px solid black;text-align:center">';
            if ($result['q4'] == 'YES') {
                $string .= '<div class=""><span style="color:green;border:1px solid grey;font-size:25px;text-align:center">YES</span></div>';
            }
            $string .= '</td>
                                                <td class="table_data" style="border:1px solid black;text-align:center">';
            if ($result['q4'] == 'NO') {
                $string .= '<div class=""><span style="color:red;border:1px solid grey;font-size:25px;text-align:center">NO</span></div>';
            }
            $string .= '</td>
                                            </tr>
                                            <tr  style="border 1px solid black">
                                                <td class="table_data" style="width:66%; border:1px solid black;">
                                                    <h3><p style="color:black !important">5. I have been told about the screening and testing procedure for Covid-19</p></h3>
                                                </td>
                                                <td class="table_data" style="border:1px solid black;text-align:center">';
            if ($result['q5'] == 'YES') {
                $string .= '<div class=""><span style="color:green;border:1px solid grey;font-size:25px;text-align:center">YES</span></div>';
            }
            $string .= '</td>
                                                <td class="table_data" style="border:1px solid black;text-align:center">';
            if ($result['q5'] == 'NO') {
                $string .= '<div class=""><span style="color:red;border:1px solid grey;font-size:25px;text-align:center">NO</span></div>';
            }
            $string .= '</td>
                                            </tr>
                                            <tr  style="border 1px solid black">
                                                <td class="table_data" style="width:66%; border:1px solid black;">
                                                    <h3><p style="color:black !important">6. I have been told about contact-tracing for Covid-19 if I am tested positive for Covid-19</p></h3>
                                                </td>
                                                <td class="table_data" style="border:1px solid black;text-align:center">';
            if ($result['q6'] == 'YES') {
                $string .= '<div class=""><span style="color:green;border:1px solid grey;font-size:25px;text-align:center">YES</span></div>';
            }
            $string .= '</td>
                                                <td class="table_data" style="border:1px solid black;text-align:center">';
            if ($result['q6'] == 'NO') {
                $string .= '<div class=""><span style="color:red;border:1px solid grey;font-size:25px;text-align:center">NO</span></div>';
            }
            $string .= '</td>
                                            </tr>
                                            <tr  style="border 1px solid black">
                                                <td class="table_data" style="width:66%; border:1px solid black;">
                                                    <h3><p style="color:black !important">7. I have been trained in the correct use, how many times PPE can be used before it needs to be replaced, storage and safe disposal of used/contaminated PPE.</p></h3>
                                                </td>
                                                <td class="table_data" style="border:1px solid black;text-align:center">';
            if ($result['q7'] == 'YES') {
                $string .= '<div class=""><span style="color:green;border:1px solid grey;font-size:25px;text-align:center">YES</span></div>';
            }
            $string .= '</td>
                                                <td class="table_data" style="border:1px solid black;text-align:center">';
            if ($result['q7'] == 'NO') {
                $string .= '<div class=""><span style="color:red;border:1px solid grey;font-size:25px;text-align:center">NO</span></div>';
            }
            $string .= '</td>
                                            </tr>
                                          <tr class="table_header" style="border 1px solid black">
                                            <td colspan="3"><center>Hygiene and cleaning measures</center></td>
                                          </tr>
                                            <tr  style="border 1px solid black">
                                                <td class="table_data" style="width:66%; border:1px solid black;">
                                                    <h3><p style="color:black !important">8. Hand washing sink with soap & approved (70% alcohol) hand sanitiser is available.</p></h3>
                                                </td>
                                                <td class="table_data" style="border:1px solid black;text-align:center">';
            if ($result['q8'] == 'YES') {
                $string .= '<div class=""><span style="color:green;border:1px solid grey;font-size:25px;text-align:center">YES</span></div>';
            }
            $string .= '</td>
                                                <td class="table_data" style="border:1px solid black;text-align:center">';
            if ($result['q8'] == 'NO') {
                $string .= '<div class=""><span style="color:red;border:1px solid grey;font-size:25px;text-align:center">NO</span></div>';
            }
            $string .= '</td>
                                            </tr>
                                            <tr  style="border 1px solid black">
                                                <td class="table_data" style="width:66%; border:1px solid black;">
                                                    <h3><p style="color:black !important">9. Surfaces and equipment are cleaned and disinfected with approved disinfection/sanitising products on a regular basis (at least every four hours).</p></h3>
                                                </td>
                                                <td class="table_data" style="border:1px solid black;text-align:center">';
            if ($result['q9'] == 'YES') {
                $string .= '<div class=""><span style="color:green;border:1px solid grey;font-size:25px;text-align:center">YES</span></div>';
            }
            $string .= '</td>
                                                <td class="table_data" style="border:1px solid black;text-align:center">';
            if ($result['q9'] == 'NO') {
                $string .= '<div class=""><span style="color:red;border:1px solid grey;font-size:25px;text-align:center">NO</span></div>';
            }
            $string .= '</td>
                                            </tr>
                                            <tr  style="border 1px solid black">
                                                <td class="table_data" style="width:66%; border:1px solid black;">
                                                    <h3><p style="color:black !important">10. I know the required personal hygiene practices such as coughing/sneezing into my elbow if I do not have a clean tissue with me, washing my hands regularly for 20 sec, and not sharing stationary, eating utensils and/or PPE with a colleague.</p></h3>
                                                </td>
                                                <td class="table_data" style="border:1px solid black;text-align:center">';
            if ($result['q10'] == 'YES') {
                $string .= '<div class=""><span style="color:green;border:1px solid grey;font-size:25px;text-align:center">YES</span></div>';
            }
            $string .= '</td>
                                                <td class="table_data" style="border:1px solid black;text-align:center">';
            if ($result['q10'] == 'NO') {
                $string .= '<div class=""><span style="color:red;border:1px solid grey;font-size:25px;text-align:center">NO</span></div>';
            }
            $string .= '</td>
                                            </tr>
                                          <tr class="table_header" style="border 1px solid black">
                                            <td colspan="3"><center>Reduce physical contact (social distancing 1.5 m or 2 x arm-length)</center></td>
                                          </tr>
                                            <tr  style="border 1px solid black">
                                                <td class="table_data" style="width:66%; border:1px solid black;">
                                                    <h3><p style="color:black !important">11. I know the social distancing rule of keeping a distance of at least 1.5 meter or 2 x arm-length between myself and any colleague or person from the public.</p></h3>
                                                </td>
                                                <td class="table_data" style="border:1px solid black;text-align:center">';
            if ($result['q11'] == 'YES') {
                $string .= '<div class=""><span style="color:green;border:1px solid grey;font-size:25px;text-align:center">YES</span></div>';
            }
            $string .= '</td>
                                                <td class="table_data" style="border:1px solid black;text-align:center">';
            if ($result['q11'] == 'NO') {
                $string .= '<div class=""><span style="color:red;border:1px solid grey;font-size:25px;text-align:center">NO</span></div>';
            }
            $string .= '</td>
                                            </tr>
                                            <tr  style="border 1px solid black">
                                                <td class="table_data" style="width:66%; border:1px solid black;">
                                                    <h3><p style="color:black !important">12. I know that I need to avoid physical contact such as handshakes, touching and hugs.</p></h3>
                                                </td>
                                                <td class="table_data" style="border:1px solid black;text-align:center">';
            if ($result['q12'] == 'YES') {
                $string .= '<div class=""><span style="color:green;border:1px solid grey;font-size:25px;text-align:center">YES</span></div>';
            }
            $string .= '</td>
                                                <td class="table_data" style="border:1px solid black;text-align:center">';
            if ($result['q12'] == 'NO') {
                $string .= '<div class=""><span style="color:red;border:1px solid grey;font-size:25px;text-align:center">NO</span></div>';
            }
            $string .= '</td>
                                            </tr>
                                            <tr  style="border 1px solid black">
                                                <td class="table_data" style="width:66%; border:1px solid black;">
                                                    <h3><p style="color:black !important">13. I know that crowds or gatherings (e.g. large groups >10 or groups in spaces where there is not sufficient ventilation) needs to be avoided at my workplace.</p></h3>
                                                </td>
                                                <td class="table_data" style="border:1px solid black;text-align:center">';
            if ($result['q13'] == 'YES') {
                $string .= '<div class=""><span style="color:green;border:1px solid grey;font-size:25px;text-align:center">YES</span></div>';
            }
            $string .= '</td>
                                                <td class="table_data" style="border:1px solid black;text-align:center">';
            if ($result['q13'] == 'NO') {
                $string .= '<div class=""><span style="color:red;border:1px solid grey;font-size:25px;text-align:center">NO</span></div>';
            }
            $string .= '</td>
                                            </tr>
                                            <tr  style="border 1px solid black">
                                                <td class="table_data" style="width:66%; border:1px solid black;">
                                                    <h3><p style="color:black !important">14. When dining at work or during breaks, I need to maintain a 1.5 metre distance from colleagues while dining, and I must not sit face-to-face opposite any other person.</p></h3>
                                                </td>
                                                <td class="table_data" style="border:1px solid black;text-align:center">';
            if ($result['q14'] == 'YES') {
                $string .= '<div class=""><span style="color:green;border:1px solid grey;font-size:25px;text-align:center">YES</span></div>';
            }
            $string .= '</td>
                                                <td class="table_data" style="border:1px solid black;text-align:center">';
            if ($result['q14'] == 'NO') {
                $string .= '<div class=""><span style="color:red;border:1px solid grey;font-size:25px;text-align:center">NO</span></div>';
            }
            $string .= '</td>
                                            </tr>
                                          <tr class="table_header" style="border 1px solid black">
                                            <td colspan="3"><center>Personal Protective Equipment</center></td>
                                          </tr>
                                            <tr  style="border 1px solid black">
                                                <td class="table_data" style="width:66%; border:1px solid black;">
                                                    <h3><p style="color:black !important">15. I have all the PPE specific to my work tasks to protect me, in addition to my PPE required to protect me from COVID-19.</p></h3>
                                                </td>
                                                <td class="table_data" style="border:1px solid black;text-align:center">';
            if ($result['q15'] == 'YES') {
                $string .= '<div class=""><span style="color:green;border:1px solid grey;font-size:25px;text-align:center">YES</span></div>';
            }
            $string .= '</td>
                                                <td class="table_data" style="border:1px solid black;text-align:center">';
            if ($result['q15'] == 'NO') {
                $string .= '<div class=""><span style="color:red;border:1px solid grey;font-size:25px;text-align:center">NO</span></div>';
            }
            $string .= '</td>
                                            </tr>
                                            <tr  style="border 1px solid black">
                                                <td class="table_data" style="width:66%; border:1px solid black;">
                                                    <h3><p style="color:black !important">16. My PPE is in a good condition and I am familiar with the procedure required to use it and how to replace it when it is damaged, worn or lost.</p></h3>
                                                </td>
                                                <td class="table_data" style="border:1px solid black;text-align:center">';
            if ($result['q16'] == 'YES') {
                $string .= '<div class=""><span style="color:green;border:1px solid grey;font-size:25px;text-align:center">YES</span></div>';
            }
            $string .= '</td>
                                                <td class="table_data" style="border:1px solid black;text-align:center">';
            if ($result['q16'] == 'NO') {
                $string .= '<div class=""><span style="color:red;border:1px solid grey;font-size:25px;text-align:center">NO</span></div>';
            }
            $string .= '</td>
                                            </tr>
                                          <tr class="table_header" style="border 1px solid black">
                                            <td colspan="3"><center>Personal wellbeing</center></td>
                                          </tr>
                                            <tr  style="border 1px solid black">
                                                <td class="table_data" style="width:66%; border:1px solid black;">
                                                    <h3><p style="color:black !important">17. I monitor my own health for early COVID-19 symptoms (cough, sore throat, shortness of breath or fever &#8805; 38 &deg;C) or flu symptoms and know what to do and where I need to report to if I experience any of the aforementioned symptoms.</p></h3>
                                                </td>
                                                <td class="table_data" style="border:1px solid black;text-align:center">';
            if ($result['q17'] == 'YES') {
                $string .= '<div class=""><span style="color:green;border:1px solid grey;font-size:25px;text-align:center">YES</span></div>';
            }
            $string .= '</td>
                                                <td class="table_data" style="border:1px solid black;text-align:center">';
            if ($result['q17'] == 'NO') {
                $string .= '<div class=""><span style="color:red;border:1px solid grey;font-size:25px;text-align:center">NO</span></div>';
            }
            $string .= '</td>
                                            </tr>
                                            <tr  style="border 1px solid black">
                                                <td class="table_data" style="width:66%; border:1px solid black;">
                                                    <h3><p style="color:black !important">18. I know the contact number and how to access psychological support services should I need support, within my company or external to my company.</p></h3>
                                                </td>
                                                <td class="table_data" style="border:1px solid black;text-align:center">';
            if ($result['q18'] == 'YES') {
                $string .= '<div class=""><span style="color:green;border:1px solid grey;font-size:25px;text-align:center">YES</span></div>';
            }
            $string .= '</td>
                                                <td class="table_data" style="border:1px solid black;text-align:center">';
            if ($result['q18'] == 'NO') {
                $string .= '<div class=""><span style="color:red;border:1px solid grey;font-size:25px;text-align:center">NO</span></div>';
            }
            $string .= '</td>
                                            </tr>
                                          <tr class="table_header" style="border 1px solid black">
                                            <td colspan="3"><center>Emergency response</center></td>
                                          </tr>
                                            <tr  style="border 1px solid black">
                                                <td class="table_data" style="width:66%; border:1px solid black;">
                                                    <h3><p style="color:black !important">19. I am familiar with the procedure to report in case someone at home or in my workplace has symptoms of COVID-19.</p></h3>
                                                </td>
                                                <td class="table_data" style="border:1px solid black;text-align:center">';
            if ($result['q19'] == 'YES') {
                $string .= '<div class=""><span style="color:green;border:1px solid grey;font-size:25px;text-align:center">YES</span></div>';
            }
            $string .= '</td>
                                                <td class="table_data" style="border:1px solid black;text-align:center">';
            if ($result['q19'] == 'NO') {
                $string .= '<div class=""><span style="color:red;border:1px solid grey;font-size:25px;text-align:center">NO</span></div>';
            }
            $string .= '</td>
                                            </tr>
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
                                    <div class="row">
                                        <div  style="width:60%;">
                                            
                                            <br>
                                            
                                        </div>
                                        <div  style="width:40%;">
                                            
                                            <br>
                                            
                                        </div>
                                    </div>
                                </main>
                                
                            </div>
                            <!--DO NOT DELETE THIS div. IT is responsible for showing footer always at the bottom-->
                        </div>
                    </div>
                </body>
            </html>';
            header("Content-type: application/doc");
            header("Content-Disposition: attachment; filename=Declaration Report(" . $date_created . ").doc");
            header("Pragma: no-cache");
            header("Expires: 0");
            echo $string;
            exit;
        } else {
            $temp = array();
            $temp['error'] = 1;
            $temp['message'] = "No declarations found.";
            echo json_encode($temp);
        }
    } else {
        $temp = array();
        $temp['error'] = 1;
        $temp['message'] = "No employee found";
        echo json_encode($temp);
    }
} else {
    $temp = array();
    $temp['error'] = 1;
    $temp['message'] = "Invalid request type";
    echo json_encode($temp);
}
