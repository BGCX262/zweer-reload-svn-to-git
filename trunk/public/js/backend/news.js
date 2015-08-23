window.addEvent('domready', function(){
    if(document.id('news_text'))
        CKEDITOR.replace('news_text', CKEditorOptionsFull);

    if(document.id('movable_children_list'))
    {
        new Tree('movable_children_list', {
            checkDrag: function(element){
                return element.hasClass('movable_children_list_child');
            },
            checkDrop: function(element, dropOptions){
                var isSubnode = element.hasClass('movable_children_list_parent') && dropOptions.isSubnode;
                var isSubnodeSiblin = element.hasClass('movable_children_list_child') && !dropOptions.isSubnode;
                var isDroppable = isSubnode || isSubnodeSiblin;

                return isDroppable;
            },

            onChange: function(){
                var ID = this.current.get('id').split('_'),
                    IDPage = this.current.getParent().getParent().get('id').split('_');
                ID = ID[ID.length - 1];
                IDPage = IDPage[IDPage.length - 1];

                new Request.JSON({
                    url: '/admin/news/parent.json',
                    data: 'news=' + ID + '&page=' + IDPage,
                    onSuccess: function(J){
                        new MooDialog.Alert(J.message);
                    }
                }).send();
            }
        });

        new Collapse('movable_children_list', {
            selector: 'a.mover'
        });
    }
});