<div id="countdown_<?=$salle?>"></div>
<script type="text/javascript">
    $('#countdown_<?=$salle?>').timeTo({
        start: <?=$auto_start?>,
        },
        <?=$diff?>,
        function(){
            var datas = {"titre":"Fin de partie","txt":"Fin de la partie sur salle <?=$infos->nom?>"};
            _inPop.open('/popin/confirm', datas, 'alerte', '_inPop.close()');
    });
</script>
