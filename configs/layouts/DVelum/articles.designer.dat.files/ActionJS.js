Ext.onReady(function(){
  // Init permissions
  app.application.on("projectLoaded",function(module){
    if(Ext.isEmpty(module) || module === "Dvelum_Articles"){
      if(!Ext.isEmpty(appDvelumArticlesApplication.mainPanel)){
        appDvelumArticlesApplication.mainPanel.setCanEdit(app.permissions.canEdit("Dvelum_Articles"));
        appDvelumArticlesApplication.mainPanel.setCanDelete(app.permissions.canDelete("Dvelum_Articles"));
        appDvelumArticlesApplication.mainPanel.setCanPublish(app.permissions.canPublish("Dvelum_Articles"));
      }
    }
  });
});