
    <footer class="col-md-offset-2 col-md-10">
    </footer>
    <!--[if lt IE 9]>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <![endif]-->
    <!--[if (gte IE 9) | (!IE)]><!-->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
    <!--<![endif]-->
<script type="text/javascript" src="<?=HOME_URI;?>public/plugins/Jcrop/js/jquery.Jcrop.js"></script>      
    <script src="<?=HOME_URI;?>public/scripts/bootstrap.min.js"></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/2.9.0/moment.min.js"></script>    
    <script type="text/javascript" src="<?=HOME_URI;?>public/plugins/bootstrap-daterangepicker-master/daterangepicker.js"></script>
    <script type="text/javascript" src="<?=HOME_URI;?>public/plugins/iCheck/icheck.min.js"></script>
    <script type="text/javascript" src="<?=HOME_URI;?>public/plugins/bootstrap-filestyle-master/src/bootstrap-filestyle.js"></script>
    <script type="text/javascript" src="<?=HOME_URI;?>public/plugins/Simple-Ajax-Uploader-master/SimpleAjaxUploader.js"></script>
    <script type="text/javascript" src="<?=HOME_URI;?>public/plugins/fancyapps-fancyBox/lib/jquery.mousewheel-3.0.6.pack.js"></script>
    <script type="text/javascript" src="<?=HOME_URI;?>public/plugins/fancyapps-fancyBox/source/jquery.fancybox.pack.js?v=2.1.5"></script>
    <script type="text/javascript" src="<?=HOME_URI;?>public/plugins/fancyapps-fancyBox/source/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>
    <script type="text/javascript" src="<?=HOME_URI;?>public/plugins/fancyapps-fancyBox/source/helpers/jquery.fancybox-media.js?v=1.0.6"></script>
    <script type="text/javascript" src="<?=HOME_URI;?>public/plugins/fancyapps-fancyBox/source/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>
    <script type='text/javascript' src="<?=HOME_URI;?>public/plugins/jquery-sortable.js"></script> 
         
    <script type="text/javascript">
      $(function () {
          $('a.changestatus').click(function( e ) {
            e.preventDefault();
            var i = $(this).children();
            var url = $(this).attr('href');
            var data = {id: $(this).attr('data-id')};
             $.ajax({
                 type: "POST",
                 url: url,
                 data: data,
                 dataType: 'json'
                 
                 })  
                .done(function(response) {
                    if(response.success){
                      $(i).toggleClass('on');
                      $(i).toggleClass('off');
                    }else{
                      alert( "ERRO ao atualizar. Tente novamente ou contacte o administrador do sistema.");
                    }
                       
                  })
                  .fail(function(jqXHR, textStatus, errorThrown) {
                    alert( "ERRO ao enviar dados. Tente novamente ou contacte o administrador do sistema.");
                  })
                  .always(function() {
                    //alert( "finished" );
                }); 

          });

          $('a.removeImg').click(function( e ){
              e.preventDefault();
              if(confirm('Tem certeza que deseja remover a imagem?')){
                var url = $(this).attr('href');
                var img = '#img'+$(this).attr('data-id');
                var data = {id: $(this).attr('data-id')};
                $.ajax({
                    type: "POST",
                    url: url,
                    data: data,
                    dataType: 'json'
                }).done(function(response){
                    if(response.success){
                      $(img).fadeOut();
                    }else{
                      alert( "ERRO ao remover imagem." );
                    }
                }).fail(function(){
                    alert( "ERRO ao enviar dados. Tente novamente ou contacte o administrador do sistema.");
                })
              }
          });


          $('input').iCheck({
              checkboxClass: 'icheckbox_square-blue',
              radioClass: 'iradio_square-blue',
              increaseArea: '20%' // optional
          });
          $('input[name="daterange"]').daterangepicker(
          {
              format: 'DD/MM/YYYY',
              startDate: moment(),
              endDate: moment().add(1, 'month'),
              ranges: {
                 'Hoje': [moment(), moment()],
                 'Amanhã': [moment().add(1, 'days'), moment().add(1, 'days')],
                 'Próximos 7 Dias': [moment(), moment().add(6, 'days')],
                 'Próximos 30 Dias': [moment(), moment().add(29, 'days')],
                 'Este Mês': [moment().startOf('month'), moment().endOf('month')],
                 'Próximo Mês': [moment().add(1, 'month').startOf('month'), moment().add(1, 'month').endOf('month')]
              },
              separator: ' até ',
              locale: {
                  applyLabel: 'Aplicar',
                  cancelLabel: 'Cancelar',
                  fromLabel: 'De',
                  toLabel: 'Até',
                  customRangeLabel: 'Personalizado',
                  daysOfWeek: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex','Sab'],
                  monthNames: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
                  firstDay: 1
              }

          });
          $('[data-toggle="tooltip"]').tooltip();
          $(".fancybox-thumb").fancybox({
                prevEffect  : 'none',
                nextEffect  : 'none',
                helpers : {
                  title : {
                    type: 'outside'
                  },
                  thumbs  : {
                    width : 50,
                    height  : 50
                  }
              }
          });
          $('#cropbox').Jcrop({
                aspectRatio:  parseInt($("#targ_w").val()) / parseInt($("#targ_h").val()),
                minSize: [ parseInt($("#targ_w").val()),parseInt($("#targ_h").val())],
                onSelect: updateCoords
            });          

       





          // Sortable rows
          var group = $('.sorted').sortable({
            group: 'sorted',
            containerSelector: 'ul',
            itemSelector: 'li',
            handle: '.move',
            onDrop: function (item, container, _super) {
              var data = group.sortable("serialize").get();

              var jsonString = JSON.stringify(data, null, ' ');
              var url = $('.sorted').attr("data-url");

            //alert(jsonString);
              $('#serialize_output2').text(jsonString);

              $.post(url, {data:jsonString}, 
               function(data){
                console.log(data);
                // if(data){
                //  alert('Ordem alterada com sucesso.');
             //   alert(data.lista); // John
                //}
              }, "json"
            );
              _super(item, container)
            }
          })
      });

      function updateCoords(c)
      {
        $('#x').val(c.x);
        $('#y').val(c.y);
        $('#w').val(c.w);
        $('#h').val(c.h);
      };
      function checkCoords()
      {
        if (parseInt($('#w').val())) return true;
        alert('Por favor, selecione a área de corte e clique em salvar.');
        return false;
      };
    </script>	
  </body>
</html>
