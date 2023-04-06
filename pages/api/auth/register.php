
<?php
include_once base_path('/inc/inc_dbconnect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $test = new Account($con,['dsad'=>'dasda']);
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        $accountForm = new AccountDTO($data);

        if($accountForm->password != $accountForm->passwordConfirm){
            throw new Exception('Passwords do not match');
        }
        $regex = "^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).{8,}^";
        $regex = "^(?=.*[a-z]).{8,}^";
        if(!preg_match($regex, $accountForm->password)){
            throw new Exception('Password must contain numbers and upper and lower case characters and be 8 characters long');
        }

        $regex = "^.{4,}^";
        if(!preg_match($regex, $accountForm->username)){
            throw new Exception('Username must be atleast 4 characters long');
        }

        $matchingAccounts = Account::getAccountByName($con, $accountForm->username);

        if(isset($matchingAccounts)){
            throw new Exception('Account name taken');
        }

        $matchingAccounts = Account::getAccountByEmail($con, $accountForm->email);

        if(isset($matchingAccounts)){
            throw new Exception('email taken');
        }

        $account = Account::createAccount($con, $accountForm);
        
        $response['status'] = "success";
        $response['message'] = "Account created";
        $newMessages = $_SESSION['messages'];
        array_push($newMessages, $response);
        $_SESSION['messages'] = $newMessages;
        $jsonRes = json_encode($response);
        echo $jsonRes;
    }
    catch (\Exception $e) {
        $response['status'] = "failure";
        $response['message'] = $e->getMessage();
        $newMessages = $_SESSION['messages'];
        array_push($newMessages, $response);
        $_SESSION['messages'] = $newMessages;
        $jsonRes = json_encode($response);
        echo $jsonRes;
    }
}