<?php

class Employees extends Controller
{
    public function __construct()
    {
        if (!isLoggedIn()) {
            redirect('users/login');
        }
        $this->employeeModel = $this->model('Employee');
        $this->userModel     = $this->model('User');
        $this->requestModel  = $this->model('Request');
    }

    public function index()
    {
        //get employees
        $employees = $this->employeeModel->getEmployees();
        $requests  = $this->requestModel->getRequests();

        $data = [
            'employees' => $employees,
            'requests'  => $requests
        ];
        $this->view('employees/index', $data);
    }

    //add employee
    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //sanitize array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'name'         => trim($_POST['name']),
                'email'        => trim($_POST['email']),
                'password'     => trim($_POST['password']),
                'name_err'     => '',
                'email_err'    => '',
                'password_err' => ''
            ];

            //validation
            //validate name
            if (empty($data['name'])) {
                $data['name_err'] = 'Please enter Employee full name';
            }

            //validate email\
            if (empty($data['email'])) {
                $data['email_err'] = 'Please enter email';
            } else {
                //check email if exists in database
                if ($this->employeeModel->findUserByEmail($data['email'])) {
                    $data['email_err'] = 'email already exists in our database';
                }
            }

            //validate password
            if (empty($data['password'])) {
                $data['password_err'] = 'Please enter password';
            } elseif (strlen($data['password']) < 6) {
                $data['password_err'] = 'The Password must be at least 6 characters';
            }

            if (empty($data['name_err']) && empty($data['email_err']) && empty($data['password_err'])) {

                //hash password
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
                if ($this->employeeModel->addEmployee($data)) {
                    flash('employee_message', 'You have created new Employee in our system');

                    //send email
                    flash('email_message', 'An email has been sent to the employeee with his new credentials');
                    $to_email = $data['email'];
                    $subject  = "Employee credentials";
                    $body     = "your email is:" .$data['email'] . " and your password:" . $data['password'];
                    $headers  = "From: dzalevwork@gmail.com";
                    if (mail($to_email, $subject, $body, $headers)) {
                        echo "Email successfully sent to $to_email...";
                    } else {
                        echo "Email sending failed...";
                    }
                    redirect('employees');
                } else {
                    die('something went wrong');
                }
            } else {
                // load view with errors
                $this->view('employees/add', $data);
            }
        } else {
            $data = [
                'name'     => '',
                'email'    => '',
                'password' => ''
            ];
            $this->view('employees/add', $data);
        }
    }

    //edit employee
    public function edit($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //sanitize array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'id'           => $id,
                'name'         => trim($_POST['name']),
                'email'        => trim($_POST['email']),
                'password'     => trim($_POST['password']),
                'name_err'     => '',
                'email_err'    => '',
                'password_err' => ''
            ];

            //validation
            //validate name
            if (empty($data['name'])) {
                $data['name_err'] = 'Please enter Employee full name';
            }

            //validate email\
            if (empty($data['email'])) {
                $data['email_err'] = 'Please enter email';
            } else {
                //check email if exists in database
            }

            //validate password
            if (empty($data['password'])) {
                $data['password_err'] = 'Please enter password';
            } elseif (strlen($data['password']) < 6) {
                $data['password_err'] = 'The Password must be at least 6 characters';
            }

            if (empty($data['name_err']) && empty($data['email_err']) && empty($data['password_err'])) {
                //hash password
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                if ($this->employeeModel->updateEmployee($data)) {
                    flash('employee_message', 'You have Updated Employee Data');
                    redirect('employees');
                } else {
                    die('something went wrong');
                }
            } else {
//                load view with errors
                $this->view('employees/edit', $data);
            }
        } else {
            //get employee
            $employee = $this->employeeModel->getEmployeeById($id);

            $data = [
                'id'       => $id,
                'name'     => $employee->name,
                'email'    => $employee->email,
                'password' => $employee->password

            ];
            $this->view('employees/edit', $data);
        }
    }

    public function show($id)
    {
        $requests = $this->requestModel->getRequests();
        $request  = $this->requestModel->getRequestById($id);
        $employee = $this->employeeModel->getEmployeeById($id);

        $data = [
            'employee' => $employee,
            'requests' => $requests,
            'request'  => $request
        ];

        $this->view('employees/show', $data);
    }

    public function delete($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->employeeModel->deleteEmployee($id)) {
                flash('employee_message', 'The Employee was Removed');
                redirect('employees');
            } else {
                die('something went wrong');
            }
        } else {
            redirect('employees');
        }
    }

///////////////////////REQUESTS///////////////////////////

    public function requests(){
        $requests = $this->requestModel->getRequests();
        $data = [
            'requests' => $requests
        ];
        $this->view('employees/requests', $data);
    }

    public function addRequest(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //sanitize array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'user_id'          => $_SESSION['user_id'],
                'request_from'     => trim($_POST['request_from']),
                'request_to'       => trim($_POST['request_to']),
                'status'           => 'Pending',
                'request_from_err' => '',
                'request_to_err'   => ''
            ];
            //validation
            //validate name
            if (empty($data['request_from'])) {
                $data['request_from_err'] = 'Please Enter date from';
            }

            if (empty($data['request_to'])) {
                $data['request_to_err'] = 'Please Enter date to';
            }

            if (empty($data['request_from_err']) &&  empty($data['request_to_err'])) {
                if ($this->requestModel->addEmployeeRequest($data)) {
                    flash('request_message', 'You have created new request in our system! Please wait for out Administrator to respond.');
                    //send email
                    flash('email_message', 'An email with the new Request status was sent to the Administrator. Please wait for his response');
                    $to_email = $data['email'];
                    $subject  = "Employee credentials";
                    $body     = "your request status is:" .$data['status'];
                    $headers  = "From: dzalevwork@gmail.com";

                    if (mail($to_email, $subject, $body, $headers)) {
                        echo "Email successfully sent to $to_email...";
                    } else {
                        echo "Email sending failed...";
                    }
                    header('location: ' . URLROOT . '/employees/show/'.  $_SESSION['user_id'] );
                } else {
                    die('something went wrong');
                }
            } else {
//                load view with errors
                $this->view('employees/addRequest', $data);
            }
        } else {
            $data = [
                'request_from' => '',
                'request_to'   => ''
            ];
            $this->view('employees/addRequest', $data);
        }
    }

   public function approveRequest($id){
       if ($_SERVER['REQUEST_METHOD'] == 'POST') {
           if ($this->requestModel->approveRequestById($id)){
               flash('request_message', 'Request Approved! the Employee will be notified by email');
               redirect('employees/requests');
           }else{
               die('something went wrong');
           }
       } else {
           redirect('employees/requests');
       }
   }

    public function cancelRequest($id){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->requestModel->cancelRequestById($id)){
                flash('request_message', 'Request Canceled! the Employee will be notified by email');
                header('location: ' . URLROOT . '/employees/show/'.  $_SESSION['user_id'] );
            }else{
                die('something went wrong');
            }
        } else {
            redirect('employees/requests');
        }
    }

    public function rejectRequest($id){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->requestModel->rejectRequestbyId($id)){
                flash('request_message', 'Request rejected, the Employee will be notified by email');
                redirect('employees/requests');
            }else{
                die('something went wrong');
            }
        } else {
            redirect('employees/requests');
        }
    }

    public function removeRequest($id){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->requestModel->deleteRequest($id)) {
                flash('request_message', 'The Request was Removed');
                redirect('employees/requests');
            } else {
                die('something went wrong');
            }
        } else {
            redirect('employees/requests');
        }
    }

    public function licences(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            var_dump($_POST);
            //sanitize array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'user_id'          => $_SESSION['user_id'],
                'request_from'     => trim($_POST['request_from']),
                'request_to'       => trim($_POST['request_to']),
                'status'           => 'Pending',
                'request_from_err' => '',
                'request_to_err'   => ''
            ];
            //validation
            //validate name
            if (empty($data['request_from'])) {
                $data['request_from_err'] = 'Please Enter date from';
            }

            if (empty($data['request_to'])) {
                $data['request_to_err'] = 'Please Enter date to';
            }

            if (empty($data['request_from_err']) &&  empty($data['request_to_err'])) {
                if ($this->requestModel->addEmployeeRequest($data)) {
                    flash('request_message', 'You have created new request in our system! Please wait for out Administrator to respond.');
                    redirect('employees/requests');
                } else {
                    die('something went wrong');
                }
            } else {
//                load view with errors
                $this->view('employees/addRequest', $data);
            }
        } else {
            $data = [
                'request_from' => '',
                'request_to'   => ''
            ];
            $this->view('employees/addRequest', $data);
        }
    }

    public function sendMailToEmployee($data){
        //test email
        $to_email = "dzalev@hotmail.com";
        $subject = "Simple Email Test via PHP";
        $body = "Hi,nn This is test email send by PHP Script";
        $headers = "From: dzalevwork@gmail.com";

        if (mail($to_email, $subject, $body, $headers)) {
            echo "Email successfully sent to $to_email...";
        } else {
            echo "Email sending failed...";
        }
    }
}