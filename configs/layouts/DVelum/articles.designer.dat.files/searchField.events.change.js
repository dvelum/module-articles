
if(!me.searchBuffer){
	me.searchBuffer = Ext.Function.createBuffered(function(val){
    	this.setViewFilter('search', val);	
    },800, me);
}

me.searchBuffer(newValue);

