Ext.Ajax.request({
  url: '[%wroot%][%admp%][%-%]dvelum_articles[%-%]delete',
  method: "post",
  scope:this,
  params:{
    id: record.get("id")
  },
  success: function(response, request) {
    response =  Ext.JSON.decode(response.responseText);
    if(response.success){
      alert('afterDelete');
    }else{
      Ext.Msg.alert(appLang.MESSAGE , response.msg);
    }
  },
  failure:function(){
    Ext.Msg.alert(appLang.MESSAGE, appLang.MSG_LOST_CONNECTION);
  }
});