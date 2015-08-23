window.addEvent('domready', function(){
    if(document.id('page_text'))
        CKEDITOR.replace('page_text', CKEditorOptionsFull);

    if(document.id('movable_list'))
    {
        new Tree('movable_list', {
            onChange: function(){
                var IDs = JSON.encode(this.serialize(function(el){
                    var ID = el.get('id').split('_');
                    return ID[ID.length - 1];
                }));

                new Request.JSON({
                    url: '/admin/pages/order.json',
                    data: 'order=' + IDs,
                    onSuccess: function(J){
                        new MooDialog.Alert(J.message);
                    }
                }).send();
            }
        });

        new Collapse('movable_list', {
            selector: 'a.mover'
        });
    }
});