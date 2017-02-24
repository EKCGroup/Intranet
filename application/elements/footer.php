<?php defined('C5_EXECUTE') or defined('BASEPATH') or die("Access Denied."); ?>

            <footer>
                <?php if (isset($is_codeigniter)) { ?>

                    <p>Canterbury College was established in 1947 and is now one of the largest Further and Higher Education Colleges in the South East.</p>
                    <p>New Dover Road, Canterbury, Kent CT1 3AJ. Tel: +44 (0)1227 811111 | Copyright &copy; <?= date("Y"); ?> Canterbury College.</p>

                <?php /* END Codeigniter */ } else { /* IF Concrete5 */ ?>
                
                    <?php
                        $a = new GlobalArea('Global Footer'); $a->display($c);

                        $v = View::getInstance();
                        if ($v->getThemeHandle() == 'ccintranet') {
                            $a = new GlobalArea('CC Footer'); $a->display($c);
                        } elseif ($v->getThemeHandle() == 'ekcintranet') {
                            $a = new GlobalArea('EKC Footer'); $a->display($c);
                        }
                    ?>
                
                <?php /* END Concrete5*/ } ?>

            </footer>
        </div> <!-- END page-wrapper -->
    </div> <!-- END wrapper -->
    
    <?php if (isset($is_codeigniter)) { ?>
    
        <!-- Jquery Order Matters -->
        <script type="text/javascript" src="/concrete/js/jquery-ui.js"></script>

    <?php /* END Codeigniter Header */ } else { ?>
                
        <?php Loader::element('footer_required'); ?>   
    
    <?php /* END Concrete Header */ } ?>

    <!-- Jquery Order Matters -->
    <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/metisMenu/2.6.2/metisMenu.min.js"></script>
    <script type="text/javascript" src="/application/themes/ccintranet/assets/vendor/sorttable-2.0.0/sorttable.min.js"></script>
    <script type="text/javascript" src="/application/themes/ccintranet/assets/js/main.js"></script>
    
</body>
</html>