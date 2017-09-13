        <footer class="section section-primary">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6">
                        <h1>Estefan Bombonato Photography.</h1>
                        <p>Fotógrafia de casamento, pré wedding, trash the dress, ensaios, aniversários.
                            <br>© <?=date("Y");?> Todos os direitos reservados.</p>
                    </div>
                    <div class="col-sm-6">
                        <p class="text-info text-right">
                            <br>
                            <br>
                        </p>
                        <div class="row">
                            <div class="col-md-12 hidden-lg hidden-md hidden-sm text-left">
                            	<img src="/public/images/inspiration-member.png" alt="Inspiration Member " style="max-height: 110px; margin-top: -20px; margin-right: 50px;">
                                <?php if($modelo->config['facebook']){?><a href="<?=$modelo->config['facebook'];?>" target="_blank"><i class="fa fa-3x fa-fw fa-facebook text-inverse"></i></a><?Php }?>
                                <?php if($modelo->config['youtube']){?><a href="<?=$modelo->config['youtube'];?>" target="_blank"><i class="fa fa-3x fa-fw fa-youtube text-inverse"></i></a><?Php }?>
                                <?php if($modelo->config['twitter']){?><a href="<?=$modelo->config['twitter'];?>" target="_blank"><i class="fa fa-3x fa-fw fa-twitter text-inverse"></i></a><?Php }?>                             
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 hidden-xs text-right">
                            	<img src="/public/images/inspiration-member.png" alt="Inspiration Member " style="max-height: 110px; margin-top: -20px; margin-right: 50px;">
                                <?php if($modelo->config['facebook']){?><a href="<?=$modelo->config['facebook'];?>" target="_blank"><i class="fa fa-3x fa-fw fa-facebook text-inverse"></i></a><?Php }?>
                                <?php if($modelo->config['youtube']){?><a href="<?=$modelo->config['youtube'];?>" target="_blank"><i class="fa fa-3x fa-fw fa-youtube text-inverse"></i></a><?Php }?>
                                <?php if($modelo->config['twitter']){?><a href="<?=$modelo->config['twitter'];?>" target="_blank"><i class="fa fa-3x fa-fw fa-twitter text-inverse"></i></a><?Php }?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <p class="text-muted text-right maxwill">Desenvolvido por:
                                <a href="www.maxwill.com.br" target="_blank"><img src="<?=HOME_URI;?>public/images/maxwill.png" class="img-responsive pull-right"></a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>

<!--[if lt IE 9]>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <![endif]-->
    <!--[if (gte IE 9) | (!IE)]><!-->
     <script src="<?=HOME_URI;?>public/scripts/jquery.min.js"></script>
    <!--<![endif]-->
		<script src="<?=HOME_URI;?>public/scripts/bootstrap.min.js"></script>
		 <script src="<?=HOME_URI;?>public/scripts/jquery.easing.1.3.js"></script>
        <script src="<?=HOME_URI;?>public/scripts/jquery.animate-enhanced.min.js"></script>
        <script src="<?=HOME_URI;?>public/scripts/contact-form.js"></script>
		<script type="text/javascript">
$(document).ready(function() {
		$("#home").css("margin-top",$('.navbar').height());
		//$("#home").css("height",$(window).height()-$('.navbar').height());
	

        $('#form-contact').submit(function(e){
           $('#send-form').attr('disabled','disabled');
            var dados = $(this).serialize();
            var method = $(this).attr('method');
            var action = $(this).attr('action');

            $.ajax({
                type: method,
                url: action,
                data: dados,
                dataType: 'json'
            }).done(function(response){
              $('#form-msg').html(response.msg);
            }).fail(function(){
                 $('#form-msg').html( "ERRO ao enviar dados. Tente novamente ou contacte o administrador do sistema.");
            });
            $('#send-form').removeAttr('disabled');
            e.preventDefault();

             
        })


      



				$('a.scroll').on('click',function (e) {
           var link = $(this).attr('href').split('#');
           if(link[0]==window.location.pathname || link[0]+'index'==window.location.pathname || link[0]+'index/'==window.location.pathname){
              e.preventDefault ();
                     
          }
            var target = this.hash,
              $target = $(target);     
              var until =  $target.offset().top-85;  
              $('html, body').stop().animate ({
                'scrollTop': until
              }, 2000, 'swing', function () {
              });    					
				});
			
				
        $('.item').css("max-height",484);
        

			});			

var topMenu = $(".nav"),
    topMenuHeight = topMenu.outerHeight()+($(window).height()*30/100),
    // All list items
    menuItems = topMenu.find("a.scroll"),
    // Anchors corresponding to menu items
    scrollItems = menuItems.map(function(){
      var item = $($(this).attr("href").substring(6));
	 //alert(item.offset().top);
	  //alert($('#about').offset().top); //441
      if (item.length) { return item; }
    });	
			
$(window).scroll(function() {    
   var fromTop = $(this).scrollTop()+topMenuHeight;

   if($(this).scrollTop()>0){
      $(".navbar").removeClass("big").addClass("mini");

   }else{
      $(".navbar").removeClass("mini").addClass("big");
   }

   // Get id of current scroll item
   var cur = scrollItems.map(function(){
     if ($(this).offset().top < fromTop)
       return this;
   });
   // Get the id of the current element
   cur = cur[cur.length-1];
   var id = cur && cur.length ? cur[0].id : "";
   // Set/remove active class
   menuItems
     .parent().removeClass("active")
     .end().filter("[href='#"+id+"']").parent().addClass("active");
});			
		

		</script>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
  ga('create', 'UA-13206210-9', 'auto');
  ga('require', 'displayfeatures');  
  ga('send', 'pageview');
</script>
	</body>
</html>