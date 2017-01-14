jQuery(document).ready(function($) {
    $('#afl-background-slides a.afl-social-add').bind('click', function(e){
        e.preventDefault();
        var parent = $(this).parents('.afl-single-set:first');
        parent.before(parent.clone(true)); console.log("yep");
        var prev = parent.prev();
        prev.find('a.afl-social-add').unbind('click').removeClass('afl-social-add').removeClass('afl-clone-set').addClass('afl-social-delete').addClass('afl-remove-set').html('Delete');


        parent.find(':text,:hidden').each(function(){
            //bind('change',function(){
            var re = /\d+/;
            var name = $(this).attr('name');
            var id = $(this).attr('id');
            $(this).attr('name', name.replace(re, parseInt(re.exec(name))+1));
            if(id != undefined){
                $(this).attr('id', id.replace(re, parseInt(re.exec(id))+1));
            }
            $(this).val('');
        });
        parent.find('img').remove();
        afl_uploader(prev.find('.afl-uploader'));
    });
});