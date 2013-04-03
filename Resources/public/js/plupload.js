MediaCollectionPlupload = Backbone.Model.extend({  
    
    el: '.plupload',  

    initialize: function (options) { 

          
          $(this.el).each(function() {
              
              var el = this;
              var uploader = new plupload.Uploader({
                   runtimes : 'html5,flash',
                    browse_button : $(this).attr('data-picker'),
                    container: $(el).attr('id'),
                    max_file_size : '10mb',
                    url : $(this).attr('data-upload'),
                    resize : {width : 1024, height : 768, quality : 90},
                    flash_swf_url : '../js/plupload.flash.swf',
                    silverlight_xap_url : '../js/plupload.silverlight.xap',
                    filters : [
                            {title : "Image files", extensions : "jpg,gif,png"},
                            {title : "Zip files", extensions : "zip"}
                    ] 
                });
                uploader.bind('Init', function(up, params) { console.log ("Current runtime: " + params.runtime); });          
                uploader.bind('FilesAdded', function(up, files) {
                    for (var i in files) {
                        $("#"+$(el).attr('id')+'_uploader_list').append('<li id="' + files[i].id + '">' + files[i].name + ' (' + plupload.formatSize(files[i].size) + ') <b></b></li>');
                    }
                });
                
            uploader.bind('BeforeUpload', function(up, file) {
                up.settings.multipart_params = {"fileid": file.id };
            });                
            uploader.bind('Error', function(up, err) {
               $("#"+$(el).attr('id')+'_uploader_list').append("<li>Error: " + err.code + ", Message: " + err.message + (err.file ? ", File: " + err.file.name : "") +"</li>");
               up.refresh(); // Reposition Flash/Silverlight
            });
            uploader.bind('FileUploaded', function(up, file, info) {

                var data = $.parseJSON(info.response);
                var newForm = $(el).attr('data-prototype').replace(/__image__/g, file.id);    
                $(el).append(newForm);

                $("#"+$(el).attr('id')+"_"+file.id+"_image").val(data.result.id); 

                
                //$("#"+$(el).attr('id')+"_"+file.id+"_image_path").val(data.result.path);    
                $("#"+$(el).attr('id')+"_"+file.id+"_"+$(el).attr('data-field')+"_media_src").attr('src', data.result.web);

                $('#' + file.id ).remove();
            });
                
                $("#"+$(el).attr('id')+'_uploadfiles').click(function(e){
                    e.preventDefault();
                    uploader.start();
                 });
                uploader.init();
          })
    }
        
});
