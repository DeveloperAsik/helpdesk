<?php if ($this->session->flashdata()): ?>
    <div id="flashmessage" onclick="rm()" style="position: fixed; bottom: 0px; left:0px; z-index:9999; width: 100%; height:60px; background-color:orange; color:#fff;" title="Klik di sekitar area slide loading untuk menutup bagian ini...">
        <center>
            <?php echo ($this->session->flashdata('success') ) ? $this->session->flashdata('success') : ''; ?>
            <?php echo ($this->session->flashdata('error') ) ? $this->session->flashdata('error') : ''; ?>
            <?php echo ($this->session->flashdata('message') ) ? $this->session->flashdata('message') : ''; ?>
        </center>
    </div>
    <style>
        #loading_message{ width: 20%; height: 5px; box-shadow:0px 5px 5px black; border:1px dotted #fff; position: relative; -webkit-animation: mymove 5s infinite;  /* Chrome, Safari, Opera */ -webkit-animation-timing-function: linear;  /* Chrome, Safari, Opera */ animation: mymove 5s infinite; animation-timing-function: linear; }
        /* Chrome, Safari, Opera */
        @-webkit-keyframes mymove { from {left: 0%;} to {left: 100%;} }
        @keyframes mymove { from {left: 0%;} to {left: 100%;} }
    </style>
    <script>
        function rm() {
            $("#flashmessage").remove()
        }
        setTimeout(function () {
            $('#flashmessage').fadeOut('slow');
        }, 4900);
    </script>
<?php endif; ?>