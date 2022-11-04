<?php
session_start();
include('dbcon.php');


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
    $middle_name = $_POST['middle_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['prephone']. '' .$_POST['phone'];
    $password = $_POST['password'];
    $full_name = $first_name. ' ' .$middle_name. ' ' .$last_name;
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
    ];

    $ref_table = "resident";
    $postRef_result = $database->getReference($ref_table)->getChild($uid)->push($postData);

    if($postRef_result){
        $_SESSION['status'] = "Resident Added!";
        header("Location: resident.php?id=".$uid);
        exit(0);
    }
    else{
        $_SESSION['statusred'] = "Resident Not Added!";
        header("Location: resident.php?id=".$uid);
        exit(0);
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
    $businesspermit_type = $_POST['businesspermit_type'];
    $barangaypermit_type = $_POST['barangaypermit_type'];
    $barangaycertificate_type = $_POST['barangaycertificate_type'];



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
        'businesspermittype'=>$businesspermit_type,
        'barangaypermittype'=>$barangaypermit_type,
        'barangaycertificatetype'=>$barangaycertificate_type,
        'uid' =>$uid,
    ];

    $ref_table = "requesteddocuments";
    $postRef_result = $database->getReference($ref_table)->getChild($uid)->push($postData);

    if($postRef_result){
        $_SESSION['status'] = "Document Request Form has been Submitted Successfully!";
        header("Location: requestdocuments.php?id=".$uid);
        exit(0);
    }
    else{
        $_SESSION['statusred'] = "Document Request Form has not been Submitted Successfully.";
        header("Location: requestdocuments.php?id=".$uid);
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
    header('Location: dashboard.php');
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
    header('Location: dashboard.php');
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