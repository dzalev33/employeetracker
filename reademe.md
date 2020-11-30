# Recruitment Task
### Work from home requests Application for Employees


## Setup Requirements
For development purpuses, I have used XAMPP server and for emails I have used php build in functions,
(in order to send emails you will need to configure you XAMPP php.ini and sendmail.ini files to set up SMTP )


Please go to the `config.php` file, so you can define all your Params like APPROOT,URLROOT and SITENAME.
######Database
I have included schema creation script in the root folder `employeetracker.sql`
with some dummy data.


In order to connect with your local database, you can define your own Database params like DB_HOST, DB_NAME, DB_USER, DB_PASS in :`config.php`.


#How to use the app

####Admin Login 
##### Email: admin@admin.com
##### Password:123456


In this Application you can Log in as Administrator or as an Employee.
Also you can Register as a new user which the Administrator will be notified by mail.

The Administrator, once logged in, will be redirected to a view where
 he can see all the Employees with details about them and on each Employee he can navigate to
  "show Employee Details",  and a new view will be shown with a dedicated Employee data,
and also he can Edit details about the Employee and Delete the Employee.

###### Add Employee
On the Admin dashboard view there is a button "add Employee", from where 
the Administrator can create a new Employee. When the User is created, a Mail will be sent 
to the Employee with the Credential so he can login to the Application.

###### Work From Home Requests

When you are loged in as Administrator, on the Admin Dashboard, there is a button for "Work From Home Requests" that will redirect
you to a dedicated view where you can see all the Work From Home Requests that are made by the Employees.
By default, the request sent by the Employees are with status "Pending", so here you can 
Approve, Reject or Remove a request. When a request change is made, the Employee will be notified 
by mail with the status change.
#
#### Logged in as Employee

When you are logged in as Employee, you will be redirected to your own employee Dashboard 
where you can see your work from home requests and licences.

From here you can make a request to the Administrator to work from home and the admin will be notified by mail about your request.
Also you can Cancel the request that will change the status to canceled. Only the administrator can remove the requests.


 #

