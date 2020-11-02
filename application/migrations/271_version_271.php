<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Version_271 extends CI_Migration
{
    function __construct()
    {
        parent::__construct();
    }

    public function up()
    {
        // Add new table tblmy_courts
        $this->db->query("CREATE TABLE IF NOT EXISTS `tblmy_courts` (
          `c_id` int(11) NOT NULL,
          `court_name` varchar(250) NOT NULL,
          `is_default` int(1) NOT NULL DEFAULT '0',
          `datecreated` date NOT NULL         
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");

        $this->db->query("ALTER TABLE `tblmy_courts`
            ADD PRIMARY KEY (`c_id`);");

        $this->db->query("ALTER TABLE `tblmy_courts`
          MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT;
        COMMIT;");

        // insert default value table tblmy_courts
        $this->db->query("INSERT INTO `tblmy_courts` (`c_id`, `court_name`, `is_default`, `datecreated`) VALUES
            (1, 'nothing_was_specified', 1, NOW())");

        // Add new table tblmy_judicialdept
        $this->db->query("CREATE TABLE IF NOT EXISTS `tblmy_judicialdept` (
          `j_id` int(255) NOT NULL,
          `Jud_number` varchar(255) NOT NULL,
          `c_id` int(255) NOT NULL,
          `is_default` int(1) NOT NULL DEFAULT '0',
          `datecreated` datetime NOT NULL          
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");

        $this->db->query("ALTER TABLE `tblmy_judicialdept`
          ADD PRIMARY KEY (`j_id`),
          ADD KEY `CourtJudKey` (`c_id`);");

        $this->db->query("ALTER TABLE `tblmy_judicialdept`
          MODIFY `j_id` int(255) NOT NULL AUTO_INCREMENT");

        $this->db->query("ALTER TABLE `tblmy_judicialdept`
          ADD CONSTRAINT `CourtJudKey` FOREIGN KEY (`c_id`) REFERENCES `tblmy_courts` (`c_id`) ON DELETE CASCADE ON UPDATE CASCADE;
        COMMIT;");

        // insert default value table tblmy_judicialdept
        $this->db->query("INSERT INTO `tblmy_judicialdept` (`j_id`, `Jud_number`, `c_id`, `is_default`, `datecreated`) VALUES
            (1, 'nothing_was_specified', 1, 1, NOW());");

    }
}
