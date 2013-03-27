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
                
            uploader.bind('Error', function(up, err) {
               $('#filelist').append("<li>Error: " + err.code + ", Message: " + err.message + (err.file ? ", File: " + err.file.name : "") +"</li>");
               up.refresh(); // Reposition Flash/Silverlight
            });
            uploader.bind('FileUploaded', function(up, file, info) {

                console.log(info);
                var data = $.parseJSON(info.response);
                console.log(data);
                var newForm = $(el).attr('data-prototype').replace(/__name__/g, file.id);    
                $(el).append(newForm);
    
                $("#"+$(el).attr('id')+"_"+file.id+"_image").val(file.id);    
                $("#"+$(el).attr('id')+"_"+file.id+"_image").parent().append('<img src="'+data.result.web+'" />');    

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
