
/*
 * Here you can define application logic
 * To obtain info about current user access rights
 * you can use global scope JS vars canEdit , canDelete , canPublish
 * To access project elements, please use the namespace you defined in the config
 * For example: appDvelumArticleCategoryApplication.Panel or Ext.create("appDvelumArticleCategoryComponents.editWindow", {});
*/
Ext.onReady(function(){
  // Init permissions
  app.application.on("projectLoaded",function(module){
    if(Ext.isEmpty(module) || module === "Dvelum_Articles_Category"){
      if(!Ext.isEmpty(appDvelumArticleCategoryApplication.dataGrid)){
        appDvelumArticleCategoryApplication.dataGrid.setCanEdit(app.permissions.canEdit("Dvelum_Articles_Category"));
        appDvelumArticleCategoryApplication.dataGrid.setCanDelete(app.permissions.canDelete("Dvelum_Articles_Category"));
        appDvelumArticleCategoryApplication.dataGrid.setCanPublish(app.permissions.canPublish("Dvelum_Articles_Category"));
        appDvelumArticleCategoryApplication.dataGrid.getView().refresh();
      }
    }
  });
});