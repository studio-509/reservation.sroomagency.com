<?php $this->load->view('/front/head'); ?>

<p  style="font-size:30px;">sélectionnez votre salle :</p>
<ul style="position:absolute;z-index:100">
    <?php foreach($salles as $salle): ?>
        <li>
            <a data-id="<?=$salle->id?>" class="_newPage" style="font-size:30px; line-height:35px;cursor:pointer"><?=$salle->nom?></a>
        </li>
    <?php endforeach; ?>
</ul>
<script type="text/javascript">
    $('body').ready(function(){
        $("._newPage").click(function(){alert('ok');
            var id = $(this).attr('data-id');
            window.open("/timer/salle/" + id, "POP_UP", "width="+screen.width
     +",height="+screen.height+",menubar='no',toolbar='no',location='no',status='no',scrollbars=0, titlebar='no'");
        });
    });
</script>

<?php $this->load->view('/front/footer'); ?>
