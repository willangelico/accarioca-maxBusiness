<script type="text/javascript" src="<?=HOME_URI;?>public/plugins/Simple-Ajax-Uploader-master/SimpleAjaxUploader.js"></script>
<script type="text/javascript">
      $(function () {
          var btn = document.getElementById('upload-btn'),
              wrap = document.getElementById('pic-progress-wrap'),
              //picBox = document.getElementById('picbox'),
              errBox = document.getElementById('errormsg');

              picBox = $("#picbox");
            
                var uploader = new ss.SimpleUpload({
                      button: btn,
                      url: '/admin/galleries/uploadfotos',
                      progressUrl: '/public/plugins/Simple-Ajax-Uploader-master/extras/uploadProgress.php',
                      name: 'imgfile',
                      multiple: true,
                      //maxUploads: 2,
                      maxSize: 5000,
                      queue: true,
                      allowedExtensions: ['jpg', 'jpeg', 'png', 'gif'],
                      accept: 'image/*',
                      debug: true,
                      hoverClass: 'btn-hover',
                      focusClass: 'active',
                      disabledClass: 'disabled',
                      responseType: 'json',
                      onSubmit: function(filename, ext) {            
                         var prog = document.createElement('div'),
                             outer = document.createElement('div'),
                             bar = document.createElement('div'),
                             size = document.createElement('div'),
                             self = this;     
                  
                          prog.className = 'prog';
                          size.className = 'size';
                          outer.className = 'progress';
                          bar.className = 'bar';
                          
                          outer.appendChild(bar);
                          prog.appendChild(size);
                          prog.appendChild(outer);
                          wrap.appendChild(prog); // 'wrap' is an element on the page
                          
                          self.setProgressBar(bar);
                          self.setProgressContainer(prog);
                          self.setFileSizeBox(size);                
                          
                          errBox.innerHTML = '';
                          btn.value = 'Escolha outras fotos';
                        },        
                        onSizeError: function() {
                              errBox.innerHTML = 'Arquivos não podem exceder 5MB.';
                        },
                        onExtError: function() {
                            errBox.innerHTML = 'Tipo de arquivo inválido. Por favor selecione arquivos PNG, JPG, GIF image.';
                        },
                      onComplete: function(file, response) {            
                          if (!response) {
                            errBox.innerHTML = 'Erro ao fazer o upload';
                          }     
                          if (response.success === true) {
                              $("#picbox h3").html('Fotos adicionadas');
                              $("#picbox span").html('Não esqueça de salvar');
                             picBox.append('<img src="/public/files/images/galerias/' + response.file + '"  width="100">');
                             picBox.append('<input type="hidden" name="img_src[]" value="' +response.file+ '" />');
                          } else {
                            if (response.msg)  {
                              errBox.innerHTML = response.msg;
                            } else {
                              errBox.innerHTML = 'Erro ao fazer o upload';
                            }
                          }            
                          
                        }
                  });
          });
</script>