<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container-fluid">
    <div class="row">
        <?php if (validation_errors()) : ?>
            <div class="col-md-12">
                <div class="alert alert-danger" role="alert">
                    <?= validation_errors() ?>
                </div>
            </div>
        <?php endif; ?>
        <?php if (isset($error)) : ?>
            <div class="col-md-12">
                <div class="alert alert-danger" role="alert">
                    <?= $error ?>
                </div>
            </div>
        <?php endif; ?>
        <?php if (isset($_COOKIE['CI-CONCRETE5'])) {
            $this->load->view('templates/toolbars/marketing/visitor.php'); 
        } ?>
        <div class="col-lg-12">
            <h1 class="page-header">Open Day Visitor</h1>
            <?= form_open() ?>
            <div class="form-group">
                <label for="first_name">First name *</label>
                <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Enter first name" value="<?= set_value('first_name') ?>">
            </div>
            <div class="form-group">
                <label for="last_name">Last name *</label>
                <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Enter last name" value="<?= set_value('last_name') ?>">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="text" class="form-control" id="email" name="email" placeholder="Enter email address" value="<?= set_value('email') ?>">
            </div>
            <div class="form-group">
                <label for="postcode">Full Postcode</label>
                <input type="text" class="form-control" id="postcode" name="postcode" placeholder="Enter postcode" value="<?= set_value('postcode') ?>" style="text-transform:uppercase">
            </div>
            <div class="form-group">
                <label for="dob">Date of Birth *</label><br>
                <input type="text" class="form-control" id="dob-d" name="dob_d" placeholder="DD" maxlength="2" style="width: 50px !important; display: inline-block;" value="<?= set_value('dob_d') ?>">
                <input type="text" class="form-control" id="dob-m" name="dob_m" placeholder="MM" maxlength="2" style="width: 50px !important; display: inline-block;" value="<?= set_value('dob_m') ?>">
                <input type="text" class="form-control" id="dob-y" name="dob_y" placeholder="YYYY" maxlength="4" style="width: 70px !important; display: inline-block;" value="<?= set_value('dob_y') ?>">
            </div> <br>
            <div class="form-group">
                <label>Current School (or previous)</label>
                <div class="row">
                    <div class="col-md-2">
                        <label id="checkbox"><input type="radio" name="current" value="Abbey School"> Abbey School</label> <br>
                        <label id="checkbox"><input type="radio" name="current" value="Archbishops School"> Archbishops School</label> <br>
                        <label id="checkbox"><input type="radio" name="current" value="Astor College"> Astor College</label> <br>
                        <label id="checkbox"><input type="radio" name="current" value="Brockhill"> Brockhill</label> <br>
                        <label id="checkbox"><input type="radio" name="current" value="Canterbury Academy"> Canterbury Academy</label>
                    </div>
                    <div class="col-md-2">
                        <label id="checkbox"><input type="radio" name="current" value="Charles Dickens School"> Charles Dickens School</label> <br>
                        <label id="checkbox"><input type="radio" name="current" value="Folkestone Academy"> Folkestone Academy</label> <br>
                        <label id="checkbox"><input type="radio" name="current" value="Fulston manor school"> Fulston manor school</label> <br>
                        <label id="checkbox"><input type="radio" name="current" value="Goodwin Academy"> Goodwin Academy</label> <br>
                        <label id="checkbox"><input type="radio" name="current" value="Hartsdown Academy"> Hartsdown Academy</label>
                    </div>
                    <div class="col-md-2">
                        <label id="checkbox"><input type="radio" name="current" value="Herne Bay High School"> Herne Bay High School</label> <br>
                        <label id="checkbox"><input type="radio" name="current" value="King Ethelbert School"> King Ethelbert School</label> <br>
                        <label id="checkbox"><input type="radio" name="current" value="Oasis Academy"> Oasis Academy</label> <br>
                        <label id="checkbox"><input type="radio" name="current" value="Pent Valley"> Pent Valley</label> <br>
                        <label id="checkbox"><input type="radio" name="current" value="Sandwich Technology School"> Sandwich Technology School</label>
                    </div>
                    <div class="col-md-2">
                        <label id="checkbox"><input type="radio" name="current" value="Sittingbourne Community College"> Sittingbourne Community College</label> <br>
                        <label id="checkbox"><input type="radio" name="current" value="Spires Academy"> Spires Academy</label> <br>
                        <label id="checkbox"><input type="radio" name="current" value="St Anselm's Catholic School"> St Anselm's Catholic School</label> <br>
                        <label id="checkbox"><input type="radio" name="current" value="St Georges CE Foundation School"> St Georges CE Foundation School</label> <br>
                        <label id="checkbox"><input type="radio" name="current" value="St. Edmunds Catholic School (Dover)"> St. Edmunds Catholic School (Dover)</label>
                    </div>
                    <div class="col-md-2">
                        <label id="checkbox"><input type="radio" name="current" value="The North School"> The North School</label> <br>
                        <label id="checkbox"><input type="radio" name="current" value="Towers School"> Towers School</label> <br>
                        <label id="checkbox"><input type="radio" name="current" value="Ursuline College"> Ursuline College</label> <br>
                        <label id="checkbox"><input type="radio" name="current" value="Westlands School"> Westlands School</label> <br>
                        <label id="checkbox"><input type="radio" name="current" value="Whitstable Community College"> Whitstable Community College</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5">
                        <input type="text" class="form-control" id="other" name="current_other" placeholder="Other" value="<?= set_value('current_other') ?>">
                    </div>
                </div>
            </div> <br>
            <div class="form-group">
                <label>Subject of interest (Primary)</label>
                <div class="row">
                    <div class="col-md-2">
                        <label id="checkbox"><input type="radio" name="subject[]" value="Animal Care, Veterinaray & Land-Based"> Animal Care, Veterinaray & Land-Based</label> <br>
                        <label id="checkbox"><input type="radio" name="subject[]" value="Apprenticeship"> Apprenticeship</label> <br>
                        <label id="checkbox"><input type="radio" name="subject[]" value="Art & Design"> Art & Design</label> <br>
                        <label id="checkbox"><input type="radio" name="subject[]" value="Beauty & Theatrical Makeup"> Beauty & Theatrical Makeup</label> <br>
                        <label id="checkbox"><input type="radio" name="subject[]" value="Building Services"> Building Services (Plumming & Electrical)</label> <br>
                        <label id="checkbox"><input type="radio" name="subject[]" value="Business"> Business</label> <br>
                        <label id="checkbox"><input type="radio" name="subject[]" value="Catering & Hospitality"> Catering & Hospitality</label> <br>
                    </div>
                    <div class="col-md-2">
                        <label id="checkbox"><input type="radio" name="subject[]" value="Childhood Education"> Childhood Education</label>
                        <label id="checkbox"><input type="radio" name="subject[]" value="Construction Crafts (Bricklaying & Woodwork)"> Construction Crafts (Bricklaying & Woodwork)</label> <br>
                        <label id="checkbox"><input type="radio" name="subject[]" value="Drama & Dance"> Drama & Dance</label> <br>
                        <label id="checkbox"><input type="radio" name="subject[]" value="Engineering"> Engineering</label> <br>
                        <label id="checkbox"><input type="radio" name="subject[]" value="Hairdressing"> Hairdressing</label> <br>
                        <label id="checkbox"><input type="radio" name="subject[]" value="Health & Social Care"> Health & Social Care</label> <br>
                        <label id="checkbox"><input type="radio" name="subject[]" value="Media & Game Design"> Media & Game Design</label> <br>
                    </div>
                    <div class="col-md-2">
                        <label id="checkbox"><input type="radio" name="subject[]" value="Motor Vehicle"> Motor Vehicle</label> <br>
                        <label id="checkbox"><input type="radio" name="subject[]" value="Music"> Music</label> <br>
                        <label id="checkbox"><input type="radio" name="subject[]" value="Public Services"> Public Services</label> <br>
                        <label id="checkbox"><input type="radio" name="subject[]" value="Science & Medical"> Science & Medical</label> <br>
                        <label id="checkbox"><input type="radio" name="subject[]" value="Sport & Leisure"> Sport & Leisure</label> <br>
                        <label id="checkbox"><input type="radio" name="subject[]" value="Supported Learning"> Supported Learning</label>
                        <label id="checkbox"><input type="radio" name="subject[]" value="Travel & Tourism"> Travel & Tourism</label> <br>
                    </div>
                    <div class="col-md-2">
                        <label id="checkbox"><input type="radio" name="subject[]" value="GCSE (English, Maths)"> GCSE (English, Maths)</label> <br>
                        <label id="checkbox"><input type="radio" name="subject[]" value="Higher Education"> Higher Education</label> <br>
                        <label id="checkbox"><input type="radio" name="subject[]" value="Access to Higher Education"> Access to Higher Education</label> <br>
                        <label id="checkbox"><input type="radio" name="subject[]" value="Professional Development (Teaching, Accounting, ETC)"> Professional Development (Teaching, Accounting, ETC)</label>
                    </div>
                    <div class="col-md-2">
                        <label id="checkbox"><input type="radio" name="subject[]" value="Sheppey - Beauty Therapy"> Sheppey - Beauty Therapy</label> <br>
                        <label id="checkbox"><input type="radio" name="subject[]" value="Sheppey - Business, Administration, Computing & IT"> Sheppey - Business, Administration, Computing & IT</label> <br>
                        <label id="checkbox"><input type="radio" name="subject[]" value="Sheppey - Construction"> Sheppey - Construction</label> <br>
                        <label id="checkbox"><input type="radio" name="subject[]" value="Sheppey - Hairdressing"> Sheppey - Hairdressing</label> <br>
                        <label id="checkbox"><input type="radio" name="subject[]" value="Sheppey - Independent Learning & Leisure"> Sheppey - Independent Learning & Leisure</label>
                    </div>
                </div> <br>
                <div class="row">
                    <div class="col-md-5" style=" margin: 0 -15px 0 15px !important; border: 1px solid #ccc; border-radius: 3px; -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075); box-shadow: inset 0 1px 1px rgba(0,0,0,.075);">
                        <label id="checkbox"><input type="radio" value="subject[]" style="margin-top: 10px;"> Undecided</label>
                    </div>
                </div>
            </div> <br>
            <div class="form-group">
                <label>How did you hear about Open Day?</label>
                <div class="row">
                    <div class="col-md-2">
                        <label id="checkbox"><input type="checkbox" name="hear[]" value="Parent/guardian"> Parent/guardian</label> <br>
                        <label id="checkbox"><input type="checkbox" name="hear[]" value="Brother/Sister"> Brother/Sister</label> <br>
                        <label id="checkbox"><input type="checkbox" name="hear[]" value="Friend"> Friend</label> <br>
                    </div>
                    <div class="col-md-2">
                        <label id="checkbox"><input type="checkbox" name="hear[]" value="Careers Advisor"> Careers Advisor</label> <br>
                        <label id="checkbox"><input type="checkbox" name="hear[]" value="School"> School</label> <br>
                        <label id="checkbox"><input type="checkbox" name="hear[]" value="Course guide"> Course guide</label> <br>
                        <label id="checkbox"><input type="checkbox" name="hear[]" value="UCAS Progress (Kent Choices 4 U)"> UCAS Progress (Kent Choices 4 U)</label> <br>
                        <label id="checkbox"><input type="checkbox" name="hear[]" value="Events"> Event</label>
                    </div>
                    <div class="col-md-2">
                        <label id="checkbox"><input type="checkbox" name="hear[]" value="College website"> College website</label> <br>
                        <label id="checkbox"><input type="checkbox" name="hear[]" value="Facebook"> Facebook</label> <br>
                        <label id="checkbox"><input type="checkbox" name="hear[]" value="Twitter"> Twitter</label> <br>
                        <label id="checkbox"><input type="checkbox" name="hear[]" value="Instagram"> Instagram</label> <br>
                        <label id="checkbox"><input type="checkbox" name="hear[]" value="Web advert"> Web advert</label>
                    </div>
                    <div class="col-md-2">
                        <label id="checkbox"><input type="checkbox" name="hear[]" value="Item through door"> Item through door</label> <br>
                        <label id="checkbox"><input type="checkbox" name="hear[]" value="Newspaper"> Newspaper</label> <br>
                        <label id="checkbox"><input type="checkbox" name="hear[]" value="Radio"> Radio</label> <br>
                        <label id="checkbox"><input type="checkbox" name="hear[]" value="TV"> TV</label> <br>
                    </div>
                </div>
            </div> <br>
            <div class="form-group">
                <label>What year are you looking to start College?</label>
                <div class="row">
                    <div class="col-md-1">
                        <label id="checkbox"><input type="radio" name="year" value="<?= date("Y") ?>"> <?= date("Y") ?></label>
                    </div>
                    <div class="col-md-1">
                        <label id="checkbox"><input type="radio" name="year" value="<?= date("Y", strtotime('+1 year')) ?>"> <?= date("Y", strtotime('+1 year')) ?></label>
                    </div>
                    <div class="col-md-1">
                        <label id="checkbox"><input type="radio" name="year" value="<?= date("Y", strtotime('+2 year')) ?>"> <?= date("Y", strtotime('+2 year')) ?></label>
                    </div>
                    <div class="col-md-1">
                        <label id="checkbox"><input type="radio" name="year" value="<?= date("Y", strtotime('+3 year')) ?>"> <?= date("Y", strtotime('+3 year')) ?></label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-default" value="Post">
                <input type="reset" class="btn btn-default" value="Reset Form">
            </div>
            </form>
        </div> <!-- END col-lg-12 -->
    </div> <!-- END row -->
</div> <!-- END container-fluid -->