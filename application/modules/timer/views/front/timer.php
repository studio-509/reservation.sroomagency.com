<?php $this->load->view('/front/head', $this->data); ?>

<div id="bloc_timer">
    <div id="countdown-wrapper"><div id="countdown"></div></div>
    <?php
        $now = time();
        $diff = 3600;
        $auto_start = 'false';
        if($salle->starter != '' && $salle->pause == 0):
            $diff = ($salle->starter + $diff) - $now;
            $auto_start = 'true';
        elseif($salle->starter != '' && $salle->pause != 0):
            $new = $salle->starter + ($now - $salle->pause);
            $diff = ($new + $diff) - $now;
            $auto_start = 'false';
        endif;
    ?>

    <div id="bloc_message">
    	<div class="content typewriter">
        <?=$salle->affiche?><span class="affiche_cursor white"> |</span>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('#countdown').timeTo({
        start: <?=$auto_start?>,
        theme: "black",
        fontSize: 140,
        countdownAlertLimit: 180
        },
        <?=$diff?>,
        function(){
            $(".typewriter").html("C'est terminé !!!");
        }
    );

    $.fn.typewriter = function(opt,callback) {
        var i=0;
        var typeone = function(self, text, content) {
            if (text.length > 0) {
                i=i+1;
                var next = text.match(/(\s*(<[^>]*>)?)*(&.*?;|.?)/)[0];
                text = text.substr(next.length);
                $(self).html(content+next);
                setTimeout(function(){
                    typeone(self, text, content+next);
                }, opt['delay']);
                if(text.length==0) if (callback!=null) callback();
            }
        }
        this.each(function() {
            opt = opt || { 'delay': 150 };
            typeone(this, $(this).html(), '');
        });
        return this;
    }

    var clignotement = function(){
        if ($(".affiche_cursor").hasClass("white") === true)
            $(".affiche_cursor").removeClass("white").addClass("black");
        else
            $(".affiche_cursor").removeClass("black").addClass("white");
    }

    $(".typewriter").typewriter();
    setInterval(function(){
        clignotement();
    }, 200);

    setInterval(function(){
        jQuery.ajax({
            type: 'POST',
            url: '/timer/Timer/test',
            data: {
                id: <?=$salle->id?>
            },
            success: function(data, textStatus, jqXHR) {
                if(data == 1)
                    window.location.reload(1);
                else if(data == 2){
                    $('#countdown').timeTo({
                        start: false,
                        theme: "black",
                        fontSize: 140,
                        countdownAlertLimit: 180
                        },
                        3600,
                        function(){}
                        );
                    $('#bloc_message').html();
                    }
                },
            error: function(jqXHR, textStatus, errorThrown) {
                alert("error");
            }
        });
    }, 3000);
</script>

<?php $this->load->view('/front/footer'); ?>
