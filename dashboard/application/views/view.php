<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container-fluid">
    <div class="row">
        <?php $this->load->view('templates/toolbars/welcome.php'); ?>   
        <div class="col-lg-12">
            <h1 class="page-header">Welcome to Canterbury College Dashboard</h1>
            <br>
            <div class="row dept-items">
                <div class="col-sm-6">
                    <a href="<?= base_url('human-resources') ?>" id="no-link-style">
                        <i class="fa fa-user fa-5x" aria-hidden="true"></i>
                        <h2>HR</h2></a>
                    <p><a href="/cc/staff-portal/human-resources/updates">HR Updates </a>|<a href="/cc/staff-portal/human-resources/forms"> Find a Form </a>| <a href="http://sap06-70/accessselecthr182/Login.aspx">SelectHR</a></p>
                </div>
                <div class="col-sm-6">
                    <a href="<?= base_url('computing-support') ?>" id="no-link-style">
                        <i class="fa fa-laptop fa-5x" aria-hidden="true"></i>
                        <h2>Computing Support</h2></a>
                    <p><a href="/dashboard/computing-support">All Forms </a> | <a href="/cc/staff-portal/computing-support/log-job">Log a Job </a>|<a href="/dashboard/computing-support/status"> IT Service Status </a></p>
                </div>
                <div class="col-sm-6">
                    <a href="<?= base_url('marketing') ?>" id="no-link-style">
                        <i class="fa fa-comment-o fa-5x" aria-hidden="true"></i>
                        <h2>Marketing</h2></a>
                    <p><a href="/cc/staff-portal/marketing/brand-guidelines">The Brand</a> | <a href="/application/files/6014/7453/2910/REMs_course_pro_forma.docx">Course Approval</a></p>
                </div>
            </div>
            <a href="/cc/staff-portal/staff-online-forms">Other Staff Forms</a> <br>
            <a href="https://dashboard.cant-col.ac.uk/index.php/home">Old Dashboard</a>
        </div> <!-- END col-lg-12 -->
    </div> <!-- END row -->
</div> <!-- END container-fluid -->
