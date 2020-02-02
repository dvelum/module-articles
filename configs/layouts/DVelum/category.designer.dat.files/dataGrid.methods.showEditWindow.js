
        var win = Ext.create("appDvelumArticleCategoryComponents.editWindow", {
                  dataItemId:id,
                  canDelete:this.canDelete,
                  canPublish:this.canPublish,canEdit:this.canEdit
            });

            win.on("dataSaved",function(){
                this.getStore().load();
              },this);

            win.show();
    