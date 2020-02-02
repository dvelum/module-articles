this.getStore().remove(record);
Ext.apply(record.data, sourceCmp.recordOptions);
sourceCmp.getStore().add(record);