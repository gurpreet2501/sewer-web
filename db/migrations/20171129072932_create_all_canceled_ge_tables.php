<?php
use Phinx\Migration\AbstractMigration;

class CreateAllCanceledGeTables extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        $sql = "
        CREATE TABLE `canceled_gate_entries` (
          `id` int(10) UNSIGNED NOT NULL,
          `entry_type` varchar(5) NOT NULL,
          `form_id` int(11) DEFAULT NULL,
          `stock_group_id` int(10) UNSIGNED DEFAULT NULL,
          `truck_no` varchar(100) NOT NULL,
          `chatni_report_no` varchar(100) NOT NULL,
          `gate_pass_no` varchar(100) NOT NULL,
          `account_id` int(11) NOT NULL,
          `loaded_weight` decimal(10,2) NOT NULL,
          `loaded_weight_time` datetime DEFAULT NULL,
          `tare_weight` decimal(10,2) NOT NULL,
          `tare_weight_time` datetime DEFAULT NULL,
          `gross_weight` decimal(10,2) NOT NULL,
          `packing_material_weight` decimal(10,2) NOT NULL,
          `deduct_packing_material` tinyint(1) NOT NULL,
          `net_weight` decimal(10,2) NOT NULL,
          `status` varchar(20) NOT NULL DEFAULT 'Partially Completed',
          `second_weight_date` datetime NOT NULL,
          `first_weight_date` datetime NOT NULL,
          `cancelled` tinyint(1) NOT NULL,
          `prefix` varchar(255) NOT NULL,
          `serial` int(11) NOT NULL,
          `cancelation_reason` text NOT NULL,
          `canceled_by_user_id` int(11) NOT NULL,
          `created_at` datetime NOT NULL,
          `updated_at` datetime NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1;

        CREATE TABLE `canceled_ge_bag_types` (
          `id` int(10) UNSIGNED NOT NULL,
          `ge_id` int(10) UNSIGNED NOT NULL,
          `stock_item_id` int(11) NOT NULL,
          `bags` int(11) NOT NULL,
          `created_at` datetime NOT NULL,
          `updated_at` datetime NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1;

        CREATE TABLE `canceled_ge_bran_quality_report` (
          `id` int(11) NOT NULL,
          `party_test_report` varchar(255) NOT NULL,
          `lab_test_report` varchar(255) NOT NULL,
          `disputed` tinyint(1) NOT NULL,
          `remarks` varchar(255) NOT NULL,
          `created_at` datetime NOT NULL,
          `updated_at` datetime NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

        CREATE TABLE `canceled_ge_cmr_details` (
          `id` int(10) UNSIGNED NOT NULL,
          `ge_id` int(10) UNSIGNED NOT NULL,
          `account_id` int(11) NOT NULL,
          `cmr_agency_id` int(10) UNSIGNED NOT NULL,
          `cmr_market_id` int(11) DEFAULT NULL,
          `truck_no` varchar(100) NOT NULL,
          `tp_no` text NOT NULL,
          `tp_date` date NOT NULL,
          `ac_note_no` text NOT NULL,
          `ac_note_date` date NOT NULL,
          `quintals` decimal(10,2) NOT NULL,
          `no_of_bags` int(11) NOT NULL,
          `m_serial_no` varchar(100) NOT NULL,
          `created_at` datetime NOT NULL,
          `updated_at` datetime NOT NULL,
          `cmr_society_id` int(11) NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1;

        CREATE TABLE `canceled_ge_cmr_rice_delivery_details` (
          `id` int(10) UNSIGNED NOT NULL,
          `ge_id` int(10) UNSIGNED NOT NULL,
          `cmr_agency_id` int(10) UNSIGNED NOT NULL,
          `delivery_to_id` int(10) UNSIGNED NOT NULL,
          `fci_godown_id` int(10) UNSIGNED NOT NULL,
          `lot_num` varchar(100) NOT NULL,
          `created_at` datetime NOT NULL,
          `updated_at` datetime NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1;

        CREATE TABLE `canceled_ge_delivery_details` (
          `id` int(11) NOT NULL,
          `gate_entry_id` int(11) UNSIGNED DEFAULT NULL,
          `weight` decimal(10,2) NOT NULL,
          `weight_diff` decimal(10,2) NOT NULL,
          `created_at` datetime NOT NULL,
          `updated_at` datetime NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

        CREATE TABLE `canceled_ge_delivery_qc` (
          `id` int(11) NOT NULL,
          `gate_entry_id` int(11) UNSIGNED DEFAULT NULL,
          `qc_type_id` int(11) NOT NULL,
          `quantity_per_unit` decimal(10,2) NOT NULL,
          `cut_unit` varchar(10) NOT NULL,
          `unit_count` decimal(10,2) NOT NULL,
          `updated_at` datetime NOT NULL,
          `created_at` datetime NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

        CREATE TABLE `canceled_ge_godown_labor_allocation` (
          `id` int(10) UNSIGNED NOT NULL,
          `ge_id` int(10) UNSIGNED NOT NULL,
          `godown_id` int(10) UNSIGNED NOT NULL,
          `job_status` text NOT NULL,
          `bags` int(11) NOT NULL,
          `labor_party_name` varchar(100) NOT NULL,
          `remarks` text NOT NULL,
          `created_at` datetime NOT NULL,
          `updated_at` datetime NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1;

        CREATE TABLE `canceled_ge_material_qc_labour_allocation` (
          `id` int(11) NOT NULL,
          `ge_id` int(11) NOT NULL,
          `stock_item_id` int(11) NOT NULL,
          `bags` int(11) NOT NULL,
          `weight_in_kg` decimal(14,4) NOT NULL,
          `godown_id` int(11) NOT NULL,
          `labour_party_id` int(11) NOT NULL,
          `quality_cut_id` int(11) NOT NULL,
          `remarks` text NOT NULL,
          `labour_job_type_id` int(11) NOT NULL,
          `weight_unit` varchar(10) NOT NULL,
          `rate_per_unit` decimal(10,2) NOT NULL,
          `created_at` datetime NOT NULL,
          `updated_at` datetime NOT NULL,
          `rate_contract_id` int(11) DEFAULT NULL,
          `rate` decimal(10,2) NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

        CREATE TABLE `canceled_ge_quality_cut` (
          `id` int(10) UNSIGNED NOT NULL,
          `ge_id` int(10) UNSIGNED NOT NULL,
          `quality_cut_type` int(10) UNSIGNED NOT NULL,
          `bags` int(11) NOT NULL,
          `qty_per_bag` decimal(10,2) NOT NULL,
          `remarks` text NOT NULL,
          `created_at` datetime NOT NULL,
          `updated_at` datetime NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1;

        CREATE TABLE `canceled_ge_stock_items` (
          `id` int(10) UNSIGNED NOT NULL,
          `ge_id` int(10) UNSIGNED NOT NULL,
          `stock_item_id` int(10) UNSIGNED NOT NULL,
          `bags` int(11) NOT NULL,
          `created_at` datetime NOT NULL,
          `updated_at` datetime NOT NULL,
          `rate_contract_id` int(11) DEFAULT NULL,
          `rate` decimal(10,2) NOT NULL,
          `weight_unit` varchar(255) NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1;


        ALTER TABLE `canceled_gate_entries`
          ADD PRIMARY KEY (`id`),
          ADD KEY `form_id` (`form_id`),
          ADD KEY `stock_group_id` (`stock_group_id`),
          ADD KEY `account_id` (`account_id`);

        ALTER TABLE `canceled_ge_bag_types`
          ADD PRIMARY KEY (`id`);

        ALTER TABLE `canceled_ge_bran_quality_report`
          ADD PRIMARY KEY (`id`);

        ALTER TABLE `canceled_ge_cmr_details`
          ADD PRIMARY KEY (`id`),
          ADD KEY `cmr_market_id` (`cmr_market_id`);

        ALTER TABLE `canceled_ge_cmr_rice_delivery_details`
          ADD PRIMARY KEY (`id`);

        ALTER TABLE `canceled_ge_delivery_details`
          ADD PRIMARY KEY (`id`),
          ADD KEY `gate_entry_id` (`gate_entry_id`);

        ALTER TABLE `canceled_ge_delivery_qc`
          ADD PRIMARY KEY (`id`),
          ADD KEY `gate_entry_id` (`gate_entry_id`);

        ALTER TABLE `canceled_ge_godown_labor_allocation`
          ADD PRIMARY KEY (`id`);

        ALTER TABLE `canceled_ge_material_qc_labour_allocation`
          ADD PRIMARY KEY (`id`),
          ADD KEY `rate_contract_id` (`rate_contract_id`);

        ALTER TABLE `canceled_ge_quality_cut`
          ADD PRIMARY KEY (`id`);

        ALTER TABLE `canceled_ge_stock_items`
          ADD PRIMARY KEY (`id`),
          ADD KEY `rate_contract_id` (`rate_contract_id`);


        ALTER TABLE `canceled_gate_entries`
          MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
        ALTER TABLE `canceled_ge_bag_types`
          MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=449;
        ALTER TABLE `canceled_ge_bran_quality_report`
          MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
        ALTER TABLE `canceled_ge_cmr_details`
          MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=166;
        ALTER TABLE `canceled_ge_cmr_rice_delivery_details`
          MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;
        ALTER TABLE `canceled_ge_delivery_details`
          MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
        ALTER TABLE `canceled_ge_delivery_qc`
          MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
        ALTER TABLE `canceled_ge_godown_labor_allocation`
          MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
        ALTER TABLE `canceled_ge_material_qc_labour_allocation`
          MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=658;
        ALTER TABLE `canceled_ge_quality_cut`
          MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=681;
        ALTER TABLE `canceled_ge_stock_items`
          MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=155;";


        $this->execute($sql);
    }
}
