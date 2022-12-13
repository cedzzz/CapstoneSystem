<?php
session_start();
include('dbcon.php');
require_once('../php-firebase/vendor/setasign/fpdf/fpdf.php');
require_once('../php-firebase/vendor/setasign/fpdi/src/fpdi.php');
use setasign\Fpdi\Fpdi;






if(isset($_POST['updateres'])){
    $uid = $_SESSION['verified_user_id'];
    $edit_id = $_POST['edit_id'];
    $ref_table = 'resident';
    $edituid = $uid.'/'.$edit_id;
   
    
    $uid = $_SESSION['verified_user_id'];
    $firstname = $_POST['first_name'];
    $middlename = $_POST['middle_name'];
    $lastname = $_POST['last_name'];
    $gender = $_POST['gender'];
    $birthdate = $_POST['birthdate'];
    $religion = $_POST['religion'];
    $maritalstatus = $_POST['marital_status'];
    $contactnum = $_POST['contactnum'];
    $nationality = $_POST['nationality'];
    $housenostreet = $_POST['housenostreet'];
    $dob = new DateTime($birthdate);
    $today = new DateTime('today');
    $age = $dob->diff($today)->y;



    $updateData = [
        'firstname'=>$firstname,
        'middlename'=>$middlename,
        'lastname'=>$lastname,
        'gender'=>$gender,
        'age'=>$age,
        'birthdate'=>$birthdate,
        'religion'=>$religion,
        'contactnum'=>$contactnum,
        'nationality'=>$nationality,
        'maritalstatus'=>$maritalstatus,
        'housenostreet'=>$housenostreet,
        'uid' =>$uid,
    ];
    $updatequery = $database->getReference($ref_table)->getChild($edituid)->update($updateData);
    if($updatequery)
        {
            $_SESSION['status'] = "Household Member details has been updated! ";
            header('Location: resident.php?id='.$uid);
            exit();
        }
        else
        {
            $_SESSION['statusred'] = "The attempt to update the household member's details is unsuccessful.";
            header('Location: resident.php?id='.$uid);
            exit();
        }
    }

    if(isset($_POST['updateblot'])){
        $uid = $_SESSION['verified_user_id'];
        $edit_id = $_POST['edit_id'];
        $ref_table = 'blotter';
        $edituid = $uid.'/'.$edit_id;
        $complainant_firstname = $_POST['complainant_firstname'];
        $complainant_middlename = $_POST['complainant_middlename'];
        $complainant_lastname = $_POST['complainant_lastname'];
        $complainantaddress = $_POST['complainant_address'];
        $complainee_firstname = $_POST['complainee_firstname'];
        $complainee_middlename = $_POST['complainee_middlename'];
        $complainee_lastname = $_POST['complainee_lastname'];
        $complaineeaddress = $_POST['complainee_address'];
        $incident = $_POST['incident'];
        $incidentevidence = $_FILES['blotter_evidence']['name'];
        $random_no = rand(1111, 9999);
        $new_media = $random_no.$incidentevidence;
        $filename = 'uploads/blotter/'.$new_media;
        $status = $_POST['status'];

        if($status == 'Pending'){
            $updateData = [
                'complainant_firstname'=>$complainant_firstname,
                'complainant_middlename'=>$complainant_middlename,
                'complainant_lastname'=>$complainant_lastname,
                'complainantaddress'=>$complainantaddress,
                'complainee_firstname'=>$complainee_firstname,
                'complainee_middlename'=>$complainee_middlename,
                'complainee_lastname'=>$complainee_lastname,
                'complaineeaddress'=>$complaineeaddress,
                'incident'=>$incident,
                'status'=>$status,
            ];
        
            $updatequery = $database->getReference($ref_table)->getChild($edituid)->update($updateData);
            if($updatequery)
                {
                    if($incidentevidence!=NULL){
                        move_uploaded_file($_FILES['blotter_evidence']['tmp_name'], "uploads/blotter/".$new_media);
                    }
                    $_SESSION['status'] = "Blotter details has been updated!";
                    header("Location: blotter.php?id=".$uid);
                    exit(0);
                }
                else
                {
                    $_SESSION['statusred'] = "The attempt to update the blotter's details is unsuccessful.";
                    header('Location: blotter.php?id='.$uid);
                    exit();
                }
        }
        elseif($status == 'Approved'){
            $_SESSION['statusred'] = "You cannot edit an approved blotter!";
            header("Location: blotter.php?id=".$uid);
            exit(0);           
        }
        else{
            $_SESSION['statusred'] = "You cannot edit a rejected blotter!";
            header("Location: blotter.php?id=".$uid);
            exit(0);     
        }
    
        
    
    
      
        }

        if(isset($_POST['updateuser'])){
            $profile = $_FILES['profilepic']['name']; 
            $random_no = rand(1111, 9999);
            $user_id =  $_POST['user_id'];
            $uid = $_SESSION['verified_user_id'];
            $user = $auth->getUser($user_id);
            $new_image = $random_no.$profile;
            $old_image = $user ->photoUrl;
            $name = $_POST['name'];
            $phone = $_POST['phonenum'];
            $email = $_POST['email'];
            $accountstatus = $_POST['accountstatus'];
            $roles = $_POST['roles'];
            if($profile!=NULL){
                $filename = 'uploads/profilepictures/'.$new_image;
            }
            else{
                $filename = $old_image;
            }
            
            $properties = [
                'email' => $email,
                'displayName' => $name,
                'phoneNumber' => $phone,
                'photoUrl' => $filename,
            ];
            
            if($accountstatus == 'enable'){
                $auth -> enableUser($user_id);
              }
              elseif($accountstatus == 'disable'){
                $auth -> disableUser($user_id);
              }

              if($roles == 'admin'){
                $auth -> setCustomUserClaims($user_id,['admin' => true]);
              }
              elseif($roles == 'user'){
                $auth -> setCustomUserClaims($user_id, null);
              }

              $updatedUser = $auth ->updateUser($user_id,$properties); 
        
            if($updatedUser){
        
                if($profile!=NULL){
                    move_uploaded_file($_FILES['profilepic']['tmp_name'], "uploads/profilepictures/".$new_image);
                    if($old_image!=NULL){
                        unlink($old_image);
                    }
                }
                $_SESSION['status'] = "User's profile details have been updated!";
                header("Location: users.php?id=".$uid);
                exit(0);
            }
            else{
                $_SESSION['statusred'] = "The attempt to update the user's profile is unsuccessful.";
                header("Location: users.php?id=".$uid);
                exit(0);
            }
        }

        if(isset($_POST['updateuserpic'])){
            $profile = $_FILES['profilepic']['name']; 
            $random_no = rand(1111, 9999);
            $uid = $_SESSION['verified_user_id'];
            $user_id =  $_POST['user_id'];
            $user = $auth->getUser($user_id);
            $new_image = $random_no.$profile;
            $old_image = $user->photoUrl;
        
            if($profile!=NULL){
                $filename = 'uploads/profilepictures/'.$new_image;
            }
            else{
                $filename = $old_image;
            }
        
            $properties = [
                'photoUrl' => $filename,
            ];
        
            $updatedUser = $auth ->updateUser($user_id,$properties); 
        
            if($updatedUser){
        
                if($profile!=NULL){
                    move_uploaded_file($_FILES['profilepic']['tmp_name'], "uploads/profilepictures/".$new_image);
                    if($old_image!=NULL){
                        unlink($old_image);
                    }
                }
                $_SESSION['status'] = "User's profile picture has been updated!";
                header("Location: users.php?id=".$uid);
                exit(0);
            }
            else{
                $_SESSION['statusred'] = "The attempt to update the user's profile picture is unsuccessful.";
                header("Location: users.php?id=".$uid);
                exit(0);
            }
        }
    

        if(isset($_POST['approveadminblot'])){
            $uid = $_SESSION['verified_user_id'];
            $approve_uid = $_POST['approve_uid'];
            $approve_id = $_POST['approve_id'];
            $key = $_POST['key'];
            $ref_table = 'blotter';
            $approveuid = $approve_uid.'/'.$key;
            $complainant_firstname = $_POST['complainant_firstname'];
            $complainant_middlename = $_POST['complainant_middlename'];
            $complainant_lastname = $_POST['complainant_lastname'];
            $complainantaddress = $_POST['complainant_address'];
            $complainee_firstname = $_POST['complainee_firstname'];
            $complainee_middlename = $_POST['complainee_middlename'];
            $complainee_lastname = $_POST['complainee_lastname'];
            $complaineeaddress = $_POST['complainee_address'];
            $blottertype = $_POST['blottertype'];
            $incident = $_POST['incident'];
            $status = $_POST['status'];
        
            
        
        if($status == 'Pending'){
            $status = 'Approved';
            $updateData = [
                'status'=>$status,
            ];
            $updatequery = $database->getReference($ref_table)->getChild($approveuid)->update($updateData);
            if($updatequery)
                {
                    $_SESSION['status'] = "Blotter record's status has been approved!";
                    header("Location: adminblotter.php?id=".$uid);
                    exit(0);
                }
                else
                {
                    $_SESSION['statusred'] = "The attempt to update the blotter's details is unsuccessful.";
                    header('Location: adminblotter.php?id='.$uid);
                    exit();
                }
        }
        elseif($status=='Approved'){
            $_SESSION['statusred'] = "This blotter record's status is already approved!";
            header('Location: adminblotter.php?id='.$uid);
            exit();
        }
        else{
            $_SESSION['statusred'] = "Unable to approve user's blotter record, it has already been rejected!";
            header('Location: adminblotter.php?id='.$uid);
            exit();            
        }
        
            }


           


            if(isset($_POST['approveadmindocu'])){
                $uid = $_SESSION['verified_user_id'];
                $approve_uid = $_POST['approve_uid'];
                $approve_id = $_POST['approve_id'];
                $key = $_POST['key'];
                $ref_table = 'documents';
                $approveuid = $approve_uid.'/'.$key;
                $firstname = $_POST['first_name'];
                $middlename = $_POST['middle_name'];
                $lastname = $_POST['last_name'];
                $gender = $_POST['gender'];
                $age = $_POST['age'];
                $birthdate = $_POST['birthdate'];
                $religion = $_POST['religion'];
                $maritalstatus = $_POST['marital_status'];
                $nationality = $_POST['nationality'];
                $document_type = $_POST['document_type'];
                $permitcertificate_type = $_POST['permitcertificate_type'];
                $status = $_POST['status'];
                $random_no = rand(1111, 9999);
                $housenostreet = $_POST['housenostreet'];
                $barangay = $_POST['barangay'];
                $city = $_POST['city'];
                $address = $housenostreet.', '.$barangay.', '.$city;
                $today = new DateTime('today');
                $todaycompute = new DateTime('today');
                $future = $todaycompute->add(new DateInterval("P12M"));
                $futureexpire = $future->format('Y-m-d');
                $todayresult = $today->format('Y-m-d');
              


                if($document_type =='Barangay Working Permit' && $status == 'Pending'){
                    $fullname = $firstname.' '.$middlename.' '.$lastname;
                    $message = urlencode("This is to certify that this document requested by ".$fullname." is valid and effective on ".$todayresult." and it will remain valid until ".$futureexpire.". This serves as the official barangay seal.");
                    $new_media = $random_no.$firstname.$lastname.$document_type;
                    $sourcefile = 'pdftemplate/SANTOLNOTEXTCLEARANCE.pdf';
                    $pdf = new FPDI();
                    $pdf->AddPage();
                    $pdf->setSourceFile($sourcefile); 
                    $templatepdf = $pdf->importPage(1); 
                    $pdf->useTemplate($templatepdf, null, null, null, null, true);    
                    $pdf->SetFont('Arial', '', '11');
                    $pdf->SetTextColor(0,0,0);  
                    $pdf->SetXY(105, -134);
                    $pdf->Write(0, $fullname);
                    $pdf->SetXY(105, -128);
                    $pdf->Write(0, $address);
                    $pdf->SetXY(105, -116);
                    $pdf->Write(0, $birthdate);
                    $pdf->SetXY(105, -109);
                    $pdf->Write(0, $city);
                    $pdf->SetXY(105, -97);
                    $pdf->Write(0, 'IDENTIFICATION PURPOSES');
                    $pdf->SetXY(105, -68);
                    $pdf->Write(0, 'ONLINE');
                    $pdf->SetXY(105, -62);
                    $pdf->Write(0, $todayresult);
                    $pdf->Image("https://chart.googleapis.com/chart?chs=150x150&cht=qr&chl=$message&choe=UTF-8", 175, 235, null, null, 'PNG');
                    $pdf->Image("pdftemplate/watermark.png", 65, 120, null, null, 'PNG');
                    $pdf->SetFont('Arial', '', '9');
                    $pdf->SetTextColor('255', '0', '0');
                    $pdf->SetXY(85, -44);
                    $pdf->Write(0, $futureexpire);
                    $filename = 'uploads/documents/'.$new_media.'.pdf';            
                    $documents = $pdf->Output('F', $filename);
                    $status = 'Approved';
                
                    $updateData = [
                        'firstname'=>$firstname,
                        'middlename'=>$middlename,
                        'lastname'=>$lastname,
                        'gender'=>$gender,
                        'age'=>$age,
                        'birthdate'=>$birthdate,
                        'religion'=>$religion,
                        'nationality'=>$nationality,
                        'maritalstatus'=>$maritalstatus,
                        'housenostreet'=> $housenostreet,
                        'barangay'=> $barangay,
                        'city'=> $city,
                        'documenttype'=>$document_type,
                        'permitcertificatetype'=> $permitcertificate_type,
                        'documents'=>$filename,
                        'status'=>$status,
                    ];
                    $updatequery = $database->getReference($ref_table)->getChild($approveuid)->update($updateData);
                                  
                    if($updatequery)
                        {
                            $_SESSION['status'] = "The user's document request has been approved!";
                            header("Location: admindocuments.php?id=".$uid);
                            exit();
                        }
                        else
                        {
                            $_SESSION['statusred'] = "The attempt to approve the user's document request was unsuccessful.";
                            header('Location: admindocuments.php?id='.$uid);
                            exit();
                        }
                }

                elseif($status == 'Pending'){
                    $status = 'Approved';
                    $updateData = [
                        'firstname'=>$firstname,
                        'middlename'=>$middlename,
                        'lastname'=>$lastname,
                        'gender'=>$gender,
                        'age'=>$age,
                        'birthdate'=>$birthdate,
                        'religion'=>$religion,
                        'nationality'=>$nationality,
                        'maritalstatus'=>$maritalstatus,
                        'housenostreet'=> $housenostreet,
                        'barangay'=> $barangay,
                        'city'=> $city,
                        'documenttype'=>$document_type,
                        'permitcertificatetype'=> $permitcertificate_type,
                        'status'=>$status,
                    ];
                    $updatequery = $database->getReference($ref_table)->getChild($approveuid)->update($updateData);
                                   
                    if($updatequery)
                        {
                            $_SESSION['status'] = "The user's document request has been approved!";
                            header("Location: admindocuments.php?id=".$uid);
                            exit();
                        }
                        else
                        {
                            $_SESSION['statusred'] = "The attempt to approve the user's document request was unsuccessful.";
                            header('Location: admindocuments.php?id='.$uid);
                            exit();
                        }                    
                }
                elseif($status == 'Approved'){
                    $_SESSION['statusred'] = "The user's document request has already been approved!";
                    header("Location: admindocuments.php?id=".$uid);
                    exit(0);
                }
                else{
                    $_SESSION['statusred'] = "Unable to approve user's document request, it has already been rejected.";
                    header("Location: admindocuments.php?id=".$uid);
                    exit(0);
                }

                }

                if(isset($_POST['updateadminres'])){
                    $uid = $_SESSION['verified_user_id'];
                    $edit_uid = $_POST['edit_uid'];
                    $edit_id = $_POST['edit_id'];
                    $key = $_POST['key'];
                    $ref_table = 'resident';
                    $edituid = $edit_uid.'/'.$key;
                    $firstname = $_POST['first_name'];
                    $middlename = $_POST['middle_name'];
                    $lastname = $_POST['last_name'];
                    $gender = $_POST['gender'];
                    $birthdate = $_POST['birthdate'];
                    $religion = $_POST['religion'];
                    $maritalstatus = $_POST['marital_status'];
                    $contactnum = $_POST['contactnum'];
                    $nationality = $_POST['nationality'];
                    $housenostreet = $_POST['housenostreet'];
                    $dob = new DateTime($birthdate);
                    $today = new DateTime('today');
                    $age = $dob->diff($today)->y;
                
                
                    $updateData = [
                        'firstname'=>$firstname,
                        'middlename'=>$middlename,
                        'lastname'=>$lastname,
                        'gender'=>$gender,
                        'age'=>$age,
                        'birthdate'=>$birthdate,
                        'religion'=>$religion,
                        'contactnum'=>$contactnum,
                        'nationality'=>$nationality,
                        'maritalstatus'=>$maritalstatus,
                        'housenostreet'=>$housenostreet,
                    ];

                    $updatequery = $database->getReference($ref_table)->getChild($edituid)->update($updateData);
                    if($updatequery)
                        {
                            $_SESSION['status'] = "The user's resident details has been updated!";
                            header("Location: adminresidents.php?id=".$uid);
                            exit(0);
                        }
                        else
                        {
                            $_SESSION['statusred'] = "The attempt to update the user's resident details is unsuccessful.";
                            header('Location: adminresidents.php?id='.$uid);
                            exit();
                        }
                    }


                    if(isset($_POST['rejectadminblot'])){
                        $uid = $_SESSION['verified_user_id'];
                        $reject_uid = $_POST['reject_uid'];
                        $reject_id = $_POST['reject_id'];
                        $key = $_POST['key'];
                        $ref_table = 'blotter';
                        $rejectuid = $reject_uid.'/'.$key;
                        $complainant_firstname = $_POST['complainant_firstname'];
                        $complainant_middlename = $_POST['complainant_middlename'];
                        $complainant_lastname = $_POST['complainant_lastname'];
                        $complainantaddress = $_POST['complainantaddress'];
                        $complainee_firstname = $_POST['complainee_firstname'];
                        $complainee_middlename = $_POST['complainee_middlename'];
                        $complainee_lastname = $_POST['complainee_lastname'];
                        $complaineeaddress = $_POST['complaineeaddress'];
                        $blottertype = $_POST['blottertype'];
                        $incident = $_POST['incident'];
                        $status = $_POST['status'];
                    
                        
                    
                    if($status == 'Pending'){
                        $status = 'Rejected';
                        $updateData = [
                            'status'=>$status,
                        ];
                        $updatequery = $database->getReference($ref_table)->getChild($rejectuid)->update($updateData);
                        if($updatequery)
                            {
                                $_SESSION['status'] = "Blotter record's status has been rejected!";
                                header("Location: adminblotter.php?id=".$uid);
                                exit(0);
                            }
                            else
                            {
                                $_SESSION['statusred'] = "The attempt to update the blotter's details is unsuccessful.";
                                header('Location: adminblotter.php?id='.$uid);
                                exit();
                            }
                    }
                    elseif($status=='Rejected'){
                        $_SESSION['statusred'] = "This blotter record's status is already approved!";
                        header('Location: adminblotter.php?id='.$uid);
                        exit();
                    }
                    else{
                        $_SESSION['statusred'] = "Unable to approve user's blotter record, it has already been approved!" ;
                        header('Location: adminblotter.php?id='.$uid);
                        exit();            
                    }
                    
                        }
        


        


                        if(isset($_POST['rejectadmindocu'])){
                            $uid = $_SESSION['verified_user_id'];
                            $reject_id = $_POST['reject_id'];
                            $reject_uid = $_POST['reject_uid'];
                            $key = $_POST['key'];
                            $ref_table = 'documents';
                            $rejectuid = $reject_uid.'/'.$key;
                            $status = $_POST['status'];
                        
                            
                        
                        if($status == 'Pending'){
                            $status = 'Rejected';
                            $updateData = [
                                'status'=>$status,
                            ];
                            $updatequery = $database->getReference($ref_table)->getChild($rejectuid)->update($updateData);
                            if($updatequery)
                                {
                                    $_SESSION['status'] = "Document record's status has been rejected!";
                                    header("Location: admindocuments.php?id=".$uid);
                                    exit(0);
                                }
                                else
                                {
                                    $_SESSION['statusred'] = "The attempt to update the document's status is unsuccessful.";
                                    header('Location: admindocuments.php?id='.$uid);
                                    exit();
                                }
                        }
                        elseif($status =='Rejected'){
                            $_SESSION['statusred'] = "This blotter record's status is already rejected!";
                            header('Location: admindocuments.php?id='.$uid);
                            exit();
                        }
                        else{
                            $_SESSION['statusred'] = "Unable to reject user's blotter record, it has already been approved!" ;
                            header('Location: admindocuments.php?id='.$uid);
                            exit();            
                        }
                        
                            }
    
                        if(isset($_POST['updateadminres'])){
                            $uid = $_SESSION['verified_user_id'];
                            $edit_uid = $_POST['edit_uid'];
                            $edit_id = $_POST['edit_id'];
                            $key = $_POST['key'];
                            $ref_table = 'resident';
                            $edituid = $edit_uid.'/'.$key;
                            $firstname = $_POST['first_name'];
                            $middlename = $_POST['middle_name'];
                            $lastname = $_POST['last_name'];
                            $gender = $_POST['gender'];
                            $birthdate = $_POST['birthdate'];
                            $religion = $_POST['religion'];
                            $maritalstatus = $_POST['marital_status'];
                            $contactnum = $_POST['contactnum'];
                            $nationality = $_POST['nationality'];
                            $housenostreet = $_POST['housenostreet'];
                            $dob = new DateTime($birthdate);
                            $today = new DateTime('today');
                            $age = $dob->diff($today)->y;
                        
                        
                            $updateData = [
                                'firstname'=>$firstname,
                                'middlename'=>$middlename,
                                'lastname'=>$lastname,
                                'gender'=>$gender,
                                'age'=>$age,
                                'birthdate'=>$birthdate,
                                'religion'=>$religion,
                                'contactnum'=>$contactnum,
                                'nationality'=>$nationality,
                                'maritalstatus'=>$maritalstatus,
                                'housenostreet'=>$housenostreet,
                            ];
        
                            $updatequery = $database->getReference($ref_table)->getChild($edituid)->update($updateData);
                            if($updatequery)
                                {
                                    $_SESSION['status'] = "The user's resident details has been updated!";
                                    header("Location: adminresidents.php?id=".$uid);
                                    exit(0);
                                }
                                else
                                {
                                    $_SESSION['statusred'] = "The attempt to update the user's resident details is unsuccessful.";
                                    header('Location: adminresidents.php?id='.$uid);
                                    exit();
                                }
                            }

    
                            if(isset($_POST['generateadminblot'])){
                                $uid = $_SESSION['verified_user_id'];
                                $generate_uid = $_POST['generate_uid'];
                                $generate_id = $_POST['generate_id'];
                                $key = $_POST['key'];
                                $ref_table = 'blotter';
                                $generateuid = $generate_uid.'/'.$key;
                                $complainant_firstname = $_POST['complainant_firstname'];
                                $complainant_middlename = $_POST['complainant_middlename'];
                                $complainant_lastname = $_POST['complainant_lastname'];
                                $complainantaddress = $_POST['complainantaddress'];
                                $complainee_firstname = $_POST['complainee_firstname'];
                                $complainee_middlename = $_POST['complainee_middlename'];
                                $complainee_lastname = $_POST['complainee_lastname'];
                                $complaineeaddress = $_POST['complaineeaddress'];
                                $blottertype = $_POST['blottertype'];
                                $incident = $_POST['incident'];
                                $incidentdate = $_POST['incidentdate'];
                                $incidentevidence= $_POST['incidentevidence'];
                                $status = $_POST['status'];
                                $complainant_fullname = $complainant_firstname.' '.$complainant_middlename.' '.$complainant_lastname;
                                $complainee_fullname = $complainee_firstname.' '.$complainee_middlename.' '.$complainee_lastname;
                                $pdf = new FPDF();
                                $pdf->AddPage('P');
                                $pdf->SetFont('Arial','B','18');
                                $pdf->SetDisplayMode('real', 'default');
                                $pdf->Image('pdftemplate/brgysantollogo.png', 10, 20, 33, 33, 'PNG');
                                $pdf->SetXY(50,20);
                                $pdf->Cell(100,10,'Republic of the Philippines',0,0,'C',0);
                                $pdf->SetFontSize(15);
                                $pdf->Cell(-100,25,'BARANGAY SANTOL QUEZON CITY',0,0,'C',0);
                                $pdf->SetFont('Arial','','12');
                                $pdf->Cell(100,40,'SANTOL BARANGAY HALL',0,0,'C',0);
                                $pdf->SetFont('Arial','B','10');
                                $pdf->Cell(-100,55,'60 Silencio, Lungsod Quezon, Kalakhang Maynila',0,0,'C',0);
                                $pdf->Cell(100,70,'BLOTTER REPORT',0,0,'C',0);
                                $pdf->SetXY(25,50);
                                $pdf->SetFontSize(10);
                                $pdf->Write(30, 'TO WHOM IT MAY CONCERN: ');
                                $pdf->SetFont('Arial','','10');
                                $pdf->SetXY(40,75);
                                $pdf->MultiCell(100,5,"THIS IS TO CERTIFY that based on the E-Blotter Site of Barangay Santol, record of the event/s mentioned here under is taken from the complainant's blotter request in the barangay's online database: ",0,'L',false);
                                $pdf->Line(25, 100, 170, 100);
                                $pdf->SetXY(40,105);
                                $pdf->MultiCell(100,5,"COMPLAINANT'S NAME: ".$complainant_fullname,0,'L',false);
                                $pdf->SetXY(40,110);
                                $pdf->MultiCell(100,5,"COMPLAINANT'S ADDRESS: ".$complainantaddress,0,'L',false);
                                $pdf->SetXY(40,115);
                                $pdf->MultiCell(100,5,"COMPLAINEE'S NAME: ".$complainee_fullname,0,'L',false);
                                $pdf->SetXY(40,120);
                                $pdf->MultiCell(100,5,"COMPLAINEE'S ADDRESS: ".$complaineeaddress,0,'L',false);
                                $pdf->SetXY(40,125);
                                $pdf->MultiCell(100,5,"NATURE/TYPE OF INCIDENT: ".$blottertype,0,'L',false);
                                $pdf->SetXY(40,130);
                                $pdf->MultiCell(100,5,"DATE OF OCCURRENCE: ".$incidentdate,0,'L',false);
                                $pdf->SetXY(40,135);
                                $pdf->MultiCell(100,5,"BLOTTER STATUS: ".$status,0,'L',false);
                                $pdf->Line(25, 145, 170, 145);
                                $pdf->SetFont('Arial','B','10');
                                $pdf->SetXY(25,140);
                                $pdf->Write(30,'THE INCIDENT AS WRITTEN BY THE COMPLAINANT:');
                                $pdf->SetFont('Arial','','10');
                                $pdf->SetXY(35,160);
                                $pdf->MultiCell(100,5,$incident,0,'L',false);
                                $pdf->Image("pdftemplate/watermark.png", 40, 65, null, null, 'PNG');
                                $pdf->Image($incidentevidence, 35, 200, 120, 70);
                                $filename = $complainant_firstname.'_'.$complainant_lastname.'_'.$blottertype.'_blotter_report.pdf';
                                $pdf->Output('I', $filename);
                                }





    if(isset($_POST['deleteallres'])){
        $uid = $_SESSION['verified_user_id'];
        $del_id = $_POST['del_id'];
        $ref_table = 'resident';
        $deletequery = $database->getReference($ref_table)->getChild($uid)->remove();
        
        if($deletequery)
            {
                $_SESSION['status'] = "All household members have been removed from your list!";
                header('Location: resident.php?id='.$uid);
                exit();
            }
            else
            {
                $_SESSION['statusred'] = "The attempt to remove all household members from your list is unsuccessful.";
                header('Location: resident.php?id='.$uid);
                exit();
            }
        }

        if(isset($_POST['deleteallblot'])){
            $uid = $_SESSION['verified_user_id'];
            $del_id = $_POST['del_id'];
            $ref_table = 'blotter';
            $deletequery = $database->getReference($ref_table)->getChild($uid)->remove();
            
            if($deletequery)
                {
                    $_SESSION['status'] = "All blotters have been removed from your list!";
                    header('Location: blotter.php?id='.$uid);
                    exit();
                }
                else
                {
                    $_SESSION['statusred'] = "The attempt to remove all blotter from your list is unsuccessful.";
                    header('Location: blotter.php?id='.$uid);
                    exit();
                }
            }
            if(isset($_POST['deletealldoc'])){
                $uid = $_SESSION['verified_user_id'];
                $del_id = $_POST['del_id'];
                $ref_table = 'documents';
                $deletequery = $database->getReference($ref_table)->getChild($uid)->remove();
                
                if($deletequery)
                    {
                        $_SESSION['status'] = "All documents have been removed from your list!";
                        header('Location: documents.php?id='.$uid);
                        exit();
                    }
                    else
                    {
                        $_SESSION['statusred'] = "The attempt to remove all documents from your list is unsuccessful.";
                        header('Location: documents.php?id='.$uid);
                        exit();
                    }
                }
                if(isset($_POST['deletealluserdocu'])){
                    $uid = $_SESSION['verified_user_id'];
                    $del_id = $_POST['del_id'];
                    $ref_table = 'documents';
                    $deletequery = $database->getReference($ref_table)->remove();
                    
                    if($deletequery)
                        {
                            $_SESSION['status'] = "All documents from all users have been removed!";
                            header('Location: documents.php?id='.$uid);
                            exit();
                        }
                        else
                        {
                            $_SESSION['statusred'] = "The attempt to remove all documents from all users is unsuccessful.";
                            header('Location: documents.php?id='.$uid);
                            exit();
                        }
                    }
                    if(isset($_POST['deletealluserblot'])){
                        $uid = $_SESSION['verified_user_id'];
                        $del_id = $_POST['del_id'];
                        $ref_table = 'blotter';
                        $deletequery = $database->getReference($ref_table)->remove();
                        
                        if($deletequery)
                            {
                                $_SESSION['status'] = "All blotters from all users have been removed!";
                                header('Location: documents.php?id='.$uid);
                                exit();
                            }
                            else
                            {
                                $_SESSION['statusred'] = "The attempt to remove all blotters from all users is unsuccessful.";
                                header('Location: documents.php?id='.$uid);
                                exit();
                            }
                        }
                        if(isset($_POST['deletealluserres'])){
                            $uid = $_SESSION['verified_user_id'];
                            $del_id = $_POST['del_id'];
                            $ref_table = 'resident';
                            $deletequery = $database->getReference($ref_table)->remove();
                            
                            if($deletequery)
                                {
                                    $_SESSION['status'] = "All residents from all users have been removed!";
                                    header('Location: adminresident.php?id='.$uid);
                                    exit();
                                }
                                else
                                {
                                    $_SESSION['statusred'] = "The attempt to remove all residents from all users is unsuccessful.";
                                    header('Location: adminresident.php?id='.$uid);
                                    exit();
                                }
                            }

if(isset($_POST['deleteres'])){
    $uid = $_SESSION['verified_user_id'];
    $del_id = $_POST['del_id'];
    $ref_table = 'resident';
    $deluid = $uid.'/'.$del_id;
    $deletequery = $database->getReference($ref_table)->getChild($deluid)->remove();
    
    if($deletequery)
        {
            $_SESSION['status'] = "Household Member has been removed from your list!";
            header('Location: resident.php?id='.$uid);
            exit();
        }
        else
        {
            $_SESSION['statusred'] = "The attempt to remove the household member from your list is unsuccessful.";
            header('Location: resident.php?id='.$uid);
            exit();
        }
    }

    if(isset($_POST['deleteblot'])){
        $uid = $_SESSION['verified_user_id'];
        $del_id = $_POST['del_id'];
        $ref_table = 'blotter';
        $deluid = $uid.'/'.$del_id;
        $deletequery = $database->getReference($ref_table)->getChild($deluid)->remove();
        
        if($deletequery)
            {
                $_SESSION['status'] = "The blotter has been removed from your list!";
                header('Location: blotter.php?id='.$uid);
                exit();
            }
            else
            {
                $_SESSION['statusred'] = "The attempt to remove the blotter from your list is unsuccessful.";
                header('Location: blotter.php?id='.$uid);
                exit();
            }
        }
        if(isset($_POST['deleteusers'])){
            $uid = $_SESSION['verified_user_id'];
            $del_id = $_POST['del_id'];
            
            try{
                $auth->deleteUser($del_id);
                $_SESSION['status'] = "User has been deleted from your system!";
                header('Location: users.php?id='.$uid);
                 exit();
            } catch(Exception $e){
                $_SESSION['status'] = "The attempt to delete a user is unsuccessful.";
                header('Location: users.php?id='.$uid);
                 exit();
            }
            }
            
    if(isset($_POST['deletedoc'])){
        $uid = $_SESSION['verified_user_id'];
        $del_id = $_POST['del_id'];
        $ref_table = 'documents';
        $deluid = $uid.'/'.$del_id;
        $deletequery = $database->getReference($ref_table)->getChild($deluid)->remove();
        
        if($deletequery)
            {
                $_SESSION['status'] = "The document has been removed from your list!";
                header('Location: documents.php?id='.$uid);
                exit();
            }
            else
            {
                $_SESSION['statusred'] = "The attempt to remove the document from your list is unsuccessful.";
                header('Location: documents.php?id='.$uid);
                exit();
            }
        }
        if(isset($_POST['deleteadminblot'])){
            $uid = $_SESSION['verified_user_id'];
            $del_id = $_POST['del_id'];
            $del_uid = $_POST['del_uid'];
            $key = $_POST['key'];
            $ref_table = 'blotter';
            $deluid = $del_uid.'/'.$key;
            $deletequery = $database->getReference($ref_table)->getChild($deluid)->remove();
            
            if($deletequery)
                {
                    $_SESSION['status'] = "The blotter has been removed from your list!";
                    header('Location: adminblotter.php?id='.$uid);
                    exit();
                }
                else
                {
                    $_SESSION['statusred'] = "The attempt to remove the blotter from your list is unsuccessful.";
                    header('Location: adminblotter.php?id='.$uid);
                    exit();
                }
            }
            if(isset($_POST['deleteadmindocu'])){
                $uid = $_SESSION['verified_user_id'];
                $del_id = $_POST['del_id'];
                $del_uid = $_POST['del_uid'];
                $key = $_POST['key'];
                $ref_table = 'documents';
                $deluid = $del_uid.'/'.$key;
                $deletequery = $database->getReference($ref_table)->getChild($deluid)->remove();
                
                if($deletequery)
                    {
                        $_SESSION['status'] = "The user's document has been removed from the list!";
                        header('Location: admindocuments.php?id='.$uid);
                        exit();
                    }
                    else
                    {
                        $_SESSION['statusred'] = "The attempt to remove a user's document from the list is unsuccessful.";
                        header('Location: admindocuments.php?id='.$uid);
                        exit();
                    }
                }
                if(isset($_POST['deleteadminres'])){
                    $uid = $_SESSION['verified_user_id'];
                    $del_id = $_POST['del_id'];
                    $del_uid = $_POST['del_uid'];
                    $key = $_POST['key'];
                    $deluid = $del_uid.'/'.$key;
                    $ref_table = 'resident';
                    $deletequery = $database->getReference($ref_table)->getChild($deluid)->remove();
                    
                    if($deletequery)
                        {
                            $_SESSION['status'] = "The user's resident has been removed from the list!";
                            header('Location: adminresidents.php?id='.$uid);
                            exit();
                        }
                        else
                        {
                            $_SESSION['statusred'] = "The attempt to remove a user's resident from the list is unsuccessful.";
                            header('Location: adminresidents.php?id='.$uid);
                            exit();
                        }
                    }
    

if(isset($_POST['change_pwd_btn'])){
    $new_password = $_POST['new_password'];
    $uid = $_POST['change_pwd_uid'];
    
    $updatedUser = $auth->changeUserPassword($uid, $new_password);
    
    if($updatedUser)
    {
        $_SESSION['status'] = "Password Updated!";
        header('Location: changepassword.php?id='.$uid);
        exit();
    }
    else
    {
        $_SESSION['statusred'] = "Password Not Updated!";
        header('Location: changepassword.php');
        exit();
    }
}



if(isset($_POST['regisuser']))
{
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['prephone']. '' .$_POST['phone'];
    $password = $_POST['password'];
    $full_name = $first_name. ' '.$last_name;
    $userProperties = [
        'email'=>$email,
        'emailVerified' => false,
        'phoneNumber'=>$phone,
        'password'=>$password,
        'displayName'=>$full_name,
    ];
    
    $createdUser = $auth->createUser($userProperties);

    if($createdUser)
    {
        $_SESSION['status'] = "User Added Successfully!";
        header('Location: login.php');
        exit();
    }
    else
    {
        $_SESSION['status'] = "User Registration Unsuccessful!";
        header('Location: register.php');
        exit();
    }
}

if(isset($_POST['savepic'])){
    $profile = $_FILES['profilepic']['name']; 
    $random_no = rand(1111, 9999);
    $uid = $_SESSION['verified_user_id'];
    $user = $auth->getUser($uid);
    $new_image = $random_no.$profile;
    $old_image = $user->photoUrl;

    if($profile!=NULL){
        $filename = 'uploads/profilepictures/'.$new_image;
    }
    else{
        $filename = $old_image;
    }

    $properties = [
        'photoUrl' => $filename,
    ];

    $updatedUser = $auth ->updateUser($uid,$properties); 

    if($updatedUser){

        if($profile!=NULL){
            move_uploaded_file($_FILES['profilepic']['tmp_name'], "uploads/profilepictures/".$new_image);
            if($old_image!=NULL){
                unlink($old_image);
            }
        }
        $_SESSION['status'] = "Profile Picture Updated!";
        header("Location: profile.php?id=".$uid);
        exit(0);
    }
    else{
        $_SESSION['statusred'] = "Profile Picture Not Updated!";
        header("Location: profile.php?id=".$uid);
        exit(0);
    }
}

if(isset($_POST['profupd'])){
    $profile = $_FILES['profilepic']['name']; 
    $random_no = rand(1111, 9999);
    $uid = $_SESSION['verified_user_id'];
    $user = $auth->getUser($uid);
    $new_image = $random_no.$profile;
    $old_image = $user ->photoUrl;
    $name = $_POST['name'];
    $phone = $_POST['phonenum'];
    $email = $_POST['email'];

    if($profile!=NULL){
        $filename = 'uploads/profilepictures/'.$new_image;
    }
    else{
        $filename = $old_image;
    }

    $properties = [
        'email' => $email,
        'displayName' => $name,
        'phoneNumber' => $phone,
        'photoUrl' => $filename,
    ];

    $updatedUser = $auth ->updateUser($uid,$properties); 

    if($updatedUser){

        if($profile!=NULL){
            move_uploaded_file($_FILES['profilepic']['tmp_name'], "uploads/profilepictures/".$new_image);
            if($old_image!=NULL){
                unlink($old_image);
            }
        }
        $_SESSION['status'] = "Profile Details Updated!";
        header("Location: profile.php?id=".$uid);
        exit(0);
    }
    else{
        $_SESSION['statusred'] = "Profile Details Not Updated!";
        header("Location: profile.php?id=".$uid);
        exit(0);
    }
}


if(isset($_POST['addres'])){
    $uid = $_SESSION['verified_user_id'];
    $user = $auth->getUser($uid);
    $manager = $user->displayName;
    $firstname = $_POST['first_name'];
    $middlename = $_POST['middle_name'];
    $lastname = $_POST['last_name'];
    $gender = $_POST['gender'];
    $birthdate = $_POST['birthdate'];
    $religion = $_POST['religion'];
    $maritalstatus = $_POST['marital_status'];
    $contactnum = $_POST['contactnum'];
    $nationality = $_POST['nationality'];
    $housenostreet = $_POST['housenostreet'];
    $barangay = 'Barangay Santol';
    $city = 'Quezon City';
    $province = 'Metro Manila';
    $zipcode = 1113;
    $dob = new DateTime($birthdate);
    $today = new DateTime('today');
    $age = $dob->diff($today)->y;



    $postData = [
        'firstname'=>$firstname,
        'middlename'=>$middlename,
        'lastname'=>$lastname,
        'gender'=>$gender,
        'age'=>$age,
        'birthdate'=>$birthdate,
        'religion'=>$religion,
        'contactnum'=>$contactnum,
        'nationality'=>$nationality,
        'maritalstatus'=>$maritalstatus,
        'housenostreet'=>$housenostreet,
        'barangay'=>$barangay,
        'city'=>$city,
        'province'=>$province,
        'zipcode'=>$zipcode,
        'uid' =>$uid,
        'manager'=> $manager,
    ];

    $ref_table = "resident";
    $postRef_result = $database->getReference($ref_table)->getChild($uid)->push($postData);
    $postKey = $postRef_result->getKey();
    $postSecondData = [
        'firstname'=>$firstname,
        'middlename'=>$middlename,
        'lastname'=>$lastname,
        'gender'=>$gender,
        'age'=>$age,
        'birthdate'=>$birthdate,
        'religion'=>$religion,
        'contactnum'=>$contactnum,
        'nationality'=>$nationality,
        'maritalstatus'=>$maritalstatus,
        'housenostreet'=>$housenostreet,
        'barangay'=>$barangay,
        'city'=>$city,
        'province'=>$province,
        'zipcode'=>$zipcode,
        'uid' =>$uid,
        'manager'=> $manager,
        'key' => $postKey,
    ]; 
    $updateData = [
        'resident/'.$uid.'/'.$postKey => $postSecondData,
    ];
    $postRef_Second = $database->getReference()->update($updateData);

    if($postRef_result){
        $_SESSION['status'] = "Household Member has been added successfully!";
        header("Location: resident.php?id=".$uid);
        exit(0);
    }
    else{
        $_SESSION['statusred'] = "The attempt to add a household member is unsuccessful.";
        header("Location: resident.php?id=".$uid);
        exit(0);
    }
}

if(isset($_POST['addblot'])){
    $uid = $_SESSION['verified_user_id'];
    $complainant_firstname = $_POST['complainant_firstname'];
    $complainant_middlename = $_POST['complainant_middlename'];
    $complainant_lastname = $_POST['complainant_lastname'];
    $complainantaddress = $_POST['complainant_address'];
    $complainee_firstname = $_POST['complainee_firstname'];
    $complainee_middlename = $_POST['complainee_middlename'];
    $complainee_lastname = $_POST['complainee_lastname'];
    $complaineeaddress = $_POST['complainee_address'];
    $blottertype = $_POST['blottertype'];
    $incident = $_POST['incident'];
    $incidentevidence = $_FILES['blotter_evidence']['name'];
    $random_no = rand(1111, 9999);
    $new_media = $random_no.$incidentevidence;
    $filename = 'uploads/blotter/'.$new_media;
    $incidentdate = $_POST['incidentdate'];
    $status = 'Pending';

    


    $postData = [
        'complainant_firstname'=>$complainant_firstname,
        'complainant_middlename'=>$complainant_middlename,
        'complainant_lastname'=>$complainant_lastname,
        'complainantaddress'=>$complainantaddress,
        'complainee_firstname'=>$complainee_firstname,
        'complainee_middlename'=>$complainee_middlename,
        'complainee_lastname'=>$complainee_lastname,
        'complaineeaddress'=>$complaineeaddress,
        'blottertype'=>$blottertype,
        'incidentdate'=>$incidentdate,
        'incident'=>$incident,
        'incidentevidence'=>$filename,
        'status'=>$status,
    ];

    $ref_table = "blotter";
    $postRef_result = $database->getReference($ref_table)->getChild($uid)->push($postData);
    $postKey = $postRef_result->getKey();
    $postSecondData = [
        'complainant_firstname'=>$complainant_firstname,
        'complainant_middlename'=>$complainant_middlename,
        'complainant_lastname'=>$complainant_lastname,
        'complainantaddress'=>$complainantaddress,
        'complainee_firstname'=>$complainee_firstname,
        'complainee_middlename'=>$complainee_middlename,
        'complainee_lastname'=>$complainee_lastname,
        'complaineeaddress'=>$complaineeaddress,
        'blottertype'=>$blottertype,
        'incident'=>$incident,
        'incidentdate'=>$incidentdate,
        'incidentevidence'=>$filename,
        'status'=>$status,
        'key' => $postKey,
    ]; 
    $updateData = [
        'blotter/'.$uid.'/'.$postKey => $postSecondData,
    ];
    $postRef_Second = $database->getReference()->update($updateData);

    if($postRef_result){
        if($incidentevidence!=NULL){
            move_uploaded_file($_FILES['blotter_evidence']['tmp_name'], "uploads/blotter/".$new_media);
        }
        $_SESSION['status'] = "Blotter Added!";
        header("Location: blotter.php?id=".$uid);
        exit(0);
    }
    else{
        $_SESSION['statusred'] = "Blotter Not Added!";
        header("Location: blotter.php?id=".$uid);
        exit(0);
    }
}



if(isset($_POST['addusers']))
{
    $uid = $_SESSION['verified_user_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $prephone = '+63';
    $phone = $prephone. '' .$_POST['phone'];
    $password = $_POST['password'];
    $userProperties = [
        'email'=>$email,
        'emailVerified' => false,
        'phoneNumber'=>$phone,
        'password'=>$password,
        'displayName'=>$name,
    ];
    
    $createdUser = $auth->createUser($userProperties);

    if($createdUser)
    {
        $_SESSION['status'] = "User has been added!";
        header('Location: users.php?id='.$uid);
        exit();
    }
    else
    {
        $_SESSION['status'] = "The attempt to add a user is unsuccessful.";
        header('Location: users.php?id='.$uid);
        exit();
    }
}



if(isset($_POST['reqdoc'])){
    $uid = $_SESSION['verified_user_id'];
    $firstname = $_POST['first_name'];
    $middlename = $_POST['middle_name'];
    $lastname = $_POST['last_name'];
    $gender = $_POST['gender'];
    $birthdate = $_POST['birthdate'];
    $religion = $_POST['religion'];
    $maritalstatus = $_POST['marital_status'];
    $nationality = $_POST['nationality'];
    $document_type = $_POST['document_type'];
    $permitcertificate_type = $_POST['permitcertificate_type'];
    $documents = '';
    $status = 'Pending';
    $dob = new DateTime($birthdate);
    $today = new DateTime('today');
    $age = $dob->diff($today)->y;
    $housenostreet = $_POST['housenostreet'];
    $barangay = 'Barangay Santol';
    $city = 'Quezon City';

    if($permitcertificate_type != NULL){

    $postData = [
        'firstname'=>$firstname,
        'middlename'=>$middlename,
        'lastname'=>$lastname,
        'gender'=>$gender,
        'age'=>$age,
        'birthdate'=>$birthdate,
        'religion'=>$religion,
        'nationality'=>$nationality,
        'maritalstatus'=>$maritalstatus,
        'housenostreet'=> $housenostreet,
        'barangay'=> $barangay,
        'city'=> $city,
        'documenttype'=>$document_type,
        'permitcertificatetype'=> $permitcertificate_type,
        'documents'=>$documents,
        'status'=>$status,
        'uid' =>$uid,
    ];
}
else {
    $permitcertificate_type = 'N/A';
    $postData = [
        'firstname'=>$firstname,
        'middlename'=>$middlename,
        'lastname'=>$lastname,
        'gender'=>$gender,
        'age'=>$age,
        'birthdate'=>$birthdate,
        'religion'=>$religion,
        'nationality'=>$nationality,
        'maritalstatus'=>$maritalstatus,
        'barangay'=> $barangay,
        'city'=> $city,
        'housenostreet'=> $housenostreet,
        'documenttype'=>$document_type,
        'permitcertificatetype'=> $permitcertificate_type,
        'documents'=>$documents,
        'status'=>$status,
        'uid' =>$uid,
    ]; 
}

    $ref_table = "documents";
    $postRef_result = $database->getReference($ref_table)->getChild($uid)->push($postData);
    $postKey = $postRef_result->getKey();
    $postSecondData = [
        'firstname'=>$firstname,
        'middlename'=>$middlename,
        'lastname'=>$lastname,
        'gender'=>$gender,
        'age'=>$age,
        'birthdate'=>$birthdate,
        'religion'=>$religion,
        'nationality'=>$nationality,
        'maritalstatus'=>$maritalstatus,
        'barangay'=> $barangay,
        'city'=> $city,
        'housenostreet'=> $housenostreet,
        'documenttype'=>$document_type,
        'permitcertificatetype'=> $permitcertificate_type,
        'documents'=>$documents,
        'status'=>$status,
        'uid' =>$uid,
        'key' => $postKey
    ]; 

    $updateData = [
        'documents/'.$uid.'/'.$postKey => $postSecondData,
    ];
    $postRef_Second = $database->getReference()->update($updateData);
    if($postRef_result){
        $_SESSION['status'] = "Your document request form has been submitted successfully!";
        header("Location: documents.php?id=".$uid);
        exit(0);
    }
    else{
        $_SESSION['statusred'] = "The attempt to submit your document request form has been unsuccessful";
        header("Location: documents.php?id=".$uid);
        exit(0);
    }
}

if(isset($_POST['adminaddres'])){
    $uid = $_SESSION['verified_user_id'];
    $manageruid = $_POST['manageruid'];
    $user = $auth -> getUser($manageruid);
    $manager = $user -> displayName;
    $firstname = $_POST['first_name'];
    $middlename = $_POST['middle_name'];
    $lastname = $_POST['last_name'];
    $gender = $_POST['gender'];
    $birthdate = $_POST['birthdate'];
    $religion = $_POST['religion'];
    $maritalstatus = $_POST['marital_status'];
    $contactnum = $_POST['contactnum'];
    $nationality = $_POST['nationality'];
    $housenostreet = $_POST['housenostreet'];
    $barangay = 'Barangay Santol';
    $city = 'Quezon City';
    $province = 'Metro Manila';
    $zipcode = 1113;
    $dob = new DateTime($birthdate);
    $today = new DateTime('today');
    $age = $dob->diff($today)->y;



    $postData = [
        'firstname'=>$firstname,
        'middlename'=>$middlename,
        'lastname'=>$lastname,
        'gender'=>$gender,
        'age'=>$age,
        'birthdate'=>$birthdate,
        'religion'=>$religion,
        'contactnum'=>$contactnum,
        'nationality'=>$nationality,
        'maritalstatus'=>$maritalstatus,
        'housenostreet'=>$housenostreet,
        'barangay'=>$barangay,
        'city'=>$city,
        'province'=>$province,
        'zipcode'=>$zipcode,
        'uid' =>$manageruid,
        'manager'=> $manager,
    ];

    $ref_table = "resident";
    $postRef_result = $database->getReference($ref_table)->getChild($manageruid)->push($postData);
    $postKey = $postRef_result->getKey();
    $postSecondData = [
        'firstname'=>$firstname,
        'middlename'=>$middlename,
        'lastname'=>$lastname,
        'gender'=>$gender,
        'age'=>$age,
        'birthdate'=>$birthdate,
        'religion'=>$religion,
        'contactnum'=>$contactnum,
        'nationality'=>$nationality,
        'maritalstatus'=>$maritalstatus,
        'housenostreet'=>$housenostreet,
        'barangay'=>$barangay,
        'city'=>$city,
        'province'=>$province,
        'zipcode'=>$zipcode,
        'uid' =>$manageruid,
        'manager'=> $manager,
        'key' => $postKey,
    ]; 
    $updateData = [
        'resident/'.$manageruid.'/'.$postKey => $postSecondData,
    ];
    $postRef_Second = $database->getReference()->update($updateData);


    if($postRef_result){
        $_SESSION['status'] = "The resident has been added to".$manager. "'s record successfully!";
        header("Location: adminresidents.php?id=".$uid);
        exit(0);
    }
    else{
        $_SESSION['statusred'] = "The attempt to add a resident to".$manager."'s record is unsuccessful.";
        header("Location: adminresidents.php?id=".$uid);
        exit(0);
    }
}



if(isset($_POST['btn_login']))
{
    $email = $_POST['email'];
    $clearTextPassword = $_POST['password'];

    try {
        $signInResult = $auth->signInWithEmailAndPassword($email, $clearTextPassword);
    } catch (\Kreait\Firebase\Auth\SignIn\FailedToSignIn $e) {
        $_SESSION['statusred'] = "Invalid Email or Password!";
        header('Location: login.php');
        exit();
    }

    $idTokenString = $signInResult->idToken();

    if ($idTokenString === null) {
        echo "User signed in, but ID Token is empty"; exit;
    }

    try {
        $verifiedIdToken = $auth->verifyIdToken($idTokenString);
        
    } catch (\Kreait\Firebase\Exception\Auth\FailedToVerifyToken $e) {
        echo $e->getMessage(); exit;
    }
    $uid = $verifiedIdToken->claims()->get('sub');
    $_SESSION['verified_user_id'] = $uid;
    $_SESSION['idTokenString'] = $idTokenString;
    $_SESSION['status'] = "Logged in successfully!";
    header('Location: index.php');
    exit();
}




if(isset($_POST['btn_reset']))
{
$email = $_POST['email'];

try{
    $user = $auth->getUserByEmail("$email");
  try{
    $link = $auth->getPasswordResetLink($email);
    $auth->sendPasswordResetLink($email);
    $_SESSION['status'] = "Password reset link has been sent to your email! Check your inbox or spam!";
    header('Location: login.php');
    exit();
 
  } catch (Exception $e){
    $_SESSION['statusred'] = "Invalid Email!";
    header('Location: login.php');
    exit();
  }
} catch (\Kreait\Firebase\Exception\Auth\UserNotFound $e) {
    $_SESSION['statusred'] = "Email doesn't exist!";
    header('Location: login.php');
    exit();
}
}

else
{
    $_SESSION['statusred'] = "Not Allowed!";
    header('Location: login.php');
    exit();
}






?>