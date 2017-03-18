<div class="toolbar">
    <ul>
        <li onclick="goBack()" id="back"><a href=""><i class="fa fa-chevron-left fa-lg"></i>  Go Back</a></li>
        <script>
            function goBack() {
                window.history.back();
            }
        </script>
        <li><a href="<?= base_url('computing-support')?>"><i class="fa fa-desktop" aria-hidden="true"></i>  Computing Support</a></li>