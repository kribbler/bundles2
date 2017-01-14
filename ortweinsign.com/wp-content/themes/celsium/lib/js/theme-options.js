jQuery(document).ready(function($){

    $('#afl-tab-fonts a.afl-font-add').live('click', function(e){
        e.preventDefault();
        var parent = $(this).parents('.afl-single-set:first');
        parent.after(parent.clone(false, false));
        var next = parent.next();
        parent.find('a.afl-font-add').unbind('click').removeClass('afl-font-add').removeClass('afl-clone-set').addClass('afl-font-delete').addClass('afl-remove-set').html('Delete');
        next.find('.afl-select-fake-val').css({'color' : '#000000'});
        var re = /\d+/;
        var new_id = '';

        next.find(':text, select').each(function(){
            var name = $(this).attr('name');
            id = $(this).attr('id');
            $(this).attr('name', name.replace(re, parseInt(re.exec(name))+1));
            new_id = $(this).attr('id', id.replace(re, parseInt(re.exec(id))+1));
            if(name.indexOf('color')!= -1){
                $(this).val('#000000');
            }
            else{
                $(this).val('');
            }
        });
        $('.afl-colorpicker-style-wrap').afl_color_picker_activation();
    });
});