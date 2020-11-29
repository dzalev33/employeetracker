<?php
class Requests extends Controller {

    public function __construct()
    {
        if (!isLoggedIn()) {
            redirect('users/login');
        }

        $this->employeeModel = $this->model('Employee');
        $this->userModel = $this->model('User');
        $this->requestModel = $this->model('Request');
    }
    public function index(){
        //get employees
        $employees = $this->employeeModel->getEmployees();
        $requests = $this->requestModel->getRequests();

        $data = [
            'employees' => $employees,
            'requests' => $requests
        ];

        $this->view('employees/requests/index', $data);
    }
}