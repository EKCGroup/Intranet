<div class="toolbar">
    <ul>
        <li onclick="goBack()" id="back"><a href=""><i class="fa fa-chevron-left fa-lg"></i>  Go Back</a></li>
        <script>
            function goBack() {
                window.history.back();
            }
        </script>
        <li><a href="<?= base_url('human-resources')?>"><i class="fa fa-user" aria-hidden="true"></i>  Human Resources</a></li>