<?php
class MakePayment extends AdminController{

    public function __construct(){
        parent::__construct();
        $this->load->model('make_payment');
    }
    public function index(){
        if(!is_admin()){
            access_denied();
        }
        $month = $this->input->get('month');
        $year = $this->input->get('year');

        $data['date'] = $year . "-" . $month;
        if($this->input->is_ajax_request()){
            $this->hrmapp->get_table_data('my_makepayment_table', $data);
        }
        $data['title'] = 'Make Payment';
        
        $this->load->view('payments/month', $data);
    }
    public function get($id)
    {
        $data = $this->make_payment->getSalary($id);
        echo json_encode($data);
    }
    public function month($month = 1){
        if(!is_admin()){
            access_denied();
        }
        $month = $this->input->get('month');
        $year = $this->input->get('year');

        $data['month'] = $year . "-" . $month;

        if($this->input->is_ajax_request()){
            $this->hrmapp->get_table_data('my_makepayment_table', $data);
        }
        $data['title'] = 'Make Payment';
        
        $this->load->view('payments/makepayment', $data);
    }
    public function add(){
        if (!is_admin()) {
            access_denied();
        }
        if ($this->input->get()) {
            $data            = $this->input->get();
            // $data['message'] = $this->input->post('message', false);
            $success = $this->make_payment->add($data);
            if ($this->db->affected_rows() > 0) {

                set_alert('success', 'Paid Successfuly');
            }
            
            $date = $data['payment_month'];
            $start = strpos($date, '-');
            $month = substr($date, $start + 1);
            $year = str_replace("-".$month, '', $date);

            redirect('hrm/makepayment/month/?month=' . $month . "&year=" . $year);
        }
    }
}