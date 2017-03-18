<div class="toolbar">
    <ul>
        <li onclick="goBack()" id="back"><a href=""><i class="fa fa-chevron-left fa-lg"></i>  Go Back</a></li>
        <li><a href="/"><i class="fa fa-arrow-left fa-lg"></i>  Back to Intranet</a></li>
        <li><a href="<?= base_url('computing-support')?>"><i class="fa fa-desktop" aria-hidden="true"></i>  Computing Support</a></li>
        <li><a href="<?= base_url('human-resources')?>"><i class="fa fa-user" aria-hidden="true"></i>  Human Resources</a></li>
        <li><a href="<?= base_url('marketing')?>"><i class="fa fa-comments-o" aria-hidden="true"></i>  Marketing</a></li>
    </ul>
</div>
<script>
    function goBack() {
        window.history.back();
    }
</script>