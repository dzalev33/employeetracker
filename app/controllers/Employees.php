<?php
class Employees extends Controller {


    public function __construct()
    {
        if (!isLoggedIn()){
            redirect('users/login');
        }

        $this->employeeModel = $this->model('Employee');
        $this->userModel = $this->model('User');
    }

    public function index(){
        //get employees

       $employees = $this->employeeModel->getEmployees();

        $data = [
            'employees' => $employees
        ];
        $this->view('employees/index',$data);
    }
    //add employee
    public function add(){

        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
                //sanitize array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'name' => trim($_POST['name']),
                'email' => trim($_POST['email']),
                'password' =>trim($_POST['password']),
                'name_err' => '',
                'email_err' => '',
                'password_err' => ''
            ];

            //validation
            //validate name
            if (empty($data['name'])){
                $data['name_err'] = 'Please enter Employee full name';
            }

            //validate email\
            if (empty($data['email'])){
                $data['email_err'] = 'Please enter email';
            } else{
                //check email if exists in database
                if ($this->employeeModel->findUserByEmail($data['email'])){
                    $data['email_err'] = 'email already exists in our database';
                }
            }

            //validate password
            if (empty($data['password'])){
                $data['password_err'] = 'Please enter password';
            }elseif(strlen($data['password']) <6){
                $data['password_err'] = 'The Password must be at least 6 characters';
            }

            if (empty($data['name_err']) && empty($data['email_err']) && empty($data['password_err'])){
                //hash password
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
                  if ($this->employeeModel->addEmployee($data)) {
                     flash('employee_message', 'You have created new Employee in our system');
                        redirect('employees');

                  }else{
                        die('something went wrong');
                  }
            }else{

//                load view with errors
                         $this->view('employees/add', $data);
            }

        }else{
            $data = [
                'name' => '',
                'email' =>'',
                'password' => ''

            ];
            $this->view('employees/add',$data);
        }

    }

    //edit employee

    public function edit($id){
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            //sanitize array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'id' => $id,
                'name' => trim($_POST['name']),
                'email' => trim($_POST['email']),
                'password' =>trim($_POST['password']),
                'name_err' => '',
                'email_err' => '',
                'password_err' => ''
            ];

            //validation
            //validate name
            if (empty($data['name'])){
                $data['name_err'] = 'Please enter Employee full name';
            }

            //validate email\
            if (empty($data['email'])){
                $data['email_err'] = 'Please enter email';
            } else{
                //check email if exists in database

            }

            //validate password
            if (empty($data['password'])){
                $data['password_err'] = 'Please enter password';
            }elseif(strlen($data['password']) <6){
                $data['password_err'] = 'The Password must be at least 6 characters';
            }

            if (empty($data['name_err']) && empty($data['email_err']) && empty($data['password_err'])){
                //hash password
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
                if ($this->employeeModel->updateEmployee($data)) {
                    flash('employee_message', 'You have Updated Employee Data');
                    redirect('employees');

                }else{
                    die('something went wrong');
                }
            }else{

//                load view with errors
                $this->view('employees/edit', $data);
            }

        }else{
            //get employee
            $employee = $this->employeeModel->getEmployeeById($id);
            //check for credentials
//            if ($employee->id !== $_SESSION['user_id'] ){
//                redirect('employees');
//            }

            $data = [
                'id' => $id,
                'name' => $employee->name,
                'email' =>$employee->email,
                'password' => $employee->password

            ];
            $this->view('employees/edit',$data);
        }

    }
// employee/show/id
    public function show($id){

        $employee = $this->employeeModel->getEmployeeById($id);

        $data = [
            'employee' => $employee
        ];

        $this->view('employees/show',$data);
    }

    public function delete($id){
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            if ($this->employeeModel->deleteEmployee($id)){
                flash('employee_message', 'The Employee was Removed');
                redirect('employees');
            }else{
                die('something went wrong');
            }
        }else{
            redirect('employees');
        }
    }
}