<?php

class Employees extends Controller
{


    public function __construct()
    {
        if (!isLoggedIn()) {
            redirect('users/login');
        }

        $this->employeeModel = $this->model('Employee');
        $this->userModel = $this->model('User');
        $this->requestModel = $this->model('Request');
    }

    public function index()
    {
        //get employees

        $employees = $this->employeeModel->getEmployees();
        $requests = $this->requestModel->getRequests();

        $data = [
            'employees' => $employees,
            'requests' => $requests
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
                'name' => trim($_POST['name']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'name_err' => '',
                'email_err' => '',
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
                    redirect('employees');

                } else {
                    die('something went wrong');
                }
            } else {

//                load view with errors
                $this->view('employees/add', $data);
            }

        } else {
            $data = [
                'name' => '',
                'email' => '',
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
                'id' => $id,
                'name' => trim($_POST['name']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'name_err' => '',
                'email_err' => '',
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
                'id' => $id,
                'name' => $employee->name,
                'email' => $employee->email,
                'password' => $employee->password

            ];
            $this->view('employees/edit', $data);
        }

    }

// employee/show/id

//    public function request($id)
//    {
//        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//            //sanitize array
//            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
//            $data = [
//                'user_id' => $_SESSION['user_id'],
//                'request_from' => $_POST['request_from'],
//                'request_to' => $_POST['request_to'],
//                'status' => trim($_POST['status']),
//
//                'request_from_err' => '',
//                'request_to_err' => ''
//            ];
//
//            if (empty($data['request_from'])) {
//                $data['request_from_err'] = 'Please enter date from';
//            }
//            //validate name
//            if (empty($data['request_to'])) {
//                $data['request_to_err'] = 'Please date To';
//            }
//
//
//            if (empty($data['request_from']) && empty($data['request_to'])) {
//
//                if ($this->requestModel->addEmployeeRequest($data)) {
//                    flash('request_message', 'You have submitted a Work from Home Request');
//                    redirect('employees/show');
//
//                } else {
//                    die('something went wrong');
//                }
//            } else {
////                load view with errors
//                $this->view('employees/show', $data);
//            }
//
//
//        } else {
//
//            //get employee
//             $requests = $this->requestModel->getRequestById($id);
//            $employee = $this->requestModel->getRequestById($id);
//            //check for credentials
////            if ($employee->id !== $_SESSION['user_id'] ){
////                redirect('employees');
////            }
//
//            $data = [
//                'id' => $id,
//                'request_from' => $requests->request_from,
//                'request_to' => $requests->request_to
//
//
//            ];
//            $this->view('employees/request', $data);
//        }
//    }

//    public function workFromHomeRequest()
//    {
//        // add work from home request
//        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//            //sanitize array
//            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
//            $data = [
//                'user_id' => $_SESSION['user_id'],
//                'request_from' => $_POST['request_from'],
//                'request_to' => $_POST['request_to'],
//                'status' => trim($_POST['status']),
//
//                'request_from_err' => '',
//                'request_to_err' => ''
//            ];
//
//            if (empty($data['request_from'])) {
//                $data['request_from_err'] = 'Please enter date from';
//            }
//            //validate name
//            if (empty($data['request_to'])) {
//                $data['request_to_err'] = 'Please date To';
//            }
//
//
//            if (empty($data['request_from']) && empty($data['request_to'])) {
//
//                if ($this->requestModel->addEmployeeRequest($data)) {
//                    flash('request_message', 'You have submitted a Work from Home Request');
//                    redirect('employees/show');
//
//                } else {
//                    die('something went wrong');
//                }
//            } else {
////                load view with errors
//                $this->view('employees/show', $data);
//            }
//
//        } else {
//            $data = [
//                'request_from' => '',
//                'request_to' => '',
//                'status' => ''
//
//
//            ];
//            $this->view('employees/show', $data);
//        }
//    }

    public function show($id)
    {
        $requests = $this->requestModel->getRequests();
        $employee = $this->employeeModel->getEmployeeById($id);

        $data = [
            'employee' => $employee,
            'requests' => $requests
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

//REQUESTS///////////////////////////

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
                'user_id' => $_SESSION['user_id'],
                'request_from' => trim($_POST['request_from']),
                'request_to' => trim($_POST['request_to']),
                'status' => 'Pending',

                'request_from_err' => '',
                'request_to_err' => ''
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
                'request_to' => ''


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

}