var me = this;
v.dragZone = Ext.create('Ext.dd.DragZone', v.getEl(), {
  getDragData: function(e) {
    var sourceEl = e.getTarget(v.itemSelector, 10), d;
    if (sourceEl) {
      d = sourceEl.cloneNode(true);
      d.id = Ext.id();
      return (v.dragData = {
        sourceEl: sourceEl,
        repairXY: Ext.fly(sourceEl).getXY(),
        ddel: d,
        record: v.getRecord(sourceEl),
        sourceCmp:me
      });
    }
  },
  getRepairXY: function() {
    return this.dragData.repairXY;
  }
});