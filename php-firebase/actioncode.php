<?php
session_start();
include('dbcon.php');

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
    $age = $_POST['age'];
    $birthdate = $_POST['birthdate'];
    $religion = $_POST['religion'];
    $maritalstatus = $_POST['marital_status'];
    $contactnum = $_POST['contactnum'];
    $nationality = $_POST['nationality'];
    $city = $_POST['city'];
    $province = $_POST['province'];
    $zipcode = $_POST['zipcode'];
    $address = $_POST['address'];



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
        'address'=>$address,
        'city'=>$city,
        'province'=>$province,
        'zipcode'=>$zipcode,
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
        $status = 'Pending';
    
        
    
    
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
            'incidentevidence'=>$filename,
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
    

        if(isset($_POST['updateadminblot'])){
            $uid = $_SESSION['verified_user_id'];
            $edit_uid = $_POST['edit_uid'];
            $edit_id = $_POST['edit_id'];
            $ref_table = 'blotter';
            $edituid = $edit_uid.'/'.$edit_id;
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

            $status = $_POST['status'];
        
            
        
        if($incidentevidence!=NULL){
            $filename = 'uploads/blotter/'.$new_media;
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
                'incidentevidence'=>$filename,
                'status'=>$status,
            ];
        }
        else{
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
        }
        
            $updatequery = $database->getReference($ref_table)->getChild($edituid)->update($updateData);
            if($updatequery)
                {
                    if($incidentevidence!=NULL){
                        move_uploaded_file($_FILES['blotter_evidence']['tmp_name'], "uploads/blotter/".$new_media);
                    }
                    $_SESSION['status'] = "Blotter details has been updated!";
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

            if(isset($_POST['updateadmindocu'])){
                $uid = $_SESSION['verified_user_id'];
                $edit_uid = $_POST['edit_uid'];
                $edit_id = $_POST['edit_id'];
                $edituid = $edit_uid.'/'.$edit_id;
                $ref_table = 'documents';
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
                $documents = $_FILES['documents']['name'];
                $random_no = rand(1111, 9999);
                $new_media = $random_no.$documents;
            
                
            
            if($documents!=NULL && $permitcertificate_type != NULL){
                $filename = 'uploads/documents/'.$new_media;
            
            
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
                    'documenttype'=>$document_type,
                    'permitcertificatetype'=> $permitcertificate_type,
                    'documents'=>$filename,
                    'status'=>$status,
                ];
            }
            elseif($documents!=NULL && $permitcertificate_type == NULL){
                    $filename = 'uploads/documents/'.$new_media;
                    $permitcertificate_type = 'N/A';
                
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
                        'documenttype'=>$document_type,
                        'permitcertificatetype'=> $permitcertificate_type,
                        'documents'=>$filename,
                        'status'=>$status,
                    ];
                
            }
            elseif($documents == NULL && $permitcertificate_type != NULL){
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
                    'documenttype'=>$document_type,
                    'permitcertificatetype'=> $permitcertificate_type,
                    'status'=>$status,
                ];
            }
            else{
                $permitcertificate_type = 'N/A';
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
                    'documenttype'=>$document_type,
                    'permitcertificatetype'=> $permitcertificate_type,
                    'status'=>$status,
                ];
            }
            
            
                $updatequery = $database->getReference($ref_table)->getChild($edituid)->update($updateData);
                if($updatequery)
                    {
                        if($documents!=NULL){
                            move_uploaded_file($_FILES['documents']['tmp_name'], "uploads/documents/".$new_media);
                        }
                        $_SESSION['status'] = "The user's document details have been updated!";
                        header("Location: admindocuments.php?id=".$uid);
                        exit(0);
                    }
                    else
                    {
                        $_SESSION['statusred'] = "The attempt to update the user's document details was unsuccessful.";
                        header('Location: admindocuments.php?id='.$uid);
                        exit();
                    }
                }

                if(isset($_POST['updateadminres'])){
                    $uid = $_SESSION['verified_user_id'];
                    $edit_uid = $_POST['edit_uid'];
                    $edit_id = $_POST['edit_id'];
                    $ref_table = 'resident';
                    $edituid = $edit_uid.'/'.$edit_id;
                    $firstname = $_POST['first_name'];
                    $middlename = $_POST['middle_name'];
                    $lastname = $_POST['last_name'];
                    $gender = $_POST['gender'];
                    $age = $_POST['age'];
                    $birthdate = $_POST['birthdate'];
                    $religion = $_POST['religion'];
                    $maritalstatus = $_POST['marital_status'];
                    $contactnum = $_POST['contactnum'];
                    $nationality = $_POST['nationality'];
                    $city = $_POST['city'];
                    $province = $_POST['province'];
                    $zipcode = $_POST['zipcode'];
                    $address = $_POST['address'];
                
                
                
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
                        'address'=>$address,
                        'city'=>$city,
                        'province'=>$province,
                        'zipcode'=>$zipcode,
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
            $ref_table = 'blotter';
            $deluid = $del_uid.'/'.$del_id;
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
                $ref_table = 'documents';
                $deluid = $del_uid.'/'.$del_id;
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
                    $deluid = $del_uid.'/'.$del_id;
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
    //$ref_table = "users";
    //$postRef_result = $database->getReference($ref_table)->push($userProperties);

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
    $age = $_POST['age'];
    $birthdate = $_POST['birthdate'];
    $religion = $_POST['religion'];
    $maritalstatus = $_POST['marital_status'];
    $contactnum = $_POST['contactnum'];
    $nationality = $_POST['nationality'];
    $houseno = $_POST['houseno'];
    $street = $_POST['street'];
    $barangay = $_POST['barangay'];
    $city = $_POST['city'];
    $province = $_POST['province'];
    $zipcode = $_POST['zipcode'];
    $address = $_POST['houseno']. ' ' .$_POST['street']. ' , ' .$_POST['barangay'];



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
        'address'=>$address,
        'city'=>$city,
        'province'=>$province,
        'zipcode'=>$zipcode,
        'uid' =>$uid,
        'manager'=> $manager,
    ];

    $ref_table = "resident";
    $postRef_result = $database->getReference($ref_table)->getChild($uid)->push($postData);

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
    $incident = $_POST['incident'];
    $incidentevidence = $_FILES['blotter_evidence']['name'];
    $random_no = rand(1111, 9999);
    $new_media = $random_no.$incidentevidence;
    $filename = 'uploads/blotter/'.$new_media;
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
        'incident'=>$incident,
        'incidentevidence'=>$filename,
        'status'=>$status,
    ];

    $ref_table = "blotter";
    $postRef_result = $database->getReference($ref_table)->getChild($uid)->push($postData);

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
    $age = $_POST['age'];
    $birthdate = $_POST['birthdate'];
    $religion = $_POST['religion'];
    $maritalstatus = $_POST['marital_status'];
    $nationality = $_POST['nationality'];
    $document_type = $_POST['document_type'];
    $permitcertificate_type = $_POST['permitcertificate_type'];
    $documents = '';
    $status = 'Pending';
    

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
        'documenttype'=>$document_type,
        'permitcertificatetype'=> $permitcertificate_type,
        'documents'=>$documents,
        'status'=>$status,
        'uid' =>$uid,
    ];
}
else {
    $permitcertificate_type = '';
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
        'documenttype'=>$document_type,
        'permitcertificatetype'=> $permitcertificate_type,
        'documents'=>$documents,
        'status'=>$status,
        'uid' =>$uid,
    ]; 
}

    $ref_table = "documents";
    $postRef_result = $database->getReference($ref_table)->getChild($uid)->push($postData);

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
    $age = $_POST['age'];
    $birthdate = $_POST['birthdate'];
    $religion = $_POST['religion'];
    $maritalstatus = $_POST['marital_status'];
    $contactnum = $_POST['contactnum'];
    $nationality = $_POST['nationality'];
    $houseno = $_POST['houseno'];
    $street = $_POST['street'];
    $barangay = $_POST['barangay'];
    $city = $_POST['city'];
    $province = $_POST['province'];
    $zipcode = $_POST['zipcode'];
    $address = $_POST['houseno']. ' ' .$_POST['street']. ' , ' .$_POST['barangay'];



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
        'address'=>$address,
        'city'=>$city,
        'province'=>$province,
        'zipcode'=>$zipcode,
        'uid' =>$manageruid,
        'manager'=> $manager,
    ];

    $ref_table = "resident";
    $postRef_result = $database->getReference($ref_table)->getChild($manageruid)->push($postData);

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
try{
    $user = $auth->getUserByEmail("$email");
  try{
    $signInResult = $auth->signInWithEmailAndPassword($email, $clearTextPassword);
    $idTokenString = $signInResult->idToken(); 

 
try {
    $verifiedIdToken = $auth->verifyIdToken($idTokenString);
    $uid = $verifiedIdToken->claims()->get('sub');
    $_SESSION['verified_user_id'] = $uid;
    $_SESSION['idTokenString'] = $idTokenString;
    $_SESSION['status'] = "Logged in successfully!";
    header('Location: index.php');
    exit();
} catch (FailedToVerifyToken $e) {
    echo 'The token is invalid: '.$e->getMessage();
}
  } catch (Exception $e){
    $_SESSION['statusred'] = "Invalid Email or Password!";
    header('Location: login.php');
    exit();
  }
} catch (\Kreait\Firebase\Exception\Auth\UserNotFound $e) {
    $_SESSION['statusred'] = "Invalid Email or Password!";
    header('Location: login.php');
    exit();
}
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