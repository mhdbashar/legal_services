<?php

defined('BASEPATH') or exit('No direct script access allowed');

include_once(__DIR__ . '/App_pdf.php');

class Oservice_data_pdf extends App_pdf
{
    protected $project_id;
    protected $ServID;

    public function __construct($ServID, $project_id)
    {
        parent::__construct();

        $this->ci->load->model('LegalServices/LegalServicesModel', 'legal');
        $this->ci->load->model('LegalServices/Other_services_model', 'other');

        $this->project_id = $project_id;
        $this->ServID = $ServID;
    }

    public function prepare()
    {
        $slug = $this->ci->legal->get_service_by_id($this->ServID)->row()->slug;
        $project = $this->ci->other->get($ServID, $this->project_id);
        $this->SetTitle($project->name);
        $members                = $this->ci->other->get_project_members($project->id);
        $project->currency_data = $this->ci->other->get_currency($project->id);

        // Add <br /> tag and wrap over div element every image to prevent overlaping over text
        $project->description = preg_replace('/(<img[^>]+>(?:<\/img>)?)/i', '<br><br><div>$1</div><br><br>', $project->description);

        $data['project']    = $project;
        $data['milestones'] = $this->ci->other->get_milestones($slug, $project->id);
        $data['timesheets'] = $this->ci->other->get_timesheets($ServID, $project->id);

        $data['tasks']             = $this->ci->other->get_tasks($project->id, [], false);
        $data['total_logged_time'] = seconds_to_time_format($this->ci->other->total_logged_time($slug, $project->id));
        if ($project->deadline) {
            $data['total_days'] = round((human_to_unix($project->deadline . ' 00:00') - human_to_unix($project->start_date . ' 00:00')) / 3600 / 24);
        } else {
            $data['total_days'] = '/';
        }
        $data['total_members'] = count($members);
        $data['total_tickets'] = total_rows(db_prefix().'tickets', [
                'rel_sid' => $project->id,
                'rel_stype' => $slug,
            ]);
        $data['total_invoices'] = total_rows(db_prefix().'invoices', [
            'rel_sid' => $project->id,
            'rel_stype' => $slug,
            ]);

        $this->ci->load->model('invoices_model');

        $data['invoices_total_data'] = $this->ci->invoices_model->get_invoices_total([
                'currency'   => $project->currency_data->id,
                'rel_sid' => $project->id,
                'rel_stype' => $slug,
            ]);

        $data['total_milestones']     = count($data['milestones']);
        $data['total_files_attached'] = total_rows(db_prefix().'oservice_files', [
                'oservice_id' => $project->id,
            ]);
        $data['total_discussion'] = total_rows(db_prefix().'oservicediscussions', [
                'oservice_id' => $project->id,
            ]);
        $data['members'] = $members;

        $this->set_view_vars($data);

        return $this->build();
    }

    protected function type()
    {
        return 'oservice-data';
    }

    protected function file_path()
    {
        $customPath = APPPATH . 'views/admin/LegalServices/other_services/my_export_data_pdf.php';
        $actualPath = APPPATH . 'views/admin/LegalServices/other_services/export_data_pdf.php';

        if (file_exists($customPath)) {
            $actualPath = $customPath;
        }

        return $actualPath;
    }

    public function get_format_array()
    {
        return  [
            'orientation' => 'L',
            'format'      => 'landscape',
        ];
    }
}
