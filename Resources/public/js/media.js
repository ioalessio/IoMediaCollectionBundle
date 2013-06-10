(function($){
 
  var __uploader = function() {
 
        var el = $(this);
       
      
        var uploader = new plupload.Uploader({
             runtimes : 'html5,flash',
             browse_button : el.attr('id')+'_browse',
             container: el.attr('id')+'_plupload',
             max_file_size : '10mb',
             url : el.attr('data-upload'),             
             flash_swf_url : '../js/plupload.flash.swf',
             silverlight_xap_url : '../js/plupload.silverlight.xap',
             filters : [
                      {title : "Image files", extensions : "jpg,gif,png"}
             ],
             resize : {width : 1024, height : 768, quality : 90},
                                
        });
        //init plupload
        uploader.init();        
        //bind add file event
        uploader.bind('FilesAdded', function(up, files) {
            
            var maxfiles = 1;
            if(up.files.length > maxfiles ) {
                up.splice(maxfiles);
                alert('no more than '+maxfiles + ' file(s)');
            }

           /* $.each(files, function(i, file) {
                $("#"+$(el).attr('id')+'_upload_list').html('<li id="' + file.id + '">' + file.name + ' (' + plupload.formatSize(file.size) + ') <b></b></li>');
            });*/
            up.refresh(); 
            //automatic upload
            up.start();            
            $.each(files, function(i, file) {
                uploader.removeFile(file);
            });            
        });
        uploader.bind('BeforeUpload', function(up, file) {
            up.settings.multipart_params = {"fileid": file.id };
        });
    
        $("#"+$(el).attr('id')+'_remove').click(function(e){
            e.preventDefault();
            $("#"+$(el).attr('id')+'_notify').html('<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert">×</button>Image will be deleted </div>');
            
                $("#"+$(el).attr('id')+"_upload").val('');   
            

        });      

        $("#"+$(el).attr('id')+'_undo').click(function(e){

        });    


        $("#"+$(el).attr('id')+'_upload').click(function(e){
            e.preventDefault();
            uploader.start();
        });

        uploader.bind('Error', function(up, err) {
           $("#"+$(el).attr('id')+'_notify').html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">×</button>Error: ' + err.code + ', Message: ' + err.message + (err.file ? ', File: ' + err.file.name : '') + '</div>');
           up.refresh();
        });
        uploader.bind('FileUploaded', function(up, file, info) {

           //$("#"+$(el).attr('id')+'_notify').html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button>OK</div>');

                var data = $.parseJSON(info.response);
    
                //$("#"+$(el).attr('id')+"_embed").html( el.attr('data-prototype') );
                $("#"+$(el).attr('id')+"_upload").val(data.result.id);    
                $("#"+$(el).attr('id')+"_image").attr('src', data.result.image);            
        });


  };
 
  $.fn.uploader = function() {
    $(this).each(__uploader);
    return this;
  };
 
})(jQuery);


$(function() {
    $('.io_media_upload').uploader();
});



 /*


           
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
*/