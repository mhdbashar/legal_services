<?php

defined('BASEPATH') or exit('No direct script access allowed');

include_once(__DIR__ . '/App_pdf.php');

class Case_data_pdf extends App_pdf
{
    protected $project_id;
    protected $ServID;

    public function __construct($ServID, $project_id)
    {
        parent::__construct();

        $this->ci->load->model('legalservices/LegalServicesModel', 'legal');
        $this->ci->load->model('legalservices/Cases_model', 'case');

        $this->project_id = $project_id;
        $this->ServID = $ServID;
    }

    public function prepare()
    {
        $slug = $this->ci->legal->get_service_by_id($this->ServID)->row()->slug;
        $project = $this->ci->case->get($this->project_id);
        $this->SetTitle($project->name);
        $members                = $this->ci->case->get_project_members($project->id);
        $project->currency_data = $this->ci->case->get_currency($project->id);

        // Add <br /> tag and wrap over div element every image to prevent overlaping over text
        $project->description = preg_replace('/(<img[^>]+>(?:<\/img>)?)/i', '<br><br><div>$1</div><br><br>', $project->description);

        $data['project']    = $project;
        $data['milestones'] = $this->ci->case->get_milestones($slug, $project->id);
        $data['timesheets'] = $this->ci->case->get_timesheets($project->id);

        $data['tasks']             = $this->ci->case->get_tasks($project->id, ['is_session' => 0], false);

        $data['sessions']             = $this->ci->case->get_tasks($project->id, ['is_session' => 1], false);

        $data['total_logged_time'] = seconds_to_time_format($this->ci->case->total_logged_time($slug, $project->id));
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
        $data['total_files_attached'] = total_rows(db_prefix().'case_files', [
                'project_id' => $project->id,
            ]);
        $data['total_discussion'] = total_rows(db_prefix().'casediscussions', [
                'project_id' => $project->id,
            ]);
        $data['members'] = $members;

        $this->set_view_vars($data);

        return $this->build();
    }

    protected function type()
    {
        return 'case-data';
    }

    protected function file_path()
    {
        $customPath = APPPATH . 'views/admin/legalservices/cases/my_export_data_pdf.php';
        $actualPath = APPPATH . 'views/admin/legalservices/cases/export_data_pdf.php';

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
   
    public function Header()
    {

        $image_file = get_option('custom_pdf_header_image_url');
        $width = get_option('pdf_header_logo_width');

        if ($image_file != '') {

            $this->SetMargins(10, 60, 10, true);
            if ($width != '') {

                $this->Image($image_file, 0, 0, $width, 0, 'PNG', '', 'T', false, 300, 'C', false, false, 0, false, false, false);
            } else {
                $width = 210;
                $this->Image($image_file, 0, 0, $width, 50, 'PNG', '', 'T', false, 300, 'C', false, false, 0, false, false, false);
            }

        }
    }

    public function Footer()
    {
        $width_footer = '';
        $image_file_footer = '';
        $image_file_footer = get_option('custom_pdf_footer_image_url');

        $width_footer = get_option('pdf_footer_logo_width');

        if ($image_file_footer != '') {
            $this->SetMargins(10, 60, 10, true);
            $this->SetAutoPageBreak(true, 60);
            if ($width_footer != '') {

                $this->Image($image_file_footer, 0, 280, $width_footer, 0, 'PNG', '', 'B', false, 300, 'C', false, false, 0, false, false, false);

            } else {
                $width_footer = 210;

                $this->Image($image_file_footer, 0, 265, $width_footer, 0, 'PNG', '', 'B', false, 300, 'C', false, false, 0, false, false, false);

            }

        }
    }
}
