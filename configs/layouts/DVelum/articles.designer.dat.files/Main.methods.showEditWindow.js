var win = Ext.create("appDvelumArticlesComponents.editWindow", {
  dataItemId:id,
  canDelete:this.canDelete,
  canPublish:this.canPublish,
  canEdit:this.canEdit
});

win.on("dataSaved",function(){
  this.childObjects.draftView.getStore().load();
  this.childObjects.publishedView.getStore().load();
},this);

win.show();