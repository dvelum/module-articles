var me = this;
v.dropZone = Ext.create('Ext.dd.DropZone', v.el, {
  // If the mouse is over a target node, return that node. This is
  // provided as the "target" parameter in all "onNodeXXXX" node event handling functions
  getTargetFromEvent: function(e) {
    return e.getTarget('.dv_article-target');
  },
  // On entry into a target node, highlight that node.
  onNodeEnter : function(target, dd, e, data){
    Ext.fly(target).addCls('dv_article-target-hover');
  },
  // On exit from a target node, unhighlight that node.
  onNodeOut : function(target, dd, e, data){
    Ext.fly(target).removeCls('dv_article-target-hover');
  },
  // While over a target node, return the default drop allowed class which
  // places a "tick" icon into the drag proxy.
  onNodeOver : function(target, dd, e, data){
    // here we can check if drop is allowed
    if(data.sourceCmp == me){
      return false;
    }
    return true;
  },
  //  On node drop, we can interrogate the target node to find the underlying
  //  application object that is the real target of the dragged data.
  //  In this case, it is a Record in the GridPanel's Store.
  //  We can use the data set up by the DragZone's getDragData method to read
  //  any data we decided to attach.
  onNodeDrop : function(target, dd, e, data){
    if(data.sourceCmp == me){
      return false;
    }
    var recData = Ext.apply(data.record.data, me.recordOptions);
    data.sourceCmp.getStore().remove(data.record);
    var rec = me.getStore().add(recData);
    me.saveRecord(rec[0] , data.sourceCmp);
    return true;
  }
});