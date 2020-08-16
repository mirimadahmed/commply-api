<?php
include '../connection.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $risk_id = $_POST['risk_id'];
    if ($_POST['is_owner'] == 'true') {
        $company_id = $_POST['company_id'];
        $get_risk_report = mysqli_query($con, "select r.*,c.company_name from Risk_Report r inner join Company c on c.company_id=r.company_id where risk_id='$risk_id' and r.company_id='$company_id'");
    } else {
        $get_risk_report = mysqli_query($con, "select r.*,c.company_name from Risk_Report r inner join Company c on c.company_id=r.company_id where risk_id='$risk_id'");
    }
    $risk_report_row = mysqli_fetch_array($get_risk_report);
    $custom_date = date("d-M-Y", strtotime($risk_report_row['date_created']));
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
                                    <table class="table table-bordered">
                                        <thead>
                                          <tr class="table_header" style="border 1px solid black">

                                            <td colspan="4" style="background:#87CEEB !important"><center>COVID-19 Walk-through risk assessment</center></td>
                                          </tr>
                                        </thead>
                                        <thead>
                                          <tr style="background:white">
                                            <td width="40%" style="border:1px solid black;">Site:' . $risk_report_row['site'] . ' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Sector: ' . $risk_report_row['sector'] . '</td> 
                                            <td colspan="3" style="border:1px solid black;" >Date: ' . $risk_report_row['date_added'] . '</td>
                                          </tr>
                                        </thead>
                                        <thead>
                                          <tr style="background:white">
                                            <td style="border:1px solid black;">Department: ' . $risk_report_row['department'] . '</td>
                                            <td style="border:1px solid black;">Risk Assessor: ' . $risk_report_row['risk_assessor'] . '</td>
                                            <td style="border:1px solid black;color:#D3D3D3">Name & Surname</td>
                                            <td style="border:1px solid black;color:#D3D3D3">Signature</td>
                                          </tr>
                                        </thead>
                                        <thead>
                                          <tr style="background:white">
                                            <td style="border:1px solid black;">Work Area/s: ' . $risk_report_row['work_area'] . '</td>
                                            <td style="border:1px solid black;">Employer Representative: ' . $risk_report_row['employer_representative'] . '</td>
                                            <td style="border:1px solid black;color:#D3D3D3">Name & Surname</td>
                                            <td style="border:1px solid black;color:#D3D3D3">Signature</td>
                                          </tr>
                                        </thead>
                                        <thead>
                                          <tr style="background:white">
                                            <td style="border:1px solid black;">Occupation in Area: ' . $risk_report_row['occupations'] . '</td>
                                            <td style="border:1px solid black;">Health & Safety Representative: ' . $risk_report_row['health_safety_representative'] . '</td>
                                            <td style="border:1px solid black;color:#D3D3D3">Name & Surname</td>
                                            <td style="border:1px solid black;color:#D3D3D3">Signature</td>
                                          </tr>
                                        </thead>
                                    </table>
                                    <table class="table table-bordered">
                                        <thead>
                                          <tr class="table_header" style="border 1px solid black">
                                            <td colspan="9" style="background:#87CEEB !important"><center>Risk Assessment</center></td>
                                          </tr>
                                        </thead>
                                        <thead>
                                          <tr>
                                            <td style="border:1px solid black;">Source of <br>Hazard</td>
                                            <td style="border:1px solid black;">Route of <br>exposure</td>
                                            <td style="border:1px solid black;">Activities & <br>tasks</td>
                                            <td style="border:1px solid black;">Existing Control <br>Measures</td>
                                            <td style="border:1px solid black;">Control <br>effectiveness</td>
                                            <td style="border:1px solid black;">Risk <br>classification</td>
                                            <td style="border:1px solid black;">Additional <br>Controls<br> Required</td>
                                            <td style="border:1px solid black;">Responsible <br>person(s)</td>
                                            <td style="border:1px solid black;">Due Date/s</td>
                                          </tr>
                                        </thead>
                                        <thead>
                                          <tr>
                                            <td style="border:1px solid black;">' . $risk_report_row['source_of_hazard'] . '</td>
                                            <td style="border:1px solid black;">' . $risk_report_row['route_of_exposure'] . '</td>
                                            <td style="border:1px solid black;">' . $risk_report_row['activities'] . '</td>
                                            <td style="border:1px solid black;">' . $risk_report_row['existing_control_measure'] . '</td>
                                            <td style="border:1px solid black;">' . $risk_report_row['control_effectiveness'] . '</td>
                                            <td style="border:1px solid black;">' . $risk_report_row['risk_classification'] . '</td>
                                            <td style="border:1px solid black;">' . $risk_report_row['addition_controls'] . '</td>
                                            <td style="border:1px solid black;">' . $risk_report_row['responsible_person'] . '</td>
                                            <td style="border:1px solid black;">' . $risk_report_row['due_date'] . '</td>
                                          </tr>
                                          
                                        </thead>
                                        <thead style="display:none">
                                          <tr>
                                            <td style="border:1px solid black;"></td>
                                            <td style="border:1px solid black;"></td>
                                            <td style="border:1px solid black;"></td>
                                            <td style="border:1px solid black;"></td>
                                            <td style="border:1px solid black;"></td>
                                            <td style="border:1px solid black;"></td>
                                            <td style="border:1px solid black;"></td>
                                            <td style="border:1px solid black;"></td>
                                            <td style="border:1px solid black;"></td>
                                          </tr>
                                          
                                        </thead>
                                        <thead>
                                            <tr>
                                            <td colspan="9" style="border:1px solid black;"><center>Department of Employment and Labour Exposure Risk Classification</center></td>
                                          </tr>
                                        </thead>
                                        <thead>
                                          <tr>
                                            <td colspan="3" style="background:yellow;border:1px solid black;">Low Exposure Risk Lower exposure risk (caution) jobs are those that do not require contact with people known to be or suspected of being infected with SARS-CoV-2, nor frequent close contact with (i.e. within 2 meter of) the general public.</td>
                                            
                                            <td colspan="2" style="background:orange;border:1px solid black;">Medium Exposure Risk Medium exposure risk jobs include those that require frequent and/or close contact with (i.e. within 2 meters of) people who may be infected with SARS-CoV-2, but who are not known or suspected COVID-19 patients.</td>
                                            
                                            <td colspan="2" style="background:red;border:1px solid black;">High Exposure Risk High exposure risk jobs are those with high potential for exposure to known or suspected sources of COVID-19.</td>
                                            
                                            <td colspan="2" style="background:#C71585;border:1px solid black;">Very High Exposure Risk Very high exposure risk jobs are those with high potential for exposure to known or suspected sources of COVID-19 during specific medical, postmortem, or laboratory procedures.</td>
                                          </tr>
                                        </thead>
                                        
                            
                                    </table>
                                    *Mining, Agriculture, Fishing, Forestry, Manufacturing, Service<br><br>
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
                        </div>
                    </div>
                </body>
            </html>';
    header("Content-type: application/doc");
    header("Content-Disposition: attachment; filename=Risk Assesment(" . $custom_date . ").doc");
    header("Pragma: no-cache");
    header("Expires: 0");
    echo $string;
    exit;
} else {
    $temp = array();
    $temp['error'] = 1;
    $temp['message'] = "Invalid request type";
    echo json_encode($temp);
}
