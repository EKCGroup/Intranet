<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Mobile_policy extends My_Force_Login {

    public function __construct() {
        parent::__construct();
        $this->load->library('grocery_CRUD');
        $this->load->model('computing-support/Mobile_policy_model', 'mobile_policy_model');
    }

    public function index() {

        $this->load->helper('form');
        $this->load->library('form_validation');

        // validation rules
        $this->form_validation->set_rules('mobile', 'Mobile Number', 'trim|required|numeric|min_length[11]');

        if ($this->form_validation->run() === false) {

            $this->load->view('templates/header');
            $this->load->view('computing-support/mobile-policy/view');
            $this->load->view('templates/footer');
        } else {

            $full_name = $this->input->post('full_name');
            $email = $this->input->post('email');
            $mobile = $this->input->post('mobile');

            if ($this->mobile_policy_model->accept($full_name, $email, $mobile)) {

                $this->email->from('noreply@intranet.cant-col.ac.uk', 'Mobile Phone Policy');
                $this->email->to($_SESSION['ldap']['email']);
                $this->email->subject('Mobile Phone Policy');
                $this->email->message(
                       'Name: ' . $_SESSION['ldap']['fll_name']. '
                           
                       Has accepted the Canterbury College mobile phone policy.

                       Mobile Phone Policy
                        1.	Introduction
                        1.1	If you use or, are responsible for, a Canterbury College mobile phone, this document is important. Please ensure you read and comply with it.
                        1.2 	Canterbury College will provide mobile telephones for business use. These will be provided upon written (email) request, outlining the business need, to the IT Manager from the Operational Manager (budget holder) of the member of staff.
                        1.3	Costs of operating the mobile phone(s) provided will be re-charged to individual department(s) and must therefore be planned for annually in Business Plans/budgets.

                        2.	Legal Requirements
                        2.1	Driving while using a hand-held device became an offence on 1 December 2003. Examples of interactive communication functions are; Making and receiving calls, texting, accessing the internet and sending and receiving still or moving images. This includes periods when the vehicle is stationery but, the engine is running â€“ e.g.  In standing traffic (jams). 
                        2.2	In addition, the Dept. for Transport has strongly advised that a driver will risk prosecution for failing to have proper control of a vehicle if the driver uses a hands-free phone when driving and there is an incident/accident. The use of any phone or similar device might justify charges of careless or dangerous driving. 
                        2.3	It is therefore Canterbury College Policy, taking account of 2.1 & 2.2 above, that the use of mobile phones while driving, either hand-held or hands-free models, is prohibited. All phones must be switched off whilst driving, with voicemail activated to allow messages to be left as necessary.

                        3.	Acceptable Use
                        3.1	All mobile phones must be purchased through the Computing Support Department, who will obtain the best value for the service required.
                        3.2	A responsible person is to be identified for each Canterbury College mobile phone and this person will be responsible for the safekeeping of the telephone.  The name of the responsible person must be given to the IT Manager
                        3.4	Loss or theft of a mobile phone must be reported to the Computing Support Team immediately to allow the account to be closed and the service stopped/phone blocked.
                        3.5	If the responsible person identified with the College Mobile phone leaves the post they are in and no longer requires the mobile phone, they must ensure that the IT Manager and relevant operational manager is informed.
                        3.6	It is the responsibility of the staff member to ensure that the phone is secure and that they use security features built into the phone, specifically pin codes to stop unauthorised use.
                        3.7	Private use of College business mobile phones is permitted but, the cost of all personal calls must be paid back to the College by the user, every month. You will be provided with a copy of the mobile phone bill to check your calls, declare all personal calls and costs thereof and, authorise the College to deduct that amount from your next salary. Please refer to the â€œpaying for personal callsâ€� procedure on the Computing Support intranet page. 

                        4.      Other Information
                        4.1	Members of staff should be aware of the possible health risks associated with the excessive use of mobile telephones.  Use of any mobile phone should be kept to the minimum and landlines used where possible.
                        4.2	Invoices for the use of Canterbury College mobile phones are to be in the name of the Canterbury College and addressed to the Computing Support Department.  The summary invoice will be submitted to the Finance Office for payment.
                        4.3	All costs of mobile phone provision and use will be re-charged to relevant cost centres.');
                $this->email->send();
                
                $this->email->from('noreply@intranet.cant-col.ac.uk', 'Mobile Phone Policy');
                $this->email->to('ns@canterburycollege.ac.uk');
                $this->email->subject('Mobile Phone Policy Accepted');
                $this->email->message(
                       'Name: ' . $_SESSION['ldap']['full_name'] . '
                           
                       Has accepted the Canterbury College mobile phone policy.
                       
                       ' . date("d/m/Y") . ' ' . date("h:i"));
                $this->email->send();
                
                $function = 'mobile_policy_accepted';
                $this->user_model->function_log($function);

                // user created
                $this->load->view('templates/header');
                $this->load->view('computing-support/mobile-policy/complete');
                $this->load->view('templates/footer');
            } else {
                
                $function = 'mobile_policy_error';
                $this->user_model->function_log($function);

                $data = new stdClass();
                $data->error = 'There was a problem accepting the terms. Please try again.';

                // failed to create user
                $this->load->view('templates/header');
                $this->load->view('computing-support/mobile-policy/view', $data);
                $this->load->view('templates/footer');
            }
        }
    }
    
    public function accepted() {
        
        if (in_array('CN=Dashboard_Admin,OU=Dashboard_Group,OU=Intranet_Group,OU=Groups,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups']) || 
            in_array('CN=Dashboard_CS_NS,OU=Dashboard_Group,OU=Intranet_Group,OU=Groups,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups'])) {
        
            $crud = new grocery_CRUD();
            $crud->set_table('mobile_policy');
            $crud->set_subject('Mobile Policy', 'Mobile Policy');
            $crud->unset_columns('id'); 
            $crud->edit_fields('mobile'); 
            $crud->unset_add();
            $crud->unset_read();
            $output = $crud->render();

            $this->load->view('templates/header.php');
            $this->load->view('computing-support/mobile-policy/accepted', $output);
            $this->load->view('templates/footer.php');
            $this->load->view('templates/table_assets.php', $output);
            
        } else {
            redirect('permissions');
        }
        
    } // END user permissions
}
