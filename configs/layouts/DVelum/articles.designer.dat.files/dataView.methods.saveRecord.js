var me = this;
Ext.Ajax.request({
  url: '[%wroot%][%admp%][%-%]dvelum_articles[%-%]drop',
  method: 'post',
  params:{
    id:record.get('id'),
    published:record.get('published')
  },
  scope:me,
  success: function(response, request) {
    response =  Ext.JSON.decode(response.responseText);
    if(response.success){
      record.set('published_version', response.data.published_version);
      me.refresh();
      return;
    }else{
      Ext.Msg.alert(appLang.MESSAGE, response.msg);
      me.revertRecord(record , sourceCmp);
    }
  },
  failure:function() {
    Ext.Msg.alert(appLang.MESSAGE, appLang.MSG_LOST_CONNECTION);
    me.revertRecord(record , sourceCmp);
  }
});