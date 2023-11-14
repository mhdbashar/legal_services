<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Version_532 extends CI_Migration
{
    public function __construct()
    {
        parent::__construct();
    }
    public function up()
    {

//*****ADDing tbltransaction_type table ***********//

        $this->db->query("CREATE TABLE IF NOT EXISTS `tbltransaction_type` (
            `id` int(11) NOT NULL ,
            `name` varchar(50)   NOT NULL,
             PRIMARY KEY (`id`)
          )  ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;");

//*****ADDing 	tbltransaction_origin table ***********//
        $this->db->query("CREATE TABLE IF NOT EXISTS `tbltransaction_origin` (
            `id` int(11) NOT NULL ,
            `name` varchar(50)   NOT NULL,
             PRIMARY KEY (`id`)
          )  ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;");

//*****ADDing tbltransaction_incoming_type table ***********//
        $this->db->query("CREATE TABLE IF NOT EXISTS `tbltransaction_incoming_type` (
            `id` int(11) NOT NULL ,
            `name` varchar(50)   NOT NULL,
             PRIMARY KEY (`id`)
          )  ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;");

//*****ADDing tbltransaction_importance table ***********//
        $this->db->query("CREATE TABLE IF NOT EXISTS `tbltransaction_importance` (
            `id` int(11) NOT NULL ,
            `name` varchar(50)   NOT NULL,
             PRIMARY KEY (`id`)
          )  ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;");

//*****ADDing tbltransaction_classification table ***********//
        $this->db->query("CREATE TABLE IF NOT EXISTS `tbltransaction_classification` (
            `id` int(11) NOT NULL ,
            `name` varchar(50)   NOT NULL,
             PRIMARY KEY (`id`)
          )  ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;");

    }
}